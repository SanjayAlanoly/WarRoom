<?php


class ContactMaster extends Eloquent
{
	protected $table = 'contact_master';
        public static $statuses = array(
            'open' => 'Open',
            'pledged' => 'Pledged',
            'not_interested' => 'Not Interested',
            'call_back' => 'Call back',
            'collected' => 'Collected',
            'retracted' => 'Retracted'
        );
        
        public static $donationRange = array(
            '0-500',
            '501-2000',
            '2001-above'
        );
        
        private $rules = array(
            'name'  => 'required',
            'donation_range' => 'required'
        );
        
        private static $contactsToDisplay = 5;
        
        public function validate($data)
        {
            $v = Validator::make($data, $this->rules);
            return $v->passes();
        }
        
        public static function getContacts()
        {
            $contacts = ContactMaster::where('volunteer_id','=',Auth::user()->id)
                    ->whereIn('status', array('open'))
                    ->orderBy('updated_at', 'ASC')
                    ->get();

            return $contacts;
         
         
        }
        

        public static function updateContact($input)
        {
            $contact = ContactMaster::find($input['id']);
            switch($input['type'])
            {
                case 'not_interested':
                    $contact->status = 'not_interested';
                    $contact->first_updated_at = date('Y-m-d H:i:s');
                    $contact->save();
                    break;
                
                case 'call_back':
                    $contact->status = 'call_back';
                    $contact->first_updated_at = date('Y-m-d H:i:s');
                    $contact->save();
                    
                    $cb = new Callback();
                    $cb->contact_id = $contact->id;
                    $cb->call_date = $input['call_date'];
                    $cb->comments = $input['comments'];
                    $cb->volunteer_id = Auth::user()->id;
                    $cb->save();
                    break;
                case 'pledged':
                    $contact->status = 'pledged';
                    $contact->first_updated_at = date('Y-m-d H:i:s');
                    $contact->save();
                    
                    $pl = new Pledged();
                    $pl->contact_id = $contact->id;

                    if($input['amount_pledged']<0){
                        $pl->amount_pledged = $input['amount_pledged'] * -1;
                    }else{
                        $pl->amount_pledged = $input['amount_pledged'];
                    }

                    $pl->volunteer_id = Auth::user()->id;
                    $pl->collect_date = $input['collect_date'];
                    $pl->comments = $input['comments'];
                    $pl->save();

                    break;
            }
            
            return $input['id'];
        }
        
        public static function getStatuses()
        {
            return static::$statuses;
        }
        
        public static function getDonationRange()
        {
            return static::$donationRange;
        }
        
        public function callback()
        {
            return $this->hasOne('callback', 'id', 'contact_id');
        }
        
        public function pledged()
        {
            return $this->hasOne('pledged', 'id', 'contact_id');
        }
}
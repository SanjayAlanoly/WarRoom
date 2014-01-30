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
            '501-1000',
            '1001-5000',
            '5001-20000',
            '20001-above'
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
                    ->where('displayed_at', '=', date("Y-m-d"))->take(5)->get();
            
            if (count($contacts)== static::$contactsToDisplay )
            {
                return $contacts;
            }
            
            elseif (count($contacts)==0)
            {
                $cArr = array();
                $contacts = ContactMaster::where('volunteer_id','=',Auth::user()->id)
                    ->whereIn('status', array('open','call_back'))
                    ->where('displayed','=', '0')
                    ->orderBy('updated_at', 'ASC')
                    ->take(static::$contactsToDisplay)
                    ->get();
                foreach($contacts as $c)
                {
                    $contact = ContactMaster::find($c->id);
                    $contact->displayed_at = date("Y-m-d");
                    $contact->displayed = '1';
                    $contact->save();
                    $cArr[] = $contact->id;
                }
                if(count($cArr) == static::$contactsToDisplay)
                {
                    return $contacts;
                }
                else
                {
                    $contacts = (static::rotateContacts($cArr) !== false)?static::rotateContacts($cArr):$contacts;
                    return $contacts;
                }
            }
            else
            {
                $cArr = array();
                foreach ($contacts as $c)
                {
                    $contact = ContactMaster::find($c->id);
                    $contact->displayed_at = date("Y-m-d");
                    $contact->displayed = '1';
                    $contact->save();
                    $cArr[] = $contact->id;
                }
                $contacts = (static::rotateContacts($cArr) !== false)?static::rotateContacts($cArr):$contacts;
                return $contacts;
            }
            
        }
        
        public static function rotateContacts($ids)
        {
            $toReturn = static::$contactsToDisplay - count($ids);
            if(count($ids) == 0)
            {
                return false;
                exit;
            }
            $c = ContactMaster::whereNotIn('id', $ids)->take($toReturn)->get();
            foreach($c as $cont)
            {
                $ids[] = $cont->id;
            }
            
            $contacts = ContactMaster::whereIn('id', $ids)->get();
            $markNotDisplayed = ContactMaster::whereNotIn('id', $ids)->where('volunteer_id','=',Auth::user()->id)->update(array('displayed'=> '0'));
            $markDisplayed = ContactMaster::whereIn('id', $ids)->where('volunteer_id','=',Auth::user()->id)->update(array('displayed'=>'1', 'displayed_at'=> date('Y-m-d')));
            return $contacts;
            
        }
        
        public static function updateContact($input)
        {
            $contact = ContactMaster::find($input['id']);
            switch($input['type'])
            {
                case 'not_interested':
                    $contact->status = 'not_interested';
                    $contact->save();
                    break;
                
                case 'call_back':
                    $contact->status = 'call_back';
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
                    $contact->save();
                    
                    $pl = new Pledged();
                    $pl->contact_id = $contact->id;
                    $pl->amount_pledged = $input['amount_pledged'];
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
<?php

class Pledged extends Eloquent
{
    protected $table = 'pledged';
    
    public function contactmaster()
    {
        return $this->belongsTo('contactmaster', 'contact_id','id');
    }
    
    public static function getPledged()
    {
        return static::where('volunteer_id','=',Auth::user()->id)->where('amount_collected','=',0)
                ->orderBy('collect_date','ASC')->get();
    }
    
    public static function updatePledge($input)
    {
        $pledge = Pledged::find($input['id']);
        
        switch($input['type'])
        {
            case 'collect':
                //0 in collected amount column is used to check whether the amount is collected or not
                if($input['amount_collected']==0){
                    break;
                }

                ContactMaster::where('id','=',$pledge->contact_id)->update(array('status'=>'collected'));

                if($input['amount_collected']<0){
                    $pledge->amount_collected = $input['amount_collected'] * -1;
                }else{
                    $pledge->amount_collected = $input['amount_collected'];
                }

                $pledge->save();
                break;
            case 'retracted':
                ContactMaster::where('id','=',$pledge->contact_id)->update(array('status'=>'retracted'));
                $pledge->delete();
                break;
        }
    }
    
    
}
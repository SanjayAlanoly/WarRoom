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
        return static::where('volunteer_id','=',Auth::user()->id)
                ->where('collect_date', '<=', date('Y-m-d'))->get();
    }
    
    public static function updatePledge($input)
    {
        $pledge = Pledged::find($input['id']);
        
        switch($input['type'])
        {
            case 'collect':
                ContactMaster::where('id','=',$pledge->contact_id)->update(array('status'=>'collected'));
                $pledge->amount_collected = $input['amount_collected'];
                $pledge->save();
                break;
            case 'retracted':
                ContactMaster::where('id','=',$pledge->contact_id)->update(array('status'=>'retracted'));
                $pledge->delete();
                break;
        }
    }
    
    
}
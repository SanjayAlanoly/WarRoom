<?php

class Callback extends Eloquent
{
    protected $table = 'call_back';
    
    public function contactmaster()
    {
        return $this->belongsTo('contactmaster', 'contact_id','id');
    }
    
    public static function getCallBack()
    {
        return static::where('volunteer_id','=',Auth::user()->id)
                ->orderBy('call_date','ASC')->get();
    }
    
    
    public static function updateCallback($input)
    {
        $callback = Callback::find($input['id']);
        
        switch($input['type'])
        {
            case 'not_interested':
                ContactMaster::where('id','=',$callback->contact_id)->update(array('status'=>'not_interested'));
                $callback->delete();
                break;
            
            case 'pledged':
                ContactMaster::where('id','=',$callback->contact_id)->update(array('status'=>'pledged'));
                $pl = new Pledged();
                $pl->contact_id = $callback->contact_id;
                $pl->amount_pledged = $input['amount_pledged'];
                $pl->collect_date = $input['collect_date'];
                $pl->comments = $input['comments'];
                $pl->volunteer_id = Auth::user()->id;
                if ($pl->save())
                {
                    $callback->delete();
                }
                break;
                
            case 'call_back':
                $callback->call_date = $input['call_date'];
                $callback->comments = $input['comments'];
                $callback->save();
            
        }
        return $callback;
    }
}

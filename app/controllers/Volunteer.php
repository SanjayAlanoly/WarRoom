<?php

class Volunteer extends BaseController {

    public static $volunteer_id;

    public function showVolunteer($id){

        return View::make('Volunteer',$this->calculateVolunteerStats($id));


    }


    function calculateVolunteerStats($id){

        $volunteer_cfrapp = DB::connection('cfrapp')->select("SELECT users.id as id, users.first_name AS first_name, users.last_name AS last_name, users.phone_no as phone_no,
                                users.email,COALESCE(SUM(donations.donation_amount),0) AS amount, COUNT(donations.donation_amount) AS count
                                FROM donations,users
                                WHERE users.id = ? AND donations.fundraiser_id = ?",array($id,$id));

        $volunteer_fraise_count = DB::connection('WarRoom')->select("SELECT COUNT(contact_master.id) AS conv_count
                                                                   FROM contact_master
                                                                   WHERE contact_master.status <> ? AND contact_master.volunteer_id = ?",
            array('open',$id));

        $volunteer_fraise_pledged = DB::connection('WarRoom')->select("SELECT COALESCE(SUM(pledged.amount_pledged),0) AS amount_pledged
                                                                   FROM pledged
                                                                   WHERE pledged.volunteer_id = ?",
            array($id));

        $volunteer_amount_raised = DB::connection('cfrapp')->select("SELECT id,donation_amount, DATE(created_at) as created_at FROM donations WHERE fundraiser_id = ?",array($id));

        $volunteer_conversations = DB::connection('WarRoom')->select("SELECT id, DATE(first_updated_at) as first_updated_at FROM contact_master WHERE volunteer_id = ?",array($id));


       $volunteer = (object)array_merge((array)$volunteer_cfrapp[0],(array)$volunteer_fraise_count[0],(array)$volunteer_fraise_pledged[0]);

        self::$volunteer_id = $volunteer->id;

        $data = compact("volunteer_amount_raised","volunteer_conversations","volunteer");

        return $data;



    }

    function submitCalendar(){

        DB::connection('WarRoom')->delete('DELETE FROM volunteer_sparta WHERE volunteer_id = ?
                                                AND MONTH(on_date) = ?',array($_POST['volunteer_id'],$_POST['month']));

        DB::connection('WarRoom')->delete('DELETE FROM volunteer_weekly_target WHERE volunteer_id = ?
                                                AND MONTH(on_date) = ?',array($_POST['volunteer_id'],$_POST['month']));

        DB::connection('WarRoom')->delete('DELETE FROM volunteer_overall_target WHERE volunteer_id = ?',array($_POST['volunteer_id']));

        if(!empty($_POST['sparta_day'])){
            foreach($_POST['sparta_day'] as $sparta_day){

                DB::connection('WarRoom')->insert('INSERT INTO volunteer_sparta (on_date,volunteer_id,type) VALUES (?,?,?)',array($sparta_day,$_POST['volunteer_id'],'sparta_day'));

            }
        }


        if(!empty($_POST['coached'])){
            foreach($_POST['coached'] as $coached){

                DB::connection('WarRoom')->insert('INSERT INTO volunteer_sparta (on_date,volunteer_id,type) VALUES (?,?,?)',array($coached,$_POST['volunteer_id'],'coached'));

            }
        }

        $weekly_target = $_POST['weekly_target'];

        if(!empty($weekly_target)){
            for($i = 0; $i < count($weekly_target); $i++){

                if($weekly_target[$i] != 0){

                    DB::connection('WarRoom')->insert('INSERT INTO volunteer_weekly_target (volunteer_id,target,on_date) VALUES (?,?,?)',array($_POST['volunteer_id'],$weekly_target[$i],$_POST['date'][$i]));
                }
            }
        }

        if(!empty($_POST['overall_target'])){
            DB::connection('WarRoom')->insert('INSERT INTO volunteer_overall_target (volunteer_id,target) VALUES (?,?)',array($_POST['volunteer_id'],$_POST['overall_target']));
        }

        $vol_id = $_POST['volunteer_id'];
        $url = "/Volunteer/$vol_id";

        return Redirect::to($url);

    }

    function submitPledged(){


        $cm = new ContactMaster();

        $cm->name = 'AutoAdded';
        $cm->phone = '0000000000';
        $cm->email = 'auto@auto.com';
        $cm->status = 'pledged';
        $cm->donation_range = '0-500';
        $cm->volunteer_id = $_POST['volunteer_id'];
        $cm->first_updated_at = date('Y-m-d H:i:s');
        $cm->save();


        $pl = new Pledged();
        $pl->contact_id = $cm->id;

        $pl->amount_pledged = $_POST['pledged_amount'];

        $pl->volunteer_id = $_POST['volunteer_id'];
        $pl->collect_date = date('Y-m-d H:i:s');
        $pl->comments = '';
        $pl->save();

        $vol_id = $_POST['volunteer_id'];
        $url = "/Volunteer/$vol_id";

        return Redirect::to($url);





    }
}

?>
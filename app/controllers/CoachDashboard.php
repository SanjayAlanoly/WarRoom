<?php

class CoachDashboard extends BaseController {

    public function showCoachDashboard(){

        return View::make('CoachDashboard')->with('volunteers_list',$this->calculateDashboard());

    }


    function calculateDashboard(){

        $volunteers_list = DB::connection('cfrapp')->select("SELECT users.id as id, users.first_name AS first_name, users.last_name AS last_name, users.phone_no as phone_no,
							SUM(donations.donation_amount) AS amount, COUNT(donations.donation_amount) AS count
							FROM donations
							RIGHT OUTER JOIN users
							ON donations.fundraiser_id = users.id
							WHERE users.city_id = ?
							GROUP BY users.id
							ORDER BY users.first_name",array(Auth::user()->city_id));


        $result_conversations = DB::connection('WarRoom')->select('SELECT cfrapp.users.id as id, COUNT(contact_master.id) AS count
                                                                    FROM contact_master
                                                                    INNER JOIN cfrapp.users
                                                                    ON contact_master.volunteer_id = cfrapp.users.id
                                                                    WHERE contact_master.status <> ? AND cfrapp.users.city_id = ?
                                                                    GROUP BY cfrapp.users.id',
                                                                    array('open',Auth::user()->city_id));

        $result_pledged = DB::connection('WarRoom')->select('SELECT cfrapp.users.id as id, SUM(pledged.amount_pledged) AS amount_pledged
                                                                    FROM pledged
                                                                    INNER JOIN cfrapp.users
                                                                    ON pledged.volunteer_id = cfrapp.users.id
                                                                    WHERE cfrapp.users.city_id = ?
                                                                    GROUP BY cfrapp.users.id',
                                                                    array(Auth::user()->city_id));

        foreach($volunteers_list as $volunteer){
            if($volunteer->amount == null){
                $volunteer->amount = 0;
            }
        }

        foreach($volunteers_list as $volunteer){
            foreach($result_conversations as $conversation){
                if($volunteer->id == $conversation->id){
                    $volunteer->conv_count = $conversation->count;
                }else{
                    $volunteer->conv_count = 0;
                }

            }
        }


        foreach($volunteers_list as $volunteer){
            foreach($result_pledged as $pledged){
                if($volunteer->id == $pledged->id){
                    $volunteer->amount_pledged = (int)$pledged->amount_pledged;
                }else{
                    $volunteer->amount_pledged = 0;
                }
            }
        }

        /*foreach($volunteers_list as $volunteer){

            $result_donations = DB::connection('cfrapp')->select('SELECT donation_amount,created_at FROM donations WHERE volunteer_id = ?',array($volunteer->id));

            for($d=30; $d>=0; $d--){

                $date_compare = new DateTime("now - $d days");
                $date_compare = $date_compare->format('Y-m-d');

                foreach($result_donations as $donations){


                }

            }
        }*/




        return $volunteers_list;
    }


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

        $data = compact("volunteer_amount_raised","volunteer_conversations","volunteer");

        return $data;



    }

}

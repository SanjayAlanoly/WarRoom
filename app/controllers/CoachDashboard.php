<?php

class CoachDashboard extends BaseController {



    public function showCoachDashboard(){

        return View::make('CoachDashboard',$this->calculateDashboard())->with('volunteers_list',$this->calculateFRaiserTable())->with('all_volunteers_list',$this->showAllVolunteers());

    }

    function calculateDashboard(){

        $yesterday = new DateTime("yesterday");
        $yesterday = $yesterday->format('Y-m-d');

        $today = new DateTime("today");
        $today = $today->format('l');

        //what if it is saturday
        if($today == 'saturday'){
            $next_saturday = new DateTime("today");

        }else{
            $next_saturday = new DateTime("next saturday");
        }

        $next_saturday = $next_saturday->format('Y-m-d');

        $yesterday_calls_target = DB::connection('WarRoom')->select('SELECT COUNT(volunteer_sparta.id) as count FROM volunteer_sparta
                                                                            INNER JOIN volunteer_coach
                                                                            ON volunteer_coach.volunteer_id = volunteer_sparta.volunteer_id
                                                                            WHERE volunteer_sparta.on_date = ? AND volunteer_sparta.type = ?
                                                                            AND volunteer_coach.coach_id = ?',array($yesterday,'sparta_day',Auth::user()->id));

        $yesterday_calls_actual = DB::connection('WarRoom')->select('SELECT COUNT(volunteer_sparta.id) as count FROM volunteer_sparta
                                                                            INNER JOIN volunteer_coach
                                                                            ON volunteer_coach.volunteer_id = volunteer_sparta.volunteer_id
                                                                            WHERE volunteer_sparta.on_date = ? AND volunteer_sparta.type = ?
                                                                            AND volunteer_coach.coach_id = ?',array($yesterday,'coached',Auth::user()->id));

        $yesterday_pledged_actual = DB::connection('WarRoom')->select('SELECT COALESCE(SUM(pledged.amount_pledged),0) as sum FROM pledged
                                                                        INNER JOIN volunteer_coach
                                                                        ON volunteer_coach.volunteer_id = pledged.volunteer_id
                                                                        WHERE DATE(pledged.created_at) = ? AND volunteer_coach.coach_id = ?'
                                                                        ,array($yesterday,Auth::user()->id));

        $yesterday_pledged_target = DB::connection('WarRoom')->select('SELECT COALESCE(SUM(volunteer_weekly_target.target),0) as sum FROM volunteer_weekly_target
                                                                        INNER JOIN volunteer_coach
                                                                        ON volunteer_weekly_target.volunteer_id = volunteer_coach.volunteer_id
                                                                        WHERE volunteer_weekly_target.on_date = ? AND volunteer_coach.coach_id = ?',
                                                                        array($next_saturday,Auth::user()->id));

        $group_raised_actual = DB::connection('cfrapp')->select('SELECT COALESCE(SUM(donations.donation_amount),0) AS sum
																	FROM donations
																	INNER JOIN makeadiff_warroom.volunteer_coach
																	ON makeadiff_warroom.volunteer_coach.volunteer_id = donations.fundraiser_id
																	WHERE makeadiff_warroom.volunteer_coach.coach_id = ?',array(Auth::user()->id));

        $group_pledged_actual = DB::connection('WarRoom')->select('SELECT COALESCE(SUM(pledged.amount_pledged),0) AS sum
                                                                      FROM pledged
                                                                      INNER JOIN volunteer_coach
                                                                      ON volunteer_coach.volunteer_id = pledged.volunteer_id
                                                                      WHERE volunteer_coach.coach_id = ?',array(Auth::user()->id));

        $group_conversations_actual = DB::connection('WarRoom')->select('SELECT COUNT(*) AS count
                                                                  FROM contact_master
                                                                  INNER JOIN volunteer_coach
                                                                  ON volunteer_coach.volunteer_id = contact_master.volunteer_id
                                                                  WHERE volunteer_coach.coach_id = ?',array(Auth::user()->id));

        $coach_raised_actual = DB::connection('cfrapp')->select('SELECT COALESCE(SUM(donations.donation_amount),0) AS sum
																	FROM donations
																	WHERE donations.fundraiser_id = ?',array(Auth::user()->id));

        $coach_pledged_actual = DB::connection('WarRoom')->select('SELECT COALESCE(SUM(pledged.amount_pledged),0) AS sum
                                                                      FROM pledged
                                                                      WHERE pledged.volunteer_id = ?',array(Auth::user()->id));

        $coach_conversations_actual = DB::connection('WarRoom')->select('SELECT COUNT(*) AS count
                                                                  FROM contact_master
                                                                  WHERE contact_master.volunteer_id = ?',array(Auth::user()->id));

        $overall_raised_actual = $group_raised_actual[0]->sum + $coach_raised_actual[0]->sum;

        $overall_pledged_actual = $group_pledged_actual[0]->sum + $coach_pledged_actual[0]->sum;

        $overall_conversations_actual = $group_conversations_actual[0]->count + $coach_conversations_actual[0]->count;



        $data = compact("overall_raised_actual","overall_pledged_actual","overall_conversations_actual");


        return $data;

    }



    function calculateFRaiserTable(){

        $volunteers_list = DB::connection('cfrapp')->select("SELECT users.id as id, users.first_name AS first_name, users.last_name AS last_name, users.phone_no as phone_no,
							COALESCE(SUM(donations.donation_amount),0) AS amount_raised, COUNT(donations.donation_amount) AS count
							FROM donations
							RIGHT OUTER JOIN users
							ON donations.fundraiser_id = users.id
							INNER JOIN makeadiff_warroom.volunteer_coach
							ON makeadiff_warroom.volunteer_coach.volunteer_id = users.id
							WHERE makeadiff_warroom.volunteer_coach.coach_id = ?
							GROUP BY users.id
							ORDER BY users.first_name",array(Auth::user()->id));


        $result_conversations = DB::connection('WarRoom')->select('SELECT cfrapp.users.id as id, COUNT(contact_master.id) AS count
                                                                    FROM contact_master
                                                                    RIGHT OUTER JOIN cfrapp.users
                                                                    ON contact_master.volunteer_id = cfrapp.users.id
                                                                    AND contact_master.status <> ?
                                                                    INNER JOIN volunteer_coach
							                                        ON volunteer_coach.volunteer_id = cfrapp.users.id
                                                                    AND volunteer_coach.coach_id = ?
                                                                    GROUP BY cfrapp.users.id',
                                                                    array('open',Auth::user()->id));

        $result_pledged = DB::connection('WarRoom')->select('SELECT cfrapp.users.id as id, COALESCE(SUM(pledged.amount_pledged),0) AS amount_pledged
                                                                    FROM pledged
                                                                    RIGHT OUTER JOIN cfrapp.users
                                                                    ON pledged.volunteer_id = cfrapp.users.id
                                                                    INNER JOIN volunteer_coach
							                                        ON volunteer_coach.volunteer_id = cfrapp.users.id
                                                                    WHERE volunteer_coach.coach_id = ?
                                                                    GROUP BY cfrapp.users.id',
                                                                    array(Auth::user()->id));

        $result_sparta_day_remaining = DB::connection('WarRoom')->select('SELECT cfrapp.users.id as id, COUNT(volunteer_sparta.id) as count FROM volunteer_sparta
                                                                            INNER JOIN cfrapp.users
                                                                            ON cfrapp.users.id = volunteer_sparta.volunteer_id
                                                                            WHERE volunteer_sparta.type = ? AND volunteer_sparta.on_date >= CURDATE()
                                                                            GROUP BY cfrapp.users.id',array('sparta_day'));

        $result_sparta_day_total = DB::connection('WarRoom')->select('SELECT cfrapp.users.id as id, COUNT(volunteer_sparta.id) as count FROM volunteer_sparta
                                                                            INNER JOIN cfrapp.users
                                                                            ON cfrapp.users.id = volunteer_sparta.volunteer_id
                                                                            WHERE volunteer_sparta.type = ?
                                                                            GROUP BY cfrapp.users.id',array('sparta_day'));

        $result_overall_target = DB::connection('WarRoom')->select('SELECT volunteer_id as id, target FROM
                                                                    volunteer_overall_target');

        //$result_sparta_days = DB::connection('WarRoom')->select






        foreach($volunteers_list as $volunteer){
            foreach($result_conversations as $conversation){
                if(($volunteer->id == $conversation->id) && isset($conversation->count)){
                    $volunteer->conv_count = $conversation->count;
                    break;
                }else{
                    $volunteer->conv_count = 0;
                }

            }
        }


        foreach($volunteers_list as $volunteer){
            foreach($result_pledged as $pledged){
                if(($volunteer->id == $pledged->id) && isset($pledged->amount_pledged)){
                    $volunteer->amount_pledged = (int)$pledged->amount_pledged;
                    break;
                }else{
                    $volunteer->amount_pledged = 0;
                }
            }
        }

        foreach($volunteers_list as $volunteer){
            foreach($result_sparta_day_remaining as $sparta_remaining){
                if(($volunteer->id == $sparta_remaining->id) && isset($sparta_remaining->count)){
                    $volunteer->sparta_remaining = (int)$sparta_remaining->count;
                    break;
                }else{
                    $volunteer->sparta_remaining = 0;
                }
            }
        }

        foreach($volunteers_list as $volunteer){
            foreach($result_sparta_day_total as $sparta_total){
                if(($volunteer->id == $sparta_total->id) && isset($sparta_total->count)){
                    $volunteer->sparta_total = (int)$sparta_total->count;
                    break;
                }else{
                    $volunteer->sparta_total = 0;
                }
            }
        }

        foreach($volunteers_list as $volunteer){
            foreach($result_overall_target as $overall_target){
                if(($volunteer->id == $overall_target->id) && isset($overall_target->target)){
                    $volunteer->overall_target = (int)$overall_target->target;
                    break;
                }else{
                    $volunteer->overall_target = 0;
                }
            }
        }

        foreach($volunteers_list as $volunteer){

            if($volunteer->sparta_remaining != 0){
                $volunteer->should_have_raised =  round((($volunteer->overall_target-$volunteer->amount_raised)/$volunteer->sparta_remaining) + $volunteer->amount_raised,0,PHP_ROUND_HALF_DOWN);
            }else{
                $volunteer->should_have_raised = 0;
            }

        }






        return $volunteers_list;
    }

    function showAllVolunteers(){

        $all_volunteers_list = DB::connection('cfrapp')->select("SELECT users.id as id, users.first_name as first_name, users.last_name as last_name, users.city_id , cities.name as city_name FROM users
                                                            INNER JOIN cities
                                                            ON users.city_id = cities.id
                                                            WHERE cities.name LIKE ?
                                                            ORDER BY users.first_name",array('Sparta%'));

        $selected_volunteers_list = DB::connection('WarRoom')->select('SELECT volunteer_id,coach_id FROM volunteer_coach WHERE
                                                                        coach_id = ?',array(Auth::user()->id));
        foreach($all_volunteers_list as $all_volunteer){
            foreach($selected_volunteers_list as $selected_volunteer){
                if($all_volunteer->id == $selected_volunteer->volunteer_id){
                    $all_volunteer->selected = true;
                }
            }
        }

        return $all_volunteers_list;


    }

    function saveVolunteers(){

        DB::connection('WarRoom')->delete('DELETE FROM volunteer_coach WHERE coach_id = ?
                                            ',array(Auth::user()->id));

        if(!empty($_POST['selected_volunteers'])){
            foreach($_POST['selected_volunteers'] as $selected_volunteer){

                DB::connection('WarRoom')->insert('INSERT INTO volunteer_coach (volunteer_id,coach_id) VALUES (?,?)',array($selected_volunteer,Auth::user()->id));

            }
        }

        return Redirect::to('/CoachDashboard');

    }




}

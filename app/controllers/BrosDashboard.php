<?php

class BrosDashboard extends BaseController{

    public function showBrosDashboard(){
        return View::make('BrosDashboard',$this->returnDashboard())->with('bro_teams',$this->returnBroTeams())->with('volunteers_list',$this->returnVolunteersList());
    }

    function returnBroTeams(){

        $bro_teams = DB::connection('WarRoom')->select('SELECT id,name FROM bro_team');


        return $bro_teams;
    }

    function returnDashboard(){

        $mad_amount_raised = DB::connection('cfrapp')->select('SELECT COALESCE(SUM(donations.donation_amount),0) AS amount_raised
																	FROM donations
																	INNER JOIN users
																	ON donations.fundraiser_id = users.id
																	INNER JOIN cities
																	ON cities.id = users.city_id AND cities.name LIKE ?',array('Sparta%'));

        $mad_conversations = DB::connection('WarRoom')->select('SELECT COUNT(*) AS count
																	FROM contact_master
																	INNER JOIN cfrapp.users
																	ON contact_master.volunteer_id = cfrapp.users.id
																	INNER JOIN cfrapp.cities
																	ON cfrapp.cities.id = cfrapp.users.city_id AND cities.name LIKE ?
																	WHERE status <> ?',
                                                                    array('Sparta%','open'));

        $mad_pledged = DB::connection('WarRoom')->select("SELECT COALESCE(SUM(pledged.amount_pledged),0) AS amount_pledged
                                                                FROM pledged
                                                                INNER JOIN cfrapp.users
                                                                ON pledged.volunteer_id = cfrapp.users.id
                                                                INNER JOIN cfrapp.cities
                                                                ON cfrapp.cities.id = cfrapp.users.city_id AND cities.name LIKE ?",array('Sparta%'));

        $data = compact("mad_amount_raised","mad_conversations","mad_pledged");

        return $data;


    }

    static function returnBroTeamMembers($bro_team_id){


        $members = DB::connection('WarRoom')->select("SELECT cfrapp.users.id as id,cfrapp.users.first_name as first_name,cfrapp.users.last_name as last_name,cfrapp.users.city_id,cfrapp.users.phone_no,cfrapp.cities.name as city_name FROM cfrapp.users
                                                        INNER JOIN cfrapp.cities
                                                        ON cfrapp.users.city_id = cfrapp.cities.id
                                                        INNER JOIN bro_team_coach
                                                        ON bro_team_coach.coach_id = cfrapp.users.id
                                                        WHERE bro_team_coach.bro_team_id = ?",array($bro_team_id));

       $group_raised = DB::connection('WarRoom')->select('SELECT bro_team_coach.coach_id as id, COALESCE(SUM(cfrapp.donations.donation_amount),0) AS sum
                                                            FROM cfrapp.donations
                                                            INNER JOIN volunteer_coach
                                                            ON volunteer_coach.volunteer_id = cfrapp.donations.fundraiser_id
                                                            INNER JOIN bro_team_coach
                                                            ON bro_team_coach.coach_id = volunteer_coach.coach_id
                                                            WHERE bro_team_coach.bro_team_id = ?
                                                            GROUP BY bro_team_coach.coach_id
							                                ',array($bro_team_id));

        $group_pledged = DB::connection('WarRoom')->select('SELECT bro_team_coach.coach_id as id, COALESCE(SUM(pledged.amount_pledged),0) AS sum
                                                            FROM pledged
                                                            INNER JOIN volunteer_coach
                                                            ON volunteer_coach.volunteer_id = pledged.volunteer_id
                                                            INNER JOIN bro_team_coach
                                                            ON bro_team_coach.coach_id = volunteer_coach.coach_id
                                                            WHERE bro_team_coach.bro_team_id = ?
                                                            GROUP BY bro_team_coach.coach_id',array($bro_team_id));



        $coach_raised = DB::connection('WarRoom')->select('SELECT bro_team_coach.coach_id as id, COALESCE(SUM(cfrapp.donations.donation_amount),0) AS sum
                                                            FROM cfrapp.donations
                                                            INNER JOIN bro_team_coach
                                                            ON bro_team_coach.coach_id = cfrapp.donations.fundraiser_id
                                                            WHERE bro_team_coach.bro_team_id = ?
                                                            GROUP BY bro_team_coach.coach_id',array($bro_team_id));

        $coach_pledged = DB::connection('WarRoom')->select('SELECT bro_team_coach.coach_id as id, COALESCE(SUM(pledged.amount_pledged),0) AS sum
                                                            FROM pledged
                                                            INNER JOIN bro_team_coach
                                                            ON bro_team_coach.coach_id = pledged.volunteer_id
                                                            WHERE bro_team_coach.bro_team_id = ?
                                                            GROUP BY bro_team_coach.coach_id',array($bro_team_id));

        $coach_target = DB::connection('WarRoom')->select('SELECT bro_team_coach.coach_id as id, COALESCE(SUM(volunteer_overall_target.target),0) as target FROM
                                                                    volunteer_overall_target
                                                                    INNER JOIN volunteer_coach
                                                                    ON volunteer_coach.volunteer_id = volunteer_overall_target.volunteer_id
                                                                    INNER JOIN bro_team_coach
                                                                    ON bro_team_coach.coach_id = volunteer_coach.coach_id
                                                                    WHERE bro_team_coach.bro_team_id = ?
                                                                    GROUP BY bro_team_coach.coach_id',array($bro_team_id));

        $coach_target_count = DB::connection('WarRoom')->select('SELECT bro_team_coach.coach_id as id, COUNT(volunteer_overall_target.target) as count FROM
                                                                    volunteer_overall_target
                                                                    INNER JOIN volunteer_coach
                                                                    ON volunteer_coach.volunteer_id = volunteer_overall_target.volunteer_id
                                                                    INNER JOIN bro_team_coach
                                                                    ON bro_team_coach.coach_id = volunteer_coach.coach_id
                                                                    WHERE bro_team_coach.bro_team_id = ?
                                                                    GROUP BY bro_team_coach.coach_id',array($bro_team_id));



        $number_of_interns = DB::connection('WarRoom')->select('SELECT volunteer_coach.coach_id as id, COUNT(volunteer_coach.volunteer_id) as count FROM volunteer_coach
                                                                GROUP BY volunteer_coach.coach_id');

        $coach_login = DB::connection('WarRoom')->select('SELECT volunteer_login.volunteer_id as id,MAX(volunteer_login.login_time) as last_login FROM volunteer_login
                                                                        INNER JOIN bro_team_coach
                                                                        ON bro_team_coach.coach_id = volunteer_login.volunteer_id
                                                                        WHERE bro_team_coach.bro_team_id = ?
                                                                        GROUP BY bro_team_coach.coach_id',array($bro_team_id));

        foreach($members as $member){
            foreach($group_raised as $raised){
                if(($member->id == $raised->id) && isset($raised->sum)){
                    $member->group_raised = $raised->sum;
                    break;
                }else{
                    $member->group_raised = 0;
                }
            }
        }

        foreach($members as $member){
            foreach($number_of_interns as $interns){
                if(($member->id == $interns->id) && isset($interns->count)){
                    $member->interns = $interns->count;
                    break;
                }else{
                    $member->interns = 0;
                }
            }
        }


        foreach($members as $member){
            if(!empty($group_raised)){
                foreach($group_raised as $each_group_raised){
                    if(($member->id == $each_group_raised->id) && isset($each_group_raised->sum)){
                        $member->group_raised = $each_group_raised->sum;
                        break;
                    }else{
                        $member->group_raised = 0;
                    }
                }
            }else{
                $member->group_raised = 0;
            }

        }

        foreach($members as $member){
            if(!empty($coach_raised)){
                foreach($coach_raised as $each_coach_raised){
                    if(($member->id == $each_coach_raised->id) && isset($each_coach_raised->sum)){
                        $member->coach_raised = $each_coach_raised->sum;
                        break;
                    }else{
                        $member->coach_raised = 0;
                    }
                }
            }else{
                $member->coach_raised = 0;
            }

        }

        foreach($members as $member){
            if(!empty($group_pledged)){
                foreach($group_pledged as $each_group_pledged){
                    if(($member->id == $each_group_pledged->id) && isset($each_group_pledged->sum)){
                        $member->group_pledged = $each_group_pledged->sum;
                        break;
                    }else{
                        $member->group_pledged = 0;
                    }
                }
            }else{
                $member->group_pledged = 0;
            }

        }

        foreach($members as $member){
            if(!empty($coach_pledged)){
                foreach($coach_pledged as $each_coach_pledged){
                    if(($member->id == $each_coach_pledged->id) && isset($each_coach_pledged->sum)){
                        $member->coach_pledged = $each_coach_pledged->sum;
                        break;
                    }else{
                        $member->coach_pledged = 0;
                    }
                }
            }else{
                $member->coach_pledged = 0;
            }

        }


        foreach($members as $member){
            if(!empty($coach_target)){
                foreach($coach_target as $each_coach_target){
                    if(($member->id == $each_coach_target->id) && isset($each_coach_target->target)){
                        $member->coach_target = $each_coach_target->target;
                        break;
                    }else{
                        $member->coach_target = 0;
                    }
                }
            }else{
                $member->coach_target = 0;
            }

        }

        foreach($members as $member){
            if(!empty($coach_target_count)){
                foreach($coach_target_count as $each_coach_target_count){
                    if(($member->id == $each_coach_target_count->id) && isset($each_coach_target_count->count)){
                        $member->target_count = $each_coach_target_count->count;
                        break;
                    }else{
                        $member->target_count = 0;
                    }
                }
            }else{
                $member->target_count = 0;
            }

        }

        foreach($members as $member){
            if(!empty($coach_login)){
                foreach($coach_login as $login){
                    if(($member->id == $login->id) && isset($login->last_login)){

                        $last_login = new DateTime("$login->last_login");
                        $last_login = $last_login->format('j M g:i A');
                        $member->last_login = $last_login;

                        break;
                    }else{
                        $member->last_login = '-';
                    }
                }
            }else{
                $member->last_login = '-';
            }

        }

        return $members;
    }

    function returnVolunteersList(){

        $volunteers_list = DB::connection('cfrapp')->select("SELECT users.id as id, users.first_name as first_name, users.last_name as last_name, users.city_id , users.phone_no, cities.name as city_name FROM users
                                                            INNER JOIN cities
                                                            ON users.city_id = cities.id
                                                            WHERE cities.name LIKE ? OR cities.name LIKE ?
                                                            ORDER BY users.first_name",array('Sparta%','National%'));

        return $volunteers_list;

    }

    function saveBroTeams(){

        DB::connection('WarRoom')->delete('DELETE FROM bro_team_coach WHERE bro_team_id = ?',array($_POST['bro_team']));

        if(!empty($_POST['bro_team']) && !empty($_POST['volunteers'])){
            foreach($_POST['volunteers'] as $volunteer){

                DB::connection('WarRoom')->insert('INSERT INTO bro_team_coach (bro_team_id,coach_id) VALUES (?,?)',array($_POST['bro_team'],$volunteer));

            }
        }

        return Redirect::to('/BrosDashboard');
    }

    static function returnTeamOverall($bro_team_id){
        $group_raised = DB::connection('WarRoom')->select('SELECT COALESCE(SUM(cfrapp.donations.donation_amount),0) as sum FROM cfrapp.donations
                                            INNER JOIN volunteer_coach
                                            ON volunteer_coach.volunteer_id = cfrapp.donations.fundraiser_id
                                            INNER JOIN bro_team_coach
                                            ON bro_team_coach.coach_id = volunteer_coach.coach_id
                                            WHERE bro_team_coach.bro_team_id = ?',array($bro_team_id));



        $coach_raised = DB::connection('WarRoom')->select('SELECT COALESCE(SUM(cfrapp.donations.donation_amount),0) as sum FROM cfrapp.donations
                                            INNER JOIN bro_team_coach
                                            ON bro_team_coach.coach_id = cfrapp.donations.fundraiser_id
                                            WHERE bro_team_coach.bro_team_id = ?',array($bro_team_id));

        $group_pledged = DB::connection('WarRoom')->select('SELECT COALESCE(SUM(pledged.amount_pledged),0) AS sum
                                                            FROM pledged
                                                            INNER JOIN volunteer_coach
                                                            ON volunteer_coach.volunteer_id = pledged.volunteer_id
                                                            INNER JOIN bro_team_coach
                                                            ON bro_team_coach.coach_id = volunteer_coach.coach_id
                                                            WHERE bro_team_coach.bro_team_id = ?
                                                            ',array($bro_team_id));

        $coach_pledged = DB::connection('WarRoom')->select('SELECT COALESCE(SUM(pledged.amount_pledged),0) AS sum
                                                            FROM pledged
                                                            INNER JOIN bro_team_coach
                                                            ON bro_team_coach.coach_id = pledged.volunteer_id
                                                            WHERE bro_team_coach.bro_team_id = ?
                                                            ',array($bro_team_id));

        $overall_target = DB::connection('WarRoom')->select('SELECT COALESCE(SUM(volunteer_overall_target.target),0) as target FROM
                                                                    volunteer_overall_target
                                                                    INNER JOIN volunteer_coach
                                                                    ON volunteer_coach.volunteer_id = volunteer_overall_target.volunteer_id
                                                                    INNER JOIN bro_team_coach
                                                                    ON bro_team_coach.coach_id = volunteer_coach.coach_id
                                                                    WHERE bro_team_coach.bro_team_id = ?
                                                                    ',array($bro_team_id));

        $no_of_interns = DB::connection('WarRoom')->select('SELECT COUNT(volunteer_coach.volunteer_id) AS count FROM volunteer_coach
                                                            INNER JOIN bro_team_coach
                                                            ON bro_team_coach.coach_id = volunteer_coach.coach_id
                                                            WHERE bro_team_coach.bro_team_id = ?',array($bro_team_id));

        $yesterday = new DateTime('yesterday');
        $yesterday = $yesterday->format('Y-m-d');

        $sparta_days_yesterday = DB::connection('WarRoom')->select('SELECT COUNT(volunteer_sparta.id) AS count FROM volunteer_sparta
                                                                INNER JOIN volunteer_coach
                                                                ON volunteer_coach.volunteer_id = volunteer_sparta.volunteer_id
                                                                INNER JOIN bro_team_coach
                                                                ON bro_team_coach.coach_id = volunteer_coach.coach_id
                                                                WHERE bro_team_coach.bro_team_id = ?
                                                                AND volunteer_sparta.on_date = ? AND volunteer_sparta.type = ?',
                                                                array($bro_team_id,$yesterday,'sparta_day'));

        $coached_days_yesterday = DB::connection('WarRoom')->select('SELECT COUNT(volunteer_sparta.id) AS count FROM volunteer_sparta
                                                                INNER JOIN volunteer_coach
                                                                ON volunteer_coach.volunteer_id = volunteer_sparta.volunteer_id
                                                                INNER JOIN bro_team_coach
                                                                ON bro_team_coach.coach_id = volunteer_coach.coach_id
                                                                WHERE bro_team_coach.bro_team_id = ?
                                                                AND volunteer_sparta.on_date = ? AND volunteer_sparta.type = ?',
                                                                array($bro_team_id,$yesterday,'coached'));

        $group_raised_yesterday = DB::connection('WarRoom')->select('SELECT COALESCE(SUM(cfrapp.donations.donation_amount),0) as sum FROM cfrapp.donations
                                            INNER JOIN volunteer_coach
                                            ON volunteer_coach.volunteer_id = cfrapp.donations.fundraiser_id
                                            INNER JOIN bro_team_coach
                                            ON bro_team_coach.coach_id = volunteer_coach.coach_id
                                            WHERE bro_team_coach.bro_team_id = ?
                                            AND DATE(cfrapp.donations.created_at) = ?',array($bro_team_id,$yesterday));

        $coach_raised_yesterday = DB::connection('WarRoom')->select('SELECT COALESCE(SUM(cfrapp.donations.donation_amount),0) as sum FROM cfrapp.donations
                                            INNER JOIN bro_team_coach
                                            ON bro_team_coach.coach_id = cfrapp.donations.fundraiser_id
                                            WHERE bro_team_coach.bro_team_id = ?
                                            AND DATE(cfrapp.donations.created_at) = ?',array($bro_team_id,$yesterday));

        $group_pledged_yesterday = DB::connection('WarRoom')->select('SELECT COALESCE(SUM(pledged.amount_pledged),0) AS sum
                                                            FROM pledged
                                                            INNER JOIN volunteer_coach
                                                            ON volunteer_coach.volunteer_id = pledged.volunteer_id
                                                            INNER JOIN bro_team_coach
                                                            ON bro_team_coach.coach_id = volunteer_coach.coach_id
                                                            WHERE bro_team_coach.bro_team_id = ?
                                                            AND DATE(pledged.created_at) = ?',array($bro_team_id,$yesterday));

        $coach_pledged_yesterday = DB::connection('WarRoom')->select('SELECT COALESCE(SUM(pledged.amount_pledged),0) AS sum
                                                            FROM pledged
                                                            INNER JOIN bro_team_coach
                                                            ON bro_team_coach.coach_id = pledged.volunteer_id
                                                            WHERE bro_team_coach.bro_team_id = ?
                                                            AND DATE(pledged.created_at) = ?',array($bro_team_id,$yesterday));




        $raised = $group_raised[0]->sum + $coach_raised[0]->sum;
        $pledged = $group_pledged[0]->sum + $coach_pledged[0]->sum;
        $target = $overall_target[0]->target;
        $interns = $no_of_interns[0]->count;
        $sparta_yesterday = $sparta_days_yesterday[0]->count;
        $coached_yesterday = $coached_days_yesterday[0]->count;
        $raised_yesterday = $group_raised_yesterday[0]->sum + $coach_raised_yesterday[0]->sum;
        $pledged_yesterday = $group_pledged_yesterday[0]->sum + $coach_pledged_yesterday[0]->sum;

        $data = compact("raised","pledged","target","interns","coached_yesterday","sparta_yesterday","raised_yesterday","pledged_yesterday");
        return $data;
    }

    static function returnCoaches(){

    }
}
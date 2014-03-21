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

        $number_of_interns = DB::connection('WarRoom')->select('SELECT volunteer_coach.coach_id as id, COUNT(volunteer_coach.volunteer_id) as count FROM volunteer_coach
                                                                GROUP BY volunteer_coach.coach_id');

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
        $coach_group = DB::connection('WarRoom')->select('SELECT COALESCE(SUM(cfrapp.donations.donation_amount),0) as sum FROM cfrapp.donations
                                            INNER JOIN volunteer_coach
                                            ON volunteer_coach.volunteer_id = cfrapp.donations.fundraiser_id
                                            INNER JOIN bro_team_coach
                                            ON bro_team_coach.coach_id = volunteer_coach.coach_id
                                            WHERE bro_team_coach.bro_team_id = ?',array($bro_team_id));

        $coach_own = DB::connection('WarRoom')->select('SELECT COALESCE(SUM(cfrapp.donations.donation_amount),0) as sum FROM cfrapp.donations
                                            INNER JOIN bro_team_coach
                                            ON bro_team_coach.coach_id = cfrapp.donations.fundraiser_id
                                            WHERE bro_team_coach.bro_team_id = ?',array($bro_team_id));


        $sum = $coach_group[0]->sum + $coach_own[0]->sum;
        return $sum;
    }

    static function returnCoaches(){

    }
}
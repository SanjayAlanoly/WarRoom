<?php

class BrosDashboard extends BaseController{

    public function showBrosDashboard(){
        return View::make('BrosDashboard')->with('bro_teams',$this->returnBroTeams())->with('volunteers_list',$this->returnVolunteersList());
    }

    function returnBroTeams(){

        $bro_teams = DB::connection('WarRoom')->select('SELECT id,name FROM bro_team');


        return $bro_teams;
    }

    static function returnBroTeamMembers($bro_team_id){
        $members = DB::connection('WarRoom')->select("SELECT cfrapp.users.id as id,cfrapp.users.first_name as first_name,cfrapp.users.last_name as last_name,cfrapp.users.city_id,cfrapp.users.phone_no,cfrapp.cities.name as city_name FROM cfrapp.users
                                                        INNER JOIN cfrapp.cities
                                                        ON cfrapp.users.city_id = cfrapp.cities.id
                                                        INNER JOIN bro_team_coach
                                                        ON bro_team_coach.coach_id = cfrapp.users.id
                                                        WHERE bro_team_coach.bro_team_id = ?",array($bro_team_id));

        $group_raised = DB::connection('cfrapp')->select('SELECT donations.fundraiser_id as id, COALESCE(SUM(donations.donation_amount),0) AS sum
                                                            FROM donations
                                                            INNER JOIN makeadiff_warroom.volunteer_coach
                                                            ON makeadiff_warroom.volunteer_coach.volunteer_id = donations.fundraiser_id
                                                            INNER JOIN makeadiff_warroom.bro_team_coach
                                                            ON makeadiff_warroom.bro_team_coach.coach_id = makeadiff_warroom.volunteer_coach.coach_id
                                                            GROUP BY users.id
							                                ORDER BY users.first_name
                                                            WHERE makeadiff_warroom.bro_team_coach.bro_team_id = ?',array($bro_team_id));

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
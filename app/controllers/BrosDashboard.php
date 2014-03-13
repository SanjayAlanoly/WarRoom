<?php

class BrosDashboard extends BaseController{

    public function showBrosDashboard(){
        return View::make('BrosDashboard')->with('bro_teams',$this->returnBroTeams())->with('volunteers_list',$this->returnVolunteersList());
    }

    function returnBroTeams(){

        $bro_teams = DB::connection('WarRoom')->select('SELECT id,name FROM bro_team');


        return $bro_teams;
    }

    function returnVolunteersList(){

        $volunteers_list = DB::connection('cfrapp')->select("SELECT users.id as id, users.first_name as first_name, users.last_name as last_name, users.city_id , cities.name as city_name FROM users
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
        $data = DB::connection('WarRoom')->select('SELECT COALESCE(SUM(cfrapp.donations.donation_amount),0) as sum FROM cfrapp.donations
                                            INNER JOIN bro_team_coach
                                            ON bro_team_coach.coach_id = cfrapp.donations.fundraiser_id
                                            WHERE bro_team_coach.bro_team_id = ?',array($bro_team_id));
        return $data[0]->sum;
    }
}
<?php

class Home extends BaseController {

	public function showHome(){

		$dashboard = $this->calculateDashboard();

		$run_rate = $this->calculateRunRate();

		$leaderboard = $this->calculateLeaderboard();

		$data = compact("dashboard","run_rate","leaderboard");

		return View::make('Home',$data)->with('donationRanges', ContactMaster::getDonationRange());
	}


	public function calculateLeaderboard(){




		$fundraisers_national = DB::connection('cfrapp')->select("SELECT users.id as id, users.first_name AS first_name, users.last_name AS last_name,
							SUM(donations.donation_amount) AS amount,
							cities.name as city_name
							FROM donations 
							INNER JOIN users
							ON donations.fundraiser_id = users.id
							INNER JOIN cities
							ON cities.id = users.city_id AND cities.name LIKE ?
							GROUP BY users.id
							ORDER BY SUM(donations.donation_amount) DESC",array('Sparta%'));
		$count = 0;
		$user_count_national = 0;
		$flag = false;

		foreach($fundraisers_national as $fn){

			if($fn->id == Auth::user()->id){
				$user_count_national = $count;
				$flag = true;
				break;
			}
				

			$count++;
		}

		if($flag == false){
			$user_count_national = -1;
		}



		$fundraisers_city = DB::connection('cfrapp')->select("SELECT users.id as id, users.first_name AS first_name, users.last_name AS last_name,
							SUM(donations.donation_amount) AS amount,
							cities.name as city_name
							FROM donations 
							INNER JOIN users
							ON donations.fundraiser_id = users.id
							INNER JOIN cities
							ON cities.id = users.city_id AND cities.id = ? AND cities.name LIKE ?
							GROUP BY users.id
							ORDER BY SUM(donations.donation_amount) DESC",array(Auth::user()->city_id,'Sparta%'));
		$count = 0;
		$user_count_city = 0;
		$flag = false;

		foreach($fundraisers_city as $fn){

			if($fn->id == Auth::user()->id){
				$user_count_city = $count;
				$flag=true;
				break;
			}
				

			$count++;
		}

		if($flag == false){
			$user_count_city = -1;
		}


		$leaderboard = compact("fundraisers_national","user_count_national","fundraisers_city","user_count_city");

		return $leaderboard;


	}

	public function calculateRunRate(){

		$result_city_target = DB::connection('WarRoom')->select("SELECT * FROM city_target");

		$data = array();

		foreach($result_city_target as $city){

			$result_city = DB::connection("cfrapp")->select('SELECT SUM(donations.donation_amount) AS sum, cities.name as name
											FROM donations
											INNER JOIN users
											ON donations.fundraiser_id = users.id
											INNER JOIN cities
											ON cities.id = users.city_id
											WHERE cities.id = ?',array($city->city_id));



            if(!isset($result_city[0]->sum)){
                $result_city = DB::connection("cfrapp")->select('SELECT name FROM cities WHERE id = ?',array($city->city_id));
                $city_amount_raised = 0;
                $city_name = $result_city[0]->name;
            }else{
                $city_amount_raised = $result_city[0]->sum;
                $city_name = $result_city[0]->name;
            }



			$start_date = new DateTime("$city->start_date");
			$end_date = new DateTime("$city->end_date");

			$interval = $start_date->diff($end_date,true);

			$interval = $interval->format('%a');

			$per_day = $city->target / $interval;

			$ideal_amount = $per_day * ( $start_date->diff(new DateTime("now"),true)->format("%a") );

			$ideal_amount = round($ideal_amount,0,PHP_ROUND_HALF_DOWN);

			$diff_in_amount = $city_amount_raised - $ideal_amount;

			$percentage = ($diff_in_amount/$ideal_amount) * 100;

			$percentage = round($percentage,0,PHP_ROUND_HALF_DOWN);

			$city_data = compact("percentage", "diff_in_amount","city_amount_raised","ideal_amount","city_name");

			array_push($data,$city_data);


		}

		arsort($data);

		return $data;

	}

	public function calculateDashboard(){


		//Calculate total amount raised by the user

		$result_you_amount_raised = DB::connection('cfrapp')->select('SELECT SUM(donation_amount) AS sum
																	FROM donations WHERE fundraiser_id=?',
																	array(Auth::user()->id));

		if(isset($result_you_amount_raised[0])){

			$you_amount_raised = $result_you_amount_raised[0]->sum;
		}else{

			$you_amount_raised = 0;
		}

		//Calculate total conversations by the user

		$result_you_conversations = DB::connection('WarRoom')->select('SELECT COUNT(*) AS count
																	FROM contact_master WHERE status <> ? AND volunteer_id=?',
																	array('open',Auth::user()->id));

		if(isset($result_you_conversations[0])){

			$you_conversations = $result_you_conversations[0]->count;
		}else{

			$you_conversations = 0;
		}


        //Calculate total pledged by the user

        $result_you_pledged = DB::connection('WarRoom')->select("SELECT COALESCE(SUM(pledged.amount_pledged),0) AS amount_pledged
                                                               FROM pledged
                                                               WHERE pledged.volunteer_id = ?",array(Auth::user()->id));


        if(isset($result_you_pledged[0])){

            $you_pledged = $result_you_pledged[0]->amount_pledged;
        }else{

            $you_pledged = 0;
        }


		//Calculate the number of Sparta days by the user


		$result_you_sparta_days = DB::connection('WarRoom')->select('SELECT DATE(first_updated_at) as first_updated_at FROM contact_master WHERE status <> ? AND volunteer_id = ?',array('open',Auth::user()->id));

		$sparta_days_completed = 0;

		for($day = 0; $day <=100; $day++){

			$same_day = 0;
			$check_date = new DateTime("today -$day day");


			foreach($result_you_sparta_days as $row){

				
				if((string)$row->first_updated_at == $check_date->format('Y-m-d')){

						$same_day++;

				}

			}

			$sparta_days_completed += (int)($same_day/5);


		}


		

		//Calculate total amount raised by users's city

		$result_city_amount_raised = DB::connection('cfrapp')->select('SELECT SUM(donations.donation_amount) AS sum
																	FROM donations
																	INNER JOIN users
																	ON donations.fundraiser_id = users.id
																	INNER JOIN cities
																	ON cities.id = users.city_id
																	WHERE cities.id = ?',array(Auth::user()->city_id));

		if(isset($result_city_amount_raised[0])){

			$city_amount_raised = $result_city_amount_raised[0]->sum;
		}else{

			$city_amount_raised = 0;
		}


        //Calculate total pledged by the user's city

        $result_city_pledged = DB::connection('WarRoom')->select("SELECT COALESCE(SUM(pledged.amount_pledged),0) AS amount_pledged
                                                               FROM pledged
                                                               INNER JOIN cfrapp.users
                                                               ON pledged.volunteer_id = cfrapp.users.id
                                                               WHERE cfrapp.users.city_id = ?",array(Auth::user()->city_id));


        if(isset($result_city_pledged[0])){

            $city_pledged = $result_city_pledged[0]->amount_pledged;
        }else{

            $city_pledged = 0;
        }


		//Calculate total conversations by the user's city

		$result_city_conversations = DB::connection('WarRoom')->select('SELECT COUNT(*) AS count
																	FROM contact_master
																	INNER JOIN cfrapp.users
																	ON contact_master.volunteer_id = cfrapp.users.id
																	WHERE contact_master.status <> ? AND cfrapp.users.city_id=?',
																	array('open',Auth::user()->city_id));

		if(isset($result_city_conversations[0])){

			$city_conversations = $result_city_conversations[0]->count;
		}else{

			$city_conversations = 0;
		}


		//Calculate the total amount raised by MAD

		$result_mad_amount_raised = DB::connection('cfrapp')->select('SELECT SUM(donations.donation_amount) AS sum
																	FROM donations
																	INNER JOIN users
																	ON donations.fundraiser_id = users.id
																	INNER JOIN cities
																	ON cities.id = users.city_id AND cities.name LIKE ?',array('Sparta%'));

		if(isset($result_mad_amount_raised[0])){

			$mad_amount_raised = $result_mad_amount_raised[0]->sum;
		}else{

			$mad_amount_raised = 0;
		}


		//Calculate total conversations by MAD

		$result_mad_conversations = DB::connection('WarRoom')->select('SELECT COUNT(*) AS count
																	FROM contact_master
																	INNER JOIN cfrapp.users
																	ON contact_master.volunteer_id = cfrapp.users.id
																	INNER JOIN cfrapp.cities
																	ON cfrapp.cities.id = cfrapp.users.city_id AND cities.name LIKE ?
																	WHERE status <> ?',
																	array('Sparta%','open'));

		if(isset($result_mad_conversations[0])){

			$mad_conversations = $result_mad_conversations[0]->count;
		}else{

			$mad_conversations = 0;
		}

        //Calculate total pledged by the MAD

        $result_mad_pledged = DB::connection('WarRoom')->select("SELECT COALESCE(SUM(pledged.amount_pledged),0) AS amount_pledged
                                                                FROM pledged
                                                                INNER JOIN cfrapp.users
                                                                ON pledged.volunteer_id = cfrapp.users.id
                                                                INNER JOIN cfrapp.cities
                                                                ON cfrapp.cities.id = cfrapp.users.city_id AND cities.name LIKE ?",array('Sparta%'));


        if(isset($result_mad_pledged[0])){

            $mad_pledged = $result_mad_pledged[0]->amount_pledged;
        }else{

            $mad_pledged = 0;
        }



		$data = compact("you_amount_raised","city_amount_raised","mad_amount_raised","you_conversations","city_conversations","mad_conversations","sparta_days_completed","you_pledged","city_pledged","mad_pledged");

		return $data;

	}


}


?>
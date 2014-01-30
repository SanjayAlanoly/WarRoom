<?php

class Home extends BaseController {

	public function showHome(){

		$dashboard = $this->calculateDashboard();

		$run_rate = $this->calculateRunRate();

		$leaderboard = $this->calculateLeaderboard();

		$data = compact("dashboard","run_rate","leaderboard");

		return View::make('Home',$data);
	}


	public function calculateLeaderboard(){


		$fundraisers_national = DB::connection('cfrapp')->select("SELECT users.id as id, users.first_name AS first_name, users.last_name AS last_name,
							SUM(donations.donation_amount) AS amount,
							cities.name as city_name
							FROM donations 
							INNER JOIN users
							ON donations.fundraiser_id = users.id
							INNER JOIN cities
							ON cities.id = users.city_id AND cities.name <> ? AND cities.name NOT LIKE ?
							GROUP BY users.id
							ORDER BY SUM(donations.donation_amount) DESC",array('Beyond Bangalore','FOM%'));
		$count = 0;
		$user_count_national = 0;

		foreach($fundraisers_national as $fn){

			if($fn->id == Auth::user()->id){
				$user_count_national = $count;
				break;
			}
				

			$count++;
		}



		$fundraisers_city = DB::connection('cfrapp')->select("SELECT users.id as id, users.first_name AS first_name, users.last_name AS last_name,
							SUM(donations.donation_amount) AS amount,
							cities.name as city_name
							FROM donations 
							INNER JOIN users
							ON donations.fundraiser_id = users.id
							INNER JOIN cities
							ON cities.id = users.city_id AND cities.id = ? AND cities.name <> ? AND cities.name NOT LIKE ?
							GROUP BY users.id
							ORDER BY SUM(donations.donation_amount) DESC",array(Auth::user()->city_id,'Beyond Bangalore','FOM%'));
		$count = 0;
		$user_count_city = 0;

		foreach($fundraisers_city as $fn){

			if($fn->id == Auth::user()->id){
				$user_count_city = $count;
				break;
			}
				

			$count++;
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


			$city_amount_raised = $result_city[0]->sum;
			$city_name = $result_city[0]->name;

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

			$city_data = compact("city_name", "diff_in_amount","city_amount_raised","ideal_amount","percentage");

			array_push($data,$city_data);


		}

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


		//Calculate total conversations by the user's city

		$result_city_conversations = DB::connection('WarRoom')->select('SELECT COUNT(*) AS count
																	FROM WarRoom.contact_master
																	INNER JOIN cfrapp.users
																	ON WarRoom.contact_master.volunteer_id = cfrapp.users.id
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
																	ON cities.id = users.city_id AND cities.name <> ?',array('Beyond Bangalore'));

		if(isset($result_mad_amount_raised[0])){

			$mad_amount_raised = $result_mad_amount_raised[0]->sum;
		}else{

			$mad_amount_raised = 0;
		}


		//Calculate total conversations by MAD

		$result_mad_conversations = DB::connection('WarRoom')->select('SELECT COUNT(*) AS count
																	FROM contact_master WHERE status <> ?',
																	array('open'));

		if(isset($result_mad_conversations[0])){

			$mad_conversations = $result_mad_conversations[0]->count;
		}else{

			$mad_conversations = 0;
		}


		$data = compact("you_amount_raised","city_amount_raised","mad_amount_raised","you_conversations","city_conversations","mad_conversations");

		return $data;

	}


}


?>
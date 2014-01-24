<?php

class Home extends BaseController {

	public function showHome(){

		$dashboard = $this->calculateDashboard();

		$run_rate = $this->calculateRunRate();

		$data = compact("dashboard","run_rate");

		return View::make('Home',$data);
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

			$city_data = compact("city_name", "diff_in_amount","city_amount_raised","ideal_amount");

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


		$data = compact("you_amount_raised","city_amount_raised","mad_amount_raised");

		return $data;

	}


}


?>
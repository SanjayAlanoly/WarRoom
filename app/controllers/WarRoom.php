<?php

class WarRoom extends BaseController {

	public function index()
	{
		return View::make('WarRoom');

		
	}

	public function add_conv(){


		DB::connection('WarRoom')->insert('insert into conversation (user_id, created_at) values (?, ?)', array(1, date("Y-m-d H:i:s")));

		$this->render_conv_progress();
	

	}


	public static function render_conv_progress(){

		$result_target =  DB::select('select quantity from target where target_date = ? AND type = ?', array(date("Y-m-d"),'conversation'));

		$result_conv_count =  DB::select('SELECT COUNT(*) as count FROM conversation WHERE DATE(created_at) = CURDATE()');
		
		if(isset($result_target[0])){

			$conv_target = $result_target[0]->quantity;

		}else{

			$conv_target = 100;
		}

		if(isset($result_conv_count[0])){

			$conv_count = $result_conv_count[0]->count;
		}else{

			$conv_count = 0;
		}

		$conv_percentage = ($conv_count/$conv_target)*100;

		echo '<div class="row">';


		echo '<div class="col-md-6">';

		echo '<h4>Conversations : ' . $conv_count . '</h4>';

		echo '</div>';


		echo '<div class="col-md-6">';

		echo '<h4 class="pull-right">Target : ' . $conv_target . '</h4>';

		echo '</div>';
		 

		echo '</div>';

		echo '<div class="row">';

		echo '<div class="col-md-12">';

		echo '<div class="progress progress-striped active">
				 	 <div class="progress-bar" role="progressbar" aria-valuenow="' . $conv_percentage . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $conv_percentage . '%;">
					  		<span class="sr-only">' . $conv_percentage . '% Complete</span>
					 </div>
				</div>';

		echo '</div>';

		echo '</div>';


	}

	public function add_pledged(){

		$pledged_amount = Input::get('pledged_amount', 0);

		DB::connection('WarRoom')->insert('insert into money_pledged (user_id, created_at, pledged_amount) values (?, ?, ?)', array(1, date("Y-m-d H:i:s"), $pledged_amount));

		$this->render_pledged_progress();
	}

	public static function render_pledged_progress(){

		$result_target =  DB::select('select quantity from target where target_date = ? AND type = ?', array(date("Y-m-d"),'money_pledged'));

		$result_pledged_amount =  DB::select('SELECT SUM(pledged_amount) as amount FROM money_pledged WHERE DATE(created_at) = CURDATE()');
		
		if(isset($result_target[0])){

			$pledged_target = $result_target[0]->quantity;

		}else{

			$pledged_target = 100;
		}

		if(isset($result_pledged_amount[0])){

			$pledged_amount = $result_pledged_amount[0]->amount;
		}else{

			$pledged_amount = 0;
		}

		$pledged_percentage = ($pledged_amount/$pledged_target)*100;

		echo '<div class="row">';


		echo '<div class="col-md-6">';

		echo '<h4>Money Pledged : ' . $pledged_amount . '</h4>';

		echo '</div>';


		echo '<div class="col-md-6">';

		echo '<h4 class="pull-right">Target : ' . $pledged_target . '</h4>';

		echo '</div>';


		echo '</div>';


		echo '<div class="row">';

		echo '<div class="col-md-12">';

		echo '<div class="progress progress-striped active">
				 	 <div class="progress-bar" role="progressbar" aria-valuenow="' . $pledged_percentage . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $pledged_percentage . '%;">
					  		<span class="sr-only">' . $pledged_percentage . '% Complete</span>
					 </div>
				</div>';

		echo '</div>';

		echo '</div>';
	}

}
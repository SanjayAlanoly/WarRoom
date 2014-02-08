<?php

class WarRoom extends BaseController
{

	public function showWarRoom()
	{
		session_start();
        $_SESSION['name'] = Auth::user()->first_name . " " . Auth::user()->last_name;

        
		//return View::make('WarRoom',array('donation_amount' => $user[0]->donation_amount));
		return View::make('WarRoom')
                    ->with('donationRanges', ContactMaster::getDonationRange())
                    ->with('contacts', ContactMaster::getContacts())
                    ->with('callbacks', Callback::getCallBack())
                    ->with('pledged', Pledged::getPledged());
	}


	public static function renderChildrenSupported(){


		$result_pledged_amount =  DB::select('SELECT SUM(amount_pledged) as amount FROM pledged WHERE DATE(updated_at) = CURDATE()');

		if(isset($result_pledged_amount[0])){

			$pledged_amount = $result_pledged_amount[0]->amount;
		}else{

			$pledged_amount = 0;
		}

		$children_supported = round($pledged_amount/1000,0,PHP_ROUND_HALF_DOWN);

		echo "<h2 class='text-center sub_title'>Children Supported : " . $children_supported . "</h2>";


	}

	public function addConv(){


		DB::connection('WarRoom')->insert('insert into conversation (user_id, created_at) values (?, ?)', array(1, date("Y-m-d H:i:s")));

		$this->render_conv_progress();
	

	}


	public static function render_conv_progress(){

		$result_target =  DB::select('select quantity from target where target_date = ? AND type = ?', array(date("Y-m-d"),'conversation'));

		$result_conv_count =  DB::select('SELECT COUNT(*) as count FROM contact_master WHERE DATE(updated_at) = CURDATE() AND status <> ? AND status <> ? AND status <> ?',array('collected','retracted','open'));
		
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

		echo '<p class="normal">Conversations : ' . $conv_count . '</p>';

		echo '</div>';


		echo '<div class="col-md-6">';

		echo '<p class="pull-right normal">Target : ' . $conv_target . '</p>';

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

	public function addPledged(){

		$pledged_amount = Input::get('pledged_amount', 0);

		DB::connection('WarRoom')->insert('insert into money_pledged (user_id, created_at, pledged_amount) values (?, ?, ?)', array(1, date("Y-m-d H:i:s"), $pledged_amount));

		$this->render_pledged_progress();
	}

	public static function render_pledged_progress(){

		$result_target =  DB::select('select quantity from target where target_date = ? AND type = ?', array(date("Y-m-d"),'money_pledged'));

		$result_pledged_amount =  DB::select('SELECT SUM(amount_pledged) as amount FROM pledged WHERE DATE(updated_at) = CURDATE()');
		
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

		echo '<p class="normal">Money Pledged : ' . $pledged_amount . '</p>';

		echo '</div>';


		echo '<div class="col-md-6">';

		echo '<p class="pull-right normal">Target : ' . $pledged_target . '</p>';

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

	public function destroySession(){

		// Destroy session
		session_start();
        session_destroy();

        return Redirect::to('logout');
	}

	public static function renderConvList()
	{

		$contacts = ContactMaster::getContacts();

        $callbacks = Callback::getCallBack();

        $pledged = Pledged::getPledged();

		echo "	 

		<div class=\"row\">

		<h3>To Call</h3>       

		<table>
	            <tr>
	                <th>Name</th>
	                <th>Pledged</th>
	                <th>Call Back</th>
	                <th>Not Interested</th>
	            </tr>";

        foreach($contacts as $contact)
        {


        echo "
		        <tr>
		            <td>
		            	<a class=\"list_popover\" data-container=\"body\" data-toggle=\"popover\" data-placement=\"top\" 
		            	data-content=\" <strong> $contact->name </strong> <br /> Phone : $contact->phone <br /> Email : $contact->email <br /> Donation Range : $contact->donation_range\">
          					$contact->name
        				</a>
					</td>
		            <td><button class='list_button' title=\"Pledged\" onclick=\"updatecm('pledged',$contact->id)\"><img src=\"img/pledged.png\" alt=\"Pledged\" ></button></td>
		            <td><button class='list_button' title=\"Call Back\" onclick=\"updatecm('call_back',$contact->id)\"><img src=\"img/call_back.png\" alt=\"Call Back\" ></button></td>
		            <td><button class='list_button' title=\"Not Interested\" onclick=\"updatecm('not_interested',$contact->id)\"><img src=\"img/not_interested.png\" alt=\"Not Interested\" ></button></td>
		        </tr>";
       }

        echo "</table>";

        echo "</div>";


       	echo	"
	       		
		        <div class=\"row\" style=\"margin-top:10px;\">
		        <h3>To Call Back</h3>
		            <table>
		                <tr>
		                    <th>Name</th>
		                    <th>Call Date</th>
		                    <th>Pledged</th>
		                    <th>Call Back</th>
		                    <th>Not Interested</th>
		                </tr>
		               
		        ";

		foreach($callbacks as $cb){

			$rd = WarRoom::relativeDate(strtotime($cb->call_date));

			echo "
		                <tr>
		                    <td>
				            	<a class=\"list_popover\" data-container=\"body\" data-toggle=\"popover\" data-placement=\"top\" 
				            	data-content=\" <strong> ";
				            	print_r($cb->contactmaster->name);
				            	echo "</strong> <br /> Phone : ";
				            	print($cb->contactmaster->phone);
				            	echo " <br /> Email : ";
				            	print_r($cb->contactmaster->email);
				            	echo " <br /> Call Date : $cb->call_date";
				            	echo " <br /> Comments : $cb->comments\">";
				            	print_r($cb->contactmaster->name);
				            	echo "</a></td>";

		    echo "          <td>$rd</td>
		                    <td><button class='list_button' title=\"Pledged\" onclick=\"updatecb('pledged',$cb->id)\"><img src=\"img/pledged.png\" alt=\"Pledged\" ></button></td>
		                    <td><button class='list_button' title=\"Call Back\" onclick=\"updatecb('call_back',$cb->id)\"><img src=\"img/call_back.png\" alt=\"Call Back\" ></button></td>
		                    <td><button class='list_button' title=\"Not Interested\" onclick=\"updatecb('not_interested',$cb->id)\"><img src=\"img/not_interested.png\" alt=\"Not Interested\" ></button></td>
		                </tr>
		         ";

		}


		echo "</table>";

		if(count($callbacks)==0){
		    echo "<p>List Empty</p>";
		}

		echo "
		        </div>
		        
		        
		        <div class=\"row\" style=\"margin-top:10px;\">
		        <h3>To Collect</h3>
		            <table>
		                <tr>
		                    <th>Name</th>
		                    <th>Collect Date</th>
		                    <th>Collected</th>
		                    <th>Retracted</th>
		                </tr>
		    ";
		               
        foreach($pledged as $pl){

        	$rd = WarRoom::relativeDate(strtotime($pl->collect_date));
        
       		echo "	
                <tr>
              		<td>
		            	<a class=\"list_popover\" data-container=\"body\" data-toggle=\"popover\" data-placement=\"top\" 
		            	data-content=\" <strong> ";
		            	print_r($pl->contactmaster->name);
		            	echo "</strong> <br /> Phone : ";
		            	print($pl->contactmaster->phone);
		            	echo " <br /> Email : ";
		            	print_r($pl->contactmaster->email);
		            	echo " <br /> Amount Pledged : $pl->amount_pledged";
		            	echo " <br /> Collect Date : $pl->collect_date";
		            	echo " <br /> Comments : $pl->comments\">";
		            	print_r($pl->contactmaster->name);
		            	echo "</a></td>";
		    echo "

                    <td>$rd</td>
  
                    <td><button class='list_button' title=\"Collected\" onclick=\"updatepl('collected', $pl->id)\"><img src=\"img/collected.png\" alt=\"Collected\" ></button></td>
                    <td><button class='list_button' title=\"Retractecd\" onclick=\"updatepl('retracted',$pl->id)\"><img src=\"img/not_interested.png\" alt=\"Retractecd\" ></button></td>
                </tr>

                ";
        }


		echo "</table>";

		if(count($pledged)==0){
		  	echo "<p>List Empty</p>";
		}
		       

		echo "</div>";

		echo "<script type=\"text/javascript\">$('.list_popover').popover({'html' : true});</script>";


                        
	}


        
    public function addContact()
    {
        $data = array(
            'name' => Input::get('name'),
            'phone' => Input::get('phone'),
            'email' => Input::get('email'),
            'status' => Input::get('status'),
            'donation_range' => Input::get('donation_range'),
            'volunteer_id' => Auth::user()->id
        );
        
        $cm = new ContactMaster();
        
        if($cm->validate($data))
        {
            $cm->name = $data['name'];
            $cm->phone = $data['phone'];
            $cm->email = $data['email'];
            $cm->status = $data['status'];
            $cm->donation_range = $data['donation_range'];
            $cm->volunteer_id = $data['volunteer_id'];
            $cm->save();
            $res = "Contact added successfully";
        }
        
        else
        {
            $res = "There was an error adding the contact. Please try again";
        }
        
        return $res;
        
    }
    
    public function updateContact()
    {
        
        return ContactMaster::updateContact(Input::all());
        
    }
    
    public function updateCallback()
    {
        
        return Callback::updateCallback(Input::all());
    }
    
    public function updatePledge()
    {
        return Pledged::updatePledge(Input::all());
    }






    public static function relativeDate($time) 
    {

		$today = strtotime(date('M j, Y'));

		$reldays = ($time - $today)/86400;

		if ($reldays >= 0 && $reldays < 1) {

		return 'Today';

		} else if ($reldays >= 1 && $reldays < 2) {

		return 'Tomorrow';

		} else if ($reldays >= -1 && $reldays < 0) {

		return 'Yesterday';

		}

		if (abs($reldays) < 7) {

		if ($reldays > 0) {

		$reldays = floor($reldays);

		return 'In ' . $reldays . ' day' . ($reldays != 1 ? 's' : '');

		} else {

		$reldays = abs(floor($reldays));

		return $reldays . ' day' . ($reldays != 1 ? 's' : '') . ' ago';

		}

		}

		if (abs($reldays) < 182) {

		return date('j F',$time ? $time : time());

		} else {

		return date('j F, Y',$time ? $time : time());

		}

		

	}

}
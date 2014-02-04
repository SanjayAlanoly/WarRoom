<?php

class WarRoom extends BaseController {

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


		$result_pledged_amount =  DB::select('SELECT SUM(pledged_amount) as amount FROM money_pledged WHERE DATE(created_at) = CURDATE()');

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

	public static function renderOpenConv()
	{

		$contacts = ContactMaster::getContacts();

		echo "	        

		<table>
	            <tr>
	                <th>Name</th>
	                <th>Email</th>
	                <th>Phone</th>
	                <th>Status</th>
	                <th>Donation Range</th>
	                <th>&nbsp;</th>
	                <th>&nbsp;</th>
	                <th>&nbsp;</th>
	            </tr>";

        foreach($contacts as $contact)
        {


        echo "
		        <tr>
		            <td>$contact->name</td>
		            <td>$contact->email</td>
		            <td>$contact->phone</td>
		            <td>$contact->status</td>
		            <td>$contact->donation_range</td>
		            <td><button onclick=\"updatecm('pledged',$contact->id)\">Pledge</button></td>
		            <td><button onclick=\"updatecm('call_back',$contact->id)\">Call Back</button></td>
		            <td><button onclick=\"updatecm('not_interested',$contact->id)\">Not Interested</button></td>
		        </tr>";
       }

       echo "</table>";
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

}
<?php

class Import extends BaseController {

	public function showImport(){

		return View::make('Import')->with('cities',$this->getCities());

	}

	public function getCities(){

		return DB::connection('cfrapp')->select("SELECT id,name FROM cities");
	}

	public function getVolunteers(){

		$volunteers = DB::connection('cfrapp')->select("SELECT id,first_name,last_name from users WHERE city_id =?",array(Input::get('choice')));

		foreach($volunteers as $volunteer){

			echo "<option value=\"$volunteer->id\">$volunteer->first_name $volunteer->last_name</option>";
		}
	}

	public function uploadFile(){


		if (isset($_POST['submit'])) {
		    if (is_uploaded_file($_FILES['filename']['tmp_name'])) {

		    	echo "<!DOCTYPE html>\n"; 
				echo "<html lang=\"en\">\n"; 
				echo "<head>\n"; 
				echo "\n"; 
				echo "	<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n"; 
				echo "	\n"; 
				echo "    <link href=\"../css/bootstrap.min.css\" rel=\"stylesheet\">\n";
				echo "    <link href=\"../css/custom.css\" rel=\"stylesheet\">\n";
				echo "</head>\n"; 
				echo "\n"; 
				echo "<body>\n"; 
				echo "\n"; 
				echo "\n"; 
				echo "	<div class=\"container board\">\n";

				$file_info = pathinfo($_FILES['filename']['name']);

				if($file_info['extension'] == 'csv'){


					echo "<h1 class='text-center title'>" . "File uploaded successfully" . "</h1>";

			        


						        
			        echo "<p class='normal'>Displaying contents of " . $_FILES['filename']['name'] . " : </p>";
			        //readfile($_FILES['filename']['tmp_name']);
		   		
			

					$handle = fopen($_FILES['filename']['tmp_name'], "r");

					echo "<table>";
					echo "<tr><th>Name</th><th>Amount</th></tr>";

				    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

				    	
				    	if($data[0] == 'Name' || $data[0] == 'name' || $data[0] == 'NAME'){
				    		continue;
				    	}

				    	if($data[0] == ''){
				    		continue;
				    	}

				    	echo "<tr><td>$data[0]</td><td>";
				    	if(isset($data[1]))
				    		echo "$data[1]</td></tr>";
				    	else
				    		echo "</td></tr>";


				    	$cm = new ContactMaster();


				        $cm->name = $data[0];

				        if(isset($data[1])){

					        if($data[1] >=0 && $data[1] <=500)
					        	$cm->donation_range = '0-500';
					        else if($data[1] <=2000)
					        	$cm->donation_range = '501-2000';
					        else if($data[1] >= 2001)
					        	$cm->donation_range = '2001-above';
					        else
					        	$cm->donation_range = '0-500';
					    }else{
					    	$cm->donation_range = '0-500';	
					    }



				        $cm->volunteer_id = $_POST['volunteers_dropdown'];

				        $cm->save();

				       
				    }

				    fclose($handle);

			     	

				    echo "</table><br/><br/>";

				}else{

					echo "<br/><br/><p class='text-center normal'>" . "File is of $file_info[extension] type and not csv. Please save the file in the correct format and upload again." . "</p>";


				}

			    echo "<div class='text-center'><button class='btn btn-primary btn-lg' type='button' onClick=\"location.href='../Import'\">Back to Upload</button></div>";

			    echo "</div></body></html>";

			}
		}

	}

}
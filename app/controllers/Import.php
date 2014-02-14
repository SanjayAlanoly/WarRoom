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
		        echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1>";
		        echo "<h2>Displaying contents:</h2>";
		        readfile($_FILES['filename']['tmp_name']);
	   		}
		}


		$handle = fopen($_FILES['filename']['tmp_name'], "r");


		


	    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

	    	echo 'Name : ' . $data[0];

	    	$cm = new ContactMaster();


	        $cm->name = $data[0];
	        $cm->volunteer_id = Auth::user()->id;
	        $cm->save();

	       
	    }

	    fclose($handle);

	    print "Import done";

	}

}
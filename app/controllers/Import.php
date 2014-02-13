<?php

class Import extends BaseController {

	public function showImport(){

		return View::make('Import');

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
<!DOCTYPE html>
<html lang="en">
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/custom-navbar.css" rel="stylesheet">

    <link href="css/custom.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="js/Import.js" type="text/javascript"></script>

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-48212155-1', 'makeadiff.in');
      ga('send', 'pageview');

    </script>

</head>

<body>


	<div class="container board">

		<h1 class="text-center title">Upload Contacts</h1>

		<br/>

		<select id="cities_dropdown" class="form-control">

			<option value="">Please select the city</option>

			<?php
			foreach($cities as $city){

				echo "<option value=\"$city->id\">$city->name</option>";
			}
			?>

		</select>

		<br/>

		<form action="Import/uploadFile" method="post" enctype="multipart/form-data">
			
			<select name="volunteers_dropdown" id="volunteers_dropdown" class="form-control">

			</select>

			<br/>
			
 			<input size='50' type='file' name='filename'><br />

			<input type='submit' name='submit' value='Upload'>
		</form>

		<div id="preview_area"></div>

	</div>



</body> 
</html> 

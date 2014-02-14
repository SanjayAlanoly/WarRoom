<!DOCTYPE html>
<html lang="en">
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/custom-navbar.css" rel="stylesheet">

    <link href="css/custom.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="js/Import.js" type="text/javascript"></script>

</head>

<body>

	<nav class="navbar navbar-default navbar-static-top" role="navigation">
		<div class="navbar-header">
		    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
			      <span class="sr-only">Toggle navigation</span>
			      <span class="icon-bar"></span>
			      <span class="icon-bar"></span>
			      <span class="icon-bar"></span>
		    </button>
		    <a class="navbar-brand" href="#">FRaise</a>
	  	</div>
	  	<div class="collapse navbar-collapse" id="navbar-collapse-1">
	  		<ul class="nav navbar-nav">
      			<li class="active"><a href="#">Home</a></li>
      			<li><a target="_blank" href="../public/WarRoom">War Room</a></li>
      		</ul>
      		<button type="button" class="btn btn-default navbar-btn navbar-right" onclick="location.href='destroySession'">Logout</button>
	  	</div>
	</nav>

	<div class="container board">

		<select id="cities_dropdown" class="form-control">

			<?php
			foreach($cities as $city){

				echo "<option value=\"$city->id\">$city->name</option>";
			}
			?>

		</select>

		<select id="volunteers_dropdown" class="form-control">

		</select>

		<form enctype='multipart/form-data' onSubmit="return submitFile()">
			<input size='50' type='file' name='filename'><br />
			<input type='submit' name='submit' value='Upload'>
		</form>

	</div>



</body> 
</html> 

<!DOCTYPE html>
<html lang="en">
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/custom-navbar.css" rel="stylesheet">

    <link href="css/custom.css" rel="stylesheet">
   

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
		    <a class="navbar-brand" href="#">FOE</a>
	  	</div>
	  	<div class="collapse navbar-collapse" id="navbar-collapse-1">
	  		<ul class="nav navbar-nav">
      			<li class="active"><a href="#">Home</a></li>
      			<li><a href="../public">War Room</a></li>
      		</ul>
      		<button type="button" class="btn btn-default navbar-btn navbar-right" onclick="location.href='destroySession'">Logout</button>
	  	</div>
	</nav>


	<div class="container board">

		<h1 class="text-center title">Home</h1>

		<br>

		<ul class="nav nav-tabs nav-justified" id="myTab">
			  <li><a href="#you" data-toggle="tab">You</a></li>
			  <li><a href="#city" data-toggle="tab">City</a></li>
			  <li><a href="#mad" data-toggle="tab">MAD</a></li>
			  
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
		  	<div class="tab-pane fade in active" id="you">

		  		<br>

		  		<p class="normal">Amount Raised : <?php echo $dashboard['you_amount_raised']; ?></p>
		  		
		  	</div>
	  		<div class="tab-pane fade" id="city">

		  		<br>

		  		<p class="normal">Amount Raised : <?php echo $dashboard['city_amount_raised']; ?></p>

		  	</div>
		  	<div class="tab-pane fade" id="mad">

		  		<br>

		  		<p class="normal">Amount Raised : <?php echo $dashboard['mad_amount_raised']; ?></p>

		  	</div>
			  
		</div>
		
		<?php 
		//var_dump($run_rate)
	
		echo "<table>";
		echo "<th>City</th><th>Amount Raised</th><th>Ideal Amount</th><th>Difference in Amount</th>";

		foreach($run_rate as $city){

			echo "<tr><td>$city[city_name]</td><td>$city[city_amount_raised]</td><td>$city[ideal_amount]</td><td>$city[diff_in_amount]</td></tr>";

		}

		echo "</table>";

		?>
	</div>

	<script src="https://code.jquery.com/jquery.js"></script>

	<script src="js/bootstrap.min.js"></script>	
	<script src="js/Home.js" type="text/javascript"></script>

    
	  
</body>
</html>
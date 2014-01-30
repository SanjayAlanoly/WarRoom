<!DOCTYPE html>
<html lang="en">
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/custom-navbar.css" rel="stylesheet">

    <link href="css/custom.css" rel="stylesheet">


    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['City', 'Target Amount', 'Amount Raised'],

        <?php
  		foreach($run_rate as $city){

			echo "[" . "'" . $city['city_name'] . "($city[percentage]%)" . "'" . ",$city[ideal_amount],$city[city_amount_raised]],";

		}?>

          ['Delhi',  1000,      400],
          ['Kolkata',  1170,      460],
          ['Nagpur',  660,       1120],
          ['Delhi',  1000,      400],
          ['Kolkata',  1170,      460],
          ['Nagpur',  660,       1120],
          ['Coimbatore',  1030,      540]
        ]);

        var options = {
          'backgroundColor':'#ffe800',
          'title': 'City',
          'hAxis': {title: 'Year', titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);


        function resizeHandler () {
        	chart.draw(data, options);
	    }
	    if (window.addEventListener) {
	        window.addEventListener('resize', resizeHandler, false);
	    }
	    else if (window.attachEvent) {
	        window.attachEvent('onresize', resizeHandler);
	    }
       
      }
    </script>
   

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
      			<li><a href="../public/WarRoom">War Room</a></li>
      		</ul>
      		<button type="button" class="btn btn-default navbar-btn navbar-right" onclick="location.href='destroySession'">Logout</button>
	  	</div>
	</nav>


	<div class="container board no-padding">

		<img class="img-responsive banner" src="img/banner.jpg"></img>

		<div class="inner">


		<?php if($message = Session::get('success')){

		echo '<div class="alert alert-success alert-dismissable">
		  			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
		echo "<strong>Success</strong>: $message";
  			
		echo '</div>';


		}

		?>

		

		

		<br>

		<ul class="nav nav-tabs nav-justified" id="myTab">
			  <li class="active"><a href="#you" data-toggle="tab">You</a></li>
			  <li><a href="#city" data-toggle="tab">City</a></li>
			  <li><a href="#mad" data-toggle="tab">MAD</a></li>
			  
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
		  	<div class="tab-pane fade in active" id="you">

		  		<br>

		  		<p class="normal">Amount Raised by You : <?php echo $dashboard['you_amount_raised']; ?></p>
		  		<p class="normal">Children Supported by You: <?php echo round($dashboard['you_amount_raised']/1000,0,PHP_ROUND_HALF_DOWN); ?></p>
		  		<p class="normal">Conversations made by You: <?php echo $dashboard['you_conversations']; ?></p>
		  		
		  	</div>
	  		<div class="tab-pane fade" id="city">

		  		<br>

		  		<p class="normal">Amount Raised by your City: <?php echo $dashboard['city_amount_raised']; ?></p>
		  		<p class="normal">Children Supported by your City: <?php echo round($dashboard['city_amount_raised']/1000,0,PHP_ROUND_HALF_DOWN); ?></p>
		  		<p class="normal">Conversations made by your City: <?php echo $dashboard['city_conversations']; ?></p>

		  	</div>
		  	<div class="tab-pane fade" id="mad">

		  		<br>

		  		<p class="normal">Amount Raised by MAD: <?php echo $dashboard['mad_amount_raised']; ?></p>
		  		<p class="normal">Children Supported by MAD : <?php echo round($dashboard['mad_amount_raised']/1000,0,PHP_ROUND_HALF_DOWN); ?></p>
		  		<p class="normal">Conversations made by MAD : <?php echo $dashboard['mad_conversations']; ?></p>

		  	</div>
			  
		</div>
		

		

<!-- 		<?php 
		//var_dump($run_rate)
	
		echo "<table>";
		echo "<th>City</th><th>Amount Raised</th><th>Ideal Amount</th><th>Difference in Amount</th>";

		foreach($run_rate as $city){

			echo "<tr><td>$city[city_name]</td><td>$city[city_amount_raised]</td><td>$city[ideal_amount]</td><td>$city[diff_in_amount]</td></tr>";

		}

		echo "</table>";

		?>
 -->


		<ul class="nav nav-tabs nav-justified" id="myTab2">
			  <li class="active"><a href="#you_city" data-toggle="tab">You vs City</a></li>
			  <li><a href="#you_national" data-toggle="tab">You vs National</a></li>
			    
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">

		  	<div class="tab-pane fade in active" id="you_city">



				<table>
				<th>Rank</th><th>Name</th><th>Amount Raised</th>

				<?php

				for($i = $leaderboard['user_count_city'] - 3 ; $i <= ($leaderboard['user_count_city'] + 3) ; $i++){

					if(isset($leaderboard['fundraisers_city'][$i])){

						$j = $i + 1;

						if($i == $leaderboard['user_count_city'])
							echo "<tr><td class='middle'>$j</td><td class='middle'>" .  $leaderboard['fundraisers_city'][$i]->first_name . "</td><td class='middle'>" . $leaderboard['fundraisers_city'][$i]->amount . "</td>";
						else
							echo "<tr><td>$j</td><td>" .  $leaderboard['fundraisers_city'][$i]->first_name . "</td><td>" . $leaderboard['fundraisers_city'][$i]->amount . "</td>";

					}
						

				}
				?>


				</table>
			</div>

			<div class="tab-pane fade in" id="you_national">




				<table>
				<th>Rank</th><th>Name</th><th>Amount Raised</th>

				<?php

				for($i = $leaderboard['user_count_national'] - 3 ; $i <= ($leaderboard['user_count_national'] + 3) ; $i++){

					if(isset($leaderboard['fundraisers_national'][$i])){

						$j = $i + 1;

						if($i == $leaderboard['user_count_national'])
							echo "<tr><td class='middle'>$j</td><td class='middle'>" .  $leaderboard['fundraisers_national'][$i]->first_name . "</td><td class='middle'>" . $leaderboard['fundraisers_national'][$i]->amount . "</td>";
						else
							echo "<tr><td>$j</td><td>" .  $leaderboard['fundraisers_national'][$i]->first_name . "</td><td>" . $leaderboard['fundraisers_national'][$i]->amount . "</td>";

					}
						

				}
				?>


				

				</table>

			</div>
		</div>

		<div id="chart_div" style="width: 100%; height: 500px;"></div>
		</div>	
	</div>

	<script src="https://code.jquery.com/jquery.js"></script>

	<script src="js/bootstrap.min.js"></script>	
	<script src="js/Home.js" type="text/javascript"></script>

    
	  
</body>
</html>
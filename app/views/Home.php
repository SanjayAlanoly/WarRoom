<!DOCTYPE html>
<html lang="en">
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/custom-navbar.css" rel="stylesheet">

    <link href="css/custom.css" rel="stylesheet">

    <link href="css/ui-lightness/jquery-ui-1.10.4.custom.css" media="all" type="text/css" rel="stylesheet">

	<script src="js/jquery.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
    <script src="js/jquery.form-validator.min.js"></script>
	<script src="js/bootstrap.min.js"></script>	
	<script src="js/Home.js" type="text/javascript"></script>



    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-48212155-1', 'makeadiff.in');
      ga('send', 'pageview');

    </script>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['City', 'Target Amount', 'Amount Raised'],

        <?php

        $i = 01;

  		foreach($run_rate as $city){

			echo "[" . "'" . $i . ". " . $city['city_name'] . "($city[percentage]%)" . "'" . ",$city[ideal_amount],$city[city_amount_raised]],";
			$i++;

		}?>

        ]);

        var options = {
          'backgroundColor':'#ffe800',
          'title': '',
          'hAxis': {title: 'Cities', titleTextStyle: {color: 'red'}}
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


	<div class="container board no-padding">

		<img class="img-responsive banner" src="img/banner.jpg">

		<div class="inner">


		<?php if($message = Session::get('success')){

		echo '<div class="alert alert-success alert-dismissable">
		  			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
		echo "<strong>Success</strong>: $message";
  			
		echo '</div>';


		}

		?>

		

		

		

		<h2 class="sub_title text-center">Dashboard</h2>

		<ul class="nav nav-tabs nav-justified" id="myTab">
			  <li class="active"><a href="#you" data-toggle="tab">You</a></li>
			  <li><a href="#city" data-toggle="tab">City</a></li>
			  <li><a href="#mad" data-toggle="tab">MAD</a></li>
			  
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
		  	<div class="tab-pane fade in active" id="you">

		  		<br>

		  		<p class="normal">Amount Raised by You : <?php echo "Rs. " . number_format($dashboard['you_amount_raised']); ?></p>
		  		<p class="normal">Children Supported by You : <?php echo round($dashboard['you_amount_raised']/1000,0,PHP_ROUND_HALF_DOWN); ?></p>
		  		<p class="normal">Conversations made by You : <?php echo number_format($dashboard['you_conversations']); ?></p>
		  		<p class="normal">Sparta Days completed by You : <?php echo $dashboard['sparta_days_completed']; ?>/21</p>
		  		
		  	</div>
	  		<div class="tab-pane fade" id="city">

		  		<br>

		  		<p class="normal">Amount Raised by your City: <?php echo "Rs. " . number_format($dashboard['city_amount_raised']); ?></p>
		  		<p class="normal">Children Supported by your City: <?php echo number_format(round($dashboard['city_amount_raised']/1000,0,PHP_ROUND_HALF_DOWN)); ?></p>
		  		<p class="normal">Conversations made by your City: <?php echo number_format($dashboard['city_conversations']); ?></p>

		  	</div>
		  	<div class="tab-pane fade" id="mad">

		  		<br>

		  		<p class="normal">Amount Raised by MAD : <?php echo "Rs. " . number_format($dashboard['mad_amount_raised']); ?></p>
		  		<p class="normal">Children Supported by MAD : <?php echo number_format(round($dashboard['mad_amount_raised']/1000,0,PHP_ROUND_HALF_DOWN)); ?></p>
		  		<p class="normal">Conversations made by MAD : <?php echo number_format($dashboard['mad_conversations']); ?></p>

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

 		<br />

 		<h2 class="sub_title text-center">Leaderboard</h2>

		<ul class="nav nav-tabs nav-justified" id="myTab2">
			  <li class="active"><a href="#you_city" data-toggle="tab">You vs City</a></li>
			  <li><a href="#you_national" data-toggle="tab">You vs National</a></li>
			    
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">

		  	<div class="tab-pane fade in active" id="you_city">



				

				<?php

				if($leaderboard['user_count_city'] == -1){
					echo "<p class='normal'><br />You haven't started fundraising yet.</p>";
				}else{

					echo "
						<table>
						<th>Rank</th><th>Name</th><th>Amount Raised</th>";

					for($i = $leaderboard['user_count_city'] - 3 ; $i <= ($leaderboard['user_count_city'] + 3) ; $i++){

						if(isset($leaderboard['fundraisers_city'][$i])){

							$j = $i + 1;

							if($i == $leaderboard['user_count_city'])
								echo "<tr><td class='middle'>$j</td><td class='middle'>" .  $leaderboard['fundraisers_city'][$i]->first_name . " " . $leaderboard['fundraisers_city'][$i]->last_name . "</td><td class='middle'>" . $leaderboard['fundraisers_city'][$i]->amount . "</td>";
							else
								echo "<tr><td>$j</td><td>" .  $leaderboard['fundraisers_city'][$i]->first_name . " " . $leaderboard['fundraisers_city'][$i]->last_name . "</td><td>" . $leaderboard['fundraisers_city'][$i]->amount . "</td>";

						}
							

					}
				}
				?>


				</table>
			</div>

			<div class="tab-pane fade in" id="you_national">




				

				<?php

				if($leaderboard['user_count_national'] == -1){

					echo "<p class='normal'><br />You haven't started fundraising yet.</p>";

				}else{

					echo "
						<table>
						<th>Rank</th><th>Name</th><th>City</th><th>Amount Raised</th>";

					for($i = $leaderboard['user_count_national'] - 3 ; $i <= ($leaderboard['user_count_national'] + 3) ; $i++){

						if(isset($leaderboard['fundraisers_national'][$i])){

							$j = $i + 1;

							if($i == $leaderboard['user_count_national'])
								echo "<tr><td class='middle'>$j</td><td class='middle'>" .  $leaderboard['fundraisers_national'][$i]->first_name . " " . $leaderboard['fundraisers_national'][$i]->last_name . "</td><td class='middle'>" . $leaderboard['fundraisers_national'][$i]->city_name . "</td><td class='middle'>" . $leaderboard['fundraisers_national'][$i]->amount . "</td>";
							else
								echo "<tr><td>$j</td><td>" .  $leaderboard['fundraisers_national'][$i]->first_name . " " 
							. $leaderboard['fundraisers_national'][$i]->last_name . "</td><td>" . $leaderboard['fundraisers_national'][$i]->city_name 
							. "</td><td>" . $leaderboard['fundraisers_national'][$i]->amount . "</td>";

						}
							

					}
				}
				?>


				

				</table>

			</div>
		</div>

		<br />

		<h2 class="sub_title text-center">City Run Rate</h2>

		<div id="chart_div" style="width: 100%; height: 500px;"></div>

		<br>

		<h2 class="sub_title text-center">Contacts</h2>

		<div class="panel-group" id="accordion">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                  Contact List (click to toggle)
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">
              <div class="panel-body">
                
                <div id="conv_list" class="conv_list">
                    <?php WarRoom::renderConvList(); ?>
                </div>
                        
                <div class="row" style="margin-top:10px;">
                    <div class="col-md-12">
                        <button id="add_contact" class="btn btn-primary btn-lg" type="button">Add Contact</button>
                    </div>
                </div>

              </div>
            </div>
          </div>
        </div>
		</div>	
	</div>

	<div id="addContact">
        <form>
            <label for="name">*Name</label>
            <input type="text" id="name" name="name" data-validation="required" /><br>
            
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" /><br>
            
            <label for="email">Email</label>
            <input type="text" id="email" name="email" /><br>
            
          
            <label for="donation_range">Donation range</label>
            <select name="donation_range" id="donation_range">
                   <?php foreach ($donationRanges as $k=>$v): ?>
                <option value="<?php echo $k?>"><?php echo $v ?></option>
                    <?php endforeach ?>
            </select><br>

            <p style="font-style:italic">* : Required</p>
            
        </form>
        
    </div>
    <div id="contactCallback">
         <form>
            <label for="datepicker1">*Call Date</label>
            <input type="text" id="datepicker1" data-validation="required" value="<?php echo date("Y-m-d")?>"/><br><br>
            <label for="comments">Comments</label>
            <textarea name="comments" id="comments"></textarea>
            <p style="font-style:italic">* : Required</p>
         </form>
            
    </div>
    <div id="contactCallbackCB">
         <form>
            <label for="datepicker4">*Call Date</label>
            <input type="text" id="datepicker4" data-validation="required" value="<?php echo date("Y-m-d")?>"/><br><br>
            <label for="comments4">Comments</label>
            <textarea name="comments4" id="comments4"></textarea>
            <p style="font-style:italic">* : Required</p>
         </form>
    </div>
    <div id="contactPledged">
         <form>
            <label for="datepicker2">*Collect Date</label>
            <input type="text" id="datepicker2" data-validation="required" value="<?php echo date("Y-m-d")?>"/><br>
            <label for="ampl">*Amount Pledged</label>
            <input type="text" id="ampl" data-validation="number" data-validation-allowing="positive"/><br>
            <label for="comments1">Comments</label>
            <textarea name="comments1" id="comments1"></textarea>
            <p style="font-style:italic">* : Required</p>
         </form>
    </div>
    <div id="contactPledgedCB">
         <form>
            <label for="datepicker3">*Collect Date</label>
            <input type="text" id="datepicker3" data-validation="required" value="<?php echo date("Y-m-d")?>"/><br>
            <label for="ampl3">*Amount Pledged</label>
            <input type="text" id="ampl3" data-validation="number" data-validation-allowing="positive"/><br>
            <label for="comments3">Comments</label>
            <textarea name="comments3" id="comments3"></textarea>
             <p style="font-style:italic">* : Required</p>
         </form>
    </div>
    <div id="collect">
        <form>
            <label for="amount_collected">*Amount collected</label>
            <input type="text" id="amount_collected" data-validation="number" data-validation-allowing="positive"/><br>
            <p style="font-style:italic">* : Required</p>
        </form>
    </div>



    
	  
</body>
</html>
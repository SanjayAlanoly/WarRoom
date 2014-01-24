<!DOCTYPE html>
<html lang="en">
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="phpfreechat-2.1.0/client/themes/default/jquery.phpfreechat.min.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/custom-navbar.css" rel="stylesheet">
	<link rel="stylesheet" href="css/flipclock.css">
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
      			<li><a href="../public/home">Home</a></li>
      			<li class="active"><a href="#">War Room</a></li>
      		</ul>
      		<button type="button" class="btn btn-default navbar-btn navbar-right" onclick="location.href='destroySession'">Logout</button>
	  	</div>
	</nav>


	<div class="container board">

		<h1 class="text-center title">War Room</h1>

		<br>

		<div class="row">
			<div class="col-md-9 col-md-offset-3	">
				<div class="your-clock"></div>
			</div>
		</div>

		
		<br>
		
		

		
		<div id="children_supported">
			<?php WarRoom::renderChildrenSupported(); ?>	
		</div>
		
		
		
		<br>

		<div class="pin">
			<br>
			<div class="row">
				<div id = "conv_progress" class="col-md-5">

					<?php WarRoom::render_conv_progress(); ?>
					
				</div>
				<div id = "money_progress" class="col-md-5 col-md-offset-2">

					<?php WarRoom::render_pledged_progress(); ?>
					
				</div>
			</div>

			<div class="row">
				<div class="col-md-3">
					<button id="add_conv" class="btn btn-large btn-primary" type="button" >Add Conversation</button>
				</div>
				<div class="col-md-2 col-md-offset-5">
					<div class="input-group">
					  <span class="input-group-addon">Rs</span>
					  <input id="pledged_amount" type="text" class="form-control pull-right">
					  
					</div>
				</div>		
				<div class="col-md-2">
					<button id="add_pledged" class="btn btn-large btn-primary pull-right " type="button">Add Money Pledged</button>
				</div>
			</div>
		</div>
	
		<br><br>
		
		
		<div class="row">
			<div id="mychat" style="padding-left:20px"><a href="http://www.phpfreechat.net">phpFreeChat: simple Web chat</a></div>
			
		</div>

	</div>

	
	<script src="phpfreechat-2.1.0/client/lib/jquery-1.8.2.min.js" type="text/javascript"></script>
	<script src="phpfreechat-2.1.0/client/jquery.phpfreechat.min.js" type="text/javascript"></script>
	<script src="js/WarRoom.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js"></script>	
	<script src="js/flipclock.min.js"></script>	


    <script type="text/javascript">
  	$('#mychat').phpfreechat({ serverUrl: 'phpfreechat-2.1.0/server' });

/*	var clock = $('.your-clock').FlipClock({
		countdown : true	
	});

	clock.setTime(3600);
	clock.start();
*/
	</script>
</body>
</html>
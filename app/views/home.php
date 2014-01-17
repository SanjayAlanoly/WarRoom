<!DOCTYPE html>
<html lang="en">
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="css/bootstrap.min.css" rel="stylesheet">
	
    	<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>

</head>

<body>

	<div class="container">
		
		<br>
		<h1 class="text-center">CFR War Room</h1>

		<br>
		<div class="row">
			<div id = "conv_progress" class="col-md-6">
				
			</div>
			<div id = "money_progress" class="col-md-6">
				<div class="progress progress-striped active">
				 	 <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
					  		<span class="sr-only">60% Complete</span>
					 </div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<button id="add_conv" class="btn btn-large btn-primary" type="button" >Add Conversation</button>
			</div>
			<div class="col-md-3 col-md-offset-6">
				<button id="pledge_money" class="btn btn-large btn-primary pull-right" type="button">Pledge Money</button>
			</div>
		</div>
	
		<br><br>
		

		

	</div>

	<div id="test">
	</div>

	


	<script src="js/warroom.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js"></script>	

</body>
</html>
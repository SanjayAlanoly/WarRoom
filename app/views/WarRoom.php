<!DOCTYPE html>
<html lang="en">
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="phpfreechat-2.1.0/client/themes/default/jquery.phpfreechat.min.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/custom.css" rel="stylesheet">
    

</head>

<body>

	<div class="container board">
		
		<br>
		
		<h1 class="text-center">CFR War Room</h1>
		
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
	<script src="js/warroom.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js"></script>	

    <script type="text/javascript">
  	$('#mychat').phpfreechat({ serverUrl: 'phpfreechat-2.1.0/server' });
	</script>
</body>
</html>
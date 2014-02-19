<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="phpfreechat-2.1.0/client/themes/default/jquery.phpfreechat.min.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/custom-navbar.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/ui-lightness/jquery-ui-1.10.4.custom.css" media="all" type="text/css" rel="stylesheet">
    <?php include_once("analyticstracking.php") ?>



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
		    <a class="navbar-brand" href="#"><strong>FRaise</strong></a>
	  	</div>
	  	<div class="collapse navbar-collapse" id="navbar-collapse-1">
	  		<ul class="nav navbar-nav">
      			<li><a href="../public/">Home</a></li>
      			<li class="active"><a href="#">War Room</a></li>
      		</ul>
      		<button type="button" class="btn btn-default navbar-btn navbar-right" onclick="location.href='destroySession'">Logout</button>
	  	</div>
	</nav>
<p>

	<div class="container board">

        <div id="countdown_modal" class="modal fade bs-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <p class = "text-center countdown_content" id="countdown_in_modal"></p>
            </div>
          </div>
        </div>


        <h1 class="text-center title">War Room</h1>

        <br>

        <h1 class = "text-center countdown" id="countdown"></h1>

        
        

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

                        
		</div>

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

		
		<br><br>
		
		
		<div class="row">
			<div id="mychat" style="padding-left:20px"><a href="http://www.phpfreechat.net">phpFreeChat: simple Web chat</a></div>
			
		</div>

	</div>
    <div id="addContact">
        <form>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" /><br>
            
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
            
            
        </form>
        
    </div>
    <div id="contactCallback">
         <form>
            <label for="date">Call Date</label>
            <input type="text" id="datepicker1" value="<?php echo date("Y-m-d")?>"/><br><br>
            <label for="comments">Comments</label>
            <textarea name="comments" id="comments"></textarea>
            
    </div>
    <div id="contactCallbackCB">
         <form>
            <label for="date">Call Date</label>
            <input type="text" id="datepicker4" value="<?php echo date("Y-m-d")?>"/><br><br>
            <label for="comments4">Comments</label>
            <textarea name="comments4" id="comments4"></textarea>
            
    </div>
    <div id="contactPledged">
         <form>
            <label for="date">Collect Date</label>
            <input type="text" id="datepicker2" value="<?php echo date("Y-m-d")?>"/><br>
            <label for="date">Amount Pledged</label>
            <input type="text" id="ampl"/><br>
         
            <label for="comments">Comments</label>
            <textarea name="comments1" id="comments1"></textarea>
            
    </div>
    <div id="contactPledgedCB">
         <form>
            <label for="date">Collect Date</label>
            <input type="text" id="datepicker3" value="<?php echo date("Y-m-d")?>"/><br>
            <label for="date">Amount Pledged</label>
            <input type="text" id="ampl3"/><br>
         
            <label for="comments3">Comments</label>
            <textarea name="comments3" id="comments3"></textarea>
            
    </div>
    <div id="collect">
        <form>
            <label for="amount_collected">Amount collected</label>
            <input type="text" id="amount_collected" /><br>
    </div>
    

    <script src="phpfreechat-2.1.0/client/lib/jquery-1.8.2.min.js" type="text/javascript"></script>
    <script src="phpfreechat-2.1.0/client/jquery.phpfreechat.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui-1.10.4.custom.min.js"></script>   
    
    <script src="js/WarRoom.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js"></script> 
	

    
    
    
</body>
</html>

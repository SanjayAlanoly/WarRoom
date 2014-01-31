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
		    <a class="navbar-brand" href="#"><strong>FOE</strong></a>
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

        <div class="panel-group" id="accordion">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                  Collapsible Group Item #1
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
              <div class="panel-body">
                

                 <div class="row" style="margin-top:10px;">
                            <table>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Donation Range</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                </tr>
                                <?php foreach($contacts as $contact): ?>
                                <tr>
                                    <td><?php echo $contact->name?></td>
                                    <td><?php echo $contact->email?></td>
                                    <td><?php echo $contact->phone?></td>
                                    <td><?php echo $contact->status?></td>
                                    <td><?php echo $contact->donation_range?></td>
                                    <td><button onclick="updatecm('pledged',<?php echo $contact->id?>)">Pledge</button></td>
                                    <td><button onclick="updatecm('call_back', <?php echo $contact->id?>)">Call Back</button></td>
                                    <td><button onclick="updatecm('not_interested',<?php echo $contact->id?>)">Not Interested</button></td>
                                </tr>
                                <?php endforeach ?>
                            </table>
                        </div>
                        
                        <h3>Call Back</h3>
                        <div class="row" style="margin-top:10px;">
                            <table>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Call Date</th>
                                    <th>Comments</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                </tr>
                               
                                <?php foreach($callbacks as $cb): ?>
                                <tr>
                                    <td><?php print_r($cb->contactmaster->name) ?></td>
                                    <td><?php print_r($cb->contactmaster->email) ?></td>
                                    <td><?php print_r($cb->contactmaster->phone) ?></td>
                                    <td><?php echo $cb->call_date?></td>
                                    <td><?php echo $cb->comments?></td>
                                    <td><button onclick="updatecb('pledged',<?php echo $cb->id?>)">Pledge</button></td>
                                    <td><button onclick="updatecb('call_back', <?php echo $cb->id?>)">Call Back</button></td>
                                    <td><button onclick="updatecb('not_interested',<?php echo $cb->id?>)">Not Interested</button></td>
                                </tr>
                                <?php endforeach ?>
                            </table>
                             <?php if(count($callbacks)==0): ?>
                                <p>List Empty</p>
                                <?php endif ?>
                        </div>
                        
                        <h3>Pledged</h3>
                        <div class="row" style="margin-top:10px;">
                            <table>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Amount pledged</th>
                                    <th>Collect Date</th>
                                    <th>Comments</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                </tr>
                               
                                <?php foreach($pledged as $pl): ?>
                                <tr>
                                    <td><?php print_r($pl->contactmaster->name) ?></td>
                                    <td><?php print_r($pl->contactmaster->email) ?></td>
                                    <td><?php print_r($pl->contactmaster->phone) ?></td>
                                    <td><?php echo $pl->amount_pledged?></td>
                                    <td><?php echo $pl->collect_date?></td>
                                    <td><?php echo $pl->comments?></td>
                                    <td><button onclick="updatepl('collected', <?php echo $pl->id?>)">Collect</button></td>
                                    <td><button onclick="updatepl('retracted',<?php echo $pl->id?>)">Retract</button></td>
                                </tr>
                                <?php endforeach ?>
                            </table>
                             <?php if(count($pledged)==0): ?>
                                <p>List Empty</p>
                                <?php endif ?>
                        </div>
                        
                        
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-3">
                                <button id="add_contact" class="btn btn-large" type="button">Add Contact</button>
                            </div>
                        </div>



                
              </div>
            </div>
          </div>
        </div>

		<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
		  	Launch demo modal
		</button>

		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
		      </div>
		      <div class="modal-body">


                   


		        
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="button" class="btn btn-primary">Save changes</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	
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
	<script src="js/WarRoom.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js"></script>	
	<script src="js/flipclock.min.js"></script>	
        <script src="<?php echo url('js/jquery-ui-1.10.4.custom.min.js')?>"></script>	

        <link href="<?php echo url('css/ui-lightness/jquery-ui-1.10.4.custom.css') ?>" media="all" type="text/css" rel="stylesheet">
    <script type="text/javascript">
  	$('#mychat').phpfreechat({ serverUrl: 'phpfreechat-2.1.0/server' });

/*	var clock = $('.your-clock').FlipClock({
		countdown : true	
	});

	clock.setTime(3600);
	clock.start();*/

	</script>
    <script type="text/javascript">
            $("#addContact").dialog({
                autoOpen: false,
                height: 300,
                width: 400,
                buttons: {
                    'Save' : function(){
                        $.post("<?php echo url('/WarRoom/addContact')?>",
                        {
                            name: $("#name").val(),
                            email: $("#email").val(),
                            phone: $("#phone").val(),
                            status: 'open',
                            donation_range: $("#donation_range").find(':selected').text()
                        },
                        function(data)
                        {
                            $("#name").val('');
                            $("#email").val('');
                            $("#phone").val('');
                            $("#addContact").dialog("close");
                            location.reload();
                        }
                                
                                )
                    },
                    Cancel: function(){
                        $(this).dialog("close");
                    }
                }
            });
            
            $("#contactCallback").dialog({
                autoOpen: false,
                height:450,
                width: 350,
                buttons: {
                    'Save' : function(){
                        $.post("<?php echo url('/WarRoom/updateContact')?>",
                        {
                            type: 'call_back',
                            id: $(this).data('id'),
                            call_date: $("#datepicker1").val(),
                            comments: $("#comments").val()
                        },
                        function()
                        {
                            $("#datepicker1").val('');
                            $("#comments").val('');
                            $("#contactCallback").dialog("close");
                            location.reload();
                        }
                                
                                );
                        
                    },
                    Cancel: function(){
                        $(this).dialog("close");
                    }
                }
            });
            $("#contactCallbackCB").dialog({
                autoOpen: false,
                height:450,
                width: 350,
                buttons: {
                    'Save' : function(){
                        $.post("<?php echo url('/WarRoom/updateCallback')?>",
                        {
                            type: 'call_back',
                            id: $(this).data('id'),
                            call_date: $("#datepicker4").val(),
                            comments: $("#comments4").val()
                        },
                        function()
                        {
                            $("#datepicker41").val('');
                            $("#comments4").val('');
                            $("#contactCallbackCB").dialog("close");
                            location.reload();
                        }
                                
                                );
                        
                    },
                    Cancel: function(){
                        $(this).dialog("close");
                    }
                }
            });
            
             $("#contactPledged").dialog({
                autoOpen: false,
                height:400,
                width: 380,
                buttons: {
                    'Save' : function(){
                        $.post("<?php echo url('/WarRoom/updateContact')?>",
                        {
                            type: 'pledged',
                            id: $(this).data('id'),
                            collect_date: $("#datepicker2").val(),
                            amount_pledged: $("#ampl").val(),
                            comments: $("#comments1").val()
                        },
                        function()
                        {
                            $("#datepicker1").val('');
                            $("#contactPledged").dialog("close");
                            location.reload();
                        }
                                
                                );
                        
                    },
                    Cancel: function(){
                        $(this).dialog("close");
                    }
                }
            });
             $("#contactPledgedCB").dialog({
                autoOpen: false,
                height:400,
                width: 380,
                buttons: {
                    'Save' : function(){
                        $.post("<?php echo url('/WarRoom/updateCallback')?>",
                        {
                            type: 'pledged',
                            id: $(this).data('id'),
                            collect_date: $("#datepicker3").val(),
                            amount_pledged: $("#ampl3").val(),
                            comments: $("#comments3").val()
                        },
                        function(data)
                        {
                            $("#datepicker3").val('');
                            $("#contactPledgedCB").dialog("close");
                            location.reload();
                        }
                                
                                );
                        
                    },
                    Cancel: function(){
                        $(this).dialog("close");
                    }
                }
            });
             $("#collect").dialog({
                autoOpen: false,
                height:200,
                width: 380,
                buttons: {
                    'Save' : function(){
                        $.post("<?php echo url('/WarRoom/updatePledge')?>",
                        {
                            type: 'collect',
                            id: $(this).data('id'),
                            amount_collected: $("#amount_collected").val()
                        },
                        function(data)
                        {
                            $("#amount_collected").val('');
                            $("#collect").dialog("close");
                            location.reload();
                        }
                                
                                );
                        
                    },
                    Cancel: function(){
                        $(this).dialog("close");
                    }
                }
            });
            
            $( "#datepicker1" ).datepicker( {dateFormat: 'yy-mm-dd' });
            $( "#datepicker2" ).datepicker( {dateFormat: 'yy-mm-dd' });
            $( "#datepicker3" ).datepicker( {dateFormat: 'yy-mm-dd' });
            $( "#datepicker4" ).datepicker( {dateFormat: 'yy-mm-dd' });
            
            $(document).ready(function(){
                $("#add_contact").click(function(){
                    $("#addContact").dialog("open");
                });
                
                
                
            })
            
    </script>
    
    <script type="text/javascript">
    
        function updatecm(type, id)
        {
            switch(type)
            {
                case 'not_interested':
                            if(confirm('Are you sure?'))
                            {
                                
                                $.post('<?php echo url('/WarRoom/updateContact')?>',
                                {
                                    type: 'not_interested',
                                    id: id
                                },
                                function(data)
                                {
                                    location.reload();
                                }
                                );
                            }
                    break;
                case 'call_back': 
                    $("#contactCallback").data('id',id).dialog('open');
                    break;
                    
                case 'pledged':
                    $("#contactPledged").data('id',id).dialog('open');
                    break;
                        
            }
        }
        
        
        function updatecb(type, id)
        {
            switch(type)
            {
                case 'not_interested':
                            if(confirm('Are you sure?'))
                            {
                                
                                $.post('<?php echo url('/WarRoom/updateCallback')?>',
                                {
                                    type: 'not_interested',
                                    id: id
                                },
                                function(data)
                                {
                                    location.reload();
                                }
                                );
                            }
                    break;
                case 'call_back': 
                    $("#contactCallbackCB").data('id',id).dialog('open');
                    break;
                    
                case 'pledged':
                    $("#contactPledgedCB").data('id',id).dialog('open');
                    break;
                        
            }
        }
        
        function updatepl(type, id)
        {
            switch(type)
            {
                case "collected":
                    $("#collect").data('id',id).dialog('open');
                    break;
                case 'retracted':
                    if(confirm('Are you sure?'))
                            {
                                
                                $.post('<?php echo url('/WarRoom/updatePledge')?>',
                                {
                                    type: 'retracted',
                                    id: id
                                },
                                function(data)
                                {
                                    location.reload();
                                }
                                );
                            }
                    
            }
        }
    </script>
    
</body>
</html>
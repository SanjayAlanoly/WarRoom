	function updatecm(type, id)
    {
        switch(type)
        {
            case 'not_interested':
                        if(confirm('Are you sure?'))
                        {
                            
                            $.post("WarRoom/updateContact",
                            {
                                type: 'not_interested',
                                id: id
                            },
                            function(data)
                            {
                                $.get("WarRoom/renderConvList",{},
                                    function(data)
                                        //alert(data);
                                    {

                                        $("#conv_list").html(data);
                                    }
                                )
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
                            
                            $.post('WarRoom/updateCallback',
                            {
                                type: 'not_interested',
                                id: id
                            },
                            function(data)
                            {
                                $.get("WarRoom/renderConvList",{},
                                    function(data)
                                    {
                                        //alert(data);

                                        $("#conv_list").html(data);
                                    }
                                )                                }
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
                            
                            $.post('WarRoom/updatePledge',
                            {
                                type: 'retracted',
                                id: id
                            },
                            function(data)
                             {
                                $.get("WarRoom/renderConvList",{},
                                    function(data)
                                    {
                                        //alert(data);

                                        $("#conv_list").html(data);
                                    }
                                )
                            }
                            );
                        }
                
        }
    }

function init(){

    $.validate();

	$('.list_popover').popover({'html' : true});

	$(document).ready(function() {

		countdownTimer();

		$.ajaxSetup({ cache: false }); 
		setInterval(function() {
			$('#children_supported').load('WarRoom/renderChildrenSupported');
			$('#conv_progress').load('WarRoom/render_conv_progress');
			$('#money_progress').load('WarRoom/render_pledged_progress');
		}, 5000);
	});


	/*$.get("WarRoom/render_conv_progress", function(data) {
    	$("#conv_progress").html(data);
    	window.setTimeout(update, 5000);
  	});

  	$.get("WarRoom/render_pledged_progress", function(data) {
    	$("#money_progress").html(data);
    	window.setTimeout(update, 5000);
  	});
	*/
	

	$("#add_conv").click(function(){

		$.ajax("WarRoom/add_conv",{

			"success" : function(data){

				$("#conv_progress").html(data);

			},
			"error" : function(){

				alert("Can't add conversation now. Please try again");
			}
		})


	});




	$("#add_pledged").click(function(){

		var pledged_amount = $("#pledged_amount").val();



		$.ajax("WarRoom/add_pledged?pledged_amount=" + pledged_amount,{

			"success" : function(data){

				$("#money_progress").html(data);

				

			},
			"error" : function(){

				alert("Can't add pledged money now. Please try again");
			}
		})




	});


	//Redirect to home when modal is closed


	function countdownTimer(){

		
		 
		// variables for time units
		var days, hours, minutes, seconds;
		 
		// get tag element
		var countdown = document.getElementById("countdown");
		 
		// update the tag with id "countdown" every 1 second
		setInterval(function () {
		 
		    // find the amount of "seconds" between now and target
			var now = new Date();

			var start_time = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 20,00,0).getTime();
			var end_time = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 20,20,0).getTime();

			var tom_start_time = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1, 12,15,0).getTime();

			if(now < start_time){

				$('#countdown_modal').modal({keyboard : false, backdrop : 'static'});
				$('#countdown_modal').modal('show');

				var seconds_left = (start_time - now) / 1000;
			 
			    // do some time calculations
			    days = parseInt(seconds_left / 86400);
			    seconds_left = seconds_left % 86400;
			     
			    hours = parseInt(seconds_left / 3600);
			    seconds_left = seconds_left % 3600;
			     
			    minutes = parseInt(seconds_left / 60);
			    seconds = parseInt(seconds_left % 60);
			     
			    // format countdown string + set tag value
			    countdown_in_modal.innerHTML = "War Room starts in <br>" + hours + " hours, "
			    + minutes + " minutes, " + seconds + " seconds"; 

			}else if(now >= start_time && now <=end_time){

				$('#countdown_modal').modal('hide');


				var seconds_left = (end_time - now) / 1000;
			 
			    // do some time calculations
			    days = parseInt(seconds_left / 86400);
			    seconds_left = seconds_left % 86400;
			     
			    hours = parseInt(seconds_left / 3600);
			    seconds_left = seconds_left % 3600;
			     
			    minutes = parseInt(seconds_left / 60);
			    seconds = parseInt(seconds_left % 60);
			     
			    // format countdown string + set tag value
			    countdown.innerHTML = hours + "h : "
			    + minutes + "m : " + seconds + "s"; 


			}else{

/*				var seconds_left = (tom_start_time - now) / 1000;
			 
			    // do some time calculations
			    days = parseInt(seconds_left / 86400);
			    seconds_left = seconds_left % 86400;
			     
			    hours = parseInt(seconds_left / 3600);
			    seconds_left = seconds_left % 3600;
			     
			    minutes = parseInt(seconds_left / 60);
			    seconds = parseInt(seconds_left % 60);
			     
			    // format countdown string + set tag value
			    countdown.innerHTML = "Next War Room starts in " + hours + "H, "
			    + minutes + "M, " + seconds + "S"; */

			    countdown.innerHTML = "War Room Closed"


			}
 
		 
		}, 1000);
	}

	
  	$('#mychat').phpfreechat({ 
        refresh_delay : 2000,
        focus_on_connect : false,
        serverUrl: 'phpfreechat-2.1.0/server' });




    $("#addContact").dialog({
        autoOpen: false,
        height: 300,
        width: 400,
        buttons: {
            'Save' : function(){

                $("#addContact").dialog("close");

                $.post("WarRoom/addContact",
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


                        $.get("WarRoom/renderConvList",{},
                            function(data)
                            {
                                //alert(data);

                                $("#conv_list").html(data);

                            }
                        )

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
        height:300,
        width: 350,
        buttons: {
            'Save' : function(){

                $("#contactCallback").dialog("close");

                $.post("WarRoom/updateContact",
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

                        $.get("WarRoom/renderConvList",{},
                            function(data)
                            {
                                //alert(data);

                                $("#conv_list").html(data);
                            }
                        )
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
        height:300,
        width: 350,
        buttons: {
            'Save' : function(){

                $("#contactCallbackCB").dialog("close");

                $.post("WarRoom/updateCallback",
                    {
                        type: 'call_back',
                        id: $(this).data('id'),
                        call_date: $("#datepicker4").val(),
                        comments: $("#comments4").val()
                    },
                    function()
                    {
                        $("#datepicker4").val('');
                        $("#comments4").val('');

                        $.get("WarRoom/renderConvList",{},
                            function(data)
                            {
                                //alert(data);

                                $("#conv_list").html(data);
                            }
                        )
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
        height:350,
        width: 390,
        buttons: {
            'Save' : function(){

                $("#contactPledged").dialog("close");

                $.post("WarRoom/updateContact",
                    {
                        type: 'pledged',
                        id: $(this).data('id'),
                        collect_date: $("#datepicker2").val(),
                        amount_pledged: $("#ampl").val(),
                        comments: $("#comments1").val()
                    },
                    function()
                    {
                        $("#datepicker2").val('');
                        $("#ampl").val('');
                        $("#comments1").val('');

                        $.get("WarRoom/renderConvList",{},
                            function(data)
                            {
                                //alert(data);

                                $("#conv_list").html(data);
                            }
                        )
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
        height:350,
        width: 390,
        buttons: {
            'Save' : function(){

                $("#contactPledgedCB").dialog("close");

                $.post("WarRoom/updateCallback",
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
                        $("#ampl3").val('');
                        $("#comments3").val('');

                        $.get("WarRoom/renderConvList",{},
                            function(data)
                            {
                                //alert(data);

                                $("#conv_list").html(data);
                            }
                        )
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
        height:250,
        width: 380,
        buttons: {
            'Save' : function(){

                $("#collect").dialog("close");

                $.post("WarRoom/updatePledge",
                    {
                        type: 'collect',
                        id: $(this).data('id'),
                        amount_collected: $("#amount_collected").val()
                    },
                    function(data)
                    {
                        $("#amount_collected").val('');

                        $.get("WarRoom/renderConvList",{},
                            function(data)
                            {
                                //alert(data);

                                $("#conv_list").html(data);
                            }
                        )
                    }

                );

            },
            Cancel: function(){
                $(this).dialog("close");
            }
        }
    });

    $( "#datepicker1" ).datepicker( {dateFormat: 'yy-mm-dd', minDate : 0 });
    $( "#datepicker2" ).datepicker( {dateFormat: 'yy-mm-dd', minDate : 0 });
    $( "#datepicker3" ).datepicker( {dateFormat: 'yy-mm-dd', minDate : 0 });
    $( "#datepicker4" ).datepicker( {dateFormat: 'yy-mm-dd', minDate : 0 });

    $(document).ready(function(){
        $("#add_contact").click(function(){
            $("#addContact").dialog("open");
        });



    });

    







}
$(init);
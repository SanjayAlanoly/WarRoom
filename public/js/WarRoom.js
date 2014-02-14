function init(){


	$('.list_popover').popover({'html' : true});

	$(document).ready(function() {

		countdownTimer();

		$.ajaxSetup({ cache: false }); 
		setInterval(function() {
			$('#children_supported').load('WarRoom/renderChildrenSupported');
			$('#conv_progress').load('WarRoom/render_conv_progress');
			$('#money_progress').load('WarRoom/render_pledged_progress');
		}, 3000); 
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

			var start_time = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 12,00,0).getTime();
			var end_time = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 21,00,0).getTime();

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






}
$(init);
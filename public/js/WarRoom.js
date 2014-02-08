function init(){


	$(document).ready(function() {
		$.ajaxSetup({ cache: false }); 
		setInterval(function() {
		$('#children_supported').load('WarRoom/renderChildrenSupported');
		}, 3000); 
	});

	$(document).ready(function() {
		$.ajaxSetup({ cache: false }); 
		setInterval(function() {
		$('#conv_progress').load('WarRoom/render_conv_progress');
		}, 3000); 
	});

	$(document).ready(function() {
		$.ajaxSetup({ cache: false }); 
		setInterval(function() {
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






}
$(init);
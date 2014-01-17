function init(){

	

	$("#add_conv").click(function(){

		$.ajax("WarRoom/add_conv",{

			"success" : function(data){

				$("#conv_progress").html(data);

			},
			"error" : function(){

				alert("Can't add conversation now. Please try again");
			}
		})


	})


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




	})




}
$(init);
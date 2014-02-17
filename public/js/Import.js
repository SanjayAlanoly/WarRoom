function init(){

	$("#cities_dropdown").change(function(){

		var choice = $("#cities_dropdown").val();

		//alert(choice);

		$.get("Import/getVolunteers?choice=" + choice,{},function(data){

			$("#volunteers_dropdown").html(data);


		})
	})


}
$(init);
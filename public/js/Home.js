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
                            )                                }
                        );
                    }
            
    }
}

function init(){

    $.validate();

	$('#myTab a').click(function (e) {
	  e.preventDefault()
	  $(this).tab('show')
	});

	$('#myTab2 a').click(function (e) {
	  e.preventDefault()
	  $(this).tab('show')
	});

	$('.list_popover').popover({'html' : true});

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
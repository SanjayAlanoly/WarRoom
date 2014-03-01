<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="ihhUtEI6HzxmcIqIGqJnUP9f0t8ztbawetksOIKpaPA" />

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/custom-navbar.css" rel="stylesheet">
    <link href="../css/custom.css" rel="stylesheet">

    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>


    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

        // Load the Visualization API and the piechart package.
        google.load('visualization', '1.0', {'packages':['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.setOnLoadCallback(drawChart);

        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawChart() {
            var chart_raised = google.visualization.arrayToDataTable([

                ['Date', 'Amount Raised'],

                <?php

                for($d=30; $d>=0; $d--){

                    $date_compare = new DateTime("now - $d days");
                    $date_compare = $date_compare->format('Y-m-d');


                    $raised_sum = 0;
                    $pledged_sum = 0;
                    $conversation_sum = 0;

                    foreach($volunteer_amount_raised as $donation){

                        if($date_compare == $donation->created_at){

                            $raised_sum += $donation->donation_amount;

                        }

                    }


                    foreach($volunteer_conversations as $conversation){

                        if($date_compare == $conversation->first_updated_at){

                            $conversation_sum++;

                        }

                    }


                    echo "['$date_compare',$raised_sum],";



                }

                ?>

            ]);

            var chart_raised_options = {
                title: 'Amount raised per day',
                'backgroundColor':'#ffe800',
                'titleTextStyle' : {fontSize:16},
                'animation.duration' : 100,
                'exlorer' : {}
            };

            var raised = new google.visualization.LineChart(document.getElementById('chart_div'));
            raised.draw(chart_raised, chart_raised_options);

            function resizeHandler () {
                raised.draw(chart_raised, chart_raised_options);
            }
            if (window.addEventListener) {
                window.addEventListener('resize', resizeHandler, false);
            }
            else if (window.attachEvent) {
                window.attachEvent('onresize', resizeHandler);
            }

    }
    </script
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
            <a class="navbar-brand" href="#">FRaise</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a target="_blank" href="../public/WarRoom">War Room</a></li>
            </ul>
            <button type="button" class="btn btn-default navbar-btn navbar-right" onclick="location.href='destroySession'">Logout</button>
        </div>
    </nav>

    <div class="container board">

        <h2 class="sub_title text-center"><?php echo "$volunteer->first_name $volunteer->last_name"?></h2>

        <br>

        <div class = "row">

            <div class="col-md-5">
                <p class="normal">Phone : <?php echo $volunteer->phone_no;?></p>
                <p class="normal">Conversations : <?php echo $volunteer->conv_count;?></p>
                <p class="normal">Amount Pledged : <?php echo $volunteer->amount_pledged;?></p>
            </div>
            <div class="col-md-4 col-md-offset-3">
                <p class="normal">Email : <?php echo $volunteer->email;?></p>
                <p class="normal">Donors : <?php echo $volunteer->count;?></p>
                <p class="normal">Amount Raised : <?php echo $volunteer->amount;?></p>
            </div>
        </div>

        <div id="chart_div"></div>

    </div>



</body>
</html>


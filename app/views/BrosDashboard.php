<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="ihhUtEI6HzxmcIqIGqJnUP9f0t8ztbawetksOIKpaPA" />

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom-navbar.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css"/>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-multiselect.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.multiselect').multiselect({
                enableCaseInsensitiveFiltering: true,
                maxHeight: 300,
                buttonWidth: '100%'

            });
        });
    </script>

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

            <?php
                foreach($bro_teams as $bro_team){
                    echo "var chart_data_$bro_team->id = new google.visualization.DataTable();";
                    echo "chart_data_$bro_team->id.addColumn('string','Date');";
                    echo "chart_data_$bro_team->id.addColumn('number','Raised');";
                    echo "chart_data_$bro_team->id.addColumn({type:'boolean',role:'certainty'});";
                    echo "chart_data_$bro_team->id.addRows([";
                    BrosDashboard::returnChartData($bro_team->id);
                    echo "]);";

                    echo "var chart_options_$bro_team->id = {
                            title: 'Amount Raised',
                            'backgroundColor':'#ffe800',
                            'titleTextStyle' : {fontSize:16},
                            'animation.duration' : 100,
                            'exlorer' : {}
                        };";

                    echo "var chart_visual_$bro_team->id = new google.visualization.LineChart(document.getElementById('chart_div_$bro_team->id'));
                            chart_visual_$bro_team->id.draw(chart_data_$bro_team->id, chart_options_$bro_team->id);

                            function resizeHandler () {
                                chart_visual_$bro_team->id.draw(chart_data_$bro_team->id, chart_options_$bro_team->id);
                            }
                            if (window.addEventListener) {
                                window.addEventListener('resize', resizeHandler, false);
                            }
                            else if (window.attachEvent) {
                                window.attachEvent('onresize', resizeHandler);
                            }";
                }
            ?>



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
            <li><a href=".">Home</a></li>
            <li><a target="_blank" href="WarRoom">War Room</a></li>
            <li><a href="CoachDashboard">Coach Dashboard</a></li>
            <li class="active"><a href="">Bros Dashboard</a></li>
        </ul>
        <button type="button" class="btn btn-default navbar-btn navbar-right" onclick="location.href='destroySession'">Logout</button>
    </div>
</nav>

<div class="container board">

    <h1 class="title text-center">Bros Dashboard</h1>

    <br>

    <p class="normal">Total Amount Raised : <?php echo "Rs. " . number_format($mad_amount_raised[0]->amount_raised); ?></p>
    <p class="normal">Total Amount Pledged : <?php echo "Rs. " . number_format($mad_pledged[0]->amount_pledged); ?></p>
    <!--<p class="normal">Total Conversations : <?php /*echo $mad_conversations[0]->count; */?></p>-->

    <br>

    <h2 class='sub_title_left'>Select Bro Teams : </h2>

    <form action='BrosDashboard/saveBroTeams' method='post' enctype='multipart/form-data' class="form-inline" role="form">

        <select name='bro_team' class="form-control">

            <?php
                foreach($bro_teams as $bro_team){
                    echo "<option value=\"$bro_team->id\">$bro_team->name</option>";
                }
            ?>

        </select>



        <select name='volunteers[]' class="multiselect form-control" multiple="multiple">

            <?php
                foreach($volunteers_list as $volunteer){
                    echo "<option value=\"$volunteer->id\">$volunteer->first_name $volunteer->last_name ($volunteer->city_name) ($volunteer->phone_no)</option>";
                }
            ?>

        </select>

        <button type='submit' class='btn btn-primary'>SAVE</button>
    </form>

    <br>



    <?php
        foreach($bro_teams as $bro_team){

            $data = BrosDashboard::returnTeamOverall($bro_team->id);

            echo "<h2 class='sub_title text-center'>$bro_team->name</h2>";

            echo "<div id=\"chart_div_$bro_team->id\"></div>";

            echo "<div class='row'>";

            echo "<div class='col-md-5'>";

            echo " <h2 class='sub_title_left'>Overall : </h2>";
            echo "<p class='normal'>Amount Raised : Rs. " . number_format($data['raised']) . " / " . number_format($data['should_have_raised']) . "</p>";
            echo "<p class='normal'>Amount Pledged : Rs. " . number_format($data['pledged']) . "</p>";
            echo "<p class='normal'>Run Rate (Avg of past 7 days) : Rs. " . number_format($data['run_rate']) . "</p>";
            echo "<p class='normal'>Target : Rs. " . number_format($data['target']) . "</p>";
            echo "<p class='normal'>Interns : " . number_format($data['interns']) . "</p>";
            echo "<p class='normal'>Sparta Days Remaining : " . number_format($data['sparta_day_remaining']) . "</p>";


            echo "</div>";



            echo "<div class='col-md-4 col-md-offset-3'>";

            echo " <h2 class='sub_title_left'>Yesterday : </h2>";

            echo "<p class='normal'>Calls : " . $data['coached_yesterday'] . "/" . $data['sparta_yesterday'] . "</p>";
            echo "<p class='normal'>Raised : Rs. " . number_format($data['raised_yesterday'])  . "</p>";
            echo "<p class='normal'>Pledged : Rs. " . number_format($data['pledged_yesterday']) . "</p>";

            echo "</div></div>";

            echo "<br>";

            $bro_team_members = BrosDashboard::returnBroTeamMembers($bro_team->id);

            echo "<table>";
            echo "<tr><th class='big'>Name</th><th class='big'>Phone No</th><th class='big'>Raised</th><th class='big'>Pledged</th><th class='big'>Overall Target</th><th class='big'>Target Count</th><th class='big'>Interns</th><th class='big'>Last Login</th></tr>";


            foreach($bro_team_members as $member){

                $raised = number_format($member->group_raised + $member->coach_raised);
                $pledged = number_format($member->group_pledged + $member->coach_pledged);
                $should_have_raised = number_format($member->should_have_raised);

                echo "<tr><td>$member->first_name $member->last_name</td><td>$member->phone_no</td><td>$raised / $should_have_raised</td><td>$pledged</td><td>$member->coach_target</td><td>$member->target_count/$member->interns</td><td>$member->interns</td><td>$member->last_login</td></tr>";

            }

            echo "</table>";





        }


    ?>

    <br>
    <div  class="text-center">
        <a href="DeleteDonation">Delete Donation</a>
    </div>

</div>
</body>
</html>

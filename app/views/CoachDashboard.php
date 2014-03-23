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
                <li class="active"><a href="">Coach Dashboard</a></li>
                <li><a href="BrosDashboard">Bros Dashboard</a></li>
            </ul>
            <button type="button" class="btn btn-default navbar-btn navbar-right" onclick="location.href='destroySession'">Logout</button>
        </div>
    </nav>

    <div class="container board">

        <?php




            echo "<h1 class=\"title text-center\">Coach Dashboard</h1><br>";

           /* echo "<h2 class='sub_title_left'>Yesterday : </h2>";

            echo "<p class='normal'>Number of coach calls made : 3/4</p>";
            echo "<p class='normal'>Amount of money pledged by FRaisers : 2000/3000</p>";
            echo "<p class='normal'>Amount of money raised by FRaisers : 1000/2000</p>";

            echo "<br><h2 class='sub_title_left'>Today : </h2>";

            echo "<p class='normal'>Number of calls I have to make today : 3</p>";
            echo "<p class='normal'>Amount pledged to hit today : 1000</p>";
            echo "<p class='normal'>Amount raised to hit today : 500</p>";*/

            echo "<h2 class='sub_title_left'>Overall (INCL COACH) : </h2>";
            echo "<p class='normal'>Total Amount Raised : " . $overall_raised_actual . "</p>";
            echo "<p class='normal'>Total Amount Pledged : " . $overall_pledged_actual . "</p>";
            echo "<p class='normal'>Total Converstaions : " . $overall_conversations_actual . "</p>";


            echo "<form action='CoachDashboard/saveVolunteers' method='post' enctype='multipart/form-data'>";

            echo "<br><h2 class='sub_title_left'>Select your FRaisers : </h2><select  name = 'selected_volunteers[]' class='multiselect' multiple='multiple'>";

            foreach($all_volunteers_list as $volunteer){

                if(isset($volunteer->selected)){
                    echo "<option value=\"$volunteer->id\" selected>$volunteer->first_name $volunteer->last_name ($volunteer->city_name)</option>";
                }else{
                    echo "<option value=\"$volunteer->id\">$volunteer->first_name $volunteer->last_name ($volunteer->city_name)</option>";
                }


            }

            echo "</select>";

            echo "<button type='submit' class='btn btn-primary'>SAVE</button>";

            echo "</form><br><br>";

            echo "<table>";
            echo "<tr><th class='big'>Name</th><th class='big'>Phone</th><th class='big'>Raised</th><th class='big'>Pledged</th><th class='big'>Should have Raised</th><th class='big'>Target</th><th class='big'>Next Sparta Day</th><th class='big'>Last Login</th></tr>";


            foreach($volunteers_list as $volunteer){

                echo "<tr><td><a href=\"Volunteer/$volunteer->id\">$volunteer->first_name $volunteer->last_name</a></td><td>$volunteer->phone_no</td><td>$volunteer->amount_raised</td><td>$volunteer->amount_pledged</td><td>$volunteer->should_have_raised</td><td>$volunteer->overall_target</td><td>$volunteer->next_sparta_day</td><td>$volunteer->last_login</td></tr>";


            }

            echo "</table>";
            echo "<br><br><br>";





        ?>


    </div>


</body>

</html>


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
            <li><a href="CoachDashboard">Coach Dashboard</a></li>
            <li class="active"><a href="">Bros Dashboard</a></li>
        </ul>
        <button type="button" class="btn btn-default navbar-btn navbar-right" onclick="location.href='destroySession'">Logout</button>
    </div>
</nav>

<div class="container board">

    <h1 class="title text-center">Bros Dashboard</h1>

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
                    echo "<option value=\"$volunteer->id\">$volunteer->first_name $volunteer->last_name ($volunteer->city_name)</option>";
                }
            ?>

        </select>

        <button type='submit' class='btn btn-primary'>SAVE</button>
    </form>

    <br>

    <?php
        foreach($bro_teams as $bro_team){
            echo "<h2 class='sub_title text-center'>$bro_team->name</h2>";
            echo "<p class='normal'>Total Amount Raised : " . BrosDashboard::returnTeamOverall($bro_team->id) . "</p>";
        }
    ?>

</div>
</body>
</html>

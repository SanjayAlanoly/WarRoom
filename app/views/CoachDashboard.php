<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="ihhUtEI6HzxmcIqIGqJnUP9f0t8ztbawetksOIKpaPA" />

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom-navbar.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
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

        <?php



            echo "<h2></h2>";

            echo "<table>";
            echo "<tr><th>Name</th><th>Phone No</th><th>FRaised</th><th>Pledged</th><th>Donors</th><th>Conversations</th></tr>";


            foreach($volunteers_list as $volunteer){

                echo "<tr><td><a>$volunteer->first_name $volunteer->last_name</a></td><td>$volunteer->phone_no</td><td>$volunteer->amount</td><td>$volunteer->amount_pledged</td><td>$volunteer->count</td><td>$volunteer->conv_count</td></tr>";


            }

            echo "</table>";
            echo "<br><br><br>";





        ?>


    </div>


</body>

</html>


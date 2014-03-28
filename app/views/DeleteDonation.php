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
            <li><a href=".">Home</a></li>
            <li><a target="_blank" href="WarRoom">War Room</a></li>
            <li><a href="CoachDashboard">Coach Dashboard</a></li>
            <li><a href="BrosDashboard">Bros Dashboard</a></li>
        </ul>
        <button type="button" class="btn btn-default navbar-btn navbar-right" onclick="location.href='destroySession'">Logout</button>
    </div>
</nav>

<div class="container board">

    <h1 class="title text-center">Delete Donations</h1>

    <form action="DeleteDonation/submitID" method="post" enctype="multipart/form-data" role="form">
        <div class="form-group">
            <label for="donation_id">Donation IDs</label>
            <input type="text" class="form-control" id="donation_id" name="donation_id" placeholder="Enter Donation IDs separated by comma">
        </div>


        <div class="text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

    <?php

        if($message = Session::get('message')){
            echo "<br>";
            echo "<p class='normal text-center'>" . $message . "</p>";
        }
    ?>


</div>
</body>
</html>
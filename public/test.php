<?php
require('../../../../iframe/common.php');

showTop('Travel Calender');
echo '<link href="css/calendar.css" type="text/css" rel="stylesheet" />';
echo '<h2>Travel Calender</h2>';

$cal = new Calendar("daily");
$cal->display();

showEnd();

function daily($year, $month, $day) {
print "$year-$month-$day"; //This thing goes in every calendar day box.
}
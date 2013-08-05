<?php
require_once('connect.php');

mysql_select_db("highcharts", $con);

$result = mysql_query("SELECT * FROM highcharts_php");

while($row = mysql_fetch_array($result)) {
  echo $row['timespan'] . "\t" . $row['visits']. "\t" . $row['sales']. "\n";
}

mysql_close($con);
?> 
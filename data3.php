<?php
require_once('connect.php');
mysql_select_db("highcharts", $con);

mysql_select_db("highcharts", $con);

$query = mysql_query("SELECT month, wordpress, codeigniter, highcharts FROM project_requests");

$category = array();
$category['name'] = 'Month';

$series1 = array();
$series1['name'] = 'Wordpress';

$series2 = array();
$series2['name'] = 'CodeIgniter';

$series3 = array();
$series3['name'] = 'Highcharts';

while($r = mysql_fetch_array($query)) {
    $category['data'][] = $r['month'];
    $series1['data'][] = $r['wordpress'];
    $series2['data'][] = $r['codeigniter'];
    $series3['data'][] = $r['highcharts'];   
}

$result = array();
array_push($result,$category);
array_push($result,$series1);
array_push($result,$series2);
array_push($result,$series3);

print json_encode($result, JSON_NUMERIC_CHECK);

mysql_close($con);
?>
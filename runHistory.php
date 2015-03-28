<?php
include 'services/HistoryService.php';

$history = new HistoryService();


$yesterday = time() - (1 * 24 * 60 * 60); 
$today_3_hours_ago = time() - (3 *60*60);
$today = time(); 

/*echo "<h1> Bucuresti </h1>";
$history->feed('bucuresti',$today_3_hours_ago,$today );

echo "<h1> Cluj </h1>";
$history->feed('cluj',$today_3_hours_ago,$today );

echo "<h1> Timisoara </h1>";
$history->feed('timisoara',$today_3_hours_ago,$today );*/


$servername = getenv('IP');
$username = getenv('C9_USER');
$password = "";
$database = "c9";
$dbport = 3306;

// Create connection
$db = new mysqli($servername, $username, $password, $database, $dbport);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
} 
echo "Connected successfully (".$db->host_info.")";
    
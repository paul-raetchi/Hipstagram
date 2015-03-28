<?php
include 'services/HistoryService.php';

$history = new HistoryService();

$today = time();
$today_8_hours_ago = $today - 8*3600;

$start_of_year = time()  - 90*24*60*60;

while ($today > $start_of_year){
    echo "Getting photos from ".date('Y-m-d H:i:s',$today_8_hours_ago)." to ".date('Y-m-d H:i:s',$today)." for Cluj.\n";
    $history->feed('cluj',$today_8_hours_ago,$today );
    
    echo "Getting photos from ".date('Y-m-d H:i:s',$today_8_hours_ago)." to ".date('Y-m-d H:i:s',$today)." for Bucuresti.\n";
    $history->feed('bucuresti',$today_8_hours_ago,$today );

    echo "Getting photos from ".date('Y-m-d H:i:s',$today_8_hours_ago)." to ".date('Y-m-d H:i:s',$today)." for Timisoara.\n";
    $history->feed('timisoara',$today_8_hours_ago,$today );
    
    $today = $today - 24*3600;
    $today_8_hours_ago =  $today - 8*3600;
}

/*$yesterday = time() - (1 * 24 * 60 * 60); 
$today_3_hours_ago = time() - (3 *60*60);
$today = time(); */

/*echo "<h1> Bucuresti </h1>";
$history->feed('bucuresti',$today_3_hours_ago,$today );*/

/*
echo "<h1> Cluj </h1>";
$history->feed('cluj',$today_3_hours_ago,$today );

echo "<h1> Timisoara </h1>";
$history->feed('timisoara',$today_3_hours_ago,$today );*/



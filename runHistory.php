<?php
include 'services/HistoryService.php';

$history = new HistoryService();


$yesterday = time() - (1 * 24 * 60 * 60); 
$today_3_hours_ago = time() - (3 *60*60);
$today = time(); 

$history->feed('bucuresti',$today_3_hours_ago,$today);

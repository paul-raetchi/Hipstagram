<?php
include ('services/ProcessingService.php');

$proc = new ProcessingService('pics/sample-image1.jpg');
$proc->process();

//if ($proc)  echo "face";

?>

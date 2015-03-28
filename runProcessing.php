<?php
include ('services/ProcessingService.php');

$proc = new ProcessingService('pics/sample-image1.jpg');
$proc->process();

$proc->displayImage();

?>

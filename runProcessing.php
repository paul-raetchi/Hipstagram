<?php
include ('services/ProcessingService.php');

$data= file_get_contents('http://i1.wp.com/scontent.cdninstagram.com/hphotos-xaf1/t51.2885-15/e15/11024130_346652568877084_698519389_n.jpg');
echo $data;
die();
$proc = new ProcessingService('pics/sample-image1.jpg');
print_r($proc->process());

//$proc->displayImage();

?>
¬
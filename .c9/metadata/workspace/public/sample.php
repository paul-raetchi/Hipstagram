{"changed":true,"filter":false,"title":"sample.php","tooltip":"/public/sample.php","value":"<?php\ninclude('lib/color_difference.class.php');\n\n$palette = array(\n  '00' => array(255, 255, 255),\n  '01' => array(0, 0, 0),\n  '02' => array(0, 0, 139),\n  '03' => array(0, 128, 0),\n  '04' => array(255, 0, 0),\n  '05' => array(139, 0, 0),\n  '06' => array(128, 0, 128),\n  '07' => array(255, 165, 0),\n  '08' => array(255, 255, 0),\n  '09' => array(50, 205, 50),\n  '10' => array(0, 128, 128),\n  '11' => array(173, 216, 230),\n  '12' => array(0, 0, 255),\n  '13' => array(255, 105, 180),\n  '14' => array(128, 128, 128),\n  '15' => array(211, 211, 211),\n);\n\n$color_rgb = array(255, 255, 128);\n$color_delta_e = new color_difference($color_rgb);\n$match_index = $color_delta_e->getClosestMatch($palette);\n$color = $palette[$match_index];","undoManager":{"mark":-1,"position":0,"stack":[[{"group":"doc","deltas":[{"start":{"row":0,"column":0},"end":{"row":25,"column":32},"action":"insert","lines":["<?php","include('lib/color_difference.class.php');","","$palette = array(","  '00' => array(255, 255, 255),","  '01' => array(0, 0, 0),","  '02' => array(0, 0, 139),","  '03' => array(0, 128, 0),","  '04' => array(255, 0, 0),","  '05' => array(139, 0, 0),","  '06' => array(128, 0, 128),","  '07' => array(255, 165, 0),","  '08' => array(255, 255, 0),","  '09' => array(50, 205, 50),","  '10' => array(0, 128, 128),","  '11' => array(173, 216, 230),","  '12' => array(0, 0, 255),","  '13' => array(255, 105, 180),","  '14' => array(128, 128, 128),","  '15' => array(211, 211, 211),",");","","$color_rgb = array(255, 255, 128);","$color_delta_e = new color_difference($color_rgb);","$match_index = $color_delta_e->getClosestMatch($palette);","$color = $palette[$match_index];"]}]}]]},"ace":{"folds":[],"scrolltop":0,"scrollleft":0,"selection":{"start":{"row":25,"column":32},"end":{"row":25,"column":32},"isBackwards":false},"options":{"guessTabSize":true,"useWrapMode":false,"wrapToView":true},"firstLineState":0},"timestamp":1427551808187}
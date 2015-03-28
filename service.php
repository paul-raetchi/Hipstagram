<?php

$from = $_GET['from'];
$to = $_GET['to'];

// Create connection
$db = new mysqli(getenv('IP'), getenv('C9_USER'), "", "hipstagram", 3306);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$data = mysqli_query($db, "SELECT city, AVG(white) as white,
      AVG(black) as black,
      AVG(navyblue) as navyblue,
      AVG(green) as green,
      AVG(red) as red,
      AVG(darkred) as darkred,
      AVG(purple) as purple,
      AVG(orange) as orange,
      AVG(yellow) as yellow,
      AVG(limegreen) as limegreen,
      AVG(teal) as teal,
      AVG(aqualight) as aqualight,
      AVG(royalblue) as royalblue,
      AVG(hotpink) as hotpink,
      AVG(darkgrey) as darkgrey,
      AVG(lightgrey) as lightgrey
      from bigdata JOIN location on location.id = bigdata.location
      GROUP BY city DESC

      ");
$retArray = array();

foreach($data as $row) {
    $retArray[] = $row;
}

echo json_encode($retArray);

<?php
    // Create connection
    $IP = getenv('IP');
    $C9_USER = getenv('C9_USER');
    $con=mysqli_connect($IP, $C9_USER, "", "c9");

    //mysqli_connect(host,username,password,dbname); << guideline

    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
?>
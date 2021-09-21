<?php

// Get date and time variables
// date_default_timezone_set('Africa/Kigali');  // for other timezones, refer:- https://www.php.net/manual/en/timezones.asia.php
    // $d = date("Y-m-d");
    // $t = date("H:i");

if(isset($_POST["send_t"], $_POST["send_h"], $_POST["s_moisture"])) {

   $temp = $_POST["send_t"]; 
   $hum = $_POST["send_h"];
   $s_moisture = $_POST["s_moisture"];

//    echo $temp + ", " + $hum + ", " + $s_moisture;
    $servername = "localhost:3308";
    $username = "root";
    $password = "";
    $dbname = "agriculture";

   // Create connection
   $conn = new mysqli($servername, $username, $password, $dbname);
   // Check connection
   if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
   }

   $sql = "INSERT INTO data (temp, hum, soil_moisture) VALUES ($temp, $hum, $s_moisture)";

   if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
   } else {
      echo "Error: " . $sql . " => " . $conn->error;
   }

   $conn->close();
} else {
   echo "temperature is not set";
}
?>
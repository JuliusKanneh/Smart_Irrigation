<?php

    $servername = "localhost:3308";
    $username = "root";
    $password = "";
    $dbname = "agriculture";

   // Create connection
   $conn = new mysqli($servername, $username, $password, $dbname);
   // Check connection

   $update_query = "UPDATE irrigation_status SET status = 0 ORDER BY rollno DESC LIMIT 1";

   if ($conn->query($update_query) === TRUE) {
      echo "New record created successfully";
   } else {
      echo "Error: " . $sql . " => " . $conn->error;
   }

   $conn->close();

?>
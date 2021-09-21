<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
// define('DB_SERVER', "localhost");
// define('DB_USERNAME', "root");
// define('DB_PASSWORD', "");
// define('DB_NAME', "agriculture");
 
/* Attempt to connect to MySQL database */
// $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
// if($link === false){
//     die("ERROR: Could not connect. " . mysqli_connect_error());
// }

    $serverName = "localhost:3308";
    $userName = "root";
    $password = "";
    $dbName = "agriculture";

    //creat connection
    $conn = new mysqli($serverName,$userName, $password, $dbName);

    if($conn){
        // echo"Connected Successfully";
    }else{
        echo "Failed to connect!";
    }
    
    // $query = "select * FROM data ORDER BY rollno DESC LIMIT 1";
    // $res = mysqli_query($conn, $query);
    // $data = mysqli_fetch_array($res);
    // $temp = $data['temp'];

                    
?>
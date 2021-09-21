<?php 
    $serverName = "localhost:3308";
    $userName = "root";
    $password = "";
    $dbName = "agriculture";

    //creat connection
    $conn = new mysqli($serverName,$userName, $password, $dbName);

    $query = "select * FROM irrigation_status WHERE rollno = 6";
    $res = mysqli_query($conn, $query);
    $data = mysqli_fetch_array($res);

    $i_status = $data['status'];

    echo $i_status;

?>
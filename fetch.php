<?php
$query = "select * FROM data ORDER BY rollno DESC LIMIT 1";
$res = mysqli_query($conn, $query);
$data = mysqli_fetch_array($res);

$query1 = "Select * FROM irrigation_status ORDER BY rollno DESC LIMIT 1";
$res1 = mysqli_query($conn, $query1);
$data1 = mysqli_fetch_array($res1);

$temp = $data['temp'];
$hum = $data['hum'];
$soil_moisture = $data['soil_moisture'];
$i_status = $data1['status'];
$_trigger_status;

// if($i_status == 1){
//     $_trigger_status = "ON";
// }else{
//     $_trigger_status = "OFF";
// }

if ($soil_moisture >= 700) {
    $_trigger_status = "ON";
} else {
    $_trigger_status = "OFF";
}
?>

<script>
    function irragationTrigger() {
        var trig_status = document.getElementById("switch");
        if (trig_status.checked == true) {
            document.getElementById("trigger").innerHTML = "ON";
            // alert("Trigger On");
            fetch("http://localhost/Smart_Agri/irrigation_on.php");
        } else {
            document.getElementById("trigger").innerHTML = "OFF";
            // alert("Trigger OFf");
            fetch("http://localhost/Smart_Agri/irrigation_off.php");
        }
    }

    function FetchData() {
        fetch("http://localhost/test/fetch.php")
            .then((res1) => res1.text())
            .then((data) => {
                if (status == 1) {
                    testnode.checked = true;
                } else {
                    testnode.checked = false;
                }

            });
    }
</script>
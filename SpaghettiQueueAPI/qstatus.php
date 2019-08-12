<?php
if (file_exists("config.php")) {
    require "config.php";
}
else {
    die("Error: Config file not found, make sure to have run the setup file first");
}
$uuid = $_POST['uuid'];
$conn = new mysqli($sqlhost, $sqlusername, $sqlpass, $sqldb);
if ($uuid != "") {

    if ($conn->connect_error) {
        die("Error: " . $conn->connect_error);
    } 

    $query = "SELECT position, lastupdate, status FROM users WHERE uuid = '" . $uuid . "'";
    $status = mysqli_query($conn, $query);
    if (mysqli_num_rows($status) == 1) {
        $row = mysqli_fetch_row($status);
        $lastupdate = strtotime($row[1]);
        $interval = date("U") - date("U", $lastupdate);
        if ($interval >= 600) {
            echo $row[0]."o";
        } else {
        	if ($row[2] == "online") {
            	echo $row[0];
            } elseif ($row[2] == "offline") {
            	echo $row[0]."o";
            } elseif ($row[2] == "frozen") {
                echo $row[0]."f";
            }
        }
    } else {
        echo "Error: Invalid uuid";
    }

    $conn->close();

} else {
	echo "Error: No uuid provided"; 
}
?>
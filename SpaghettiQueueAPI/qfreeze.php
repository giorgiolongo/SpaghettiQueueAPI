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


    $uuidcheck = mysqli_query($conn, "SELECT * FROM users WHERE uuid = '" . $uuid . "'");
    if (mysqli_num_rows($uuidcheck) == 1) {
	$now = date("Y-m-d H:i:s");
        $query = "UPDATE users SET status='frozen', lastupdate='" . $now . "' WHERE uuid='" . $uuid . "'";
        if (mysqli_query($conn, $query)) {
            echo "OK";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
            
    } else {
        echo "Error: Invalid uuid";
    }

    $conn->close();

} else {
	echo "Error: Missing uuid argument";
}
?>
<?php
if (file_exists("config.php")) {
    require "config.php";
}
else {
    die("Error: Config file not found, make sure to have run the setup file first");
}
$olduuid = $_POST['uuid'];
$newuuid = bin2hex(random_bytes(8));
$conn = new mysqli($sqlhost, $sqlusername, $sqlpass, $sqldb);

if ($conn->connect_error) {
    die("Error: " . $conn->connect_error);
}

if ($olduuid != "") {
    $checkquery = "SELECT * FROM users WHERE uuid = '" . $olduuid . "'";
    $uuidcheck = mysqli_query($conn, $checkquery);
    if (mysqli_num_rows($uuidcheck) != 0) {
        $deletequery = "DELETE FROM users WHERE uuid='" . $olduuid . "'";
        if (mysqli_query($conn, $deletequery)) {
            $createquery = "INSERT INTO users (uuid, position, lastupdate) VALUES ('" . $newuuid . "', '0', '" . date("Y-m-d H:i:s") . "')";
            if (mysqli_query($conn, $createquery) === TRUE) {
                echo $newuuid; 
            } else { 
                echo "Error: " . mysqli_error($conn);
            }
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
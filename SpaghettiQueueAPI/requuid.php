<?php
if (file_exists("config.php")) {
    require "config.php";
}
else {
    die("Error: Config file not found, make sure to have run the setup file first");
}
$uuid = bin2hex(random_bytes(8));
$conn = new mysqli($sqlhost, $sqlusername, $sqlpass, $sqldb);
if ($conn->connect_error) {
    die("Error: " . $conn->connect_error);
} 

$query = "INSERT INTO users (uuid, position, lastupdate) VALUES ('" . $uuid . "', 0 , '" . date("Y-m-d H:i:s") . "')";

if (mysqli_query($conn, $query) === TRUE) {
    echo $uuid;
} else {
    echo "Error: " . mysqli_error($conn);
}

$conn->close();
?>
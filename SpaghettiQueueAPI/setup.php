<html>
<body>
<form action="setup.php" method="post">
Configuration of PHP API. The database you put here has to be empty. You can have other databases in the MySql server but the DB of SpaghettiQueue needs its own one.
The 'users' table will be automatically created after submitting the data<br>
MySql Server IP: <input type="text" name="sqlhost"><br>
MySql Username: <input type="text" name="sqlusername"><br>
MySql Password: <input type="text" name="sqlpass"><br>
MySql Database: <input type="text" name="sqldb"><br>
<input type="submit">
</form>
<?php

$sqlhost = $_POST['sqlhost'];
$sqlusername = $_POST['sqlusername'];
$sqlpass = $_POST['sqlpass'];
$sqldb = $_POST['sqldb'];

if ($sqlhost == "" or $sqlusername == "" or $sqldb == "") {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo "<p style='color:red;'>Make sure to fill every textbox before submitting</p>";
    }
} else {
    $conn = new mysqli($sqlhost, $sqlusername, $sqlpass, $sqldb);
    if ($conn->connect_error) {
        die("<p style='color:red;'>The credentials are not valid: " . $conn->connect_error . "</p>");
    } else {
        $query = "CREATE TABLE IF NOT EXISTS `users` (`uuid` varchar(255) NOT NULL, `position` int(11) NOT NULL, `lastupdate` varchar(255) NOT NULL, `status` varchar(255) NOT NULL DEFAULT 'online')";
        if (mysqli_query($conn, $query) === TRUE) {
            $file = fopen( "config.php", "w" );
            if( $file == false ) {
                die("<p style='color:green;'>There was a problem managing config.php.</p>");
            }
            fwrite( $file, '<?php $sqlhost = "' . $sqlhost . '"; $sqlusername = "' . $sqlusername . '"; $sqlpass = "' . $sqlpass . '"; $sqldb = "' . $sqldb . '"; ?>' );
            fclose( $file );
            unlink('setup.php') or die("<p style='color:green;'>Couldnt delete setup.php.</p>");
            echo "<p style='color:green;'>The credentials are valid. The setup file has been deleted and a config file has been created.</p>";

        } else {
            die("<p style='color:red;'>There was an error with the database: " . mysqli_error($conn) . "</p>");
        }
        
        $conn->close();
        
    }
}





?>
</body>
</html>
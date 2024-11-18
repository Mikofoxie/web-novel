<?php

$servername = "localhost";
$username = "root";
$password = "123";
$dbname = "websach";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection to the database failed: " . $conn->connect_error);
}
mysqli_set_charset($conn, 'UTF8');

?>

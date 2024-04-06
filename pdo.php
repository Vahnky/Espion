<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "AGENCE"; 

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

} catch (PDOException $e) {
    echo $e->getMessage();
}

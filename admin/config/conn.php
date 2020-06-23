<?php

include("accessControl.php");

$servername = "gomed123.mysql.database.azure.com";
$username = "gomedroot@gomed123";
$password = "goMed123";
$dbname = "gomed";

try {
   $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
   // set the PDO error mode to exception
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo "Connected successfully";
} catch (PDOException $e) {
   // echo "Connection failed: " . $e->getMessage();
}

// $conn=null;

?>
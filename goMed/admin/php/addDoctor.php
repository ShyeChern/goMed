<?php
include("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["Email"];
    $password = $_POST["Password"];
    $name = $_POST["Name"];
    $ic = $_POST["Ic"];
    $workingLocation = $_POST["WorkingLocation"];
    $experience = $_POST["Experience"];

    $fileName = $_FILES['Certificate']['name'];
    $tmpName = $_FILES['Certificate']['tmp_name'];
    $fileSize = $_FILES['Certificate']['size'];
    $fileType = $_FILES['Certificate']['type'];
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $fp      = fopen($tmpName, 'r');
    $content = fread($fp, filesize($tmpName));
    
    fclose($fp);

    $dataToSend = array();

    try {
        $sql = "INSERT INTO certificate (Filename,FileType,Size,Content) VALUES(?, ?, ?, ?);
            INSERT INTO doctor (Email, Password, Name, Ic, Working_Location, Experience, Certificate_Id) VALUES (?, ?, ?, ?, ?, ?, LAST_INSERT_ID())";

        $stmt = $conn->prepare($sql);

        $stmt->execute([$fileName, $fileType, $fileSize, $content, $email, $password, $name, $ic, $workingLocation, $experience]);

        $dataToSend = ["result" => true];
    } catch (PDOException $e) {
        $dataToSend = ["result" => $e->getMessage()];
    }

    $conn = null;

    echo json_encode($dataToSend);
}

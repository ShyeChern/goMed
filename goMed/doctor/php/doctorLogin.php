<?php
include("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $doctorEmail=$_POST['DoctorEmail'];
    $doctorPassword=md5($_POST['DoctorPassword']);

    $dataToSend = array();

    try {
        $sql = "SELECT Doctor_Id FROM doctor WHERE BINARY Email=? AND Password=?";

        $stmt = $conn->prepare($sql);

        $stmt->execute([$doctorEmail, $doctorPassword]);

        if($stmt->rowCount() == 1) {
            $result = $stmt->fetch();
            $dataToSend = ["result" => true, "doctorId"=>$result['Doctor_Id']];
        }
        else{
            $dataToSend = ["result" => false];
        }

    } catch (PDOException $e) {
        $dataToSend = ["result" => $e->getMessage()];
    }

    $conn = null;

    echo json_encode($dataToSend);
}
?>
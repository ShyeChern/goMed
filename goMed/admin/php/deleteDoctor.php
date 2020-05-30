<?php
include("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $doctorId = $_POST["DoctorId"];
    $dataToSend = array();

    try {
        $sql = "DELETE doctor, certificate
                FROM doctor INNER JOIN certificate
                ON doctor.Certificate_Id = certificate.Certificate_Id
                WHERE doctor.Doctor_Id = ?";

        $stmt = $conn->prepare($sql);

        $stmt->execute([$doctorId]);

        $dataToSend = ["result" => true];
    } catch (PDOException $e) {
        $dataToSend = ["result" => $e->getMessage()];
    }

    $conn = null;

    echo json_encode($dataToSend);
}

?>

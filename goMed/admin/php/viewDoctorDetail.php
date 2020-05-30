<?php
include("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $doctorId = $_POST["DoctorId"];
    $dataToSend = array();

    try {
        $sql = "SELECT d.Doctor_Id, d.Email, d.Name, d.Ic, d.Working_Location, d.Experience, d.Certificate_Id, c.Filename
                FROM doctor d INNER JOIN certificate c
                ON d.Certificate_Id=c.Certificate_Id
                WHERE d.Doctor_Id=?;";

        $stmt = $conn->prepare($sql);

        $stmt->execute([$doctorId]);

        $result = $stmt->fetch();

        $dataToSend = ["result" => true, "doctorDetail" => [
            "doctorId" => $result['Doctor_Id'], "email" => $result["Email"],
            "name" => $result["Name"], "ic" => $result["Ic"], "workingLocation" => $result["Working_Location"],
            "experience" => $result["Experience"], "certificateId" => $result['Certificate_Id']
        ]];
    } catch (PDOException $e) {
        $dataToSend = ["result" => $e->getMessage()];
    }

    $conn = null;

    echo json_encode($dataToSend);
}

?>
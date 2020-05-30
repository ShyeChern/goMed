<?php
include("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $visitorId = $_POST["VisitorId"];
    $doctorId = $_POST["DoctorId"];
    $message = $_POST["Message"];

    $dataToSend = array();

    try {
        $sql = "INSERT INTO chat (Visitor_Id, Doctor_Id, Message, AcceptedBy) VALUES(?, ?, ?, ?);";

        $stmt = $conn->prepare($sql);

        $stmt->execute([$visitorId, $doctorId, $message, $doctorId]);

        $dataToSend = ["result" => true];
    } catch (PDOException $e) {
        $dataToSend = ["result" => $e->getMessage()];
    }

    $conn = null;

    echo json_encode($dataToSend);
}

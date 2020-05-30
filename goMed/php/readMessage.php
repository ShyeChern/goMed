<?php
include("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $visitorId = $_POST["VisitorId"];
    $dataToSend = array();

    try {
        $sql = "SELECT  Visitor_Id, Doctor_Id, Message from chat WHERE Visitor_Id=? ORDER BY Timestamp";

        $stmt = $conn->prepare($sql);

        $stmt->execute([$visitorId]);

        $result = $stmt->fetchAll();

        $data = array();

        foreach ($result as $row) {
            array_push($data, ["doctorId" => $row["Doctor_Id"], "visitorId" => $row["Visitor_Id"], "message" => $row["Message"]]);
        }

        $dataToSend = ["result" => true, "messages" => $data];
    } catch (PDOException $e) {
        $dataToSend = ["result" => $e->getMessage()];
    }

    $conn = null;

    echo json_encode($dataToSend);
}

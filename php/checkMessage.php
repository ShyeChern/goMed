<?php
include("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $visitorId = $_POST["VisitorId"];

    $dataToSend = array();

    try {
        $sql = "SELECT EXISTS(SELECT 1 FROM chat WHERE Visitor_Id=?) AS Result";

        $stmt = $conn->prepare($sql);

        $stmt->execute([$visitorId]);

        $result = $stmt->fetch();

        if ($result["Result"] == "1") {
            $dataToSend = ["result" => true, "data" => true];
        } 
        else {
            $dataToSend = ["result" => true, "data" => false];
        }
    } 
    catch (PDOException $e) {
        $dataToSend = ["result" => $e->getMessage()];
    }

    $conn = null;

    echo json_encode($dataToSend);
}

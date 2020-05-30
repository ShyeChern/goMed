<?php
include("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $visitorId = $_POST["VisitorId"];
    $message = $_POST["Message"];

    $dataToSend = array();

    try {

        $sql = "BEGIN; 
                SELECT @AcceptedBy:= AcceptedBy
                FROM chat 
                WHERE Visitor_Id=? ORDER BY AcceptedBy DESC LIMIT 1;
                INSERT INTO chat (Visitor_Id,Message, AcceptedBy) VALUES(?, ?, @AcceptedBy);
                COMMIT;";


        $stmt = $conn->prepare($sql);

        $stmt->execute([$visitorId, $visitorId, $message]);

        $dataToSend = ["result" => true];
    } catch (PDOException $e) {
        $dataToSend = ["result" => $e->getMessage()];
    }

    $conn = null;

    echo json_encode($dataToSend);
}

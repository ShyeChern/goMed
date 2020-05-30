<?php
include("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $doctorId = $_POST["DoctorId"];
    $dataToSend = array();

    try {
        $sql = "SELECT DISTINCT Visitor_Id, AcceptedBy FROM chat WHERE AcceptedBy IS NULL OR AcceptedBy = ?";

        $stmt = $conn->prepare($sql);

        $stmt->execute([$doctorId]);

        $result = $stmt->fetchAll();

        $newConsultation = array();
        $currentConsultation = array();

        foreach ($result as $row) {
            if (is_null($row["AcceptedBy"])) {
                array_push($newConsultation, ["visitorId" => $row["Visitor_Id"]]);
            } 
            else {
                array_push($currentConsultation, ["visitorId" => $row["Visitor_Id"]]);
            }
        }

        $dataToSend = ["result" => true, "newConsultation" => $newConsultation, "currentConsultation" => $currentConsultation];
    } catch (PDOException $e) {
        $dataToSend = ["result" => $e->getMessage()];
    }

    $conn = null;

    echo json_encode($dataToSend);
}

<?php
include("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $dataToSend = array();

    try {
        $sql = "SELECT Symptom_Id, Name FROM symptom";

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetchAll();

        $data = array();
        
        foreach ($result as $row) {
            array_push($data, ["symptomId" => $row["Symptom_Id"], "name" => $row["Name"]]);
        }

        $dataToSend = ["result" => true, "symptom" => $data];

    } catch (PDOException $e) {
        $dataToSend = ["result" => $e->getMessage()];
    }

    $conn = null;

    echo json_encode($dataToSend);
}
?>
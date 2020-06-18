<?php
include("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $dataToSend = array();

    try {
        $sql = "SELECT d.Disease_Id, d.Name, GROUP_CONCAT(s.Name separator ',') as Symptom, d.Image FROM disease d INNER JOIN disease_symptom ds 
                ON d.Disease_Id=ds.Disease_Id INNER JOIN symptom s ON ds.Symptom_Id=s.Symptom_Id
                GROUP BY d.Disease_Id";

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetchAll();

        $data = array();

        foreach ($result as $row) {
            array_push($data, [
                "diseaseId" => $row["Disease_Id"], "name" => $row["Name"], "symptom" => $row["Symptom"], "image" => base64_encode($row["Image"])
            ]);
        }

        $dataToSend = ["result" => true, "disease" => $data];
    } catch (PDOException $e) {
        $dataToSend = ["result" => $e->getMessage()];
    }

    $conn = null;

    echo json_encode($dataToSend);
}

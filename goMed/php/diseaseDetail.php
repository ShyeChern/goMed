<?php
include("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $diseaseId = $_POST["DiseaseId"];
    $dataToSend = array();

    try {
        $sql = "SELECT d.Name, d.Description, d.Duration, d.Precaution, d.Image, GROUP_CONCAT(s.Name separator ', ') as Symptom FROM disease d 
        INNER JOIN disease_symptom ds ON d.Disease_Id=ds.Disease_Id INNER JOIN symptom s ON ds.Symptom_Id=s.Symptom_Id
        WHERE d.Disease_Id=?";

        $stmt = $conn->prepare($sql);

        $stmt->execute([$diseaseId]);

        $result = $stmt->fetch();

        $data = array();

        $data = [
            "name" => $result["Name"], "description" => $result["Description"], "duration" => $result["Duration"],
            "precaution" => $result["Precaution"], "image"=> base64_encode($result["Image"]), "symptom"=> $result["Symptom"]
        ];

        $dataToSend = ["result" => true, "diseaseDetail" => $data];
    } catch (PDOException $e) {
        $dataToSend = ["result" => $e->getMessage()];
    }

    $conn = null;

    echo json_encode($dataToSend);
}

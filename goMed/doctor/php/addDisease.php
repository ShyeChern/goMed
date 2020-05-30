<?php
include("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $diseaseName = $_POST["DiseaseName"];
    $description = $_POST["Description"];
    $precaution = $_POST["Precaution"];
    $diseaseDuration = $_POST["DiseaseDuration"];
    $symptom = explode(",", $_POST["Symptom"]);

    $fileName = $_FILES['DiseaseImage']['name'];
    $tmpName = $_FILES['DiseaseImage']['tmp_name'];
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $fp      = fopen($tmpName, 'r');
    $content = fread($fp, filesize($tmpName));

    fclose($fp);
        
    $dataToSend = array();

    if (!($ext == "png" || $ext == "PNG" || $ext == "JPG" || $ext == "jpg" || $ext == "jpeg" || $ext == "JPEG")) {
        $dataToSend = ["result" => "Please provide only png, jpg or jepg image only"];
        echo json_encode($dataToSend);
    } else {

        try {
            $sql = "INSERT INTO disease (Name, Description, Duration, Precaution, Image) VALUES(?, ?, ?, ?, ?);";

            $stmt = $conn->prepare($sql);

            $stmt->execute([$diseaseName, $description, $diseaseDuration, $precaution, $content]);

            $diseaseId = $conn->lastInsertId();

            $sql = "INSERT INTO disease_symptom (Disease_Id, Symptom_Id) VALUES (?, (SELECT Symptom_Id FROM symptom WHERE name=?) );";

            foreach ($symptom as $value) {
                
                $stmt = $conn->prepare($sql);

                $stmt->execute([$diseaseId, $value]);
                
            }

            $dataToSend = ["result" => true ];
        } catch (PDOException $e) {
            $dataToSend = ["result" => $e->getMessage()];
        }

        $conn = null;

        echo json_encode($dataToSend);
    }

}

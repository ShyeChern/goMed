<?php
include("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $dataToSend = array();

    try {
        $sql = "SELECT Disease_Id, Name, Description, Image FROM disease;";

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetchAll();

        $data = array();

        foreach ($result as $row) {
            array_push($data, [
                "diseaseId" => $row["Disease_Id"], "name" => $row["Name"], "description" => $row["Description"],
                "image" => base64_encode($row["Image"])
            ]);
        }

        $dataToSend = ["result" => true, "disease" => $data];
    } catch (PDOException $e) {
        $dataToSend = ["result" => $e->getMessage()];
    }

    $conn = null;

    echo json_encode($dataToSend);
}

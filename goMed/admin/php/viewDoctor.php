<?php
include("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $dataToSend = array();

    try {
        $sql = "SELECT Doctor_Id, Name FROM doctor;";

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetchAll();

        $data = array();

        foreach ($result as $row) {
            array_push($data, ["doctorId" => $row["Doctor_Id"], "name" => $row["Name"]]);
        }

        $dataToSend = ["result" => true, "doctor" => $data];

    } catch (PDOException $e) {
        $dataToSend = ["result" => $e->getMessage()];
    }

    $conn = null;

    echo json_encode($dataToSend);
}
?>
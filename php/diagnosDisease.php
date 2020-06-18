<?php
include("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $symptom = $_POST["Symptom"];
    $dataToSend = array();

    $having = "HAVING";

    foreach ($symptom as $key => $value) {
        if ($key == 0) {
            $having .= " Symptom LIKE '%" . $value . "%'";
        } else {
            $having .= " OR Symptom LIKE '%" . $value . "%'";
        }
    }


    try {
        $sql = "SELECT d.Name, GROUP_CONCAT(s.Name separator ',') as Symptom FROM disease d
                INNER JOIN disease_symptom ds ON d.Disease_Id=ds.Disease_Id INNER JOIN symptom s ON ds.Symptom_Id=s.Symptom_Id
                GROUP BY d.Disease_Id " . $having;
        // HAVING Symptom LIKE '%Bloating%' OR Symptom LIKE '%Cough%'

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetchAll();

        $matchedDisease = array();
        $data = array();
        $totalPercentage = 0;

        foreach ($result as $row) {
            $diseaseSymptom = explode(",", $row["Symptom"]);
            $matchedItem = sizeof(array_intersect($diseaseSymptom, $symptom));
            $percentageMatched = $matchedItem / sizeof($diseaseSymptom);
            $totalPercentage += $percentageMatched;
            array_push($matchedDisease, ["name" => $row["Name"], "percentageMatched" => $percentageMatched]);
        }

        foreach ($matchedDisease as $value) {
            $percentage = $value["percentageMatched"] / $totalPercentage * 100;
            array_push($data, ["name" => $value["name"], "percentage" => $percentage]);
        }

        $dataToSend = ["result" => true, "disease" => $data];
    } catch (PDOException $e) {
        $dataToSend = ["result" => $e->getMessage()];
    }

    $conn = null;

    echo json_encode($dataToSend);
}

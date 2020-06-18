<?php
include("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $adminUsername=$_POST['AdminUsername'];
    $adminPassword=md5($_POST['AdminPassword']);

    $dataToSend = array();

    try {
        $sql = "SELECT Admin_Id FROM admin WHERE BINARY Username=? AND Password=?";

        $stmt = $conn->prepare($sql);

        $stmt->execute([$adminUsername, $adminPassword]);

        if($stmt->rowCount() == 1) {
            $result = $stmt->fetch();
            $dataToSend = ["result" => true, "adminId"=>$result['Admin_Id']];
        }
        else{
            $dataToSend = ["result" => false];
        }

    } catch (PDOException $e) {
        $dataToSend = ["result" => $e->getMessage()];
    }

    $conn = null;

    echo json_encode($dataToSend);
}
?>
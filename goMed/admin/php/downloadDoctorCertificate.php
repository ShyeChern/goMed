<?php
include("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $certificateId=$_GET["certificateId"];

    $dataToSend = array();

    try {
        $sql = "SELECT Filename, Filetype, Size, Content FROM certificate WHERE Certificate_Id=?";

        $stmt = $conn->prepare($sql);

        $stmt->execute([$certificateId]);

        $result = $stmt->fetch();

        $size=$result['Size'];
        $file=$result['Filename'];
        $type=$result['Filetype'];
        $content=$result['Content'];

        header("Content-length: $size");
		header("Content-type: $type");
		header("Content-Disposition: attachment; filename=$file");
		ob_clean();
		flush();
		echo $content;
        
    } catch (PDOException $e) {
        $dataToSend = ["result" => $e->getMessage()];
    }

    $conn = null;
}
?>
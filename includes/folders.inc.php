<?php
require("./db.inc.php");
if (isset($_POST['fetchFolders'])) {
    $sql = "SELECT * FROM question_folders";
    $result = mysqli_query($conn, $sql);
    $resultChecker = mysqli_num_rows($result);
    if ($resultChecker > 0) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode($data);
    }
}
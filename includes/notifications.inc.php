<?php

require "./db.inc.php";

if (isset($_POST['add'])) {
    $head = str_replace("'","''", trim($_POST['head'])); 
    $body = str_replace("'","''", trim($_POST['body']));
    if (empty($head) || empty($body)) {
        echo "Empty Field(s)";
    } else {   
        $sql = "INSERT INTO notifications (head, body) VALUES ('$head', '$body');";
        if (mysqli_query($conn,$sql)) {
            echo "Added Successfully";
        } 
    }
} elseif (isset($_POST['show'])) {
    $sql = "SELECT * FROM notifications";
    $result = mysqli_query($conn, $sql);
    $resultChecker = mysqli_num_rows($result);
    if ($resultChecker > 0) {
        $x = 0;
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $array = array();
            $array[] = ++$x;
            $array[] = $row['head'];
            $array[] = $row['body'];
            $array[] = $row['date_created'];
            $array[] = '<td>•••<div class="links shadow-sm">
            <button type="submit" class="edit" name="edit" value="' . $row['id'] . '" onclick="editNotification(' . $row['id'] . ')">Edit</button>
            <button name="delete" value="' . $row['id'] . '" onclick="deleteNotification(' . $row['id'] . ')">Delete</button>
          </div></td>';
            array_push($data, $array);
        }
        file_put_contents("../text/notifications.txt", '{"data":' . json_encode($data) . '}');
    } else {
        file_put_contents("../text/notifications.txt", '{"data":[[null,null,null,null,null]]}');
    }
} elseif (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM notifications WHERE id = $id;";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    echo json_encode($row);
} elseif (isset($_POST['update'])) {
    $id = $_POST['id'];
    $head = str_replace("'","''", trim($_POST['head'])); 
    $body = str_replace("'","''", trim($_POST['body']));
    if (empty($head) || empty($body)) {
        echo "Empty Field(s)";
    } else {   
        $sql = "UPDATE notifications SET head = '$head', body = '$body' WHERE id = $id;";
        if (mysqli_query($conn,$sql)) {
            echo "Updated Successfully";
        } 
    }
} elseif (isset($_POST['remove'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM notifications WHERE id = $id;";
    if (mysqli_query($conn,$sql)) {
        echo "Deleted Successfully";
    }
}
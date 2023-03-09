<?php
require "./db.inc.php";
if (isset($_POST['password'])) {
    $id = $_POST['id'];
    if (!empty($_POST['cpwd']) || !empty($_POST['pwd']) || !empty($_POST['rpwd'])) {
        $oldpwd = $_POST['cpwd'];
        $newpwd = $_POST['pwd'];
        $rnewpwd = $_POST['rpwd'];
        if (empty($oldpwd) || empty($newpwd) || empty($rnewpwd)) {
            echo "Empty Field(s)";
        } else {
            $sql = "SELECT * FROM `teachers` WHERE id = '$id';";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $old_hash_pwd = $row['password'];
            if (password_verify($oldpwd, $old_hash_pwd)) {
                if ($newpwd === $rnewpwd) {
                    $hash_pwd = password_hash($newpwd, PASSWORD_DEFAULT);
                    $sql1 = "UPDATE `teachers` SET `password` = '$hash_pwd' WHERE id = '$id';";
                    if (mysqli_query($conn, $sql1)) {
                        echo "Password Changed Successfully";
                    }
                } else {
                    echo "Password Does Not Match";
                }
            } else {
                echo "Old Password Not Correct";
            }
        }
    } else {
        echo "Empty Field(s)!";
    }
}

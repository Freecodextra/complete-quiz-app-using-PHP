<?php

if (isset($_POST['submit'])) {
    require_once("db.inc.php");
    $fName = trim($_POST['fName']);
    $lName = trim($_POST['lName']);
    $uid = trim($_POST['uid']);
    $email = trim($_POST['email']);
    $pwd = trim($_POST['pwd']);
    $rpwd = trim($_POST['rpwd']);
 $sql = "INSERT INTO admin (fName, lName, username, email, password, reg_date, last_login) VALUES (?, ?, ?, ?, ?, ?, ?);";
            $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../user/signup.php?error=sql");
                exit();
            } else {
            $date = getdate()[0];
            $hashPwd = password_hash($pwd, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "sssssdd", $fName, $lName, $uid, $email, $hashPwd, $date, $date);
            mysqli_stmt_execute($stmt);
   }
            } else {
    header("Location: ../user/signup.php?error=pressbtn");
    exit();
 }

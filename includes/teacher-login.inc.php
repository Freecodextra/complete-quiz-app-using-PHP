<?php

session_start();


if (isset($_POST['submit'])) {
    require "./db.inc.php";
    $uid = trim($_POST['uid']);
    $pwd = trim($_POST['pwd']);

    if (empty($uid) || empty($pwd)) {
        header("Location: ../teacher/login.php?error=empty");
        exit();
    } else {
        $sql = "SELECT * FROM teachers WHERE username = ? OR email = ? OR teacherID = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../teacher/login.php?error=sql");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "sss", $uid, $uid, $uid);
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
           if (mysqli_num_rows($result) <= 0) {
            header("Location: ../teacher/login.php?error=usernotfound");
            exit();
           } else {
            while ($row = mysqli_fetch_assoc($result)) {
                $pwdCheck = password_verify($pwd, $row['password']);
                if ($pwdCheck) {
                    $teacher_id = $row['id'];
                   $_SESSION['teacher'] = $row['id'];
                   $_SESSION['uid'] = $row['username'];
                   $_SESSION['email'] = $row['email'];
                   $_SESSION['studentID'] = $row['studentID'];
                   $_SESSION['fName'] = $row['fName'];
                   $_SESSION['lName'] = $row['lName'];
                   $date = getdate()[0];
                   $id = $row['id'];
                   $sql = "UPDATE teachers SET last_login = $date WHERE id = $id;";
                   header("Location: ../teacher/login.php?error=success&teacher=$teacher_id");
                    exit();
                } else {
                    header("Location: ../teacher/login.php?error=wrongpwd");
                    exit();
                }
                
            }
           }
        }
    }
    
} else {
   header("Location: ../teacher/login.php");
   exit();
}




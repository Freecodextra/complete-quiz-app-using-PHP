<?php

session_start();


if (isset($_POST['submit'])) {
    require "./db.inc.php";
    $uid = trim($_POST['uid']);
    $pwd = trim($_POST['pwd']);

    if (empty($uid) || empty($pwd)) {
        header("Location: ../user/login.php?error=empty");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE username = ? OR email = ? OR studentID = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../user/login.php?error=sql");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "sss", $uid, $uid, $uid);
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
           if (mysqli_num_rows($result) <= 0) {
            header("Location: ../user/login.php?error=usernotfound");
            exit();
           } else {
            while ($row = mysqli_fetch_assoc($result)) {
                $pwdCheck = password_verify($pwd, $row['password']);
                if ($pwdCheck) {
                    $user_id = $row['id'];
                   $_SESSION['id'] = $row['id'];
                   $_SESSION['uid'] = $row['username'];
                   $_SESSION['email'] = $row['email'];
                   $_SESSION['studentID'] = $row['studentID'];
                   $_SESSION['fName'] = $row['fName'];
                   $_SESSION['lName'] = $row['lName'];
                   $date = getdate()[0];
                   $id = $row['id'];
                   $sql = "UPDATE users SET last_login = $date WHERE id = $id;";
                   header("Location: ../user/login.php?error=success&user=$user_id");
                    exit();
                } else {
                    header("Location: ../user/login.php?error=wrongpwd");
                    exit();
                }
                
            }
           }
        }
    }
    
} else {
   header("Location: ../user/login.php");
   exit();
}




<?php

session_start();


if (isset($_POST['admin'])) {
    require "./db.inc.php";
    $uid = trim($_POST['uid']);
    $pwd = trim($_POST['pwd']);

    if (empty($uid) || empty($pwd)) {
        header("Location: ../admin/login.php?error=empty");
        exit();
    } else {
        $sql = "SELECT * FROM `admin` WHERE username = ? OR email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../admin/login.php?error=sql");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $uid, $uid);
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
           if (mysqli_num_rows($result) <= 0) {
            header("Location: ../admin/login.php?error=usernotfound");
            exit();
           } else {
            while ($row = mysqli_fetch_assoc($result)) {
                $pwdCheck = password_verify($pwd, $row['password']);
                if ($pwdCheck) {
                   $_SESSION['admin'] = $row['id'];
                   $_SESSION['uid'] = $row['username'];
                   $_SESSION['email'] = $row['email'];
                   $date = getdate()[0];
                   $id = $row['id'];
                   $sql = "UPDATE admins SET last_login = $date WHERE id = $id;";
                   header("Location: ../admin/index.php");
                    exit();
                } else {
                    header("Location: ../admin/login.php?error=wrongpwd");
                    exit();
                }
                
            }
           }
        }
    }
    
} else {
   header("Location: ../admin/login.php");
   exit();
}




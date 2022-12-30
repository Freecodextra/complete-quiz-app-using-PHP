<?php

if (isset($_POST['submit'])) {
    require_once("db.inc.php");
    $fName = trim($_POST['fName']);
    $lName = trim($_POST['lName']);
    $uid = trim($_POST['uid']);
    $email = trim($_POST['email']);
    $pwd = trim($_POST['pwd']);
    $rpwd = trim($_POST['rpwd']);

    if (empty($fName) || empty($lName) || empty($uid) || empty($email) || empty($pwd) || empty($rpwd)) {
    header("Location: ../user/signup.php?error=empty&fName=".$fName."&lName=".$lName."&uid=".$uid."&email=".$email);
    exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $uid)) {
        header("Location: ../user/signup.php?error=uid/email&fName=".$fName."&lName=".$lName);
        exit();
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../user/signup.php?error=email&fName=".$fName."&lName=".$lName."&uid=".$uid);
        exit();
    }
    elseif (!preg_match("/^[a-zA-Z0-9]*$/", $uid)) {
        header("Location: ../user/signup.php?error=username&fName=".$fName."&lName=".$lName."&email=".$email);
        exit();
    } elseif (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $pwd)) {
        header("Location: ../user/signup.php?error=strong&fName=".$fName."&lName=".$lName."&email=".$email."&uid=".$uid);
        exit();
    } elseif ($pwd !== $rpwd) {
        header("Location: ../user/signup.php?error=password&fName=".$fName."&lName=".$lName."&email=".$email."&uid=".$uid);
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../user/signup.php?error=sql");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $uid, $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                header("Location: ../user/signup.php?error=userexist&fName=".$fName."&lName=".$lName."&uid=".$uid."&email=".$email);
                exit();
            } else {
                $sql = "INSERT INTO users (fName, lName, username, email, password, reg_date, last_login) VALUES (?, ?, ?, ?, ?, ?, ?);";
            $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../user/signup.php?error=sql");
                exit();
            } else {
            $date = getdate()[0];
            $hashPwd = password_hash($pwd, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "sssssdd", $fName, $lName, $uid, $email, $hashPwd, $date, $date);
            mysqli_stmt_execute($stmt);

            $sql = "SELECT * FROM users WHERE username = '$uid'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $userid = $row['id'];
                    $student = "STD/00".$userid;
                    $sql1 = "UPDATE users SET studentID = '$student' WHERE id = '$userid';";
                    mysqli_query($conn, $sql1);
                    $sql2 = "INSERT INTO image (userid, state) VALUES ($userid, 0);";
                    mysqli_query($conn, $sql2);
                    header("Location: ../user/signup.php?error=success");
                    exit();
                }
            }
   }
            }
        }
}
 } else {
    header("Location: ../user/signup.php?error=pressbtn");
    exit();
 }

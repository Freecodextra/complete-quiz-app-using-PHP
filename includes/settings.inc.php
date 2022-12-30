<?php
require "./db.inc.php";
if (isset($_FILES['image'])) {
    $school_name = str_replace("'", "''", $_POST['school-name']);
    $short_name = $_POST['short-name'];
    $school_motto = str_replace("'", "''", $_POST['school-motto']);
    $image = $_FILES['image'];
    if (empty($school_name) || empty($short_name) || empty($school_motto)) {
        echo "Empty Field(s)";
    } else {
        if ($image['name'] === "") {
            $sql = "UPDATE settings SET school_name = '$school_name', school_short_name = '$short_name', school_motto = '$school_motto';";
            if (mysqli_query($conn, $sql)) {
                echo "Saved Successfully";
            }
        } else {
            $img_name = $image['name'];
            $img_error = $image['error'];
            $img_tmp_name = $image['tmp_name'];
            $img_type = $image['type'];
            $img_size = $image['size'];
            $img_array = explode(".", $img_name);
            $img_ext = strtolower(end($img_array));
            $accept = array("jpg", "jpeg", "png", "pdf", "gif");
            if (in_array($img_ext, $accept)) {
                if ($img_error === 0) {
                    if ($img_size < 10000000) {
                        $file = "../images/logo*";
                        $fileSearch = glob($file);
                        if (file_exists($fileSearch[0])) {
                            unlink($fileSearch[0]);
                        }
                        $img_des = "../images/";
                        $img_new_name = "logo" . rand() . "." . $img_ext;
                        $img_new_des = $img_des . $img_new_name;
                        move_uploaded_file($img_tmp_name, $img_new_des);
                        // Query Database
                        $sql = "UPDATE settings SET school_name = '$school_name', school_short_name = '$short_name', school_motto = '$school_motto';";
                        if (mysqli_query($conn, $sql)) {
                            echo "Saved Successfully";
                        }
                    } else {
                        echo "Image Size Too Big";
                    }
                } else {
                    echo "Error while uploading Image";
                }
            } else {
                echo "Invalid File Type";
            }
        }
    }
} elseif (isset($_POST['fName'])) {
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    if (empty($fName) || empty($lName) || empty($username) || empty($email)) {
        echo "Empty Field(s)";
    } else {
        $sql = "UPDATE `admin` SET fName = '$fName', lName = '$lName', username = '$username', email = '$email';";
        if (mysqli_query($conn, $sql)) {
            echo "Saved Successfully";
        }
    }
} elseif (isset($_POST['facebook'])) {
    $facebook = $_POST['facebook'];
    $twitter = $_POST['twitter'];
    $instagram = $_POST['instagram'];
    $phone = $_POST['phone'];
    if (empty($facebook) || empty($twitter) || empty($instagram) || empty($phone)) {
        echo "Empty Field(s)";
    } else {
        $sql = "UPDATE settings SET facebook = '$facebook', twitter = '$twitter', instagram = '$instagram', phone = '$phone';";
        if (mysqli_query($conn, $sql)) {
            echo "Saved Successfully";
        }
    }
} elseif (isset($_POST['oldpwd'])) {
    $oldpwd = $_POST['oldpwd'];
    $newpwd = $_POST['newpwd'];
    $rnewpwd = $_POST['rnewpwd'];
    if (empty($oldpwd) || empty($newpwd) || empty($rnewpwd)) {
        echo "Empty Field(s)";
    } else {
        $sql = "SELECT * FROM `admin`";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $old_hash_pwd = $row['password'];
        if (password_verify($oldpwd, $old_hash_pwd)) {
            if ($newpwd === $rnewpwd) {
                $hash_pwd = password_hash($newpwd, PASSWORD_DEFAULT);
                $sql1 = "UPDATE `admin` SET `password` = '$hash_pwd';";
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
}

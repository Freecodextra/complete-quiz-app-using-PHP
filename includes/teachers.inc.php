<?php
require_once("db.inc.php");
function teacherID()
{
    $x = range(0, 9);
    $y = "";
    for ($i = 0; $i < 3; $i++) {
        $shuffle = shuffle($x);
        $rand_x = $x[array_rand($x)];
        $y .= $rand_x;
    }
    return $y;
}
if (isset($_POST['addTeacher'])) {
    $fName = trim($_POST['fName']);
    $lName = trim($_POST['lName']);
    $uid = trim($_POST['uid']);
    $email = trim($_POST['email']);
    $pwd = trim($_POST['pwd']);
    $rpwd = trim($_POST['rpwd']);

    if (empty($fName) || empty($lName) || empty($uid) || empty($email) || empty($pwd) || empty($rpwd)) {
        echo "Empty Field(s)";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $uid)) {
        echo "Input Valid Email/Username";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Input Valid Email";
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $uid)) {
        echo "Input Valid Username";
    } elseif (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $pwd)) {
        echo "Input Strong Password";
    } elseif ($pwd !== $rpwd) {
        echo "Password Does Not Match";
    } else {
        $sql = "SELECT * FROM teachers WHERE username = ? OR email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL Error, Try Again";
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $uid, $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                echo "User Exist";
            } else {
                $sql = "INSERT INTO teachers (fName, lName, username, email, `password`, reg_date, last_login) VALUES (?, ?, ?, ?, ?, ?, ?);";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "SQL Error, Try Again";
                } else {
                    $date = getdate()[0];
                    $hashPwd = password_hash($pwd, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "sssssdd", $fName, $lName, $uid, $email, $hashPwd, $date, $date);
                    mysqli_stmt_execute($stmt);

                    $sql = "SELECT * FROM teachers WHERE username = '$uid'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $teacher_id = $row['id'];
                            $teacher = "STAFF/" . teacherID();
                            $sql1 = "UPDATE teachers SET teacherID = '$teacher' WHERE id = '$teacher_id';";
                            mysqli_query($conn, $sql1);
                            $sql2 = "INSERT INTO teacher_img (teacher_id, status) VALUES ($teacher_id, 0);";
                            mysqli_query($conn, $sql2);
                            echo "Registered Successfully";
                        }
                    }
                }
            }
        }
    }
} elseif (isset($_POST['display'])) {
    $sql = "SELECT * FROM teachers";
    $result = mysqli_query($conn, $sql);
    $resultChecker = mysqli_num_rows($result);
    // Settings
    $sql1 = "SELECT * FROM settings;";
    $result1 = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_assoc($result1);
    $school_short_name = $row1['school_short_name'];
    if ($resultChecker > 0) {
        $x = 0;
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $date = date("Y-m-d H:i:s", $row['last_login']);
            $array = array();
            $id = $row['id'];
            $array[] = ++$x;
            $array[] = $school_short_name . "/" . $row['teacherID'];
            $array[] = $row['fName'];
            $array[] = $row['lName'];
            $array[] = $row['email'];
            $t_sql = "SELECT * FROM teachers_enrollment WHERE teacher_id = $id;";
            $t_result = mysqli_query($conn, $t_sql);
            $t_num = mysqli_num_rows($t_result);
            $array[] = $t_num;
            $array[] = $row['phone'];
            $array[] = $date;
            $array[] = '<td>•••<div class="links shadow-sm">
            <form action="./teacher-photocard.php" method="post">
            <button name="id" value="' . $row['id'] . '">View Details</button>
            </form>
            <form action="./edit-teacher.php" method="post">
            <button type="submit" class="edit" name="edit" value="' . $row['id'] . '">Edit Details</button>
            </form>
            <button name="delete" value="' . $row['id'] . '" onclick="deleteTeacher(' . $row['id'] . ')">Delete Teacher</button>
          </div></td>';
            array_push($data, $array);
        }
        file_put_contents("../text/teachers.txt", '{"data":' . json_encode($data) . '}');
    } else {
        file_put_contents("../text/teachers.txt", '{"data":[[null,null,null,null,null,null,null,null,null]]}');
    }
} elseif (isset($_POST['remove'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM teachers WHERE id = '$id';";
    mysqli_query($conn, $sql);
    $sql2 = "DELETE FROM teacher_img WHERE teacher_id = '$id';";
    mysqli_query($conn, $sql2);
    $sql3 = "DELETE FROM teachers_enrollment WHERE teacher_id = '$id';";
    mysqli_query($conn, $sql3);
    $image = "../img-uploads/teacher" . $id . "*";
    $findFile = glob($image);
    if (count($findFile) > 0) {
        unlink($findFile[0]);
    }
    echo "Deleted Successfully!";
} elseif (isset($_POST['fetchTeacher'])) {
    $sql = "SELECT * FROM teachers";
    $result = mysqli_query($conn, $sql);
    $resultChecker = mysqli_num_rows($result);
    if ($resultChecker > 0) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode($data);
    }
} elseif (isset($_FILES['image'])) {
    $id = $_POST['id'];
    $uid = trim($_POST['uid']);
    $email = trim($_POST['email']);
    $image = $_FILES['image'];
    if (empty($uid) || empty($email) || empty($image)) {
        echo "Empty Fields";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid Email";
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $uid)) {
        echo "Input Valid Username";
    } else {
        if ($image['name'] === "") {
            $sql = "UPDATE teachers SET username = '$uid', email = '$email' WHERE id = '$id';";
            mysqli_query($conn, $sql);
            echo "Saved Successfully";
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
                        $img_des = "../img-uploads/";
                        $img_new_name = "teacher" . $id . "." . $img_ext;
                        $img_new_des = $img_des . $img_new_name;
                        move_uploaded_file($img_tmp_name, $img_new_des);
                        // Query Data Base
                        $sql = "UPDATE teachers SET username = '$uid', email = '$email' WHERE id = '$id';";
                        mysqli_query($conn, $sql);
                        $img_sql = "UPDATE teacher_img SET `status` = 1 WHERE teacher_id = '$id';";
                        mysqli_query($conn, $img_sql);
                        echo "Updated Successfully";
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
} elseif (isset($_POST['personal'])) {
    $id = $_POST['hidden'];
    $fName = trim($_POST['fName']);
    $lName = trim($_POST['lName']);
    $city = trim($_POST['city']);
    $phone = trim($_POST['phone']);
    $sex = $_POST['sex'];
    if (empty($fName) || empty($lName) || empty($city) || empty($phone)) {
        echo "Empty Input(s)";
    } else {
        $sql = "UPDATE teachers SET fName = '$fName', lName = '$lName', city = '$city', phone = '$phone', sex = '$sex' WHERE id = '$id';";
        mysqli_query($conn, $sql);
        echo "Saved Successfully";
    }
} elseif (isset($_POST['password'])) {
    $id = $_POST['id'];
    $pwd = trim($_POST['pwd']);
    $rpwd = trim($_POST['rpwd']);
    if (empty($pwd) || empty($rpwd)) {
        echo "Empty Input(s)";
    } elseif ($pwd !== $rpwd) {
        echo "Input Same Password";
    } else {
        $hashPwd = password_hash($pwd, PASSWORD_DEFAULT);
        $sql = "UPDATE teachers SET `password` = '$hashPwd' WHERE id = '$id';";
        mysqli_query($conn, $sql);
        echo "Password Changed Successfully";
    }
}

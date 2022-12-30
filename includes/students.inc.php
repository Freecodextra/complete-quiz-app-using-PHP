<?php
require_once("db.inc.php");
function studentID()
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
if (isset($_POST['addStudent'])) {
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
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?;";
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
                $sql = "INSERT INTO users (fName, lName, username, email, `password`, reg_date, last_login) VALUES (?, ?, ?, ?, ?, ?, ?);";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "SQL Error, Try Again";
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
                            $student = "STD/" . studentID();
                            $sql1 = "UPDATE users SET studentID = '$student' WHERE id = '$userid';";
                            mysqli_query($conn, $sql1);
                            $sql2 = "INSERT INTO `image` (userid, `state`) VALUES ($userid, 0);";
                            mysqli_query($conn, $sql2);
                            echo "Registered Successfully";
                        }
                    }
                }
            }
        }
    }
} elseif (isset($_POST['show'])) {
    $sql = "SELECT * FROM users";
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
            $array[] = ++$x;
            $array[] =  $school_short_name . "/" . $row['studentID'];
            $array[] = $row['fName'];
            $array[] = $row['lName'];
            $array[] = $row['username'];
            $array[] = $row['email'];
            // get class name
            $class_id = $row['level'];
            $sql2 = "SELECT * FROM classes WHERE id = '$class_id';";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $class_name = $row2['class_name'];
            $array[] = $class_name;
            $plan = $row['plan'] === "free" ? '<span class="badge bg-warning">Free</span>' : '<span class="badge bg-success">Paid</span>';
            $array[] = $plan;
            $array[] = $date;
            $array[] = '<td>•••<div class="links shadow-sm">
            <form action="./photocard.php" method="post">
            <button name="id" value="' . $row['id'] . '">View Details</button>
            </form>
            <form action="./edit-user.php" method="post">
            <button type="submit" class="edit" name="edit" value="' . $row['id'] . '">Edit User</button>
            </form>
            <button name="delete" value="' . $row['id'] . '" onclick="deleteStudent(' . $row['id'] . ')">Delete User</button>
            <button type="submit" name="upgrade" value="' . $row['id'] . '" onclick="upgradeUser(' . $row['id'] . ')">Upgrade User</button>
            <button type="submit" name="downgrade" value="' . $row['id'] . '" onclick="downgradeUser(' . $row['id'] . ')">Downgrade User</button>
          </div></td>';
            array_push($data, $array);
        }
        file_put_contents("../text/students.txt", '{"data":' . json_encode($data) . '}');
    } else {
        file_put_contents("../text/students.txt", '{"data":[[null,null,null,null,null,null,null,null,null,null]]}');
    }
} elseif (isset($_POST['remove'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM users WHERE id = '$id';";
    mysqli_query($conn, $sql);
    $sql2 = "DELETE FROM `image` WHERE userid = '$id';";
    mysqli_query($conn, $sql2);
    $sql3 = "DELETE FROM users_enrollment WHERE student_id = '$id';";
    mysqli_query($conn, $sql3);
    $image = "../img-uploads/student" . $id . "*";
    $findFile = glob($image);
    if (count($findFile) > 0) {
        unlink($findFile[0]);
    }
    echo "Deleted Successfully!";
} elseif (isset($_POST['fetchStudents'])) {
    $sql = "SELECT * FROM users";
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
            $sql = "UPDATE users SET username = '$uid', email = '$email' WHERE id = '$id';";
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
                        $img_new_name = "student" . $id . "." . $img_ext;
                        $img_new_des = $img_des . $img_new_name;
                        move_uploaded_file($img_tmp_name, $img_new_des);
                        // Query Database
                        $sql = "UPDATE users SET username = '$uid', email = '$email' WHERE id = '$id';";
                        mysqli_query($conn, $sql);
                        $img_sql = "UPDATE `image` SET `state` = 1 WHERE userid = '$id';";
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
    $level = $_POST['level'];
    if (empty($fName) || empty($lName) || empty($city) || empty($phone) || $level == -1) {
        echo "Empty Input(s)";
    } else {
        $sql = "UPDATE users SET fName = '$fName', lName = '$lName', city = '$city', phone = '$phone', sex = '$sex', `level` = '$level' WHERE id = '$id';";
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
        $sql = "UPDATE users SET `password` = '$hashPwd' WHERE id = '$id';";
        mysqli_query($conn, $sql);
        echo "Password Changed Successfully";
    }
} elseif (isset($_POST['upgrade'])) {
    $id = $_POST['id'];
    $sql = "SELECT plan FROM users WHERE id = '$id';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $plan = $row['plan'];
    if ($plan === "paid") {
        echo "Already Upgraded";
    } else {
        $sql = "UPDATE users SET plan = 'paid' WHERE id = '$id';
        ";
        mysqli_query($conn, $sql);
        echo "Upgraded Successfully";
    }
} elseif (isset($_POST['downgrade'])) {
    $id = $_POST['id'];
    $sql = "SELECT plan FROM users WHERE id = '$id';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $plan = $row['plan'];
    if ($plan === "free") {
        echo "Already Downgraded";
    } else {
        $sql = "UPDATE users SET plan = 'free' WHERE id = '$id';
        ";
        mysqli_query($conn, $sql);
        echo "Downgraded Successfully";
    }
} elseif (isset($_POST['fetchStudent'])) {
    $sql = "SELECT * FROM users";
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

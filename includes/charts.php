<?php

require "./db.inc.php";

if (isset($_POST['gender'])) {
    // Male
    $sql1 = "SELECT * FROM users WHERE sex = 'Male';";
    $resut1 = mysqli_query($conn, $sql1);
    $resultChecker1 = mysqli_num_rows($resut1);
    // Female
    $sql2 = "SELECT * FROM users WHERE sex = 'Female';";
    $result2 = mysqli_query($conn, $sql2);
    $resultChecker2 = mysqli_num_rows($result2);
    // Others
    $sql3 = "SELECT * FROM users WHERE sex = 'Others';";
    $result3 = mysqli_query($conn, $sql3);
    $resultChecker3 = mysqli_num_rows($result3);
    $total = $resultChecker1 + $resultChecker2 + $resultChecker3;
    $male = ($resultChecker1 / $total) * 100;
    $female = ($resultChecker2 / $total) * 100;
    $others = ($resultChecker3 / $total) * 100;
    $gender = array($male, $female, $others);
    echo json_encode($gender);
} elseif(isset($_POST['days'])) {
    $sql = "SELECT * FROM users;";
    $result = mysqli_query($conn, $sql);
    $data = array("sun"=>0,"mon"=>0,"tue"=>0,"wed"=>0,"thur"=>0,"fri"=>0,"sat"=>0);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $last_login = $row['last_login'];
         $last_date = getdate($last_login);
         $date = getdate();
         if ($last_date['mon'] == $date['mon']) {
            $days = $last_date['wday'];
                switch ($days) {
                    case 0:
                        $data['sun']++;
                    case 1:
                        $data['mon']++;
                    case 2:
                        $data['tue']++;
                    case 3:
                        $data['wed']++;
                    case 4:
                        $data['thur']++;
                    case 5:
                        $data['fri']++;
                    case 6:
                        $data['sat']++;
                }
         }
        }
    }
    echo json_encode($data);
} elseif (isset($_POST['overview'])) {
    $course_id = $_POST['courseId'];
    // students
    $sql1 = "SELECT * FROM users_enrollment WHERE course_id = '$course_id';";
    $result1 = mysqli_query($conn, $sql1);
    $num1 = mysqli_num_rows($result1);
    // topics
    $sql2 = "SELECT * FROM topics WHERE course_id = '$course_id';";
    $result2 = mysqli_query($conn, $sql2);
    $num2 = mysqli_num_rows($result2);
    // quizes
    $sql3 = "SELECT * FROM quizes WHERE course_id = '$course_id';";
    $result3 = mysqli_query($conn, $sql3);
    $num3 = mysqli_num_rows($result3);
    // questions
    $sql4 = "SELECT * FROM questions WHERE course_id = '$course_id';";
    $result4 = mysqli_query($conn, $sql4);
    $num4 = mysqli_num_rows($result4);
    $data = array($num1, $num2, $num3, $num4);
    echo json_encode($data);
}
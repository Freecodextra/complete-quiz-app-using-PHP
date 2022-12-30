<?php
session_start();
if (isset($_SESSION['id'])) {
    require "./db.inc.php";
    if (isset($_GET['quiz'])) {
        $user_id = $_SESSION['id'];
        $quiz_id = $_GET['quiz'];
        $sql = "SELECT * FROM quizes WHERE `id` = '$quiz_id';";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $course_id = $row['course_id'];
        $sql1 = "SELECT * FROM users_enrollment WHERE course_id = $course_id AND student_id = $user_id;";
        $result1 = mysqli_query($conn, $sql1);
        $resultChecker = mysqli_num_rows($result1);
        if ($resultChecker > 0) {
            header("Location: ./quiz-on.inc.php?quiz=" . $quiz_id . "&start=true");
        } else {
            header("Location: ../user/start.php?quiz=" . $quiz_id . "&error=enroll");
        }
    } else {
        header("Location: ../user/start.php?quiz=" . $quiz_id . "&error=quiz");
    }
} else {
    header("Location: ../user/login.php");
}

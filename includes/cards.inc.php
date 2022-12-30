<?php
require "./db.inc.php";
if (isset($_POST['fetchCategories'])) {
    $sql = "SELECT * FROM course_category";
    $result = mysqli_query($conn,$sql);
    $result_checker = mysqli_num_rows($result);
    echo $result_checker;
} elseif (isset($_POST['fetchCourses'])) {
    $sql = "SELECT * FROM courses";
    $result = mysqli_query($conn,$sql);
    $result_checker = mysqli_num_rows($result);
    echo $result_checker;
} elseif (isset($_POST['fetchTopics'])) {
    $sql = "SELECT * FROM topics";
    $result = mysqli_query($conn,$sql);
    $result_checker = mysqli_num_rows($result);
    echo $result_checker;
} elseif (isset($_POST['fetchQuizes'])) {
    $sql = "SELECT * FROM quizes";
    $result = mysqli_query($conn,$sql);
    $result_checker = mysqli_num_rows($result);
    echo $result_checker;
} elseif (isset($_POST['fetchStudents'])) {
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn,$sql);
    $result_checker = mysqli_num_rows($result);
    echo $result_checker;
} elseif (isset($_POST['fetchClasses'])) {
    $sql = "SELECT * FROM classes";
    $result = mysqli_query($conn,$sql);
    $result_checker = mysqli_num_rows($result);
    echo $result_checker;
} elseif (isset($_POST['fetchTeachers'])) {
    $sql = "SELECT * FROM teachers";
    $result = mysqli_query($conn,$sql);
    $result_checker = mysqli_num_rows($result);
    echo $result_checker;
} elseif (isset($_POST['fetchEnroll'])) {
    $course_id = $_POST['courseId'];
    $sql = "SELECT * FROM users_enrollment WHERE course_id = $course_id;";
    $result = mysqli_query($conn,$sql);
    $result_checker = mysqli_num_rows($result);
    echo $result_checker;
} elseif (isset($_POST['fetchExercise'])) {
    $course_id = $_POST['courseId'];
    $sql = "SELECT * FROM quizes WHERE course_id = $course_id;";
    $result = mysqli_query($conn,$sql);
    $result_checker = mysqli_num_rows($result);
    echo $result_checker;
} elseif (isset($_POST['fetchExercises'])) {
    $sql = "SELECT * FROM quizes;";
    $result = mysqli_query($conn,$sql);
    $result_checker = mysqli_num_rows($result);
    echo $result_checker;
} elseif (isset($_POST['fetchCourseTopics'])) {
    $course_id = $_POST['courseId'];
    $sql = "SELECT * FROM topics WHERE course_id = $course_id;";
    $result = mysqli_query($conn,$sql);
    $result_checker = mysqli_num_rows($result);
    echo $result_checker;
} elseif (isset($_POST['fetchQuestions'])) {
    $sql = "SELECT * FROM questions;";
    $result = mysqli_query($conn,$sql);
    $result_checker = mysqli_num_rows($result);
    echo $result_checker;
}
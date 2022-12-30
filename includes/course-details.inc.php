<?php
require "./db.inc.php";
if (isset($_POST['show'])) {
    $course_id =$_POST['courseId'];
    $sql = "SELECT * FROM users_enrollment WHERE course_id = $course_id;";
    $result = mysqli_query($conn,$sql);
    $resultChecker = mysqli_num_rows($result);
    if ($resultChecker > 0) {
        $x = 0;
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $student_id = $row['student_id'];
            $s_sql = "SELECT * FROM users WHERE id=$student_id;";
            $s_result = mysqli_query($conn,$s_sql);
            $s_row = mysqli_fetch_assoc($s_result);
            $date = date("Y-m-d H:i:s", $s_row['last_login']);
            $array = array();
            $array[] = ++$x;
            $array[] = $s_row['studentID'];
            $array[] = $s_row['fName'];
            $array[] = $s_row['lName'];
            $array[] = $s_row['username'];
            $array[] = $s_row['email'];
            // get class name
            $class_id = $s_row['level'];
            $sql2 = "SELECT * FROM classes WHERE id = '$class_id';";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $class_name = $row2['class_name'];
            $array[] = $class_name;
            $plan = $s_row['plan'] === "free" ? '<span class="badge bg-warning">Free</span>' : '<span class="badge bg-success">Paid</span>';
            $array[] = $plan;
            $array[] = $date;
            $array[] = '<td>•••<div class="links shadow-sm">
            <button name="view" value="' . $s_row['id'] . '" onclick="unenrollUser(' . $s_row['id'] . ')">Unenroll</button>
          </div></td>';
            array_push($data, $array);
        }
        file_put_contents("../text/course-details.txt", '{"data":' . json_encode($data) . '}');
    } else {
       file_put_contents("../text/course-details.txt",'{"data":[[null,null,null,null,null,null,null,null,null,null]]}');
    }
    

} elseif (isset($_POST['unenroll'])) {
    $student_id = $_POST['student'];
    $course_id = $_POST['courseId'];
    $sql = "DELETE FROM users_enrollment WHERE student_id = $student_id AND course_id = $course_id;";
    if (mysqli_query($conn,$sql)) {
        echo "Unenrolled Successfully";
    }
}
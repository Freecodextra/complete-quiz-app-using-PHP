<?php
require("./db.inc.php");
function courseID()
{
    $x = range(0, 9);
    $y = "";
    for ($i = 0; $i < 5; $i++) {
        $shuffle = shuffle($x);
        $rand_x = $x[array_rand($x)];
        $y .= $rand_x;
    }
    return $y;
}

if (isset($_POST['add'])) {
    $course_name = trim($_POST['courseName']);
    $course_short_name = trim($_POST['courseShortName']);
    $course_category_id = $_POST['courseCat'];
    $level = $_POST['level'];
    if (empty($course_name) || empty($course_short_name)) {
        echo "Empty Input";
    } elseif ($course_short_name == 0 || $level == 0) {
        echo "Select Level/Course Category";
    } else {
        $sql = "SELECT * FROM courses WHERE course_name = '$course_name' OR course_short_name = '$course_short_name';";
        $result = mysqli_query($conn, $sql);
        $resultChecker = mysqli_num_rows($result);
        if ($resultChecker > 0) {
            echo "Course Exist";
        } else {
            $sql = "INSERT INTO courses (course_id, course_category_id, course_name, course_short_name, `level`, date_created) VALUES (?,?,?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "Sql Error";
            } else {
                $course_id = courseID();
                $date = getdate()[0];
                mysqli_stmt_bind_param($stmt, "sdssdd", $course_id, $course_category_id, $course_name, $course_short_name, $level, $date);
                mysqli_stmt_execute($stmt);
                echo "Added Successfully";
            }
        }
    }
} 

elseif (isset($_POST['remove'])) {
    $id = $_POST['id'];
    // delete attempted and attempts
    $ss_sql = "SELECT * FROM quizes WHERE course_id = '$id';";
    $ss_result = mysqli_query($conn,$ss_sql);
    if(mysqli_num_rows($ss_result) > 0) {
        while($ss_row = mysqli_fetch_assoc($ss_result)) {
            $quiz_id = $ss_row['id'];
            $a_sql = "DELETE FROM attempted WHERE quiz_id = $quiz_id;";
            $b_sql = "DELETE FROM attempts WHERE quiz_id = $quiz_id;";
            mysqli_query($conn, $a_sql);
            mysqli_query($conn, $b_sql);

        }
    }
    // delete course
    $sql = "DELETE FROM courses WHERE id = '$id';";
    // delete course enrollments
    $te_sql = "DELETE FROM teachers_enrollment WHERE course_id = '$id';";
    $ue_sql = "DELETE FROM users_enrollment WHERE course_id = '$id';";
    // delete course topics and quizes
    $t_sql = "DELETE FROM topics WHERE course_id = '$id';";
    $q_sql = "DELETE FROM quizes WHERE course_id = '$id';";
    $qe_sql = "UPDATE questions SET course_id = 0, topic_id = 0 WHERE course_id = $id;";
    if (mysqli_query($conn, $sql) && mysqli_query($conn, $te_sql) && mysqli_query($conn, $ue_sql) && mysqli_query($conn, $t_sql) && mysqli_query($conn, $q_sql) && mysqli_query($conn, $qe_sql)) {
        echo "Deleted Successfully!";
    } else {
        echo "Can't delete course";
    }
}

elseif (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM courses WHERE id = '$id';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo json_encode($row);
        }
    }
} 

elseif (isset($_POST['update'])) {
    $id = $_POST['id'];
    $course_name = trim($_POST['courseName']);
    $course_short_name = trim($_POST['courseShortName']);
    $course_category_id = $_POST['courseCat'];
    $level = $_POST['level'];
    if (empty($course_name) || empty($course_short_name)) {
        echo "Empty Input";
    } elseif ($course_short_name == 0 || $level == 0) {
        echo "Select Level/Course Category";
    } else {
        $sql = "UPDATE courses SET course_name = '$course_name', course_short_name = '$course_short_name', course_category_id = '$course_category_id', `level` = $level WHERE id = '$id';";
        mysqli_query($conn, $sql);
        echo "Updated Successfully";
    }
} 

elseif (isset($_POST['display'])) {
    $sql = "SELECT * FROM courses";
    $result = mysqli_query($conn, $sql);
    $resultChecker = mysqli_num_rows($result);
    if ($resultChecker > 0) {
        $x = 0;
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $array = array();
            $courseCat = $row['course_category_id'];
            $cat = "SELECT * FROM course_category WHERE id = $courseCat;";
            $resultCat = mysqli_query($conn, $cat);
            $catName = mysqli_fetch_assoc($resultCat)['cat_name'];
            $date = date("Y-m-d H:i:s", $row['date_created']);
            $course_id = $row['id'];
            $array[] = ++$x;
            $array[] = $row['course_id'];
            $array[] = $row['course_short_name'];
            $array[] = $row['course_name'];
            $array[] = $catName;
            // get numer of enrolled students
            $u_sql = "SELECT * FROM users_enrollment WHERE course_id = $course_id;";
            $u_result = mysqli_query($conn, $u_sql);
            $teacher;
            $array[] = mysqli_num_rows($u_result);
            // Get name of assigned Teachers
            $c_sql = "SELECT * FROM teachers_enrollment WHERE course_id = $course_id;";
            $c_result = mysqli_query($conn, $c_sql);
            $teacher;
            if (mysqli_num_rows($c_result) > 0) {
                $c_row = mysqli_fetch_assoc($c_result);
                $teacher_id = $c_row['teacher_id'];
                $t_sql = "SELECT * FROM teachers WHERE id = $teacher_id;";
                $t_result = mysqli_query($conn, $t_sql);
                $t_row = mysqli_fetch_assoc($t_result);
                $teacher = $teacher = $t_row['fName'] . " " . $t_row['lName'];
            } else {
                $teacher = "None";
            }
            $array[] = $teacher;
            $array[] = $date;
            $array[] = '<td>•••<div class="links shadow-sm">
            <form method="POST" action="../admin/course-details.php">
            <button name="view" value="' . $row['id'] . '">View Details</button>
            </form>
             <button class="edit" name="edit" value="' . $row['id'] . '" onclick="updateCourse(' . $row['id'] . ')">Update Course</button> <button class="unassign" name="unassign" value="' . $row['id'] . '" onclick="unassignTeacher(' . $row['id'] . ')">Unassign Teacher</button>
             <button name="delete" value="' . $row['id'] . '" onclick="deleteCourse(' . $row['id'] . ')">Delete Course</button>
           </div></td>';
            array_push($data, $array);
        }
        file_put_contents("../text/courses.txt", '{"data":' . json_encode($data) . '}');
    } else {
        file_put_contents("../text/courses.txt", '{"data":[[null,null,null,null,null,null,null,null]]}');
    }
} elseif (isset($_POST['fetchCourse'])) {
    $sql = "SELECT * FROM courses";
    $result = mysqli_query($conn, $sql);
    $resultChecker = mysqli_num_rows($result);
    if ($resultChecker > 0) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode($data);
    }
} elseif (isset($_POST['assign'])) {
    $teacher_mail = $_POST['teacher'];
    $course_id = $_POST['courseId'];
    if (empty($teacher_mail) || $course_id == -1) {
        echo "Empty Field(s)";
    } else {
        $t_sql = "SELECT * FROM teachers WHERE email = '$teacher_mail';";
        $t_result = mysqli_query($conn, $t_sql);
        if (mysqli_num_rows($t_result) > 0) {
            $t_row = mysqli_fetch_assoc($t_result);
            $teacher_id = $t_row['id'];
            $sql = "SELECT * FROM teachers_enrollment WHERE course_id = $course_id";
            $result = mysqli_query($conn,$sql);
            if (mysqli_num_rows($result) == 0) {
                $sql = "INSERT INTO teachers_enrollment (teacher_id, course_id) VALUES ($teacher_id, $course_id);";
                if (mysqli_query($conn, $sql)) {
                    echo "Assigned Successfully";
            } 
            } else {
                echo "A Teacher has been enrolled for this course.";
                }
        } else {
           echo "Teacher Does not exist";
        }
        
    }
    
 } elseif (isset($_POST['unassign'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM teachers_enrollment WHERE course_id = $id;";
    if (mysqli_query($conn,$sql)) {
       echo "Unassigned Successfully";
    }
 } elseif (isset($_POST['enroll'])) {
    $student_mail = $_POST['student'];
    $course_id = $_POST['courseId'];
    if (empty($student_mail) || $course_id == -1) {
        echo "Empty Field(s)";
    } else {
        $t_sql = "SELECT * FROM users WHERE email = '$student_mail';";
        $t_result = mysqli_query($conn, $t_sql);
        if (mysqli_num_rows($t_result) > 0) {
            $t_row = mysqli_fetch_assoc($t_result);
            $student_id = $t_row['id'];
            $sql = "SELECT * FROM users_enrollment WHERE student_id = $student_id";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) == 3 && $t_row['plan'] == "free") {
                echo "Course limit reached for free plan users";
            } else {
                $c_sql = "SELECT * FROM users_enrollment WHERE student_id = $student_id AND course_id = $course_id;";
                $c_result = mysqli_query($conn, $c_sql);
                if (mysqli_num_rows($c_result) > 0) {
                    echo "Student already enrolled for this course";
                } else {
                    $sql = "INSERT INTO users_enrollment (student_id, course_id) VALUES ($student_id, $course_id);";
                    if (mysqli_query($conn, $sql)) {
                        echo "Enrolled Successfully";
                    }
                }
            }
        } else {
            echo "Student Does not exist";
        }
    }
}

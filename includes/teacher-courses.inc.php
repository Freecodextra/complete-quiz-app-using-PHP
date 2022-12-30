<?php
require "../includes/db.inc.php";
if (isset($_POST['fetchCourse'])) {
    $id = $_POST['teacherId'];
    $sql = "SELECT * FROM teachers_enrollment WHERE teacher_id = '$id';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $array = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $course_id = $row['course_id'];
            $sql = "SELECT * FROM courses WHERE id = $course_id";
            $result = mysqli_query($conn, $sql);
            $resultChecker = mysqli_num_rows($result);
            if ($resultChecker > 0) {
                $data = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
            }
            $array = $data;
        }
        echo json_encode($array);
    }
} elseif (isset($_POST['show'])) {
    $id = $_POST['teacherId'];
    $sql = "SELECT * FROM teachers_enrollment WHERE teacher_id = '$id';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $course_id = $row['course_id'];
            $sql = "SELECT * FROM topics WHERE course_id = '$course_id'";
            $result = mysqli_query($conn, $sql);
            $resultChecker = mysqli_num_rows($result);
            if ($resultChecker > 0) {
                $x = 0;
                $data = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $date = date("Y-m-d H:i:s", $row['date_created']);
                    $array = array();
                    $array[] = ++$x;
                    $array[] = $row['topicID'];
                    $array[] = $row['topic_name'];
                    $array[] = strlen($row['topic_desc']) > 50 ? substr($row['topic_desc'], 0, 50) . "..." : $row['topic_desc'];
                    // FETCH COURSE NAME
                    $course_id = $row['course_id'];
                    $course_sql = "SELECT * FROM courses WHERE id = '$course_id';";
                    $fetch_course = mysqli_query($conn, $course_sql);
                    $course = mysqli_fetch_assoc($fetch_course);
                    $array[] = $course['course_short_name'];
                    // FETCH LEVEL
                    $level_id = $course['level'];
                    $level_sql = "SELECT * FROM classes WHERE id = '$level_id';";
                    $fetch_level = mysqli_query($conn, $level_sql);
                    $level = mysqli_fetch_assoc($fetch_level);
                    $array[] = $level['class_name'];
                    // Fetch Number of exercises
                    $topic_id = $row['id'];
                    $e_sql = "SELECT * FROM quizes WHERE topic_id = $topic_id;";
                    $e_result = mysqli_query($conn, $e_sql);
                    $exercise = mysqli_num_rows($e_result);
                    $array[] = $exercise;
                    $array[] = $date;
                    $array[] = '<td>•••<div class="links shadow-sm">
                    <button name="view" value="' . $row['id'] . '" onclick="editTopic(' . $row['id'] . ')">Edit Topic</button>
                    <button type="submit" name="delete" value="' . $row['id'] . '" onclick="deleteTopic(' . $row['id'] . ')">Delete Topic</button>
                    <button type="submit" name="exercise" value="' . $row['id'] . '" onclick="addQuiz(' . $row['id'] . ')">Add Quiz</button>
                  </div></td>';
                    $data[] = $array;
                }
            }
        }
        file_put_contents("../text/teacher-topics.txt", '{"data":' . json_encode($data) . '}');
    } else {
        file_put_contents("../text/teacher-topics.txt", '{"data":[[null,null,null,null,null,null,null,null,null]]}');
    }
} elseif (isset($_POST['showq'])) {
    $id = $_POST['teacherId'];
    $sql = "SELECT * FROM teachers_enrollment WHERE teacher_id = '$id';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $course_id = $row['course_id'];
            $sql = "SELECT * FROM quizes WHERE course_id = '$course_id'";
            $result = mysqli_query($conn, $sql);
            $resultChecker = mysqli_num_rows($result);
            if ($resultChecker > 0) {
                $x = 0;
                $data = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $quiz_id = $row['id'];
                    $date1 = date("Y-m-d H:i:s", $row['start_date']);
                    $date2 = date("Y-m-d H:i:s", $row['end_date']);
                    $array = array();
                    $array[] = ++$x;
                    $array[] = $row['quizID'];
                    $array[] = $row['quiz_name'];
                    // FETCH COURSE NAME
                    $course_id = $row['course_id'];
                    $course_sql = "SELECT * FROM courses WHERE id = '$course_id';";
                    $fetch_course = mysqli_query($conn, $course_sql);
                    $course = mysqli_fetch_assoc($fetch_course);
                    $array[] = $course['course_short_name'];
                    // FETCH TOPIC NAME
                    $topic_id = $row['topic_id'];
                    $topic_sql = "SELECT * FROM topics WHERE id = '$topic_id';";
                    $fetch_topic = mysqli_query($conn, $topic_sql);
                    $topic = mysqli_fetch_assoc($fetch_topic);
                    // get questions number
                    $sql3 = "SELECT * FROM questions WHERE quiz_id = '$quiz_id';";
                    $result3 = mysqli_query($conn, $sql3);
                    $question_num = mysqli_num_rows($result3);
                    $array[] = $topic_id == 0 ? "default" : $topic['topic_name'];
                    $array[] = $question_num;
                    $array[] = $row['attempts'] == 1000 ? "Unlimited" : $row['attempts'];
                    $array[] = $row['duration'] . " minutes";
                    $array[] = $date1;
                    $array[] = $date2;
                    $array[] = '<td>•••<div class="links shadow-sm">
            <form method="post" action="./quiz.php?teacher='.$id.'">
            <button type="submit" name="view" value="' . $row['id'] . '">View Details</button>
            </form>
            <button name="view" value="' . $row['id'] . '" onclick="editQuiz(' . $row['id'] . ')">Edit Quiz</button>
            <button type="submit" name="delete" value="' . $row['id'] . '" onclick="deleteQuiz(' . $row['id'] . ')">Delete Quiz</button>
          </div></td>';
                    array_push($data, $array);
                }
            }
        }
        file_put_contents("../text/teacher-quizes.txt", '{"data":' . json_encode($data) . '}');
    } else {
        file_put_contents("../text/teacher-quizes.txt", '{"data":[[null,null,null,null,null,null,null,null,null,null,null]]}');
    }
} elseif (isset($_POST['display'])) {
    $id = $_POST['teacherId'];
    $sql = "SELECT * FROM teachers_enrollment WHERE teacher_id = '$id';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $course_id = $row['course_id'];
            $sql = "SELECT * FROM questions WHERE course_id = '$course_id'";
    $result = mysqli_query($conn, $sql);
    $resultChecker = mysqli_num_rows($result);
    if ($resultChecker > 0) {
        $x = 0;
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $array = array();
            $array[] = ++$x;
            $array[] = substr($row['question'], 0, 100);
            // Get Folder Name
            $folder = $row['folder'];
            $folder_sql = "SELECT * FROM question_folders WHERE id = $folder;";
            $folder_result = mysqli_query($conn, $folder_sql);
            $folder_row = mysqli_fetch_assoc($folder_result);
            $folder_name = $folder_row['folder_name'];
            $array[] = $folder == 0 ? "default" : $folder_name;
            // Get Course Name
            $course = $row['course_id'];
            $course_sql = "SELECT * FROM courses WHERE id = $course;";
            $course_result = mysqli_query($conn, $course_sql);
            $course_row = mysqli_fetch_assoc($course_result);
            $course_short_name = $course_row['course_short_name'];
            $array[] = $course_short_name;
            $array[] = "Multichoice";
            $array[] = '<td>•••<div class="links shadow-sm">
            <button type="submit" class="edit" name="edit" value="' . $row['id'] . '" onclick="editQuestion(' . $row['id'] . ')">Edit Question</button>
            <button name="delete" value="' . $row['id'] . '" onclick="deleteQuestion(' . $row['id'] . ')">Delete Question</button>
          </div></td>';
            array_push($data, $array);
        }
    }
        }
        file_put_contents("../text/teacher-questions.txt", '{"data":' . json_encode($data) . '}');
    } else {
        file_put_contents("../text/teacher-questions.txt", '{"data":[[null,null,null,null,null,null]]}');
    }
} elseif (isset($_POST['shows'])) {
    $class_id = $_POST['classId'];
    $class_name = $_POST['className'];
    $sql = "SELECT * FROM users WHERE `level` = '$class_id'";
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
            $array[] = $class_name;
            $plan = $row['plan'] === "free" ? '<span class="badge bg-warning">Free</span>' : '<span class="badge bg-success">Paid</span>';
            $array[] = $plan;
            $array[] = $date;
            $array[] = '<td>•••<div class="links shadow-sm">
            <form action="./photocard.php" method="post">
            <button name="id" value="' . $row['id'] . '">View Details</button>
            </form>
          </div></td>';
            array_push($data, $array);
        }
        file_put_contents("../text/teacher-students.txt", '{"data":' . json_encode($data) . '}');
    } else {
        file_put_contents("../text/teacher-students.txt", '{"data":[[null,null,null,null,null,null,null,null,null,null]]}');
    }
} elseif (isset($_POST['fetchStudents'])) {
    $class_id = $_POST['classId'];
    $sql = "SELECT * FROM users WHERE `level` = '$class_id'";
    $result = mysqli_query($conn, $sql);
    $resultChecker = mysqli_num_rows($result);
    if ($resultChecker > 0) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode($data);
    } else {
        echo "none";
    }
}

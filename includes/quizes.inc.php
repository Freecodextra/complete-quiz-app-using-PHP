<?php
require_once("db.inc.php");
function quizID()
{
    $x = range(0, 9);
    $y = "";
    for ($i = 0; $i < 7; $i++) {
        $shuffle = shuffle($x);
        $rand_x = $x[array_rand($x)];
        $y .= $rand_x;
    }
    return $y;
}

if (isset($_POST['addQuiz'])) {
    $topic = $_POST['topic'];
    $course = $_POST['course'];
    $quizName = trim($_POST['quizName']);
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $duration = $_POST['duration'];
    $attempts = $_POST['attempts'];
    $quizID = quizID();
    $start_date = strtotime($startDate);
    $end_date = strtotime($endDate);
    if (empty($quizName) || empty($startDate) || empty($endDate) || empty($duration) || $topic == -1 || $course == -1 || $duration == 0) {
        echo "Empty Field(s)";
    } else {
        $sql = "INSERT INTO quizes (quizID, course_id, topic_id, quiz_name, attempts, `start_date`, end_date,duration) VALUES ('$quizID', '$course', '$topic', '$quizName', '$attempts','$start_date',$end_date,$duration);";
        mysqli_query($conn, $sql);
        echo "Added Successfully";
    }
} elseif (isset($_POST['show'])) {
    $sql = "SELECT * FROM quizes";
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
            <form method="post" action="./quiz.php">
            <button type="submit" name="view" value="' . $row['id'] . '">View Details</button>
            </form>
            <button name="view" value="' . $row['id'] . '" onclick="editQuiz(' . $row['id'] . ')">Edit Quiz</button>
            <button type="submit" name="delete" value="' . $row['id'] . '" onclick="deleteQuiz(' . $row['id'] . ')">Delete Quiz</button>
          </div></td>';
            array_push($data, $array);
        }
        file_put_contents("../text/quizes.txt", '{"data":' . json_encode($data) . '}');
    } else {
        file_put_contents("../text/quizes.txt", '{"data":[[null,null,null,null,null,null,null,null,null,null,null]]}');
    }
} elseif (isset($_POST['remove'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM quizes WHERE id = '$id';";
    // Update all questions to default 
    $q_sql = "UPDATE questions SET quiz_id = 0 WHERE quiz_id = $id;";
    if (mysqli_query($conn, $sql) && mysqli_query($conn, $q_sql)) {
        echo "Deleted Successfully!";
    }
} elseif (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM quizes WHERE id = '$id';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row['id'];
            $data[] = $row['course_id'];
            $data[] = $row['topic_id'];
            $data[] = $row['quiz_name'];
            $start_date = $row['start_date'];
            $date11 = date("Y-m-d H:i", $start_date);
            $end_date = $row['end_date'];
            $date21 = date("Y-m-d H:i", $end_date);
            $data[] = $date11;
            $data[] = $date21;
            $data[] = $row['duration'];
            $data[] = $row['attempts'];
        }
        echo json_encode($data);
    }
} elseif (isset($_POST['update'])) {
    $topic = $_POST['topic'];
    $course = $_POST['course'];
    $quizName = trim($_POST['quizName']);
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $duration = $_POST['duration'];
    $attempts = $_POST['attempts'];
    $quizId = $_POST['quizId'];
    $start_date = strtotime($startDate);
    $end_date = strtotime($endDate);
    if (empty($quizName) || empty($startDate) || empty($endDate) || $topic == -1 || $course == -1 || $duration == 0) {
        echo "Empty Field(s)";
    } else {
        $sql = "UPDATE quizes SET course_id = '$course', topic_id = '$topic', quiz_name = '$quizName', attempts = '$attempts', `start_date` = '$start_date', end_date = '$end_date', duration = '$duration' WHERE id = '$quizId'";
        $q_sql = "UPDATE questions SET course_id = '$course', topic_id = '$topic' WHERE  quiz_id = $quizId;";
        if (mysqli_query($conn, $sql) && mysqli_query($conn, $q_sql)) {
            echo "Updated Successfully";
        }
    }
}

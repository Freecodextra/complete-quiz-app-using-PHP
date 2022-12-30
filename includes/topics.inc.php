<?php
require_once("db.inc.php");
function topicID()
{
    $x = range(0, 9);
    $y = "";
    for ($i = 0; $i < 6; $i++) {
        $shuffle = shuffle($x);
        $rand_x = $x[array_rand($x)];
        $y .= $rand_x;
    }
    return $y;
}

if (isset($_POST['addTopic'])) {
    $course_id = $_POST['course'];
    $topicName = trim($_POST['topicName']);
    $topicDesc = trim($_POST['topicDesc']);

    if (empty($topicName) || empty($topicDesc) || $course_id === 0) {
        echo "Empty Input(s)";
    } else {
        $sql = "SELECT * FROM topics WHERE topic_name = '$topicName' OR topic_desc = '$topicDesc';";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            echo "Topic Already Exist";
        } else {
            $topicID = topicID();
            $date = getdate()[0];
            $sql = "INSERT INTO topics (topicID, course_id, topic_name, topic_desc, date_created) VALUES ($topicID, '$course_id', '$topicName', '$topicDesc', $date);";
            mysqli_query($conn, $sql);
            echo "Added Successfully";
        }
    }
} elseif (isset($_POST['show'])) {
    $sql = "SELECT * FROM topics";
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
            array_push($data, $array);
        }
        file_put_contents("../text/topics.txt", '{"data":' . json_encode($data) . '}');
    } else {
        file_put_contents("../text/topics.txt", '{"data":[[null,null,null,null,null,null,null,null,null]]}');
    }
} elseif (isset($_POST['remove'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM topics WHERE id = $id;";
    $e_sql = "DELETE FROM quizes WHERE topic_id = $id;";
    $q_sql = "UPDATE questions SET topic_id = 0, quiz_id = 0 WHERE topic_id = $id;";
    if (mysqli_query($conn, $sql) && mysqli_query($conn, $e_sql) && mysqli_query($conn, $q_sql)) {
        echo "Deleted Successfully!";
    }
} elseif (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM topics WHERE id = '$id';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo json_encode($row);
        }
    }
} elseif (isset($_POST['update'])) {
    $id = $_POST['hidden'];
    $course_id = $_POST['course'];
    $prev_course = $_POST['prevCourse'];
    $topicName = trim($_POST['topicName']);
    $topicDesc = trim($_POST['topicDesc']);
    if (empty($topicName) || empty($topicDesc) || $course_id == 0) {
        echo "Empty Input(s)";
    } else {
        $sql = "UPDATE topics SET course_id = '$course_id', topic_name = '$topicName', topic_desc = '$topicDesc' WHERE id = '$id';";
        $q_sql = "UPDATE quizes SET course_id = '$course_id' WHERE  topic_id = '$id';";
        $qq_sql = "UPDATE questions SET course_id = '$course_id', topic_id = '$id' WHERE  course_id = '$prev_course' AND topic_id = '$id';";
        if (mysqli_query($conn, $sql) && mysqli_query($conn, $q_sql) && mysqli_query($conn, $qq_sql)) {
            echo "Edited Successfully";
        }
    }
} elseif (isset($_POST['quiz'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM topics WHERE id = '$id';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    echo json_encode($row);
} elseif (isset($_POST['fetchTopics'])) {
    $course_id = $_POST['course_id'];
    if ($course_id == 0) {
        $sql = "SELECT * FROM topics;";
    } else {
        $sql = "SELECT * FROM topics WHERE course_id = '$course_id';";
    }
    $result = mysqli_query($conn, $sql);
    $resultChecker = mysqli_num_rows($result);
    if ($resultChecker > 0) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode($data);
    } else {
        echo "";
    }
}

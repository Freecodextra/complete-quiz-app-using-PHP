<?php
require "./db.inc.php";
if (isset($_POST['quiz'])) {
    $quiz = $_POST['quiz'];
    $topic = $_POST['topic'];
    $course = $_POST['course'];
    $question = str_replace("'", "''", trim($_POST['question']));
    $opt1 = trim($_POST['opt1']);
    $opt2 = trim($_POST['opt2']);
    $opt3 = trim($_POST['opt3']);
    $opt4 = trim($_POST['opt4']);
    $opt5 = trim($_POST['opt5']);
    $answer = $_POST['answer'];
    $image = $_FILES['image'];
    if (empty($question) || empty($opt1) || empty($opt2) || $answer == -1) {
        echo "Empty Field(s)!";
    } else {
        if ($image['name'] === "") {
            $sql = "INSERT INTO questions (course_id,topic_id, quiz_id, question) VALUES ($course, $topic, $quiz, '$question');";
            if (mysqli_query($conn, $sql)) {
                $question_id = mysqli_insert_id($conn);
                $options = array($opt1, $opt2, $opt3, $opt4, $opt5);
                foreach ($options as $option => $value) {
                    if ($value != "") {
                        $value = str_replace("'", "''", $value);
                        if ($option == $answer) {
                            $osql = "INSERT INTO options (question_id, `option`, answer) VALUES ($question_id, '$value', 1);";
                        } else {
                            $osql = "INSERT INTO options (question_id, `option`) VALUES ($question_id, '$value');";
                        }
                        mysqli_query($conn, $osql);
                    }
                }
            }
            echo "Added Successfully";
        } else {
            // Query Data Base
            $sql = "INSERT INTO questions (course_id,topic_id, quiz_id, question) VALUES ($course, $topic, $quiz, '$question');";
            if (mysqli_query($conn, $sql)) {
                $question_id = mysqli_insert_id($conn);
                $options = array($opt1, $opt2, $opt3, $opt4, $opt5);
                foreach ($options as $option => $value) {
                    if ($value != "") {
                        $value = str_replace("'", "''", $value);
                        if ($option == $answer) {
                            $osql = "INSERT INTO options (question_id, `option`, answer) VALUES ($question_id, '$value', 1);";
                        } else {
                            $osql = "INSERT INTO options (question_id, `option`) VALUES ($question_id, '$value');";
                        }
                        mysqli_query($conn, $osql);
                    }
                }
            }

            // Save Image
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
                        $img_des = "../question-img/";
                        $img_new_name = "question" . $question_id . "." . $img_ext;
                        $img_new_des = $img_des . $img_new_name;
                        move_uploaded_file($img_tmp_name, $img_new_des);
                        $img_sql = "UPDATE questions SET `image` = 1 WHERE id = '$question_id';";
                        mysqli_query($conn, $img_sql);
                        echo "Added Successfully";
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
} elseif (isset($_POST['getQuestions'])) {
    // AND quiz_id = 0
    $folder = $_POST['folder'];
    $sql = "SELECT * FROM questions WHERE folder = '$folder';";
    $result = mysqli_query($conn, $sql);
    $x = 0;
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $array = array();
            $array[] = ++$x;
            $array[] = substr($row['question'], 0, 100);
            // Get Course Name
            $course = $row['course_id'];
            $course_sql = "SELECT * FROM courses WHERE id = $course;";
            $course_result = mysqli_query($conn, $course_sql);
            $course_row = mysqli_fetch_assoc($course_result);
            $course_short_name = $course_row['course_short_name'];
            $array[] = $course_short_name;
            // Get Topic Name
            $topic = $row['topic_id'];
            if ($topic > 0) {
                $topic_sql = "SELECT * FROM topics WHERE id = $topic;";
                $topic_result = mysqli_query($conn, $topic_sql);
                $topic_row = mysqli_fetch_assoc($topic_result);
                $topic_name = $topic_row['topic_name'];
            }
            $array[] = $topic == 0 ? "default" : $topic_name;
            $array[] = "Multichoice";
            $array[] = $row['id'];
            array_push($data, $array);
        }
        echo json_encode($data);
    } else {
        echo "null";
    }
} elseif (isset($_POST['c-quiz'])) {
    if (isset($_POST['questions'])) {
        $question_ids = $_POST['questions'];
        $topic_id = $_POST['c-topic'];
        $quiz_id = $_POST['c-quiz'];
        echo json_encode($question_ids);
        foreach ($question_ids as $question_id) {
            $sql = "UPDATE questions SET topic_id = $topic_id, quiz_id = $quiz_id WHERE id = $question_id";
            mysqli_query($conn, $sql);
        }
        echo "Imported Successfully";
    } else {
        echo "Select at least one question";
    }
} elseif (isset($_POST['show'])) {
    $id = $_POST['quizId'];
    $sql = "SELECT * FROM attempted WHERE quiz_id = '$id'";
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
            $user_id = $row['user_id'];
            $score = $row['score'];
            $attempts = $row['attempts'];
            $user_id = $row['user_id'];
            $date1 = date("Y-m-d H:i:s", $row['date_started']);
            $date2 = date("Y-m-d H:i:s", $row['date_submited']);
            $array = array();
            $array[] = ++$x;
            // FETCH STUDENT NAME
            $user_sql = "SELECT * FROM users WHERE id = '$user_id';";
            $fetch_user = mysqli_query($conn, $user_sql);
            $user = mysqli_fetch_assoc($fetch_user);
            $array[] = $school_short_name . "/" . $user['studentID'];
            $array[] = $user['fName'];
            $array[] = $user['lName'];
            $array[] = $attempts;
            $array[] = $score;
            $array[] = $date1;
            $array[] = $date2;
            $array[] = '<td>•••<div class="links shadow-sm">
            <form method="post" action="./quiz-result.php">
            <button type="submit" name="view" value="' . $id . '.' . $user_id . '">View Result</button>
            </form>
            <button type="submit" name="delete" value="' . $id . '.' . $user_id . '" onclick="deleteAttempt(' . $id . '.' . $user_id . ')">Delete Attempt</button>
          </div></td>';
            array_push($data, $array);
        }
        file_put_contents("../text/attempts.txt", '{"data":' . json_encode($data) . '}');
    } else {
        file_put_contents("../text/attempts.txt", '{"data":[[null,null,null,null,null,null,null,null,null]]}');
    }
} elseif (isset($_POST['attemptNum'])) {
    $id = $_POST['quizId'];
    $sql = "SELECT * FROM attempted WHERE quiz_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $result_checker = mysqli_num_rows($result);
    $x = 0;
    if ($result_checker > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $attempts = $row['attempts'];
            $x += $attempts;
        }
    }
    echo $x;
} elseif (isset($_POST['averageScore'])) {
    $id = $_POST['quizId'];
    $sql = "SELECT * FROM attempted WHERE quiz_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $result_checker = mysqli_num_rows($result);
    $x = 0;
    $y = 0;
    if ($result_checker > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $y++;
            $score = $row['score'];
            $x += $score;
        }
        $z = $x / $y;
        echo round($z,2);
    } else {
        echo 0;
    }
} elseif (isset($_POST['percentagePass'])) {
    $id = $_POST['quizId'];
    $sql = "SELECT * FROM attempted WHERE quiz_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $result_checker = mysqli_num_rows($result);
    $x = 0;
    $y = 0;
    if ($result_checker > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $percentage = $row['percentage'];
            if ($percentage >= 50) {
                $y++;
                $x += $percentage;
            }
        }
        $z = $x / $y;
        echo round($z,2);
    } else {
        echo 0;
    }
} elseif (isset($_POST['remove'])) {
    $user = $_POST['user'];
    $quiz = $_POST['quizId'];
    $sql = "DELETE FROM attempted WHERE quiz_id = '$quiz' AND user_id = '$user'";
    if (mysqli_query($conn, $sql)) {
        echo "Deleted Successfully";
    }
}

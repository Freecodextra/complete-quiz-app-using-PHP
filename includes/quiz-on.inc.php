<?php
session_start();
if (isset($_SESSION['id'])) {
    function canAttempt($conn, $user_id, $quiz_id)
    {
        $att = "SELECT * FROM attempted WHERE user_id = '$user_id' AND quiz_id = '$quiz_id';";
        $att_res = mysqli_query($conn, $att);
        if (mysqli_num_rows($att_res) > 0) {
            $att_row = mysqli_fetch_assoc($att_res);
            $attempts = $att_row['attempts'];
        } else {
            $attempts = 0;
        }
        $arr = "SELECT * FROM quizes WHERE id = '$quiz_id';";
        $arr_res = mysqli_query($conn, $arr);
        $arr_row = mysqli_fetch_assoc($arr_res);
        $num_of_attempts = $arr_row['attempts'];
        if ($attempts >= $num_of_attempts) {
            return false;
        } else {
            return true;
        }
    }
    function quizExpire($conn,$quiz_id) {
        $sql = "SELECT * FROM quizes WHERE id = '$quiz_id';";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $date = $row['end_date'];
        $now = getdate()[0];
        if ($now > $date) {
            return false;
        } else {
            return true;
        }
    }
    function canStart($conn,$quiz_id) {
        $sql = "SELECT * FROM quizes WHERE id = '$quiz_id';";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $date = $row['start_date'];
        $now = getdate()[0];
        if ($now > $date) {
            return true;
        } else {
            return false;
        }
    }
    function updateLeaderBoard($conn, $user_id) {
        $sql = "SELECT * FROM attempted WHERE user_id = '$user_id';";
        $result = mysqli_query($conn, $sql);
        $total_percent = 0;
        $quiz_no = 0;
        $average_percent = 0;
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $quiz_no++;
                $percent = $row['percentage'];
                $total_percent += $percent;
            }
        }
        $average_percent = $total_percent / $quiz_no;
        $sql1 = "SELECT * FROM leaderboard WHERE user_id = '$user_id';";
        $result1 = mysqli_query($conn, $sql1);
        if(mysqli_num_rows($result1) > 0) {
            $sql2 = "UPDATE leaderboard SET quiz_no = '$quiz_no', `percentage` = '$average_percent' WHERE user_id = '$user_id';";
        } else {
            $sql2 = "INSERT INTO leaderboard (user_id, quiz_no, `percentage`) VALUES ('$user_id','$quiz_no','$average_percent')";
        }
        mysqli_query($conn, $sql2);
    }
    require "./db.inc.php";
    if (isset($_GET['start'])) {
        $user_id = $_SESSION['id'];
        $quiz_id = $_GET['quiz'];
        $_SESSION['token'] = "quiz-token";
        $sql1 = "DELETE FROM attempts WHERE user_id = '$user_id' AND quiz_id = '$quiz_id';";
        mysqli_query($conn, $sql1);
        // get quiz number of question
        $sql2 = "SELECT * FROM questions WHERE quiz_id = '$quiz_id';";
        $result2 = mysqli_query($conn, $sql2);
        $total_questions = mysqli_num_rows($result2);
        $startDate = getdate()[0];
        for ($i = 1; $i <= $total_questions; $i++) {
            $sql3 = "INSERT INTO attempts (user_id, quiz_id, question_id, answer, correct, `date_started`) VALUES('$user_id', '$quiz_id', '$i', 0, 0, '$startDate');";
            mysqli_query($conn, $sql3);
        }
        if(canStart($conn, $quiz_id)) {
            if(quizExpire($conn, $quiz_id)) {
                if (canAttempt($conn, $user_id, $quiz_id)) {
                    header("Location: ../user/quiz.php?quiz=$quiz_id&q=1&user=$user_id&date=$startDate");
                }
                 else {
                    header("Location: ../user/start.php?quiz=$quiz_id&user=$user_id&error=attempt");
                }
            } else {
                header("Location: ../user/start.php?quiz=$quiz_id&user=$user_id&error=end");
            }
        } else {
            header("Location: ../user/start.php?quiz=$quiz_id&user=$user_id&error=start");
        }
    }
    if (isset($_POST['next'])) {
        $user_id = $_SESSION['id'];
        $quiz_id = $_POST['quiz'];
        if($_SESSION['token'] != "") {
            if (isset($_POST['option'])) {
                $option = $_POST['option'];
            } else {
                $option = 0;
            }
            $question_num = (int) $_POST['q'];
            $total_questions = $_POST['total'];
            $correct = $_POST['correct'];
            if ($question_num >= $total_questions) {
                $next = 1;
            } else {
                $next = $question_num + 1;
            }
            $sql = "UPDATE attempts SET answer = '$option', correct = '$correct' WHERE user_id = '$user_id' AND quiz_id = '$quiz_id' AND question_id = '$question_num';";
            if (mysqli_query($conn, $sql)) {
                // get start date
                $sql2 = "SELECT * FROM attempts WHERE user_id = $user_id AND quiz_id = $quiz_id;";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);
                $startDate = $row2['date_started'];
                header("Location: ../user/quiz.php?quiz=$quiz_id&q=$next&user=$user_id&date=$startDate");
            }
        } else {
            header("Location: ../user/start.php?quiz=$quiz_id&user=$user_id&error=token");
        }
    }
    if (isset($_POST['prev'])) {
        $user_id = $_SESSION['id'];
        $quiz_id = $_POST['quiz'];
        if($_SESSION['token'] != "") {
        if (isset($_POST['option'])) {
            $option = $_POST['option'];
        } else {
            $option = 0;
        }
        $question_num = (int) $_POST['q'];
        $total_questions = $_POST['total'];
        $correct = $_POST['correct'];
        if ($question_num <= 1) {
            $prev = $total_questions;
        } else {
            $prev = $question_num - 1;
        }
        $sql = "UPDATE attempts SET answer = '$option', correct = '$correct' WHERE user_id = '$user_id' AND quiz_id = '$quiz_id' AND question_id = '$question_num';";
        if (mysqli_query($conn, $sql)) {
            // get start date
            $sql2 = "SELECT * FROM attempts WHERE user_id = $user_id AND quiz_id = $quiz_id;";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $startDate = $row2['date_started'];
            header("Location: ../user/quiz.php?quiz=$quiz_id&q=$prev&user=$user_id&date=$startDate");
        }
    } else {
        header("Location: ../user/start.php?quiz=$quiz_id&user=$user_id&error=token");
    }
    }
    if (isset($_POST['finish'])) {
        $user_id = $_SESSION['id'];
        $quiz_id = $_POST['quiz'];
        if($_SESSION['token'] != "") {
        $date = $_POST['date'];
        if (isset($_POST['option'])) {
            $option = $_POST['option'];
        } else {
            $option = 0;
        }
        $question_num = (int) $_POST['q'];
        $correct = $_POST['correct'];
        $sql = "UPDATE attempts SET answer = '$option', correct = '$correct' WHERE user_id = '$user_id' AND quiz_id = '$quiz_id' AND question_id = '$question_num';";
        if (mysqli_query($conn, $sql)) {
            header("Location: ../user/end.php?quiz=$quiz_id&q=$question_num&user=$user_id&date=$date");
        }
    } else {
        header("Location: ../user/start.php?quiz=$quiz_id&user=$user_id&error=token");
    }
    }
    if (isset($_POST['return'])) {
        $user_id = $_SESSION['id'];
        $quiz_id = $_POST['quiz'];
        if($_SESSION['token'] != "") {
        $question_num = (int) $_POST['q'];
        // get start date
        $sql2 = "SELECT * FROM attempts WHERE user_id = $user_id AND quiz_id = $quiz_id;";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $startDate = $row2['date_started'];
        header("Location: ../user/quiz.php?quiz=$quiz_id&q=$question_num&user=$user_id&date=$startDate");
    } else {
        header("Location: ../user/start.php?quiz=$quiz_id&user=$user_id&error=token");
    }
    }
    if (isset($_POST['submit'])) {
        $user_id = $_SESSION['id'];
        $quiz_id = $_POST['quiz'];
        $question_num = (int) $_POST['q'];
        $_SESSION['token'] = "";
        // get score
        $sql2 = "SELECT * FROM attempts WHERE user_id='$user_id' AND quiz_id='$quiz_id';";
        $result2 = mysqli_query($conn, $sql2);
        $score = 0;
        $total_questions = 0;
        $startDate = 0;
        $endDate = getdate()[0];
        while ($row2 = mysqli_fetch_assoc($result2)) {
            $answer = $row2['answer'];
            $correct = $row2['correct'];
            $startDate = $row2['date_started'];
            if ($answer != 0 && $answer == $correct) {
                $score++;
            }
            $total_questions++;
        }
        $scorePercentage = ($score / $total_questions) * 100;
        $sql = "SELECT * FROM attempted WHERE user_id = '$user_id' AND quiz_id = '$quiz_id';";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $attempts = $row['attempts'];
            $newAttempts = $attempts + 1;
            $sql2 = "UPDATE attempted SET attempts = '$newAttempts', score = '$score', `percentage` = '$scorePercentage', date_started = '$startDate', date_submited = '$endDate' WHERE user_id = '$user_id' AND quiz_id = '$quiz_id';";
        } else {
            $sql2 = "INSERT INTO attempted (user_id, quiz_id, attempts, score, `percentage`,date_started, date_submited) VALUES ('$user_id','$quiz_id',1,'$score','$scorePercentage','$startDate',  '$endDate')";
        }
        mysqli_query($conn, $sql2);
        updateLeaderBoard($conn, $user_id);
        header("Location: ../user/overview.php?quiz=$quiz_id&percent=$scorePercentage&user=$user_id&score=$score");
    }
    if (isset($_POST['restart'])) {
        $user_id = $_SESSION['id'];
        $quiz_id = $_POST['quiz'];
        header("Location: ./quiz-on.inc.php?quiz=" . $quiz_id . "&start=true");
    }
    if (isset($_POST['result'])) {
        $user_id = $_SESSION['id'];
        $quiz_id = $_POST['quiz'];
        header("Location: ../user/result.php?quiz=$quiz_id&user=$user_id");
    }
} else {
    header("Location: ../user/login.php");
}

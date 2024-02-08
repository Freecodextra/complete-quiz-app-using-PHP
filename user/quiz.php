<?php
if (isset($_GET['quiz']) && $_GET['q']) {
  require "../includes/db.inc.php";
  $quiz_id = $_GET['quiz'];
  $question_num = (int) $_GET['q'];
  $user_id = $_GET['user'];
  $date = $_GET['date'];
  $offset = $question_num - 1;
  // get quiz duration (60 should be added to the duration for live server)
  $sql6 = "SELECT * FROM quizes WHERE id = $quiz_id;";
  $result6 = mysqli_query($conn, $sql6);
  $row6 = mysqli_fetch_assoc($result6);
  $duration = $row6['duration'];

  // get quiz number of question
  $sql = "SELECT * FROM questions WHERE quiz_id = '$quiz_id';";
  $result = mysqli_query($conn, $sql);
  $total_questions = mysqli_num_rows($result);

  // get question
  $sql3 = "SELECT * FROM questions WHERE quiz_id = '$quiz_id';";
  $result3 = mysqli_query($conn, $sql3);
  $data = array();
  while ($row3 = mysqli_fetch_assoc($result)) {
    $data[] = $row3;
  }
  $question_id = $data[$offset]['id'];
  $question_image = $data[$offset]['image'];
  $question = $data[$offset]['question'];
  $course_id = $data[$offset]['course_id'];

  // get course name and short name
  $sql1 = "SELECT * FROM courses WHERE `id` = '$course_id';";
  $result1 = mysqli_query($conn, $sql1);
  $row1 = mysqli_fetch_assoc($result1);
  $course_name = $row1['course_name'];
  $short_name = $row1['course_short_name'];

  // get options
  $sql2 = "SELECT * FROM options WHERE question_id = '$question_id';";
  $result2 = mysqli_query($conn, $sql2);

  // get correct option
  $sql4 = "SELECT * FROM options WHERE question_id = '$question_id' AND answer = 1;";
  $result4 = mysqli_query($conn, $sql4);
  $row4 = mysqli_fetch_assoc($result4);
  $correct = $row4['id'];
  // get timer
  $stamp = $duration * 60;
  $actualDate = $date + $stamp;
  $actualDateString = date("Y-m-d H:i:s", $actualDate);
  function logoSrc()
  {
    $file = "../images/logo*";
    $fileSearch = glob($file);
    return $fileSearch[0];
  }
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ================ BOOTSTRAP CDN -================= -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- ============ BOOTSTRAP ICON CDN ===========================-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- =================== JQUERY CDN ======================= -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="../public/style.css">
    <link rel="shortcut icon" href="<?php echo logoSrc() ?>" type="image/x-icon">
    <title>Quiz - Quiz App</title>
  </head>

  <body>
    <?php
    require("./header.php");
    require("./navbar.php");
    ?>
    <!-- ======================== MAIN CONTENT ===================== -->
    <main>
      <div class="quiz">
        <div class="quiz-head">
          <h4><?php echo   $short_name; ?> - <?php echo $course_name; ?></h4>
          <div class="time"><i class="bi bi-stopwatch"></i> Timer: <span id="timer"></span></div>
        </div>
        <div class="quiz-body">
          <div class="quiz-body-head">
            <div class="question">Question <?php echo $question_num; ?> of <?php echo $total_questions; ?></div>
            <div class="sound"><i class="bi bi-volume-up"></i></div>
          </div>
          <div class="quiz-body-body">
            <div class="question">
              <h5><?php echo $question; ?></h5>
              <?php
              if ($question_image == 1) {
                $src;
                $file = "../question-img/question" . $question_id . "*";
                $fileSearch = glob($file);
                if (count($fileSearch) > 0) {
                  $file_path = $fileSearch[0];
                  if (file_exists($file_path)) {
                    $src = $file_path;
                  } else {
                    $src = "../images/avatar.png";
                  }
                }
                echo '<img src="' . $src . '" id="question-img"/>';
              }
              ?>
            </div>
            <div class="options">
              <form action="../includes/quiz-on.inc.php" method="POST">
                <?php
                $x = 0;
                $alpha = array("", "A", "B", "C", "D", "E", "F", "G", "H");
                // check selected
                $sql5 = "SELECT * FROM attempts WHERE question_id = '$question_num' AND user_id = '$user_id' AND quiz_id = '$quiz_id';";
                $result5 = mysqli_query($conn, $sql5);
                $row5 = mysqli_fetch_assoc($result5);
                $selected = $row5['answer'];
                while ($row2 = mysqli_fetch_assoc($result2)) {
                  $x++;
                  $option_name = $row2['option'];
                  $option_id = $row2['id'];
                  if ($selected == $option_id) {
                    echo '<div class="option">
                      <span>' . $alpha[$x] . '.</span>
                      <input type="radio" name="option" id="option' . $x . '" value="' . $option_id . '" checked>
                      <label for="option' . $x . '">' . $option_name . '</label>
                    </div>';
                  } else {
                    echo '<div class="option">
                      <span>' . $alpha[$x] . '.</span>
                      <input type="radio" name="option" id="option' . $x . '" value="' . $option_id . '">
                      <label for="option' . $x . '">' . $option_name . '</label>
                    </div>';
                  }
                }
                ?>
                <!-- hidden -->
                <input type="hidden" name="quiz" value="<?php echo $quiz_id; ?>">
                <input type="hidden" name="q" value="<?php echo $question_num; ?>">
                <input type="hidden" name="total" value="<?php echo $total_questions; ?>">
                <input type="hidden" name="correct" value="<?php echo $correct; ?>">
                <input type="hidden" name="date" value="<?php echo $date; ?>">
                <div class="buttons">
                  <button class="btn btn-warning" type="submit" name="prev">Previous</button>
                  <button class="btn btn-primary" type="submit" name="next">Next</button>
                  <button class="btn btn-danger" type="submit" name="finish" id="finish">Finish</button>
                  <!-- submit when time is up -->
                  <button class="btn btn-danger" type="submit" name="submit" id="submit" style="visibility: hidden;">Sumit</button>
                </div>
              </form>
            </div>
          </div>
          <div class="quiz-footer">
            <div class="quiz-footer-head">
              <h5>Quick Links</h5>
            </div>
            <div class="quiz-footer-body">
              <?php
              $sql3 = "SELECT * FROM attempts WHERE user_id = '$user_id' AND quiz_id = '$quiz_id';";
              $result3 = mysqli_query($conn, $sql3);
              $y = 0;
              while ($row3 = mysqli_fetch_assoc($result3)) {
                $y++;
                $answer = $row3['answer'];
                if ($answer == 0) {
                  echo '<a href="./quiz.php?quiz=' . $quiz_id . '&q=' . $y . '&user=' . $user_id . '&date=' . $date . '" class="btn border-primary text-primary mx-1">' . $y . '</a>';
                } else {
                  echo '<a href="./quiz.php?quiz=' . $quiz_id . '&q=' . $y . '&user=' . $user_id . '&date=' . $date . '" class="btn btn-primary mx-1">' . $y . '</a>';
                }
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </main>
    </div>
    <?php
    require "../admin/footer.php";
    ?>
    <script src="../public/app.js"></script>
    <script src="../public/loader.js"></script>
    <script src="../public/text2speech.js"></script>
    <script>
      let countDownDate = new Date("<?php echo $actualDateString; ?>").getTime();
      let x = setInterval(function() {
        let now = new Date().getTime();
        let diff = countDownDate - now;
        let minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((diff % (1000 * 60)) / (1000));
        let timer = minutes + ":" + seconds;
        $("#timer").html(timer);
        if (minutes == 0 && seconds == 0) {
          clearInterval(x);
          document.getElementById("submit").click();
        }
      }, 1000);
    </script>
  </body>

  </html>
<?php
} else {
  header("Location: ./index.php");
}
?>
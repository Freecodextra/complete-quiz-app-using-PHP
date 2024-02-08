<?php
session_start();
if (isset($_SESSION['admin'])) {
  if (isset($_POST['view'])) {
    require "../includes/db.inc.php";
    $both = (string) $_POST['view'];
    $bothArr = explode(".", $both);
    $quiz_id = (int) $bothArr[0];
    $user_id = (int) $bothArr[1];

    $sql = "SELECT * FROM quizes WHERE `id` = '$quiz_id';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $course_id = $row['course_id'];

    // get course name and short name
    $sql1 = "SELECT * FROM courses WHERE `id` = '$course_id';";
    $result1 = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_assoc($result1);
    $course_name = $row1['course_name'];
    $course_short_name = $row1['course_short_name'];

    // get start and finished date
    $sql2 = "SELECT * FROM attempted WHERE user_id = '$user_id' AND quiz_id = '$quiz_id';";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $score = $row2['score'];
    $percent = $row2['percentage'];
    $start = $row2['date_started'];
    $end = $row2['date_submited'];
    $get_start_date = getdate($start);
    $get_end_date = getdate($end);

    $start_date = $get_start_date['mday'] . " " . $get_start_date['weekday'] . " " . $get_start_date['month'] . " " . $get_start_date['year'];
    $end_date = $get_end_date['mday'] . " " . $get_end_date['weekday'] . " " . $get_end_date['month'] . " " . $get_end_date['year'];

    $diff = round(abs($end - $start) / 60, 2);

    // get questions
    $sql3 = "SELECT * FROM questions WHERE quiz_id = '$quiz_id';";
    $result3 = mysqli_query($conn, $sql3);
    $total_question = mysqli_num_rows($result3);

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
      <link rel="shortcut icon" href="<?php echo logoSrc() ?>" type="image/x-icon">
      <link rel="stylesheet" href="../public/style.css">
      <title>Result - Quiz App</title>
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
            <h4><?php echo $course_short_name; ?> - <?php echo $course_name; ?></h4>
          </div>
        </div>
        <div class="quiz-result d-flex align-items-center justify-content-center">
          <div class="quiz-result-head">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>
                    <strong>Started On:</strong>
                  </td>
                  <td>
                    <?php echo $start_date; ?>
                  </td>
                </tr>
                <tr>
                  <td>
                    <strong>State:</strong>
                  </td>
                  <td>
                    Finished
                  </td>
                </tr>
                <tr>
                  <td>
                    <strong>Completed On:</strong>
                  </td>
                  <td>
                    <?php echo $end_date; ?>
                  </td>
                </tr>
                <tr>
                  <td>
                    <strong>Marks:</strong>
                  </td>
                  <td>
                    <?php echo number_format($score, 2); ?>/<?php echo number_format($total_question, 2) ?>
                  </td>
                </tr>
                <tr>
                  <td>
                    <strong>Grade:</strong>
                  </td>
                  <td>
                    <?php echo number_format($percent, 2); ?> out of 100.00
                  </td>
                </tr>
                <tr>
                  <td>
                    <strong>Time Taken:</strong>
                  </td>
                  <td>
                    <?php echo $diff . " minutes"; ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="quiz-result-body">
          <?php
          $x = 0;
          while ($row3 = mysqli_fetch_assoc($result3)) {
            $x++;
            $question = $row3['question'];
            $question_id = $row3['id'];
            $question_image = $row3['image'];
            $image = "";
            // get question image
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
              $image = '<img src="' . $src . '" id="question-img"/>';
            }
            // get user answers
            $sql4 = "SELECT * FROM attempts WHERE user_id = '$user_id' AND quiz_id = '$quiz_id' AND question_id = '$x';";
            $result4 = mysqli_query($conn, $sql4);
            $row4 = mysqli_fetch_assoc($result4);
            $answer = $row4['answer'];
            // get options
            $sql5 = "SELECT * FROM options WHERE question_id = '$question_id';";
            $result5 = mysqli_query($conn, $sql5);
            echo '<div class="quiz">
              <div class="quiz-body">
                  <div class="quiz-body-head">
                    <div class="question"><b>Question ' . $x . '</b></div>
                  </div>
              <div class="quiz-body-body">
                  <div class="question"><h5>' . $question . '</h5>
                  ' . $image . '
                  </div>
                  <div class="options">';
            $y = 0;
            $alpha = array("", "A", "B", "C", "D", "E", "F", "G", "H");
            $sql6 = "SELECT * FROM options WHERE question_id = '$question_id' AND answer = 1;";
            $result6 = mysqli_query($conn, $sql6);
            $row6 = mysqli_fetch_assoc($result6);
            $correct = $row6['id'];
            $correct_answer = '';
            while ($row5 = mysqli_fetch_assoc($result5)) {
              $y++;
              $option = $row5['option'];
              $option_id = $row5['id'];
              if ($option_id == $answer) {
                echo '<div class="option">
                  <span>' . $alpha[$y] . '.</span>
                  <input type="checkbox" name="option" id="option' . $y . '" disabled checked>
                  <label for="option' . $y . '">' . $option . '</label>
                  </div>';
              } else {
                echo '<div class="option">
                  <span>' . $alpha[$y] . '.</span>
                  <input type="checkbox" name="option" id="option1" disabled>
                  <label for="option1">' . $option . '</label>
                  </div>';
              }
              if ($option_id == $correct) {
                $correct_answer = $option;
              }
            }
            echo '<div class="alert alert-warning">
              <strong> The correct answer is:</strong>
                  ' . $correct_answer . '
            </div> </div>
            </div>
            </div>
          </div>';
          }
          ?>
        </div>
      </main>
      </div>
      <?php
      require("./footer.php");
      ?>
      <script src="../public/app.js"></script>
      <script src="../public/loader.js"></script>
    </body>

    </html>
<?php
  } else {
    header("Location: ./quizes.php");
    exit();
  }
} else {
  header("Location: ./login.php");
}
?>
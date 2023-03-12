<?php
require "../includes/db.inc.php";
if (isset($_GET['quiz']) && $_GET['q']) {
  $quiz_id = $_GET['quiz'];
  $question_num = (int) $_GET['q'];
  $user_id = $_GET['user'];
  $date = $_GET['date'];

  // get quiz duration
  $sql6 = "SELECT * FROM quizes WHERE id = $quiz_id;";
  $result6 = mysqli_query($conn, $sql6);
  $row6 = mysqli_fetch_assoc($result6);
  $duration = $row6['duration'];
  // get timer
  $stamp = $duration * 60;
  $actualDate = $date + $stamp;
  $actualDateString = date("Y-m-d H:i:s", $actualDate);
  // get course id
  $sql = "SELECT * FROM quizes WHERE id = '$quiz_id';";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $course_id = $row['course_id'];

  // get course name and short name
  $sql1 = "SELECT * FROM courses WHERE `id` = '$course_id';";
  $result1 = mysqli_query($conn, $sql1);
  $row1 = mysqli_fetch_assoc($result1);
  $course_name = $row1['course_name'];
  $short_name = $row1['course_short_name'];

  // get attempts
  $sql2 = "SELECT * FROM attempts WHERE user_id='$user_id' AND quiz_id='$quiz_id';";
  $result2 = mysqli_query($conn, $sql2);

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
    <title>End - Quiz App</title>
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
      </div>
      <div class="overview">
        <div class="overview-head">
          <h3>Summary Of attempt</h3>
        </div>
        <div class="overview-body">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>Question</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($row2 = mysqli_fetch_assoc($result2)) {
                $question_id = $row2['question_id'];
                $answer = $row2['answer'];
                if ($answer == 0) {
                  echo '<tr>
                            <td>' . $question_id . '</td>
                            <td>Not Yet Attempted</td>
                            </tr>';
                } else {
                  echo '<tr>
                            <td>' . $question_id . '</td>
                            <td>Attempted</td>
                            </tr>';
                }
              }
              ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="2">
                  <form action="../includes/quiz-on.inc.php" method="post">
                    <!-- hidden -->
                    <input type="hidden" name="q" value="<?php echo $question_num; ?>">
                    <input type="hidden" name="quiz" value="<?php echo $quiz_id; ?>">
                    <button class="btn btn-info" type="submit" name="return">Return</button>
                    <button class="btn btn-warning" type="submit" name="submit" id="submit">Submit</button>
                  </form>
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </main>
    </div>
    <?php
    require "../admin/footer.php";
    ?>
    <script src="../public/app.js"></script>
    <script src="../public/loader.js"></script>
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
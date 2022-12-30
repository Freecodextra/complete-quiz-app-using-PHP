<?php
require "../includes/db.inc.php";
if (isset($_GET['quiz'])) {
  $quiz_id = $_GET['quiz'];
  $sql = "SELECT * FROM quizes WHERE `id` = '$quiz_id';";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $course_id = $row['course_id'];
  $topic_id = $row['topic_id'];
  $start_date = $row['start_date'];
  $end_date = $row['end_date'];
  $duration = $row['duration'];
  $date = getdate()[0];
  // get course name and short name
  $sql1 = "SELECT * FROM courses WHERE `id` = '$course_id';";
  $result1 = mysqli_query($conn, $sql1);
  $row1 = mysqli_fetch_assoc($result1);
  $course_name = $row1['course_name'];
  $course_short_name = $row1['course_short_name'];
  // get topic name
  $sql2 = "SELECT * FROM topics WHERE `id` = '$topic_id';";
  $result2 = mysqli_query($conn, $sql2);
  $row2 = mysqli_fetch_assoc($result2);
  $topic_name = $row2['topic_name'];
  // get questions number
  $sql3 = "SELECT * FROM questions WHERE quiz_id = '$quiz_id';";
  $result3 = mysqli_query($conn, $sql3);
  $question_num = mysqli_num_rows($result3);
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
  <!-- ===================== TOASTIFY LIBRARY ==================== -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <link rel="stylesheet" href="../public/style.css">
  <link rel="shortcut icon" href="<?php echo logoSrc() ?>" type="image/x-icon">
  <title>Start Quiz - Quiz App</title>
</head>
<body>
<?php
    require("./header.php");
    require("./navbar.php");
    ?>
    <!-- ======================== MAIN CONTENT ===================== -->
    <main>
        <div class="course-head">
            <div class="course">
                  <div class="image">
                    <img src="../images/course.png" alt="Course">
                  </div>
                  <div class="text">
                    <h2><?php echo $course_short_name; ?></h2>
                    <p><?php echo $course_name; ?></p>
                  </div>
              </div>
        </div>
        <div class="start">
        <div class="body">
            <div class="text">
                <h4>Test Your knowledge on "<?php echo $topic_name; ?>".</h4>
                <p>This is a multichoice quiz to best your <?php echo $course_short_name; ?> Knowledge.</p>
            </div>
            <div class="info">
                <p><b>Number of questions:</b> <?php echo $question_num; ?></p>
                <p><b>Type:</b> Multiple Choice</p>
                <p><b>Estimated Time:</b> <?php echo $duration; ?> Minutes</p>
            </div>
            <div class="button">
                <a href="../includes/start-quiz.inc.php?quiz=<?php echo $quiz_id; ?>" class="btn">Start Quiz</a>
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
    <script><?php if (isset($_GET['error'])) {
      if ($_GET['error'] == "enroll") {
        echo 'toast("You\'re not enroll for this course");';
      }
      elseif ($_GET['error'] == "quiz") {
        echo 'toast("No quiz id");';
      }
      elseif ($_GET['error'] == "attempt") {
        echo 'toast("You can no longer attempt this quiz");';
      }
      elseif ($_GET['error'] == "start") {
        echo 'toast("This quiz has not yet started");';
      }
      elseif ($_GET['error'] == "end") {
        echo 'toast("This quiz has ended");';
      }
      elseif ($_GET['error'] == "token") {
        echo 'toast("This quiz has already been submitted");';
      }
  } ?>
  
      // ===================== TOASTIFY =========================
      function toast(x) {
      Toastify({
        text: x,
        duration: 2000,
        close: true,
        style: {
          background: "linear-gradient(to right, #4649ff, #1d1ce5)",
        }
      }).showToast()
    }
  </script>
</body>
</html>
<?php

} else {
  header("Location: ./index.php");
}
?>
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
    <title>Course - Quiz App</title>
  </head>

  <body>
    <?php
    require("./header.php");
    require("./navbar.php");
  
// if (isset($_GET['course'])) {
  require "../includes/db.inc.php";
  $course_id = $_GET['course'];
  $sql = "SELECT * FROM courses WHERE `id` = '$course_id';";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $course_name = $row['course_name'];
  $course_short_name = $row['course_short_name'];
  
  function logoSrc()
  {
    $file = "../images/logo*";
    $fileSearch = glob($file);
    return $fileSearch[0];
  }
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
      <div class="topics">
        <?php
        // fetch topics and exercises
        $sql1 = "SELECT * FROM topics WHERE course_id = $course_id;";
        $x = 0;
        $result1 = mysqli_query($conn, $sql1);
        if (mysqli_num_rows($result1) > 0) {
          while ($row1 = mysqli_fetch_assoc($result1)) {
            ++$x;
            $topic_id = $row1['id'];
            $topic_name = $row1['topic_name'];
            $sql2 = "SELECT * FROM quizes WHERE topic_id = $topic_id;";
            $result2 = mysqli_query($conn, $sql2);
            echo '<div class="topic">
            <div class="topic-image">
              <img src="../images/topic.png" alt="Topic">
            </div>
            <div class="topic-name">
              <h5>TOPIC '.$x.': '.$topic_name.'</h5>
            </div>
          </div>';
            if (mysqli_num_rows($result2) > 0) {
              while ($row2 = mysqli_fetch_assoc($result2)) {
                $quiz_name = $row2['quiz_name'];
                $quiz_id = $row2['id'];
                echo '<div class="exercises">
                <div class="exercise-image">
                  <img src="../images/exercise.png" alt="Exercise">
                </div>
                <div class="exercise-name">
                  <a href="./start.php?quiz='.$quiz_id.'&user='.$user_id.'">
                    <p>'.$quiz_name.'</p>
                  </a>
                </div>
              </div>';
              }
            }
          }
        }
        ?>
      </div>
    </main>
    </div>
    <?php
    require "../admin/footer.php";
    ?>
    <script src="../public/app.js"></script>
    <script src="../public/loader.js"></script>
  </body>

  </html>

<?php
// } else {
//   header("Location: ./index.php");
// }
?>
<?php
session_start();
require "../includes/db.inc.php";
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
  <title>Courses - Quiz App</title>
</head>
<body>
<?php
  require("./header.php");
  require("./navbar.php");
  ?>
    <!-- ======================== MAIN CONTENT ===================== -->
    <main>
        <div class="head">
          <h2>Available Courses</h2>
          <?php
            $sql = "SELECT * FROM classes;";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                $class_id = $row['id'];
                $class_name = $row['class_name'];
                echo '<div class="courses">
                <div class="level">
                  <h4>'.$class_name.' COURSES</h4>
                </div>
                <div class="row">';
                $sql1 = "SELECT * FROM courses WHERE `level` = '$class_id';";
                $result1 = mysqli_query($conn, $sql1);
                if (mysqli_num_rows($result1) > 0) {
                  while ($row1 = mysqli_fetch_assoc($result1)) {
                    $course_id = $row1['id'];
                    $course_short_name = $row1['course_short_name'];
                    // topics
                    $sql2 = "SELECT * FROM topics WHERE course_id = '$course_id';";
                    $result2 = mysqli_query($conn, $sql2);
                    $topics = mysqli_num_rows($result2);
                    echo '<div class="col-md-3">
                      <a href="./course.php?course='.$course_id.'&user='.$user_id.'">
                      <div class="course">
                        <div class="main">
                          <div class="image">
                            <img src="../images/course.png" alt="Course">
                          </div>
                          <div class="text">
                            <h5>'.$course_short_name.'</h5>
                            <p>'.$topics.' Topics</p>
                          </div>
                        </div>
                        <div class="icon">
                          <i class="bi bi-caret-right-fill"></i>
                        </div>
                      </div>
                    </a>
                    </div>';
                  }
                }
                echo '</div>
              </div>';
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
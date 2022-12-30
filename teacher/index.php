<?php
session_start();
require "../includes/db.inc.php";
function logoSrc()
{
  $file = "../images/logo*";
  $fileSearch = glob($file);
  return $fileSearch[0];
}
// fetch my courses
$myCourses = array();
if (isset($_SESSION['teacher'])) {
  $id = $_SESSION['teacher'];
  $sql = "SELECT * FROM teachers_enrollment WHERE teacher_id = '$id';";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $course_id = $row['course_id'];
      $sql1 = "SELECT * FROM courses WHERE id = '$course_id';";
      $result1 = mysqli_query($conn, $sql1);
      while ($row1 = mysqli_fetch_assoc($result1)) {
        $course_cat = $row1['course_category_id'];
        $cat = "SELECT * FROM course_category WHERE id = '$course_cat';";
        $cat_result = mysqli_query($conn, $cat);
        $cat_row = mysqli_fetch_assoc($cat_result);
        $data = array();
        $data[] = $row1['id'];
        $data[] = $row1['course_name'];
        $data[] = $row1['course_short_name'];
        $data[] = strtolower($cat_row['cat_name']);
        $myCourses[] = $data;
      }
    }
  }
}
//  number of courses
if (isset($_SESSION['teacher'])) {
  $id1 = $_SESSION['teacher'];
  $sql3 = "SELECT * FROM teachers_enrollment WHERE teacher_id = '$id1';";
  $result3 = mysqli_query($conn, $sql3);
  $course_num = mysqli_num_rows($result3);
}
// no of students
if (isset($_SESSION['teacher'])) {
  $id2 = $_SESSION['teacher'];
  $sql4 = "SELECT * FROM classes WHERE teacher = '$id2';";
  $result4 = mysqli_query($conn, $sql4);
  if (mysqli_num_rows($result4) > 0) {
    $row4 = mysqli_fetch_assoc($result4);
    $class_id = $row4['id'];
    $sql5 = "SELECT * FROM users WHERE `level` = '$class_id';";
    $result5 = mysqli_query($conn, $sql5);
    $student_no = mysqli_num_rows($result5);
  }
}
// no of quizes
if (isset($_SESSION['teacher'])) {
  $id3 = $_SESSION['teacher'];
  $sql6 = "SELECT * FROM teachers_enrollment WHERE teacher_id = '$id3';";
  $result6 = mysqli_query($conn, $sql6);
  $quiz_num = 0;
  if (mysqli_num_rows($result6) > 0) {
    while($row6 = mysqli_fetch_assoc($result6)) {
      $course_id = $row6['course_id'];
      $sql7 = "SELECT * FROM quizes WHERE id = '$course_id';";
      $result7 = mysqli_query($conn, $sql7);
      if(mysqli_num_rows($result7) > 0) {
        while($row7 = mysqli_fetch_assoc($result7)) {
          $quiz_num++;
        }
      }
    }
  }
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
  <title>Home - Quiz App</title>
</head>

<body>
  <?php
  require("./header.php");
  require("./navbar.php");
  ?>
  <!-- ======================== MAIN CONTENT ===================== -->
  <main>
    <div class="row">
      <div class="col-md-4">
        <div class="user-profile d-flex align-items-center justify-content-center">
          <div class="profile-img">
            <img src="../images/avatar.png" alt="Avatar">
          </div>
          <h2>Hi <?php if (isset($_SESSION['teacher'])) {
                    echo $_SESSION['uid'] . "!";
                  } else {
                    echo "Anonymous";
                  } ?></h2>
          <div class="profile-body">
            <div class="stats row d-flex align-items-center justify-content-center">
              <div class="stat col-sm-4">
                <div class="sec">
                  <div class="icon"><i class="bi bi-mortarboard"></i></div>
                  <div class="text">
                    <p>Number Of Courses</p>
                  </div>
                  <div class="number"><?php if (isset($_SESSION['teacher'])) {
                    echo $course_num;
                  } ?></div>
                </div>
              </div>
              <div class="stat col-sm-4">
                <div class="sec">
                  <div class="icon"><i class="bi bi-puzzle"></i></div>
                  <div class="text">
                    <p>Numer Of Students</p>
                  </div>
                  <div class="number"><?php if (isset($_SESSION['teacher'])) {
                    echo $student_no;
                  } ?></div>
                </div>
              </div>
              <div class="stat col-sm-4">
                <div class="sec">
                  <div class="icon"><i class="bi bi-trophy"></i></div>
                  <div class="text">
                    <p>Number of Quizes</p>
                  </div>
                  <div class="number"><?php if (isset($_SESSION['teacher'])) {
                    echo $quiz_num;
                  } ?></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <?php
        if (isset($_SESSION['teacher'])) {
        ?>
          <div class="mine content">
            <div class="heading">
              <h2>My Courses</h2>
            </div>
            <div class="courses">
              <div class="row d-flex align-items-start justify-content-center">
                <?php
                foreach ($myCourses as $myCourse) {
                  $src = "../images/" . $myCourse[3] . rand(1, 2) . ".png";
                  if(!file_exists($src)) {
                    $src = "../images/dafault.png";
                  }
                  echo '
                      <div class="col-md-4">
                      <a href="./course.php?course=' . $myCourse[0] . '&teacher='.$id.'">
                      <div class="image">
                        <img src="'.$src.'" alt="' . $myCourse[3] . '">
                      </div>
                      <div class="head">' . $myCourse[2] . '</div>
                      <div class="text">' . $myCourse[1] . '</div>
                      </a>
                      </div>
                      ';
                }
                ?>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
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
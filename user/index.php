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
if (isset($_SESSION['id'])) {
  $id = $_SESSION['id'];
  $sql = "SELECT * FROM users_enrollment WHERE student_id = '$id';";
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
// fetch Popular course
$sql2 = "SELECT * FROM courses LIMIT 3;";
$result2 = mysqli_query($conn, $sql2);
$popularCourses = array();
if (mysqli_num_rows($result2) > 0) {
  while ($row2 = mysqli_fetch_assoc($result2)) {
    $course_cat = $row2['course_category_id'];
    $cat = "SELECT * FROM course_category WHERE id = '$course_cat';";
    $cat_result = mysqli_query($conn, $cat);
    $cat_row = mysqli_fetch_assoc($cat_result);
    $array = array();
    $array[] = $row2['id'];
    $array[] = $row2['course_name'];
    $array[] = $row2['course_short_name'];
    $array[] = strtolower($cat_row['cat_name']);
    $popularCourses[] = $array;
  }
}
//  number of courses
if (isset($_SESSION['id'])) {
  $id1 = $_SESSION['id'];
  $sql3 = "SELECT * FROM users_enrollment WHERE student_id = '$id1';";
  $result3 = mysqli_query($conn, $sql3);
  $course_num = mysqli_num_rows($result3);
}
// quiz attempted
if (isset($_SESSION['id'])) {
  $id2 = $_SESSION['id'];
  $sql4 = "SELECT * FROM attempted WHERE user_id = '$id2';";
  $result4 = mysqli_query($conn, $sql4);
  $quiz_attempted = mysqli_num_rows($result4);
}
// quiz attempted
if (isset($_SESSION['id'])) {
  $id3 = $_SESSION['id'];
  $x = 0;
  $leaderboard = 0;
  $sql5 = "SELECT * FROM leaderboard ORDER BY `percentage` DESC;";
  $result5 = mysqli_query($conn, $sql5);
  if(mysqli_num_rows($result5)) {
    while($row5 = mysqli_fetch_assoc($result5)) {
      $x++;
      $f_id = $row5['user_id'];
      if($id3 == $f_id) {
        $leaderboard = $x;
      }
    }
  }
}
    // get image
    $src;
    if(isset($_SESSION['id'])) {   
      $id = $_SESSION['id'];
    $file = "../img-uploads/student". $id . "*";
    $fileSearch = glob($file);
    if (count($fileSearch) > 0) {      
      $fileExt = explode(".", $fileSearch[0]);
      $fileActExt = end($fileExt);
      $file_path = "../img-uploads/student" . $id .".". $fileActExt;
      if(file_exists($file_path)) {
        $src = $file_path;
      }
      else {
        $src = "../images/avatar.png";
      }
    } else {
      $src = "../images/avatar.png";
    }
  } else {
    $src = "../images/avatar.png";
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
            <img src="<?php echo $src; ?>" alt="Avatar">
          </div>
          <h2>Hi <?php if (isset($_SESSION['uid'])) {
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
                  <div class="number"><?php if (isset($_SESSION['id'])) {
                    echo $course_num;
                  } ?></div>
                </div>
              </div>
              <div class="stat col-sm-4">
                <div class="sec">
                  <div class="icon"><i class="bi bi-puzzle"></i></div>
                  <div class="text">
                    <p>Quiz Attempted</p>
                  </div>
                  <div class="number"><?php if (isset($_SESSION['id'])) {
                    echo $quiz_attempted;
                  } ?></div>
                </div>
              </div>
              <div class="stat col-sm-4">
                <div class="sec">
                  <div class="icon"><i class="bi bi-trophy"></i></div>
                  <div class="text">
                    <p>Leaderboard Ranking</p>
                  </div>
                  <div class="number"><?php if (isset($_SESSION['id'])) {
                    echo $leaderboard;
                  } ?></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="popular content">
          <div class="heading">
            <h2>Popular Courses</h2>
          </div>
          <div class="courses">
            <a href="./courses.php?user=<?php if(isset($_GET['user'])) {echo $user_id;} ?>" class="all-course">All Courses</a>
            <div class="row d-flex align-items-start justify-content-center">
              <?php
              foreach ($popularCourses as $popularCourse) {
                $id;
                if (isset($_SESSION['id'])) {
                  $id = $_SESSION['id'];
                } else {
                  $id = "";
                }
                echo '
                    <div class="col-md-4">
                    <a href="./course.php?course=' . $popularCourse[0] . '&user='.$id.'">
                    <div class="image">
                      <img src="../images/' . $popularCourse[3] . rand(1, 2) . '.png" alt="' . $popularCourse[3] . '">
                    </div>
                    <div class="head">' . $popularCourse[2] . '</div>
                    <div class="text">' . $popularCourse[1] . '</div>
                    </a>
                    </div>
                    ';
              }
              ?>
            </div>
          </div>
        </div>
        <?php
        if (isset($_SESSION['id'])) {
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
                      <a href="./course.php?course=' . $myCourse[0] . '&user='.$id.'">
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
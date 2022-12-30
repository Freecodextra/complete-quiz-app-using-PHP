<?php
session_start();
if (isset($_SESSION['admin'])) {
if (isset($_POST['id'])) {
  require "../includes/db.inc.php";
  $id = $_POST['id'];
  $sql = "SELECT * FROM teachers WHERE id = '$id'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  // get level
  $fName = $row['fName'];
  $lName = $row['lName'];
  $teacherID = $row['teacherID'];
  $city = $row['city'];
  $sex = $row['sex'];
  $phone = $row['phone'];
  $class_name;
  $l_sql = "SELECT * FROM classes WHERE teacher = $id;";
  $l_result = mysqli_query($conn, $l_sql);
  if (mysqli_num_rows($l_result) > 0) {
    $l_row = mysqli_fetch_assoc($l_result);
    $class_name = $l_row['class_name'];
  } else {
    $class_name = "null";
  }
  // get image
  $file = "../img-uploads/teacher" . $id . "*";
  $fileSearch = glob($file);
  $fileExt = explode(".", $fileSearch[0]);
  $fileActExt = end($fileExt);
  $file_path = "../img-uploads/teacher" . $id . "." . $fileActExt;
  $src;
  if (file_exists($file_path)) {
    $src = $file_path;
  } else {
    $src = "../images/avatar.png";
  }
      // Settings
      $sql1 = "SELECT * FROM settings;";
      $result1 = mysqli_query($conn,$sql1);
      $row1 = mysqli_fetch_assoc($result1);
      $school_name = $row1['school_name'];
      $school_short_name = $row1['school_short_name'];
      $school_motto = $row1['school_motto'];
  // logo
      function logoSrc() {
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
    <title>Admin - Quiz App</title>
  </head>

  <body>
  <?php 
    require("./header.php"); 
    require("./navbar.php");
    ?>
    <!-- MAIN CONTENT -->
    <main class="center">
      <div class="photo-card shadow d-flex align-items-center justify-content-center m-3">
        <div class="card-content">
          <div class="photo-card-head text-center mt-3">
            <h4>Teacher's Photo Card</h4>
          </div>
          <div class="card-logo center">
            <div class="img center">
              <img src="<?php echo logoSrc(); ?>" alt="">
            </div>
          </div>
          <div class="heading text-center">
            <h3><?php echo $school_name; ?></h3>
          </div>
          <div class="card-body d-flex">
            <div class="user-image">
              <img src="<?php echo $src; ?>" alt="Avatar">
            </div>
            <div class="text">
              <div class="line d-flex">
                <div class="line-text">
                  <p><?php echo $fName; ?></p>
                  <span>First Name</span>
                </div>
                <div class="line-text">
                  <p><?php echo $lName; ?></p>
                  <span>Last Name</span>
                </div>
                <div class="line-text">
                  <p><?php echo $class_name; ?></p>
                  <span>Level</span>
                </div>
              </div>
              <div class="line d-flex">
                <div class="line-text">
                  <p><?php echo $school_short_name. "/". $teacherID; ?></p>
                  <span>Reg Number</span>
                </div>
                <div class="line-text">
                  <p><?php echo $city; ?></p>
                  <span>City</span>
                </div>
                <div class="line-text">
                  <p><?php echo $sex; ?></p>
                  <span>Sex</span>
                </div>
              </div>
              <div class="line d-flex">
                <div class="line-text">
                  <p><?php echo $id; ?></p>
                  <span>Serial Number</span>
                </div>
                <div class="line-text">
                  <p><?php echo date("Y"); ?></p>
                  <span>Year</span>
                </div>
                <div class="line-text">
                  <p><?php echo $phone; ?></p>
                  <span>Phone</span>
                </div>
              </div>
            </div>
          </div>
          <div class="user-courses">
            <h4>Assigned Courses</h4>
          </div>
          <div class="courses-list">
            <ul>
              <?php
              $e_sql = "SELECT * FROM teachers_enrollment WHERE teacher_id = $id;";
              $e_result = mysqli_query($conn, $e_sql);
              $e_result_checker = mysqli_num_rows($e_result);
              if ($e_result_checker > 0) {
                while ($e_row = mysqli_fetch_assoc($e_result)) :
                  $course_id = $e_row['course_id'];
                  $c_sql = "SELECT * FROM courses WHERE id = $course_id;";
                  $c_result = mysqli_query($conn, $c_sql);
                  $c_row = mysqli_fetch_assoc($c_result);
              ?>
                  <li><?php echo $c_row['course_short_name'] ?></li>
              <?php endwhile;
              }
              ?>
            </ul>
          </div>
          <div class="info-note">
            <div class="note-name">
              <h6>Note*</h6>
            </div>
            <div class="note-list">
              <ul>
                <li>This photocard shouldn't be duplicated. Any one who misplaced his/her own should contact the administrator.</li>
                <li>This photocard is not transferrable. The Council reserves the right to withdraw it if further screening reveals that it was obtained through malpractice or any form of irregularity.
                </li>
              </ul>
            </div>
          </div>
          <div class="card-footer text-center">
            <h6>Ⓒ 2022 <?php echo $school_name; ?></h6>
          </div>
        </div>
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
  header("Location: ./students.php");
}
} else {
  header("Location: ./login.php");
 }
?>
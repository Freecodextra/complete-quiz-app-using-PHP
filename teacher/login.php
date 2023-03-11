<?php 
  function logoSrc() {
    $file = "../images/logo*";
    $fileSearch = glob($file);
    return $fileSearch[0];
    }
    ?>
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
  <title>Login - Quiz App</title>
</head>
<body>
<div class="loading">
<div class="loading-cover"></div>
    <h1><i class="bi bi-arrow-clockwise"></i></h1>
    Loading...</div>
  <?php 
    if (isset($_GET['error'])) {
      if ($_GET['error'] == "empty") {
        echo '<div id="snackbar">Empty Field(s)!</div>';
      }
      elseif ($_GET['error'] == "sql") {
        echo '<div id="snackbar">Database Error! Try Again</div>';
      }
      elseif ($_GET['error'] == "usernotfound") {
        echo '<div id="snackbar">User Not Found!</div>';
      }
      elseif ($_GET['error'] == "wrongpwd") {
        echo '<div id="snackbar">Incorrect Password!</div>';
      }
    //  elseif ($_GET['error'] == "success") {
    //   $teacher_id = $_GET['teacher'];
    //   echo '<div id="snackbar">Login Success!</div>';
    //   header("refresh:2;url=./index.php?teacher=$teacher_id");
    //  }
    }  
  ?>
  <div class="wrapper container-fluid">
    <div class="container">
      <div class="row login shadow-sm">
        <div class="col-md-6">
          <img src="../images/login.png" alt="Login">
        </div>
        <div class="col-md-6">
          <form action="../includes/teacher-login.inc.php" method="POST">
            <div class="mb-3 shadow-sm">
              <div class="icon"><i class="bi bi-person-fill"></i></div>
              <input type="text" class="form-control" id="username" name="uid" placeholder="Username/Email/TeacherID">
            </div>
            <div class="mb-3 shadow-sm">
              <div class="icon"><i class="bi bi-lock-fill"></i></div>
              <input type="password" class="form-control" id="password" name="pwd" placeholder="Password">
            </div>
            <div class="d-grid shadow-sm">
              <button type="submit" name="submit" class="btn">Login</button>
            </div>
          </form>
        </div>
      </div>
  </div>
  </div>
<?php
    require "../admin/footer.php";
?>
  <script src="../public/loading.js"></script>
  <script src="../public/toast.js"></script>
  <script src="../public//loader.js"></script>
  <script><?php if (isset($_GET['error'])) {
   echo "snackBar();";
  } ?></script>
</body>
</html>
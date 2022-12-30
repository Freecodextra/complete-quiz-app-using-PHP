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
  <title>Signup - Quiz App</title>
</head>
<body>
<div class="loading">
    <h1><i class="bi bi-arrow-clockwise"></i></h1>
    Loading...</div>
<?php 
    if (isset($_GET['error'])) {
      if ($_GET['error'] == "empty") {
        echo '<div id="snackbar">Empty Fields!</div>';
      }
      elseif ($_GET['error'] == "uid/email") {
        echo '<div id="snackbar">Invalid Username/Email!</div>';
       }
       elseif ($_GET['error'] == "email") {
        echo '<div id="snackbar">SInvalid Email!</div>';
       }
       elseif ($_GET['error'] == "uid") {
        echo '<div id="snackbar">Invalid Username!</div>';
       }
       elseif ($_GET['error'] == "strong") {
        echo '<div id="snackbar">Use Strong Password!</div>';
       }
       elseif ($_GET['error'] == "username") {
        echo '<div id="snackbar">Use Valid USername!</div>';
       }
       elseif ($_GET['error'] == "password") {
        echo '<div id="snackbar">Password not the same!</div>';
       }
       elseif ($_GET['error'] == "sql") {
        echo '<div id="snackbar">Database Error! Try Again</div>';
       }
       elseif ($_GET['error'] == "userexist") {
        echo '<div id="snackbar">User Exist! Change Username/Email</div>';
       }
     elseif ($_GET['error'] == "success") {
      echo '<div id="snackbar">Signup Success!</div>';
      header("refresh:2;url=./login.php");
     }
    }  
  ?>
  <div id="snackbar">Some Text Here</div>
  <div class="wrapper container-fluid">
    <div class="container">
      <div class="row login shadow-sm">
        <div class="col-md-6">
          <img src="../images/signup.png" alt="Signup">
        </div>
        <div class="col-md-6">
            <form action="../includes/signup.inc.php" method="post">
            <div class="mb-3 shadow-sm">
                <div class="icon"><i class="bi bi-file-person-fill"></i></div>
                <input type="text" class="form-control" id="firstname" name="fName" placeholder="Firstname" value="<?php if (isset($_GET['fName'])) {echo $_GET['fName'];}?>">
              </div>
              <div class="mb-3 shadow-sm">
                <div class="icon"><i class="bi bi-file-person-fill"></i></div>
                <input type="text" class="form-control" id="lastname" name="lName" placeholder="Lastname" value="<?php if (isset($_GET['lName'])) {echo $_GET['lName'];}?>">
              </div>
            <div class="mb-3 shadow-sm">
              <div class="icon"><i class="bi bi-person-fill"></i></div>
              <input type="text" class="form-control" id="username" name="uid" placeholder="Username" value="<?php if (isset($_GET['uid'])) {echo $_GET['uid'];}?>">
            </div>
            <div class="mb-3 shadow-sm">
                <div class="icon"><i class="bi bi-envelope-fill"></i></div>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email"value="<?php if (isset($_GET['email'])) {echo $_GET['email'];}?>">
              </div>
            <div class="mb-3 shadow-sm">
              <div class="icon"><i class="bi bi-lock-fill"></i></div>
              <input type="password" class="form-control" id="password" name="pwd" placeholder="Password">
            </div>
            <div class="mb-3 shadow-sm">
                <div class="icon"><i class="bi bi-lock-fill"></i></div>
                <input type="password" class="form-control" id="password" name="rpwd" placeholder="Repeat Password">
              </div>
            <div class="d-grid shadow-sm">
              <button type="submit" name="submit" class="btn">Sign-Up</button>
            </div>
          </form>
          <div class="text mt-3">
            <p class="text-center">Alrady have an account? <a href="./login.php">Login</a></p>
          </div>
        </div>
      </div>
  </div>
  </div>
  <footer>
    <div class="footer-text">
      Copyrights Ⓒ 2022 All Rights reserved | Design By <a href="http://wa.me/2349016242310">CodeXtra</a>
      </div>
      <div class="footer-icons">
        <a href="http://facebook.com/insideabucampus">
          <i class="bi bi-facebook"></i>
        </a>
        <a href="http://twitter.com/insideabucampus">
          <i class="bi bi-twitter"></i>
        </a>
        <a href="http://instagram.com/insideabucampus">
          <i class="bi bi-instagram"></i>
        </a>
      </div>
  </footer>
  <script src="../public/app.js"></script>
  <script src="../public/toast.js"></script>
  <script src="../public/loader.js"></script>
  <script>
  <?php if (isset($_GET['error'])) {echo "snackBar();";}?>
  </script>
</body>
</html>
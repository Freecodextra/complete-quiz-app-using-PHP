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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../public/style.css">
  <link rel="shortcut icon" href="<?php echo logoSrc() ?>" type="image/x-icon">
  <title>Login - Quiz App</title>
</head>
<body>
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
     elseif ($_GET['error'] == "success") {
      echo '<div id="snackbar">Login Success!</div>';
      header("refresh:2;url=./index.php");
     }
    }  
  ?>
  <div class="wrapper container-fluid">
    <div class="container">
      <div class="row login shadow-sm">
        <div class="col-md-6">
          <img src="../images/login.png" alt="Login">
        </div>
        <div class="col-md-6">
          <form action="../includes/admin-login.inc.php" method="post">
            <div class="mb-3 shadow-sm">
              <div class="icon"><i class="bi bi-person-fill"></i></div>
              <input type="text" class="form-control" id="username" name="uid" placeholder="Username/Email">
            </div>
            <div class="mb-3 shadow-sm">
              <div class="icon"><i class="bi bi-lock-fill"></i></div>
              <input type="password" class="form-control" id="password" name="pwd" placeholder="Password">
            </div>
            <div class="d-grid shadow-sm">
              <button type="submit" name="admin" class="btn">Login</button>
            </div>
          </form>
        </div>
      </div>
  </div>
  </div>
  <?php 
    require("./footer.php");
    ?>
  <script src="../public/app.js"></script>
  <script src="../public/toast.js"></script>
  <script><?php if (isset($_GET['error'])) {
   echo "snackBar();";
  } ?></script>
</body>
</html>
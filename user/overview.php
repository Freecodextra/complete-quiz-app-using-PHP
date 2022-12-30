<?php
require "../includes/db.inc.php";
if (isset($_GET['quiz'])) {
  $quiz_id = $_GET['quiz'];
  $user_id = $_GET['user'];
  $score = $_GET['score'];
  $percent = $_GET['percent'];

  function logoSrc()
  {
    $file = "../images/logo*";
    $fileSearch = glob($file);
    return $fileSearch[0];
  }
  function emoji($percent)
  {
    if ($percent < 25) {
      return "&#128532;";
    } elseif ($percent >= 25 && $percent < 50) {
      return "&#128512;";
    } elseif ($percent >= 50 && $percent < 75) {
      return "&#x1F389;";
    } elseif ($percent >= 75) {
      return "&#127942;";
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
    <title>Overview - Quiz App</title>
    <style>
      main .overviews {
        background-image: url(../images/confetti.gif);
      }
    </style>
  </head>

  <body>
    <?php
    require("./header.php");
    require("./navbar.php");
    ?>
    <!-- ======================== MAIN CONTENT ===================== -->
    <main>
      <div class="overviews">
        <div class="overview">
          <div class="emoji">
            <p><?php echo emoji($percent); ?></p>
          </div>
          <div class="text">
            <p>Your Score is</p>
            <h1><?php echo $percent; ?>%</h1>
          </div>
          <form action="../includes/quiz-on.inc.php" method="post">
            <!-- hidden -->
            <input type="hidden" name="quiz" value="<?php echo $quiz_id; ?>">
            <div class="butttons">
              <button class="btn btn-primary" type="submit" name="restart">Retake Quiz</button>
              <button class="btn btn-success" type="submit" name="result">View result</button>
            </div>
          </form>
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
    </script>
  </body>

  </html>
<?php
} else {
  header("Location: ./index.php");
}
?>
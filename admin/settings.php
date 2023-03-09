<?php
session_start();
if (isset($_SESSION['admin'])) {
  require "../includes/db.inc.php";
  // settings
  $sql = "SELECT * FROM settings;";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $school_name = $row['school_name'];
  $school_short_name = $row['school_short_name'];
  $school_motto = $row['school_motto'];
  $facebook = $row['facebook'];
  $twitter = $row['twitter'];
  $instagram = $row['instagram'];
  $phone = $row['phone'];
  // admin
  $sql1 = "SELECT * FROM `admin`;";
  $result1 = mysqli_query($conn, $sql1);
  $row1 = mysqli_fetch_assoc($result1);
  $fName = $row1['fName'];
  $lName = $row1['lName'];
  $username = $row1['username'];
  $email = $row1['email'];
  // logo
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
    <!-- =================== DATA TABLE CDN ======================= -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/datatables.min.js"></script>
    <!-- ===================== TOASTIFY LIBRARY ==================== -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


    <link rel="stylesheet" href="../public/style.css">
    <link rel="shortcut icon" href="<?php echo logoSrc() ?>" type="image/x-icon">
    <title>Admin - Quiz App</title>
  </head>

  <body>
    <?php
    require("./header.php");
    require("./navbar.php");
    if (isset($_GET['error'])) {
      if ($_GET['error'] == "empty") {
        echo '<div id="snackbar">Empty Field!</div>';
      } elseif ($_GET['error'] == "sql") {
        echo '<div id="snackbar">Database Error! Try Again</div>';
      } elseif ($_GET['error'] == "success") {
        echo '<div id="snackbar">Signup Success!</div>';
      }
    }
    ?>
    <main>
      <div class="head m-3" id="settings">
        <h3>Website's Settings</h3>
        <p>Edit website's name, logo, links e.t.c here.</p>
        <div class="more-info mb-3">
          <div class="links">
            <a href="">General</a>
            <a href="" class="active">Personal</a>
            <a href="">Social</a>
            <a href="">Password</a>
          </div>
        </div>
        <div class="form main-details">
          <div class="row d-flex align-items-center justify-content-center one" id="general">
            <div class="shadow-sm each">
              <h4>General</h4>
              <hr>
              <form method="POST" action="../includes/settings.inc.php" id="generals">
                <div class="mb-3">
                  <label for="school-name" class="form-label">Name Of Institution</label>
                  <input type="text" class="form-control" id="school-name" placeholder="e.g Codextra International School" name="school-name" value="<?php echo $school_name; ?>">
                </div>
                <div class="mb-3">
                  <label for="short-name" class="form-label">Short Name</label>
                  <input type="text" class="form-control" placeholder="e.g CIS" id="short-name" name="short-name" value="<?php echo $school_short_name; ?>">
                </div>
                <div class="mb-3">
                  <label for="motto" class="form-label">Motto</label>
                  <input type="text" class="form-control" placeholder="e.g Excelence In Education" id="motto" name="school-motto" value="<?php echo $school_motto; ?>">
                </div>
                <div class="mb-3">
                  <label for="image" class="form-label">Logo</label>
                  <input type="file" class="form-control" id="image" name="image">
                </div>
                <button type="submit" class="btn" id="general-btn" name="general">Save Details</button>
              </form>
            </div>
          </div>
          <div class="row d-flex align-items-center justify-content-center one" id="personal">
            <div class="shadow-sm each">
              <h4>Personal</h4>
              <hr>
              <form method="POST" action="../includes/settings.inc.php" id="personals">
                <div class="mb-3">
                  <label for="fName" class="form-label">First Name</label>
                  <input type="text" class="form-control" id="fName" placeholder="e.g Quiz" value="<?php echo $fName; ?>">
                </div>
                <div class="mb-3">
                  <label for="lName" class="form-label">Last Name</label>
                  <input type="text" class="form-control" placeholder="e.g Admin" id="lName" value="<?php echo $lName; ?>">
                </div>
                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" placeholder="e.g admin_123" id="username" value="<?php echo $username; ?>">
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="text" class="form-control" placeholder="e.g admin@quizapp.com" id="email" value="<?php echo $email; ?>">
                </div>
                <button type="submit" class="btn" id="personal-btn">Save Details</button>
              </form>
            </div>
          </div>
          <div class="row d-flex align-items-center justify-content-center one" id="social">
            <div class="shadow-sm each">
              <h4>Social Links</h4>
              <hr>
              <form method="POST" action="../includes/settings.inc.php" id="socials">
                <div class="mb-3">
                  <label for="facebook" class="form-label">Facebook</label>
                  <input type="url" class="form-control" id="facebook" placeholder="https://www.facebook.com/codextra-school" value="<?php echo $facebook; ?>">
                </div>
                <div class="mb-3">
                  <label for="instagram" class="form-label">Instagram</label>
                  <input type="url" class="form-control" id="instagram" placeholder="https://www.instagram.com/codextra-school" value="<?php echo $instagram; ?>">
                </div>
                <div class="mb-3">
                  <label for="twitter" class="form-label">Twitter</label>
                  <input type="url" class="form-control" id="twitter" placeholder="https://www.twitter.com/codextra-school" value="<?php echo $twitter; ?>">
                </div>
                <div class="mb-3">
                  <label for="phone" class="form-label">Phone Number</label>
                  <input type="text" class="form-control" id="phone" placeholder="Phone Number" value="<?php echo $phone; ?>">
                </div>
                <button type="submit" id="social-btn" class="btn">Save Details</button>
              </form>
            </div>
          </div>
          <div class="row d-flex align-items-center justify-content-center one" id="password">
            <div class="shadow-sm each">
              <h4>Admin Password</h4>
              <p>Setup Password Here</p>
              <hr>
              <form method="POST" action="../includes/settings.inc.php" id="passwords">
                <div class="mb-3">
                  <label for="oldpwd" class="form-label">Current Password</label>
                  <input type="password" class="form-control" id="oldpwd" placeholder="Old Password" name="oldpwd">
                </div>
                <div class="mb-3">
                  <label for="newpwd" class="form-label">New Password</label>
                  <input type="password" class="form-control" id="newpwd" placeholder="New Password" name="newpwd">
                </div>
                <div class="mb-3">
                  <label for="rnewpwd" class="form-label">Confirm Password</label>
                  <input type="password" class="form-control" id="rnewpwd" placeholder="Confirm Password" name="rnewpwd">
                </div>
                <button type="submit" id="password-btn" class="btn">Save Details</button>
              </form>
            </div>
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
    <script src="../public/toast.js"></script>
    <script>
      const links = document.querySelectorAll(".more-info .links a");
      const contents = document.querySelectorAll(".main-details .one");

      function checkLinks(id) {
        links.forEach((link, index) => {
          if (id != index) {
            link.classList.remove("active");
          } else {
            link.classList.add("active");
          }
        })
      }

      function showContents(id) {
        contents.forEach((content, index) => {
          content.setAttribute("id", index);
          if (id != index) {
            content.style.left = "-120%";
            content.style.visibility = "hidden";
          } else {
            content.style.left = "0";
            content.style.visibility = "visible";
          }
        })
      }
      links.forEach((link, index) => {
        link.setAttribute("id", index);
        link.addEventListener("click", (e) => {
          e.preventDefault();
          checkLinks(link.id);
          showContents(link.id);
        })
      })
      // ====================== General ======================
      $("#generals").on("submit", function(e) {
        e.preventDefault();
        $("#general-btn").html("<span class='spinner-border'></span>");
        $("#general-btn").attr("disabled", true);
        $.ajax({
          url: "../includes/settings.inc.php",
          type: "POST",
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success: function(data, status) {
            toast(data);
            $("#general-btn").html("Save Details");
            $("#general-btn").attr("disabled", false);
          }
        });
      });
      // ====================== Personal ======================
      $("#personals").on("submit", function(e) {
        e.preventDefault();
        personal();
      })

      function personal() {
        $("#personal-btn").html("<span class='spinner-border'></span>");
        $("#personal-btn").attr("disabled", true);
        const fName = $("#fName").val();
        const lName = $("#lName").val();
        const username = $("#username").val();
        const email = $("#email").val();
        $.post("../includes/settings.inc.php", {
          fName,
          lName,
          username,
          email
        }, function(data) {
          toast(data);
          $("#personal-btn").html("Save Details");
          $("#personal-btn").attr("disabled", false);
        })
      }
      // ====================== Social ======================
      $("#socials").on("submit", function(e) {
        e.preventDefault();
        social();
      })

      function social() {
        $("#social-btn").html("<span class='spinner-border'></span>");
        $("#social-btn").attr("disabled", true);
        const facebook = $("#facebook").val();
        const twitter = $("#twitter").val();
        const instagram = $("#instagram").val();
        const phone = $("#phone").val();
        $.post("../includes/settings.inc.php", {
          facebook,
          twitter,
          instagram,
          phone
        }, function(data) {
          toast(data);
          $("#social-btn").html("Save Details");
          $("#social-btn").attr("disabled", false);
        })
      }
      // ====================== Passoword ======================
      $("#passwords").on("submit", function(e) {
        e.preventDefault();
        password();
      })

      function password() {
        $("#password-btn").html("<span class='spinner-border'></span>");
        $("#password-btn").attr("disabled", true);
        const oldpwd = $("#oldpwd").val();
        const newpwd = $("#newpwd").val();
        const rnewpwd = $("#rnewpwd").val();
        $.post("../includes/settings.inc.php", {
          oldpwd,
          newpwd,
          rnewpwd
        }, function(data) {
          toast(data);
          $("#password-btn").html("Save Details");
          $("#password-btn").attr("disabled", false);
        })
      }
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
  header("Location: ./login.php");
}
?>
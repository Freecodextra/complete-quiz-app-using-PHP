<?php
session_start();
if (isset($_SESSION['admin'])) {
  if (isset($_POST['edit'])) {
    require("../includes/db.inc.php");
    $id = $_POST['edit'];
    $sql = "SELECT * FROM users WHERE id = '$id';";
    $result = mysqli_query($conn, $sql);
    $data = null;
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $data = $row;
      }
    }
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
      ?>
      <main>
        <div class="head" id="settings">
          <h3>Edit Student Profile</h3>
          <p>Edit student account, personal details, and password here.</p>
          <div class="form">
            <div class="row d-flex align-items-center justify-content-center">
              <div class="col-md-3 shadow-sm">
                <h4>Account</h4>
                <hr>
                <form action="../includes/students.inc.php" method="post" enctype="multipart/form-data" id="account">
                  <div class="mb-3">
                    <label for="uid" class="form-label">Username</label>
                    <input type="text" class="form-control" id="uid" name="uid" placeholder="Username" value="<?php echo $data['username']; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" placeholder="Email" name="email" id="email" value="<?php echo $data['email']; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="image" class="form-label">Profile Image</label>
                    <input type="file" name="image" class="form-control" id="image" accept="image/*">
                  </div>
                  <!-- Hidden Input -->
                  <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                  <button type="submit" name="account" id="account-btn" class="btn">Save Details</button>
                </form>
              </div>
              <div class="col-md-3 shadow-sm">
                <h4>Personal</h4>
                <hr>
                <div class="mb-3">
                  <label for="fNmae" class="form-label">First Name</label>
                  <input type="text" class="form-control" id="fName" name="fName" placeholder="First Name" autocomplete="off" value="<?php echo $data['fName']; ?>">
                </div>
                <div class="mb-3">
                  <label for="lName" class="form-label">Last Name</label>
                  <input type="text" class="form-control" id="lName" name="lName" placeholder="Last Name" autocomplete="off" value="<?php echo $data['lName']; ?>">
                </div>
                <div class="mb-3">
                  <label for="city" class="form-label">City/Town</label>
                  <input type="text" class="form-control" id="city" name="city" placeholder="City/Town" autocomplete="off" value="<?php echo $data['city']; ?>">
                </div>
                <div class="mb-3">
                  <label for="phone" class="form-label">Phone Number</label>
                  <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" value="<?php echo $data['phone']; ?>">
                </div>
                <div class="mb-3">
                  <label for="sex" class="form-label">Sex</label>
                  <select name="sex" id="sex" class="form-control">
                    <option value="Male" <?php if ($data['sex'] === "Male") {
                                            echo "selected";
                                          } ?>>Male</option>
                    <option value="Female" <?php if ($data['sex'] === "Female") {
                                              echo "selected";
                                            } ?>>Female</option>
                    <option value="Others" <?php if ($data['sex'] === "Others") {
                                              echo "selected";
                                            } ?>>Others</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="level" class="form-label">Level</label>
                  <select name="level" id="level" class="form-control">
                  </select>
                </div>
                <button type="submit" class="btn" id="personal-btn" onclick="editPersonal(<?php echo $data['id']; ?>)">Save Details</button>
              </div>
              <div class="col-md-3 shadow-sm">
                <h4>Password</h4>
                <p>Setup Password Here</p>
                <hr>
                <div class="mb-3">
                  <label for="newpwd" class="form-label">New Password</label>
                  <input type="password" class="form-control" id="pwd" placeholder="New Password">
                </div>
                <div class="mb-3">
                  <label for="rnewpwd" class="form-label">Confirm Password</label>
                  <input type="password" class="form-control" id="rpwd" placeholder="Confirm Password">
                </div>
                <button type="submit" class="btn" id="password-btn" onclick="editPassword(<?php echo $data['id']; ?>)">Save Details</button>
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
      <script>
        $(document).ready(function() {
          getClasses();
        })
        // ====================== ACCOUNT ======================
        $("#account").on("submit", function(e) {
          e.preventDefault();
          $("#account-btn").html("<span class='spinner-border'></span>");
          $("#account-btn").attr("disabled", true);
          $.ajax({
            url: "../includes/students.inc.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data, status) {
              toast(data);
              $("#account-btn").html("Save Details");
              $("#account-btn").attr("disabled", false);
            }
          });
        });
        // ================== PERSONAL =======================
        function editPersonal(hidden) {
          $("#personal-btn").html("<span class='spinner-border'></span>");
          $("#personal-btn").attr("disabled", true);
          var personal = true;
          var fName = $("#fName").val();
          var lName = $("#lName").val();
          var city = $("#city").val();
          var phone = $("#phone").val();
          var sex = $("#sex").val();
          var level = $("#level").val();
          $.post("../includes/students.inc.php", {
            personal: personal,
            hidden: hidden,
            fName: fName,
            lName: lName,
            city: city,
            phone: phone,
            sex: sex,
            level: level
          }, function(data, status) {
            toast(data);
            $("#personal-btn").html("Save Details");
            $("#personal-btn").attr("disabled", false);
          });
        }
        //  ================== PASSWORD =======================
        function editPassword(id) {
          $("#password-btn").html("<span class='spinner-border'></span>");
          $("#password-btn").attr("disabled", true);
          var password = true;
          var pwd = $("#pwd").val();
          var rpwd = $("#rpwd").val();
          $.post("../includes/students.inc.php", {
            id: id,
            password: password,
            pwd: pwd,
            rpwd: rpwd
          }, function(data, status) {
            $("#pwd").val("");
            $("#rpwd").val("");
            toast(data);
            $("#password-btn").html("Save Details");
            $("#password-btn").attr("disabled", false);
          });
        }
        // ========================= GET ALL CLASSES =====================
        function getClasses() {
          var fetchClass = true;
          $.post("../includes/classes.inc.php", {
            fetchClass: fetchClass
          }, function(data, status) {
            var results = JSON.parse(data);
            var x = '<option value="-1">--- Select Class ---</option> <option value="0">default</option>';
            results.forEach(result => {
              x += `<option value="${Number(result.id)}">${result.class_name}</option>`;
            });
            $("#level").html(x);
            $("#level").val(<?php echo $data['level']; ?>);
          });
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
    header("Location: ./sudents.php");
  }
} else {
  header("Location: ./login.php");
}
?>
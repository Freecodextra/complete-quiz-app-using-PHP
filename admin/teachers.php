<?php
session_start();
if (isset($_SESSION['admin'])) {
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
    <!-- MAIN CONTENT -->
    <main>
      <div class="admin">
        <div class="dashboard container-fluid">
          <div class="summary">
            <div class="row">
              <div class="col-md-3">
                <div class="icon">
                  <i class="bi bi-people"></i>
                </div>
                <div class="number">
                  <h2 id="teacher-num"></h2>
                </div>
                <div class="text">
                  <p>Total Teachers</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="icon">
                  <i class="bi bi-people"></i>
                </div>
                <div class="number">
                  <h2 id="student-num"></h2>
                </div>
                <div class="text">
                  <p>Total Students</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="icon">
                  <i class="bi bi-mortarboard"></i>
                </div>
                <div class="number">
                  <h2 id="course-num"></h2>
                </div>
                <div class="text">
                  <p>Total Courses</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="add-student">
        <button class="btn" data-bs-toggle="modal" data-bs-target="#myModal1">Add New Teacher</button>
        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#myModal">
          Assign Teacher
        </button>
      </div>
      <!-- =================== MODAL============================== -->
      <div class="modal fade" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Assign Teacher</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <div class="mb-3">
                <label for="teacher" class="form-label">Select Teacher</label>
                <input list="teacher" class="form-control" id="teachers">
                <datalist id="teacher">
                </datalist>
              </div>
              <div class="mb-3">
                <label for="course" class="form-label">Select Course</label>
                <select id="course" name="course" class="form-control">
                </select>
              </div>
              <div class="d-grid shadow-sm">
                <button type="submit" class="btn btn-primary" id="assign-btn" onclick="assignTeacher()">Assign Teacher</button>
              </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>

          </div>
        </div>
      </div>
      <!-- =================== MODAL II ============================== -->
      <div class="modal fade" id="myModal1">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Add New Teacher</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <div class="mb-3">
                <label for="fName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="fName" placeholder="First Name">
              </div>
              <div class="mb-3">
                <label for="lName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lName" placeholder="Last Name">
              </div>
              <div class="mb-3">
                <label for="uid" class="form-label">Username</label>
                <input type="text" class="form-control" id="uid" placeholder="Username">
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" placeholder="Email">
              </div>
              <div class="mb-3">
                <label for="pwd" class="form-label">Password</label>
                <input type="password" class="form-control" id="pwd" placeholder="Password">
              </div>
              <div class="mb-3">
                <label for="rpwd" class="form-label">Re-Password</label>
                <input type="password" class="form-control" id="rpwd" placeholder="Repeat Password">
              </div>
              <div class="d-grid shadow-sm">
                <button type="submit" class="btn btn-primary" id="register-btn" onclick="addTeacher()">Register Teacher</button>
              </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>

          </div>
        </div>
      </div>
      <div class="container-fluid">
        <div class="row">

          <div class="table-data shadow-sm">
            <div class="alert alert-primary">
              <strong>TEACHERS</strong>
            </div>
            <table width="100%" class="table table-hover table-borderless" id="teacher-table">
              <thead>
                <tr>
                  <td>#</td>
                  <td>Teacher ID</td>
                  <td>First Name</td>
                  <td>Last Name</td>
                  <td>Email</td>
                  <td>Course(s)</td>
                  <td>Phone</td>
                  <td>Last Login</td>
                  <td>Action</td>
                </tr>
              </thead>
            </table>
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
      $("document").ready(function() {
        displayTable();
        getTeachers();
        getCourses();
        studentNum();
        teacherNum();
        courseNum();
      });
      var table = $('#teacher-table').DataTable({
        ajax: "../text/teachers.txt"
      });
      // ========================= GET ALL TEACHERS =====================
      function getTeachers() {
        var fetchTeacher = true;
        $.post("../includes/teachers.inc.php", {
          fetchTeacher: fetchTeacher
        }, function(data, status) {
          var results = JSON.parse(data);
          var x = '';
          results.forEach(result => {
            x += `<option value="${result.email}">`;
          });
          $("#teacher").html(x);
        });
      }
      // ========================= GET ALL CLASSES =====================
      function getCourses() {
        var fetchCourse = true;
        $.post("../includes/courses.inc.php", {
          fetchCourse: fetchCourse
        }, function(data, status) {
          var results = JSON.parse(data);
          var x = '<option value="0">--- Select Course ---</option>';
          results.forEach(result => {
            x += `<option value="${Number(result.id)}">${result.course_short_name}</option>`;
          });
          $("#course").html(x);
        });
      }
      // ========================== ADD TEACHER =========================
      function addTeacher() {
        $("#register-btn").html("<span class='spinner-border'></span>");
        $("#register-btn").attr("disabled", true);
        var addTeacher = true;
        var fName = $("#fName").val();
        var lName = $("#lName").val();
        var uid = $("#uid").val();
        var email = $("#email").val();
        var pwd = $("#pwd").val();
        var rpwd = $("#rpwd").val();
        $.post("../includes/teachers.inc.php", {
          addTeacher: addTeacher,
          fName: fName,
          lName: lName,
          uid: uid,
          email: email,
          pwd: pwd,
          rpwd: rpwd
        }, function(data, status) {
          if (data == "Registered Successfully") {
            $("#myModal1").modal("hide");
            $("#fName").val("");
            $("#lName").val("");
            $("#uid").val("");
            $("#email").val("");
            $("#pwd").val("");
            $("#rpwd").val("");
            displayTable();
            getTeachers();
            teacherNum();
          }
          toast(data);
          $("#register-btn").html("Register Teacher");
          $("#register-btn").attr("disabled", false);
        });
      }
      //============================= DELETE TEACHER =========================
      function deleteTeacher(id) {
        var remove = true;
        $.post("../includes/teachers.inc.php", {
          id: id,
          remove: remove
        }, function(data, status) {
          displayTable();
          getTeachers();
          teacherNum();
          toast(data);
        });
      }
      //================================== ASSIGN TEACHER ==============================
      function assignTeacher() {
        $("#assign-btn").html("<span class='spinner-border'></span>");
        $("#assign-btn").attr("disabled", true);
        var assign = true;
        var teacher = $("#teachers").val();
        var courseId = $("#course").val();
        $.post("../includes/courses.inc.php", {
          assign: assign,
          teacher: teacher,
          courseId: courseId
        }, function(data, status) {
          if (data === "Assigned Successfully") {
            displayTable();
            $("#teachers").val("");
            $("#course").val(-1);
            $("#myModal").modal("hide");
          }
          toast(data);
          $("#assign-btn").html("Assign Teacher");
          $("#assign-btn").attr("disabled", false);
        });
      }
      //============================= CARDS DISPLAYS =========================
      function studentNum() {
        var fetchStudents = true;
        $.post("../includes/cards.inc.php", {
          fetchStudents: fetchStudents
        }, function(data, status) {
          $("#student-num").html(data);
        });
      }

      function courseNum() {
        var fetchCourses = true;
        $.post("../includes/cards.inc.php", {
          fetchCourses: fetchCourses
        }, function(data, status) {
          $("#course-num").html(data);
        });
      }

      function teacherNum() {
        var fetchTeachers = true;
        $.post("../includes/cards.inc.php", {
          fetchTeachers: fetchTeachers
        }, function(data, status) {
          $("#teacher-num").html(data);
        });
      }
      //============================ DISPLAY TABLE ======================================
      function displayTable() {
        var display = true;
        $.post("../includes/teachers.inc.php", {
          display: display
        }, function(data, status) {
          table.ajax.reload();
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
  header("Location: ./login.php");
}
?>
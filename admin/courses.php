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
                  <h2 id="category-num"></h2>
                </div>
                <div class="text">
                  <p>Total Course Categories</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="icon">
                  <i class="bi bi-people"></i>
                </div>
                <div class="number">
                  <h2 id="course-num"></h2>
                </div>
                <div class="text">
                  <p>Total Courses</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="icon">
                  <i class="bi bi-mortarboard"></i>
                </div>
                <div class="number">
                  <h2 id="topic-num"></h2>
                </div>
                <div class="text">
                  <p>Total Topics</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="add-student">
        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#myModal1">
          Add New Course
        </button>
        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#myModal">
          Assign Teacher
        </button>
        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#myModal3">
          Enroll Student
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
      <!-- =================== MODAL 3============================== -->
      <div class="modal fade" id="myModal3">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Enroll Student</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <div class="mb-3">
                <label for="student" class="form-label">Select Student</label>
                <input list="student" class="form-control" id="students">
                <datalist id="student">`
                </datalist>
              </div>
              <div class="mb-3">
                <label for="course" class="form-label">Select Course</label>
                <select id="e-course" name="course" class="form-control">
                </select>
              </div>
              <div class="d-grid shadow-sm">
                <button type="submit" class="btn btn-primary" id="enroll-btn" onclick="enrollUser()">Enroll Student</button>
              </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>

          </div>
        </div>
      </div>
      <!-- =================== MODAL 1============================== -->
      <div class="modal fade" id="myModal1">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Add Course</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <div class="mb-3">
                <label for="student" class="form-label">Course Name</label>
                <input type="text" class="form-control" placeholder="e.g Introduction to PLant Biology" id="course-name">
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Course Short Name</label>
                <input type="text" class="form-control" placeholder="e.g BIOL 111" id="course-short-name">
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Course Category</label>
                <select id="course-cat" name="course" class="form-control">
                </select>
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Class</label>
                <select id="level" name="course" class="form-control">
                </select>
              </div>
              <div class="d-grid shadow-sm">
                <button class="btn btn-primary" id="course-btn" onclick="addCourse()">Add Course</button>
              </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>

          </div>
        </div>
      </div>
      <!-- =================== MODAL 2 (UPDATE MODAL)============================== -->
      <div class="modal fade" id="myModal2">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Update Course</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <div class="mb-3">
                <label for="student" class="form-label">Course Name</label>
                <input type="text" class="form-control" placeholder="e.g Introduction to PLant Biology" id="u-course-name">
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Course Short Name</label>
                <input type="text" class="form-control" placeholder="e.g BIOL 111" id="u-course-short-name">
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Course Category</label>
                <select id="u-course-cat" name="course" class="form-control">
                </select>
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Class</label>
                <select id="u-level" name="course" class="form-control">
                </select>
              </div>
              <!-- Hidden input -->
              <input type="hidden" name="hidden" id="hidden">
              <div class="d-grid shadow-sm">
                <button class="btn btn-primary" id="u-course-btn" onclick="update()">Update Course</button>
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
              <strong>COURSES</strong>
            </div>
            <table width="100%" class="table table-hover table-borderless" id="teacher-table">
              <thead>
                <tr>
                  <td>#</td>
                  <td>Course ID</td>
                  <td>Short Name</td>
                  <td>Full Name</td>
                  <td>Course Category</td>
                  <td>Enrolled Users</td>
                  <td>Teacher</td>
                  <td>Date Created</td>
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
      $('document').ready(function() {
        displayTable();
        getClasses();
        getCourseCat();
        getCourses();
        getStudents();
        getTeachers();
        categoryNum();
        courseNum();
        topicNum();
      });
      var table = $('#teacher-table').DataTable({
        ajax: "../text/courses.txt",
      });
      // ========================= GET ALL CLASSES =====================
      function getClasses() {
        var fetchClass = true;
        $.post("../includes/classes.inc.php", {
          fetchClass: fetchClass
        }, function(data, status) {
          var results = JSON.parse(data);
          var x = '<option value="0">--- Select Class ---</option>';
          results.forEach(result => {
            x += `<option value="${Number(result.id)}">${result.class_name}</option>`;
          });
          $("#level").html(x);
          $("#u-level").html(x);
        });
      }
      // ========================= GET ALL CLASSES =====================
      function getCourses() {
        var fetchCourse = true;
        $.post("../includes/courses.inc.php", {
          fetchCourse: fetchCourse
        }, function(data, status) {
          var results = JSON.parse(data);
          var x = '<option value="-1">--- Select Course ---</option>';
          results.forEach(result => {
            x += `<option value="${Number(result.id)}">${result.course_short_name}</option>`;
          });
          $("#course").html(x);
          $("#e-course").html(x);
        });
      }
      // ========================= GET ALL COURSE CATEGOIES =====================
      function getCourseCat() {
        var fetchCat = true;
        $.post("../includes/category.inc.php", {
          fetchCat: fetchCat
        }, function(data, status) {
          var results = JSON.parse(data);
          var x = '<option value="-1">--- Select Course Category ---</option>';
          results.forEach(result => {
            x += `<option value="${Number(result.id)}">${result.cat_name}</option>`;
          });
          $("#course-cat").html(x);
          $("#u-course-cat").html(x);
        });
      }
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
      // ========================= GET ALL StudentS =====================
      function getStudents() {
        var fetchStudent = true;
        $.post("../includes/students.inc.php", {
          fetchStudent: fetchStudent
        }, function(data, status) {
          var results = JSON.parse(data);
          var x = '';
          results.forEach(result => {
            x += `<option value="${result.email}">`;
          });
          $("#student").html(x);
        });
      }
      // ========================= ADD COOURSE =====================
      function addCourse() {
        $("#course-btn").html("<span class='spinner-border'></span>");
        $("#course-btn").attr("disabled", true);
        var add = true;
        var courseName = $("#course-name").val();
        var courseShortName = $("#course-short-name").val();
        var courseCat = $("#course-cat").val();
        var level = $("#level").val();
        $.post("../includes/courses.inc.php", {
          add: add,
          courseName: courseName,
          courseShortName,
          courseShortName,
          courseCat: courseCat,
          level: level
        }, function(data, status) {
          if (data == "Added Successfully") {
            $("#myModal1").modal("hide");
            $("#course-name").val("");
            $("#course-short-name").val("");
            displayTable();
            getCourses();
            courseNum();
          }
          toast(data);
          $("#course-btn").html("Add Course");
          $("#course-btn").attr("disabled", false);
        });
      }

      //================================== UPDATE COURSE ==============================
      function updateCourse(id) {
        var edit = true;
        $.post("../includes/courses.inc.php", {
          id: id,
          edit: edit
        }, function(data, status) {
          var result = JSON.parse(data);
          $("#u-course-name").val(result.course_name);
          $("#u-course-short-name").val(result.course_short_name);
          $("#u-course-cat").val(result.course_category_id);
          $("#u-level").val(result.level);
          $("#hidden").val(Number(result.id));
          $("#myModal2").modal("show");
        });
      }

      function update() {
        $("#u-course-btn").html("<span class='spinner-border'></span>");
        $("#u-course-btn").attr("disabled", true);
        var update = true;
        var updateID = $("#hidden").val();
        var courseName = $("#u-course-name").val();
        var courseShortName = $("#u-course-short-name").val();
        var courseCat = $("#u-course-cat").val();
        var level = $("#u-level").val();
        $.post("../includes/courses.inc.php", {
          id: updateID,
          update: update,
          courseName: courseName,
          courseShortName,
          courseShortName,
          courseCat: courseCat,
          level: level
        }, function(data, status) {
          $("#myModal2").modal("hide");
          $("#course-name").val("");
          $("#course-short-name").val("");
          displayTable();
          toast(data);
          $("#u-course-btn").html("Update Course");
          $("#u-course-btn").attr("disabled", false);
        });
      }
      //============================= DELETE CATEGORY =========================
      function deleteCourse(id) {
        var remove = true;
        $.post("../includes/courses.inc.php", {
          id: id,
          remove: remove
        }, function(data, status) {
          displayTable();
          getCourses();
          courseNum();
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

      function unassignTeacher(id) {
        var unassign = true;
        $.post("../includes/courses.inc.php", {
          unassign: unassign,
          id: id
        }, function(data, status) {
          if (data === "Unassigned Successfully") {
            displayTable();
          }
          toast(data);
        });
      }
      //================================== ENROLL USER ==============================
      function enrollUser() {
        $("#enroll-btn").html("<span class='spinner-border'></span>");
        $("#enroll-btn").attr("disabled", true);
        var enroll = true;
        var student = $("#students").val();
        var courseId = $("#e-course").val();
        $.post("../includes/courses.inc.php", {
          enroll: enroll,
          student: student,
          courseId: courseId
        }, function(data, status) {
          if (data === "Enrolled Successfully") {
            displayTable();
            $("#students").val("");
            $("#e-course").val(-1);
            $("#myModal3").modal("hide");
          }
          toast(data);
          $("#enroll-btn").html("Enroll Student");
          $("#enroll-btn").attr("disabled", false);
        });
      }

      //============================= CARDS DISPLAYS =========================
      function categoryNum() {
        var fetchCategories = true;
        $.post("../includes/cards.inc.php", {
          fetchCategories: fetchCategories
        }, function(data, status) {
          $("#category-num").html(data);
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

      function topicNum() {
        var fetchTopics = true;
        $.post("../includes/cards.inc.php", {
          fetchTopics: fetchTopics
        }, function(data, status) {
          $("#topic-num").html(data);
        });
      }
      //============================ DISPLAY TABLE ======================================
      function displayTable() {
        var display = true;
        $.post("../includes/courses.inc.php", {
          display: display
        }, function(data, status) {
          table.ajax.reload();
        });
      }
      // ===================== TOASTIFY =========================
      function toast(x) {
        Toastify({
          text: x,
          duration: 3000,
          close: true,
          background: "linear-gradient(to right, #4649ff, #1d1ce5)",
          style: {}
        }).showToast()
      }
    </script>
    </script>
  </body>

  </html>
<?php
} else {
  header("Location: ./login.php");
}
?>
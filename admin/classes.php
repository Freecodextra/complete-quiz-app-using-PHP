<?php
session_start();
 if (isset($_SESSION['admin'])) {
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
                <h2 id="student-num"></h2>
              </div>
              <div class="text">
                <p>Total Students</p>
              </div>
            </div>
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
                <i class="bi bi-mortarboard"></i>
              </div>
              <div class="number">
                <h2 id="class-num"></h2>
              </div>
              <div class="text">
                <p>Total Classes</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="add-student">
      <button class="btn" data-bs-toggle="modal" data-bs-target="#myModal1">Add New Class</button>
      <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#myModal">
        Assign Teacher
      </button>
    </div>
    <!-- =================== MODAL 1============================== -->
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
                <label for="student" class="form-label">Select Teacher</label>
                <input type="email" list="teacher" id="teachers" class="form-control">
                <datalist id="teacher">
                </datalist>
              </div>
              <div class="mb-3">
                <label for="course" class="form-label">Select Class</label>
                <select id="course" name="course" class="form-control">
                </select>
              </div>
              <div class="d-grid shadow-sm">
                <button type="submit" class="btn btn-primary" onclick="assignTeacher()">Assign Teacher</button>
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
            <h4 class="modal-title">Add Class</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="mb-3">
              <label for="student" class="form-label">Add Class</label>
              <input type="text" class="form-control" placeholder="e.g Primary 1" id="class">
            </div>
            <div class="d-grid shadow-sm">
              <button class="btn btn-primary" onclick="addClass()">Add Class</button>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>
    <!-- =================== MODAL II 1============================== -->
    <div class="modal fade" id="update">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Update Class</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="mb-3">
              <label for="student" class="form-label">Update Class</label>
              <input type="text" class="form-control" placeholder="e.g Primary 1" id="update-class">
            </div>
            <!-- Hidden input -->
            <input type="hidden" name="hidden" id="hidden">
            <div class="d-grid shadow-sm">
              <button class="btn btn-primary" onclick="update()">Update Class</button>
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
            <strong>CLASSES</strong>
          </div>
          <table width="100%" class="table table-hover table-borderless" id="teacher-table">
            <thead>
              <tr>
                <td>#</td>
                <td>Class ID</td>
                <td>Class Name</td>
                <td>Teacher</td>
                <td>No. of Students</td>
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
      getTeachers();
      classNum();
      teacherNum();
      studentNum();
    });
    var table = $('#teacher-table').DataTable({
      ajax: "../text/classes.txt",
    });
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
        $("#course").html(x);
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
    // ========================= ADD CATEGORY =====================
    function addClass() {
      var clas = $("#class").val();
      $.post("../includes/classes.inc.php", {
        clas: clas
      }, function(data, status) {
        if (data == "Added Successfully") {
          $("#myModal1").modal("hide");
          $("#class").val("");
          displayTable();
          getClasses();
          classNum();
        }
        toast(data);
      });
    }

    //================================== UPDATE CATEGORY ==============================
    function updateClass(id) {
      var edit = true;
      $.post("../includes/classes.inc.php", {
        id: id,
        edit: edit
      }, function(data, status) {
        var result = JSON.parse(data);
        $("#update-class").val(result.class_name);
        $("#hidden").val(Number(result.id));
        $("#update").modal("show");
      });
    }

    function update() {
      var update = true;
      var updateID = $("#hidden").val();
      var updateName = $("#update-class").val();
      $.post("../includes/classes.inc.php", {
        id: updateID,
        update: update,
        updateName: updateName
      }, function(data, status) {
        $("#update").modal("hide");
        $("#update-class").val("");
        $("#hidden").val("");
        displayTable();
        getClasses();
        toast(data);
      });
    }
    //============================= DELETE CATEGORY =========================
    function deleteClass(id) {
      var remove = true;
      $.post("../includes/classes.inc.php", {
        id: id,
        remove: remove
      }, function(data, status) {
        displayTable();
        getClasses();
        classNum();
        toast(data);
      });
    }
    //================================== ASSIGN TEACHER ==============================
    function assignTeacher() {
      var assign = true;
      var teacher = $("#teachers").val();
      var classId = $("#course").val();
      $.post("../includes/classes.inc.php", {
        assign: assign,
        teacher:teacher,
        classId:classId
      }, function(data, status) {
        if (data === "Assigned Successfully") {
          displayTable();
          $("#teachers").val("");
          $("#course").val(-1);
          $("#myModal").modal("hide");
        }
        toast(data);
      });
    }
    function unassignTeacher(id) {
      var unassign = true;
      $.post("../includes/classes.inc.php", {
        unassign: unassign,
        id:id
      }, function(data, status) {
        if (data === "Unassigned Successfully") {
          displayTable();
        }
        toast(data);
      });
    }
    //================================== CARDS VALUES ==============================
    function classNum() {
      var fetchClasses = true;
      $.post("../includes/cards.inc.php", {
        fetchClasses: fetchClasses
      }, function(data, status) {
        $("#class-num").html(data);
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
    function studentNum() {
      var fetchStudents = true;
      $.post("../includes/cards.inc.php", {
        fetchStudents: fetchStudents
      }, function(data, status) {
        $("#student-num").html(data);
      });
    }
    //============================ DISPLAY TABLE ======================================
    function displayTable() {
      var display = true;
      $.post("../includes/classes.inc.php", {
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
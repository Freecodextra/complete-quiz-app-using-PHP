<?php 
session_start();
if (isset($_SESSION['teacher'])) {
if (isset($_GET['course'])) {
  require("../includes/db.inc.php");
  $id = $_GET['course'];
  $teacher_id = $_SESSION['teacher'];
  $sql = "SELECT * FROM courses WHERE id = '$id';";
  $result = mysqli_query($conn, $sql);
  $data = null;
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $data = $row;
    }
  }
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
    <title>Teacher - Quiz App</title>
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
                  <h2 id="enroll-num"></h2>
                </div>
                <div class="text">
                  <p>Total Enrolled Students</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="icon">
                  <i class="bi bi-people"></i>
                </div>
                <div class="number">
                  <h2 id="topic-num"></h2>
                </div>
                <div class="text">
                  <p>Total Topics</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="icon">
                  <i class="bi bi-mortarboard"></i>
                </div>
                <div class="number">
                  <h2 id="exercise-num"></h2>
                </div>
                <div class="text">
                  <p>Total Exercise</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="add-student">
        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#myModal1">
          Add New Topic
        </button>
          <button class="btn" id="view-topics">View Topics</button>
        <button class="btn" data-bs-toggle="modal" data-bs-target="#myModal2">Enroll Student</button>
      </div>
      <!-- =================== MODAL 1============================== -->
      <div class="modal fade" id="myModal1">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Add Topic</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <div class="mb-3">
                <label for="topicName" class="form-label">Topic Name</label>
                <input type="text" name="topicName" class="form-control" placeholder="e.g Chemical Combination" id="topicName">
              </div>
              <div class="mb-3">
                <label for="topicDesc" class="form-label">Topic Description</label>
                <textarea name="topicDesc" id="topicDesc" cols="30" rows="6" class="form-control" placeholder="e.g You will learn how chemicals combine together to form other chemicals..."></textarea>
              </div>
              <!-- Hidden Input -->
              <input type="hidden" name="hidden" id="course" value="<?php echo $data['id']; ?>">
              <div class="d-grid shadow-sm">
                <button type="submit" class="btn btn-primary" id="topic-btn" onclick="addTopic()">Add Topic</button>
              </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>

          </div>
        </div>
      </div>
      <!-- =================== MODAL 2============================== -->
      <div class="modal fade" id="myModal2">
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
              <!-- Hidden Input -->
              <input type="hidden" name="e-course" id="e-course" value="<?php echo $data['id']; ?>">
                <div class="d-grid shadow-sm">
                  <button type="submit" class="btn btn-primary" id="enroll-btn" onclick="enrollUser()">Enroll</button>
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
            <table width="100%" class="table table-hover table-borderless" id="teacher-table">
              <div class="alert alert-primary">
                <strong><?php echo $data['course_short_name']; ?></strong> - <?php echo $data['course_name']; ?>: <strong>Students</strong>
              </div>
              <thead>
                <tr>
                <td>#</td>
                <td>Student ID</td>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Username</td>
                <td>Email</td>
                <td>Level</td>
                <td>Plan</td>
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
    require("../admin/footer.php");
    ?>
    <script src="../public/app.js"></script>
    <script src="../public/loader.js"></script>
    <script>
      $("document").ready(function() {
        displayTable();
        getStudents();
        exerciseNum();
        topicNum();
        enrollNum();
      });
      var table = $('#teacher-table').DataTable({
        ajax: "../text/course-details.txt"
      });
      $("#view-topics").on("click",function () {
        var links = window.location.href.split("/");
        if (links[links.length - 1] == "") {
          links.pop();
          links.pop();
        }
        links.pop();
        window.location.assign(links.join("/")+"/topics.php?teacher=<?php echo $teacher_id; ?>&course=<?php echo $id; ?>" );
      })
    //============================= ADD TOPIC =========================
    function addTopic() {
      $("#topic-btn").html("<span class='spinner-border'></span>");
      $("#topic-btn").attr("disabled", true);
      var addTopic = true;
      var course = $("#course").val();
      var topicName = $("#topicName").val();
      var topicDesc = $("#topicDesc").val();
      $.post("../includes/topics.inc.php", {
        addTopic: addTopic,
        course: course,
        topicName: topicName,
        topicDesc: topicDesc
      }, function(data, status) {
        if (data == "Added Successfully") {
          $("#course").val("");
          $("#topicName").val("");
          $("#topicDesc").val("");
          $("#myModal1").modal("hide");
          topicNum();
        }
        toast(data);
        displayTable();
        $("#topic-btn").html("Add Topic");
        $("#topic-btn").attr("disabled",false);
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
    // enroll user
    function enrollUser() {
      $("#enroll-btn").html("<span class='spinner-border'></span>");
      $("#enroll-btn").attr("disabled", true);
      var enroll = true;
      var student = $("#students").val();
      var courseId = $("#e-course").val();
      $.post("../includes/courses.inc.php", {
        enroll: enroll,
        student:student,
        courseId:courseId
      }, function(data, status) {
        if (data === "Enrolled Successfully") {
          displayTable();
          enrollNum();
          $("#students").val("");
          $("#myModal2").modal("hide");
        }
        toast(data);
        $("#enroll-btn").html("Enroll Student");
        $("#enroll-btn").attr("disabled",false);
      });
    }
    // unenroll user
    function unenrollUser(id) {
      var unenroll = true;
      var student = id;
      var courseId = $("#e-course").val();
      $.post("../includes/course-details.inc.php", {
        unenroll: unenroll,
        student:student,
        courseId:courseId
      }, function(data, status) {
        if (data === "Unenrolled Successfully") {
          displayTable();
          enrollNum();
        }
        toast(data);
      });
    }
        //============================= CARDS DISPLAYS =========================
    function exerciseNum() {
      var fetchExercise = true;
      var courseId = $("#e-course").val();
      $.post("../includes/cards.inc.php", {
        fetchExercise: fetchExercise,
        courseId:courseId
      }, function(data, status) {
        $("#exercise-num").html(data);
      });
    }
    function topicNum() {
      var fetchCourseTopics = true;
      var courseId = $("#e-course").val();
      $.post("../includes/cards.inc.php", {
        fetchCourseTopics: fetchCourseTopics,
        courseId:courseId
      }, function(data, status) {
        $("#topic-num").html(data);
      });
    }
    function enrollNum() {
      var fetchEnroll = true;
      var courseId = $("#e-course").val();
      $.post("../includes/cards.inc.php", {
        fetchEnroll: fetchEnroll,
        courseId:courseId
      }, function(data, status) {
        $("#enroll-num").html(data);
      });
    }
    //============================ DISPLAY TABLE ======================================
    function displayTable() {
      var show = true;
      var courseId = $("#e-course").val();
      $.post("../includes/course-details.inc.php", {
        show: show,
        courseId:courseId
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
<?php } else {
  header("Location: ./courses.php");
}
 } else {
  header("Location: ./login.php");
 }
?>
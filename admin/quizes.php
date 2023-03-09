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
                <h2 id="course-num"></h2>
              </div>
              <div class="text">
                <p>Total Courses</p>
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
                <p>Total Quizes</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="add-student">
      <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#myModal">
        Add New Quiz
      </button>
    </div>
    <!-- =================== MODAL============================== -->
    <div class="modal fade" id="myModal">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Add Quiz</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="mb-3">
              <label for="course" class="form-label">Select Course</label>
              <select name="course" id="course" class="form-control">
              </select>
            </div>
            <div class="mb-3">
              <label for="topic" class="form-label">Select Topic</label>
              <select name="topic" id="topic" class="form-control">
              </select>
            </div>
            <div class="mb-3">
              <label for="student" class="form-label">Quiz Name</label>
              <input type="text" class="form-control" placeholder="e.g Exercise 1" id="quiz-name">
            </div>
            <div class="mb-3">
              <label for="student" class="form-label">Start Date/Time</label>
              <input type="datetime-local" class="form-control" id="start-date">
            </div>
            <div class="mb-3">
              <label for="student" class="form-label">End Date/Time</label>
              <input type="datetime-local" class="form-control" id="end-date">
            </div>
            <div class="mb-3">
              <label for="student" class="form-label">Duration(min)</label>
              <input type="number" class="form-control" id="duration">
            </div>
            <div class="mb-3">
              <label for="student" class="form-label">Number Of Attempts</label>
              <select name="attempts" id="attempts" class="form-control">
                <option value="0">Choose No. of Attempts</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="1000">Unlimited</option>
              </select>
            </div>
            <div class="d-grid shadow-sm">
              <button type="submit" class="btn btn-primary" id="quiz-btn" onclick="addQuiz()">Add Quiz</button>
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
            <h4 class="modal-title">Edit Quiz</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="mb-3">
              <label for="n-course" class="form-label">Select Course</label>
              <select name="n-course" id="n-course" class="form-control">
              </select>
            </div>
            <div class="mb-3">
              <label for="n-topic" class="form-label">Select Topic</label>
              <select name="n-topic" id="n-topic" class="form-control">
              </select>
            </div>
            <div class="mb-3">
              <label for="n-quiz-name" class="form-label">Quiz Name</label>
              <input type="text" class="form-control" placeholder="e.g Exercise 1" id="n-quiz-name">
            </div>
            <div class="mb-3">
              <label for="n-start-date" class="form-label">Start Date/Time</label>
              <input type="datetime-local" class="form-control" id="n-start-date">
            </div>
            <div class="mb-3">
              <label for="n-end-date" class="form-label">End Date/Time</label>
              <input type="datetime-local" class="form-control" id="n-end-date">
            </div>
            <div class="mb-3">
              <label for="student" class="form-label">Duration(min)</label>
              <input type="number" class="form-control" id="n-duration">
            </div>
            <div class="mb-3">
              <label for="n-attempts" class="form-label">Number Of Attempts</label>
              <select name="n-attempts" id="n-attempts" class="form-control">
                <option value="0">Choose No. of Attempts</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="1000">Unlimited</option>
              </select>
            </div>
            <!-- Hidden -->
            <input type="hidden" name="hidden" id="hidden">
            <div class="d-grid shadow-sm">
              <button type="submit" class="btn btn-primary" id="u-quiz-btn" onclick="updateQuiz()">Update Quiz</button>
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
              <strong>QUIZES</strong>
            </div>
            <thead>
              <tr>
                <td>#</td>
                <td>Quiz ID</td>
                <td>Name</td>
                <td>Course</td>
                <td>Topic</td>
                <td>No. Of Questions</td>
                <td>No. Of Attempts</td>
                <td>Duration</td>
                <td>Start Date</td>
                <td>End Date</td>
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
      getCourses();
      getTopics(0);
      courseNum();
      topicNum();
      exerciseNum();
    });
    var table = $('#teacher-table').DataTable({
      ajax: "../text/quizes.txt"
    });
    // ========================= GET ALL COURSES =====================
    function getCourses() {
      var fetchCourse = true;
      $.post("../includes/courses.inc.php", {
        fetchCourse: fetchCourse
      }, function(data, status) {
        var results = JSON.parse(data);
        var x = '<option value="-1">--- Select Course ---</option><option value="0">default</option>';
        results.forEach(result => {
          x += `<option value="${Number(result.id)}">${result.course_short_name}</option>`;
        });
        $("#course").html(x);
        $("#n-course").html(x);
      });
    }
    // ========================= GET TOPICS =====================
    function getTopics(course_id) {
      var fetchTopics = true;
      $.post("../includes/topics.inc.php", {
        fetchTopics: fetchTopics,
        course_id: course_id
      }, function(data, status) {
        if (data === '') {
          $("#topic").html('');
          $("#n-topic").html('');
        } else {
          var results = JSON.parse(data);
          var x = '<option value="-1">--- Select Topic ---</option><option value="0">default</option>';
          results.forEach(result => {
            x += `<option value="${Number(result.id)}">${result.topic_name}</option>`;
          });
          $("#topic").html(x);
          $("#n-topic").html(x);
        };
      });
    }
    $("#course").on("change", function() {
      getTopics($("#course").val());
    });
    $("#n-course").on("change", function() {
      getTopics($("#n-course").val());
    });
    // ADD QUIZ
    function addQuiz() {
      $("#quiz-btn").html("<span class='spinner-border'></span>");
  $("#quiz-btn").attr("disabled", true);
      var addQuiz = true;
      var topic = $("#topic").val();
      var course = $("#course").val();
      var quizName = $("#quiz-name").val();
      var startDate = $("#start-date").val();
      var endDate = $("#end-date").val();
      var duration = $("#duration").val();
      var attempts = $("#attempts").val();
      $.post("../includes/quizes.inc.php", {
        addQuiz: addQuiz,
        topic: topic,
        course: course,
        quizName: quizName,
        startDate: startDate,
        endDate: endDate,
        duration: duration,
        attempts: attempts
      }, function(data, status) {
        if (data == "Added Successfully") {
          $("#topic").val("");
          $("#course").val("");
          $("#quiz-name").val("");
          $("#start-date").val("");
          $("#end-date").val("");
          $("#duration").val("");
          $("#attempts").val("");
          $("#myModal").modal("hide");
          displayTable();
        }
        toast(data);
        $("#quiz-btn").html("Add Quiz");
     	$("#quiz-btn").attr("disabled",false);
      });
    }
    //============================= DELETE QUIZ =========================
    function deleteQuiz(id) {
      var remove = true;
      $.post("../includes/quizes.inc.php", {
        id: id,
        remove: remove
      }, function(data, status) {
        displayTable();
        toast(data);
      });
    }
    //============================= UPDATE TOPIC =========================
    function editQuiz(id) {
      var edit = true;
      $.post("../includes/quizes.inc.php", {
        id: id,
        edit: edit
      }, function(data, status) {
        var result = JSON.parse(data);
        $("#n-topic").val(Number(result[2]));
        $("#n-course").val(Number(result[1]));
        $("#n-quiz-name").val(result[3]);
        $("#n-start-date").val(result[4]);
        $("#n-end-date").val(result[5]);
        $("#n-duration").val(result[6]);
        $("#n-attempts").val(result[7]);
        $("#hidden").val(result[0]);
        $("#prevCourse").val(Number(result[1]));
        $("#prevTopic").val(Number(result[2]));
        $("#myModal1").modal("show");
      });
    }

    function updateQuiz() {
      $("#u-quiz-btn").html("<span class='spinner-border'></span>");
  $("#u-quiz-btn").attr("disabled", true);
      var update = true;
      var topic = $("#n-topic").val();
      var course = $("#n-course").val();
      var quizName = $("#n-quiz-name").val();
      var startDate = $("#n-start-date").val();
      var endDate = $("#n-end-date").val();
      var duration = $("#n-duration").val();
      var attempts = $("#n-attempts").val();
      var quizId = $("#hidden").val();
      $.post("../includes/quizes.inc.php", {
        update: update,
        topic: topic,
        course: course,
        quizName: quizName,
        startDate: startDate,
        endDate: endDate,
        quizId: quizId,
        duration: duration,
        attempts: attempts,
      }, function(data, status) {
        if (data == "Updated Successfully") {
          $("#myModal1").modal("hide");
          displayTable();
        }
        toast(data);
        $("#u-quiz-btn").html("Update Quiz");
     	$("#u-quiz-btn").attr("disabled",false);
      });
    }
    //============================= CARDS DISPLAYS =========================
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

    function exerciseNum() {
      var fetchExercises = true;
      $.post("../includes/cards.inc.php", {
        fetchExercises: fetchExercises
      }, function(data, status) {
        $("#exercise-num").html(data);
      });
    }
    //============================ DISPLAY TABLE ======================================
    function displayTable() {
      var show = true;
      $.post("../includes/quizes.inc.php", {
        show: show
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
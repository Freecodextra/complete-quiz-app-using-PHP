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
                <p>Total Exercises</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="add-student">
      <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#myModal">
        Add New Topic
      </button>
    </div>
    <!-- =================== MODAL============================== -->
    <div class="modal fade" id="myModal">
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
              <label for="course" class="form-label">Select Course</label>
              <select name="course" id="course" class="form-control">
              </select>
            </div>
            <div class="mb-3">
              <label for="topicName" class="form-label">Topic Name</label>
              <input type="text" name="topicName" class="form-control" placeholder="e.g Chemical Combination" id="topicName">
            </div>
            <div class="mb-3">
              <label for="topicDesc" class="form-label">Topic Description</label>
              <textarea name="topicDesc" id="topicDesc" cols="30" rows="6" class="form-control" placeholder="e.g You will learn how chemicals combine together to form other chemicals..."></textarea>
            </div>
            <div class="d-grid shadow-sm">
              <button type="submit" class="btn btn-primary" onclick="addTopic()">Add Topic</button>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>
    <!-- =================== MODAL============================== -->
    <div class="modal fade" id="myModal1">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Edit Topic</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="mb-3">
              <label for="course" class="form-label">Select Course</label>
              <select name="course" id="n-course" class="form-control">
              </select>
            </div>
            <div class="mb-3">
              <label for="topicName" class="form-label">Topic Name</label>
              <input type="text" class="form-control" placeholder="e.g Chemical Combination" id="n-topicName">
            </div>
            <div class="mb-3">
              <label for="topic-decs" class="form-label">Topic Description</label>
              <textarea name="topicDesc" id="n-topicDesc" cols="30" rows="6" class="form-control" placeholder="e.g You will learn how chemicals combine together to form other chemicals..."></textarea>
            </div>
            <!-- Hidden Input -->
            <input type="hidden" name="hidden" id="hidden">
            <input type="hidden" name="prevCourse" id="prevCourse">
            <div class="d-grid shadow-sm">
              <button type="submit" class="btn btn-primary" onclick="updateTopic()">Update Topic</button>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>
    <!-- =================== MODAL============================== -->
    <div class="modal fade" id="myModal2">
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
                <select name="" id="attempts" class="form-control">
                  <option value="0">Choose No. of Attempts</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="1000">Unlimited</option>
                </select>
              </div>
              <!-- Hidden Input -->
              <input type="hidden" name="h-topic" id="h-topic">
              <input type="hidden" name="h-course" id="h-course">
              <div class="d-grid shadow-sm">
                <button type="submit" class="btn btn-primary" onclick="addQuizz()">Add Quiz</button>
              </div>
              </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">

        <div class="table-data shadow-sm">
          <div class="alert alert-primary">
            <strong>TOPICS</strong>
          </div>
          <table width="100%" class="table table-hover table-borderless" id="teacher-table">
            <thead>
              <tr>
                <td>#</td>
                <td>Topic ID</td>
                <td>Topic Name</td>
                <td>Topic Description</td>
                <td>Course</td>
                <td>Level</td>
                <td>Exercises</td>
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
    $("document").ready(function() {
      displayTable();
      getCourses();
      courseNum();
      topicNum();
      exerciseNum();
    });
    var table = $('#teacher-table').DataTable({
      ajax: "../text/topics.txt"
    });
    // ========================= GET ALL COURSES =====================
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
        $("#n-course").html(x);
      });
    }
    //============================= ADD TOPIC =========================
    function addTopic() {
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
          $("#course").val(0);
          $("#topicName").val("");
          $("#topicDesc").val("");
          $("#myModal").modal("hide");
          topicNum();
          displayTable();
        }
        toast(data);
      });
    }
    //============================= ADD TOPIC =========================
    function addQuiz(id) {
      var quiz = true;
      $.post("../includes/topics.inc.php", {
        quiz: quiz,
        id: id
      }, function(data, status) {
        var result = JSON.parse(data);
        $("#h-topic").val(Number(result.id));
        $("#h-course").val(Number(result.course_id));
      });
      $("#myModal2").modal("show");
    }

    function addQuizz() {
      var addQuiz = true;
      var topic = $("#h-topic").val();
      var course = $("#h-course").val();
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
          $("#h-topic").val("");
          $("#h-course").val("");
          $("#quiz-name").val("");
          $("#start-date").val("");
          $("#end-date").val("");
          $("#duration").val("");
          $("#attempts").val("");
          $("#myModal2").modal("hide");
          exerciseNum();
        }
        toast(data);
      });
    }
    //============================= DELETE TOPIC =========================
    function deleteTopic(id) {
      var remove = true;
      $.post("../includes/topics.inc.php", {
        id: id,
        remove: remove
      }, function(data, status) {
        displayTable();
        topicNum();
        toast(data);
      });
    }
    //============================= UPDATE TOPIC =========================
    function editTopic(id) {
      var edit = true;
      $.post("../includes/topics.inc.php", {
        id: id,
        edit: edit
      }, function(data, status) {
        var result = JSON.parse(data);
        $("#n-course").val(Number(result.course_id));
        $("#n-topicName").val(result.topic_name);
        $("#n-topicDesc").val(result.topic_desc);
        $("#hidden").val(result.id);
        $("#prevCourse").val(Number(result.course_id));
        $("#myModal1").modal("show");
      });
    }

    function updateTopic() {
      var update = true;
      var hidden = $("#hidden").val();
      var course = $("#n-course").val();
      var topicName = $("#n-topicName").val();
      var topicDesc = $("#n-topicDesc").val();
      var prevCourse = $("#prevCourse").val();
      $.post("../includes/topics.inc.php", {
        update: update,
        hidden: hidden,
        course: course,
        topicName: topicName,
        topicDesc: topicDesc,
        prevCourse:prevCourse
      }, function(data, status) {
        if (data === "Edited Successfully") {
          $("#myModal1").modal("hide");
        }
        displayTable();
        toast(data);
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
      $.post("../includes/topics.inc.php", {
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
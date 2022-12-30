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
                <h2 id="question-num">100</h2>
              </div>
              <div class="text">
                <p>Total Questions</p>
              </div>
            </div>
            <div class="col-md-3">
              <div class="icon">
                <i class="bi bi-people"></i>
              </div>
              <div class="number">
                <h2 id="course-num">100</h2>
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
                <h2 id="topic-num">100</h2>
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
      <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#myModal">
        Add New Question
      </button>
    </div>
    <!-- =================== MODAL============================== -->
    <div class="modal fade" id="myModal">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Add Question</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <form method="POST" action="../includes/questions.inc.php" enctype="multipart/form-data" id="add-question">
              <div class="mb-3">
                <input onchange="handleChange()" type="radio" name="choose" id="choose1" value="choose1">
                <label for="choose1" class="form-label">Add To New Folder</label>
                <input onchange="handleChange()" type="radio" name="choose" id="choose2" value="choose2" checked>
                <label for="choose2" class="form-label">Add To Existing Folder</label>
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Select Course</label>
                <select name="course" id="course" class="form-control">
                </select>
              </div>
              <div class="mb-3 show2">
                <label for="student" class="form-label">Question Folder</label>
                <select name="folder" id="folder" class="form-control">
                </select>
              </div>
              <div class="mb-3 show1">
                <label for="student" class="form-label">Folder Name</label>
                <input type="text" class="form-control" placeholder="e.g BIOLOGY FOLDER" name="newfolder" id="newfolder">
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Question</label>
                <input type="text" class="form-control" placeholder="e.g Who is the father of Biology?" name="question" id="question">
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Image (optional)</label>
                <input class="form-control" type="file" name="image" id="image">
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Option 1</label>
                <input type="text" class="form-control" placeholder="option 1" name="opt1" id="opt1">
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Option 2</label>
                <input type="text" class="form-control" placeholder="option 2" name="opt2" id="opt2">
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Option 3 (optional)</label>
                <input type="text" class="form-control" placeholder="option 3" name="opt3" id="opt3">
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Option 4 (optional)</label>
                <input type="text" class="form-control" placeholder="option 4" name="opt4" id="opt4">
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Option 5 (optional)</label>
                <input type="text" class="form-control" placeholder="option 5" name="opt5" id="opt5">
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Answer</label>
                <select name="answer" id="answer" class="form-select">
                  <option value="0">--- Choose Answer ---</option>
                  <option value="0">Option 1</option>
                  <option value="1">Option 2</option>
                  <option value="2">Option 3</option>
                  <option value="3">Option 4</option>
                  <option value="4">Option 5</option>
                </select>
              </div>
              <div class="d-grid shadow-sm">
                <button type="submit" class="btn btn-primary">Add Question</button>
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
    <!-- =================== MODAL 1============================== -->
    <div class="modal fade" id="myModal1">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Edit Question</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <form method="POST" action="../includes/questions.inc.php" enctype="multipart/form-data" id="edit-question">
              <div class="mb-3">
                <input onchange="handleChange()" type="radio" name="e-choose" id="e-choose1" value="choose1">
                <label for="e-choose1" class="form-label">Add To New Folder</label>
                <input onchange="handleChange()" type="radio" name="e-choose" id="e-choose2" value="choose2" checked>
                <label for="e-choose2" class="form-label">Add To Existing Folder</label>
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Select Course</label>
                <select name="e-course" id="e-course" class="form-control">
                </select>
              </div>
              <div class="mb-3 e-show2">
                <label for="student" class="form-label">Question Folder</label>
                <select name="e-folder" id="e-folder" class="form-control">
                </select>
              </div>
              <div class="mb-3 e-show1">
                <label for="student" class="form-label">Folder Name</label>
                <input type="text" class="form-control" placeholder="e.g BIOLOGY FOLDER" name="e-newfolder" id="e-newfolder">
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Question</label>
                <input type="text" class="form-control" placeholder="e.g Who is the father of Biology?" name="e-question" id="e-question">
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Image (optional)</label>
                <input class="form-control" type="file" name="image" id="image">
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Option 1</label>
                <input type="text" class="form-control" placeholder="option 1" name="e-opt1" id="e-opt1">
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Option 2</label>
                <input type="text" class="form-control" placeholder="option 2" name="e-opt2" id="e-opt2">
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Option 3 (optional)</label>
                <input type="text" class="form-control" placeholder="option 3" name="e-opt3" id="e-opt3">
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Option 4 (optional)</label>
                <input type="text" class="form-control" placeholder="option 4" name="e-opt4" id="e-opt4">
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Option 5 (optional)</label>
                <input type="text" class="form-control" placeholder="option 5" name="e-opt5" id="e-opt5">
              </div>
              <div class="mb-3">
                <label for="student" class="form-label">Answer</label>
                <select name="e-answer" id="e-answer" class="form-select">
                  <option value="0">--- Choose Answer ---</option>
                  <option value="0">Option 1</option>
                  <option value="1">Option 2</option>
                  <option value="2">Option 3</option>
                  <option value="3">Option 4</option>
                  <option value="4">Option 5</option>
                </select>
              </div>
              <!-- Hidden Input -->
              <input type="hidden" name="hidden" id="hidden">
              <div class="d-grid shadow-sm">
                <button type="submit" class="btn btn-primary">Update Question</button>
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
    <div class="container-fluid">
      <div class="row">

        <div class="table-data shadow-sm">
          <table width="100%" class="table table-hover table-borderless" id="teacher-table">
            <div class="alert alert-primary">
              <strong>Question Bank</strong>
            </div>
            <thead>
              <tr>
                <td>#</td>
                <td>Question</td>
                <td>Question Folder</td>
                <td>Course</td>
                <td>Type</td>
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
      getFolders();
      handleChange();
      courseNum();
      topicNum();
      questionNum();
    });
    var table = $('#teacher-table').DataTable({
      ajax: "../text/questions.txt"
    });

    // ====================== ADD QUESTION ======================
    $("#add-question").on("submit", function(e) {
      e.preventDefault();
      $.ajax({
        url: "../includes/questions.inc.php",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data, status) {
          if (data == "Added Successfully") {
            $("#question").val("");
            $("#image").val("");
            $("#opt1").val("");
            $("#opt2").val("");
            $("#opt3").val("");
            $("#opt4").val("");
            $("#opt5").val("");
            $("#answer").val(-1);
            $("#course").val(0);
            $("#folder").val(0);
            $("#newfolder").val("");
            $("#myModal").modal("hide");
            getFolders();
            displayTable();
          }
          toast(data);
          questionNum();
        }
      });
    });
    // ====================== EDIT QUESTION ======================
    function editQuestion(id) {
      var edit = true;
      $.post("../includes/questions.inc.php", {
        id: id,
        edit: edit
      }, function(data, status) {
        var result = JSON.parse(data);
        console.log(result);
        $("#e-question").val(result[0].question);
        for (let i = 0; i < result[1].length; i++) {
          $("#e-opt" + (i + 1) + "").val(result[1][i].option);
          if (Number(result[1][i].answer) === 1) {
            $("#e-answer").val(Number(result[1][i].answer));
          }
        }
        $("#e-course").val(Number(result[0].course_id));
        $("#e-folder").val(Number(result[0].folder));
        $("#hidden").val(Number(result[0].id));
        $("#myModal1").modal("show");
      })
    }

    $("#edit-question").on("submit", function(e) {
      e.preventDefault();
      $.ajax({
        url: "../includes/questions.inc.php",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data, status) {
          if (data == "Updated Successfully") {
            $("#e-question").val("");
            $("#image").val("");
            $("#e-opt1").val("");
            $("#e-opt2").val("");
            $("#e-opt3").val("");
            $("#e-opt4").val("");
            $("#e-opt5").val("");
            $("#e-answer").val(-1);
            $("#e-folder").val(0);
            $("#e-newfolder").val("");
            $("#hidden").val("");
            $("#myModal1").modal("hide");
            getFolders();
            displayTable();
          }
          toast(data);
        }
      });
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
        $("#e-course").html(x);
      });
    }

    function getFolders() {
      var fetchFolders = true;
      $.post("../includes/folders.inc.php", {
        fetchFolders: fetchFolders
      }, function(data, status) {
        var results = JSON.parse(data);
        var x = '<option value="-1">--- Select Folder ---</option><option value="0">default</option>';
        results.forEach(result => {
          x += `<option value="${Number(result.id)}">${result.folder_name}</option>`;
        });
        $("#folder").html(x);
        $("#e-folder").html(x);
      });
    }

    //============================ DELETE QUESTION ======================================
    function deleteQuestion(id) {
      var remove = true;
      $.post("../includes/questions.inc.php", {
        id:id,
        remove: remove
      }, function(data, status) {
        displayTable();
        toast(data);
        questionNum();
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

    function questionNum() {
      var fetchQuestions = true;
      $.post("../includes/cards.inc.php", {
        fetchQuestions: fetchQuestions
      }, function(data, status) {
        $("#question-num").html(data);
      });
    }
    //============================ DISPLAY TABLE ======================================
    function displayTable() {
      var display = true;
      $.post("../includes/questions.inc.php", {
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
        // ===================== TOGGLE FOLDERS =========================
    var radioInput1 = document.getElementById('choose1');
    var eradioInput1 = document.getElementById('e-choose1');
    var radioInput2 = document.getElementById('choose2');
    var eradioInput2 = document.getElementById('e-choose2');
    var show1 = document.querySelector(".show1");
    var eshow1 = document.querySelector(".e-show1");
    var show2 = document.querySelector(".show2");
    var eshow2 = document.querySelector(".e-show2");

    function handleChange() {
      if (radioInput1.checked || eradioInput1.checked) {
        show1.style.display = "block";
        eshow1.style.display = "block";
        show2.style.display = "none";
        eshow2.style.display = "none";
        $("#folder").attr("disabled", true);
        $("#e-folder").attr("disabled", true);
        $("#newfolder").attr("disabled", false);
        $("#e-newfolder").attr("disabled", false);
      } else if (radioInput2.checked || eradioInput2.checked) {
        show1.style.display = "none";
        eshow1.style.display = "none";
        show2.style.display = "block";
        eshow2.style.display = "block";
        $("#folder").attr("disabled", false);
        $("#e-folder").attr("disabled", false);
        $("#newfolder").attr("disabled", true);
        $("#e-newfolder").attr("disabled", true);
      }
    }
  </script>
</body>

</html>
<?php
 } else {
  header("Location: ./login.php");
 }
?>
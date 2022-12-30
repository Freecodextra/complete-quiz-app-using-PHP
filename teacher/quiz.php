<?php
session_start();
if (isset($_SESSION['teacher'])) {
if (isset($_POST['view'])) {
  require "../includes/db.inc.php";
  $id = $_POST['view'];
  $sql = "SELECT * FROM quizes WHERE id = $id";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $topic_id = $row['topic_id'];
  $quiz_name = $row['quiz_name'];

  $t_sql = "SELECT * FROM topics WHERE id = $topic_id";
  $t_result = mysqli_query($conn, $t_sql);
  $t_row = mysqli_fetch_assoc($t_result);

  $topic_name = isset($t_row['topic_name']) ? $t_row['topic_name'] : "default";

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
                  <h2 id="attempt-num">100</h2>
                </div>
                <div class="text">
                  <p>Total Attempts</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="icon">
                  <i class="bi bi-people"></i>
                </div>
                <div class="number">
                  <h2 id="average-num">100</h2>
                </div>
                <div class="text">
                  <p>Average Score</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="icon">
                  <i class="bi bi-mortarboard"></i>
                </div>
                <div class="number">
                  <h2 id="percent-num">100</h2>
                </div>
                <div class="text">
                  <p>Percentage Pass</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="add-student">
        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#myModal1">
          Add New Question
        </button>
        <button class="btn" data-bs-toggle="modal" data-bs-target="#myModal2">Import From Question Bank</button>
      </div>
      <!-- =================== MODAL============================== -->
      <div class="modal fade" id="myModal1">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Add Question</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <form method="POST" action="../includes/quiz.inc.php" enctype="multipart/form-data" id="add-question">
                <div class="mb-3">
                  <label for="student" class="form-label">Question</label>
                  <textarea class="form-control" name="question" id="question" cols="30" rows="3" placeholder="e.g Who is the father of Biology?"></textarea>
                </div>
                <div class="mb-3">
                  <label for="student" class="form-label">Image (optional)</label>
                  <input class="form-control" type="file" name="image" id="image">
                </div>
                <div class="mb-3">
                  <label for="student" class="form-label">Option 1</label>
                  <input type="text" class="form-control" placeholder="option 1" id="opt1" name="opt1">
                </div>
                <div class="mb-3">
                  <label for="student" class="form-label">Option 2</label>
                  <input type="text" class="form-control" placeholder="option 2" id="opt2" name="opt2">
                </div>
                <div class="mb-3">
                  <label for="student" class="form-label">Option 3 (optional)</label>
                  <input type="text" class="form-control" placeholder="option 3" id="opt3" name="opt3">
                </div>
                <div class="mb-3">
                  <label for="student" class="form-label">Option 4 (optional)</label>
                  <input type="text" class="form-control" placeholder="option 4" id="opt4" name="opt4">
                </div>
                <div class="mb-3">
                  <label for="student" class="form-label">Option 5 (optional)</label>
                  <input type="text" class="form-control" placeholder="option 5" id="opt5" name="opt5">
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
                <!-- Hidden Inputs -->
                <input type="hidden" name="course" id="course" value="<?php echo $row['course_id']; ?>">
                <input type="hidden" name="topic" id="topic" value="<?php echo $row['topic_id']; ?>">
                <input type="hidden" name="quiz" id="quiz" value="<?php echo $id; ?>">
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
      <!-- =========================== MODAL 2 ============================ -->
      <div class="modal fade" id="myModal2">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Import Questions</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="max-height: 500px; overflow:auto;">
              <form method="POST" action="../includes/quiz.inc.php" id="checkForm">
                <div class="table-data shadow-sm">
                  <table width="100%" class="table table-hover table-borderless">
                    <div class="alert alert-primary">
                      <strong>Importing Question From Question Bank</strong>
                    </div>
                    <div class="mb-3">
                          <label for="student" class="form-label">Select Folder</label>
                          <select class="form-select" name="folder" id="folder">
                          </select>
                        </div>
                    <thead>
                      <tr>
                        <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                        <td>#</td>
                        <td>Question</td>
                        <td>Course</td>
                        <td>Topic</td>
                        <td>Type</td>
                      </tr>
                    </thead>
                    <tbody id="tbody"></tbody>
                  </table>
                </div>
                <!-- Hidden Inputs -->
                <input type="hidden" name="c-topic" id="c-topic" value="<?php echo $topic_id; ?>">
                <input type="hidden" name="c-quiz" id="c-quiz" value="<?php echo $id; ?>">
                <div class="d-grid shadow-sm">
                  <button type="submit" class="btn btn-primary" name="checkboxBtn">Import Questions</button>
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
                <strong><?php echo $topic_name . " - " . $quiz_name; ?> Quiz Attempts</strong>
              </div>
              <thead>
                <tr>
                  <td>#</td>
                  <td>Student ID</td>
                  <td>First Name</td>
                  <td>Last Name</td>
                  <td>No. Of Attempts</td>
                  <td>Score</td>
                  <td>Date Started</td>
                  <td>Date Submitted</td>
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
        getFolders(getQuestionsbyFolder);
        attemptNum();
        averageScore();
        percentagePass();
      });
      var table = $('#teacher-table').DataTable({
        ajax: "../text/attempts.txt"
      });
      $("#folder").on("change",() => getQuestionsbyFolder());

    //============================ DISPLAY TABLE ======================================
    function displayTable() {
      var show = true;
      var quizId = $("#quiz").val();
      $.post("../includes/quiz.inc.php", {
        show: show,
        quizId:quizId
      }, function(data, status) {
        table.ajax.reload();
      });
    }
      // ====================== ADD QUESTION ======================
      $("#add-question").on("submit",function(e) {
          e.preventDefault();
          $.ajax({
            url: "../includes/quiz.inc.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data,status) {
              if (data == "Added Successfully") {
                $("#question").val("");
                $("#image").val("");
                $("#opt1").val("");
                $("#opt2").val("");
                $("#opt3").val("");
                $("#opt4").val("");
                $("#opt5").val("");
                $("#answer").val(-1);
                $("#myModal1").modal("hide");
              }
              toast(data);
            }
          });
      });
    //============================ GET FOLDERS ======================================
    function getFolders(callback) {
      var fetchFolders = true;
      $.post("../includes/folders.inc.php", {
        fetchFolders: fetchFolders
      }, function(data, status) {
        var results = JSON.parse(data);
        var x = '<option value="0">default</option>';
        results.forEach(result => {
          x += `<option value="${Number(result.id)}">${result.folder_name}</option>`;
        });
        $("#folder").html(x);
        getQuestionsbyFolder();
      });
    }
    //============================ GET FOLDERS ======================================
    function getQuestionsbyFolder() {
      var getQuestions = true;
      var folder = $("#folder").val();
      $.post("../includes/quiz.inc.php",{
        getQuestions:getQuestions,
        folder:folder
      }, function(data,status) {
        if (data === "null") {
          $("#tbody").text("No question For this Folder");
        } else {
          var result = JSON.parse(data);
          // console.log(result);
          var x = "";
          for (let i = 0; i < result.length; i++) {
            x += `<tr>
                          <td><input type="checkbox" name="questions[]" value="${result[i][5]}" class="checkAll"></td>
                          <td>${result[i][0]}</td>
                          <td>${result[i][1]}</td>
                          <td>${result[i][2]}</td>
                          <td>${result[i][3]}</td>
                          <td>${result[i][4]}</td>
                        </tr>
                        <tr>`;
            
          }
          $("#tbody").html(x);
        }
      })
    }

    $("#checkAll").click(function() {
      if ($(this).is(":checked")) {
        $(".checkAll").prop("checked",true);
      } else {
        $(".checkAll").prop("checked",false);
      }
    })
    // Submit Import Question
    $("#checkForm").on("submit", function(e) {
      e.preventDefault();
      $.ajax({
        url:"../includes/quiz.inc.php",
        method: "post",
        data: new FormData(this),
        catch: false,
        processData: false,
        contentType: false,
        success: function(data,status) {
          if (data = "Imported Successfully") {
            $("#myModal2").modal("hide");
            getQuestionsbyFolder();
            $("#checkAll").prop("checked",false);
            toast(data);
          }
        }
      })
    })
    //============================= DELETE ATTEMPT =========================
    function deleteAttempt(id) {
      var remove = true;
      var idArr = id.toString().split(".");
      var quizId = Number(idArr[0]);
      var user = Number(idArr[1]);
      $.post("../includes/quiz.inc.php", {
        quizId: quizId,
        user: user,
        remove: remove
      }, function(data, status) {
        displayTable();
        toast(data);
        attemptNum();
        averageScore();
        percentagePass();
      });
    }
    //============================= CARDS DISPLAYS =========================
    function attemptNum() {
      var attemptNum = true;
      var quizId = $("#quiz").val();
      $.post("../includes/quiz.inc.php", {
        attemptNum: attemptNum,
        quizId:quizId
      }, function(data, status) {
        $("#attempt-num").html(data);
      });
    }
    function averageScore() {
      var averageScore = true;
      var quizId = $("#quiz").val();
      $.post("../includes/quiz.inc.php", {
        averageScore: averageScore,
        quizId:quizId
      }, function(data, status) {
        $("#average-num").html(data);
      });
    }
    function percentagePass() {
      var percentagePass = true;
      var quizId = $("#quiz").val();
      $.post("../includes/quiz.inc.php", {
        percentagePass: percentagePass,
        quizId:quizId
      }, function(data, status) {
        $("#percent-num").html(data + "%");
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
  header("Location: ./quizes.php");
  exit();
}
} else {
  header("Location: ./login.php");
}
?>
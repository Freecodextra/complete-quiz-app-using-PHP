<?php
session_start();
if (isset($_SESSION['admin'])) {
  require("../includes/db.inc.php");
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
        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#myModal">
          Add New Category
        </button>
      </div>
      <!-- =================== MODAL============================== -->
      <div class="modal fade" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Add Category</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <div class="mb-3">
                <label for="student" class="form-label">Add Category</label>
                <input type="text" class="form-control" name="cat" id="cat" placeholder="e.g Mathematics">
              </div>
              <div class="d-grid shadow-sm">
                <button name="submit" class="btn btn-primary" id="category-btn" onclick="addCat()">Add Category</button>
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
      <div class="modal fade" id="update">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Update Category</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <div class="mb-3">
                <label for="student" class="form-label">Update Category</label>
                <input type="text" class="form-control" name="cat" id="update-cat" placeholder="e.g Mathematics">
              </div>
              <!-- Hidden input -->
              <input type="hidden" name="hidden" id="hidden">
              <div class="d-grid shadow-sm">
                <button name="submit" class="btn btn-primary" id="u-category-btn" onclick="update()">Update Category</button>
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
                <strong>COURSE CATEGORIES</strong>
              </div>
              <thead>
                <tr>
                  <td>#</td>
                  <td>Category ID</td>
                  <td>Name</td>
                  <td>No. Of Courses</td>
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
        categoryNum();
        courseNum();
        topicNum();
      });
      var table = $('#teacher-table').DataTable({
        ajax: "../text/category.txt",
      });
      // ========================= ADD CATEGORY =====================
      function addCat() {
        $("#category-btn").html("<span class='spinner-border'></span>");
        $("#category-btn").attr("disabled", true);
        var cat = $("#cat").val();
        $.post("../includes/category.inc.php", {
          cat: cat
        }, function(data, status) {
          console.log(data);
          if (data == "Added Successfully") {
            $("#myModal").modal("hide");
            $("#cat").val("");
            displayTable();
            categoryNum();
          }
          toast(data);
          $("#category-btn").html("Add Category");
          $("#category-btn").attr("disabled", false);
        });
      }

      //================================== UPDATE CATEGORY ==============================
      function updateCat(id) {
        var edit = true;
        $.post("../includes/category.inc.php", {
          id: id,
          edit: edit
        }, function(data, status) {
          var result = JSON.parse(data);
          $("#update-cat").val(result.cat_name);
          $("#hidden").val(Number(result.id));
          $("#update").modal("show");
        });
      }

      function update() {
        $("#u-category-btn").html("<span class='spinner-border'></span>");
        $("#u-category-btn").attr("disabled", true);
        var update = true;
        var updateID = $("#hidden").val();
        var updateName = $("#update-cat").val();
        $.post("../includes/category.inc.php", {
          id: updateID,
          update: update,
          updateName: updateName
        }, function(data, status) {
          $("#update").modal("hide");
          displayTable();
          $("#update-cat").val("");
          $("#hidden").val("");
          toast(data);
          $("#u-category-btn").html("Update Category");
          $("#u-category-btn").attr("disabled", false);
        });
      }
      //============================= DELETE CATEGORY =========================
      function deleteCat(id) {
        var remove = true;
        $.post("../includes/category.inc.php", {
          id: id,
          remove: remove
        }, function(data, status) {
          displayTable();
          categoryNum();
          toast(data);
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
      //============================ DISPLAY CATEGORY ======================================
      function displayTable() {
        var display = true;
        $.post("../includes/category.inc.php", {
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
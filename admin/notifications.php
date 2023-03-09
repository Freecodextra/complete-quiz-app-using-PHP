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
      <div class="add-student pt-5">
        <button class="btn" data-bs-toggle="modal" data-bs-target="#myModal">Add New Notification</button>
      </div>
      <!-- =================== MODAL 2============================== -->
      <div class="modal fade" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Add Notifications</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <div class="mb-3">
                <label for="head" class="form-label">Notification Head</label>
                <input type="text" class="form-control" placeholder="Heading" id="head">
              </div>
              <div class="mb-3">
                <label for="body" class="form-label">Notification Body</label>
                <textarea name="body" id="body" cols="30" rows="5" class="form-control" placeholder="write here..."></textarea>
              </div>
              <div class="d-grid shadow-sm">
                <button type="submit" class="btn btn-primary" id="notify-btn" onclick="addNotification()">Add Notification</button>
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
      <div class="modal fade" id="myModal1">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Edit Notifications</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <div class="mb-3">
                <label for="e-head" class="form-label">Notification Head</label>
                <input type="text" class="form-control" placeholder="Heading" id="e-head">
              </div>
              <div class="mb-3">
                <label for="e-body" class="form-label">Notification Body</label>
                <textarea name="e-body" id="e-body" cols="30" rows="5" class="form-control" placeholder="write here..."></textarea>
              </div>
              <!-- hidden -->
              <input type="hidden" name="hidden" id="hidden">
              <div class="d-grid shadow-sm">
                <button type="submit" class="btn btn-primary" id="u-notify-btn" onclick="updateNotification()">Update Notification</button>
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
              <strong>NOTIFICATIONS</strong>
            </div>
            <table width="100%" class="table table-hover table-borderless" id="teacher-table">
              <thead>
                <tr>
                  <td>#</td>
                  <td>Notification Head</td>
                  <td>Notification Body</td>
                  <td>Date/Time</td>
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
      });
      var table = $('#teacher-table').DataTable({
        ajax: "../text/notifications.txt"
      })
      // add notification
      function addNotification() {
        $("#notify-btn").html("<span class='spinner-border'></span>");
        $("#notify-btn").attr("disabled", true);
        var add = true;
        var head = $("#head").val();
        var body = $("#body").val();
        $.post("../includes/notifications.inc.php", {
          add: add,
          head: head,
          body: body
        }, function(data, status) {
          if (data == "Added Successfully") {
            $("#head").val("");
            $("#body").val("");
            $("#myModal").modal("hide");
            displayTable();
          }
          toast(data);
          $("#notify-btn").html("Add Notification");
          $("#notify-btn").attr("disabled", false);
        })
      }
      // edit notification
      function editNotification(id) {
        var edit = true;
        $.post("../includes/notifications.inc.php", {
          edit: edit,
          id: id
        }, function(data, status) {
          var result = JSON.parse(data);
          $("#e-head").val(result.head);
          $("#e-body").val(result.body);
          $("#hidden").val(Number(result.id));
          $("#myModal1").modal("show");
        })
      }

      function updateNotification() {
        $("#u-notify-btn").html("<span class='spinner-border'></span>");
        $("#u-notify-btn").attr("disabled", true);
        var update = true;
        var head = $("#e-head").val();
        var body = $("#e-body").val();
        var id = $("#hidden").val();
        $.post("../includes/notifications.inc.php", {
          update: update,
          head: head,
          body: body,
          id: id
        }, function(data, status) {
          if (data == "Updated Successfully") {
            $("#e-head").val("");
            $("#e-body").val("");
            $("#hidden").val(0);
            $("#myModal1").modal("hide");
            displayTable();
          }
          toast(data);
          $("#u-notify-btn").html("Update Notification");
          $("#u-notify-btn").attr("disabled", false);
        })
      }

      function deleteNotification(id) {
        var remove = true;
        $.post("../includes/notifications.inc.php", {
          remove: remove,
          id: id
        }, function(data, status) {
          displayTable();
          toast(data);
        })
      }
      //============================ DISPLAY TABLE ======================================
      function displayTable() {
        var show = true;
        $.post("../includes/notifications.inc.php", {
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
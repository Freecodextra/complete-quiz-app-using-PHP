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
  <link rel="stylesheet" href="../public/style.css">
  <link rel="shortcut icon" href="<?php echo logoSrc() ?>" type="image/x-icon">
  <title>Admin - Quiz App</title>
</head>
<body>
    <?php 
    require("./header.php"); 
    require("./navbar.php");
    ?>
    <!-- ======================== MAIN CONTENT ===================== -->
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
        <div class="course-overview">
        <div class="row shadow-sm">
            <div class="head">
              <div class="head-name">
                <p>Course Overview</p>
              </div>
              <div class="head-input">
                <select name="course" id="course">
                  </select>
              </div>
            </div>
            <div class="body">
              <div class="row">
                <div class="col-sm-3 first">
                  <div class="icon">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="text">
                    <p>Number of students</p>
                    <p id="student"></p>
                  </div>
                </div>
                <div class="col-sm-3 second">
                  <div class="icon">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="text">
                    <p>Number of topics</p>
                    <p id="topic"></p>
                  </div>
                </div>
                <div class="col-sm-3 third">
                  <div class="icon">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="text">
                    <p>Number of quizes</p>
                    <p id="quiz"></p>
                  </div>
                </div>
                <div class="col-sm-3 fourth">
                  <div class="icon">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="text">
                    <p>Number of questions</p>
                    <p id="question"></p>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
        <div class="mainboard">
          <div class="row">
            <div class="col-md-6">
              <div class="mainboard-head">
                <h5>Monthly Statistics</h5>
              </div>
              <div class="mainboard-body center">
                <!-- <div class="one">
                  <div class="img">
                    <img src="../images/course.png" alt="">
                  </div>
                  <div class="text">
                    <h6>CHEM 101 - Introduction to inorganic chemistry</h6>
                    <p>100 level</p>
                  </div>
                </div> -->
                <div id="myChart1" style="min-width:450px; height:400px;"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mainboard-head">
                <h5>Total Number Of Students</h5>
              </div>
              <div class="mainboard-body center">
                <div id="myChart2" style="min-width:450px; height:400px;"></div>
              </div>
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
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
      $(document).ready(function() {
        getCourses();
        getOverview();
        studentNum();
        courseNum();
        teacherNum();
      });
      // ====================PIE CHART===========================
      $.post("../includes/charts.php", {gender: true}, function(data) {
        const result = JSON.parse(data);
      google.charts.load('current',{packages:['corechart']});
      google.charts.setOnLoadCallback(drawChart1);
      function drawChart1() {
var data = google.visualization.arrayToDataTable([
  ['Students', 'Number'],
  ['Male',result[0]],
  ['Female',result[1]],
  ['Others',result[2]]
]);

var options = {
  title:'Total Number Of Students',
  is3D:true
};

var chart = new google.visualization.PieChart(document.getElementById('myChart2'));
  chart.draw(data, options);
}
})
 // ====================LINE CHART===========================
 $.post("../includes/charts.php", {days: true}, function(data) {
  const result = JSON.parse(data);
 google.charts.load('current',{packages:['corechart']});
 google.charts.setOnLoadCallback(drawChart2);
 function drawChart2() {
// Set Data
var data = google.visualization.arrayToDataTable([
  ['Days', 'Number'],
  ['Sun',result.sun],
  ['Mon',result.mon],
  ['Tue',result.tue],
  ['Wed',result.wed],
  ['Thur',result.thur],
  ['Fri',result.fri],
  ['Sat',result.sat]
  ]);
// Set Options
var options = {
  title: 'Monthly Login Users',
  hAxis: {title: 'Days Of The Week'},
  vAxis: {title: 'Square Meters'},
  legend: 'none',
  colors: ['#0e3eda']
};
// Draw Chart
var chart = new google.visualization.LineChart(document.getElementById('myChart1'));
chart.draw(data, options);
}
})
    // ========================= GET ALL COURSES =====================
    function getCourses() {
      var fetchCourse = true;
      $.post("../includes/courses.inc.php", {
        fetchCourse: fetchCourse
      }, function(data, status) {
        var results = JSON.parse(data);
        var x = '<option value="0">Select Course</option>';
        results.forEach(result => {
          x += `<option value="${Number(result.id)}">${result.course_short_name}</option>`;
        });
        $("#course").html(x);
      });
    }
    $("#course").on("change", function() {
      getOverview();
    });

// ============= get overview
    function getOverview() {
      const courseId = $("#course").val();
      $.post("../includes/charts.php", {overview: true, courseId: courseId}, function(data) {
        const result = JSON.parse(data);
        $("#student").html(result[0]);
        $("#topic").html(result[1]);
        $("#quiz").html(result[2]);
        $("#question").html(result[3]);
      })
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
    </script>
</body>
</html>
<?php
 } else {
  header("Location: ./login.php");
 }
?>
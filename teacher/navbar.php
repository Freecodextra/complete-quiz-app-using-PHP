    <?php
      if(isset($_SESSION['teacher'])) {
        require "../includes/db.inc.php";
        $teacher_id = $_SESSION['teacher'];
        $sql = "SELECT * FROM teachers WHERE id='$teacher_id';";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          $fName = $row['fName'];
          $lName = $row['lName'];
          $username = $row['username'];
        }
      }
    ?>
    <!-- ===================== SIDE NAVIGATION ======================== -->
    <nav class="shadow-sm nav-collapse">
      <div class="nav-logo center">
        <div class="logo center"><img src="<?php echo logoSrc(); ?>" alt="Logo"></div>
      </div>
      <hr>
      <div class="nav-header">
        <div class="nav-text">
          <h5><strong><?php if (isset($_SESSION['teacher'])) {
                echo $fName." ".$lName;
              } else {echo "Anonymous User";} ?></strong></h5>
          <h6>Teacher</h6>
        </div>
      </div>
      <div class="nav-body">
        <div class="links">
          <ul>
            <a href="./index.php?teacher=<?php if(isset($_SESSION['teacher'])) {echo $teacher_id;} ?>">
              <li>
                <div class="link">
                  <div class="icon">
                    <i class="bi bi-columns-gap"></i>
                  </div>
                  <p>Dashboard</p>
            </div>
          </li>
          </a>
        <a href="javascript:void(0)">
          <li>
            <div class="link drop-btn course">
              <div class="icon">
                <i class="bi bi-mortarboard"></i>
              </div>
              <p>Courses</p>
              <span><i class="bi bi-chevron-down"></i></span>
        </div>
      </li>
      </a>
          <div class="drop-down course">
            <ul>
              <?php
                if (isset($_SESSION['teacher'])) {
                  $id = $_SESSION['teacher'];
                  require "../includes/db.inc.php";
                  $sql = "SELECT * FROM teachers_enrollment WHERE teacher_id = '$id';";
                  $result = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      $course_id = $row['course_id'];
                      $sql1 = "SELECT * FROM courses WHERE id = '$course_id';";
                      $result1 = mysqli_query($conn, $sql1);
                      while ($row1 = mysqli_fetch_assoc($result1)) {
                        $course_short_name = $row1['course_short_name'];
                        $course_idd = $row1['id'];
                        echo '<a href="./course.php?course='.$course_idd.'&teacher='.$teacher_id.'">
                        <li>
                          <div class="link">
                            <div class="icon">
                              <i class="bi bi-mortarboard"></i>
                            </div>
                            <p>'.$course_short_name.'</p>
                      </div>
                    </li>
                    </a>';

                      }
                    }
                  }
                }
              ?>
            </ul>
          </div>
          <a href="./class.php?teacher=<?php if(isset($_SESSION['teacher'])) {echo $teacher_id;} ?>">
                    <li>
                      <div class="link">
                        <div class="icon">
                          <i class="bi bi-book"></i>
                        </div>
                        <p>Class</p>
                  </div>
                </li>
                </a>
          <a href="./quizes.php?teacher=<?php if(isset($_SESSION['teacher'])) {echo $teacher_id;} ?>">
                    <li>
                      <div class="link">
                        <div class="icon">
                          <i class="bi bi-journal"></i>
                        </div>
                        <p>Quizes</p>
                  </div>
                </li>
                </a>
                <a href="./questions.php?teacher=<?php if(isset($_SESSION['teacher'])) {echo $teacher_id;} ?>">
                    <li>
                      <div class="link">
                        <div class="icon">
                          <i class="bi bi-journal"></i>
                        </div>
                        <p>Questions</p>
                  </div>
                </li>
                </a>
          <a href="./settings.php?teacher=<?php if(isset($_SESSION['teacher'])) {echo $teacher_id;} ?>">
            <li>
              <div class="link">
                <div class="icon">
                  <i class="bi bi-gear"></i>
                </div>
                <p>Settings</p>
          </div>
        </li>
        </a>
        <?php if (isset($_SESSION['teacher'])) { ?>
          <a href="../includes/logout.inc.php">
            <li>
              <div class="link">
                <div class="icon">
                  <i class="bi bi-box-arrow-right"></i>
                </div>
                <p>Logout</p>
          </div>
        </li>
        </a>
        <?php } else { ?>
          <a href="./login.php">
            <li>
              <div class="link">
                <div class="icon">
                  <i class="bi bi-box-arrow-in-right"></i>
                </div>
                <p>Login</p>
          </div>
        </li>
        </a>
       <?php } ?>
          </ul>
        </div>
      </div>
    </nav>
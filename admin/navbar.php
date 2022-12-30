    <?php
    require "../includes/db.inc.php";
    $sql = "SELECT * FROM `admin`;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    ?>
    <!-- ===================== SIDE NAVIGATION ======================== -->
    <nav class="shadow-sm nav-collapse">
      <div class="nav-logo center">
        <div class="logo center"><img src="<?php echo logoSrc(); ?>" alt="Logo"></div>
      </div>
      <hr>
      <div class="nav-header">
        <div class="nav-text">
          <h5><strong><?php echo $row['fName'] . " " . $row['lName']; ?></strong></h5>
          <h6>Admin</h6>
        </div>
      </div>
      <div class="nav-body">
        <div class="links">
          <ul>
            <a href="./index.php">
              <li>
                <div class="link">
                  <div class="icon">
                    <i class="bi bi-columns-gap"></i>
                  </div>
                  <p>Dashboard</p>
            </div>
          </li>
          </a>
          <a href="./students.php">
                    <li>
                      <div class="link">
                        <div class="icon">
                          <i class="bi bi-people"></i>
                        </div>
                        <p>Students</p>
                  </div>
                </li>
                </a>
          <a href="./teachers.php">
                    <li>
                      <div class="link">
                        <div class="icon">
                          <i class="bi bi-people"></i>
                        </div>
                        <p>Teachers</p>
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
                  <a href="./courses.php">
                    <li>
                      <div class="link">
                        <div class="icon">
                          <i class="bi bi-mortarboard"></i>
                        </div>
                        <p>View Courses</p>
                  </div>
                </li>
                </a>
                <a href="./topics.php">
                    <li>
                      <div class="link">
                        <div class="icon">
                          <i class="bi bi-book"></i>
                        </div>
                        <p>View Topics</p>
                  </div>
                </li>
                </a>
              <a href="./course-categories.php">
                <li>
                  <div class="link">
                    <div class="icon">
                      <i class="bi bi-mortarboard"></i>
                    </div>
                    <p>Course Categories</p>
              </div>
            </li>
            </a>
                </ul>
              </div>
              <a href="./classes.php">
                    <li>
                      <div class="link">
                        <div class="icon">
                          <i class="bi bi-book"></i>
                        </div>
                        <p>Classes</p>
                  </div>
                </li>
                </a>
            </a>
            </a>
            <a href="./quizes.php">
                    <li>
                      <div class="link">
                        <div class="icon">
                          <i class="bi bi-journal"></i>
                        </div>
                        <p>Quizes</p>
                  </div>
                </li>
                </a>
                <a href="./questions.php">
                    <li>
                      <div class="link">
                        <div class="icon">
                          <i class="bi bi-journal"></i>
                        </div>
                        <p>Questions</p>
                  </div>
                </li>
                </a>
                  <a href="./notifications.php">
                    <li>
                      <div class="link">
                        <div class="icon">
                          <i class="bi bi-bell"></i>
                        </div>
                        <p>Notifications</p>
                  </div>
                </li>
                </a>
          <a href="./settings.php">
            <li>
              <div class="link">
                <div class="icon">
                  <i class="bi bi-gear"></i>
                </div>
                <p>Settings</p>
          </div>
        </li>
        </a>
          <a href="../includes/admin-logout.inc.php">
            <li>
              <div class="link">
                <div class="icon">
                  <i class="bi bi-box-arrow-right"></i>
                </div>
                <p>Logout</p>
          </div>
        </li>
        </a>
          </ul>
        </div>
      </div>
    </nav>
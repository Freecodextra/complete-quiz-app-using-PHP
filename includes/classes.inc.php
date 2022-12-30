<?php
    require("./db.inc.php");
    function classID() {
        $x = range(0,9);
       $y = "";
       for ($i=0; $i < 4; $i++) { 
        $shuffle = shuffle($x);
        $rand_x = $x[array_rand($x)];
        $y.= $rand_x;
       }
     return $y;
    }
    
if (isset($_POST['clas'])) {
    $class_name = trim($_POST['clas']);
    if (empty($class_name)) {
     echo "Empty Input";
    } else {
     $sql = "SELECT * FROM classes WHERE class_name = '$class_name';";
     $result = mysqli_query($conn, $sql);
     $resultChecker = mysqli_num_rows($result);
     if ($resultChecker > 0) {
         echo "Category Exist";
     } else {
         $sql = "INSERT INTO classes (class_id, class_name, date_created) VALUES (?,?,?)";
     $stmt = mysqli_stmt_init($conn);
     if (!mysqli_stmt_prepare($stmt, $sql)) {
         echo "Sql Error";
     } else {
         $class_id = classID();
         $date = getdate()[0];
         mysqli_stmt_bind_param($stmt, "ssd",$class_id, $class_name, $date);
         mysqli_stmt_execute($stmt);
         echo "Added Successfully";
     }
     }
     
    }
    
 } elseif (isset($_POST['remove'])) {
     $id = $_POST['id'];
     $sql = "DELETE FROM classes WHERE id = '$id';";
     $c_sql = "UPDATE courses SET `level` = 0 WHERE `level` = $id;";
     $u_sql = "UPDATE users SET `level` = 0 WHERE `level` = $id;";
     if (mysqli_query($conn, $sql) && mysqli_query($conn, $c_sql) && mysqli_query($conn, $u_sql)) {
         echo "Deleted Successfully!";
     }
 
 } elseif (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM classes WHERE id = '$id';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
     while ($row = mysqli_fetch_assoc($result)) {
         echo json_encode($row);
     }
    }
    
 } elseif (isset($_POST['update'])) {
     $id = $_POST['id'];
     $name = $_POST['updateName'];
     $sql ="UPDATE classes SET class_name = '$name' WHERE id = '$id';";
     mysqli_query($conn, $sql);
     echo "Updated Successfully";
 } elseif (isset($_POST['display'])) {
     $sql = "SELECT * FROM classes";
     $result = mysqli_query($conn, $sql);
     $resultChecker = mysqli_num_rows($result);
     if ($resultChecker > 0) {
         $x = 0;
         $data = array();
         while ($row = mysqli_fetch_assoc($result)) {
        $date = date("Y-m-d H:i:s",$row['date_created']);
                 $array = array();
            $class_id = $row['id'];
             $array[] = ++$x;
             $array[] = $row['class_id'];
             $array[] = $row['class_name'];
             $teacher_id = $row['teacher'];
            $teacher;
            if ($teacher_id > 0) {
                $t_sql = "SELECT * FROM teachers WHERE id = $teacher_id;";
                $t_result = mysqli_query($conn, $t_sql);
                $t_row = mysqli_fetch_assoc($t_result);
                $teacher = $t_row['fName'] . " " . $t_row['lName'];
             }
             $array[] = $teacher_id == 0 ? "None" : $teacher;
             // Get Number of Students in each class
             $get_std = "SELECT * FROM users WHERE level = $class_id;";
             $std_result = mysqli_query($conn,$get_std);
             $array[] = mysqli_num_rows($std_result);
             $array[] = $date;
             $array[] = '<td>•••<div class="links shadow-sm">
             <button class="edit" type="submit" name="edit" value="'.$row['id'].'" onclick="updateClass('.$row['id'].')">Edit Class</button>
             <button class="unassign" name="unassign" value="' . $row['id'] . '" onclick="unassignTeacher(' . $row['id'] . ')">Unassign Teacher</button>
             <button type="submit" name="delete" value="'.$row['id'].'" onclick="deleteClass('.$row['id'].')">Delete Class</button>
           </div></td>';
             array_push($data, $array);
         }
         file_put_contents("../text/classes.txt", '{"data":'.json_encode($data).'}');
         } else {
            file_put_contents("../text/classes.txt", '{"data":[[null,null,null,null,null,null,null]]}');
        }
 } elseif (isset($_POST['fetchClass'])) {
    $sql = "SELECT * FROM classes";
     $result = mysqli_query($conn, $sql);
     $resultChecker = mysqli_num_rows($result);
     if ($resultChecker > 0) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode($data);
     }
 } elseif (isset($_POST['assign'])) {
    $teacher_mail = $_POST['teacher'];
    $class_id = $_POST['classId'];
    if (empty($teacher_mail) || $class_id == -1) {
        echo "Empty Field(s)";
    } else {
        $sql = "SELECT * FROM teachers WHERE email = '$teacher_mail'";
        $result = mysqli_query($conn,$sql);
        if (mysqli_num_rows($result) <= 0) {
            echo "Teacher Not-Found";
        } else {
            $row = mysqli_fetch_assoc($result);
            $teacher_id = $row['id'];
            $c_sql = "UPDATE classes SET teacher = 0 WHERE teacher = $teacher_id";
            if (mysqli_query($conn,$c_sql)) {
                $sql = "UPDATE classes SET teacher = $teacher_id WHERE id = $class_id;";
                mysqli_query($conn,$sql);
                echo "Assigned Successfully";
            }
        }
    }
    
 } elseif (isset($_POST['unassign'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM classes WHERE id = $id;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row['teacher'] == 0) {
        echo "No teacher assigned";
    } else {
        $sql = "UPDATE classes SET teacher = 0 WHERE id = $id;";
        if (mysqli_query($conn, $sql)) {
            echo "Unassigned Successfully";
        }
    }
}
<?php
    require("./db.inc.php");
    function courseID() {
        $x = range(0,9);
       $y = "";
       for ($i=0; $i < 3; $i++) { 
        $shuffle = shuffle($x);
        $rand_x = $x[array_rand($x)];
        $y.= $rand_x;
       }
     return $y;
    }

if (isset($_POST['cat'])) {
   $cat_name = trim($_POST['cat']);
   if (empty($cat_name)) {
    echo "Empty Input";
   } else {
    $sql = "SELECT * FROM course_category WHERE cat_name = '$cat_name';";
    $result = mysqli_query($conn, $sql);
    $resultChecker = mysqli_num_rows($result);
    if ($resultChecker > 0) {
        echo "Category Exist";
    } else {
        $sql = "INSERT INTO course_category (cat_id, cat_name, date_created) VALUES (?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Sql Error";
    } else {
        $course_id = courseID();
        $date = getdate()[0];
        mysqli_stmt_bind_param($stmt, "ssd",$course_id, $cat_name, $date);
        mysqli_stmt_execute($stmt);
        echo "Added Successfully";
    }
    }
    
   }
   
} elseif (isset($_POST['remove'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM course_category WHERE id = '$id';";
    $c_sql = "UPDATE courses SET course_category_id = 0 WHERE course_category_id = $id;";
    if (mysqli_query($conn, $sql) && mysqli_query($conn,$c_sql)) {
        echo "Deleted Successfully!";
    }

} elseif (isset($_POST['edit'])) {
   $id = $_POST['id'];
   $sql = "SELECT * FROM course_category WHERE id = '$id';";
   $result = mysqli_query($conn, $sql);
   if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    }
   }
   
} elseif (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['updateName'];
    $sql ="UPDATE course_category SET cat_name = '$name' WHERE id = '$id';";
    mysqli_query($conn, $sql);
    echo "Updated Successfully";
} elseif (isset($_POST['display'])) {
    $sql = "SELECT * FROM course_category";
    $result = mysqli_query($conn, $sql);
    $resultChecker = mysqli_num_rows($result);
    if ($resultChecker > 0) {
        $x = 0;
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
       $date = date("Y-m-d H:i:s",$row['date_created']);
                $array = array();
            $array[] = ++$x;
            $array[] = $row['cat_id'];
            $array[] = $row['cat_name'];
            $category_id = $row['id'];
            $c_sql = "SELECT * FROM courses WHERE course_category_id = $category_id;";
            $c_result = mysqli_query($conn,$c_sql);
            $array[] = mysqli_num_rows($c_result);
            $array[] = $date;
            $array[] = '<td>•••<div class="links shadow-sm">
            <button class="edit" type="submit" name="edit" value="'.$row['id'].'" onclick="updateCat('.$row['id'].')">Rename Category</button>
            <button type="submit" name="delete" value="'.$row['id'].'" onclick="deleteCat('.$row['id'].')">Delete Category</button>
          </div></td>';
            array_push($data, $array);
        }
        file_put_contents("../text/category.txt", '{"data":'.json_encode($data).'}');
        } else {
            file_put_contents("../text/category.txt", '{"data":[[null,null,null,null,null,null]]}');
        }
} elseif (isset($_POST['fetchCat'])) {
    $sql = "SELECT * FROM course_category";
     $result = mysqli_query($conn, $sql);
     $resultChecker = mysqli_num_rows($result);
     if ($resultChecker > 0) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode($data);
     }
 }

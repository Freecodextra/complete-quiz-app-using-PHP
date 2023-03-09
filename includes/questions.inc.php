<?php
require "./db.inc.php";
$folder;
if (isset($_POST['question'])) {
    if (isset($_POST['newfolder'])) {
        $newfolder = trim($_POST['newfolder']);
        $sql = "INSERT INTO question_folders (folder_name) VALUES ('$newfolder');";
        $result = mysqli_query($conn, $sql);
        $folder = mysqli_insert_id($conn);
    } else {
        $folder = $_POST['folder'];
    }
    $course = $_POST['course'];
    $question = str_replace("'", "''", trim($_POST['question']));
    $opt1 = trim($_POST['opt1']);
    $opt2 = trim($_POST['opt2']);
    $opt3 = trim($_POST['opt3']);
    $opt4 = trim($_POST['opt4']);
    $opt5 = trim($_POST['opt5']);
    $answer = $_POST['answer'];
    $image = $_FILES['image'];
    if (empty($question) || empty($opt1) || empty($opt2) || $answer == -1 || $folder == -1) {
        echo "Empty Field(s)!";
    } else {
        if ($image['name'] === "") {
            $sql = "INSERT INTO questions (course_id, question,folder) VALUES ($course, '$question', $folder);";
            if (mysqli_query($conn, $sql)) {
                $question_id = mysqli_insert_id($conn);
                $options = array($opt1, $opt2, $opt3, $opt4, $opt5);
                foreach ($options as $option => $value) {
                    if ($value != "") {
                        $value = str_replace("'", "''", $value);
                        if ($option == $answer) {
                            $osql = "INSERT INTO options (question_id, `option`, answer) VALUES ($question_id, '$value', 1);";
                        } else {
                            $osql = "INSERT INTO options (question_id, `option`) VALUES ($question_id, '$value');";
                        }
                        mysqli_query($conn, $osql);
                    }
                }
            }
            echo "Added Successfully";
        } else {
            // Query Data Base
            $sql = "INSERT INTO questions (course_id, question) VALUES ($course,'$question');";
            if (mysqli_query($conn, $sql)) {
                $question_id = mysqli_insert_id($conn);
                $options = array($opt1, $opt2, $opt3, $opt4, $opt5);
                foreach ($options as $option => $value) {
                    if ($value != "") {
                        $value = str_replace("'", "''", $value);
                        if ($option == $answer) {
                            $osql = "INSERT INTO options (question_id, `option`, answer) VALUES ($question_id, '$value', 1);";
                        } else {
                            $osql = "INSERT INTO options (question_id, `option`) VALUES ($question_id, '$value');";
                        }
                        mysqli_query($conn, $osql);
                    }
                }
            }
            // save Image
            $img_name = $image['name'];
            $img_error = $image['error'];
            $img_tmp_name = $image['tmp_name'];
            $img_type = $image['type'];
            $img_size = $image['size'];
            $img_array = explode(".", $img_name);
            $img_ext = strtolower(end($img_array));
            $accept = array("jpg", "jpeg", "png", "pdf", "gif");
            if (in_array($img_ext, $accept)) {
                if ($img_error === 0) {
                    if ($img_size < 10000000) {
                        $img_des = "../question-img/";
                        $img_new_name = "question" . $question_id . "." . $img_ext;
                        $img_new_des = $img_des . $img_new_name;
                        move_uploaded_file($img_tmp_name, $img_new_des);
                        $img_sql = "UPDATE questions SET `image` = 1 WHERE id = '$question_id';";
                        mysqli_query($conn, $img_sql);
                        echo "Added Successfully";
                    } else {
                        echo "Image Size Too Big";
                    }
                } else {
                    echo "Error while uploading Image";
                }
            } else {
                echo "Invalid File Type";
            }
        }
    }
} elseif (isset($_POST['display'])) {
    $sql = "SELECT * FROM questions";
    $result = mysqli_query($conn, $sql);
    $resultChecker = mysqli_num_rows($result);
    if ($resultChecker > 0) {
        $x = 0;
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $array = array();
            $array[] = ++$x;
            $array[] = substr($row['question'], 0, 100);
            // Get Folder Name
            $folder = $row['folder'];
            $folder_sql = "SELECT * FROM question_folders WHERE id = $folder;";
            $folder_result = mysqli_query($conn, $folder_sql);
            $folder_row = mysqli_fetch_assoc($folder_result);
            $folder_name = $folder_row['folder_name'];
            $array[] = $folder == 0 ? "default" : $folder_name;
            // Get Course Name
            $course = $row['course_id'];
            $course_sql = "SELECT * FROM courses WHERE id = $course;";
            $course_result = mysqli_query($conn, $course_sql);
            $course_row = mysqli_fetch_assoc($course_result);
            $course_short_name = $course_row['course_short_name'];
            $array[] = $course_short_name;
            $array[] = "Multichoice";
            $array[] = '<td>•••<div class="links shadow-sm">
            <button type="submit" class="edit" name="edit" value="' . $row['id'] . '" onclick="editQuestion(' . $row['id'] . ')">Edit Question</button>
            <button name="delete" value="' . $row['id'] . '" onclick="deleteQuestion(' . $row['id'] . ')">Delete Question</button>
          </div></td>';
            array_push($data, $array);
        }
        file_put_contents("../text/questions.txt", '{"data":' . json_encode($data) . '}');
    } else {
        file_put_contents("../text/questions.txt", '{"data":[[null,null,null,null,null,null]]}');
    }
} elseif (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $q_sql = "SELECT * FROM questions WHERE id=$id;";
    $o_sql = "SELECT * FROM options WHERE question_id=$id;";
    $q_result = mysqli_query($conn, $q_sql);
    $o_result = mysqli_query($conn, $o_sql);
    $q_row = mysqli_fetch_assoc($q_result);
    $array = array();
    $o_array = array();
    $array[] = $q_row;
    while ($o_row = mysqli_fetch_assoc($o_result)) {
        $o_array[] = $o_row;
    }
    $array[] = $o_array;
    echo json_encode($array);
} elseif (isset($_POST['hidden'])) {
    if (isset($_POST['e-newfolder'])) {
        $newfolder = str_replace("'", "''", trim($_POST['e-newfolder']));
        $sql = "INSERT INTO question_folders (folder_name) VALUES ('$newfolder');";
        $result = mysqli_query($conn, $sql);
        $folder = mysqli_insert_id($conn);
    } else {
        $folder = $_POST['e-folder'];
    }
    $course = $_POST['e-course'];
    $question = str_replace("'", "''", trim($_POST['e-question']));
    $opt1 = trim($_POST['e-opt1']);
    $opt2 = trim($_POST['e-opt2']);
    $opt3 = trim($_POST['e-opt3']);
    $opt4 = trim($_POST['e-opt4']);
    $opt5 = trim($_POST['e-opt5']);
    $answer = $_POST['e-answer'];
    $image = $_FILES['image'];
    $question_id = $_POST['hidden'];
    if (empty($question) || empty($opt1) || empty($opt2) || $answer == -1 || $folder == -1) {
        echo "Empty Field(s)!";
    } else {
        if ($image['name'] === "") {
            $sql = "UPDATE questions SET course_id = $course, question = '$question', folder = $folder WHERE id = $question_id;";
            if (mysqli_query($conn, $sql)) {
                $options = array($opt1, $opt2, $opt3, $opt4, $opt5);
                $delete_sql = "DELETE FROM options WHERE question_id = $question_id";
                mysqli_query($conn, $delete_sql);
                foreach ($options as $option => $value) {
                    if ($value != "") {
                        $value = str_replace("'", "''", $value);
                        if ($option == $answer) {
                            $osql = "INSERT INTO options (question_id, `option`, answer) VALUES ($question_id, '$value', 1);";
                        } else {
                            $osql = "INSERT INTO options (question_id, `option`) VALUES ($question_id, '$value');";
                        }
                        mysqli_query($conn, $osql);
                    }
                }
            }
            echo "Updated Successfully";
        } else {
            // Query Data Base
            $sql = "UPDATE questions SET course_id = $course, question = '$question', folder = $folder WHERE id = $question_id;";
            if (mysqli_query($conn, $sql)) {
                $options = array($opt1, $opt2, $opt3, $opt4, $opt5);
                $delete_sql = "DELETE FROM options WHERE question_id = $question_id;";
                mysqli_query($conn, $delete_sql);
                foreach ($options as $option => $value) {
                    if ($value != "") {
                        $value = str_replace("'", "''", $value);
                        if ($option == $answer) {
                            $osql = "INSERT INTO options (question_id, `option`, answer) VALUES ($question_id, '$value', 1);";
                        } else {
                            $osql = "INSERT INTO options (question_id, `option`) VALUES ($question_id, '$value');";
                        }
                        mysqli_query($conn, $osql);
                    }
                }
            }
            // delete previous image
            $prev_image = "../question-img/question" . $id . "*";
            $findFile = glob($prev_image);
            if (count($findFile) > 0) {
                unlink($findFile[0]);
            }
            // Insert Image
            $img_name = $image['name'];
            $img_error = $image['error'];
            $img_tmp_name = $image['tmp_name'];
            $img_type = $image['type'];
            $img_size = $image['size'];
            $img_array = explode(".", $img_name);
            $img_ext = strtolower(end($img_array));
            $accept = array("jpg", "jpeg", "png", "pdf", "gif");
            if (in_array($img_ext, $accept)) {
                if ($img_error === 0) {
                    if ($img_size < 10000000) {
                        $img_des = "../question-img/";
                        $img_new_name = "question" . $question_id . "." . $img_ext;
                        $img_new_des = $img_des . $img_new_name;
                        move_uploaded_file($img_tmp_name, $img_new_des);                        
                        $img_sql = "UPDATE questions SET `image` = 1 WHERE id = '$question_id';";
                        mysqli_query($conn, $img_sql);
                        echo "Updated Successfully";
                    } else {
                        echo "Image Size Too Big";
                    }
                } else {
                    echo "Error while uploading Image";
                }
            } else {
                echo "Invalid File Type";
            }
        }
    }
} elseif (isset($_POST['remove'])) {
    $id = $_POST['id'];
    $q_sql = "DELETE FROM questions WHERE id = $id;";
    $o_sql = "DELETE FROM options WHERE question_id = $id;";
    if (mysqli_query($conn, $q_sql) && mysqli_query($conn, $o_sql)) {
        $image = "../question-img/question" . $id . "*";
    $findFile = glob($image);
    if (count($findFile) > 0) {
        unlink($findFile[0]);
    }
        echo "Deleted Successfully";
    }
}

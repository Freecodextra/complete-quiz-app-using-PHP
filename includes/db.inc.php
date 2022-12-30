<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "quiz-app";

$conn = mysqli_connect($host,$username,$password,$dbname);

if (!$conn) {
    die("Connection Prolem:".mysqli_connect_error());
}
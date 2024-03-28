<?php
$server_username = "root";
$server_password = "";
$server_host = "localhost";
$database = "webmap";
$conn = mysqli_connect($server_host,$server_username,$server_password,$database) or die("<script> alert('Không thể kết nối CSDL!')</script>");
mysqli_query($conn,"SET NAMES 'UTF8'");
?>

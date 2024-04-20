<?php
$rate=$_POST['rate'];
$mathongbao=$_POST['mathongbao'];
include('connect.php');
$sql = "insert into rating(ma_thongbao,rate) values({$mathongbao},{$rate})";
$retval=mysqli_query($conn,$sql);
?>
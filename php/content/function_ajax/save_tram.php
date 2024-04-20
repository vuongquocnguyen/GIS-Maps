<?php
include("../connect.php");
$data=json_decode($_POST['id']);
$stt=1;
$sql="DELETE FROM tram_xebus WHERE ma_sotuyen='{$_POST['mst']}'";
mysqli_query($conn,$sql) or die('lỗi');
$sql="select max(ma_tram) as max from tram_xebus";
$res=mysqli_query($conn,$sql) or die('lỗi');
$max= mysqli_fetch_assoc($res);
echo $max['max'];
foreach ($data as $value) {
	$max['max']++;
	$name = ($value[0])[0];
	$lat = ($value[0])[1];
	$lng = ($value[0])[2];
	$danhsachnode = json_encode($value[1]);
	$sql = "INSERT INTO `tram_xebus`(`ma_tram`, `ten_tram`, `ma_sotuyen`, `lat`, `lon`, `stt_theotuyen`, `danhsachnode`) VALUES ({$max['max']},'{$name}','{$_POST['mst']}',{$lat},{$lng},{$stt},'{$danhsachnode}') ";
	echo $sql;
	mysqli_query($conn,$sql) or die(12);
	echo $_POST['id'];
	$stt++;
}

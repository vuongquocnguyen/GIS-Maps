<?php
include("../connect.php");
$data = $_POST['data'];
$sql = "SELECT ma_sotuyen, ten_tuyen FROM tuyen_xebus WHERE ma_sotuyen LIKE '$data%' limit 10";
$res=mysqli_query($conn,$sql) or die('lỗi');
if($res!=null&&mysqli_num_rows($res)>0){
	$tmp='';
	while($row=mysqli_fetch_assoc($res)){
		$tmp.=json_encode($row).';';
	}
	echo $tmp;
}
?>
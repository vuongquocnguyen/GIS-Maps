<?php
include("../connect.php");
$data = $_POST['data'];
$sql = "SELECT * FROM tram_xebus WHERE ten_tram LIKE '$data%' limit 20";
$res=mysqli_query($conn,$sql) or die('lỗi');
if($res!=null&&mysqli_num_rows($res)>0){
	$tmp='';
	while($row=mysqli_fetch_assoc($res)){
		$tmp.=json_encode($row).';';
	}
	echo $tmp;
}
?>
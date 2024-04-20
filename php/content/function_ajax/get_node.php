<?php
include("../connect.php");
$sql="select * from tram_xebus where ma_sotuyen='".$_POST['mst']."' ORDER BY stt_theotuyen ASC;" ;
$res = mysqli_query($conn,$sql) or die('loi');
if($res!=null && mysqli_num_rows($res)>0){
	$kq="";
	while ($row=mysqli_fetch_assoc($res)) {
		$kq=$kq.json_encode($row).";";
	}
}
echo $kq;
?>
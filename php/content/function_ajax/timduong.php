<?php 

if(isset($_POST['action']) && isset($_POST['data'])){
	switch ($_POST['action']) {
		case 'getToaDoAll':
			 getToaDo($_POST['data']);
			break;
		
		default:
			# code...
			break;
	}
}

function getToaDo($data){
	if(!is_array($data)){
		include("../connect.php");
		$sql="select * from tram_xebus ORDER BY stt_theotuyen ASC;" ;
		$res = mysqli_query($conn,$sql) or die('loi');
		if($res!=null && mysqli_num_rows($res)>0){
			$kq="";
			while ($row=mysqli_fetch_assoc($res)) {
				$kq=$kq.json_encode($row).";";
			}
		}
		echo $kq;
	}

}


<?php

#----------------------Hàm rút ngắn nội dung---------------
	function rutgonnoidung($string,$batdau,$sotu){
		$len=strlen($string);
		while($sotu<$len){
			if($string[$sotu]==' ') break;
			$sotu++;
		}
		$string=substr($string,$batdau,$sotu);
		if($len>strlen($string)) $string.='...';
		return $string;
	}
?>
<?php
if(isset($_GET['offset']) && isset($_GET['limit'])){
	$limit=$_GET['limit'];
	$offset=$_GET['offset'];
#-----------------------Hiển thị danh sách thông báo-------------
	include("connect.php");
		$sql="SELECT * FROM baidang_diendan where trangthai=1 order by id_baidang DESC limit {$limit} offset {$offset}";
		$retval=mysqli_query($conn, $sql);
		if(mysqli_num_rows($retval) > 0){	
			while($row = mysqli_fetch_assoc($retval)){
				$sql2 ="SELECT COUNT(com_id) as soluong FROM comment WHERE id_baidang=".$row['id_baidang']."";
				$retval2=mysqli_query($conn, $sql2);
				$soluong=mysqli_fetch_assoc($retval2);
				echo  "<div class='baidang'>
							<div class='tag'>".$row['tieude']."</div>
							<div class='hinhanh'><img src='upload/".$row['hinhanh']."'/></div>
							<div class='chu'><p>".rutgonnoidung($row['noidung'],0,700)."</p></div>
							<div class='tuychon'> 
								<p><a onclick='upview();' href='http://127.0.0.1/webMap/forum.php?xem=chitietbaidang&id=".$row['id_baidang']."'><i class='fas fa-book-reader'> More</i></a></p>
								<p><i class='fas fa-comments'> Comment: ".$soluong['soluong']."</i></p>
								<p><i class='fas fa-eye'> View: ".$row['viewcount']."</i></p>
								<div class='tacgia'><p><img src='img/nguoiduyet.png' /> Author: ".$row['nguoidang']."</p></div>
								</div>
						</div>";
			}	
	}else{
		echo "<script>$('.holder').fadeOut(1000);</script>";
	}
	mysqli_close($conn);
}
?>
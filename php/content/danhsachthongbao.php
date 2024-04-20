<style type="text/css">
.tabletuyenbus th{
	height: 50px;
}
</style>
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

#-----------------------------Xóa thông báo-----------------
if(isset($_POST['xoa'])){
	if(!empty($_POST['chon'])){
				$checkbox =$_POST['chon'];
				$len=count($checkbox);
				require("connect.php");
						for( $i=0;$i<$len;$i++){
							$sql = "DELETE FROM thongbao WHERE ma_thongbao='".$checkbox[$i]."'";
							$retval = mysqli_query($conn,$sql)
								or die(mysqli_error());
								
				}
				echo "<script>alert('Đã xóa thành công!')</script>";      
	}else echo "<script> alert('Vui lòng chọn ít nhất một thông báo!')</script>";
}

#-----------------------Hiển thị danh sách thông báo-------------
echo "<div class='tieude'>DANH SÁCH THÔNG BÁO</div>";
include("connect.php");
	$sql="SELECT * FROM thongbao";
	$retval=mysqli_query($conn, $sql);
	if(mysqli_num_rows($retval) > 0){	
	echo "<form name='quanly' method='post' action='#'>";
	echo "<table border='1' class='tabletuyenbus'>";
	echo "<tr>		<th width='5%'>Mã TB</th>".
					"<th width='8%'>Chủ đề</th>".
					"<th width='15%'>Tiêu đề</th>".
					"<th width='13%'>Hình ảnh</th>".
					"<th>Nội dung TB</th>".
					"<th width='5%'>Chọn</th>".
         "</tr>";			
		while($row = mysqli_fetch_assoc($retval)){
			$sql="SELECT * from thongbao";
				echo "<tr>";
				echo "<td>" . $row["ma_thongbao"]. "</td>"; 
				echo "<td>" . $row["chude"]. "</td>"; 
				echo "<td>" . $row["tieude"]. "</td>";
				echo "<td><img src='upload/".$row["hinhanh"]."' width='100px' height='80px'/></td>";
				echo "<td>" . rutgonnoidung($row["noidung"],0,200). "</td>";
				echo "<td style='width:40px;'><input type='checkbox' name='chon[]' value='".$row["ma_thongbao"]."'></td>";
		}	
		echo "</table>";
		echo "<center>";
					echo "<div class='nutchon'>";
						echo "<input class='btn btn-primary' name='xoa' type='submit' value='Xóa Thông Báo'></td>";
					echo "</div>";
		echo "</center>";
	echo "</form>";
}else echo "Không có thông báo!";	
mysqli_close($conn);
?>


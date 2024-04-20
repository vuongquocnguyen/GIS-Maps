<?php
#-------------------------------------Xóa trạm bus--------------------------------------
if(isset($_POST['xoatrambus'])){
	if(!empty($_POST['chon'])){
				$checkbox =$_POST['chon'];
				$len=count($checkbox);
				require("connect.php");
						for( $i=0;$i<$len;$i++){
							$sql = "DELETE FROM tram_xebus WHERE ma_tram='".$checkbox[$i]."'";
							$retval = mysqli_query($conn,$sql)
								or die(mysqli_error());				
				}
				echo "<script>alert('Đã xóa thành công!')</script>";      
	}else echo "<script> alert('Vui lòng chọn ít nhất 1 tuyến bus!')</script>";
}

#----------Cập nhật tuyến bus-----------------
	if(isset($_POST['capnhat'])){
	require("connect.php");
		$sql = "UPDATE tram_xebus SET ma_tram='{$_POST['ma_tram']}',
				ten_tram='{$_POST['ten_tram']}',
				lat='{$_POST['lat']}',
				lon='{$_POST['lon']}',
				stt_theotuyen='{$_POST['stt_theotuyen']}'
		WHERE ma_tram='{$_POST['ma_tram']}'";
	   mysqli_query($conn, $sql) or die("<script> alert('Cập nhật không thành công!')</script>");
	   echo "<script> alert('Cập nhật thành công!')</script>";
	}
?>
<?php
#------------------------------Hiển thị danh sách trạm bus------------------
require("connect.php");
		echo "<div class='tieude'>DANH SÁCH TRẠM BUS THUỘC TUYẾN {$_GET['id']}</div>";
		$sql="SELECT * FROM tram_xebus where ma_sotuyen='{$_GET['id']}' ORDER BY stt_theotuyen";
		$retval=mysqli_query($conn, $sql);
		if(mysqli_num_rows($retval) > 0){	
		echo "<form name='quanly' method='post' action='#'>";
		echo "<table border='1' class='tabletuyenbus'>";
		echo "<tr>		<th width='10%'>Mã trạm</th>".
						"<th>Tên trạm</th>".
						"<th width='20%'>Vĩ độ(Latitude)</th>".
						"<th width='20%'>Kinh độ(Longitude)</th>".
						"<th width='10%'>STT Theo Tuyến</th>".
						"<th>Chọn</th>".
	         "</tr>";			
		while($row = mysqli_fetch_assoc($retval)){
				echo "<tr>";
				echo "<td style='text-align:center;'>" . $row["ma_tram"]. "</td>"; 
				echo "<td>" . $row["ten_tram"]. "</td>"; 
				echo "<td style='text-align:center;'>" . $row["lat"]. "</td>"; 
				echo "<td style='text-align:center;'>" . $row["lon"]. "</td>"; 
				echo "<td style='text-align:center;'>" . $row["stt_theotuyen"]. "</td>";
				echo "<td style='width:40px;'><input type='checkbox' name='chon[]' value='".$row["ma_tram"]."'></td>";
				echo "</tr>";
		}	
		echo "</table>";
		echo "<div id='xoa'></div>";
			echo "<center><div style='width:100%;position: fix;float:left;'>";		
							echo "<a href='index.php?xem=danhsachtuyenbus' style='position:fix;width:100px;'><input class='btn btn-primary' name='suatram' type='button' value='Quay Lại' style='width:150px;' /></a>";	
							echo "<input class='btn btn-primary' name='suatrambus' type='submit' value='Sửa trạm bus' style='width:150px;margin-left:70px;' /> ";
							echo "<button class='btn btn-primary' type='button' onClick='xacnhanxoa();' value='Xóa trạm bus' style='width:150px;margin-left:14px;'>Xóa</button>";
			echo "</div></center>";
		echo "</form>";
		}
		mysqli_close($conn);

#------------------------------------Sửa trạm bus--------------------------------------
if(isset($_POST['suatrambus'])){
		if(!empty($_POST['chon'])){
			require("connect.php");
			$checkbox =$_POST['chon'];
			$len=count($checkbox);
			if($len==1){
				echo "<form name='sua' method='post' action='#'>";
					echo "<table border='1' class='tabletuyenbus'>";
							echo "<tr>";
							echo "<th width='5%'>Mã trạm</th>"; 
							echo "<th>Tên trạm</th>"; 
							echo "<th>Vĩ độ</th>"; 
							echo "<th>Kinh độ</th>"; 
							echo "<th>STT theo tuyến</th>";
							echo "</tr>";
					for( $i=0;$i<$len;$i++){
						echo "<tr>";
						$sql = "select * FROM tram_xebus WHERE ma_tram='".$checkbox[$i]."'";
							$retval = mysqli_query($conn,$sql)
								or die(mysqli_error());
						if(mysqli_num_rows($retval) > 0){					
								while($row = mysqli_fetch_assoc($retval)){
								    echo "<td><input name='ma_tram' type='text' value='{$row['ma_tram']}'></td>";
									echo "<td><input name='ten_tram' type='text' value='{$row['ten_tram']}'></td>"; 
									echo "<td><input name='lat' type='text' value='{$row['lat']}'></td>";	
									echo "<td><input name='lon' type='text' value='{$row['lon']}'></td>";
									echo "<td><input name='stt_theotuyen' type='text' value='{$row['stt_theotuyen']}'></td>";
								}
						}
						 echo "</tr>";							
					}
					echo "</table>";
						echo "<center>";
							echo "<div class='nutchon'>";
								echo "<input style='width:150px; margin-left:70px;' class='btn btn-primary' type='submit' name='capnhat' value='Cập nhật'>";
							echo "</center>";
						echo "</div>";
					echo "</form>";
			}else  echo "<script> alert('Bạn chỉ chọn tối đa 1 tuyến!')</script>";
		}else echo "<script> alert('Vui lòng chọn ít nhất 1 tuyến!')</script>";
	}

?>

<script>
	function xacnhanxoa(){
	check = document.forms['quanly'];
	var dem=0;
	for (i = 0; i < check.length; i++) {
	  if (check[i].checked) {
	  	document.getElementById("xoa").innerHTML="<input type='hidden' name='xoatrambus'/>";
	     if(confirm("Chọn Ok để xác nhận xóa! Chọn Cancel để hủy!")) document.forms['quanly'].submit();
	     return 0;
	  }
	}
	 alert("chọn ít nhất 1 trạm ");
	}
</script>


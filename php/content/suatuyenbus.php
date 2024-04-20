<style type="text/css">
	.nutchon .btn{
		margin: 1% 0 2% 0;

	}

</style>
<script type="text/javascript">
	function kiemtraFormsua(){
		masotuyen=document.forms['sua'].ma_sotuyen.value;
	    tentuyen=document.forms['sua'].ten_tuyen.value;  
	    donvidamnhan=document.forms['sua'].donvi_damnhan.value; 
	    dodaituyen=document.forms['sua'].dodai_tuyen.value;
	    loaixe=document.forms['sua'].loai_xe.value;
	    giave=document.forms['sua'].gia_ve.value;
	    matinhthanh=document.forms['sua'].ma_tinhthanh.value;
	    sochuyen=document.forms['sua'].so_chuyen.value; 
	    tu=document.forms['sua'].tu.value; 
	    den=document.forms['sua'].den.value; 
	    giancachchuyen=document.forms['sua'].giancach_chuyen.value;
		if(masotuyen==""){
	        alert('Mã số tuyến không được rỗng!');
	        document.forms['sua'].masotuyen.focus();
	        return 0;
	        }
	    if(tentuyen==""){
	        alert('Tên tuyến không được rỗng!');
	        document.forms['sua'].tentuyen.focus();
	        return 0;
	        }
	    if(donvidamnhan==""){
	        alert('Đơn vị đảm nhiệm không được rỗng!');
	        document.forms['sua'].donvidamnhan.focus();
	        return 0;
	        }
	    if(dodaituyen=="" || isNaN(dodaituyen) == true){
	    	alert('Độ dài tuyến phải là số và không được rỗng!');
	        document.forms['sua'].dodaituyen.focus();
	        return 0;
	    }
	    if(loaixe==""){
	    	alert('Loại xe không được để rỗng và phải là!');
	        document.forms['sua'].loaixe.focus();
	        return 0;
	    }
	    if(giave==""){
	    	alert('Giá vé không được để rỗng!');
	        document.forms['sua'].giave.focus();
	        return 0;
	    }
	    if(matinhthanh==""){
	    	alert('Mã tỉnh thành không được để rổng!');
	        document.forms['sua'].matinhthanh.focus();
	        return 0;
	    }
	    if(sochuyen=="" || isNaN(sochuyen) == true){
	    	alert('Số chuyến phải là số và không được rỗng!');
	        document.forms['sua'].sochuyen.focus();
	        return 0;
	    }
	    if(tu==""){
	    	alert('Thời gian từ không được để rổng!');
	        document.forms['sua'].tu.focus();
	        return 0;
	    }
	    if(den==""){
	    	alert('Thời gian đến không được để rỗng!');
	        document.forms['sua'].den.focus();
	        return 0;
	    }
	    if(giancachchuyen=="" || isNaN(giancachchuyen) == true){
	    	alert('Giãn cách chuyến phải là số và không được rỗng!');
	        document.forms['sua'].giancach_chuyen.focus();
	        return 0;
	    }
	    document.forms['sua'].submit();
	}
</script>
<?php
#---------------------------------Sửa tuyến bus--------------------------------------
require("connect.php");
echo "<div class='tieude'>SỬA TUYẾN BUS {$_GET['id']}</div>";
	echo "<form name='sua' method='post' action='#'>";
					echo "<table border='1' class='tabletuyenbus'>";
							echo "<tr>";
							echo "<th width='5%'>Mã tuyến</th>"; 
							echo "<th>Tên tuyến</th>"; 
							echo "<th>ĐV đảm nhận</th>"; 
							echo "<th width='5%'>Độ dài tuyến</th>"; 
							echo "<th width='10%'>Loại xe</th>"; 
							echo "<th width='12%'>Giá vé</th>";
							echo "<th width='8%'>Tỉnh thành</th>"; 
							echo "<th width='5%'>Số chuyến</th>"; 
							echo "<th width='12%'>Từ</th>"; 
							echo "<th width='12%'>Đến</th>"; 
							echo "<th width='6%'>Giản cách chuyến</th>";
							echo "</tr>";
						$sql = "select * FROM tuyen_xebus WHERE ma_sotuyen='".$_GET['id']."'";
							$retval = mysqli_query($conn,$sql)
								or die(mysqli_error());
						if(mysqli_num_rows($retval) > 0){					
								while($row = mysqli_fetch_assoc($retval)){
								    echo "<td> <input name='ma_sotuyen' type='text' value='{$row['ma_sotuyen']}'></td>";
									echo "<td> <input name='ten_tuyen' type='text' value='{$row['ten_tuyen']}'></td>"; 
									echo "<td> <input name='donvi_damnhan' type='text' value='{$row['donvi_damnhan']}'></td>";
									echo "<td> <input name='dodai_tuyen' type='text' value='{$row['dodai_tuyen']}'></td>"; 
									echo "<td> <select name='loai_xe'> 
															<option value='{$row['loai_xe']}'>{$row['loai_xe']}</option>
															<option value='6 chỗ'>6 chỗ</option>
															<option value='26-80 chỗ'>26-80 chỗ</option>
															<option value='26-55 chỗ'>26-55 chỗ</option>
															<option value='28-80 chỗ'>28-80 chỗ</option>
															<option value='29-55 chỗ'>29-55 chỗ</option>
											</select></td>";
									echo "<td> <select name='gia_ve'> 
															<option value='{$row['gia_ve']}'>{$row['gia_ve']}</option>
															<option value='5,000 VNĐ'>5,000 VNĐ</option>
															<option value='2,000 VNĐ'>2,000 VNĐ</option>
															<option value='112,500 VNĐ'>112,500 VNĐ</option>
											</select></td>";
									echo "<td> <select name='ma_tinhthanh'> 
															<option value='{$row['ma_tinhthanh']}'>{$row['ma_tinhthanh']}</option>
															<option value='TPHCM'>TPHCM</option>
															<option value='CT'>CT</option>
															<option value='HN'>HN</option>
											</select></td>";
									echo "<td> <input name='so_chuyen' type='text' value='{$row['so_chuyen']}'></td>";
									echo "<td> <input name='tu' type='time' value='{$row['tu']}'></td>";
									echo "<td> <input name='den' type='time' value='{$row['den']}'></td>";		
									echo "<td> <input name='giancach_chuyen' type='number' value='{$row['giancach_chuyen']}'></td>";					
								}
						}
						 echo "</tr> ";							
					echo "</table>";
						echo "<center>";
							echo "<div class='nutchon'>";
							echo "<button type='button' class='btn btn-primary' onClick='kiemtraFormsua();'>Cập Nhật</button>";
						echo "</center>";
	echo "</form>";
#----------Cập nhật tuyến bus-----------------
if(isset($_POST['ma_sotuyen'])){
	require("connect.php");
		$sql = "UPDATE tuyen_xebus SET ten_tuyen='{$_POST['ten_tuyen']}',
				donvi_damnhan='{$_POST['donvi_damnhan']}',
				dodai_tuyen='{$_POST['dodai_tuyen']}',
				loai_xe='{$_POST['loai_xe']}',
				gia_ve='{$_POST['gia_ve']}',
				ma_tinhthanh='{$_POST['ma_tinhthanh']}',
				so_chuyen='{$_POST['so_chuyen']}',
				tu='{$_POST["tu"]}',
				den='{$_POST["den"]}',
				giancach_chuyen='{$_POST['giancach_chuyen']}'
		WHERE ma_sotuyen='{$_POST['ma_sotuyen']}'";
	   mysqli_query($conn, $sql) or die("<script> alert('Cập nhật không thành công!')</script>");
	   echo "<script> alert('Cập nhật thành công!')</script>";
	}	
#----------Hiển thị tuyến bus đã cập nhật-----------------
require("connect.php");
	echo "<div class='tieude'>TUYẾN {$_GET['id']} ĐÃ ĐƯỢC CẬP NHẬT</div>";
		$sql = "select * FROM tuyen_xebus WHERE ma_sotuyen='".$_GET['id']."'";
		$retval = mysqli_query($conn,$sql) or die(mysqli_error());
		if(mysqli_num_rows($retval) > 0){					
		echo "<form name='sua' method='post' action='#'>";
						echo "<table border='1' class='tabletuyenbus'>";
								echo "<tr>";
								echo "<th width='5%'>Mã tuyến</th>"; 
								echo "<th>Tên tuyến</th>"; 
								echo "<th>ĐV đảm nhận</th>"; 
								echo "<th width='5%'>Độ dài tuyến</th>"; 
								echo "<th width='8%'>Loại xe</th>"; 
								echo "<th width='10%'>Giá vé</th>";
								echo "<th width='6%'>Tỉnh thành</th>"; 
								echo "<th width='5%'>Số chuyến</th>"; 
								echo "<th width='13%'>Từ</th>"; 
								echo "<th width='13%'>Đến</th>"; 
								echo "<th width='8%'>Giản cách chuyến</th>";
								echo "</tr>";
									while($row = mysqli_fetch_assoc($retval)){
									    echo "<tr>";
											echo "<td>" . $row["ma_sotuyen"]. "</td>"; 
											echo "<td>" . $row["ten_tuyen"]. "</td>"; 
											echo "<td>" . $row["donvi_damnhan"]. "</td>"; 
											echo "<td>" . $row["dodai_tuyen"]. "</td>"; 
											echo "<td>" . $row["loai_xe"]. "</td>"; 
											echo "<td>" . $row["gia_ve"]. "</td>"; 
											echo "<td>" . $row["ma_tinhthanh"]. "</td>"; 
											echo "<td>" . $row["so_chuyen"]. "</td>"; 
											echo "<td>" . $row["tu"]. "</td>"; 
											echo "<td>" . $row["den"]. "</td>"; 
											echo "<td>" . $row["giancach_chuyen"]."</td>";					
									}
							 echo "</tr> ";							
					echo "</table>";
			echo "</form>";
		}
		mysqli_close($conn);
?>
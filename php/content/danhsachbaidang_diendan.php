<style type="text/css">
.content-table{
	padding: 0 10px;
}
#cn{
	margin: 1% 0 1% 0;
}
input{
	width: 30%;
}
</style>
<script>
	function kiemtraFormcapnhat(){
	id_baidang=document.forms["capnhat"].id_baidang.value;
    chude=document.forms["capnhat"].chude.value;
	tieude=document.forms["capnhat"].tieude.value;
	noidung=document.forms["capnhat"].noidung.value;
	file=document.forms["capnhat"].hinhanh.value;
    if(chude==""){
        alert("Bạn chưa nhập chủ đề");
        document.forms["capnhat"].chude.focus();
    }else if(tieude==""){
		alert("Bạn chưa nhập tiêu đề thông báo!");
		document.forms["capnhat"].tieude.focus();
		}
	else if(noidung==""){
		alert("Bạn chưa nhập nội dung thông báo!");
		document.forms["capnhat"].noidung.focus();
		}
      else{
		if(file!=""){
		type=file.split(".");
			if(type[1]!=='JPG'&&type[1]!=='jpg'
			&&type[1]!=='PNG'&&type[1]!=='png'
			&&type[1]!=='gif'&&type[1]!=='GIF'
			&&type[1]!=='JPEG'&&type[1]!=='jpeg'){
			alert("vui lòng chọn file ảnh đúng định dạng JPG,PNG,GIF");
		file=document.forms["capnhat"].hinhanh.focus();
		return 0;
			}
		}
	if(kiemtraFormcapnhat)document.forms["capnhat"].submit();
	  }		
	}
</script>
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
							$sql = "DELETE FROM baidang_diendan WHERE id_baidang='".$checkbox[$i]."'";
							$retval = mysqli_query($conn,$sql)
								or die(mysqli_error());
				$sql1 = "SET @autoid:= 0;";
			    mysqli_query($conn,$sql1) or die("<script> alert('Không thể thêm1!')</script>");
			    $sql2= "UPDATE baidang_diendan SET id_baidang=@autoid:=(@autoid+1);";
			    mysqli_query($conn,$sql2) or die("<script> alert('Không thể thêm2!')</script>");
			    $sql3= "ALTER table baidang_diendan AUTO_INCREMENT=1;";
			    mysqli_query($conn,$sql3) or die("<script> alert('Không thể thêm3!')</script>");
								
				}
				echo "<script>alert('Đã xóa thành công!')</script>";      
	}else echo "<script> alert('Vui lòng chọn ít nhất một bài đăng!')</script>";
}

#--------------------------Duyệt bài đăng------------------------
if(isset($_POST['duyet'])){
	if(!empty($_POST['chon'])){
				$checkbox =$_POST['chon'];
				$len=count($checkbox);
				require("connect.php");
						for( $i=0;$i<$len;$i++){
							$sql = "UPDATE baidang_diendan set trangthai=1 WHERE id_baidang='".$checkbox[$i]."'";
							$retval = mysqli_query($conn,$sql)
								or die(mysqli_error());
								
				}
				echo "<script>alert('Duyệt bài đăng thành công!')</script>";      
	}else echo "<script> alert('Vui lòng chọn ít nhất một bài đăng!')</script>";
}
#-----------------------Hiển thị danh sách bài đăng diễn đàn-------------
echo "<div class='tieude'>DANH SÁCH BÀI ĐĂNG DIỄN ĐÀN</div>";
echo "<div class='content-table'>";
include("connect.php");
	$sql="SELECT * FROM baidang_diendan";
	$retval=mysqli_query($conn, $sql);
	if(mysqli_num_rows($retval) > 0){
		$phantrang=20;
		$sotrang=ceil(mysqli_num_rows($retval)/$phantrang);
		if(isset($_GET['trang']))
			{
				$batdau=$_GET['trang']*$phantrang;
				$tranghienthai=$_GET['trang'];
				}
			else{
				$batdau=0;
				$ketthuc=$phantrang;
				$tranghienthai=0;
				}
	echo "<form name='quanly' method='post' action='#'>";
	echo '<input type="text" id="myInput" onkeyup="searchTable()" placeholder="Tìm tiêu đề" title="Type in a name">';
	echo "<table id='tableSort' class='table table-hover'>";
	echo "<thead><tr><th width='5%'>ID_BĐ</th>".
                    "<th onclick='sortTable(1)' style='cursor:pointer'>Chủ đề</th>".
                    "<th onclick='sortTable(2)' style='cursor:pointer'>Tiêu Đề</th>".
                    "<th onclick='sortTable(3)' style='cursor:pointer'>Hình ảnh</th>".
					"<th onclick='sortTable(4)' style='cursor:pointer'>Nội dung TB</th>".
					"<th onclick='sortTable(5)' style='cursor:pointer'>Trạng thái</th>".
					"<th onclick='sortTable(6)' style='cursor:pointer'width='5%'>Chọn</th>".
         "</tr></thead><tbody>";	
        $sql1="SELECT * from baidang_diendan limit $batdau, $phantrang";	
        $retval2=mysqli_query($conn, $sql1);	
		while($row = mysqli_fetch_assoc($retval2)){
				echo "<tr>";
				echo "<td>" . $row["id_baidang"]. "</td>"; 
                echo "<td>" . $row["chude"]. "</td>"; 
                echo "<td>" . $row["tieude"]. "</td>"; 
                echo "<td><img src='upload/".$row["hinhanh"]."' width='50px' height='50px'/></td>";
				echo "<td>" . rutgonnoidung($row["noidung"],0,50). "</td>";
				echo "<td style='text-align:center;'>" . $row["trangthai"]. "</td>"; 
				echo "<td style='width:40px;'><input type='checkbox' name='chon[]' value='".$row["id_baidang"]."'></td>";
		}	
		echo "</tbody></table>";
		echo "<center>";
					echo "<div class='nutchon'>";
						echo "<input class='btn btn-primary' name='xoa' type='submit' value='Xóa Bài Đăng'></td>";
						echo "<input class='btn btn-primary' name='sua' type='submit' value='Sữa Bài Đăng'></td>";
						echo "<input class='btn btn-primary' name='duyet' type='submit' value='Duyệt bài đăng'></td>";
					echo "</div>";
					echo "<div id='phantrang'>";
						for($i=0;$i<$sotrang;$i++){
							if($i!=$tranghienthai){
								echo "<a href='index.php?xem=baidangdiendan&trang={$i}'>[ ".($i+1)." ]</a>";
								}
								 	else echo "<span>[ ".($i+1)." ]</span>";
							}
						echo "</div>";
		echo "</center>";
	echo "</form>";
}else echo "Không có thông báo!";	
mysqli_close($conn);
?>
<?php
#----------------Sữa bài đăng--------------------
if(isset($_POST['sua'])){
	if(!empty($_POST['chon'])){
			$checkbox =$_POST['chon'];
			$len=count($checkbox);
			if($len==1){
			require("connect.php");
			echo "<div class='tieude'>Sửa bài đăng {$checkbox[0]}</div>";
				echo "<form name='capnhat' method='post' action='#' enctype='multipart/form-data'>";
								echo "<table border='1' class='tabletuyenbus'>";
										echo "<tr>";
										echo "<th width='5%'>IDBĐ</th>"; 
										echo "<th width='10%'>Chủ Đề</th>";
										echo "<th width='10%'>Tiêu Đề</th>"; 
										echo "<th>Hình Ảnh</th>"; 
										echo "<th width='6%'>Trạng Thái</th>";
										echo "<th width='45%'>Nội Dung</th>"; 
										echo "</tr>";
									$sql = "select * FROM baidang_diendan WHERE id_baidang={$checkbox[0]}";
									$retval = mysqli_query($conn,$sql);
									if(mysqli_num_rows($retval) > 0){					
											while($row = mysqli_fetch_assoc($retval)){
												echo "<td> <input style='background-color:#66CCCC; border:none;' name='id_baidang' type='text' value='{$row['id_baidang']}'></td>";
												echo "<td> <select name='chude'> 
															<option value='{$row['chude']}'>{$row['chude']}</option>
															<option value='Tình Yêu'> Tình Yêu</option>
															<option value='Thơ Tình'> Thơ Tình</option>
															<option value='Thả Thính'> Thả Thính</option>
															<option value='Tâm Sự'> Tâm Sự</option>
															<option value='Chính Trị'> Chính Trị</option>
															<option value='Khác'> Khác</option>
														</select>
														</td>";
												echo "<td> <input name='tieude' type='text' value='{$row['tieude']}'></td>";
												echo "<td> <input type='text' value='{$row['hinhanh']}'>
														   <input type='file' name='hinhanh' value='chọn hình'/>
													  </td>";
												echo "<td>
														<select name='trangthai'> 
														<option value={$row['trangthai']}>{$row['trangthai']}</option>
														<option value='1'>1</option>	
														</select>
												</td>";
												echo "<td> <input name='noidung' type='text' value='{$row['noidung']}'></td>"; 					
											}
									}
									echo "</tr> ";							
								echo "</table>";
									echo "<center>";
										echo "<div class='nutchon'>";
											echo "<button id='cn' type='button' class='btn btn-primary' onClick='kiemtraFormcapnhat();'>Cập Nhật</button>";
									echo "</div>";
										echo "</center>";
				echo "</form>";
		} else echo "<script>alert('Vui lòng chọn một bài đăng!')</script>";
	}
	if(empty($_POST['chon'])){
		echo "<script>alert('Vui lòng chọn một bài đăng!')</script>";
	}
}

if(isset($_POST["noidung"])){
	include('connect.php');
	$sql1 = "SET @autoid:= 0;";
    mysqli_query($conn,$sql1) or die("<script> alert('Không thể thêm1!')</script>");
    $sql2= "UPDATE baidang_diendan SET id_baidang=@autoid:=(@autoid+1);";
    mysqli_query($conn,$sql2) or die("<script> alert('Không thể thêm2!')</script>");
    $sql3= "ALTER table baidang_diendan AUTO_INCREMENT=1;";
    mysqli_query($conn,$sql3) or die("<script> alert('Không thể thêm3!')</script>");
	#Kiểm tra file ảnh có đúng định dạng không
	if($_FILES["hinhanh"]["name"]!=""){
        $file_part=$_FILES["hinhanh"]["name"];
		move_uploaded_file($_FILES["hinhanh"]["tmp_name"],"upload/".$file_part);
		$sql = "UPDATE baidang_diendan set chude='{$_POST['chude']}', tieude='{$_POST['tieude']}', trangthai={$_POST['trangthai']}, noidung='{$_POST['noidung']}', hinhanh='{$file_part}' where id_baidang={$_POST['id_baidang']}";
	}
	else {
		$file_part="default.png";
		$sql = "UPDATE baidang_diendan set chude='{$_POST['chude']}', tieude='{$_POST['tieude']}', trangthai={$_POST['trangthai']}, noidung='{$_POST['noidung']}' where id_baidang={$_POST['id_baidang']}";
	}
    mysqli_query($conn,$sql) or die("Không thể cập nhật");
	echo "<script> alert('Đã Cập Nhật Bài Đăng Thành Công!!!')</script>";		
	}

	echo "</div>";
?>

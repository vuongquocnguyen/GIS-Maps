<style type="text/css">
.content-table{
	padding: 0 10px;
}
#cn{
	margin: 1% 0 1% 0;
}
.bnt{
	width: 30%;
}
</style>
<script>
	function kiemtra(){
	tentaikhoan=document.forms["capnhat"].tentaikhoan.value;
    matkhau=document.forms["capnhat"].matkhau.value;
	sdt=document.forms["capnhat"].sdt.value;
	email=document.forms["capnhat"].email.value;
	if(tentaikhoan==""){
        alert("Bạn chưa nhập tên tài khoản");
        document.forms["capnhat"].tentaikhoan.focus();
    }else if(matkhau==""){
        alert("Bạn chưa nhập matkhau");
        document.forms["capnhat"].matkhau.focus();
    }else if(sdt==""){
        alert("Bạn chưa nhập số điện thoại");
        document.forms["capnhat"].sdt.focus();
    }else if(email==""){
        alert("Bạn chưa nhập tên tài khoản");
        document.forms["capnhat"].email.focus();
    }else {
    	document.forms["capnhat"].submit();
    }
}
</script>

<?php
#-----------------------------Xóa thông báo-----------------
if(isset($_POST['xoa'])){
	if(!empty($_POST['chon'])){
				$checkbox =$_POST['chon'];
				$len=count($checkbox);
				require("connect.php");
						for( $i=0;$i<$len;$i++){
							$sql = "DELETE FROM taikhoan WHERE id='".$checkbox[$i]."'";
							$retval = mysqli_query($conn,$sql)
								or die(mysqli_error());
				$sql1 = "SET @autoid:= 0;";
			    mysqli_query($conn,$sql1) or die("<script> alert('Không thể thêm1!')</script>");
			    $sql2= "UPDATE taikhoan SET id=@autoid:=(@autoid+1);";
			    mysqli_query($conn,$sql2) or die("<script> alert('Không thể thêm2!')</script>");
			    $sql3= "ALTER table taikhoan AUTO_INCREMENT=1;";
			    mysqli_query($conn,$sql3) or die("<script> alert('Không thể thêm3!')</script>");
								
				}
				echo "<script>alert('Đã xóa thành công!')</script>";      
	}else echo "<script> alert('Vui lòng chọn ít nhất một tài khoản!')</script>";
}

#--------------------------Duyệt bài đăng------------------------
if(isset($_POST['duyet'])){
	if(!empty($_POST['chon'])){
				$checkbox =$_POST['chon'];
				$len=count($checkbox);
				require("connect.php");
						for( $i=0;$i<$len;$i++){
							$sql = "UPDATE taikhoan set quyen=1 WHERE id='".$checkbox[$i]."'";
							$retval = mysqli_query($conn,$sql)
								or die(mysqli_error());
								
				}
				echo "<script>alert('Duyệt Admin thành công!')</script>";      
	}else echo "<script> alert('Vui lòng chọn ít nhất một tài khoản!')</script>";
}
?>
<?php
echo "<div class='tieude'>DANH SÁCH TÀI KHOẢN</div>";
echo "<div class='content-table'>";
include("connect.php");
	$sql="SELECT * FROM taikhoan";
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
	echo '<input type="text" id="myInput" onkeyup="searchTable()" placeholder="Tìm theo tên tài khoản" title="Type in a name">';
	echo "<table id='tableSort' class='table table-hover'>";
	echo "<thead><tr><th onclick='sortTable(0)' style='cursor:pointer' width='5%'>ID_TK</th>".
					"<th onclick='sortTable(2)' style='cursor:pointer'>Mật Khẩu</th>".
                    "<th onclick='sortTable(1)' style='cursor:pointer'>Tên Tài Khoản</th>".
                    "<th onclick='sortTable(3)' style='cursor:pointer'>Email</th>".
					"<th onclick='sortTable(4)' style='cursor:pointer'>SĐT</th>".
					"<th onclick='sortTable(5)' style='cursor:pointer'>Hình Ảnh</th>".
					"<th onclick='sortTable(6)' style='cursor:pointer'>Quyền</th>".
					"<th width='5%'>Chọn</th>".
         "</tr></thead><tbody>";	
        $sql1="SELECT * from taikhoan order by id ASC limit $batdau, $phantrang ";	
        $retval2=mysqli_query($conn, $sql1);	
		while($row = mysqli_fetch_assoc($retval2)){
				echo "<tr>";
				echo "<td>" . $row["id"]. "</td>"; 
				echo "<td>" . $row["matkhau"]. "</td>"; 
                echo "<td>" . $row["tentaikhoan"]. "</td>"; 
                echo "<td>" . $row["email"]. "</td>"; 
                echo "<td>" . $row["sdt"]. "</td>";
                echo "<td><img src='upload/".$row["hinhanh"]."' width='auto' height='auto'/></td>";
				echo "<td style='text-align:center;'>" . $row["quyen"]. "</td>"; 
				echo "<td style='width:40px;'><input type='checkbox' name='chon[]' value='".$row["id"]."'></td>";
		}	
		echo "</tbody></table>";
		echo "<center>";
					echo "<div class='nutchon'>";
						echo "<input class='btn btn-primary' name='xoa' type='submit' value='Xóa Tài Khoản'></td>";
						echo "<input class='btn btn-primary' name='sua' type='submit' value='Cập nhật Tài Khoản'></td>";
						echo "<input class='btn btn-primary' name='duyet' type='submit' value='Duyệt Admin'></td>";
					echo "</div>";
					echo "<div id='phantrang'>";
						for($i=0;$i<$sotrang;$i++){
							if($i!=$tranghienthai){
								echo "<a href='index.php?xem=quanlytaikhoan&trang={$i}'>[ ".($i+1)." ]</a>";
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
			echo "<div class='tieude'>Sửa Tài Khoản {$checkbox[0]}</div>";
				echo "<form name='capnhat' method='post' action='#' enctype='multipart/form-data'>";
								echo "<table border='1' class='tabletuyenbus'>";
										echo "<tr>";
										echo "<th width='5%'>ID</th>"; 
										echo "<th width='10%'>Tên Tài Khoản</th>";
										echo "<th width='10%'>Mật Khẩu</th>"; 
										echo "<th width='10%'>SĐT</th>"; 
										echo "<th>Email</th>"; 
										echo "<th width='6%'>Quyền</th>";
										echo "</tr>";
									$sql = "select * FROM taikhoan WHERE id={$checkbox[0]}";
									$retval = mysqli_query($conn,$sql);
									if(mysqli_num_rows($retval) > 0){					
											while($row = mysqli_fetch_assoc($retval)){
												echo "<td> <input style='background-color:#66CCCC; border:none;' name='abc' type='text' value='{$row['id']}'></td>";
												echo "<td width='4%'> <input name='tentaikhoan' type='text' value='{$row['tentaikhoan']}'></td>";
												echo "<td> <input name='matkhau' type='text' value='{$row['matkhau']}'></td>";
												echo "<td> <input name='sdt' type='text' value='{$row['sdt']}'></td>";
												echo "<td width='10%'> <input name='email' type='text' value='{$row['email']}'></td>";
												echo "<td width='10%'>
														<select name='quyen' width='10%'> 
														<option value='0'>Người Dùng Thường</option>
														<option value='1'>Admin</option>	
														</select>
												</td>";			
											}
									}
									echo "</tr> ";							
								echo "</table>";
									echo "<center>";
										echo "<div class='nutchon'>";
											echo "<button id='cn' type='button' class='btn btn-primary' onClick='kiemtra();'>Cập Nhật</button>";
									echo "</div>";
										echo "</center>";
				echo "</form>";
		} else echo "<script>alert('Vui lòng chọn một tài khoản!')</script>";
	}
	if(empty($_POST['chon'])){
		echo "<script>alert('Vui lòng chọn một tài khoản!')</script>";
	}
}
?>
<?php
if(isset($_POST["quyen"])){
	include('connect.php');
	$sql1 = "SET @autoid:= 0;";
    mysqli_query($conn,$sql1) or die("<script> alert('Không thể thêm1!')</script>");
    $sql2= "UPDATE taikhoan SET id=@autoid:=(@autoid+1);";
    mysqli_query($conn,$sql2) or die("<script> alert('Không thể thêm2!')</script>");
    $sql3= "ALTER table taikhoan AUTO_INCREMENT=1;";
    mysqli_query($conn,$sql3) or die("<script> alert('Không thể thêm3!')</script>");
	#Kiểm tra file ảnh có đúng định dạng không
	$pass=md5($_POST['matkhau']);
	$sql = "UPDATE taikhoan set tentaikhoan='{$_POST['tentaikhoan']}', matkhau='$pass', sdt='{$_POST['sdt']}', email='{$_POST['email']}', quyen='{$_POST['quyen']}' where id='{$_POST['abc']}'";
    mysqli_query($conn,$sql) or die("Không thể cập nhật");
	echo "<script> alert('Đã Cập Nhật Tài Khoản Thành Công!!!')</script>";		
}
?>
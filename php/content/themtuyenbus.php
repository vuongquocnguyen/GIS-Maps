<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<style>
	#formthemtuyenbus{
		width: 100%;
		height: auto;
	}
	.tablethemtuyenbus{
		position: relative;
		margin-left: 25%;
		width: 50%;
		margin-bottom: 1%;
	}
	.tablethemtuyenbus td{
		font-size: 16px;
		font-family:tahoma, "DejaVu Sans Condensed", "sans-serif";
		color: white;
		font-weight: bold;
	}
	.tablethemtuyenbus th{
		width: 20%;
		color: #009966;
	}
	.tablethemtuyenbus select{
	background-color: white;
	width: 100%;
	height: 35px;
	line-height: 35px;
	border-radius: 5px;
	padding: 5px;
	margin-bottom: 2%;
	}
	.btn{
		margin-top: 1%;
		margin-bottom: 1%;
	}
	.tablethemtuyenbus button{
		width: 100%;
	}
</style>
<script language="javascript" type="text/javascript">
	   function kiemtra(){
	    masotuyen=document.forms['formthemtuyenbus'].masotuyen.value;
	    tentuyen=document.forms['formthemtuyenbus'].tentuyen.value;  
	    donvidamnhan=document.forms['formthemtuyenbus'].donvidamnhan.value; 
	    dodaituyen=document.forms['formthemtuyenbus'].dodaituyen.value;
	    sochuyen=document.forms['formthemtuyenbus'].sochuyen.value; 
	    giancachchuyen=document.forms['formthemtuyenbus'].giancachchuyen.value;
	    if(masotuyen==""){
	        alert('Vui lòng nhập mã số tuyến!');
	        document.forms['formthemtuyenbus'].masotuyen.focus();
	        return 0;
	        }
	    if(tentuyen==""){
	        alert('Vui lòng nhập tên tuyến!');
	        document.forms['formthemtuyenbus'].tentuyen.focus();
	        return 0;
	        }
	    if(donvidamnhan==""){
	        alert('Vui lòng nhập đơn vị đảm nhiệm!');
	        document.forms['formthemtuyenbus'].donvidamnhan.focus();
	        return 0;
	        }
	    if(dodaituyen=="" || isNaN(dodaituyen) == true){
	    	alert('Vui lòng nhập độ dài tuyến và độ dài tuyến phải là số!');
	        document.forms['formthemtuyenbus'].dodaituyen.focus();
	        return 0;
	    }
	    if(sochuyen=="" || isNaN(sochuyen) == true){
	    	alert('Vui lòng nhập số chuyến và số chuyến phải là số!');
	        document.forms['formthemtuyenbus'].sochuyen.focus();
	        return 0;
	    }
	    if(giancachchuyen=="" || isNaN(giancachchuyen) == true){
	    	alert('Vui lòng nhập giản cách chuyến và giản cách chuyến phải là số!');
	        document.forms['formthemtuyenbus'].giancachchuyen.focus();
	        return 0;
	    }
	    document.forms['formthemtuyenbus'].submit();
	}
</script>
<?php
if(isset($_POST['masotuyen'])){
	include('connect.php');
	$checkData = "SELECT * from tuyen_xebus WHERE ma_sotuyen='{$_POST['masotuyen']}' OR ten_tuyen='{$_POST['tentuyen']}'";

	$resultCheck=mysqli_query($conn,$checkData) or die("<?php echo'NO' ?>");

		if($resultCheck){
			 $result= mysqli_fetch_array($resultCheck);
		}else{
			$result=[];
		}
	if($result){
		echo "<script>alert('Mã số tuyến hoặc tên tuyến đã tồn tại!')</script>" ;
	}else{
		$sql = "INSERT INTO tuyen_xebus(ma_sotuyen,ten_tuyen,donvi_damnhan,dodai_tuyen,loai_xe,gia_ve,ma_tinhthanh,so_chuyen,tu,den,giancach_chuyen) VALUES('{$_POST['masotuyen']}','{$_POST['tentuyen']}','{$_POST['donvidamnhan']}',{$_POST['dodaituyen']},'{$_POST['loaixe']}','{$_POST['giave']}','{$_POST['tinhthanh']}',{$_POST['sochuyen']},'{$_POST['tu']}','{$_POST['den']}','{$_POST['giancachchuyen']}');";
    mysqli_query($conn,$sql) or die("<script> alert('Không thể thêm!')</script>");
    echo "<script>alert('Thêm thành công!')</script>";
    mysqli_close($conn);
	}
	}
?>
<div class="tieude">THÊM TUYẾN BUS</div>
	<form id="formthemtuyenbus" name="formthemtuyenbus" method="POST" enctype="multipart/form-data">
		<table class='tablethemtuyenbus'>
	        	<div class="form-group">
	               <tr><th>Mã số tuyến:</th><td><input type="text" name="masotuyen" class="form-control" placeholder="Nhập mã số tuyến"></td></tr>
	               <tr><th>Tên tuyến:</th><td width="40%"><input type="text" name="tentuyen" class="form-control" placeholder="Nhập tên tuyến"></td></tr>
	               <tr><th>Đơn vị đảm nhận:</th><td><input type="text" name="donvidamnhan" class="form-control" placeholder="Nhập đơn vị đảm nhận"></td></tr>
	               <tr><th>Độ dài tuyến:</th><td><input type="text" name="dodaituyen" class="form-control" placeholder="Nhập độ dài tuyến Km"></td></tr>
	               <tr><th>Loại xe:</th>
	               <td><select class="option" name="loaixe">
						<option>6 chỗ</option>
						<option>26-80 chỗ</option>
						<option>26-55 chỗ</option>
						<option>28-80 chỗ</option>
						<option>29-55 chỗ</option>
						<option>39-80 chỗ</option>
					</select></td></tr>
					<tr><th>Giá vé:</th>
		               	<td><select class="option" name="giave">
							<option>5,000 VNĐ</option>
							<option>2,000 VNĐ</option>
							<option>112,500 VNĐ</option>
						</select></td></tr>
					<tr><th>Tỉnh thành:</th>
		               	<td><select class="option" name="tinhthanh">
							<option value="TPHCM">Thành Phố Hồ Chí Minh</option>
							<option value="CT">Thành Phố Cần Thơ</option>
							<option value="HN">Thủ Đô Hà Nội</option>
							<option value="Other">....</option>
						</select></td></tr>		
				   <tr><th>Số chuyến:</th>
	               <td><input type="text" name="sochuyen" class="form-control" placeholder="Nhập số lượng chuyến"></td></tr>
	               <tr><th>Thời gian hoạt động:</th>
	               <td width="20%"><input type="time" name="tu" placeholder="Nhập giờ hh:mm">
	               <input type="time" name="den" placeholder="Nhập giờ hh:mm"></td></tr>
	               <tr><th>Giãn cách chuyến:</th>
	               <td><input type="number" name="giancachchuyen" class="form-control"  placeholder="Nhập thời gian giãn cách chuyến (phút)"></td></tr>
	               <tr>
		              <td></td>
		                <td align="center">
		                	<button type="button" class="btn btn-primary" onClick="kiemtra();">Thêm tuyến bus</button>
		                </td>
          			</tr>
	        </div>
	    </table> 
    </form>
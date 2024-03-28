<style>
#thongbao{
width:80%;
height:auto;
margin:auto;
}

#thongbao textarea{
width:100%;	
height:250px;
}
#thongbao select{
width: 30%;
}
#thongbao input[type=file]{
width:30%;
}
#thongbao p{
	font-family: tahoma;
	font-size: 14px;
}
#thongbao input[type=button]{
width:20%;
}
#thongbao progress {
    margin: 2px;
    width: 100%;
    height: 20px;
}
#thongbao p {
    margin: 2px;
    float: none;
    width: 100%;
}
</style>

<script>
//---------------------Kiểm tra form nhập liệu--------------------------
function _(el) {
  return document.getElementById(el);
}
function uploadFile() {
	chude=document.forms["baidang"].chude.value;
	tieude=document.forms["baidang"].tieude.value;
	noidung=document.forms["baidang"].noidung.value;
	file=document.forms["baidang"].hinhanh.value;
	if(chude==""){
		alert("Bạn chưa nhập chủ đề  bài đăng!");
		document.forms["baidang"].tieude.focus();
		return 0;
		}
	if(tieude==""){
		alert("Bạn chưa nhập tiêu đề  bài đăng!");
		document.forms["baidang"].tieude.focus();
		return 0;
		}
	if(noidung==""){
		alert("Bạn chưa nhập nội dung bài đăng!");
		document.forms["baidang"].noidung.focus();
		return 0;
		}
   
	if(file!=""){
		type=file.split(".");
			if(type[1]!=='JPG'&&type[1]!=='jpg'
			&&type[1]!=='PNG'&&type[1]!=='png'
			&&type[1]!=='gif'&&type[1]!=='GIF'
			&&type[1]!=='JPEG'&&type[1]!=='jpeg'){
					alert("vui lòng chọn file ảnh đúng định dạng JPG,PNG,GIF");
					file=document.forms["baidang"].hinhanh.focus();
					return 0;
		  			}
	}else {document.forms["baidang"].submit();return 0;}
	size=$('#hinhanh')[0].files[0].size;
	size=size/1024/1024;
	if(size>5){
	alert("kích thước file >5mb. vui lòng chọn ảnh size nhỏ hơn");
	document.forms['baidang'].hinhanh.focus();
	return 0;
	}

  var file = _("hinhanh").files[0];
  // alert(file.name+" | "+file.size+" | "+file.type);
  var formdata = new FormData();
  formdata.append("hinhanh", file);
  var ajax = new XMLHttpRequest();
  ajax.upload.addEventListener("progress", progressHandler, false);
  ajax.addEventListener("load", completeHandler, false);
  ajax.addEventListener("error", errorHandler, false);
  ajax.addEventListener("abort", abortHandler, false);
  ajax.open("POST", "#");
  ajax.send(formdata);
}

function progressHandler(event) {
  _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
  var percent = (event.loaded / event.total) * 100;
  _("progressBar").value = Math.round(percent);
  _("status").innerHTML = Math.round(percent) + "% uploaded... vui lòng chờ!!!";
}

function completeHandler(event) {
  _("status").innerHTML = "Upload Thành công!";
  _("xuli").innerHTML = "Đang xử lí...";
  _("progressBar").value = 0;
  document.forms['baidang'].submit();
}

function errorHandler(event) {
  _("status").innerHTML = "Upload Failed";
}

function abortHandler(event) {
  _("status").innerHTML = "Upload Aborted";
}

</script>



<?php
#-------------------------Đăng thông báo----------------------
if(isset($_POST["noidung"])){
	require_once('connect.php');
	$sql1 = "SET @autoid:= 0;";
    mysqli_query($conn,$sql1) or die("<script> alert('Không thể thêm1!')</script>");
    $sql2= "UPDATE thongbao SET ma_thongbao=@autoid:=(@autoid+1);";
    mysqli_query($conn,$sql2) or die("<script> alert('Không thể thêm2!')</script>");
    $sql3= "ALTER table thongbao AUTO_INCREMENT=1;";
    mysqli_query($conn,$sql3) or die("<script> alert('Không thể thêm3!')</script>");
	#Kiểm tra file ảnh có đúng định dạng không
	if($_FILES["hinhanh"]["name"]!=""){
		$file_part=$_FILES["hinhanh"]["name"];
		move_uploaded_file($_FILES["hinhanh"]["tmp_name"],"upload/".$file_part);
	}
	else $file_part="default.png";
	#Thêm vào csdl 
	$ngay=date('d/m/Y') ;
	$sql="INSERT INTO thongbao (chude, tieude, noidung, hinhanh, ngaydang)
	VALUES ( '".$_POST['chude']."' ,'".$_POST['tieude']."' , '".$_POST['noidung']."' , '".$file_part."' , '".$ngay."' );";
	mysqli_query($conn,$sql) or die("Không thể thêm");
	echo "<script> alert('Đã Đăng Thông Báo Thành Công!!!')</script>";		
	}
?>
<div class="tieude">ĐĂNG THÔNG BÁO</div>
<div id="thongbao"> 
  <form name="baidang" method="post" action="#" enctype="multipart/form-data">
       <p>Chủ Đề:</p><select class="form-control" name="chude" > 
       				<option value=""> --Chọn--</option>
       				<option value="Thông Báo"> Thông Báo</option>
       				<option value="An Ninh"> An Ninh</option>
       				<option value="Góp Ý"> Góp Ý</option>
                    <option value="Tìm Đồ Và Vật Bị Mất"> Tìm Đồ Và Vật Bị Mất</option>
       			</select><br>
       Tiêu Đề: <input class="form-control" type="text" name="tieude"> <br>
      <textarea name="noidung"  class="form-control" placeholder="Bạn hãy nhập nội dung vào đây!"></textarea>
      <input class="btn btn-primary" type="file" name="hinhanh" id="hinhanh"/> 
     <br/><p>Quá Trình Đăng:</p> <progress style="width: 100%;" id='progressBar' value='0' max='100' > Tiến trình:</progress>
       <center>
      <input type="button" class="btn btn-primary" name="sub" value="Đăng thông báo" onClick="uploadFile();"/>
      <input type="button" class="btn btn-primary" value="Danh Sách thông báo" onClick="location.href='index.php?xem=danhsachthongbao'">
      </center>
     </form>
    <p id='loaded_n_total'></p>
   <p id='status'> </p>
  <p id='xuli'> </p>


</div>

<style>
    /* ------------------------------------------------Dang bai-------------------------- */	
    .dangbai{
    width:100%;	
    padding:0 2%;
    }
    .dangbai input[type='text']{
    margin-top :1%;
    margin-bottom:1%;
    width:50%;	
    }
    .dangbai progress{
    margin:2px;
    width:100%;	
    height:20px;
    }
    .dangbai p{
        margin:2px;
        float:none;	
        width:100%;
    }
    .dangbai select{
    margin-top :1%;
    margin-bottom:1%;
    min-width:10%;
    }
    .dangbai textarea{
    width:98%;	
    height:300px;
    margin-top:1%;
    margin-bottom:1%;
    }
    .dangbai input[type='button']{
        margin-top:1%;
        width:30%;
        height:30px;
        color:#FFF;
        background:#069;
        border:none;
        opacity:0.7;
        border-radius:10px;
    }
    .tieude{
        text-align:center;
        font-size:20px;
        color:#069;
        font-weight:bold;
    }
</style>
<script>
//---------------------Kiểm tra form nhập liệu--------------------------
function uploadFile(){
    chude=document.forms["baidang"].chude.value;
	tieude=document.forms["baidang"].tieude.value;
	noidung=document.forms["baidang"].noidung.value;
	file=document.forms["baidang"].hinhanh.value;
    if(chude==""){
        alert("Bạn chưa nhập chủ đề");
        document.forms["baidang"].chude.focus();
    }else if(tieude==""){
		alert("Bạn chưa nhập tiêu đề thông báo!");
		document.forms["baidang"].tieude.focus();
		}
	else if(noidung==""){
		alert("Bạn chưa nhập nội dung thông báo!");
		document.forms["baidang"].noidung.focus();
		}
      else{
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
		}
	if(uploadFile)document.forms["baidang"].submit();
	  }		
	}
</script>

<?php
#-------------------------Đăng thông báo----------------------
if(isset($_POST["noidung"])){
	require_once('connect.php');
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
	}
	else $file_part="default.png";
	#Thêm vào csdl 
	$ngay=date('d/m/Y') ;
	$sql="INSERT INTO baidang_diendan (chude, tieude, noidung, hinhanh, nguoidang, ngaydang, viewcount, luot_like, luot_dislike, trangthai)
	VALUES ( '".$_POST['chude']."' ,'".$_POST['tieude']."' , '".$_POST['noidung']."' , '".$file_part."' ,'".$_SESSION['nguoidung']."' , '".$ngay."',0,0,0,0);";
    mysqli_query($conn,$sql) or die("Không thể thêm");
	echo "<script> alert('Đã Đăng Thông Báo Thành Công!!!')</script>";		
	}
?>
</script>
<div class="dangbai">
    <form name="baidang" method="post" action="#" enctype="multipart/form-data">
    <p class="tieude">Đăng bài</p>
    <hr>Chủ Đề: <select name="chude"> 
                     <option value=""> --Chọn--</option>
                     <option value="Tình Yêu"> Tình Yêu</option>
                  <option value="Thơ Tình"> Thơ Tình</option>
                  <option value="Thả Thính"> Thả Thính</option>
                  <option value="Tâm Sự"> Tâm Sự</option>
                  <option value="Chính Trị"> Chính Trị</option>
                  <option value="Học Tập"> Học Tập</option>
                  <option value="Việc Làm"> Việc Làm</option>
                  <option value="Game"> Game</option>
                  <option value="Ý Đẹp"> Ý Đẹp</option>
                  <option value="Từ Thiện"> Từ Thiện</option>
                  <option value="Kiến Thức"> Kiến Thức</option>
                   <option value="Phim Ảnh"> Phim Ảnh</option>
                  <option value="Chủ Đề Khác"> Chủ Đề Khác</option>
                 </select><br>
     <hr>Tiêu Đề: <input type="text" name="tieude"> <br>
    <hr>Nội Dung: <textarea name="noidung" placeholder="Bạn hãy nhập nội dung vào đây!"></textarea>
    <hr><input type="file" class="btn btn-primary" name="hinhanh" value="chọn hình"/>
    <center>
    <hr><input type="button" name="sub" value="Đăng Bài" onclick="uploadFile();"/>
    </center>
   </form>
</div>

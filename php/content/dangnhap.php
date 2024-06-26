<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<style type="text/css">
input[type=text], input[type=password] {
    width: 90%;
    margin-left: 5%;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
	font-size:14px;
    background-color: #FFF;
    color: #000;
}
input[type=text]:hover,input[type=password]:hover{
    background-color: #FFF;
     color: #000;
}
input[type=text]:active,input[type=password]:active{
    background-color: #FFF;
     color: #000;
}
/* Set a style for all buttons */
button{
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 26px;
    border: none;
    cursor: pointer;
    width: 90%;
	font-size:14px;
}
button:hover {
    opacity: 0.8;
}

/* Center the image and position the close button */
.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
    position: relative;
}
.avatar {
    width: 100px;
	height:100px;
    border-radius: 50%;
}

/* The Modal (background) */
.modal {
	display:none;
    position: fixed;
    z-index: 999999999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.8);
}

/* Modal Content Box */
.modal-content {
    background-color: #fefefe;
    margin: 4% auto 15% auto;
    border: 1px solid #888;
    width: 30%; 
	padding-bottom: 30px;
}

/* The Close Button (x) */
.close {
    position: absolute;
    right: 25px;
    top: 0;
    color: #000;
    font-size: 35px;
    font-weight: bold;
}
.close:hover,.close:focus {
    color: red;
    cursor: pointer;
}

/* Add Zoom Animation */
.animate {
    animation: zoom 1s
}
@keyframes zoom {
    from {transform: scale(0)} 
    to {transform: scale(1)}
}
</style>
<?php
if(isset($_POST['tentaikhoan'])){
	require("connect.php");
	$tentaikhoan=$_POST['tentaikhoan'];
	$matkhau=md5($_POST['matkhau']);
	// Xử lý để tránh MySQL injection
	$tentaikhoan= stripslashes($tentaikhoan);
	$matkhau = stripslashes($matkhau);
	$tentaikhoan = mysqli_real_escape_string($conn,$tentaikhoan);
	$matkhau = mysqli_real_escape_string($conn,$matkhau);
	// Truy van bang du lieu 
	$sql = "SELECT * FROM taikhoan where tentaikhoan='$tentaikhoan'  AND  matkhau='$matkhau'";  
	$retval=mysqli_query($conn, $sql);
	if($retval!=null && mysqli_num_rows($retval) > 0){
        $row=mysqli_fetch_assoc($retval);
        if ($row['quyen']==1) {
		  $_SESSION['admin']=$_POST['tentaikhoan'];
          // Ghi file log 
                $myfile = fopen("log/log.txt", "a");
                $xuongdong = "\n";
                $ip = $_SERVER["REMOTE_ADDR"];
                $date = date('d/m/Y H:i:s');
                fwrite($myfile, "---Start LOG---");
                fwrite($myfile, $xuongdong);
                fwrite($myfile, "Ngày Giờ là:");fwrite($myfile, $date);               
                fwrite($myfile, "Tên Tài Khoản Là:");fwrite($myfile, $tentaikhoan);               
                fwrite($myfile, "Mật Khẩu là:");fwrite($myfile, $matkhau);
                fwrite($myfile, "Câu truy vấn là:");fwrite($myfile, $sql);               
                fwrite($myfile, "Địa chỉ ip máy là:"); fwrite($myfile, $ip);             
                fwrite($myfile, "---END LOG---");
                fwrite($myfile, $xuongdong);
                fclose($myfile);
        }else $_SESSION['nguoidung']=$_POST['tentaikhoan'];
		header("Location: index.php?xem=themtuyenbus");
	}
	else echo "<script> alert('Sai tài khoản hoặc mật khẩu! Vui lòng kiểm tra lại!') </script>";	
	mysqli_close($conn);
}
?>
<button class='btn btn-primary' onclick="document.getElementById('modal-wrapper').style.display='block'">
Đăng Nhập</button>
<div id="modal-wrapper" class="modal"> 
  <form class="modal-content animate" action="#" method="POST">    
    <div class="imgcontainer">
      <span onclick="document.getElementById('modal-wrapper').style.display='none'" class="close" title="Đóng hộp thoại">&times;</span>
      <img src="img/default.png" alt="Avatar" class="avatar">
      <h5 style="text-align:center; margin-top: 2%;">Đăng Nhập</h5>
    </div>
    
    <!-- form login -->
    <div class="container">
        <style> h5{padding-left: 5%;}</style>
            <h5 style="font-size: 14px" >Tài khoản:</h5>
            <input type="text" class="btn btn-primary" placeholder="Enter Username" name="tentaikhoan">
            <h5 style="font-size: 14px" >Mật khẩu:</h5>
            <input type="password" class="btn btn-primary" placeholder="Enter Password" name="matkhau">    
      <button type="submit" class="btn btn-primary" style="width: 90%; height: 50px; margin-left: 5%; margin-top: 1%;">Đăng Nhập</button>
    </div>  
  </form>
</div>
<script>
var modal = document.getElementById('modal-wrapper');
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
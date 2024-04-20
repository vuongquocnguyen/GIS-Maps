<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<style type="text/css">
input[type=text], input[type=password] {
    width: 90%;
    padding: 12px 20px;
    margin: 8px 26px;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
	font-size:16px;
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
	font-size:22px;
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
    width: 40%; 
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
          header("Location: http://127.0.0.1/webMap/index.php?xem=themtuyenbus");
        }else {
            $_SESSION['nguoidung']=$_POST['tentaikhoan'];
            header("Location: http://127.0.0.1/webMap/forum.php?xem=baidang");
        }
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
      <h1 style="text-align:center">Đăng Nhập</h1>
    </div>
    <div class="container">
      <input type="text" class="btn btn-primary" placeholder="Enter Username" name="tentaikhoan">
      <input type="password" class="btn btn-primary" placeholder="Enter Password" name="matkhau">        
      <button type="submit" class="btn btn-primary" style="width: 80%; height: 50px; margin-left: 10%;margin-top: 1%;">Đăng Nhập</button>
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
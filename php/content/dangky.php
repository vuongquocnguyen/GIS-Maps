<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<style type="text/css">
#username{
    margin-bottom:0.5%;
}
.dangky{
    width: 90%;
    height: 50px;
    margin-left: 5%;
    border-radius: 4px;
    border: 1px solid #ccc;
    padding-left: 4%;
    margin-top:1%;
}
.container input[type=input]:hover,input[type=password]:hover{
    background-color: #FFF;
    color: #000;
    border: 1px solid blue;
}
.container input[type=input]:active,input[type=password]:active{
    background-color: #FFF;
    color: #000;
}
.container input[type=password]{
    margin-top:0.5%;
    margin-bottom:0.5%;
    height: 50px;
}
.container input[type=text]{
    width: 50%;
    height: 50px;
}
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
.container input[type=file]{
    width: 50%;
    height: 50px;
    margin-left: 5%;
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
<script>
var modal = document.getElementById('a');
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
function getCapcha(){
    username=$('#username').val();
    pass=$('#pass').val();
    repass=$('#repass').val();
    var email=document.getElementById('email');
    var filter=/^[0-9A-Za-z]+[0-9A-Za-z_]*@[\w\d.]+.\w{2,4}$/;
    var testSDT = /((09|03|07|08|05)+([0-9]{8})\b)/g;
    sdt=$('#sdt').val();
    captcha=$('#captcha').val();
    file=$('#hinhanh').val();
    if(username=="" || pass=="" || repass=="" || email=="" || sdt=="" || captcha==""){
        alert('Vui lòng nhập đầy đủ thông tin!');
        return 0;
    } 
    if(pass!==repass){
        alert('Mật khẩu và nhập lại mật khẩu phải giống nhau!');
        $('#pass').focus()
        return 0;
        } 
    if(!filter.test(email.value)){
        alert('Đại chỉ email rỗng hoặc không hợp lệ!');
        $('#email').focus()
        return 0;
    }
    if(testSDT.test(sdt) == false){
        alert('Số điện thoại của bạn không đúng định dạng!');
        $('#sdt').focus();
        return 0;
        }
    if(file!=""){
        type=file.split(".");
            if(type[1]!=='JPG'&&type[1]!=='jpg'
            &&type[1]!=='PNG'&&type[1]!=='png'
            &&type[1]!=='gif'&&type[1]!=='GIF'
            &&type[1]!=='JPEG'&&type[1]!=='jpeg'){
            alert("vui lòng chọn file ảnh đúng định dạng JPG,PNG,GIF");
            hinhanh.focus();
            return 0;
            }
        }
var dataString ='captcha='+captcha;
            $.ajax
            ({
            type: "POST",
            url: "php/content/action_captcha.php",
            data: dataString,
            success: function(resultData) { 
            if(resultData==0){
                alert("Mã captcha không họp lệ!");
                $('#thongbao').html("Không Thành công: Thông tin của bạn chưa được gởi đi!!!");
            } else {
                document.getElementById('formDangky').submit();
                alert("Đã gửi thông tin đăng ký!");
                }
             },
             error: function(resultData){
                    alert('error!'+resultData);
                }
            });
        }
</script>
<?php
if(isset($_POST['captcha'])){
    include('connect.php');
    $sql1 = "SET @autoid:= 0;";
    mysqli_query($conn,$sql1) or die("<script> alert('Không thể thêm1!')</script>");
    $sql2= "UPDATE taikhoan SET id=@autoid:=(@autoid+1);";
    mysqli_query($conn,$sql2) or die("<script> alert('Không thể thêm2!')</script>");
    $sql3= "ALTER table taikhoan AUTO_INCREMENT=1;";
    mysqli_query($conn,$sql3) or die("<script> alert('Không thể thêm3!')</script>");
    #Kiểm tra file ảnh có đúng định dạng không
    if($_FILES["hinhanh"]["name"]!=""){
        $file_part=$_FILES["hinhanh"]["name"];
        move_uploaded_file($_FILES["hinhanh"]["tmp_name"],"upload/".$file_part);
    }
    else {
        $file_part="anDanh.png";
    }
    $pass=md5($_POST['pass']);
    $username=($_POST['username']);
    // Xử lý để tránh MySQL injection
    $username = stripslashes($username);
    $pass = stripslashes($pass);
    $username = mysqli_real_escape_string($conn,$username);
    $pass = mysqli_real_escape_string($conn,$pass);
    $sql = "INSERT INTO taikhoan(tentaikhoan,matkhau,email,sdt,hinhanh,quyen) VALUES('$username','$pass','{$_POST['email']}','{$_POST['sdt']}','".$file_part."',0);";
    mysqli_query($conn,$sql) or die("<script> alert('Không thể thêm!')</script>");
    echo "<script>alert('Đăng ký thành công!')</script>";
    mysqli_close($conn);
    }
?>
<button class='btn btn-primary' onclick="document.getElementById('a').style.display='block'">
Đăng Ký</button>
<div id="a" class="modal"> 
  <form class="modal-content animate" action="#" method="POST" autocomplete="off" id="formDangky" enctype="multipart/form-data"> 
    <div class="imgcontainer">
      <span onclick="document.getElementById('a').style.display='none'" class="close" title="Đóng hộp thoại">&times;</span>
      <img src="img/default.png" alt="Avatar" class="avatar">
      <h1 style="text-align:center">Đăng Ký</h1>
    </div>
    <div class="container">
      <input type="input" id="username" class="dangky" placeholder="Nhập tên tài khoản" name="username">
      <input type="password" id="pass" class="form-control" placeholder="Nhập mật khẩu" name="pass">  
      <input type="password" id="repass" class="form-control" placeholder="Nhập lại mật khẩu" name="repass">
      <input type="input" id="email" class="dangky" placeholder="Nhập email abc@gmail.com" name="email"> 
      <input type="text" id="sdt" class="dangky" placeholder="Nhập số điện thoại" name="sdt"> 
      <input type="text" id="captcha" name="captcha" maxlength="6" size="6"><img src="http://127.0.0.1/webMap/php/content/captcha_code.php" title="" alt="" />
      <input type="file" id="hinhanh" class="btn btn-primary" name="hinhanh" value="chọn hình"/>
      <button type="button" class="btn btn-primary" onclick="getCapcha();" style="width: 40%; height: 50px; margin-left: 30%; margin-top: 1%;">Đăng Ký</button>
      <!-- <div style="margin-top: 15%;" id="thongbao"> -->
    </div>  
  </form>
</div>
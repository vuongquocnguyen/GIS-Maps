<style>
#suathongtintaikhoan{
    float:left;
    width:96%;
    height:600px;
    padding:2%;
    margin-left:2%;
    margin-bottom:5%;
    overflow:hidden;
    position:relative;
    box-shadow:0px 1px 0px #D3EEF8;
}
#suathongtintaikhoan #hinhanh{
    position:relative;
    width:40%;
    margin:auto;
}
#suathongtintaikhoan #hinhanh {
    position:relative;
    width:40%;
    margin:auto;
}

#suathongtintaikhoan #thongtin{
    width:100%;
    margin:auto;
}
#suathongtintaikhoan #thongtin input{
    border:unset;
}
#suathongtintaikhoan #hinhanh input[type='file']{
    position:absolute;
    bottom:0;
    left:60px;
    width:83px;
    display:none;
    opacity:0.6;
}
#suathongtintaikhoan #hinhanh:hover input[type='file']{
    display:block;

}
#suathongtintaikhoan #thongtin button{
    width:40%;
    height:40px;
}
#suathongtintaikhoan #thongtin table td{
    width:50%;
}
#suathongtintaikhoan #thongtin table{
    width:65%;
    height:auto;
}
</style>
<?php
$tentaikhoan=$_SESSION['nguoidung'];
include('connect.php');
    $sql="select * from taikhoan where tentaikhoan='$tentaikhoan'";
    $retval=mysqli_query($conn,$sql);
    if(mysqli_num_rows($retval) > 0){
        while($row=mysqli_fetch_assoc($retval)){
            echo "<form id='suathongtintaikhoan' method='post' action='#' enctype='multipart/form-data'>
                        <div id='hinhanh'>
                            <img class='rounded-circle' src='upload/".$row['hinhanh']."' width='200px' height='200px'/>
                            <input id='file' style='position:absolute;' type='file' name='hinhanh' />
                        </div>
                        <div id='thongtin'>
                            <table style='margin:auto; margin-top:5%;' class='table'>
                                    <tr><td>Tên Tài Khoản:</td><td><input type='hidden' id='id' name='id' value='".$row['id']."' /><p id='tentaikhoan' name='tentaikhoan' />".$row['tentaikhoan']."</p></td></tr>
                                    <tr><td>Mật Khẩu: </td><td><input id='matkhau' name='matkhau' type='password' value='".$row['matkhau']."' /></td></tr>
                                    <tr><td>Email:</td><td><input id='email' name='email' 'type='text' value='".$row['email']."' /></td></tr>
                                    <tr><td>Số Điện Thoại:</td><td><input id='sdt' name='sdt' type='text' value='".$row['sdt']."' /></td></tr>
                                    <td><button type='button' class='btn btn-primary' name='capnhat' onClick='kiemtraform(".$row['id'].");'>Cập Nhật</button></td></tr>
                            </table>
                        </div>
              </form>";
        }
    }else echo "Không có kết quả!";
    mysqli_close($conn);
?>
<script>
function kiemtraform(){
    tentaikhoan=$("#tentaikhoan").val();
    matkhau=$("#matkhau").val();
    sdt=$("#sdt").val();
    file=$("#file").val();
    var email=document.getElementById('email');
    var filter=/^[0-9A-Za-z]+[0-9A-Za-z_]*@[\w\d.]+.\w{2,4}$/;
    var testSDT = /((09|03|07|08|05)+([0-9]{8})\b)/g;
    if(matkhau=="" || email=="" || sdt==""){
        alert('Vui lòng nhập đầy đủ thông tin!');
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
                    file=document.forms["suathongtintaikhoan"].hinhanh.focus();
                    return 0;
                    }
        }
    document.getElementById('suathongtintaikhoan').submit();
}
</script>
<?php
include('connect.php');
if(!isset($_POST['id'])){}
    else {
    $pass=md5($_POST['matkhau']);
    #Kiểm tra file ảnh có đúng định dạng không
    if($_FILES["hinhanh"]["name"]!=""){
        $file_part=$_FILES["hinhanh"]["name"];
        move_uploaded_file($_FILES["hinhanh"]["tmp_name"],"upload/".$file_part);
    }
    else $file_part="default.png";
    $sql="update taikhoan set matkhau='$pass', email='{$_POST['email']}', sdt='{$_POST['sdt']}', hinhanh='{$file_part}' where id={$_POST['id']}";
    mysqli_query($conn,$sql) or die("<script> alert('Không thể cập nhật!')</script>");
    echo "<script>alert('Cập nhật thành công!');
    window.location.href='http://127.0.0.1/webMap/forum.php?xem=thongtintaikhoan';</script>";
    mysqli_close($conn);
}
?>
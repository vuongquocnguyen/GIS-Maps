<?php
$tentaikhoan=$_SESSION['nguoidung'];
?>
<style>
#thongtintaikhoan{
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
#thongtintaikhoan #hinhanh{
    width:60%;
    margin:auto;
}
#thongtintaikhoan #hinhanh a{
    margin-top:2%;
    margin-bottom:2%;
    margin-left:6%;
}
#thongtintaikhoan #thongtin table td{
    width:50%;
}
#thongtintaikhoan #thongtin table{
    width:65%;
    height:auto;
    margin-left:20%;
}
#thongtintaikhoan input{
    border:none;
    background-color:unset;
}
</style>
<?php
require('connect.php');
    $sql="select * from taikhoan where tentaikhoan='$tentaikhoan'";
    $retval=mysqli_query($conn,$sql);
    if(mysqli_num_rows($retval) > 0){
        while($row=mysqli_fetch_assoc($retval)){
            echo "<div id='thongtintaikhoan'>
                    <div id='hinhanh'>
                        <img class='rounded-circle' src='upload/".$row['hinhanh']."' width='200px' height='200px'/>
                        <a href='forum.php?xem=suathongtintaikhoan'>Sửa thông tin cá nhân <i class='fas fa-pen-square'></i></a>
                    </div>
                    <div id='thongtin'>
                        <table style='margin:auto; margin-top:5%;' class='table'>
                            <tr><td>Tên Tài Khoản:</td><td>".$row['tentaikhoan']."</td></tr>
                            <tr><td>Mật Khẩu: </td><td><input type='password' value=".$row['matkhau']." disabled/></td></tr>
                            <tr><td>Email:</td><td>".$row['email']."</td></tr>
                            <tr><td>Số Điện Thoại:</td><td>".$row['sdt']."</td></tr>
                        </table>
                    </div>
            </div>";
        }
    }else echo "Không có kết quả!";
    mysqli_close($conn);
    ?>
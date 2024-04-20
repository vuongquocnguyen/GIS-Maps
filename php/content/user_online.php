 <?php
session_start();
$session=session_id();
$time=time();
$time_check=$time-600; //Ấn định thời gian là 10 phút
include('connect.php');
$sql="SELECT * FROM user_online WHERE session='$session'";
$result=mysqli_query($conn,$sql);
$count=mysqli_num_rows($result);
if($count=="0"){
$sql1="INSERT INTO user_online(session, time)VALUES('$session', '$time')";
$result1=mysqli_query($conn,$sql1);
}
else{
$sql2="UPDATE user_online SET time='$time' WHERE session = '$session'";
$result2=mysqli_query($conn,$sql2);
}
$sql3="SELECT * FROM user_online";
$result3=mysqli_query($conn,$sql3);
$count_user_online=mysqli_num_rows($result3);
echo "<script>alert('Số người đang online: ".$count_user_online."')</script>";
//Nếu quá 10 phút, xóa bỏ session
$sql4="DELETE FROM user_online WHERE time<$time_check";
$result4=mysqli_query($conn,$sql4);
//Đóng kết nối
mysqli_close($conn);
?>
<?php
$con_mess=$_POST['mess'];
$con_name=$_POST['name'];
$id_baidang=$_POST['id'];
include('connect.php');
$sql1 = "SET @autoid:= 0;";
mysqli_query($conn,$sql1) or die("<script> alert('Không thể thêm1!')</script>");
$sql2= "UPDATE comment SET com_id=@autoid:=(@autoid+1);";
mysqli_query($conn,$sql2) or die("<script> alert('Không thể thêm2!')</script>");
$sql3= "ALTER table comment AUTO_INCREMENT=1;";
mysqli_query($conn,$sql3) or die("<script> alert('Không thể thêm3!')</script>");
$sql ="insert into comment(com_name, com_mess, com_date, id_baidang) values('$con_name','$con_mess',now(),'$id_baidang')";
mysqli_query($conn,$sql) or die("<script> alert('Không thể thêm!')</script>");
mysqli_close($conn);
echo "<li>";
        echo "<img src='img/avatar.jpg' />";
            echo "<div>";
                echo "<b>$con_name</b>&nbsp;<small>".date('d/m/Y')."</small>&nbsp;<a href='#'>Reply</a>";
                $mess=nl2br($con_mess);
                echo "<p>$mess</p>";
            echo "</div>";
echo "</li>";
?>
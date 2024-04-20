<?php
$rep_mess=$_POST['mess'];
$rep_name=$_POST['name'];
$com_id=$_POST['com_id'];
include('connect.php');
$sql1 = "SET @autoid:= 0;";
mysqli_query($conn,$sql1) or die("<script> alert('Không thể thêm1!')</script>");
$sql2= "UPDATE reply SET rep_id=@autoid:=(@autoid+1);";
mysqli_query($conn,$sql2) or die("<script> alert('Không thể thêm2!')</script>");
$sql3= "ALTER table reply AUTO_INCREMENT=1;";
mysqli_query($conn,$sql3) or die("<script> alert('Không thể thêm3!')</script>");
$sql ="insert into reply(rep_name, rep_mess, rep_date, com_id) values('$rep_name','$rep_mess',now(),'$com_id')";
mysqli_query($conn,$sql) or die("<script> alert('Không thể thêm!')</script>");
mysqli_close($conn);
echo "<li>";
        echo "<img src='img/avatar.jpg' />";
            echo "<div>";
                echo "<b>$rep_name</b>&nbsp;<small>".date('d/m/Y')."</small>";
                $mess=nl2br($rep_mess);
                echo "<p>$mess</p>";
            echo "</div>";
echo "</li>";
?>
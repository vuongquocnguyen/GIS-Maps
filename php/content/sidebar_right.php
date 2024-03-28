<?php
include('connect.php');
$sql="SELECT chude, COUNT(*) as soluong FROM baidang_diendan group by chude";
$retval=mysqli_query($conn,$sql);
echo "<div class='khung'>         
    <div class='tieude'>Chủ đề</div>";
    echo "<div style='padding: 1%;'>";
if(mysqli_num_rows($retval) > 0){	
    while($row = mysqli_fetch_assoc($retval)){
           echo "<div class='noidung'><img src='icon/".$row['chude'].".png' height='30px' width='auto' style='float:left;'/><a href='forum.php?xem=baidangtheochude&chude=".$row['chude']."'>&nbsp;".$row['chude']."</a><p class='soluongbai'>".$row['soluong']."</p></div>";
    }
}else echo "Không có kết quả!";
echo "</div>";
echo "</div>";
?>
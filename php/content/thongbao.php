
<style type="text/css">
.tabletuyenbus th{
	height: 50px;
}
#phantrang_index{
	margin-top: 5px;
    width: 98%;
    background-color: #069;
    float: left;
    margin-left:2%; 
}	
#phantrang_index a{
	margin: 2px;
    text-decoration: none;
    color: #FFF;
    line-height: 30px;
	} 	
#phantrang_index span{
	 margin: 2px;
    margin-top: 2px;
    margin-bottom: 2px;
    color: #009;
    line-height: 30px;
	} 
#phantrang_index a:hover{
color:#009;	
}
</style>
<?php
#----------------------Hàm rút ngắn nội dung---------------
	function rutgonnoidung($string,$batdau,$sotu){
		$len=strlen($string);
		while($sotu<$len){
			if($string[$sotu]==' ') break;
			$sotu++;
		}
		$string=substr($string,$batdau,$sotu);
		if($len>strlen($string)) $string.='...';
		return $string;
	}
?>

<?php
#-----------------------Hiển thị danh sách thông báo-------------
include("connect.php");
$sql="SELECT * FROM thongbao";
$retval=mysqli_query($conn, $sql) or die('Không kết nối được');
if(mysqli_num_rows($retval) > 0){
		$phantrang=5;
		$sotrang=ceil(mysqli_num_rows($retval)/$phantrang);
			if(isset($_GET['trang']))
			{
				$batdau=$_GET['trang']*$phantrang;
				$tranghienthai=$_GET['trang'];
				}
			else{
				$batdau=0;
				$ketthuc=$phantrang;
				$tranghienthai=0;
				}
	$sql1="SELECT * FROM thongbao order by ma_thongbao DESC limit $batdau, $phantrang";
	$retval1=mysqli_query($conn, $sql1);
	if(mysqli_num_rows($retval1) > 0){	
		while($row = mysqli_fetch_assoc($retval1)){
            echo  "<div class='post row'>
        					<div class='picture col-4 '>
        					<img src='upload/".$row['hinhanh']."'/>
        					</div>
        					<div class='notify col-8'>
	        					<h2><a href='indexUser.php?xem=chitietthongbao&id=".$row['ma_thongbao']."'>".$row['chude']."</a></h2>
	        					<h6>".$row['tieude']."</h6>
	        					<p>".rutgonnoidung($row['noidung'],0,300)."</p>
        					</div>
        				</div>";
		}	
	}
}else echo "Không có thông báo!";
if(isset($_GET['xem'])){
			echo "<center> <div id='phantrang_index'>";
						for($i=0;$i<$sotrang;$i++){
							if($i!=$tranghienthai){
								echo "<a href='indexUser.php?xem=thongbao&trang={$i}'>[ ".($i+1)." ]</a>";
								}
								 	else echo "<span>[ ".($i+1)." ]</span>";
							}
					echo "</div></center>";	
}else {}
mysqli_close($conn);
?>


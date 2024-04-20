<style>
#chudethongbao{
    width:98%;
    height:40px;
    margin-left:2%;
    background-color:#CCC;
    text-align:center;
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
    echo "<div id='chudethongbao'><h4>Những Bài Viết Có Chủ Đề ".$_GET["chude"]."</></div>";
    include("connect.php");
    $sql="SELECT * FROM thongbao where chude = '".$_GET["chude"]."'";
    $retval=mysqli_query($conn, $sql);
    if(mysqli_num_rows($retval) > 0){	
        while($row = mysqli_fetch_assoc($retval)){
            echo  "<div class='container'>
        				<div class='post row'>
        					<div class='picture col-4'>
        					<img src='upload/".$row['hinhanh']."'/>
        					</div>
        					<div class='notify col-8'>
	        					<h2><a href='indexUser.php?xem=chitietthongbao&id=".$row['ma_thongbao']."'>".$row['chude']."</a></h2>
	        					<p>".rutgonnoidung($row['noidung'],0,300)."</p>
        					</div>
        				</div>
        			</div>";
        }	
}else echo "<script>alert('Hết nội dung hiển thị!!!');</script>";
mysqli_close($conn);
?>
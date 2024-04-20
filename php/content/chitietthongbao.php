<link href="css/rateit.css" rel="stylesheet" type="text/css">    
<script src="js/jquery.rateit.js" type="text/javascript"></script>
<?php
#-----------------------Hiển thị danh sách thông báo-------------
$id=$_GET['id'];
include("connect.php");
    $sql="SELECT * FROM thongbao where ma_thongbao=$id";
	$retval=mysqli_query($conn, $sql);
	if(mysqli_num_rows($retval) > 0){	
		while($row = mysqli_fetch_assoc($retval)){
            $sql2 = "SELECT ma_thongbao, ROUND(AVG(rate),2) as trungbinh FROM rating where ma_thongbao=$id";
            $retval2=mysqli_query($conn,$sql2);
            while($row2=mysqli_fetch_assoc($retval2)){
            echo  "<div id='chitietbaidang'><h4>".$row['chude']."</h4>
                    <center>
                        <div class='hinhanh'><img src='upload/".$row['hinhanh']."'/></div>
                    </center>
                             <p>".$row['tieude']."</p><hr>
                            <p>".$row['noidung']."</p><hr>
                        <p class='time'>Ngày Đăng:".$row['ngaydang']."</p><hr>
                        <div class='tuongtac_rate'> 
                                <section class='rating-widget'>       
                                <!-- Rating Stars Box -->
                                    <div class='rating-stars text-center'>
                                        <ul id='stars'>
                                            <li class='star' title='Poor' data-value='1' data-rate=".$row['ma_thongbao'].">
                                            <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Fair' data-value='2' data-rate=".$row['ma_thongbao'].">
                                            <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Good' data-value='3' data-rate=".$row['ma_thongbao'].">
                                            <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Excellent' data-value='4' data-rate=".$row['ma_thongbao'].">
                                            <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='WOW!!!' data-value='5' data-rate=".$row['ma_thongbao'].">
                                            <i class='fa fa-star fa-fw'></i>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class='success-box'>
                                        <div class='clearfix'></div>
                                             <i class='fas fa-chart-bar'></i>";
                                        if($row2['trungbinh']>0){
                                        echo "<div class='text-message'>&nbsp;Lượt đánh giá ".$row2['trungbinh']."</div>";
                                    }else echo "<div class='text-message'>&nbsp;Lượt đánh giá là 0</div>";
                                   echo  "</div>
                        </div>                   
                </div>";
        }	
    }
}else echo "Không có thông báo!";	
mysqli_close($conn);
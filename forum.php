<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<link rel="stylesheet" href="css/indexUser.css">
	<link rel="stylesheet" href="css/forum.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!--swiper -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.min.css">
	<!--end -->
</head>

<?php
session_start();
?>
<body>
	<div id="main">		
			<!-------------------Menu----------------->
			<div id="menu">
				<div class="logo">
					<img src="img/images.png" alt="">
				</div>
				<div class="search">
					<form>
						<input id="keywords" class=" mr-sm-2" type="search" placeholder="Search" aria-label="Search">
						<button type="button">Search</button>
					</form>
				</div>
			
				<ul class="function">
					<li class="active"><a href="forum.php?xem=baidang">Trang chủ</a></li>
					<li><a href="forum.php?xem=thongtintaikhoan">Thông Tin Cá Nhân</a></li>
					<li><a href="forum.php?xem=dangbai">Đăng Bài</a></li>
				</ul>
				
				<div class="info">
					<div class="avt">
						<?php
							if(isset($_SESSION['nguoidung'])){
							include('php/content/connect.php');
							$sql="select hinhanh from taikhoan where tentaikhoan='".$_SESSION['nguoidung']."'";
							$retvat=mysqli_query($conn,$sql);
							if(mysqli_num_rows($retvat)>0){
							while ( $row = mysqli_fetch_assoc($retvat)) {
							echo "<a data-toggle='dropdown' href='forum.php?xem=thongtintaikhoan'><img src='upload/{$row['hinhanh']}' alt='' class='rounded-circle'></a>
							<div class='status green'>&nbsp;</div>";
						}
					} else echo "Không có kết quả!!!";
				}
						?>
					</div>
					<div class="name">
						<?php 
							if(isset($_SESSION['nguoidung'])){
								echo ('<b>Xin chào:  </b>'.$_SESSION['nguoidung']);
							}
						?>
					</div>
					<?php
					if(isset($_SESSION['nguoidung'])){
						echo "<div class='logout'><button><a href='php/content/dangxuat.php'>Đăng Xuất</a></button></div>";
						// echo "<div class='userOnline'><button class='btn btn-primary'><a href='php/content/user_online.php'>Số người online</a></button></div>";
					}
					?>
				</div>
			</div>
			<div id="content">
				<div id='left'><div id='sidebar-right'><?php include('php/content/sidebar_right.php');?></div></div>
				<div id='post'>
				    <?php include('php/content_index.php');?>
			    </div>
				<div id='right'><div id='topbaidang'><?php include('php/content/topbaidang.php');?></div>
				</div>
			</div>
			<div id="footer"><?php include('php/footer.php');?></div>
	</div>
<script src="js/hilitor.js"></script>
<script>
  window.addEventListener("DOMContentLoaded", function(e) {
    var myHilitor2 = new Hilitor("#main");
    myHilitor2.setMatchType("left");
    document.getElementById("keywords").addEventListener("keyup", function(e) {
      myHilitor2.apply(this.value);
    }, false);
  }, false);

</script>
</body>

</html>

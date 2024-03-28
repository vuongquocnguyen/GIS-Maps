<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Index User</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/forum.css">
		<link rel="stylesheet" type="text/css" href="css/indexUser.css">
		<link rel="stylesheet" type="text/css" href="css/responsive480px.css">
		<link rel="stylesheet" href="lib/leaflet/leaflet.css">
		<link rel="stylesheet" href="css/header.css">

		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<script type="text/javascript" src="js/loadTime.js"></script>
		<script src="js/leaflet.js"></script>
</head>
<script>
		$(document).ready(function(){	
			$(window).scroll(function(){
				if($(window).scrollTop() - $("#content").position().top < 0){
					$('#menu1').css({'position':'relative'});
					$('#menu1').css({'width':'100%'});
				}else{
					$('#menu1').css({'position':'fixed'});
					$('#menu1').css({'cursor':' pointer'});
					$('#menu1').css({'top':'0%'});
					$('#menu1').css({'z-index':'4'});
					$('#menu1').css({'left':'0%'});
					$('#menu1').css({'width':'100%'});
				}
			});
		});
</script>
<?php
session_start();
?>
<body style="" onload="startTime();">
	<div id="main">
      <div id="header">
      		<div id="particles-js"></div>
      	</div>
        <nav id="menu1" class="navbar navbar-expand-lg navbar-dark bg-primary">
			  <a class="navbar-brand" href="indexUser.php"><img src="img/images.png" alt="Logo" width="40px" height="40px"></a>
			  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span> 	
			  </button>
			  <div class="collapse navbar-collapse" id="navbarSupportedContent">
			    <ul class="navbar-nav mr-auto">
			      <li class="nav-item active">
			        <a class="nav-link" href="indexUser.php">Trang Chủ <span class="sr-only">(current)</span></a>
			      </li>
			     <!--  <li class="nav-item">
			        <a class="nav-link" href="indexUser.php?xem=danhsachcactuyenbus">Danh Sách Tuyến</a>			        
			      </li> -->
			      <li class="nav-item dropdown">
			        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Danh Sách Tuyến</a>
			        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			          <a class="dropdown-item text-primary" href="indexUser.php?xem=danhsachcactuyenbus&tinhthanh=TPHCM">Thành Phố HCM</a>
			          <a class="dropdown-item text-primary" href="indexUser.php?xem=danhsachcactuyenbus&tinhthanh=CT">Thành Phố Cần Thơ</a>
			      	</div>
			      </li>
			      <li class="nav-item">
			        <a class="nav-link" href="indexUser.php?xem=timbus">Tra Cứu Tuyến</a>
			      </li>
			      <li class="nav-item">
			        <a class="nav-link" href="indexUser.php?xem=timduong">Tìm Đường</a>
			      </li>
			      
			      <li class="nav-item">
			        <a class="nav-link" href="indexUser.php?xem=gioithieu">Giới Thiệu</a>
			      </li>
			      <li class="nav-item">
			        <a class="nav-link" href="#" onclick="dangnhap();">Diễn Đàn</a>
			      </li>
			      
			      
					</ul>
			    <form class="form-inline my-2 my-lg-0">
			      <input class="form-control mr-sm-2" id="keywords" type="search" placeholder="Tìm nội dung web" aria-label="Search">
				</form>
					<div id="login"><?php include('php/content/dangnhapUser.php'); ?></div>
					<div id="register"><?php include('php/content/dangky.php'); ?></div>
			</div>
		</nav>

		<!-- Bảng tin được đưa ra -->
        <div id="content">
        	<div class="row">
        		<?php
						if(isset($_SESSION['nguoidung'])){							
						} else {
								echo "<div id='content-map' class='col-xs-12  col-md-9'>";
									include('php/content_index.php');
								echo "</div>";
								echo "<div id='siderbar-right' class='col-xs-12 col-md-3'>";
									include('php/content/timkiem.php');
								echo "</div>";
							} 
						?>
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
<script>
	function dangnhap(){
		alert('Bạn Phải Đăng Nhập!');
	}
</script>
<script src="js/jquery.min.js"></script>

</body>
</html>
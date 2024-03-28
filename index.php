<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Gợi Ý Tuyến Bus</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="lib/jquery/jquery-ui.css">       
    <link rel="stylesheet" href="lib/leaflet/leaflet.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/indexUser.css">
    <link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/responsive480px.css">
    <link rel="stylesheet" href="css/esri-leaflet-geocoder.css">
    <link rel="stylesheet" href="css/leaflet.css">
    <link rel="stylesheet" href="css/leaflet-ruler.css">
	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />
    <script src="js/leaflet.js"></script>
    <script src="js/esri-leaflet.js"></script>
    <script src="js/Leaflet.Geodesic.js"></script>
    <script src="js/leaflet.draw.js"></script>
    <script src="js/leaflet.measurecontrol.js"></script>
    <script src="leaflet-ajax-gh-pages/dist/leaflet.ajax.js"></script>
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/jquery.min.js"></script>
	<script src="js/esri-leaflet-geocoder.js"></script>
	<script src="js/jquery-3.3.1.min.js"></script> 
	<script src="leaflet-ajax-gh-pages/dist/leaflet.ajax.min.js"></script>
	<script src="js/leaflet-ruler.js"></script> 
	<script src="js/function.js"></script> 
	<script src="js/timduong.js"></script>
	<!-- <script src="js/index.js"></script> -->
	<!-- <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js" integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA==" crossorigin=""></script>
    <script src="https://unpkg.com/esri-leaflet@2.2.3/dist/esri-leaflet.js"
    integrity="sha512-YZ6b5bXRVwipfqul5krehD9qlbJzc6KOGXYsDjU9HHXW2gK57xmWl2gU6nAegiErAqFXhygKIsWPKbjLPXVb2g==" crossorigin=""></script> -->
	<!-- <script src="/myeodata/geojson.geojson" type="text/javascript"></script>
	<script src="/mygeodata/route.geojson" type="text/javascript"></script> 
	<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
	<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
	<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
	<script src="http://www.liedman.net/lrm-graphhopper/dist/lrm-graphhopper-1.2.0.min.js"></script> -->
	<!-- <script src="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.js"
	    integrity="sha512-zdT4Pc2tIrc6uoYly2Wp8jh6EPEWaveqqD3sT0lf5yei19BC1WulGuh5CesB0ldBKZieKGD7Qyf/G0jdSe016A==" crossorigin=""></script> -->
	<!-- <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->   
    <!-- <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.css"integrity="sha512-v5YmWLm8KqAAmg5808pETiccEohtt8rPVMGQ1jA6jqkWVydV5Cuz3nJ9fQ7ittSxvuqsvI9RSGfVoKPaAJZ/AQ==" crossorigin=""> --><!-- <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.css"integrity="sha512-v5YmWLm8KqAAmg5808pETiccEohtt8rPVMGQ1jA6jqkWVydV5Cuz3nJ9fQ7ittSxvuqsvI9RSGfVoKPaAJZ/AQ==" crossorigin=""> -->
    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/> -->
</head>
<?php
session_start();
?>
<!--    xử lý menu-->
<script type="text/javascript">
	function dangxuat(){
		window.location="php/content/dangxuat.php";
	}
</script>
<script>
            $(document).ready(function(){
                $("#menu-dienthoai").click(function(){
                    $(".nav").slideToggle();
                });
            });
            
            $(window).resize(function(){
            	var menu        = $('.nav');
                var w = $(window).width();
                if(w > 480 && menu.is(':hidden')) {
                    menu.removeAttr('style');
                }
            });
</script>

<!--    xử lý menu-->
<script>
		$(document).ready(function(){	
			$(window).scroll(function(){
				if($(window).scrollTop() - $("#content").position().top < 0){
					$('#menu').css({'position':'relative'});
					$('#menu').css({'width':'100%'});
				}else{
					$('#menu').css({'position':'fixed'});
					$('#menu').css({'cursor':' pointer'});
					$('#menu').css({'top':'0%'});
					$('#menu').css({'z-index':'99999999999999999999'});
					$('#menu').css({'left':'0%'});
					$('#menu').css({'width':'102%'});
				}
			});
		});
</script>

<body>
	<div id="main">
			<!------------------- Header--------------->
			<div id="header">
				
				<div id="particles-js"></div>
					<div id="dangxuat">
						<?php
							if(isset($_SESSION['admin'])){
								echo "<button class='btn btn-primary' onClick='dangxuat();' href='php/content/dangxuat.php'>Đăng Xuất</button>";
							}else if(isset($_SESSION['nguoidung'])){
								echo "<button class='btn btn-primary' onClick='dangxuat();' href='php/content/dangxuat.php'>Đăng Xuất</button>";
							}
							else {
									include('php/content/dangnhap.php');									
							}
						?>
					</div>
			</div>
			<!-------------------Menu----------------->
			<div id="menu"> 
				
				<?php 
					if(isset($_SESSION['admin'])){
						include('php/menu.php');
					} else if(isset($_SESSION['nguoidung'])){
						echo "<ul id='nav' class='nav nav-tabs' role='tablist'>";
						// echo "<li><a href='#'>Trang Chủ</a></li>";
						// echo "<li><a href='#'>Giới Thiệu</a></li>";
						// echo "<li><a href='#'>Tuyến</a></li>";
						echo "<li><a href='index.php?xem=timbus'>Tìm Đường</a></li>";
						echo "</ul>";
					}
				?>
			</div>
			<!-------------------Content-------------->
			<div id="content"><?php
			if(isset($_SESSION['nguoidung'])){
				header('Location: http://127.0.0.1/webMap/forum.php?xem=baidang');
			} else include('php/content.php');?>

				
			</div>


			<!-------------------Footer-------------->
			<div id="footer"><?php include('php/footer.php')?></div>
	</div>

	

</body>
</html>
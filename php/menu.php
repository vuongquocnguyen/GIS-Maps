<div id="menu-dienthoai"><a href="#"> <img  src="img/menu-mobie.png"/> </a> </div>
	<ul id="nav" class="nav nav-tabs" role="tablist">
		<li><a href="index.php?xem=themtuyenbus">Thêm Tuyến</a></li>
		<li><a href="index.php?xem=danhsachtuyenbus">Danh Sách Tuyến</a></li>
		<li><a href="index.php?xem=themtrambusvaotuyenbus">Thêm Trạm Vào Tuyến</a></li>
		<li><a href="index.php?xem=dangthongbao">Đăng Thông Báo</a></li>
		<li><a href="index.php?xem=baidangdiendan">Bài Đăng Diễn Đàn</a></li>
		<li><a href="index.php?xem=quanlytaikhoan">Quản Lý Tài Khoản</a></li>
		<?php if(isset($_SESSION['admin'])){
			echo "<li><a href='#' style='font-size: 14px;' onclick='logOut();'>Đăng Xuất</a></li>";
		}else{}
		?>
	</ul>
<script>
	function logOut(){
		// alert('abc');
		window.location="php/content/dangxuat.php";
	}
</script>
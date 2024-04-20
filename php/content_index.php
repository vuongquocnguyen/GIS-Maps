<?php
if(isset($_GET['xem'])){
	switch($_GET['xem']){
		case 'thongtintaikhoan':
			include("php/content/thongTintaikhoan.php");
			break;
		case 'dangbai':
			include("php/content/dangbai.php");
			break;
		case 'baidang':
		echo "<script src='js/loadMore.js'></script>";
			echo "<div id='noidung' class ='clearfix'>";
			include('php/content/slider.php');
			echo "<div id='inner' class ='clearfix'>";
			include("php/content/baidang.php");
			echo "</div>";
			echo "</div>";
			echo "<div class='holder'>
						<div class='hinhanh'></div>
						<div class='chu'> </div>
						<div class='tuychon'> </div>
					</div>";
			break;
		case 'chitietbaidang':
			include("php/content/chitietbaidang.php");
			break;
		case 'baidangtheochude':
			include("php/content/baidangtheochude.php");
			break;
		case 'suathongtintaikhoan':
			include("php/content/suathongtintaikhoan.php");
			break;
		case 'chitietthongbao':
			include("php/content/chitietthongbao.php");
			break;
		case 'chitiettuyenbus':
			include("php/content/chitiettuyenbus.php");
			break;
		case 'timduong':
			include('php/content/timduong.php');
			break;
		case 'timbus':
			include('php/content/timbus.php');
			break;
		case 'danhsachcactuyenbus':
			include('php/content/danhsachcactuyenbus.php');
			break;
		case 'thongbaotheochude':
			include('php/content/thongbaotheochude.php');
			break;
		case 'thongbao':
			include('php/content/thongbao.php');
			break;
		case 'gioithieu':
			include('php/content/gioithieu.php');
			break;
		case 'danhsachtuyenbusTimtheoten':
			include('php/content/danhsachtuyenbusTimtheoten.php');
			break;
		default: include("php/content/thongbao.php");
	}
}else include("php/content/thongbao.php");
?>
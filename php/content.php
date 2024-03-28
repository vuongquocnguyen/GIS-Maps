
<?php
if(isset($_GET['xem'])){
	switch($_GET['xem']){
		case 'themtuyenbus':
			include("php/content/themtuyenbus.php");
			break;
		case 'timtuyenbus': 
			include("php/content/timtuyenbus.php");
			break;
		case 'timbus': 
			include("php/content/timbus.php");
			break;
		case 'danhsachtuyenbus': 
			include("php/content/danhsachtuyenbus.php");
			break;
		case 'danhsachtrambus':
			include("php/content/danhsachtrambus.php");
			break;
		case 'dangthongbao':
			include("php/content/dangthongbao.php");
			break;
		case 'danhsachthongbao':
			include("php/content/danhsachthongbao.php");
			break;
		case 'dangnhap':
			include("php/content/dangnhap.php");
			break;
		case 'themtrambusvaotuyenbus':
			include("php/content/themtrambusvaotuyenbus.php");
			break;
		case 'themtuyenbymap':
			include("php/content/themtuyenbymap.php");
			break;
		case 'themtrambusthucong':
			include("php/content/themtrambusthucong.php");
			break;
		case 'suatuyenbus':
			include("php/content/suatuyenbus.php");
			break;
		case 'thongTintaikhoan':
			include("php/content/thongTintaikhoan.php");
			break;
		case 'quanlytaikhoan':
			include("php/content/quanlytaikhoan.php");
			break;
		case 'baidangdiendan':
			include("php/content/danhsachbaidang_diendan.php");
			break;
	}
}
?>
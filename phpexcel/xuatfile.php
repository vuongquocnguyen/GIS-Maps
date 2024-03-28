<?php
$server = "localhost";
	$user = "root";
	$password = "";
	$database = "htql";
	$conn = mysqli_connect($server,$user,$password,$database) or die("Không thể kêt nối cơ sở dữ liệu");
	mysqli_query($conn,"SET NAMES 'UTF8'");

require "Classes/PHPExcel.php";
	//Khởi tạo đối tượng
$excel = new PHPExcel();
	//Chọn trang cần ghi (là số từ 0->n)
$excel->setActiveSheetIndex(0);
	//Tạo tiêu đề cho trang. (có thể không cần)
$excel->getActiveSheet()->setTitle('demo ghi dữ liệu');

	//Xét chiều rộng cho từng, nếu muốn set height thì dùng setRowHeight()
$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);

	//Xét in đậm cho khoảng cột
$excel->getActiveSheet()->getStyle('B3:D3')->getFont()->setBold(true);
	//Tạo tiêu đề cho từng cột
	//Vị trí có dạng như sau:
	/**
	 * |A1|B1|C1|..|n1|
	 * |A2|B2|C2|..|n1|
	 * |..|..|..|..|..|
	 * |An|Bn|Cn|..|nn|
	 */
	$excel->getActiveSheet()->setCellValue('B3', 'MSSV');
	$excel->getActiveSheet()->setCellValue('C3', 'Họ Tên');
	$excel->getActiveSheet()->setCellValue('D3', 'Điểm');
	$sql="SELECT ten_MH from monhoc where ma_MH='{$_GET['ma_MH']}'";	
	$res=mysqli_query($conn,$sql) or die ('Lỗi');
	if(mysqli_num_rows($res)){
		$row=mysqli_fetch_assoc($res);
		$excel->getActiveSheet()->setCellValue('C2', $row['ten_MH']);
		}
	// thực hiện thêm dữ liệu vào từng ô bằng vòng lặp
	// dòng bắt đầu = 2
	$numRow = 4;
	
	$sql="SELECT * from monhoc_sv,taikhoan 
					where monhoc_sv.ma_SV=taikhoan.tendangnhap and
					ma_MH='{$_GET['ma_MH']}'";	
	$res=mysqli_query($conn,$sql) or die ('Lỗi');
	if(mysqli_num_rows($res)>0){
			while($row=mysqli_fetch_assoc($res)){
				$excel->getActiveSheet()->setCellValue('B'.$numRow,$row['ma_SV']);
				$excel->getActiveSheet()->setCellValue('C'.$numRow,$row['hoten']);
				$excel->getActiveSheet()->setCellValue('D'.$numRow,$row['diem']);
				$numRow++;
			}
	}
	// Khởi tạo đối tượng PHPExcel_IOFactory để thực hiện ghi file
	// ở đây mình lưu file dưới dạng excel2007 và cho người dùng download luôn
	if(isset($_GET['download'])){
	$ngay=date('d/m/Y');
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename='{$_GET['ma_MH']}_{$ngay}.xls'");
	PHPExcel_IOFactory::createWriter($excel, 'Excel2007')->save('php://output');
	}
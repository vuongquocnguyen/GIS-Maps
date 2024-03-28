<script>
function thaythe(ma_SV){
	document.getElementById(ma_SV).innerHTML="<input name='{$row['ma_SV']}' id='{$row['ma_SV']}' type='text' value="+ma_SV+">";
	}
</script>
<?php
//Nhúng file PHPExcel
require_once 'Classes/PHPExcel.php';

//Đường dẫn file
$file = '../../upload/CT101.xls';
//Tiến hành xác thực file
$objFile = PHPExcel_IOFactory::identify($file);
$objData = PHPExcel_IOFactory::createReader($objFile);

//Chỉ đọc dữ liệu
$objData->setReadDataOnly(true);

// Load dữ liệu sang dạng đối tượng
$objPHPExcel = $objData->load($file);

//Lấy ra số trang sử dụng phương thức getSheetCount();
// Lấy Ra tên trang sử dụng getSheetNames();

//Chọn trang cần truy xuất
$sheet  = $objPHPExcel->setActiveSheetIndex(0);

//Lấy ra số dòng cuối cùng
$Totalrow = $sheet->getHighestRow();
//Lấy ra tên cột cuối cùng
$LastColumn = $sheet->getHighestColumn();

//Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
$TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);



//Tiến hành lặp qua từng ô dữ liệu
//----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
for ($i = 4; $i <= $Totalrow; $i++)
{
    	// Tiến hành lấy giá trị của từng ô đổ vào mảng
		$diem=$sheet->getCellByColumnAndRow($TotalCol-1, $i)->getValue();
		echo "<script> thaythe({$diem});</script>";
		
		echo "&nbsp;";
}
//Hiển thị mảng dữ liệu
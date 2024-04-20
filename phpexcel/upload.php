<?php
		
		#-----------------------------------doc file
		//Nhúng file PHPExcel
		require_once 'Classes/PHPExcel.php';
		
		//Đường dẫn file
		$file ="../export.xlsx";
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

		for ($i = 2; $i <= $Totalrow; $i++){
									// Tiến hành lấy giá trị của từng ô đổ vào mảng
			$cot1=$sheet->getCellByColumnAndRow(0, $i)->getValue();
			$cot2=$sheet->getCellByColumnAndRow(1, $i)->getValue();	
			$cot3=$sheet->getCellByColumnAndRow(2, $i)->getValue();
			//echo  $cot1.' - '.$cot2.' - '.$cot3."</br>";		
			echo "INSERT INTO public.rels(lon, lat, id) VALUES (".$cot1.",".$cot2.",'".$cot3."'); </br>"	;		
		}
			
	

 
?>

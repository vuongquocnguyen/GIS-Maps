<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
        //Khi bàn phím được nhấn và thả ra thì sẽ chạy phương thức này
        $("#formthemtrambus").validate({
            rules: {
                ma_tram: "required",
                ten_tram: "required",
                lat: {
                	required: true,
                	number: true
                	},
                lon: {
                	required: true,
                	number: true
                	},
                stt_theotuyen: {
                	required: true,
                	number: true
                	},
                danhsachnode: {
                	required: true,
                	number: false
                	}
            },
            messages: {
                ma_tram: "Mã trạm rỗng!",
                ten_tram: "Tên trạm Rỗng!",
                lat: {
                	required: "Kinh độ Rỗng!",
                	number: "Phải là số!"
                	},
                lon: {
                	required: "Vĩ độ Rỗng!",
                	number: "Phải là số!"
                	},
                stt_theotuyen: {
                	required: "STT Rỗng!",
                	number: "Phải là số!"
                	},
                danhsachnode: {
                	required: "Danh sách node Rỗng!",
                	number: "Phải là số!"
                	}
            }
        });
    });
</script>
<?php
#---------------------------------------------Thêm trạm bus---------------------------------
echo "<div class='tieude'>THÊM TRẠM BUS VÀO TUYẾN {$_GET['id']}</div>";
			require("connect.php");
				echo "<form id='formthemtrambus' name='themtrambus' method='POST' action='#'>";
				echo "<table class='tabletuyenbus' border='1'>";
					echo "<tr><th width='5%'>Mã tuyến</th>".
								"<th width='13%'>Mã trạm</th>".
								"<th width='20%'>Tên trạm</th>".
								"<th width='13%'>Lat</th>".
								"<th width='13%'>Lon</th>".
								"<th width='10%'>STT theo tuyến</th>".
								"<th>DsNode</th>".
								"</tr>";
				
						echo "<tr>";
						$sql = "select * FROM tuyen_xebus WHERE ma_sotuyen='".$_GET['id']."'";
							$retval = mysqli_query($conn,$sql)
								or die(mysqli_error());
						if(mysqli_num_rows($retval) > 0){					
								while($row = mysqli_fetch_assoc($retval)){
								    echo "<td style='text-align:center; padding:22px;'> <input name='mst' type='hidden' value='{$row['ma_sotuyen']}'>{$row['ma_sotuyen']}</td>";
								    echo "<td> <input name='ma_tram' type='text'></td>"; 
									echo "<td> <input name='ten_tram' type='text'</td>"; 
									echo "<td> <input name='lat' type='text'></td>";
									echo "<td> <input name='lon' type='text'></td>";
									echo "<td> <input name='stt_theotuyen' type='text'></td>";
									echo "<td> <input name='danhsachnode' type='text'></td>";
								}
						}
						 echo "</tr> ";				
					echo "</table>";
					echo "<center>";
						echo "<div class='nutchon'>";
							echo "<input class='btn btn-primary' type='submit' name='themtrambus' value='Xác nhận thêm trạm bus vào tuyến'>";
						echo "</center>";
					echo "</form>";

#----------Thêm trạm bus vào tuyến bus-----------------
	if(isset($_POST['themtrambus'])){
	require("connect.php");
		$sql = "INSERT INTO tram_xebus(ma_tram,ten_tram,ma_sotuyen,lat,lon,stt_theotuyen,danhsachnode) VALUES('{$_POST['ma_tram']}','{$_POST['ten_tram']}','{$_POST['mst']}',{$_POST['lat']},{$_POST['lon']},{$_POST['stt_theotuyen']},'{$_POST['danhsachnode']}');";
	   mysqli_query($conn, $sql) 
	   		or die("<script> alert('Thêm không thành công!')</script>");
	   echo "<script> alert('Thêm thành công!')</script>";
	}
#-------------Hiển thị các trạm bus thuộc tuyến bus---------------
	echo "<div class='tieude'>DANH SÁCH TRẠM BUS THUỘC TUYẾN {$_GET['id']}</div>";
		$sql="SELECT * FROM tram_xebus where ma_sotuyen={$_GET['id']}";
		$retval=mysqli_query($conn, $sql);
		if(mysqli_num_rows($retval) > 0){	
		echo "<form name='quanly' method='post' action='#'>";
		echo "<table border='1' class='tabletuyenbus'>";
		echo "<tr>		<th width='5%'>Mã trạm</th>".
						"<th width='15%'>Tên trạm</th>".
						"<th width='15%'>Vĩ độ(Latitude)</th>".
						"<th width='15%'>Kinh độ(Longitude)</th>".
						"<th width='5%'>STT Theo Tuyến</th>".
						"<th>DsNode</th>".
	         "</tr>";			
		while($row = mysqli_fetch_assoc($retval)){
				echo "<tr>";
				echo "<td style='text-align:center;'>" . $row["ma_tram"]. "</td>"; 
				echo "<td>" . $row["ten_tram"]. "</td>"; 
				echo "<td style='text-align:center;'>" . $row["lat"]. "</td>"; 
				echo "<td style='text-align:center;'>" . $row["lon"]. "</td>"; 
				echo "<td style='text-align:center;'>" . $row["stt_theotuyen"]. "</td>";
				echo "<td style='text-align:center;'>" . $row["danhsachnode"]. "</td>";
		}	
		echo "</table>";
		echo "</form>";
		}else echo "Không có trạm bus thuộc tuyến {$_GET['id']}";	
		mysqli_close($conn);
?>
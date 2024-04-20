<?php
if(isset($_GET['search'])){
	$noidungSearch=$_GET['search'];
	$tinhthanh=$_GET['tinhthanh'];
}
?>
<style type="text/css">
	#danhsachtuyenbus{
		position: relative;
		width: 99%;
		margin: 0 1% 1% 1%;
	}
	#danhsachtuyenbus .dstuyenbus{
		position: relative;
		float: left;
		width: 32%;
		padding: 5px;
	    margin: 5px;
	    display: inline-block;
	    text-align: left;
	    text-decoration: none;
	    font-size: 14px;
	    vertical-align: middle;
	    color: #FFFFFF !important;
	    background: none repeat scroll 0 0 #34B67A;
	    border: 1px solid #34B67A;
	}
	#danhsachtuyenbus .dstuyenbus:hover{
		text-decoration: none !important;
        color: #121212 !important;
        border: 1px solid #34B67A;
        background: none repeat scroll 0 0 #ffffff;
	}
	#danhsachtuyenbus .dstuyenbus:hover .icon {
        color: #000000;
        background-color: #FFFFFF;
    }
	#danhsachtuyenbus table tr{
		margin: 0;
	    padding: 0;
	    border: 0;
	    font-size: 100%;
	}
	#danhsachtuyenbus table td{
		padding-left:5px; 
	}
	#danhsachtuyenbus a{
		color: #5e9700;
    	text-decoration: none;
	}
	#danhsachtuyenbus .icon{
	    white-space: nowrap;
	    font-size: 18px;
	    font-weight: bold;
	    text-align: center;
	    height: 30px;
	    min-width: 30px;
	    line-height: 30px;
	    margin: 0px;
	    padding: 1px;
	    vertical-align: middle;
	    color: #ffffff;
	    border: solid 1px #dadada;
	    border-radius: 50%;
	    -webkit-border-radius: 50%;
	}
#formSearch{
	width: 100%;
	height: 60px;
}
.form-group{
	margin-bottom: unset;
}
#formSearch .form-control{
	width: 50%;
	float: left;
	margin-left: 10%; 
	margin-right: 5%;
}
#formSearch .btn{
	width: 20%;
	margin-left: 5%; 
	display: block;
}
</style>
<script type="text/javascript">
	function getSearch(){
		tinhthanh=$('#tinhthanh').val();
		noidungSearch=$('#search').val();
		window.location.href ='http://127.0.0.1/webMap/indexUser.php?xem=danhsachtuyenbusTimtheoten&search='+noidungSearch+"&tinhthanh="+tinhthanh;
	}
</script>
<div id='formSearch'>
	<form>
	  <div class="form-group">
	    <input class="form-control" id="search" placeholder="Nhập tuyến bus" autocomplete="off">
	    <input type="hidden" id="tinhthanh" value="<?php echo $tinhthanh ?>" autocomplete="off">
	  </div>
	  <button type="button" class="btn btn-primary" onclick="getSearch();">Tìm</button>
	</form>
</div>
<?php
	echo "<div class='tieude'>DANH SÁCH CÁC TUYẾN BUS</div>";
		include("connect.php");
			$sql="SELECT * FROM tuyen_xebus where ten_tuyen like '%$noidungSearch%' and ma_tinhthanh='".$_GET['tinhthanh']."'";
			$retval=mysqli_query($conn, $sql);
			if(mysqli_num_rows($retval) > 0){	
				while($row = mysqli_fetch_assoc($retval)){
					echo "<div id='danhsachtuyenbus'>
						<a href='indexUser.php?xem=chitiettuyenbus&id=".$row['ma_sotuyen']."' onclick='' class='dstuyenbus'>
							<table cellspacing='2px'>
								<tr>
									<td class='icon'>".$row['ma_sotuyen']."</td>
									<td>".$row['ten_tuyen']."</td>
								</tr>
							</table>	
						<a>
					</div>";
			}
		}else echo "Không có tuyến bus nào!";
?>
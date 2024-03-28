<style type="text/css">
	time#icon
{
  font-size: 1em; /* change icon size */
  display: block;
  position: relative;
  width: 100%;
  height: 130px;
  background-color: #fff;
  border-radius: 0.6em;
  box-shadow: 0 1px 0 #bdbdbd, 0 2px 0 #fff, 0 3px 0 #bdbdbd, 0 4px 0 #fff, 0 5px 0 #bdbdbd, 0 0 0 1px #bdbdbd;
  overflow: hidden;
  -webkit-backface-visibility: hidden;
  -webkit-transform: rotate(0deg) skewY(0deg);
  -webkit-transform-origin: 50% 10%;
  transform-origin: 50% 10%;
}
 
time#icon *
{
  display: block;
  width: 100%;
  font-size: 1em;
  font-weight: bold;
  font-style: normal;
  text-align: center;
  padding: 4%;
}
 
time#icon strong
{
  position: absolute;
  top: 0;
  color: #fff;
  background-color: #fd9f1b;
  border-bottom: 1px dashed #f37302;
  box-shadow: 0 2px 0 #fd9f1b;
}
 
time#icon em
{
  position: absolute;
  bottom: 0em;
  color: #fd9f1b;
}
 
time#icon span
{
  width: 100%;
  font-size: 2.5em;
  letter-spacing: -0.05em;
  padding-top: 1em;
  color: #2f2f2f;
}
 
time#icon:hover, time#icon:focus
{
  -webkit-animation: swing 0.6s ease-out;
  animation: swing 0.6s ease-out;
}
 
@-webkit-keyframes swing {
  0%   { -webkit-transform: rotate(0deg)  skewY(0deg); }
  20%  { -webkit-transform: rotate(12deg) skewY(4deg); }
  60%  { -webkit-transform: rotate(-9deg) skewY(-3deg); }
  80%  { -webkit-transform: rotate(6deg)  skewY(-2deg); }
  100% { -webkit-transform: rotate(0deg)  skewY(0deg); }
}
 
@keyframes swing {
  0%   { transform: rotate(0deg)  skewY(0deg); }
  20%  { transform: rotate(12deg) skewY(4deg); }
  60%  { transform: rotate(-9deg) skewY(-3deg); }
  80%  { transform: rotate(6deg)  skewY(-2deg); }
  100% { transform: rotate(0deg)  skewY(0deg); }
}
#getInput-result{
	position: absolute;
    z-index: 99999999;
    background: #FFF;
    max-height: 250px;
    overflow: scroll;
    width: 91%;
    overflow-x: hidden;
    margin-left:-10px; 
}
#form1{
	width: 100%;
	padding: 0 10px 10px 10px;
	margin-top: 5%; 
	display: block;
}
#form1 .list{
	padding: 5px 20px;
	margin: 0;
}
#form1 .list:hover{
	background-color: #ccc;
}
#form1 .list:first-child{
	margin-top: 5px;
}
#form1 input{
	width: 90%;
	margin: 5%;
}
</style>


<div class='frame'>
<div class='title'><h5>Thông Tin Tuyến</h5></div>
	<form id="form1" name='timkiem' action="javascript:submitQuery()">
			<input id="getInput" type="text" class="form-control" placeholder="Nhập mã hoặc tên tuyến" aria-label="Username" onkeyup="getInputtuyen(this);" aria-describedby="addon-wrapping" autocomplete="off">
		<div id='getInput-result'></div>
		<center>
			<button type="button" class="btn btn-primary" onclick="submit_mst();"><i class="fas fa-search"></i>Tìm</button>
		</center>
	</form>
</div>
<div class='frame'>
	<div class='title'><h5>Thông Báo Theo Chủ Đề</h5></div>
			<?php
				include('connect.php');
				$sql="SELECT chude, COUNT(*) as soluong FROM thongbao group by chude order by soluong desc";
				$retval=mysqli_query($conn,$sql);
				echo "<div class='khung'>";         
						echo "<div style='padding: 1%;'>";
				if(mysqli_num_rows($retval) > 0){	
						while($row = mysqli_fetch_assoc($retval)){
									echo "<div class='noidung'><img src='icon/".$row['chude'].".png' height='30px' width='auto' style='float:left;'/><a href='indexUser.php?xem=thongbaotheochude&chude=".$row['chude']."'>&nbsp;".$row['chude']."</a><p class='soluongbai'>".$row['soluong']."</p></div>";
						}
				}else echo "Không có kết quả!";
				echo "</div>";
				echo "</div>";
			?>
</div>
<div class='frame'>
	<div class="row">
		<div class="col-5">
			<time datetime="2014-09-20" id="icon">
			  <strong id="thang"></strong>
			  <span id="ngay"></span>
			  <em id="thu"></em>
			</time>
		</div>
		<div class="col-7">
			<time datetime="2014-09-20" id="icon">
			  <strong>Time</strong>
			  <span id="time"></span>
			</time>
		</div>
	</div>
</div>
<script type="text/javascript">
	var d = new Date();
	var ngay = ["Sunday", "Monday", "Tuesday", "Wednesday" ,"Thursday" ,"Friday" ,"Saturday"];
	var thang = ["January", "February", "March", "April", "	May", "June", "July", "August", "September", "October", "November", "December"];
	document.getElementById("thang").innerHTML = thang[d.getMonth()];
	document.getElementById("ngay").innerHTML = d.getDate();
	document.getElementById("thu").innerHTML = ngay[d.getDay()];
</script>
<script type="text/javascript">
	function getInputtuyen(e){
	value=e.value;
	var dataString ='&data='+value;
		$.ajax
		({
		type: "POST",
		url: "php/content/function_ajax/getTuyen.php",
		data: dataString,
		success: function(resultData) { 
		if(resultData=='') return;
			tram=resultData.split(';');
			setTuyen(tram,e);
		//$('#thongbao').html('thành công.').parent().fadeIn().delay(1000).fadeOut('slow');
	  	 },
	  	 error: function(data){
				alert('error!'+data);
				}
		});
	
};
/*
param danh sach ten tram bus, element của thẻ input
tạo danh sách sổ xuống các tên trạm bus
output: none
*/
function setTuyen(dataTram,e){
	id=e.id;
	idResult=id+"-result";
	document.getElementById(idResult).innerHTML="";
	for(i=0; i< dataTram.length;i++){
		if(!dataTram[i]) continue;
		tramT = jQuery.parseJSON(dataTram[i]);
		document.getElementById(idResult).innerHTML +='<p id="'+id+'" class="list" title="'+tramT.ma_sotuyen+" "+tramT.ten_tuyen+
		'" onmouseover="setValueInput(id,title);" onclick=document.getElementById("'+idResult+'").innerHTML="">'
		+tramT.ma_sotuyen +" "+tramT.ten_tuyen +'</p>';
	}
}
function setValueInput(id,e){
	$('#'+id).val(e);
}

function submit_mst(){
	chuoi=$("#getInput").val();
	if(chuoi==""){
		alert("Chưa chọn tuyến bus")
	}else{
		var mst = chuoi.split(" ");
		window.location.href = "indexUser.php?xem=chitiettuyenbus&id="+mst[0];
	}
}
</script>

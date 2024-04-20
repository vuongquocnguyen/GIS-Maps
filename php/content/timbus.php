<style type="text/css">
	#mapid{
	   position: absolute;
	   right : 0;
	   width: 100%;
	   height: 100%;
	   z-index: 0;
	}
	#form{
		width: 100%;
		padding: 0 10px 10px 10px;
		display: block;
	}
	#form input[type='button']{
		position: relative;
		margin: 0;
		padding: 0;
		width: 150px;
		height: 30px;
		float: left;
		line-height: 30px;
	}
    #form .title-input{
        float: left;
        line-height: 30px;
        height: 30px;
        margin: 0;
    }
	 #form .frompoint{
		width: 300px;
		height: 30px;
		margin:0;
	}
	 #form .topoint{
		width: 300px;
		height: 30px;
		margin:0;
	}
	 #form .topoint-content,.frompoint-content{
		float: left;
		position: relative;
		margin: 0 10px;
	}
	#frompoint-result,#topoint-result{
		position: absolute;
		z-index: 99999999;
		background: #FFF;
		max-height: 300px;
		overflow: scroll;
		width: 100%;
		overflow-x:hidden;
	}
	#form .list-point{
		padding: 5px 20px;
		margin: 0;
	}
	#form .list-point:hover{
		background-color: #ccc;
	}
	#form .list-point:first-child{
		margin-top: 20px;
	}
	#result .frompoint:hover{
		background-color: #CCC;	
	}
	#chiduong{
	   position: absolute;
	   left: 0;
	   width: 20%;
	   max-height: 100%;
	   overflow:scroll;
	   background-color: #DDD;
	   z-index: 2;
	   display: none;
	   height: 100%;
	   line-height: 1.3;
	}
	#box{
		position: relative;
		height: 500px;
	}
	#chiduong .rowStop{
		    margin: 0;
		    padding: 0;
		    border: 0;
		    font-size: 100%;
	}
	#chiduong .dstbus{
		position: relative;
		float: left;
		width: 100%;
		margin:1%;
		font-size: 14px;
		color: #FFF;
		padding: 5px;
		background-color: #34B67A;
		border: 1px solid #34B67A;
		text-align: inherit;
	}
	#chiduong a{
		text-decoration: none;
	}
	#chiduong a:hover{
		text-decoration: none;
		color: #000;
		background-color: #FFF;
	}
	#chiduong table{
		width: 100%;
	}
	#chiduong table tr{
		margin: 0;
	    padding: 0;
	    border: 0;
	    font-size: 100%;
		}
	#chiduong table td{
		text-align: inherit;
		font-size: 14px;
	}
	#chiduong .orderNo{
		width: 20px;
	    height: 20px;
	    line-height: 20px;
	    border-radius: 50%;
	    -webkit-border-radius: 50%;
	    -moz-border-radius: 50%;
	    vertical-align: middle;
	    text-align: center;
	    color: #fff;
	    background-color: #34B67A;
	}
	.closeSiderBar{
display: none;
	}
	.buttonDelete{
		width:50%; 
		height:30px;
		font-size:15px;
		margin:0;
		padding:5px;
		background-color: red;
	}
	.diemden{
		width:50%; 
		height:30px;
		font-size:15px;
		margin:0;
		padding:5px;
	}
	.diemdi{
		width:50%; 
		height:30px;
		font-size:15px;
		margin:0;
		padding:5px;
	}
	.icon-stt{
		height: 20px;
	    width: 20px;
	    border-radius: 20px;
	    background-color: green;
	    border: 1px solid white;
	    display: block;
	    float: left;
	    text-align: center;
	    line-height: 18px;
	    margin-right: 5px; 
	}
</style>


<body>
<div style="position: absolute;display: none;z-index: 9999999999999;right: 0;width: 50%;">
	<div class='alert-success' id='thongbao' style="padding: 5px 20px;width: 100%;text-align: center;"></div>
</div>
<!-- form -->

<form id="form" action="javascript:submitQuery()" name="search" class="clearfix">
    <div class='frompoint-content'>
		<input type="text" name="frompoint" placeholder="Nhập điểm đi" id='frompoint' class='frompoint' autocomplete="off"  onkeyup="getDataFromTo(this);" />
		<div id='frompoint-result'></div>
    </div>
    <div class='topoint-content'>
	    <input type="text" name="topoint" placeholder="Nhập điểm đến" autocomplete="off" id='topoint' class='topoint'  onkeyup="getDataFromTo(this);" />
	    <div id='topoint-result' ></div>
    </div>
    <input class="btn btn-primary" type="button" value="Submit" id="searchBus"></input>
</form>

<!-- map -->
<div style="position: relative;height: 40px;">
	<div id='showListBus' style="width: 40px; height: 40px; position: absolute;left: 0">
				<img src="icon/clickHere.png" height="35px" onclick='closeListBus()' />
			</div>
	<div id='sidebarRight' style="width: 40px; height: 40px; position: absolute;right: 0;">
				<img src="icon/clickHere.png" height="35px" onclick='closeSidebarRight()' />
			</div>
</div>
<div id="box">
	<div id='chiduong'>Chưa có dữ liệu</div>
	<div id="mapid">
	</div>
</div>
<script type="text/javascript">
// initMap();
function closeListBus(){
$('#chiduong').animate({width:"0%"},500);
$('#mapid').animate({width:"100%"},500);
$('#showListBus').html('<img src="icon/clickHere.png" width ="35px" onclick="openListBus()" />'); 
}

function openListBus(){
$('#chiduong').css('display','block');
$('#chiduong').animate({width:"25%"},500);

$('#mapid').animate({width:"100%"},500);
$('#showListBus').html('<img src="icon/clickHere.png" width ="35px" onclick="closeListBus()" />'); 
$('#showListBus img').css('transform','rotate(180deg)');  
}

function closeSidebarRight(){
	document.getElementById("siderbar-right").className='closeSiderBar';
$('#sidebarRight').html('<img src="icon/clickHere.png" width ="35px" onclick="openSidebarRight()" />'); 
document.getElementById("content-map").className='col-12';
$('#sidebarRight img').css('transform','rotate(180deg)');  
}
function openSidebarRight(){
	document.getElementById("siderbar-right").className='col-3';
	$('#sidebarRight').html('<img src="icon/clickHere.png" width ="35px" onclick="closeSidebarRight()" />'); 
// $("#content-map").css('max-width','100%').css('width','100%').css('flex','unset');
document.getElementById("content-map").className='col-9';
}
</script>
<script src="js/timduongnew.js"></script>
<script type="text/javascript">initMap();</script>
</body>
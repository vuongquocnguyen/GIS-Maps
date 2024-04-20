<div id='content'>
<style type="text/css">
	#mapid{
		width: 1190px;
		height: 600px;
		z-index: 0;
	}
    .row {
        position: absolute;
        float: left;
		left: 20%;
        height: 40px;
        /* width: 100%; */
        bottom: 0%;
        z-index: 99999;
        margin-left: 0%;
        background-color: rgba(0, 0, 0, 0.3);
    }
	.row .title_name{
	position: relative;
	float: left;
	width: 150px;
	height: 30px;
	margin-left: 5px;
	margin-right: 5px;
	margin-top: 5px;

	}	
	.tools-map{
		position: absolute;
		top:5%;
		left: 0%;
		width: 40px;
		background-color: rgba(255,255,255,1);
		box-shadow: 1px 1px 10px #000000;
		z-index: 999;
		margin-left: 10px;

	}
	.tools-map .tools-item{
		padding-left: 5px;
		width: 40px;
		height: 40px;
		padding-top: 5px;
		padding-bottom: 5px;
		opacity: 0.8;

	}
	.tools-map .tools-item:hover{
		opacity: 1;
		background-color: rgba(0,0,0,0.1);
	}
	.tools-map .tools-item img{
		width: 30px;
		height: 30px;
	}
	.row .button{
	position: relative;
	float: left;
	height: 30px;
	margin-left: 5px;
	margin-right: 5px;
	margin-top: 5px;
	}	
</style>
<div class='tieude' name='<?php echo $_GET['id'] ?>' >Thêm Tuyến Buýt 
	<?php 
	// echo "{$_GET['id']}";
		include('connect.php');
			$sql="SELECT ma_sotuyen, ten_tuyen FROM tuyen_xebus WHERE ma_sotuyen='{$_GET['id']}'";
			$retval=mysqli_query($conn,$sql);
			    if(mysqli_num_rows($retval) > 0){
			        while($row=mysqli_fetch_assoc($retval)){
			        	echo "".$row['ma_sotuyen'].": ";
			        	echo "".$row['ten_tuyen']."";
			        }
			    } else echo "Không có dữ liệu!";
		mysqli_close($conn);
?>  
</div>
	<div style="position: relative;float: left;">
			<div id="mapid"></div>
		<!--<button style="position: absolute;bottom: 10px; left: 5px;" onclick="get_toado_bus();">Tìm</button>-->	
			<div class='row' id='tuychon_map'>
				<input class="button" type="button" onclick='tuyChon(0);'value="Get Trạm" />
				<!-- <input class="button" type="button" onclick='tuyChon(1);'value="Get note" /> -->
				<input type="text" class='title_name' id='title_name' title="Nhập tên trạm" placeholder="Nhập tên trạm">
				<input type="text" class='title_name' id='lat_tram' title="Nhập tên trạm" placeholder="Nhập Kinh độ" style="width: 200px;">
				<input type="text" class='title_name' id='lon_tram' title="Nhập tên trạm" placeholder="Nhập vĩ độ" style="width: 200px;">
			</div>
		<div class='tools-map'>
			<div id='Move'>
				<div class='tool-map tools-item' onclick="setMove(1);" title="Chế độ di chuyển">
					<img src='icon/stopMove.png'/>
				</div>
			</div>
			<div class='tool-map tools-item' onclick="undoMaker();" title="quay lại">
					<img src='icon/undoMaker.png'/>
			</div>
			<div class='tool-map tools-item' onclick="deleteallMaker();" title="Xóa tất cả maker">
					<img src='icon/deleteallMaker.png'/>
			</div>
			<div class='tool-map tools-item' onclick="luu();" title="Lưu">
					<img src='icon/save.png'/>
			</div>
		</div>
	</div>
<script>
var tuychon=1;
var nameTram="";
var lat_tram="";
var lon_tram="";
var Move=0;
$click=0;
$firstPoint=null;
function tuyChon(value){
tuychon=value;
if(value==0){
	nameTram=document.getElementById("title_name").value;
	lat_tram=document.getElementById("lat_tram").value;
	lon_tram=document.getElementById("lon_tram").value;

	if(nameTram==""){
		document.getElementById("title_name").focus();
		alert("Nhap ten tram");
		return 0;
	}
	if(lat_tram!=""&&lon_tram!=""&&nameTram!="") newTram(lat_tram,lon_tram,nameTram,value);

}

document.getElementById("title_name").value="";
document.getElementById("lat_tram").value="";
document.getElementById("lon_tram").value="";
}

var map = L.map('mapid').setView([10.775375, 106.705737], 14);
		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					maxZoom: 18,
					attributionControl: false,
					prefix: '',
				}).addTo(map);
		L.control.ruler().addTo(map);

//search
		var searchControl = L.esri.Geocoding.geosearch().addTo(map);
		var results = L.layerGroup().addTo(map);
			searchControl.on('results', function(data){
			results.clearLayers();
		    for (var i = data.results.length - 1; i >= 0; i--) {
		      results.addLayer(L.marker(data.results[i].latlng));
		    }
		  });
// attaching function on map click
map.on('click', onMapClick);
function setMove(chedo){
	Move=chedo;
	if(chedo==0){
		$html="	<div class='tool-map tools-item' id='Move' onclick='setMove(1);'  title='Chế độ di chuyển'> "+		
					"<img src='icon/stopMove.png'/>  "+
				"</div>";

		$('#Move').html($html);
	}else{
		$html="	<div class='tool-map tools-item' id='Move' onclick='setMove(0);' title='Chế độ tạo marker'> "+
					"<img src='icon/startMove.png'/>  "+
				"</div>";
		$('#Move').html($html);
	}

}

function onMapClick(e) {

	if(Move==0) return 0;
	
	 if(tuychon==1){
	 	 nameTram="node";
	 }
    var geojsonFeature = {
        "type": "Feature",
            "properties": {},
            "geometry": {
                "type": "Point",
                "coordinates": [e.latlng.lat, e.latlng.lng]
        }
    }
    var marker;
    L.geoJson(geojsonFeature, {   
        pointToLayer: function(feature, latlng){
            
            marker = L.marker(e.latlng, {
                
                title: nameTram,
                alt: "Resource Location",
                riseOnHover: true,
                draggable: true,

            }).bindPopup("<input type='button' value='Delete this marker' class='marker-delete-button'/>");

            marker.on("popupopen", onPopupOpen);
            marker.on("moveend",function(e){
            	updateline();
            });
  
       		if(tuychon==0) marker.setIcon(getIcon('tram'));
       		if(tuychon==1) marker.setIcon(getIcon('node'));
            return marker;
        }
    }).addTo(map);
    if($click==0){
    	$firstPoint=marker;
    	$click++;
    }
    if($click!=0){
    	console.log($firstPoint._latlng);
		console.log(tinhkhoangcach($firstPoint._latlng, marker._latlng));
	}
    tuychon=1;
    updateline();
    console.log(marker);

}

// -------------------------ham cap nhat icon-------------------------
// input tên icon cần sét, output Icon
function getIcon(name){
	// khai báo icon 
	var tramIcon = L.icon({
    iconUrl: 'icon/tramIcon.png',
    number: 12,
    iconSize:     [30, 30], // size of the icon
    shadowSize:   [10, 60], // size of the shadow
    iconAnchor:   [15, 30], // point of the icon which will correspond to marker's location
    shadowAnchor: [1, 62],  // the same for the shadow
    popupAnchor:  [0, -30] // point from which the popup should open relative to the iconAnchor
	});
	var nodeIcon = L.icon({
    iconUrl: 'icon/nodeIcon.png',
    iconSize:     [15, 15], // size of the icon
    shadowSize:   [60,60], // size of the shadow
    iconAnchor:   [7, 7], // point of the icon which will correspond to marker's location
    shadowAnchor: [4, 20],  // the same for the shadow
    popupAnchor:  [0, -15] // point from which the popup should open relative to the iconAnchor
	});
	var rootIcon = L.icon({
    iconUrl: 'icon/start.png',
    iconSize:     [30, 30], // size of the icon
    shadowSize:   [60,60], // size of the shadow
    iconAnchor:   [15, 30], // point of the icon which will correspond to marker's location
    shadowAnchor: [4, 20],  // the same for the shadow
    popupAnchor:  [0, -15] // point from which the popup should open relative to the iconAnchor
	});
	var Icon=nodeIcon;
	switch(name){
		case 'tram':
			Icon=tramIcon;
			break;
		case 'node':
			Icon=nodeIcon;
			break;
		case 'root':
			Icon=rootIcon;
			break;
		default:  
			Icon=nodeIcon;
			break;

	}
	return Icon;
}
function newTram(lat,lon,name,value){
	var geojsonFeature = {
        "type": "Feature",
            "properties": {},
            "geometry": {
                "type": "Point",
                "coordinates": [lat, lon]
        }
    }
    var marker;
    L.geoJson(geojsonFeature, {   
        pointToLayer: function(feature, latlng){
            
            marker = L.marker([lat,lon], {
                
                title: name,
                alt: name,
                riseOnHover: true,
                draggable: true,

            }).bindPopup("<input type='button' value='Delete this marker' class='marker-delete-button'/>");

            marker.on("popupopen", onPopupOpen);
            marker.on("moveend",function(e){
            	updateline();
            });
  
       		if(value==0) marker.setIcon(getIcon('tram'));
       		if(value==1) marker.setIcon(getIcon('node'));
       		if(value==2) marker.setIcon(getIcon('root'));
            return marker;
        }
    }).addTo(map);
    tuychon=1;

    map.setView([lat, lon], 14);

}

function updateline(){
            for(i in map._layers) {
        if(map._layers[i]._path != undefined) {
            try {
                map.removeLayer(map._layers[i]);
            }
            catch(e) {
                console.log("problem with " + e + map._layers[i]);
            }
        }
     
    }
       veduong();
}
// Function to handle delete as well as other events on marker popup open
function onPopupOpen() {
    var tempMarker = this;
    $(".marker-delete-button:visible").click(function () {
        map.removeLayer(tempMarker);
        updateline();
    });

}

function ve_duong_all() {


    $.each(map._layers, function (ml) {
        if (map._layers[ml].feature) {
            allMarkers.push(this._latlng);
        }
    	});
    

}
// getting all the markers at once
function veduong() {

    var allMarkersObjArray = [];//new Array();
    $.each(map._layers, function (ml) {
        //console.log(map._layers)
        if (map._layers[ml].feature) {
            
            allMarkersObjArray.push(this);
          
  
        }
    });   
    var pon=[];
    i=0;
    for ( i=0;i<allMarkersObjArray.length;i++){
    	//console.log(allMarkersObjArray[i]);
    	pon.push(allMarkersObjArray[i]._latlng);
    }
polyline = L.polyline(pon, {color: '#00ff00'}).addTo(map);
if(allMarkersObjArray[0]!=null&&allMarkersObjArray[1]!=null)console.log(distance(allMarkersObjArray[0]._latlng,allMarkersObjArray[i-1]._latlng));
}

function undoMaker(){
	var tram;
	$.each(map._layers, function (ml) {
		if (map._layers[ml].feature) {
		 tram=this;
		 }	              	             
	});
	if(tram!=null) map.removeLayer(tram);
    updateline();

}

function deleteallMaker(){
	var tram;
	$.each(map._layers, function (ml) {
		if (map._layers[ml].feature) {
			if(this!=null) map.removeLayer(this);
		 }	              	             
	});
	
    updateline();

}

function getNode(){
	mst=$('.tieude').attr('name');
	var dataString ='&mst='+mst;
			$.ajax
			({
			type: "POST",
			url: "php/content/function_ajax/get_node.php",
			data: dataString,
			success: function(resultData) { 
				// alert(resultData);
			  		$ds=resultData.split(';');
			  		for(i=0;i<$ds.length-1;i++){
			  			//console.log($ds[i]);
			  			if($ds[i]=="null"||$ds[i]==null) continue;
			  			tram = jQuery.parseJSON($ds[i]);
			  			if(i==0||i==$ds.length-2) newTram(tram['lat'],tram['lon'],tram['ten_tram'],2);
				  		else newTram(tram.lat,tram.lon,tram.ten_tram,0);		
				  		//console.log(tram.danhsachnode);
				  		if(tram.danhsachnode=="null"||tram.danhsachnode==null) continue;
				  		$dsnode=jQuery.parseJSON(tram.danhsachnode);
				  		for(j=0;j<$dsnode.length;j++){
				  			newTram($dsnode[j].lat,$dsnode[j].lng,'node',1);
				  		}
		  		}
			updateline();
			//$('#thongbao').html('thành công.').parent().fadeIn().delay(1000).fadeOut('slow');
		  	 },
		  	 error: function(data){
    				// alert('error!'+data);
  				}
			});
}

function luu(){
	mst=$('.tieude').attr('name');
  	tram=[];
	note=[];
	tram_tmp=[];
	next=0;
	namet=[];
	$.each(map._layers, function (ml) {      
		if (map._layers[ml].feature) {
			if(next!=0){
				if(this.options.title!='node'){
				        tram_tmp[0]=namet;
				        namet=[];
				        tram_tmp[1]=note;
				        tram.push(tram_tmp);
				        note=[];
				        tram_tmp=[];
				        namet[0]= this.options.title;  
				    	namet[1]= this._latlng.lat; 
				    	namet[2]= this._latlng.lng; 
				}else note.push(this._latlng);
		    }else {
		    	namet[0]= this.options.title;  
		    	namet[1]= this._latlng.lat; 
		    	namet[2]= this._latlng.lng; 
		    	}   
		 	next=1;
		}		        
	});
	tram_tmp[0]=namet;
	tram_tmp[1]=null;
	tram.push(tram_tmp);
 	var dataString ='id='+JSON.stringify(tram)+'&mst='+mst;
 	// alert(dataString);
			$.ajax
			({
			type: "POST",
			url: "php/content/function_ajax/save_tram.php",
			data: dataString,
			success: function(resultData) { 
			 alert('Thêm thành công!');
			//$('#thongbao').html('thành công.').parent().fadeIn().delay(1000).fadeOut('slow');
		  	 },
		  	 error: function(data){
    				alert('error!'+data);
  				}
			});	      
}
</script>	
<script type="text/javascript">
$(window).bind("load", function() { 
	getNode();   
});
</script>





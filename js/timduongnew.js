map = L.map('mapid');
makerDiemdi=null;
markerDiemDen=null;
countMarker=1;//default;
/** event * */
// A $( document ).ready() block.
$( document ).ready(function() {
	$('#searchBus').click(function(){
		searchBus();
	});
	$(window).click(function(e){
		id=e.target.id;
		if(id!="frompoint" && id!="topoint"){
			$('#frompoint-result').html("");
			$('#topoint-result').html("");
		};
	});
});


function onMapClick(e) {
	setInfo(e.latlng.lat,e.latlng.lng,id);
}

function setInfo(lat,lng,id){
	if(	countMarker>2) return 0;
	countMarker++;
	var marker;
	$.post('https://nominatim.openstreetmap.org/reverse?format=xml&lat='+lat+'&lon='+lng+'&zoom=18&addressdetails=1',function(data) {

	   info=(data.getElementsByTagName("result"))[0].innerHTML;
	   $('#'+id).val(info);
	   		if(id=='frompoint') {
	        	 action="<div><button class='marker-delete-button buttonDelete'>Xóa Đánh Dấu"+
	            				"<button class='diemden'>Điểm Đến</button></div>"+"<span class='infor-marker'>"+info+"</span>";
	        }
	        if(id=='topoint') {
	        	 action="<div><button class='marker-delete-button buttonDelete' />Xóa Đánh Dấu"+
	            				"<button class='diemdi'>Điểm Đi</button></div>"+"<span class='infor-marker'>"+info+"</span>";
	        }
	   	  
	   	   marker = L.marker([lat,lng], {
                alt: info,
                title:info,
                trangthai:id,
                riseOnHover: true,
                draggable: true,
	            }).bindPopup(action);   	
	        marker.on("popupopen", onPopupOpen); 
	        marker.addTo(map);
	        if(id=='frompoint') {
	        	makerDiemdi=marker;
	        	diemXP['lat']=lat;
	        	diemXP['lon']=lng;
	        	diemXP['ten_tram']=info;
	        	diemXP['marker'] =marker;
	        }
	        if(id=='topoint') {
	        	makerDiemDen=marker;
	        	diemDen['lat']=lat;
	        	diemDen['lon']=lng;
	        	diemDen['ten_tram']=info;
	        	diemDen['marker'] =marker;
	        }
	});
}
/*
*khởi tạo bảng đồ
*/
var diemXP = {
	ten_tram: null,
	ma_tram: null,
	ma_sotuyen: null,
	lat: null,
	lon: null,
	stt_theotuyen: null,
	danhsachnode: null
},
	diemDen = {
		ten_tram: null,
		ma_tram: null,
		ma_sotuyen: null,
		lat: null,
		lon: null,
		stt_theotuyen: null,
		danhsachnode: null
	};
	nodeNear_KT =null;
var soLanChuyenTuyen = 0;
var dsTuyenDaChon = [];
function initMap(){
	map.setView([10.029939, 105.7680404], 14);
	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				maxZoom: 18,
				attributionControl: false,
				prefix: '',
			}).addTo(map);
	map.on('click', onMapClick);
	map.locate({setView:true,maxZoom:16});
	map.on('locationfound', function (e) {
	setInfo(e.latlng.lat,e.latlng.lng,'frompoint');
	});
}

function onPopupOpen() {
    var tempMarker = this;

    $(".marker-delete-button:visible").click(function () {
        map.removeLayer(tempMarker);
        countMarker--;
    });
    $(".diemden:visible").click(function () {
    	 map.removeLayer(tempMarker);
    	  countMarker--;
        setInfo(tempMarker._latlng.lat,tempMarker._latlng.lng,'topoint');
    });
    $(".diemdi:visible").click(function () {
    	 map.removeLayer(tempMarker);
    	  countMarker--;
       setInfo(tempMarker._latlng.lat,tempMarker._latlng.lng,'frompoint');
    });

}

/*
param element
lấy dữ liệu tên trạm bus
output: none
*/
function clean(){
		$.each(map._layers, function (ml) {
		if (map._layers[ml].feature || map._layers[ml]._path != undefined) {
		 tram=this;
		  map.removeLayer(tram);
		 }	              	             
	});

}
function getDataFromTo(e){


	value=e.value;
	var dataString ='&data='+value;
		$.ajax
		({
		type: "POST",
		url: "php/content/function_ajax/getSearch.php",
		data: dataString,
		success: function(resultData) { 
		if(resultData=='') return;
			tram=resultData.split(';');
			setFormSearch(tram,e);
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
function setFormSearch(dataTram,e){
	id=e.id;
	idResult=id+"-result";
	document.getElementById(idResult).innerHTML="";
	for(i=0; i< dataTram.length;i++){
		if(!dataTram[i]) continue;
		tramT = jQuery.parseJSON(dataTram[i]);
		document.getElementById(idResult).innerHTML +='<p id="'+id+'" class="list-point" title="'+tramT.ten_tram+ "-"+tramT.ma_sotuyen+
		'" onmouseover="setValueInput(id,title);" onclick=document.getElementById("'+idResult+'").innerHTML="">'
		+tramT.ten_tram +" (mst: "+tramT.ma_sotuyen+")"+'</p>';
	}
}

/*
* param: id thẻ input
* lấy giá trị khi hover hoặc click vào element gán vào thẻ iput
  output: none
*/
function setValueInput(id,e){
	alert(mst);
	$('#'+id).val(e);
}



function searchBus(){
	clean();
	tmp =$('#frompoint').val();
	tmp=tmp.split('-');
	diemXP['ten_tram']=tmp[0];
	diemXP['ma_sotuyen']=tmp[1];
	tmp =$('#topoint').val();
	tmp=tmp.split('-');
	diemDen['ten_tram']=tmp[0];
	diemDen['ma_sotuyen']=tmp[1];
	if(diemXP['ten_tram']==diemDen['ten_tram']){
		thongbao('điểm đi phải khác điểm đến.');
		return ;
	}
	if(diemXP['ten_tram']===""){
		$('#frompoint').focus();
		return ;
	}
	if(diemDen['ten_tram']===""){
		$('#topoint').focus();
		return ;
	}
	getToaDo("getToaDoAll");
}

function getToaDo(action){
	data = {
		action: action,
		data: null
	};
	$.ajax({
			url:"php/content/function_ajax/timduong.php",
			data: data,
			type:'POST',
			success: function(data){
				if(data[0]=='-') {
					thongbao('loi') ;
					return;
				}
			
				 xuly(data);
			}
		});
}
function getXuatPhat_KT(dstrambus){

	for(i=0;i<dstrambus.length;i++){
		if((dstrambus[i])['ten_tram']==diemXP['ten_tram'] && (dstrambus[i])['ma_sotuyen']==diemXP['ma_sotuyen'] ){
				diemXP['ma_tram']=(dstrambus[i])['ma_tram'];
				diemXP['ma_sotuyen']=(dstrambus[i])['ma_sotuyen'];
				diemXP['lat']=(dstrambus[i])['lat'];
				diemXP['lon']=(dstrambus[i])['lon'];
				diemXP['stt_theotuyen']=(dstrambus[i])['stt_theotuyen'];
				diemXP['danhsachnode']=(dstrambus[i])['danhsachnode'];
				newTram(diemXP['lat'],diemXP['lon'],diemXP['ten_tram'],0);
				dstrambus.splice(i,1);

		} 
		else if((dstrambus[i])['ten_tram']==diemDen['ten_tram'] && (dstrambus[i])['ma_sotuyen']==diemDen['ma_sotuyen']){
				diemDen['ma_tram']=(dstrambus[i])['ma_tram'];
				diemDen['ma_sotuyen']=(dstrambus[i])['ma_sotuyen'];
				diemDen['lat']=(dstrambus[i])['lat'];
				diemDen['lon']=(dstrambus[i])['lon'];
				diemDen['stt_theotuyen']=(dstrambus[i])['stt_theotuyen'];
				diemDen['danhsachnode']=(dstrambus[i])['danhsachnode'];
				newTram(diemDen['lat'],diemDen['lon'],diemDen['ten_tram'],0);

		}
	}
	nodeNear_KT =getNear(diemDen,dstrambus);
}

function getNear(node,dstrambus){
		node_near_kt =null;
		if(node['ma_sotuyen']==null){
		node_near_kt =null;
		khoangcach_tmp = 99999999999999999;
		for(i=0;i<dstrambus.length;i++){
			kc =parseFloat(tinhkhoangcach(dstrambus[i],node));
			if( kc< khoangcach_tmp){
				khoangcach_tmp  = kc;
				node_near_kt = dstrambus[i];
			}
		}
	}
	return node_near_kt;
}
function xuly(data){
	dstrambus=tachdulieu(data);
	getXuatPhat_KT(dstrambus);
	for(i=0;i<dstrambus.length;i++){
		(dstrambus[i])['khoangcach']=tinhkhoangcach(dstrambus[i],diemXP);
		}
	dstrambus=sapxep(dstrambus);
	console.log(dstrambus);
	//khongchuyentuyen(dstrambus);
	dijsktra(dstrambus);
	//getNode();

}

function getDSTuyen(mst,data){
		var result=[];
		for(i=0;i<data.length;i++){
			if(data[i]['ma_sotuyen']==mst) result.push(data[i]);
		}
		result.sort(
		function(a , b){
			if ( parseInt(a['stt_theotuyen']) >  parseInt(b['stt_theotuyen'])) return 1;
			if ( parseInt(a['stt_theotuyen']) <  parseInt(b['stt_theotuyen'])) return -1;
			return 0;
		       }
			);
		return result;

}
function khongchuyentuyen(dstrambus){
	var tuyenHienTai= null;
	var stt_bd = -1;
	var stt_kt = -1;
	if(diemXP['ma_sotuyen']==null) {
		tuyenHienTai = dstrambus[0]['ma_sotuyen'];
		tramHientai = dstrambus[0];
		stt_bd =dstrambus[0]['stt_theotuyen'];
	}
	else {
		tuyenHienTai = diemXP['ma_sotuyen'];
		stt_bd = diemXP['stt_theotuyen'];
		tramHientai = diemXP;
	}
	diemBD =tramHientai;
	dsTuyenDaChon =[];
	DStram =  getDSTuyen(tuyenHienTai ,dstrambus);
	for(i=0; i<DStram.length;i++){
		tramHientai = DStram[i];
	
	   if(DStram[i]['ma_tram']==diemDen['ma_tram']) break;
        if(
       	   	      parseFloat(tinhkhoangcach(tramHientai,diemBD))
       	   	     > 
       	   	      parseFloat(tinhkhoangcach(diemBD,diemDen))
       	) break;
        	

    	stt_kt = DStram[i]['stt_theotuyen'];
	}
	dsTuyenDaChon = getDStheotuyen(stt_bd,stt_kt,tuyenHienTai,DStram);
	console.log(stt_kt);
}

function tachdulieu(data){
	dstrambus_raw=data.split(';');
	
	var dstrambus=[];
	for(i=0;i<dstrambus_raw.length;i++){
		if(!dstrambus_raw[i]) continue;
		tmp=JSON.parse(dstrambus_raw[i]);
		dstrambus.push(tmp);
	}
	return dstrambus;
}

function tinhkhoangcach(a,b){
lat_a=a['lat'];
lon_a=a['lon'];
lat_b=b['lat'];
lon_b=b['lon'];
R = 6373.0 ;
 dLat = (lat_b - lat_a) * (Math.PI / 180);
 dLon = (lon_b - lon_a) * (Math.PI / 180);
 la1ToRad = lat_a * (Math.PI / 180);
 la2ToRad = lat_b * (Math.PI / 180);
 a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(la1ToRad)
* Math.cos(la2ToRad) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
 c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
 d = R * c;
return parseFloat(d*1000).toFixed(4);
}

function convenr_km(m){
return  parseFloat(m/1000).toFixed(2)+ " km";
}
function sapxep(data){
	data.sort(
		function(a , b){
			if ( parseFloat(a['khoangcach']) >  parseFloat(b['khoangcach'])) return 1;
			if ( parseFloat(a['khoangcach']) <  parseFloat(b['khoangcach'])) return -1;
			return 0;
		       }
			);
	console.log(data);
	return data;
}

function getDStheotuyen(stt_bd,stt_kt,mst,data){
	var result=[];
		for(i=0;i<data.length;i++){
			if(data[i]['ma_sotuyen']!=mst) continue;
			if(parseInt(data[i]['stt_theotuyen'])>=parseInt(stt_bd)&&parseInt(data[i]['stt_theotuyen'])<=parseInt(stt_kt))
			result.push(data[i]);
		}
		result.sort(
		function(a , b){
			if ( parseInt(a['stt_theotuyen']) >  parseInt(b['stt_theotuyen'])) return 1;
			if ( parseInt(a['stt_theotuyen']) <  parseInt(b['stt_theotuyen'])) return -1;
			return 0;
		       }
			);
		return result;

}
function thongbao(tb){
	$('#thongbao').html(tb).parent().fadeIn().delay(1000).fadeOut('slow');
}

// function ve duong
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
    iconSize:     [0, 0], // size of the icon
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

            }).bindPopup("<span>"+name+"</span>");

            marker.on("popupopen", onPopupOpen);
  
       		if(value==0) marker.setIcon(getIcon('tram'));
       		if(value==1) marker.setIcon(getIcon('node'));
       		if(value==2) marker.setIcon(getIcon('root'));
            return marker;
        }
    }).addTo(map);
    tuychon=1;

    map.setView([lat, lon], 14);
    return  marker;

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

}

function getNode(){

	if(dsTuyenDaChon.length<=0){
		polyline = L.polyline([{lat: diemXP['lat'],lng: diemXP['lon']},{lat: diemDen['lat'],lng: diemDen['lon']}], {color: '#000000'}).addTo(map);
	}
	if(diemXP['ma_tram']!=null) dsTuyenDaChon.unshift(diemXP);

	else{
		tram =dsTuyenDaChon[0];
		latlng = {lat: tram['lat'], lng: tram['lon']};
		polyline = L.polyline([latlng,{lat: diemXP['lat'],lng: diemXP['lon']}], {color: '#000000'}).addTo(map);
	}
	var pon = [];
	for(i=0;i<dsTuyenDaChon.length;i++){
		tram =dsTuyenDaChon[i];
		newTram(tram['lat'],tram['lon'],tram['ten_tram'],0);
		latlng = {lat: tram['lat'], lng: tram['lon']};
		pon.push(latlng);
		if(i==dsTuyenDaChon.length-1) break;
		if(tram['danhsachnode']=="null"||tram['danhsachnode']==null) continue;
		dsnode=jQuery.parseJSON(tram['danhsachnode']);
		for(j=0;j<dsnode.length;j++){
			newTram(dsnode[j].lat,dsnode[j].lng,'node',1);
			latlng = {lat: dsnode[j].lat,lng: dsnode[j].lng};
		    pon.push(latlng);
		}

	}
	polyline = L.polyline(pon, {color: '#00ff00'}).addTo(map);
	if(diemDen['ma_tram']==null||diemDen['ma_sotuyen']!=dsTuyenDaChon[0]['ma_sotuyen'])polyline = L.polyline([latlng,{lat: diemDen['lat'],lng: diemDen['lon']}], {color: '#000000'}).addTo(map);
	else polyline = L.polyline([latlng,{lat: diemDen['lat'],lng: diemDen['lon']}], {color: '#00ff00'}).addTo(map);
}

function dijsktra(dstrambus){

	if(diemXP['ma_sotuyen']!=null) {
		dstrambus.unshift(diemXP);
	}
	else {
		
	}
	OpenNode = dstrambus;
	setUpTrongSo(OpenNode);
	CloseNode =[];
	while(dstrambus.length > 0){
		nodeDangXet = OpenNode.shift();
		CloseNode.push(nodeDangXet);
		capNhatTrongSo(nodeDangXet,OpenNode);
		timMin(OpenNode);
	}
	getNodedijsktra(CloseNode);
}


function setUpTrongSo(OpenNode){
	for(i=0;i<OpenNode.length;i++){
		OpenNode[i]['khoangcach']=99999999999999;
		OpenNode[i]['giave']=9999999999999999;
	}
	OpenNode[0]['khoangcach'] =0;
	OpenNode[0]['giave'] =5000;
	OpenNode[0]['cha'] =null;
}


function capNhatTrongSo(nodeDangXet,OpenNode){
	for(i=0;i<OpenNode.length;i++){
		//cung tuyen
		if(nodeDangXet['ma_sotuyen']==OpenNode[i]['ma_sotuyen']){
			//tim node gan ke tiep theo
			 if(nodeDangXet['stt_theotuyen'] != OpenNode[i]['stt_theotuyen']-1) continue;
		}
		giaveTmp =nodeDangXet['giave'];
		if(OpenNode[i]['ma_sotuyen']!=nodeDangXet['ma_sotuyen']) giaveTmp= nodeDangXet['giave']+ 5000;
		if(giaveTmp < OpenNode[i]['giave']){
				OpenNode[i]['giave'] = giaveTmp;
				OpenNode[i]['khoangcach'] =parseFloat(nodeDangXet['khoangcach']) + parseFloat(tinhkhoangcach(nodeDangXet,OpenNode[i]));
				OpenNode[i]['cha'] =nodeDangXet;
		}else if(giaveTmp == OpenNode[i]['giave']){
			if(parseFloat(nodeDangXet['khoangcach'] + tinhkhoangcach(nodeDangXet,OpenNode[i])) < parseFloat(OpenNode[i]['khoangcach'])){
				OpenNode[i]['khoangcach'] = parseFloat(nodeDangXet['khoangcach']) + parseFloat(tinhkhoangcach(nodeDangXet,OpenNode[i]));
			    OpenNode[i]['cha'] =nodeDangXet;
			}
		}
	}
}

function timMin(OpenNode){
	OpenNode.sort(
		function(a , b){
			if ( parseInt(a['giave']) >  parseInt(b['giave'])) return 1;
			if ( parseInt(a['giave']) ==  parseInt(b['giave'])){
				if(parseFloat(a['khoangcach']) > parseFloat(b['khoangcach'])) return 1;
				if(parseFloat(a['khoangcach']) < parseFloat(b['khoangcach'])) return -1;
				return 0;
			} 
			if (parseInt(a['giave']) <  parseInt(b['giave'])) return -1;
			return 0;
		       }
			);
}

					

function getNodedijsktra(CloseNode){
	$('#chiduong').css('display','block');
	css_bd = "<table cellpadding='0' cellspacing='0'><tr class='rowStop'><td>";
	css_kt="</td></tr></table>";
	if(diemXP['ma_tram']==null)html ="<a href='#' class='dstbus' onclick='showMarker(-1); return false;'>"+css_bd+ "<img src='icon/bd.jpg' width ='20px' height ='20px'>Vị trí của bạn: " +diemXP['ten_tram']+css_kt+"</a>";
	else html ="<a href='#' class='dstbus' onclick='showMarker(-1); return false;'>"+css_bd+ "<span class='icon-stt'>"+diemXP['ma_sotuyen']+"</span>Xuất phát từ trạm: " +diemXP['ten_tram']+css_kt+"</a>";
	kq=null;
	diemDen_tmp= null;
	if(diemDen['ma_sotuyen']==null) {
		diemDen_tmp =  diemDen;
		diemDen = nodeNear_KT;
	}
	for(i=0;i<CloseNode.length;i++){
		if(CloseNode[i]['ma_tram']==diemDen['ma_tram']){
			kq=CloseNode[i];
			break;
		}
	}
	dsTuyenDaChon =[];
	dsTuyenDaChon.unshift(kq);
	while (kq['cha']!=null) {
		dsTuyenDaChon.unshift(kq['cha']);
		kq = kq['cha'];
	}
	if(dsTuyenDaChon.length<=0){
		polyline = L.polyline([{lat: diemXP['lat'],lng: diemXP['lon']},{lat: diemDen['lat'],lng: diemDen['lon']}], {color: '#000000'}).addTo(map);
	}
	if(diemXP['ma_tram']!=null) {

	}
	else{

		html +="<a href='#' class='dstbus' onclick='showMarker(0); return false;'>"+css_bd + "<img src='icon/walk.png' width ='20px' height ='20px'>Đi bộ đến trạm: " + dsTuyenDaChon[0]['ten_tram']+"("+dsTuyenDaChon[0]['ma_sotuyen']+")"+" Khoảng cách: " +convenr_km(tinhkhoangcach(diemXP, dsTuyenDaChon[0]))+css_kt+"</a>";
		tram =dsTuyenDaChon[0];
		latlng = {lat: tram['lat'], lng: tram['lon']};
      	polyline = L.polyline([latlng,{lat: diemXP['lat'],lng: diemXP['lon']}], {color: '#000000'}).addTo(map);
	}
	var pon = [];
	var marker;
	for(i=0;i<dsTuyenDaChon.length;i++){
	   
		tram =dsTuyenDaChon[i];
		if(i==0||i==dsTuyenDaChon.length-1)  marker =newTram(tram['lat'],tram['lon'],tram['ten_tram'],2);
		else  marker  = newTram(tram['lat'],tram['lon'],tram['ten_tram'],0);
		dsTuyenDaChon[i]['marker'] =  marker ;
		latlng = {lat: tram['lat'], lng: tram['lon']};
		pon.push(latlng);
		if(i==dsTuyenDaChon.length-1) break;
		if(dsTuyenDaChon[i]['ma_sotuyen']!=dsTuyenDaChon[i+1]['ma_sotuyen']) {
			html +="<a href='#' class='dstbus' onclick='showMarker("+i+"); return false;'>"+css_bd+"<img src='icon/xuongxe.png' width ='40px' height ='20px'>Xuống xe tại trạm: " + dsTuyenDaChon[i]['ten_tram'] +css_kt+"</a>";
			html +="<a href='#' class='dstbus' onclick='showMarker("+(i+1)+"); return false;'>"+css_bd+"<img src='icon/walk.png' width ='20px' height ='20px'>Đi bộ tới trạm: " + dsTuyenDaChon[i+1]['ten_tram']+" Khoảng cách: " +convenr_km(tinhkhoangcach( dsTuyenDaChon[i],dsTuyenDaChon[i+1])) +css_kt+"</a>";
			continue;
		}
		if(i>1&&dsTuyenDaChon[i]['ma_sotuyen']!=dsTuyenDaChon[i-1]['ma_sotuyen']){
			html +="<a href='#' class='dstbus' onclick='showMarker("+(i)+"); return false;'>"+css_bd+"<img src='icon/lenXe.png' width ='40px' height ='20px'> Đón xe tại trạm: " + dsTuyenDaChon[i]['ten_tram'] +css_kt+"</a>";
			continue;
		}
		 if(i>0) html +="<a href='#' class='dstbus' onclick='showMarker("+i+"); return false;'>"+css_bd+"<img src='icon/clickHere.jpg' width = '20px' height = '20px'>Qua trạm: " + dsTuyenDaChon[i]['ten_tram']+css_kt+"</a>";
		tuyenHienTai = dsTuyenDaChon[i]['ma_sotuyen'];
		if(tram['danhsachnode']=="null"||tram['danhsachnode']==null) continue;
		dsnode=jQuery.parseJSON(tram['danhsachnode']);
		for(j=0;j<dsnode.length;j++){
			newTram(dsnode[j].lat,dsnode[j].lng,'node',1);
			latlng = {lat: dsnode[j].lat,lng: dsnode[j].lng};
		    pon.push(latlng);
		}

	}
	polyline = L.polyline(pon, {color: '#00ff00'}).addTo(map);
	for(i=0;i<dsTuyenDaChon.length-1;i++){
		if(dsTuyenDaChon[i]['ma_sotuyen']!=dsTuyenDaChon[i+1]['ma_sotuyen']){
			L.polyline([{lat: dsTuyenDaChon[i]['lat'],lng: dsTuyenDaChon[i]['lon']},{lat: dsTuyenDaChon[i+1]['lat'],lng: dsTuyenDaChon[i+1]['lon']}], {color: '#000000'}).addTo(map);
		}
	}

	if(diemDen_tmp !=null || diemDen['ma_sotuyen']!=dsTuyenDaChon[dsTuyenDaChon.length-1]['ma_sotuyen'])
		polyline = L.polyline([latlng,{lat: diemDen_tmp['lat'],lng: diemDen_tmp['lon']}], {color: '#000000'}).addTo(map);
	else polyline = L.polyline([latlng,{lat: diemDen['lat'],lng: diemDen['lon']}], {color: '#00ff00'}).addTo(map);
html +="<a href='#' class='dstbus' onclick='showMarker("+i+"); return false;'>"+css_bd+"<img src='icon/bd.jpg' width ='20px' height ='20px'>Dừng tại điểm đích: " + dsTuyenDaChon[i]['ten_tram'] +css_kt+"</a>";

$('#chiduong').html(html);
openListBus();
}

function showMarker(index){
if(index==-1) {
	diemXP.marker.openPopup();
	return false;
}
dsTuyenDaChon[index].marker.openPopup();
map.setView([dsTuyenDaChon[index]['lat'], dsTuyenDaChon[index]['lon']], 14);
return false;
}
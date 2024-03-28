
var dstrambus=[];
var dstrambus_tmp=[];
var xuatphat=["110.029939",	"105.7680404",	"node/5423964222",	"1"];
var kethuc=["10.0264634",	"105.7703284",	"node/3160616370",	"1"];

function tachdulieu(data){
	dstrambus_raw=data.split(';');
	//console.log(dstrambus_raw);
	for(i=0;i<dstrambus_raw.length;i++){
		tram=[];
		tram=dstrambus_raw[i].split(',');
		dstrambus.push(tram);

	}
}

//Tính khoảng cách 2 điểm
function tinhkhoangcach(a,b){
lat_a=a[0];
lon_a=a[1];
lat_b=b[0];
lon_b=b[1];
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
function sapxep(data){
	data.sort(
		function(a , b){
			if ( parseFloat(a[4]) >  parseFloat(b[4])) return 1;
			if ( parseFloat(a[4]) <  parseFloat(b[4])) return -1;
			return 0;
		       }
			);
}
function tinhherictic(){
	for(i=0;i<dstrambus.length;i++){
	(dstrambus[i])[5]=tinhkhoangcach(dstrambus[i],kethuc);
	}
}
function timkhoancach_min(a){
	a[4]=9999999999999999;
	for(i=0;i<dstrambus_tmp.length;i++){
			if((dstrambus_tmp[i])[2]==a[2]) continue;
			(dstrambus_tmp[i])[4]=tinhkhoangcach(dstrambus_tmp[i],a);
		}
	sapxep(dstrambus_tmp);
	return dstrambus_tmp[0];
}

// Lấy tọa độ 1 điểm
function get_toado_bus(){
	data = {
		vitri_bd: "x1",
		vitri_kt: "x2"
	};
	$.ajax("php/get_toado_bus.php", {
			data: data,
			success: function(data){
				if(data[0]=='-') {alert('loi') ;return 0;}
				xuly(data);
			}
		});


}


function kiemtra_thuoc(giatri,mang){
	for(i=0;i<mang.length-1;i++){
		if(giatri[2]==(mang[i])[2]) return true;
	}
	return false;
}
function khoitao_G_F_H_Cha(){
	for(i=0;i<dstrambus.length;i++){
		dstrambus[i].push(0);
		dstrambus[i].push(0);
		dstrambus[i].push(0);
		dstrambus[i].push(0);
	}
}
function giaithuat_Asao(){
	khoitao_G_F_H_Cha();
	console.log(dstrambus[1]);
// (dstrambus[i])[7]: G, (dstrambus[i])[8]: F, (dstrambus[i])[9]: H , (dstrambus[i])[10]: Cha
	n= dstrambus.shift();
	var open=[];
	var closed=[];
	//dua tam vao open
	open.push(n);
	while(open.length>0){
		//loai phan tu ben trai open dua vao close
		n=open.shift();
		closed.push(n);
		if(n[2]==kethuc[2]) break;
		for(i=0;i<dstrambus.length;i++){
			Gn_tmp=n[7]+ tinhkhoangcach(dstrambus[i],n);
			if(kiemtra_thuoc(dstrambus[i],open)==false && kiemtra_thuoc(dstrambus[i],closed)==false){
				(dstrambus[i])[8]=Gn_tmp+(dstrambus[i])[5];
				(dstrambus[i])[10]=n[2];
				open.push(dstrambus[i]);
			}
			else if(kiemtra_thuoc(dstrambus[i],open)==true){
					if(Gn_tmp<(dstrambus[i])[7]){
						(dstrambus[i])[7]=Gn_tmp;
						(dstrambus[i])[8]=(dstrambus[i])[7]+(dstrambus[i])[5];
						(dstrambus[i])[10]=n[2];
					}
			}else if(kiemtra_thuoc(dstrambus[i],closed)==true){
						if(Gn_tmp<(dstrambus[i])[7]){
						(dstrambus[i])[8]=(dstrambus[i])[7]+(dstrambus[i])[5];
						(dstrambus[i])[10]=n[2];
						var k = closed.indexOf(dstrambus[i]);
						if (k != -1) {
						    closed.splice(k,1);
						}
						open.push(dstrambus[i]);
						sapxep(data);
					}

				}
		}
	}

}

function xuly(data){
	tachdulieu(data);
	xuatphat[4]=9999999999999999;
	for(i=0;i<dstrambus.length;i++){
		if((dstrambus[i])[2]==xuatphat[2]) continue;
		(dstrambus[i])[4]=tinhkhoangcach(dstrambus[i],xuatphat);
	}
	sapxep(dstrambus);
	tinhherictic();
	dstrambus_tmp=dstrambus;
	console.log(dstrambus[2]);
	console.log(timkhoancach_min(dstrambus[2]));
	giaithuat_Asao();
}
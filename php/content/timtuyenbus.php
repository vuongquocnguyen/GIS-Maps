<style type="text/css">
	#mapid{
		width: 1080px;
		height: 600px;
	}
</style>
<div class='tieude'>TÌM TUYẾN BUS</div>
	<div id="mapid"></div>
	<script>
		var mymap = L.map('mapid').setView([10.775375, 106.705737], 14);
		var marker = L.marker([10.775375, 106.705737]).addTo(mymap);
		marker.bindPopup("<b>HCMCT</b>").openPopup();
		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					maxZoom: 18,
					attributionControl: false,
					prefix: '',
				}).addTo(mymap);
				var popup = L.popup();

				mymap.on('click', function(ev){
				 	  var latlng = mymap.mouseEventToLatLng(ev.originalEvent);
				 	  console.log(latlng.lat + ', ' + latlng.lng);
				 	  var marker = L.marker([latlng.lat, latlng.lng],{title: "MyPoint", alt: "The Big I", draggable: true}).addTo(mymap);
				});

		// function onMapClick(e) { 
		// 			popup
		// 			.setLatLng(e.latlng)
		// 			.setContent("Vị trị của bạn là " + e.latlng.toString())
		// 			 .openOn(mymap);
		// 		}
		// 			mymap.on('click', onMapClick);
				
					//search
					/*var searchControl = L.esri.Geocoding.geosearch().addTo(mymap);
					var results = L.layerGroup().addTo(mymap);
						searchControl.on('results', function(data){
						results.clearLayers();
					    for (var i = data.results.length - 1; i >= 0; i--) {
					      results.addLayer(L.marker(data.results[i].latlng));
					    }
					  });*/
					//Đọc file geojson
					//var geojsonLayer = new L.GeoJSON.AJAX("/mygeodata/geojson.geojson");       
					//geojsonLayer.addTo(mymap);
					//Hiện thông tin
					/*var layerGroup = L.geoJSON(properties, {
						  onEachFeature: function (feature, layer) {
						    layer.bindPopup('<h1>id:'+feature.properties. id+'</h1><p>name:'+feature.properties.name+'</p>'+'</h1><p>highway: '+feature.properties.highway+'</p>'+'</h1><p>public_transport:'+feature.properties.public_transport+'</p>');
						  }
						}).addTo(mymap);*/
					
						//Tích hợp LRM
						/*routeControl = L.Routing.control({
							    waypoints: [
							    			L.latLng(10.7770988,106.7057925),
							                 L.latLng(10.7732703,106.7064278),
							                // L.latLng(10.7709405,106.7056442),
							                // L.latLng(10.7711146,106.7018736),
							                 L.latLng(10.771113,106.6997022),
							                 L.latLng(10.7691968,106.6996581),
							                  L.latLng(10.7687758,106.695905)
                               ],
                  lineOptions:{
                    styles: [{color: 'blue', opacity: 5, weight: 5}],
                    addWaypoints:false},
                  //router: L.Routing.graphHopper('16367e37-761c-49a9-b132-86e81ff97a23'),
							    routeWhileDragging: true,
							    show: true,
							    autoRoute: true
						}).addTo(mymap);
					/*var latlngs = [
							    			L.latLng(10.7770988,106.7057925),
							                 L.latLng(10.7732703,106.7064278),
							                L.latLng(10.7709405,106.7056442),
							                 L.latLng(10.7711146,106.7018736),
							                 L.latLng(10.771113,106.6997022),
							                 L.latLng(10.7691968,106.6996581),
							                  L.latLng(10.7687758,106.695905)
							];
					var polyline = L.polyline(latlngs, {color: 'red'}).addTo(mymap);*/
					// Instantiate a normal Polyline with an 'offset' options, in pixels.	
	</script>	
	<script type="text/javascript" src="js/leaflet.polylineoffset.js"></script>
	<script type="text/javascript" src="lib/jquery/jquery.js"></script>
	<script type="text/javascript" src="lib/jquery/jquery-ui.js"></script>
	<script type="text/javascript" src="lib/leaflet/leaflet-src.js"></script>
	<script type="text/javascript" src="js/main.js"></script> 
	<script type="text/javascript" src="js/timduong.js"></script>
</div>
<!--<button style="position: absolute;bottom: 10px; left: 5px;" onclick="get_toado_bus();">Tìm</button>-->	
		
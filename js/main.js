/*	PostGIS and Leaflet demo for Cart Lab Education Series, April 17, 2015	**
**	By Carl Sack, CC-BY-3.0													*/

//global variables
var fields = ["lat", "lon", "name"],autocomplete = [];

function getData(){
	$.ajax("php/getData.php", {
		data: {
			table: "rels",
			fields: fields
		},
		success: function(data){
			alert(data);
			mapData(data);
		}
	})
};

function mapData(data){
	//remove existing map layers
	mymap.eachLayer(function(layer){
		//if not the tile layer
		if (typeof layer._url === "undefined"){
			mymap.removeLayer(layer);
		}
	});

	//create geojson container object
	var geojson = {
		"type": "FeatureCollection",
		"features": []
	};

	//split data into features
	var dataArray = data.split(", ;");
	dataArray.pop();
    
    //console.log(dataArray);
	
	//build geojson features
	kt=0;
	dataArray.forEach(function(d){
		d = d.split(", "); //split the data up into individual attribute values and the geometry
		//feature object container
		//alert('x:'+d[1]+'y:'+d[0]);
		L.marker([d[0],d[1]]).addTo(mymap);
		if(kt==0) {
			mymap.setView([d[0],d[1]], 14);
			kt=1;
		}
		//return 0;
		var feature = {
			"type": "Feature",
			"properties": {}, //properties object container

		};
		for (var i=0; i<fields.length; i++){
			feature.properties[fields[i]] = d[i];
		};
		//add feature names to autocomplete list
		if ($.inArray(feature.properties.featname, autocomplete) == -1){
			autocomplete.push(feature.properties.featname);
		};

		geojson.features.push(feature);
	});
	
    //console.log(geojson.features[0].properties.lat);
     console.log(geojson);
    //activate autocomplete on featname input
    $("input[name=from-point]").autocomplete({
        source: autocomplete
    });
//
	var mapDataLayer = L.geoJson(geojson, {
		pointToLayer: function (feature, latlng) {
			var markerStyle = { 
				fillColor: "#CC9900",
				color: "#FFF",
				fillOpacity: 0.5,
				opacity: 0.8,
				weight: 1,
				radius: 8
			};

			return L.circleMarker(latlng, markerStyle);
		},
		onEachFeature: function (feature, layer) {
			var html = "";
			for (prop in feature.properties){
				html += prop+": "+feature.properties[prop]+"<br>";
			};
	        layer.bindPopup(html);
	    }
	}).addTo(mymap);
};

function submitQuery(){
	//get the form data
	var formdata = $("form").serializeArray();

	//add to data request object
	var data = {
		table: "rels",
		fields: fields
	};
	formdata.forEach(function(dataobj){
		console.log(dataobj.name);
		data[dataobj.name] = dataobj.value;
	});

	//call the php script
	$.ajax("php/getData.php", {
		data: data,
		success: function(data){
			alert(data);
			mapData(data);
	
		}
	})
};
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />   
<icon src="icon/icon.png" platform="android" width="57" height="57" density="mdpi" />
<link rel="icon" type="image/png" href="http://sstatic.net/stackoverflow/img/favicon.ico">
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
<script src="http://www.liedman.net/lrm-graphhopper/dist/lrm-graphhopper-1.2.0.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<style>
.row #mapid{
   position: absolute;
   top: 0px;
   width: 98%;
   margin-left:1%;
   height: 600px;
   z-index:1;
}
#mapid button{
    width:50%;
    height:20px;
    color:#CCC;
    padding:0px;
}
</style>  
        <div id="mapid">

            <script>
                var mymap = L.map('mapid').fitWorld();                
                // mymap.locate({setView: true, maxZoom: 14});
                // var marker = L.marker([10.775375, 106.705737]).addTo(mymap);
                // marker.bindPopup("<b>HCMCT</b>").openPopup();
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 22,
                            attributionControl: false,
                            prefix: '',
                        }).addTo(mymap);
                        /*Nhấp chuột trên bảng đồ
                        var popup = L.popup();      
                        mymap.on('click', function(ev){
                               var latlng = mymap.mouseEventToLatLng(ev.originalEvent);
                               console.log(latlng.lat + ', ' + latlng.lng);
                               var marker = L.marker([latlng.lat, latlng.lng],{title: "MyPoint", alt: "The Big I", draggable: true}).addTo(mymap);
                        });*/
                        /*Lấy vị trí hiện tại
                        function onLocationFound(e) {
                          var radius = e.accuracy / 2;

                          L.marker(e.latlng).addTo(mymap)
                              .bindPopup("You are within " + radius + " meters from this point").openPopup();

                          //L.circle(e.latlng, radius).addTo(mymap);
                          }
                          mymap.on('locationfound', onLocationFound);
                          function onLocationError(e) {
                              alert(e.message);
                          }
                          mymap.on('locationerror', onLocationError);*/
                          L.Routing.control({
                              waypoints: [
                                    L.latLng(10.03067,105.76858),
                                    L.latLng(10.0231261,105.7668441)
                                          ],
                              language: 'en',
                              lineOptions:{
                              styles: [{color: 'red', opacity: 5, weight: 5}],
                              addWaypoints:false},
                              router: L.Routing.graphHopper('16367e37-761c-49a9-b132-86e81ff97a23'),
                              routeWhileDragging: true,
                              show: true,
                              autoRoute: true,
                              geocoder: L.Control.Geocoder.nominatim()
                        }).addTo(mymap);
                </script>    
        </div>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-3.4.0.min.js"></script>
<script src="js/index.js"></script>
<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script src="http://code.jquery.com/ui/1.8.21/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
<script>$('#mydiv').draggable();</script>
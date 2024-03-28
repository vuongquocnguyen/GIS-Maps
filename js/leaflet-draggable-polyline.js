
var nodeIcon = L.icon({
    iconUrl: 'icon/nodeIcon.png',
    iconSize:     [15, 15], // size of the icon
    shadowSize:   [60,60], // size of the shadow
    iconAnchor:   [7, 7], // point of the icon which will correspond to marker's location
    shadowAnchor: [4, 20],  // the same for the shadow
    popupAnchor:  [0, -15] // point from which the popup should open relative to the iconAnchor
  });
L.EditDrag = L.EditDrag || {};
  var id_near;
L.EditDrag.Polyline = L.Handler.extend({

  options: {
    distance: 20,   //distance from pointer to the polyline
    tollerance: 5,  //tollerance for snap effect to vertex
    vertices: {
      //first: true,  //first vertex is draggable
      //middle: true, //middle vertices are draggables
      //last: true,   //last vertex draggable
      //insert: true, //define if the number of polyline's vertices can change
    },
    icon: new L.icon({
    iconUrl: 'icon/nodeIcon.png',
    iconSize:     [15, 15], // size of the icon
    shadowSize:   [60,60], // size of the shadow
    iconAnchor:   [7, 7], // point of the icon which will correspond to marker's location
    shadowAnchor: [4, 20],  // the same for the shadow
    popupAnchor:  [0, -15] // point from which the popup should open relative to the iconAnchor
  })
  },

  initialize: function(poly) {
    this._poly = poly;
    this._marker = null;
    this._dragging = false;
    L.Util.setOptions(this, poly.options);
  },

  addHooks: function() {
    if (this._poly._map) {
      this._map = this._poly._map;
      this._map.on('mousemove', this._mouseMove, this);
    }
  },

  removeHooks: function() {
    this._map.off('mousemove');
  },

  /**
  * return the closest point on the closest segment
  */

  _getClosestPointAndSegment: function(latlng) {
    var distanceMin = Infinity;
    var segmentMin = null;

    for (var i = 0, len = (this._poly._latlngs.length - 1); i < len; i++) {

      var segment = [ this._poly._latlngs[i], this._poly._latlngs[i + 1] ];
      var distance = L.GeometryUtil.distanceSegment(this._map, latlng, segment[0], segment[1]);
      if (distance < distanceMin) {
        distanceMin = distance;
        segmentMin = segment;
        
      }
    }
   
      $.each(map._layers, function (ml) {
             
              if (map._layers[ml].feature) {
                  if(this._latlng==segmentMin[1]) id_near=this._leaflet_id;
              }
          });


    return { point: L.GeometryUtil.closestOnSegment(this._map, latlng, segmentMin[0], segmentMin[1]) , segment: segmentMin };
  },

  _mouseContextClick: function(e) {
    var closest = L.GeometryUtil.closest(this._map, this._poly, e.latlng, true);

    if (this.options.vertices.destroy !== false && closest.distance < this.options.tollerance) {
      var index = this._poly._latlngs.indexOf(closest);
      var maxIndex = (this._poly._latlngs.length - 1);
      if ((this.options.vertices.first === false && index == 0) || (this.options.vertices.last === false && index == maxIndex)) {
        return;
      }
      this._poly.spliceLatLngs(index, 1);
      this._map.removeLayer(this._marker);
      this._marker = null;
    }
  },

  _mouseMove: function(e) {
    if (this._dragging) return;

    var closest = L.GeometryUtil.closestLayerSnap(this._map, [this._poly], e.latlng, this.options.distance, false);

    if (this._marker && closest) {
      this._marker.addTo(this._map);
      L.extend(this._marker._latlng, closest.latlng);
      this._marker.options.draggable = true;
      this._marker.update();

    } else if (!this._marker && closest) {
      this._marker = L.marker(closest.latlng, { draggable: true, icon: this.options.icon }).addTo(this._map);
      this._marker.on('dragstart', this._markerDragStart, this);
      this._marker.on('drag', this._markerDrag, this);
      this._marker.on('dragend', this._markerDragEnd, this);
      this._marker.on('contextmenu', this._mouseContextClick, this);


    } else if (this._marker) {
     // this._map.removeLayer(this._marker);
      //this._marker = null;
      map.addLayer(this._marker);
    }
  },

  _isInvalidDrag: function(index) {
    var maxIndex = (this._poly._latlngs.length - 1);

    if ((this.options.vertices.first === false && index == 0) ||
        (this.options.vertices.last === false && index == maxIndex) ||
        (this.options.vertices.middle === false && (index > 0 && index < maxIndex))) {
      return true;
    }

    if ((this.options.vertices.middle === false || this.options.vertices.insert === false) && index === -1) {
      return true;
    }

    return false;
  },

  _markerDragStart: function(e) {
    var latlng = e.target.getLatLng();

    this.closest = L.GeometryUtil.closest(this._map, this._poly, latlng, true);
    this._dragging = true;
    //check the tollerance
    if (this.closest.distance < this.options.tollerance) {
      var index = this._poly._latlngs.indexOf(this.closest);

      if (this._isInvalidDrag(index)) {
        this.closest = null;
        this._marker.options.draggable = false;
      }

    } else {
      this.closest = this._getClosestPointAndSegment(latlng);
      var index = this._poly._latlngs.indexOf(this.closest);
      if (this._isInvalidDrag(index)) {
        this.closest = null;
        this._marker.options.draggable = false;
        return;
      }

      //add a new vertex
      var insertAt = this._poly._latlngs.indexOf(this.closest.segment[1]);

      this._poly._latlngs.splice(insertAt, 0, this.closest);
    }
  },

  _markerDrag: function(e) {
    if (this.closest) {
      this.closest.lat = e.target.getLatLng().lat;
      this.closest.lng = e.target.getLatLng().lng;
      this._poly.redraw();
    }
  },

  _markerDragEnd: function(e) {
    this._dragging = false;
    

var geojsonFeature = {
        "type": "Feature",
            "properties": {},
            "geometry": {
                "type": "Point",
                "coordinates": [this.closest.lat,this.closest.lng]
        }
    }
    
      var map_tmp=[];
      $.each(map._layers, function (ml) {
             
              if (map._layers[ml].feature) {
                  map_tmp.push(map._layers[ml]);
          
              }
              map.removeLayer(this);
          });
for(i=0;i<map_tmp.length;i++){
  if(map_tmp[i]._leaflet_id==id_near){
       k= L.geoJson(geojsonFeature, {   
        pointToLayer: function(feature, latlng){
          var marker;
     marker = L.marker(geojsonFeature.geometry.coordinates, {
                
                title: "node",
                alt: "node",
                riseOnHover: true,
                draggable: true,

            }).bindPopup("<input type='button' value='Delete this marker' class='marker-delete-button'/>");

            marker.on("popupopen", onPopupOpen);
            marker.on("moveend",function(e){
              updateline();
            });    
            return marker;
        }
    });   
       console.log(k);
       k._leaflet_id=id_near-1;
       k.addTo(map);
  }
  map_tmp[i].addTo(map);
  console.log(map_tmp[i]._leaflet_id);
}

   $.each(map._layers, function (ml) {
    if (map._layers[ml].feature) { console.log(this._leaflet_id);}
   });
  }
});

L.Polyline.addInitHook(function() {

  if (this.edit_with_drag) {
    return;
  }

  if (L.EditDrag.Polyline) {
    this.editingDrag = new L.EditDrag.Polyline(this);

    if (this.options.edit_with_drag) {
      this.editingDrag.enable();
    }
  }

  this.on('add', function () {
    if (this.editingDrag && this.editingDrag.enabled()) {
      this.editingDrag.addHooks();
    }
  });

  this.on('remove', function () {
    if (this.editingDrag && this.editingDrag.enabled()) {
      this.editingDrag.removeHooks();
    }
  });
});
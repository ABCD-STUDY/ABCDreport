  var locations = [];
   locations[0] = { 'lat': "32.8810848", 'lng': "-117.231142225131", 'name': "University of California, San Diego" };
   locations[1] = { 'lat': "34.0722", 'lng': "-118.4441", 'name': "University of California, Los Angeles" };
   locations[2] = { 'lat': "35.2086", 'lng': "-97.4458", 'name': "University of Oklahoma" };
   locations[3] = { 'lat': "25.757684", 'lng': "-80.376139", 'name': "Florida International University" };
   locations[4] = { 'lat': "37.457273", 'lng': "-122.176139", 'name': "SRI International" };
   locations[5] = { 'lat': "19.663790", 'lng': "-155.544668", 'name': "Hawaii University" };
   locations[6] = { 'lat': "40.007655", 'lng': "-105.265877", 'name': "Boulder University" };
   locations[7] = { 'lat': "40.442926", 'lng': "-79.961071", 'name': "University of Pittsburgh" };
   locations[8] = { 'lat': "37.548911", 'lng': "-77.453337", 'name': "Virginia Commonwealth University" };
   locations[9] = { 'lat': "40.765270", 'lng': "-111.842258", 'name': "University of Utah" };
   locations[10] = { 'lat': "42.453766", 'lng': "-76.473524", 'name': "Cornell University" };
   locations[11] = { 'lat': "45.499007", 'lng': "-122.686182", 'name': "Oregon health & Science University" };
   locations[12] = { 'lat': "38.648991", 'lng': "-90.310517", 'name': "Washington University St. Louis" };
   locations[13] = { 'lat': "40.789674", 'lng': "-73.951403", 'name': "Mount Sinai University" };
   locations[14] = { 'lat': "29.644267", 'lng': "-82.353235", 'name': "University of Florida" };


     function initialize() {
        var MY_MAPTYPE_ID = 'custom_style';
        var mapOptions = {
            center: new google.maps.LatLng(32.870676, -117.236019),
	          mapTypeControlOptions: {
	             mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
            },
            mapTypeId: MY_MAPTYPE_ID,
            zoom: 4,
	          zoomControl: false,
            scaleControl: false,
	          mapTypeControl: false,
            streetViewControl: false,
	          zoomControlOptions: {
	             style: google.maps.ZoomControlStyle.SMALL
            }
		    };
        
        var featureOpts = [
            {
              stylers: [
      	       { hue: '#898989' },
               { visibility: 'simplified' },
               { gamma: 0.9 },
               { weight: 0.5 }
             ]
           },
           {
             elementType: 'labels',
             stylers: [
               { visibility: 'off' }
             ]
           },
           {
             featureType: 'water',
             stylers: [
               { color: '#FFFFFF' }
             ]
           } 
        ];
        
        
        var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
	      // var pointArray = new google.maps.MVCArray(mappoints);

        var styledMapOptions = {
           name: 'at night'
        };
        var customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);
        map.mapTypes.set(MY_MAPTYPE_ID, customMapType);
        var count = 0;
	      for (var i in locations) {
	         infowindows.push(new google.maps.InfoWindow({
	             content: "<div id='content'><h4>" + locations[i].name + "</h4><br/></div>"
           }));
           var image = '/images/dot.png';
	         marker.push(new google.maps.Marker({
	            position: new google.maps.LatLng(parseFloat(locations[i].lat), parseFloat(locations[i].lng)),
	            map: map,
              icon: image,
	            title: locations[i].name
           }));
           function openInfo(count) {
	            return function() {
  	             infowindows[count].open(map,marker[count]);
              }
           }
	         google.maps.event.addListener(marker[count], 'click', openInfo(count));
           count = count + 1;
        }
        // var markerClusterer = new MarkerClusterer(map, marker);
     }
     
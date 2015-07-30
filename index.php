<!DOCTYPE html>
<html> 
<head> 
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <title>Google Maps Multiple Markers</title> 
  <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script src="http://maps.google.com/maps/api/js?sensor=false" 
          type="text/javascript"></script>
</head> 
<body>
  <div id="map" style="width: 400px; height: 350px;"></div>

  <script type="text/javascript">
    $(document).ready(function(){

	    var map = new google.maps.Map(document.getElementById('map'), {
	      zoom: 10,
	      center: new google.maps.LatLng(-33.92, 151.25),
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	    });

	    var bounds = new google.maps.LatLngBounds();

	    var infowindow = new google.maps.InfoWindow();

	    var marker, i;

	    $.ajax({ url: "data.php",
		type: "POST",
		dataType: 'json',
		data: ({Id:'test'}),
		success: function(locations){	
			for (i = 0; i < locations.length; i++) {
			var myLatLng = new google.maps.LatLng(locations[i][1], locations[i][2]);  
		      marker = new google.maps.Marker({
		        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
		        map: map
		      });

		      google.maps.event.addListener(marker, 'click', (function(marker, i) {
		        return function() {
		          infowindow.setContent(locations[i][0]);
		          infowindow.open(map, marker);
		        }
		      })(marker, i));
		      bounds.extend(myLatLng);
		    }
		    map.fitBounds(bounds);	
		}});

	});
  </script>  
</body>
</html>
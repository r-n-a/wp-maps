<?php

?>
  <style>
  #mapCanvas {
    width: <?php echo get_option('get_w'); ?>px;
    height: <?php echo get_option('get_h'); ?>px;
   
  }
  
  #myform {
	clear: left
  }
  
  #infoPanel {
	padding-left: 10px;
  }

  </style>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
var geocoder = new google.maps.Geocoder();

function geocodePosition(pos) {
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
      updateMarkerAddress(responses[0].formatted_address);
    } else {
      updateMarkerAddress('Cannot determine address at this location.');
    }
  });
}

function updateMarkerStatus(str) {
  document.getElementById('markerStatus').innerHTML = str;
}

function updateMarkerPosition(latLng) {
  document.getElementById('info').innerHTML = [
    latLng.lat(),
    latLng.lng()
  ].join(', ');
  document.getElementById('get_v').value = latLng.lat();
  document.getElementById('get_g').value = latLng.lng();
}

function updateMarkerAddress(str) {
  document.getElementById('address').innerHTML = str;
  document.getElementById('address').value = str;
}

function updateMarkerZoom(str) {
  document.getElementById('get_zoom').innerHTML = str;
  document.getElementById('get_zoom').value = str;
}

function initialize() {
  var latLng = new google.maps.LatLng(<?php echo get_option('get_v'); ?>, <?php echo get_option('get_g'); ?>);
  var map = new google.maps.Map(document.getElementById('mapCanvas'), {
    zoom: <?php echo get_option('get_zoom'); ?>,
    center: latLng,
    mapTypeId: google.maps.MapTypeId.<?php echo get_option('get_map_type'); ?>
  });
  var marker = new google.maps.Marker({
    position: latLng,
    map: map,
	title: '<?php echo get_option('get_marker_name'); ?>',
	<?php if (is_admin()) { echo 'draggable:true,'; } ?>
	animation: google.maps.Animation.DROP
	
  });
  
  var contentString = '<?php echo get_option('get_marker_name'); ?>';

  
  var infowindow = new google.maps.InfoWindow({
      content: contentString
  });
  
  // Update current position info.
  updateMarkerPosition(latLng);
  geocodePosition(latLng);
  
  // Add dragging event listeners.
  google.maps.event.addListener(marker, 'dragstart', function() {
    updateMarkerAddress('Dragging...');
  });
  
  google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(map,marker);
	});
  
  google.maps.event.addListener(marker, 'drag', function() {
    updateMarkerStatus('Dragging...');
    updateMarkerPosition(marker.getPosition());
  });
  
  google.maps.event.addListener(marker, 'dragend', function() {
    updateMarkerStatus('Drag ended');
    geocodePosition(marker.getPosition());
  });
  
  google.maps.event.addListener(marker, 'dragend', function() {
    updateMarkerStatus('Drag ended');
    geocodePosition(marker.getPosition());
  });
  
  google.maps.event.addListener(map,'zoom_changed', function () {
		var z=map.getZoom();
		updateMarkerZoom(z);
		geocodePosition(map.getPosition());
	});
	z=map.getZoom();
	updateMarkerZoom(z);
	
	

}


// Onload handler to fire off the app.
google.maps.event.addDomListener(window, 'load', initialize);


</script>
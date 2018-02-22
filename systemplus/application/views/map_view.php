<div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="mapModalLabel">Map</h4>
      </div>
      <div class="modal-body">
        <form class="validate" name="campus_map_form" id="campus_map_form" action="" method="POST">

          <div class="form-group">
            <label for="city">City</label>
            <input type="text" id="city" name="city" class="form-control" maxlength="250" value="<?php echo $CC['city'] ?>">
          </div>

          <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" class="form-control" maxlength="250" value="<?php echo $CC['address'] ?>">
          </div>

          <div class="form-group">
            <label for="post_code">Post code</label>
            <input type="text" id="post_code" name="post_code" class="form-control" maxlength="250" value="<?php echo $CC['post_code'] ?>">
          </div>

          <div class="form-group">
            <label for="located_in">Country</label>
            <input type="text" id="located_in" name="located_in" class="form-control" maxlength="250" value="<?php echo $CC['located_in'] ?>">
          </div>

          <div class="form-group">
            <label for="map">Map</label>
            <div id="map-div" style="height: 300px;border:1px solid #aaa;"></div>
            <input type="hidden" id="mapAddress" name="mapAddress" value="<?php echo $CC['school_name'] ?>, <?php echo $CC['address'] ?>, <?php echo $CC['city'] ?> <?php echo $CC['post_code'] ?>">
          </div>

          <input type="hidden" name="latitude" id="latitude" value="">
          <input type="hidden" name="longitude" id="longitude" value="">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary disabled" id="load_map_btn" disabled="disabled">Save</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  var geocoder;
  var map;
  var timer;

  function mapLoad() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);

    var mapOptions = {
      zoom: 17,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.HYBRID
    }
    map = new google.maps.Map(document.getElementById("map-div"), mapOptions);
  }

  function changeMap() {
    var address = document.getElementById('mapAddress').value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
        });
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
  }

  $( document ).ready(function() {
    $('#mapModal').on('shown.bs.modal', function (e) {
      mapLoad();
      changeMap();
    })

    $(document).on("click", "#load_map_btn", function(event) {
      $('#mapModal').modal('toggle');

      $("#load_map_btn").addClass("disabled");
      $("#load_map_btn").prop("disabled", false);

      $("#persoprofile #city").val( $("#campus_map_form #city").val() );
      $("#persoprofile #address").val( $("#campus_map_form #address").val() );
      $("#persoprofile #post_code").val( $("#campus_map_form #post_code").val() );
      $("#persoprofile #located_in").val( $("#campus_map_form #located_in").val() );
      $('#persoprofile #located_in option[value="'+$("#campus_map_form #located_in").val()+'"]').prop("disabled", false);
      $("#map-canvas").html( $("#map-div").html() );
    });

    $( "#campus_map_form input" ).keyup(function() {
      clearTimeout(timer);
      timer = setTimeout(function(){ 
        $("#campus_map_form #latitude").val("");
        $("#campus_map_form #longitude").val("");

        $.ajax({
          url: siteUrl+'map/loadMap',
          type: 'POST',
          dataType: 'json',
          data: {'city':$("#campus_map_form #city").val(), 'address':$("#campus_map_form #address").val(), 'post_code':$("#campus_map_form #post_code").val(), 'located_in':$("#campus_map_form #located_in").val() },
          success: function(data){
            if( data.latitude != "" && data.longitude != "" )
            {
              $("#campus_map_form #latitude").val( data.latitude );
              $("#campus_map_form #longitude").val( data.longitude );

              $("#map-div").html("");
              geocoder = new google.maps.Geocoder();
              var latlng = new google.maps.LatLng(data.latitude, data.longitude);

              var mapOptions = {
                zoom: 17,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.HYBRID
              }
              map = new google.maps.Map(document.getElementById("map-div"), mapOptions);
              var marker = new google.maps.Marker({
                map: map,
                position: latlng
              });
              $("#load_map_btn").removeClass("disabled");
              $("#load_map_btn").prop("disabled", false);
            }
            else
            {
              // Display alert
              $("#load_map_btn").addClass("disabled");
              $("#load_map_btn").prop("disabled", false);
              alert("Invalid address");
            }
          }
        });
      }, 300);
      
    });
  });
</script>
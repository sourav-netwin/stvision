<?php $CC = $attraction[0]; ?>

<section class="content">
  <div class="row">
    <div class="col-md-12">

      <div>
        <span>
          <img src="<?php echo base_url(); ?>img/elements/profile/avatar_campus.png" />
        </span>
        <span class="campus_edit_title">
          <h3><?php echo $CC['pat_name'] ?></h3>
          <h5><?php echo $CC['pat_entertainment_group'] ?></h5>
        </span>
      </div>

      <form class="validate" name="persoprofile" id="persoprofile" action="<?php echo base_url(); ?>index.php/backoffice/cmsUpdateAttraction/<?php echo $CC['pat_id'] ?>" method="POST">
        <div class="box">

          <div class="box-header with-border">
            <h3 class="box-title">Attraction details</h3>
          </div>

          <div class="box-body">

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="pat_name">Attraction</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="pat_name" id="pat_name" value="<?php echo $CC['pat_name'] ?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="pat_type_id">Type</label>
              <div class="col-sm-4">
                <select class="form-control" id="pat_type_id" name="pat_type_id">
                  <?php foreach( $types as $type )
                    {
                  ?>
                      <option value="<?php echo $type['patt_id'] ?>"<?php if($type['patt_id']==$CC['pat_type_id']){ ?> selected="selected"<?php } ?>><?php echo $type['patt_name'] ?></option>
              <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="pat_entertainment_group">Entertainment group</label>
              <div class="col-sm-4">
                <input type="text" name="pat_entertainment_group" id="pat_entertainment_group" class="form-control" value="<?php echo $CC['pat_entertainment_group'] ?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="address">Students price</label>
              <div class="col-sm-4">
                <input type="text" name="pat_student_price" id="pat_student_price" class="form-control" value="<?php echo $CC['pat_student_price'] ?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="pat_adult_price">Adults price</label>
              <div class="col-sm-4">
                <input type="text" name="pat_adult_price" id="pat_adult_price" class="form-control" value="<?php echo $CC['pat_adult_price'] ?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="pat_currency_id">Currency</label>
              <div class="col-sm-4">
                <select class="form-control" id="pat_currency_id" name="pat_currency_id">
                  <?php foreach($curs as $cur){ ?>
                      <option value="<?php echo $cur['cur_id'] ?>"<?php if($cur['cur_id']==$CC['pat_currency_id']){ ?> selected="selected"<?php } ?>><?php echo $cur['cur_nome_esteso'] ?> (<?php echo $cur['cur_codice'] ?>)</option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="pat_adult_price">Address</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="pat_address" id="pat_address" value="<?php echo $CC['pat_address'] ?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="pat_regione_id">Region</label>
              <div class="col-sm-4">
                <select class="form-control" id="pat_regione_id" name="pat_regione_id">
                  <?php foreach($regs as $reg){ ?>
                      <option value="<?php echo $reg['reg_id'] ?>"<?php if($reg['reg_id']==$CC['pat_regione_id']){ ?> selected="selected"<?php } ?>><?php echo $reg['reg_descrizione'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="pat_country_id">Country</label>
              <div class="col-sm-4">
                <select class="form-control" id="pat_country_id" name="pat_country_id">
                  <?php foreach($cous as $cou){ ?>
                      <option value="<?php echo $cou['cou_id'] ?>"<?php if($cou['cou_id']==$CC['pat_country_id']){ ?> selected="selected"<?php } ?>><?php echo $cou['cou_descrizione'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="pat_city_id">City</label>
              <div class="col-sm-4">
                <select class="form-control" id="pat_city_id" name="pat_city_id">
                  <?php foreach($cits as $cit){ ?>
                      <option value="<?php echo $cit['cit_id'] ?>"<?php if($cit['cit_id']==$CC['pat_city_id']){ ?> selected="selected"<?php } ?>><?php echo $cit['cit_descrizione'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="page_1">Attraction map</label>
              <div class="col-sm-8">
                <div id="map-canvas" style="height: 300px;border:1px solid #aaa;"></div>
                <input type="hidden" id="actualAddress" name="actualAddress" value="<?php echo $CC['pat_address'] ?>">
                <input type="hidden" id="actualLat" name="actualLat" value="<?php echo $CC['pat_lat'] ?>, <?php echo $CC['pat_lat'] ?>">
                <input type="hidden" id="actualLon" name="actualLon" value="<?php echo $CC['pat_lon'] ?>, <?php echo $CC['pat_lon'] ?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="pat_desc">Description</label>
              <div class="col-sm-8">
                <textarea style="width:600px;height:400px;" name="pat_desc" id="pat_desc" class="editor"><?php echo $CC['pat_desc'] ?></textarea>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="pat_opening_time">Opening time</label>
              <div class="col-sm-8">
                <textarea style="width:600px;height:400px;" name="pat_opening_time" id="pat_opening_time" class="editor"><?php echo $CC['pat_opening_time'] ?></textarea>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="pat_notes_1">Notes</label>
              <div class="col-sm-8">
                <textarea style="width:600px;height:400px;" name="pat_notes_1" id="pat_notes_1" class="editor"><?php echo $CC['pat_notes_1'] ?></textarea>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="pat_phone">Phone number</label>
              <div class="col-sm-4">
                <input type="text" id="pat_phone" name="pat_phone"  class="form-control" value="<?php echo $CC['pat_phone'] ?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="pat_email">Email</label>
              <div class="col-sm-4">
                <input type="text" id="pat_email" name="pat_email"  class="form-control" value="<?php echo $CC['pat_email'] ?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="pat_website">Website</label>
              <div class="col-sm-4">
                <input type="text" id="pat_website" name="pat_website"  class="form-control" value="<?php echo $CC['pat_website'] ?>">
              </div>
            </div>

          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <input id="modprofile" type="submit" value="Update attraction details" name=modprofile class="btn btn-primary"/>
          </div>
          <!-- /.box-footer-->
        </div>

      </form>
    </div>
  </div>
</section>

<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSwGdc1633JshX29JtxSZzqt5sbgmUK-M&sensor=false"></script>

<script>
var geocoder;
var map;

function initialize() {
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(-34.397, 150.644);

  var mapOptions = {
    zoom: 17,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.HYBRID
  }
  map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
}

function codeAddress() {
  var address = document.getElementById('actualAddress').value;
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
      });
    $("#actualLat").val(results[0].geometry.location.lat());
    $("#actualLon").val(results[0].geometry.location.lon());
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}

function updateHidAddress(){
  $("#actualAddress").val($("#pat_address").val());
  codeAddress();
}

$(document).ready(function(){
  initialize();
  codeAddress();

  $("#pat_address").blur(function(){
    updateHidAddress();
  });

});
</script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script type="text/javascript">
  pageHighlightMenu = "backoffice/cmsManageAttractions";
  $(function(){
    $("#persoprofile").validate({
      errorElement:"div",
      ignore: "",
      rules: {
        pat_entertainment_group: "required",
        pat_student_price: "required",
        pat_adult_price: "required",
        pat_address: "required",
        pat_desc: "required",
        pat_opening_time: "required",
        pat_notes_1: "required",
        pat_phone: "required",
        pat_email: "email"
      },
      messages: {
        pat_entertainment_group: "Please enter entertainment group",
        pat_student_price: "Please enter students price",
        pat_adult_price: "Please enter adults price",
        pat_address: "Please select address",
        pat_desc: "Please enter description",
        pat_opening_time: "Please enter opening time",
        pat_notes_1: "Please enter notes",
        pat_phone: "Please enter phone number",
        pat_email: "Please enter valid email"
      },
      errorPlacement: function(error, $elem) {
        if ($elem.is('textarea')) {
          error.appendTo($elem.parent().parent('.col-sm-8'));
        }
        else
          error.appendTo($elem.parent('div'));
      },
      submitHandler: function(form) {
        form.submit();
      }
    });
  });
</script>
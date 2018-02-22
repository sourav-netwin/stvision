<?php 
  $CC = $campus[0]; 
  $CC['city'] = "";
  if (($pos = strpos($CC['address'], "#")) !== FALSE) {    
    $CC['city'] = substr($CC['address'], $pos+1); 
    $CC['address'] = substr($CC['address'], 0, $pos); 
  }
?>

<section class="content">
  <div class="row">
    <div class="col-md-12">

      <div>
        <span>
          <img src="<?php echo base_url(); ?>img/elements/profile/avatar_campus.png" />
        </span>
        <span class="campus_edit_title">
          <h3><?php echo $CC['nome_centri'] ?></h3>
          <h5><?php echo $CC['school_name'] ?></h5>
        </span>
      </div>

      <form class="validate" name="persoprofile" id="persoprofile" action="<?php echo base_url(); ?>index.php/backoffice/cmsUpdateCampus/<?php echo $CC['id'] ?>" method="POST">
        <div class="box box-primary">

          <div class="box-header with-border">
            <h3 class="box-title">Campus Details</h3>
          </div>

          <div class="box-body">

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="nome_centri">Campus</label>
              <div class="col-sm-4">
                <input type="text" id="nome_centri" name="nome_centri"  class="form-control" maxlength="250" value="<?php echo $CC['nome_centri'] ?>" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="school_name">School name</label>
              <div class="col-sm-4">
                <input type="text" id="school_name" name="school_name" class="form-control" maxlength="250" value="<?php echo $CC['school_name'] ?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="city">City</label>
              <div class="col-sm-4">
                <input type="text" id="city" name="city" class="form-control" maxlength="250" value="<?php echo $CC['city'] ?>" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="address">Address</label>
              <div class="col-sm-4">
                <input type="text" id="address" name="address" class="form-control" maxlength="250" value="<?php echo $CC['address'] ?>" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="post_code">Post code</label>
              <div class="col-sm-4">
                <input type="text" id="post_code" name="post_code" class="form-control" maxlength="250" value="<?php echo $CC['post_code'] ?>" readonly>
              </div>
              <div class="col-sm-2">
                <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#mapModal">
                  Insert/Edit address
                </a>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="post_code">Campus map</label>
              <div class="col-sm-8">
                <div id="map-canvas" style="height: 300px;border:1px solid #aaa;"></div>
                <input type="hidden" id="actualAddress" name="actualAddress" value="<?php echo $CC['school_name'] ?>, <?php echo $CC['address'] ?>, <?php echo $CC['city'] ?> <?php echo $CC['post_code'] ?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="located_in">Located in</label>
              <div class="col-sm-4">
                <select class="form-control" id="located_in" name="located_in">
                  <option value="" >Select</option>
                  <option value="Ireland" <?php if($CC["located_in"]=="Ireland"){?> selected <?php } ?>>Ireland</option>
                  <option value="Malta" <?php if($CC["located_in"]=="Malta"){?> selected <?php } ?>>Malta</option>
                  <option value="United Kingdom" <?php if($CC["located_in"]=="United Kingdom"){?> selected <?php } ?>>United Kingdom</option>
                  <option value="USA" <?php if($CC["located_in"]=="USA"){?> selected <?php } ?>>USA</option>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" style="margin-top: -7px;" for="radCourseType">Accomodations</label>
              <div class="col-sm-6">
                <div class="row">
                  <?php
                    foreach( $allSis as $sis )
                    {
                      $sisExists=0;
                      foreach( $campusSis as $cSis )
                      {
                        if($cSis["sistemazione"]== $sis["tba_type_join"])
                        {
                          $sisExists = 1;
                        }
                      }
                    ?>
                    <div class="col-sm-3 col-xs-6">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="sisacco[]" id="sisacco_<?php echo $sis["tba_type_join"] ?>" value="<?php echo $sis["tba_type_join"] ?>" <?php if($sisExists==1){ ?>checked="checked"<?php } ?>>
                          <?php echo $sis["tba_type_join"] ?>
                        </label>
                      </div>
                    </div>
              <?php } ?>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="page_1">Destination</label>
              <div class="col-sm-8">
                <textarea style="width:600px;height:400px;" name="page_1" id="page_1" class="editor"><?php echo $CC['page_1'] ?></textarea>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="page_3">Courses</label>
              <div class="col-sm-8">
                <textarea style="width:600px;height:400px;" name="page_3" id="page_3" class="editor"><?php echo $CC['page_3'] ?></textarea>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="plus_contact">Plus contact full name</label>
              <div class="col-sm-4">
                <input type="text" id="plus_contact" name="plus_contact"  class="form-control" maxlength="250" value="<?php echo $CC['plus_contact'] ?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="plus_contact_number">Plus contact number</label>
              <div class="col-sm-4">
                <input type="text" id="plus_contact_number" name="plus_contact_number"  class="form-control" maxlength="250" value="<?php echo $CC['plus_contact_number'] ?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="cm_mail">Campus manager email</label>
              <div class="col-sm-4">
                <input type="text" id="cm_mail" name="cm_mail"  class="form-control" maxlength="250" value="<?php echo $CC['cm_mail'] ?>">
              </div>
            </div>

          </div>
        </div>

        <div class="box box-primary">

          <div class="box-header with-border">
            <h3 class="box-title">Included services</h3>
          </div>

          <div class="box-body">

            <?php
              foreach( $psg as $sg )
              {
            ?>
                <div class="form-group row">
                  <label class="col-sm-2 control-label" for="cm_mail"><?php echo $sg["psg_servizio"] ?></label>
                  <div class="col-sm-8">
                    <textarea class="editor" name="cpsg_<?php echo $sg["psg_id"] ?>" id="cpsg_<?php echo $sg["psg_id"] ?>"><?php foreach($campus_psg as $cpsg){if($cpsg["jn_cpsg_ids"]==$sg["psg_id"]){ ?><?php echo $cpsg["jn_cpsg_text"]; ?><?php }}?></textarea>
                  </div>
                </div>
            <?php
              }
            ?>

          </div>
        </div>

        <div class="box box-primary">

          <div class="box-header with-border">
            <h3 class="box-title">Optional services</h3>
          </div>

          <div class="box-body">

            <?php
              foreach( $pso as $so )
              {
            ?>
                <div class="form-group row">
                  <label class="col-sm-2 control-label" for="cm_mail"><?php echo $so["pso_servizio"] ?></label>
                  <div class="col-sm-8">
                    <textarea class="editor" name="cpso_<?php echo $so["pso_id"] ?>" id="cpso_<?php echo $so["pso_id"] ?>"><?php foreach($campus_pso as $cpso){if($cpso["jn_cpso_ids"]==$so["pso_id"]){ ?><?php echo $cpso["jn_cpso_text"]; ?><?php }}?></textarea>
                  </div>
                </div>
            <?php
              }
            ?>

          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <input id="modprofile" type="submit" value="Update campus details" name=modprofile class="btn btn-primary"/>
            <input class="btn btn-danger" type="reset" id="btnCancel" name="btnCancel" value="Cancel" onclick="window.location.href='<?php echo base_url();?>index.php/backoffice/cmsManageCampus'" />
          </div>
          <!-- /.box-footer-->
        </div>
      </form>
    </div>
  </div>
</section>

<?php 
  $data['CC'] = $CC;
  echo $this->load->view("map_view", $data); 
?>

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
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}

$(document).ready(function(){
  initialize();
  codeAddress();

  $("school_name").blur(function(){
    updateHidAddress()
  });
  $("address").blur(function(){
    updateHidAddress()
  });
  $("post_code").blur(function(){
    updateHidAddress()
  });
});
</script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script type="text/javascript">
  pageHighlightMenu = "backoffice/cmsManageCampus";
  $(function(){
    $("#persoprofile").validate({
      errorElement:"div",
      ignore: "",
      rules: {
        school_name: "required",
        city: "required",
        address: "required",
        post_code: "required",
        page_1: "required",
        page_3: "required",
        plus_contact: "required",
        plus_contact_number: "required",
        cm_mail: {
          required: true,
          email: true
        }
      },
      messages: {
        school_name: "Please enter school name",
        city: "Please enter city",
        address: "Please enter address",
        post_code: "Please enter post code",
        page_1: "Please enter destination",
        page_3: "Please enter course",
        plus_contact: "Please enter contact full name",
        plus_contact_number: "Please enter plus contact number",
        cm_mail: {
          required: "Please enter campus manager email",
          email: "Please enter valid email"
        }
      },
      submitHandler: function(form) {
        form.submit();
      }
    });
  });
</script>
<section class="content">
  <div class="row">
    <div class="col-md-12">

      <div>
        <span>
          <img src="<?php echo base_url(); ?>img/elements/profile/avatar_campus.png" />
        </span>
        <span class="campus_edit_title">
          <h3>New campus</h3>
          <h5>Fill the input fields and click on "Add campus details"</h5>
        </span>
      </div>

      <form class="validate" name="persoprofile" id="persoprofile" action="<?php echo base_url(); ?>index.php/backoffice/cmsAddCampus" method="POST">
        <div class="box box-primary">

          <div class="box-header with-border">
            <h3 class="box-title">Campus Details</h3>
          </div>

          <div class="box-body">

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="nome_centri">Campus</label>
              <div class="col-sm-4">
                <input type="text" id="nome_centri" name="nome_centri"  class="form-control" maxlength="250" value="<?php echo set_value('nome_centri',  $formData['nome_centri']);?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="school_name">School name</label>
              <div class="col-sm-4">
                <input type="text" id="school_name" name="school_name" class="form-control getAddressMap" maxlength="250" value="<?php echo set_value('school_name',  $formData['school_name']);?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="city">City</label>
              <div class="col-sm-4">
                <input type="text" id="city" name="city" class="form-control getAddressMap" maxlength="250" value="<?php echo set_value('city',  $formData['city']);?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="address">Address</label>
              <div class="col-sm-4">
                <input type="text" id="address" name="address" class="form-control getAddressMap" maxlength="250" value="<?php echo set_value('address',  $formData['address']);?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="post_code">Post code</label>
              <div class="col-sm-4">
                <input type="text" id="post_code" name="post_code" class="form-control getAddressMap" maxlength="250" value="<?php echo set_value('post_code',  $formData['post_code']);?>">
              </div>
              <div class="col-sm-2">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="post_code">Campus map</label>
              <div class="col-sm-8">
                <div id="map-canvas" style="height: 300px;border:1px solid #aaa;"></div>
                <input type="hidden" id="actualAddress" name="actualAddress" value="<?php echo set_value('actualAddress',  $formData['school_name'] . $formData['address'] . $formData['city'] . $formData['post_code']); ?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="located_in">Located in</label>
              <div class="col-sm-4">
                <select class="form-control" id="located_in" name="located_in">
                  <option value="" >Select</option>
                  <option value="Ireland" <?php if($formData["located_in"]=="Ireland"){?> selected <?php } ?>>Ireland</option>
                  <option value="Malta" <?php if($formData["located_in"]=="Malta"){?> selected <?php } ?>>Malta</option>
                  <option value="United Kingdom" <?php if($formData["located_in"]=="United Kingdom"){?> selected <?php } ?>>United Kingdom</option>
                  <option value="USA" <?php if($formData["located_in"]=="USA"){?> selected <?php } ?>>USA</option>
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
                    ?>
                    <div class="col-sm-3 col-xs-6">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="sisacco[]" id="sisacco_<?php echo $sis["tba_type_join"] ?>" value="<?php echo $sis["tba_type_join"] ?>" >
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
                <textarea style="width:600px;height:400px;" name="page_1" id="page_1" class="editor"><?php echo set_value('page_1',$formData['page_1']); ?></textarea>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="page_3">Courses</label>
              <div class="col-sm-8">
                <textarea style="width:600px;height:400px;" name="page_3" id="page_3" class="editor"><?php echo set_value('page_3',$formData['page_3']); ?></textarea>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="plus_contact">Plus contact full name</label>
              <div class="col-sm-4">
                <input type="text" id="plus_contact" name="plus_contact"  class="form-control" maxlength="250" value="<?php echo set_value('plus_contact',$formData['plus_contact']); ?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="plus_contact_number">Plus contact number</label>
              <div class="col-sm-4">
                <input type="text" id="plus_contact_number" name="plus_contact_number"  class="form-control" maxlength="250" value="<?php echo set_value('plus_contact_number',$formData['plus_contact_number']); ?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 control-label" for="cm_mail">Campus manager email</label>
              <div class="col-sm-4">
                <input type="text" id="cm_mail" name="cm_mail"  class="form-control" maxlength="250" value="<?php echo set_value('cm_mail',$formData['cm_mail']); ?>">
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
                    <textarea class="editor" name="cpsg_<?php echo $sg["psg_id"] ?>" id="cpsg_<?php echo $sg["psg_id"] ?>"></textarea>
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
                    <textarea class="editor" name="cpso_<?php echo $so["pso_id"] ?>" id="cpso_<?php echo $so["pso_id"] ?>"></textarea>
                  </div>
                </div>
            <?php
              }
            ?>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <input id="modprofile" type="submit" value="Add campus details" name=modprofile class="btn btn-primary"/>
            <input class="btn btn-danger" type="reset" id="btnCancel" name="btnCancel" value="Cancel" onclick="window.location.href='<?php echo base_url();?>index.php/backoffice/cmsManageCampus'" />
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
  var school_name = document.getElementById('school_name').value;
  var address = document.getElementById('address').value;
  var city = document.getElementById('city').value;
  var post_code = document.getElementById('post_code').value;
  $("#actualAddress").val(school_name + " " + address + " " + " " + city + " " + post_code);
  var address = $.trim(document.getElementById('actualAddress').value);
  if(address != "")
  {
    geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
        } else {
            console.log('Geocode was not successful for the following reason: ' + status);
        }
    });
  }
}

$(document).ready(function(){
  initialize();
  codeAddress();
  $(".getAddressMap").blur(function(){
       codeAddress();
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
<style>
  .ui-datepicker {
    font-size: smaller;
  }

  span.datearrivo {
    border-right: 1px solid #f00;
    color: #000;
    font-weight: bold;
    padding: 0 5px;
  }

  span.datearrivo:last-child {
    border-right: none;
  }
</style>

<div class="row">
  <div class="col-xs-12">
    <div class="row">
      <?php showSessionMessageIfAny($this); ?>
    </div>
    <div class="box">
      <div class="box-body">
        <form action="<?php echo base_url(); ?>index.php/agentbooking/insertGroup<?php echo ( $enroll_id != '' ) ? "/$enroll_id" : ''; ?>" name="enrolform" id="enrolform" class="grid12" method="POST">
          <div class="box-header with-border mr-bot-10">
            <h3 class="box-title">Product and destination</h3>
          </div>

          <div class="form-group row">
            <div class="col-sm-3 col-md-3">
              <label class="mr-left-10" for="prod_select">
                <strong>Product</strong>
              </label>
            </div>
            <div class="col-sm-9 col-md-9 col-lg-6">
              <select  autocomplete="off" name="prod_select" id="prod_select" class="form-control" data-placeholder="Choose a product">
                <option value="">Select product</option>
                <option value="1" <?php echo ( !empty( $enroll_details ) && $enroll_details['enrol_product_id'] == 1 ) ? 'selected' : ''; ?>>Plus Junior Summer</option>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-3 col-md-3">
              <label class="mr-left-10" for="center_select">
                <strong>Center</strong>
              </label>
            </div>
            <div class="col-sm-9 col-md-9 col-lg-6">
              <select  autocomplete="off" name="center_select" id="center_select" class="form-control" data-placeholder="Select center">
                <option value="">Select center</option>
                <?php
                  if ( count( $centri ) )
                  {
                    foreach ( $centri as $key => $item )
                    {
                ?>
                      <option value="<?php echo $item['id']; ?>" <?php echo ( !empty( $enroll_details ) && $enroll_details['centri_id'] == $item['id'] ) ? 'selected' : ''; ?>><?php echo $item['nome_centri']; ?></option>
                <?php
                    }
                  }
                ?>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-3 col-md-3">
              <label class="mr-left-10" for="package_select">
                <strong>Package</strong>
              </label>
            </div>
            <div class="col-sm-9 col-md-9 col-lg-6">
              <select  autocomplete="off" name="package_select" id="package_select" class="form-control" data-placeholder="Select package">
                <option value="">Select package</option>
                <?php
                  if ( count( $packages ) )
                  {
                    foreach ( $packages as $package )
                    {
                ?>
                      <option value="<?php echo $package['pack_package_id']; ?>" <?php echo ( !empty( $enroll_details ) && $enroll_details['enrol_package_id'] == $package['pack_package_id'] ) ? 'selected' : ''; ?>><?php echo $package['pack_package']; ?></option>
                <?php
                    }
                  }
                ?>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-3 col-md-3">
              <label class="mr-left-10" for="n_weeks">
                <strong>Week(s)</strong>
              </label>
            </div>
            <div class="form-data col-sm-9 col-md-9 col-lg-6">
              <input autocomplete="off" data-type="spinner" type="number" min="1" max="3" value="<?php echo ( !empty( $enroll_details ) && $enroll_details['enrol_number_of_week'] ) ? $enroll_details['enrol_number_of_week'] : '1'; ?>" id="n_weeks" name="n_weeks" class="form-control only_number" />
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-9 col-md-9 col-lg-9 col-lg-offset-3">
              <div id="allprices" class="mr-top-10"></div>
            </div>
          </div>

          <?php
            if( $accomodations )
            {
          ?>
            <div class="box-header with-border mr-bot-10">
              <h3 class="box-title">Students package compositions</h3>
            </div>
            <div id="stud_pack_comp">

              <div class="form-group row">
                <div class="col-sm-3 col-md-3">
                  <label class="mr-left-10" for="sum_stud">
                    <strong>Students total</strong>
                  </label>
                </div>
                <div class="form-data col-sm-9 col-md-9 col-lg-6">
                  <input autocomplete="off" type="number" value="0" id="sum_stud" name="sum_stud" max="500" class="form-control only_number" />
                </div>
              </div>

            </div>
            <div id="st_error" class="error"></div>

            <div class="box-header with-border mr-bot-10">
              <h3 class="box-title">Group leaders package compositions</h3>
            </div>
            <div id="gl_pack_comp">
              <div class="form-group row">
                <div class="col-sm-3 col-md-3">
                  <label class="mr-left-10" for="sum_gl">
                    <strong>Group leader total</strong>
                  </label>
                </div>
                <div class="form-data col-sm-9 col-md-9 col-lg-6">
                  <input autocomplete="off" type="number" value="0" id="sum_gl" name="sum_gl" max="500" class="form-control only_number" />
                </div>
              </div>
            </div>
            <div id="gl_error" class="error"></div>
      <?php } ?>

          <div class="box-header with-border mr-bot-10">
            <h3 class="box-title">Arrival/departure dates on campus</h3>
          </div>

          <div class="form-group row">
            <div class="col-sm-3 col-md-3">
              <label class="mr-left-10" for="arrival_date">
                <strong>Arrival date</strong>
              </label>
            </div>
            <div class="form-data col-sm-9 col-md-9 col-lg-9" >
              <div id="alldates" style="border:0;color:#f00;"></div>
              <div style="overflow: auto;" id="arrival_date" data-type="date" data-id=arrival_date data-name=arrival_date data-show-button-panel=false data-number-of-months=3 data-min-date="06/01/2016"  data-max-date="09/30/2016" data-alt-field="#adate" data-alt-format="dd/mm/yy" data-alt-default-date=""></div>
              <input type="hidden" id="hidd_arrival_date" name="arrival_date" value="" />
            </div>
          </div>


          <div class="form-group row">
            <div class="col-sm-3 col-md-3">
              <label class="mr-left-10" for="departure_date">
                <strong>Departure date</strong>
              </label>
            </div>
            <div class="form-data col-sm-9 col-md-9 col-lg-9" >
              <div style="overflow: auto;" id="departure_date" data-type="date" data-id=departure_date data-name=departure_date data-show-button-panel=false data-number-of-months=3 data-min-date="06/01/2016"  data-max-date="10/31/2016" data-alt-field="#ddate" data-alt-format="dd/mm/yy" data-alt-default-date=""></div>
              <input type="hidden" id="hidd_departure_date" name="departure_date" value="" />
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-3 col-md-3">
              <label class="mr-left-10">
                <strong>Enrol summary</strong>
              </label>
            </div>
            <div class="form-data col-sm-9 col-md-9 col-lg-6">
              <div class="form-group row">
                <div class="col-sm-3 col-lg-3 col-md-4">
                  Arrival date:
                </div>
                <div class="col-sm-9 col-lg-4 col-md-6">
                  <input class="form-control" type="text" autocomplete="off" id="adate" value="" readonly />
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3 col-lg-3 col-md-4">
                  Departure date:
                </div>
                <div class="col-sm-9 col-lg-4 col-md-6">
                  <input class="form-control" type="text" autocomplete="off" id="ddate" value="" readonly>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3 col-lg-3 col-md-4">
                  Total price:
                </div>
                <div class="col-sm-9 col-lg-4 col-md-6">
                  <input class="form-control" type="text" autocomplete="off" id="total_price" name="total_price" value="0" readonly data-value="0">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3 col-lg-3 col-md-4">
                  Free GL:
                </div>
                <div class="col-sm-9 col-lg-4 col-md-6">
                  <input class="form-control" type="text" autocomplete="off" id="free_gl_count" name="free_gl_count" value="0" readonly data-value="0">
                </div>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-3 col-lg-3 col-md-4">
            </div>
            <div class="form-data col-sm-9 col-md-9 col-lg-6">
              <div class="checkbox">
                <label><input type="checkbox" value="" id="declaration_check" name="declaration_check">I declare that I have read, understood and agree to adhere to "PLUS Safeguarding and Child Protection Policy" and confirm that I have obtained a certificate of good conduct for any group leaders escorting groups that include under-18s</label>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-3 col-lg-3 col-md-4">
            </div>
            <div class="form-data col-sm-9 col-md-9 col-lg-6 actions">
              <div id="accomodations" style="display:none;"></div>
              <input id="writebook" name="writebook" class="btn btn-primary" type="button" value="Submit"/>
              <input type="reset" class="btn btn-danger" value="Cancel" />
            </div>
            <!-- End of .actions -->
          </div>
        </form>
      </div>
      <!-- End of .col-sm-12 -->
      <div class="box-footer">
      </div>
      <!-- /.box-footer-->
    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.ui.datetimepicker.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script>
  var myVar;
  var url_value = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);

  if( url_value != 'enrol' )
    pageHighlightMenu = "agentbooking/enrol";

  $(document).ready(function() {

    $(document).on("keypress",".only_number", function (e) {
      //if the letter is not digit then don't type anything
      if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        return false;
    });

    jQuery.validator.addMethod("greaterThanZero", function(value, element) {
      return this.optional(element) || (parseFloat(value) > 0);
    },'Please enter value greater than 0');

    $("#enrolform").validate({
      errorElement:"div",
      ignore: "",
      focusInvalid: false,
      invalidHandler: function(form, validator) {
        if (!validator.numberOfInvalids())
          return;

        $('html, body').animate({
          scrollTop: $(validator.errorList[0].element).offset().top
        }, 500);
      },
      rules: {
        prod_select: {
          required: true
        },
        center_select: {
          required: true
        },
        package_select: {
          required: true
        },
        arrival_date: {
          required: true
        },
        departure_date: {
          required: true
        },
        sum_stud: {
          greaterThanZero: true
        },
        sum_gl: {
          greaterThanZero: true
        },
        declaration_check: {
          required: true
        },
        n_weeks: {
          required: true
        }
      },
      messages: {
        prod_select: {
          required: "Please select a product"
        },
        center_select: {
          required: "Please select a center"
        },
        package_select: {
          required: "Please select a package"
        },
        arrival_date: {
          required: "Please select an arrival date"
        },
        departure_date: {
          required: "Please select a departure date"
        },
        sum_stud: {
          greaterThanZero: "No students enrolled"
        },
        sum_gl: {
          greaterThanZero: "No group leaders enrolled"
        },
        declaration_check: {
          required: "Please accept the declaration"
        },
        n_weeks: {
          required: "Please enter number of weeks"
        }
      },
      errorPlacement: function (error, element) {
        if (element.attr("type") == "checkbox") {
          error.appendTo($(".checkbox"));
        } else {
          error.insertAfter(element);
        }
      },
      submitHandler: function(form) {
        var st_valid = gl_valid = 0;
        var sum_st = sum_gl = 0;
        $(".st_pack_comp").each(function( index ) {
          if( parseInt($( this ).val()) > 0 )
          {
            sum_st = sum_st + parseInt($( this ).val());
            st_valid = 1;
          }
        });

        $(".grp_l_pack_comp").each(function( index ) {
          if( parseInt($( this ).val()) > 0 )
          {
            sum_gl = sum_gl + parseInt($( this ).val());
            gl_valid = 1;
          }
        });

        if( st_valid == 0 )
        {
          $("#st_error").html("Please enter students");
          $("#st_error").show();

          $('html, body').animate({
            scrollTop: $("#st_error").offset().top
          }, 500);
        }
        if( gl_valid == 0 )
        {
          $("#gl_error").html("Please enter group leaders");
          $("#gl_error").show();
          if( st_valid == 1 )
          {
            $('html, body').animate({
              scrollTop: $("#gl_error").offset().top
            }, 500);
          }
        }
        if( st_valid == 1 && gl_valid == 1 )
        {
          if( sum_st != $("#sum_stud").val() )
          {
            $("#st_error").html("Total students and count in package compositions must match");
            $("#st_error").show();

            $('html, body').animate({
              scrollTop: $("#st_error").offset().top
            }, 500);
          }
          if( sum_gl != $("#sum_gl").val() )
          {
            $("#gl_error").html("Total group leaders and count in package accommodations must match");
            $("#gl_error").show();
            if( sum_st == $("#sum_stud").val() )
            {
              $('html, body').animate({
                scrollTop: $("#gl_error").offset().top
              }, 500);
            }
          }
          if( sum_st == $("#sum_stud").val() && sum_gl == $("#sum_gl").val() )
            form.submit();
        }
      }
    });

    $('#arrival_date').datepicker({
      dateFormat: 'dd/mm/yy',
      numberOfMonths: 3,
      onSelect: function(sDate, s) {
        $("#adate").val(sDate);
        $("#hidd_arrival_date").val(sDate);
        $("#departure_date").datepicker("option", "minDate", sDate);
      }
    });

    $('#departure_date').datepicker({
      dateFormat: 'dd/mm/yy',
      numberOfMonths: 3,
      onSelect: function(sDate, s) {
        $("#ddate").val(sDate);
        $("#hidd_departure_date").val(sDate);
        $("#arrival_date").datepicker("option", "maxDate", sDate);
      }
    });

    $("#center_select").change(function( event, data ) {
      var center = $(this).val();
      $("#allprices").html("");
      $(".st_pack").remove();
      $(".gl_pack").remove();

      var accomodations = <?php echo json_encode($accomodation_name_arr); ?>;
      for (i = 0; i < accomodations.length; i++)
      {
        $("#row_"+accomodations[i]).hide();
        $("#"+accomodations[i]).val(0);
        $("#sum_stud").val(0);
        $("#sum_gl").val(0);
      }

      if ( center != "" )
      {
        if( data == undefined )
        {
          $.ajax({
            type: "POST",
            data: "idcentro=" + center,
            url: "<?php echo base_url(); ?>index.php/agentbooking/getPackages",
            success: function( data ) {
              if ( data != '') {
                $("#package_select").html( data );
              }
            }
          });
        }

        $("#alldates").html('Searching dates ...');
        $.ajax({
          type: "POST",
          data: "idcentro=" + center,
          url: "<?php echo base_url(); ?>index.php/agentbooking/findDatesByCenter",
          success: function( data ){
            if (data != '') {
              $("#alldates").html("ARRIVAL DATES @ "+$("#center_select option:selected").text()+" : "+data).show();
            }
            else {
              $("#alldates").html('<em>No item result</em>');
            }
          }
        });
      }
      else
        $("#package_select").html("<option value=''>Select package</option>");
    });

    $("#package_select").change(function() {
      package_price_table();
      $(".st_pack").remove();
      $(".gl_pack").remove();
    });

    $(document).on("input","#n_weeks", function(){
      package_price_table();
      $(".st_pack").remove();
      $(".gl_pack").remove();
    });

    $(document).on("input","#sum_stud", function( event, details ){
      var sum_stud = $(this).val();

      if( sum_stud > 0 && $("#package_comp_table").length && $("#stud_pack_comp .form-group.row").length == 1 )
      {
        $("#package_comp_table tbody tr").each(function( index ) {
          var pack_comp_id = $(this).attr("id").split("pack_comp_").pop();
          var pack_comp_text = $(this).find('td:first').html().trim()

          var stud_html = '<div class="form-group row st_pack" id="st_pack_'+pack_comp_id+'">';
              stud_html +='<div class="col-sm-3">';
              stud_html +='<label class="mr-left-10"><strong>'+pack_comp_text+'</strong></label>';
              stud_html +='</div>';
              stud_html += '<div class="col-sm-7">';
              stud_html += '<div class="row">';
              stud_html +='<div class="col-sm-2">';
              stud_html +='<input id="st_'+pack_comp_id+'" name="st_'+pack_comp_id+'" class="st_pack_comp form-control only_number" data-type="spinner" type="number" value="0" min="0" max="500" data-id="'+pack_comp_id+'"/>';
              stud_html +='</div>';
              stud_html +='<div class="col-sm-2">';
              stud_html +='<label class="mr-left-10"><strong>Total price</strong></label>';
              stud_html +='</div>';
              stud_html +='<div class="col-sm-3">';
              stud_html +='<input id="st_price_'+pack_comp_id+'" class="tot_price form-control" readonly/>';
              stud_html +='</div>';
              stud_html += '</div>';
              stud_html += '</div>';
              stud_html +='</div>';

          $("#stud_pack_comp").append( stud_html );
        });
      }

      if( details == undefined )
        calculateFreeGl();

      if( details != undefined && url_value != 'enrol' )
      {
        $.each(details, function(key,valueObj){
          $("#st_"+key).val( valueObj );
        });
        $(".st_pack_comp").trigger("input");
      }
    });

    $(document).on("input","#sum_gl", function( event, details ){
      var sum_gl = $(this).val();

      if( sum_gl > 0 && $("#package_comp_table").length && $("#gl_pack_comp .form-group.row").length == 1 )
      {
        $.ajax({
          type: "POST",
          data: "package_id=" + $("#package_select").val(),
          url: "<?php echo base_url(); ?>index.php/agentbooking/findAccomodation",
          success: function( data ){
            var result = JSON.parse(data);
            var accomodations = result.accomodation;

            for (i = 0; i < accomodations.length; i++)
            {
              var gl_html = '<div class="form-group row gl_pack" id="row_gl_'+accomodations[i]["accom_id"]+'">';
              gl_html +='<div class="col-sm-3">';
              gl_html +='<label class="mr-left-10"><strong>'+accomodations[i]["accom_name"]+'</strong></label>';
              gl_html +='</div>';
              gl_html += '<div class="col-sm-7">';
              gl_html += '<div class="row">';
              gl_html +='<div class="col-sm-2">';
              gl_html +='<input id="gl_'+accomodations[i]["accom_id"]+'" name="gl_'+accomodations[i]["accom_id"]+'" class="grp_l_pack_comp form-control only_number" data-type="spinner" type="number" value="0" min="0" max="500" data-id="'+accomodations[i]["accom_id"]+'"/>';
              gl_html +='</div>';
              gl_html +='<div class="col-sm-2">';
              gl_html +='<label class="mr-left-10"><strong>Total price</strong></label>';
              gl_html +='</div>';
              gl_html +='<div class="col-sm-3">';
              gl_html +='<input id="gl_price_'+accomodations[i]["accom_id"]+'" class="tot_price form-control" readonly/>';
              gl_html +='</div>';
              gl_html +='<div class="col-sm-2">';
              gl_html +='<label class="mr-left-10"><strong>Free GL</strong></label>';
              gl_html +='</div>';
              gl_html +='<div class="col-sm-3">';
              gl_html +='<input id="free_gl_'+accomodations[i]["accom_id"]+'" name="free_gl_'+accomodations[i]["accom_id"]+'" class="free_gl form-control" readonly/>';
              gl_html +='</div>';
              gl_html += '</div>';
              gl_html += '</div>';
              gl_html +='</div>';
              $("#gl_pack_comp").append( gl_html );
            }

            if( details != undefined && url_value != 'enrol')
            {
              $.each(details, function(key,valueObj){
                $("#gl_"+key).val( valueObj );
              });
              $(".grp_l_pack_comp").trigger("input");
            }
          }
        });
      }
    });

    $("#writebook").click(function() {

      // validate form
      if( $("#enrolform").valid() )
      {
        var giornitotali = daydiff( parseDate($('#adate').val()), parseDate($('#ddate').val()) ) * 1 + 1;
        var giornidaweek = $("#n_weeks").val() * 7 + 1;

        var nogiorniok = ( giornitotali != giornidaweek ) ? 1 : 0;
        var arrivo_ok = 0;
        var partenza_ok = 0;

        $(".datearrivo").each(function(index) {
          var miadataarrivook = $('#adate').val();
          if( miadataarrivook == $(this).text() )
          {
            arrivo_ok = 1;
          }
        });

        if( giornitotali <= 0 )
        {
          swal("Error","Please verify selected dates: "+giornitotali+"day(s) on campus!");
          return false;
        }
        if( arrivo_ok == 0 )
        {
          if( nogiorniok == 0 )
          {
            if(confirm("Arrival date doesn't match with campus arrival dates! You want to continue anyway?"))
            {
              $("#enrolform").submit();
            }
            else
            {
              return false;
            }
          }
          else
          {
            if(confirm("Arrival date doesn't match with campus arrival dates and days on campus doesn't match with selected weeks! You want to continue anyway?"))
            {
              $("#enrolform").submit();
            }
            else
            {
              return false;
            }
          }
        }
        else
        {
          if(nogiorniok==1)
          {
            if(confirm("Days on campus doesn't match with selected weeks! You want to continue anyway?"))
            {
              $("#enrolform").submit();
            }
            else
            {
              return false;
            }
          }
          else
          {
            $("#enrolform").submit();
          }
        }
      }

    });
  });

  function daydiff(first, second) {
    return (second-first)/(1000*60*60*24)
  }

  function parseDate(str) {
    var mdy = str.split('/')
    return new Date(mdy[2], mdy[1], mdy[0]-1);
  }

  function package_price_table()
  {
    var package_id = $("#package_select").val();
    $("#allprices").css('color','');
    $("#allprices").html('Searching prices ...');
    $("#sum_gl").val(0);
    $("#sum_stud").val(0);

    if( package_id != "" )
    {
      $.ajax({
        type: "POST",
        data: { "package_id":package_id, "weeks" : $("#n_weeks").val() },
        url: "<?php echo base_url(); ?>index.php/agentbooking/findAccomodationPrice",
        success: function( data ) {
          var result = JSON.parse(data);
          var obj_price = result.price;
          if( obj_price )
          {
            $("#allprices").html(obj_price);
          }
          else
          {
            if( $("#n_weeks").val() > 0 && $("#n_weeks").val() <= 3 && $("#n_weeks").val() != '' )
            {
              $("#allprices").html('This package is not available for entered week number.');
              $("#allprices").css('color','red');
            }
            else
            {
              $("#allprices").html('');
            }
          }
        }
      });

      $.ajax({
        type: "POST",
        data: "package_id=" + package_id,
        url: "<?php echo base_url(); ?>index.php/agentbooking/packageDate",
        success: function( data ) {
          var dateobj = JSON.parse(data);

          $("#arrival_date" ).datepicker( "option", "minDate", dateobj.st_date );
          $("#arrival_date" ).datepicker( "option", "maxDate", dateobj.end_date );
          $("#departure_date" ).datepicker( "option", "minDate", dateobj.st_date );
          $("#departure_date" ).datepicker( "option", "maxDate", dateobj.end_date );
        }
      });
    }
    else
      $("#allprices").html("");
  }

  function calculateFreeGl()
  {
    clearTimeout(myVar);
    myVar =setTimeout(function(){
      var package_select = $("#package_select").val();
      var weeks = $("#n_weeks").val();
      var stud_tot = $("#sum_stud").val();
      var gl_tot = $("#sum_gl").val();

      if( gl_tot > 0 )
      {
        var gl_pax_data = [];
        $(".grp_l_pack_comp").each(function( index ) {
          var pack_accom_id = $(this).attr('data-id');
          var pax_count = $(this).val();
          gl_pax_data.push([pack_accom_id, pax_count]);
        });

        $.ajax({
          type: "POST",
          data: { 'package' : package_select, 'weeks' : weeks, "stud_tot": stud_tot, "gl_tot" : gl_tot, 'gl_pax_data' : gl_pax_data, },
          url: "<?php echo base_url(); ?>index.php/agentbooking/packageAccomodationPrice",
          success: function( data ) {
            var result = JSON.parse(data);
            var currency = '';
            $.each(result, function( key, value ) {
              currency = value.currency;
              $("#gl_price_"+value.accommodation).val( value.display_price );
              $("#gl_price_"+value.accommodation).attr( 'data-price', value.price );
              $("#gl_price_"+value.accommodation).attr( 'data-currency', value.currency );
              $("#free_gl_"+value.accommodation).val( value.free_pax );
            });

            var sum_tot = 0;
            $(".tot_price").each(function( index ) {
              if( $( this ).val() != "" )
                sum_tot = parseFloat(sum_tot) + parseFloat($( this ).attr('data-price'));
              $("#total_price").val(currency+formatNumber(sum_tot));
              $("#total_price").attr('data-value', sum_tot);
            });

            var sum_free_gl = 0;
            $(".free_gl").each(function( index ) {
              if( $( this ).val() != "" )
                sum_free_gl = parseInt(sum_free_gl) + parseInt($( this ).val());
              $("#free_gl_count").val(sum_free_gl);
            });
          }
        });
      }

    }, 1000);
  }

  $( window ).load(function() {
    if( url_value != 'enrol' )
    {
      $("#center_select").trigger("change", ['edit']);
      $.ajax({
        type: "POST",
        data: "enrol_id=" + url_value,
        url: "<?php echo base_url(); ?>index.php/agentbooking/getBookingDetails",
        success: function( data ) {
          var result = JSON.parse(data);

          $("#package_select").trigger("change");
          $("#sum_stud").val(result.enroll_details.enrol_booked_students);
          $("#sum_gl").val(result.enroll_details.enrol_booked_gl);
          $("#arrival_date").datepicker('setDate', new Date(result.enroll_details.enrol_arrival_date));
          $("#hidd_arrival_date").val($("#arrival_date").val());
          $("#departure_date").datepicker('setDate', new Date(result.enroll_details.enrol_departure_date));
          $("#hidd_departure_date").val($("#departure_date").val());
          $("#adate").val($("#arrival_date").val());
          $("#ddate").val($("#departure_date").val());
          $("#declaration_check").attr("checked", "checked");

          setTimeout(function(){
            $("#sum_stud").trigger("input", [result.enroll_student_details]);
            $("#sum_gl").trigger("input", [result.enroll_gl_details]);
          }, 500);
        }
      });
    }
  });
</script>
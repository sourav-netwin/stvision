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
        <form action="<?php echo base_url(); ?>index.php/specialbooking/insertGroup<?php echo ( $enroll_id != '' ) ? "/$enroll_id" : ''; ?>" name="special_booking_form" id="special_booking_form" class="grid12" method="POST">
          <div class="box-header with-border mr-bot-10">
            <h3 class="box-title">Booking details</h3>
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
                      <option value="<?php echo $item['id']; ?>" <?php echo ( !empty( $enroll_details ) && $enroll_details['sb_center_id'] == $item['id'] ) ? 'selected' : ''; ?>><?php echo $item['nome_centri']; ?></option>
                <?php
                    }
                  }
                ?>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-3 col-md-3">
              <label class="mr-left-10" for="accomodation_select">
                <strong>Accomodation</strong>
              </label>
            </div>
            <div class="col-sm-9 col-md-9 col-lg-6">
              <select  autocomplete="off" name="accomodation_select" id="accomodation_select" class="form-control" data-placeholder="Select accomodation">
                <option value="">Select accomodation</option>
                <?php
                  if ( count( $accomodation ) )
                  {
                    foreach ( $accomodation as $key => $item )
                    {
                ?>
                      <option value="<?php echo $item['accom_id']; ?>" <?php echo ( !empty( $enroll_details ) && $enroll_details['sb_accomodation_id'] == $item['accom_id'] ) ? 'selected' : ''; ?>><?php echo $item['accom_name']; ?></option>
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
              <input autocomplete="off" data-type="spinner" type="number" min="1" max="3" value="<?php echo ( !empty( $enroll_details ) && $enroll_details['sb_number_of_week'] ) ? $enroll_details['sb_number_of_week'] : '1'; ?>" id="n_weeks" name="n_weeks" class="form-control only_number" />
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-3 col-md-3">
              <label class="mr-left-10" for="n_weeks">
                <strong>Staff persons</strong>
              </label>
            </div>
            <div class="form-data col-sm-9 col-md-9 col-lg-6">
              <input autocomplete="off" data-type="spinner" type="number" min="1" max="100" value="<?php echo ( !empty( $enroll_details ) && $enroll_details['sb_number_of_staff'] ) ? $enroll_details['sb_number_of_staff'] : '1'; ?>" id="n_staff" name="n_staff" class="form-control only_number" />
            </div>
          </div>

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
                  <input class="form-control" type="text" autocomplete="off" id="adate" value="<?php echo ( !empty( $enroll_details ) ) ? date('d/m/Y', strtotime( $enroll_details['sb_arrival_date'] ) ) : '' ?>" readonly />
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3 col-lg-3 col-md-4">
                  Departure date:
                </div>
                <div class="col-sm-9 col-lg-4 col-md-6">
                  <input class="form-control" type="text" autocomplete="off" id="ddate" value="<?php echo ( !empty( $enroll_details ) ) ? date('d/m/Y', strtotime( $enroll_details['sb_departure_date'] ) ) : '' ?>" readonly>
                </div>
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
  pageHighlightMenu = "specialbooking";
  $(document).ready(function() {

    $(document).on("keypress",".only_number", function (e) {
      //if the letter is not digit then don't type anything
      if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        return false;
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

    jQuery.validator.addMethod("greaterThanZero", function(value, element) {
      return this.optional(element) || (parseFloat(value) > 0);
    },'Please enter value greater than 0');

    $("#special_booking_form").validate({
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
        center_select: {
          required: true
        },
        accomodation_select: {
          required: true
        },
        arrival_date: {
          required: true
        },
        departure_date: {
          required: true
        },
        n_weeks: {
          required: true
        },
        n_staff: {
          required: true
        }
      },
      messages: {
        center_select: {
          required: "Please select a center"
        },
        accomodation_select: {
          required: "Please select a accomodation"
        },
        arrival_date: {
          required: "Please select an arrival date"
        },
        departure_date: {
          required: "Please select a departure date"
        },
        n_weeks: {
          required: "Please enter number of weeks"
        },
        n_staff: {
          required: "Please enter number of staff persons"
        }
      },
      errorPlacement: function (error, element) {
        if (element.attr("type") == "checkbox") {
          error.appendTo($(".checkbox"));
        } else {
          error.insertAfter(element);
        }
      }
    });

    $("#writebook").click(function() {

      // validate form
      if( $("#special_booking_form").valid() )
      {
        $("#special_booking_form").submit();
      }

    });
  });

  $(window).load(function() {
    var url_value = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);

    if( url_value != 'specialbooking' )
    {
      $("#arrival_date").datepicker('setDate', new Date('<?php echo ( !empty ( $enroll_details ) ) ? $enroll_details['sb_arrival_date'] : '' ?>'));
      $("#hidd_arrival_date").val($("#arrival_date").val());
      $("#departure_date").datepicker('setDate', new Date('<?php echo ( !empty ( $enroll_details ) ) ? $enroll_details['sb_departure_date'] : '' ?>'));
      $("#hidd_departure_date").val($("#departure_date").val());
    }
  });
</script>
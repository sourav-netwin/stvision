<style type="text/css">
  .customfile{
    width: 250px !important;
    margin: 20px auto 0px !important;
    margin-top: 0px !important;
  }
  #importPaxFile{
    z-index: 999999;
  }
  @media(max-width: 650px){
    #postaPax table td {
      height: 24px !important;
    }
    #postaPax table th {
    height: 24px !important;
    }
  }
  #postaPax .form-control {
    padding:0px 5px!important;
  }
  .chooseDOB {
    z-index: 100000;
  }
  input[type="text"].rosterField{
    padding:2px;
    width:75px;
  }
  .form-control.w30{
    width:35px;
  }
  .form-control.w40{
    width:50px;
  }
  .form-control.w55{
    width:65px;
  }
  .form-control.w60{
    width:70px;
  }
  .form-control.w80{
    width:95px;
  }
  #copyFirst{
    display: none;
  }
</style>
<div class="row">
  <div class="col-sm-12">
    <?php echo showSessionMessageIfAny($this);?>
    <div class="form-group" style="border: none;">
      <form method="post" style="border: none !important;" action="<?php echo base_url(); ?>index.php/agentroster/importPax" enctype="multipart/form-data" onsubmit="return validateFile()">
        <div class="row">
          <div class="col-sm-12 text-right">
            <p>
              <a target="_blank" href="<?php echo site_url() ?>/agentroster/exportPaxForOffline/<?php echo $booking_detail["enroll_id"] ?>">
                <button type="button" class="btn btn-primary" id="exportPax" name="exportPax">Download excel file</button>
              </a>
            </p>
            <p>
              <input type="file" id="importPaxFile" name="importPaxFile" />
              <input class="btn btn-primary" type="submit" value="Upload excel file" />
            </p>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-12" style="overflow: auto; max-height: 350px;">
    <form name="postPax" id="postPax" method="POST" action="<?php echo base_url(); ?>index.php/agentroster/postPax/<?php echo $booking_detail["enroll_id"] ?>">
      <a href="javascript:void(0);" id="copyFirst">Copy common data from first line</a>
      <table class="table table-bordered table-hover width-full vertical-middle pax_list_table" style="width:99.98%;">
        <thead>
          <tr>
            <th>Type</th>
            <th>Surname</th>
            <th>Name</th>
            <th>Sex</th>
            <th>Date of birth</th>
            <th>Citizenship</th>
            <th>Passport no</th>
            <th>Health info</th>
            <th>Share room with</th>
            <th>GL ref.</th>
            <th>Type of course</th>
            <th>Activity</th>
            <th>Campus date in</th>
            <th>Campus date out</th>
            <th>Arr flight date</th>
            <th>Arr time</th>
            <th>Transfer in</th>
            <th>Arrival airport</th>
            <th>Flight number in</th>
            <th>Dep flight date</th>
            <th>Dep time</th>
            <th>Transfer out</th>
            <th>Departure airport</th>
            <th>Flight number out</th>
            <th>Visa</th>
            <th>Departure airport for the arrival flight</th>
            <th>Arrival airport for the departure flight</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $idFirstLine = $booked_pax[0]["booked_pax_id"];
            $idFirstLine1 = $booked_pax[0]["booked_pax_id"];
            foreach ( $booked_pax as $pax )
            {
          ?>
              <tr>
                <td class="text-center">
                  <?php echo $pax["booked_tipo_pax"] ?><br />
                  <?php
                    if( $pax["booked_tipo_pax"] == 'GL' )
                      echo $pax["gl_accom_name"];
                    else
                    {
                      if( $pax['pcomp_week'] != "" && $pax['accom_name'] != "" && $pax['courses_type'] != "" && $pax['act_activity_name'] != "" )
                        $package_comp = $pax['pcomp_week'].' Week - '.$pax['accom_name'].' - '.$pax['courses_type'].' - '.$pax['act_activity_name'];
                      else if ( $pax['pcomp_week'] != "" && $pax['accom_name'] != "" )
                      {
                        if( $pax['courses_type'] == "" && $pax['act_activity_name'] == "" )
                        {
                          $package_comp = $pax['pcomp_week'].' Week - '.$pax['accom_name'];
                        }
                        else if( $pax['courses_type'] == "" && $pax['act_activity_name'] != "" )
                        {
                          $package_comp = $pax['pcomp_week'].' Week - '.$pax['accom_name'].' - '.$pax['act_activity_name'];
                        }
                        else if( $pax['courses_type'] != "" && $pax['act_activity_name'] == "" )
                        {
                          $package_comp = $pax['pcomp_week'].' Week - '.$pax['accom_name'].' - '.$pax['courses_type'];
                        }
                      }
                      echo $package_comp;
                    }
                  ?>
                </td>
                <td class="text-center">
                  <input class="form-control reqField" id="booked_pax_surname__<?php echo $pax["booked_pax_id"] ?>" name="booked_pax_surname__<?php echo $pax["booked_pax_id"] ?>" type="text" value="<?php echo $pax["booked_pax_surname"] ?>" />
                </td>
                <td class="text-center">
                  <input class="form-control reqField" id="booked_pax_name__<?php echo $pax["booked_pax_id"] ?>" name="booked_pax_name__<?php echo $pax["booked_pax_id"] ?>" type="text" value="<?php echo $pax["booked_pax_name"] ?>" />
                </td>
                <td class="text-center">
                  <select id="booked_pax_gender__<?php echo $pax["booked_pax_id"] ?>" name="booked_pax_gender__<?php echo $pax["booked_pax_id"] ?>" style="font-size:10px;" class="reqField form-control w40">
                    <option value="">-</option>
                    <option value="M" <?php if ($pax["booked_pax_gender"] == "M") { ?>selected<?php } ?>>M</option>
                    <option value="F" <?php if ($pax["booked_pax_gender"] == "F") { ?>selected<?php } ?>>F</option>
                  </select>
                </td>
                <td class="text-center">
                  <input class="form-control chooseDOB reqField" id="booked_pax_dob__<?php echo $pax["booked_pax_id"] ?>"name="booked_pax_dob__<?php echo $pax["booked_pax_id"] ?>" type="text" value="<?php echo date("d/m/Y", strtotime($pax["booked_pax_dob"])) ?>" />
                </td>
                <td class="text-center td_booked_pax_nationality">
                  <input class="form-control nationality_ac reqField" id="booked_pax_nationality__<?php echo $pax["booked_pax_id"] ?>" name="booked_pax_nationality__<?php echo $pax["booked_pax_id"] ?>" type="text" value="<?php echo $pax["booked_pax_nationality"] ?>" />
                </td>
                <td class="text-center">
                  <input class="form-control reqField" id="booked_pax_passport_no__<?php echo $pax["booked_pax_id"] ?>" name="booked_pax_passport_no__<?php echo $pax["booked_pax_id"] ?>" type="text" value="<?php echo $pax["booked_pax_passport_no"] ?>" />
                </td>
                <td class="text-center">
                  <input class="form-control" id="booked_pax_salute__<?php echo $pax["booked_pax_id"] ?>" name="booked_pax_salute__<?php echo $pax["booked_pax_id"] ?>" type="text" value="<?php echo $pax["booked_pax_salute"] ?>" />
                </td>
                <td class="text-center td_booked_pax_share_room">
                  <input class="form-control" id="booked_pax_share_room__<?php echo $pax["booked_pax_id"] ?>" name="booked_pax_share_room__<?php echo $pax["booked_pax_id"] ?>" type="text" value="<?php echo $pax["booked_pax_share_room"] ?>" />
                </td>
                <td class="text-center td_booked_pax_gl_rif">
                  <input class="form-control" id="booked_pax_gl_rif__<?php echo $pax["booked_pax_id"] ?>" name="booked_pax_gl_rif__<?php echo $pax["booked_pax_id"] ?>" type="text" value="<?php echo $pax["booked_pax_gl_rif"] ?>" />
                </td>
                <td class="text-center">
                  <?php
                    if ( !empty( $course_list ) && $pax["booked_tipo_pax"] != 'GL' )
                    {
                  ?>
                      <select id="suppl__<?php echo $pax["booked_pax_id"] ?>" name="suppl__<?php echo $pax["booked_pax_id"] ?>" style="font-size:10px;" disabled>
                        <option value="">Select</option>
                        <?php
                          foreach ( $course_list as $course )
                          {
                        ?>
                            <option value="<?php echo $course['courses_type_id'] ?>" <?php echo ( $course['courses_type_id'] == $pax["courses_type_id"] ) ? 'selected' : ''; ?>><?php echo $course['courses_type'] ?></option>
                        <?php
                          }
                        ?>
                      </select>
                  <?php
                    }
                    else
                    {
                      echo '--';
                    }
                  ?>
                </td>
                <td class="text-center">
                  <?php
                    if ( !empty( $activity_list ) && $pax["booked_tipo_pax"] != 'GL' )
                    {
                  ?>
                      <select id="activity__<?php echo $pax["booked_pax_id"] ?>" name="activity__<?php echo $pax["booked_pax_id"] ?>" style="font-size:10px;" disabled>
                        <option value="">Select</option>
                        <?php
                          foreach ( $activity_list as $activity )
                          {
                        ?>
                            <option value="<?php echo $activity['act_id'] ?>" <?php echo ( $activity['act_id'] == $pax["act_id"] ) ? 'selected' : ''; ?>><?php echo $activity['act_activity_name'] ?></option>
                        <?php
                          }
                        ?>
                      </select>
                  <?php
                    }
                    else
                    {
                      echo '--';
                    }
                  ?>
                </td>
                <td class="text-center td_booked_pax_campus_arrival_date">
                  <input class="form-control chooseDate1 reqField" id="booked_pax_campus_arrival_date__<?php echo $pax["booked_pax_id"] ?>"name="booked_pax_campus_arrival_date__<?php echo $pax["booked_pax_id"] ?>" type="text" value="<?php echo date("d/m/Y", strtotime($pax["booked_pax_campus_arrival_date"])) ?>" />
                </td>
                <td class="text-center td_booked_pax_campus_departure_date">
                  <input class="form-control chooseDate2 reqField" id="booked_pax_campus_departure_date__<?php echo $pax["booked_pax_id"] ?>" name="booked_pax_campus_departure_date__<?php echo $pax["booked_pax_id"] ?>" type="text" value="<?php echo date("d/m/Y", strtotime($pax["booked_pax_campus_departure_date"])) ?>" />
                </td>
                <td class="text-center td_booked_pax_arrival_flight_date">
                  <input class="form-control chooseDateTime1 reqField" id="booked_pax_arrival_flight_date__<?php echo $pax["booked_pax_id"] ?>"name="booked_pax_arrival_flight_date__<?php echo $pax["booked_pax_id"] ?>" type="text" value="<?php echo date("d/m/Y", strtotime($pax["booked_pax_arrival_flight_date"])) ?>" />
                </td>
                <td class="text-center td_ora_arrivo_volo">
                  <input class="form-control chooseTime1 reqField" id="ora_arrivo_volo__<?php echo $pax["booked_pax_id"] ?>"name="ora_arrivo_volo__<?php echo $pax["booked_pax_id"] ?>" type="text" value="<?php echo date("H:i", strtotime($pax["booked_pax_arrival_flight_date"])) ?>" />
                </td>
                <td class="text-center td_booked_pax_transfer_in">
                  <input type="checkbox" id="booked_pax_transfer_in__<?php echo $pax["booked_pax_id"] ?>" name="booked_pax_transfer_in__<?php echo $pax["booked_pax_id"] ?>" <?php if ($pax["booked_pax_transfer_in"] == 1) { ?>checked="checked"<?php } ?>>
                </td>
                <td class="text-center td_booked_pax_arrival_airport">
                  <input class="form-control airport_ac reqField" id="booked_pax_arrival_airport__<?php echo $pax["booked_pax_id"] ?>"name="booked_pax_arrival_airport__<?php echo $pax["booked_pax_id"] ?>" type="text" value="<?php echo $pax["booked_pax_arrival_airport"] ?>" />
                </td>
                <td class="text-center td_booked_pax_arrival_flight_number">
                  <input class="form-control reqField" id="booked_pax_arrival_flight_number__<?php echo $pax["booked_pax_id"] ?>" name="booked_pax_arrival_flight_number__<?php echo $pax["booked_pax_id"] ?>" type="text" value="<?php echo $pax["booked_pax_arrival_flight_number"] ?>" />
                </td>
                <td class="text-center td_booked_pax_departure_flight_date">
                  <input class="form-control chooseDateTime2 reqField" id="booked_pax_departure_flight_date__<?php echo $pax["booked_pax_id"] ?>" name="booked_pax_departure_flight_date__<?php echo $pax["booked_pax_id"] ?>" type="text" value="<?php echo date("d/m/Y", strtotime($pax["booked_pax_departure_flight_date"])) ?>" />
                </td>
                <td class="text-center td_ora_partenza_volo">
                  <input class="form-control chooseTime2 reqField" id="ora_partenza_volo__<?php echo $pax["booked_pax_id"] ?>" name="ora_partenza_volo__<?php echo $pax["booked_pax_id"] ?>" type="text" value="<?php echo date("H:i", strtotime($pax["booked_pax_departure_flight_date"])) ?>" />
                </td>
                <td class="text-center td_booked_pax_transfer_out">
                  <input type="checkbox" id="booked_pax_transfer_out__<?php echo $pax["booked_pax_id"] ?>" name="booked_pax_transfer_out__<?php echo $pax["booked_pax_id"] ?>" <?php if ($pax["booked_pax_transfer_out"] == 1) { ?>checked="checked"<?php } ?>>
                </td>
                <td class="text-center td_booked_pax_departure_airport">
                  <input class="form-control airport_ac reqField" id="booked_pax_departure_airport__<?php echo $pax["booked_pax_id"] ?>" name="booked_pax_departure_airport__<?php echo $pax["booked_pax_id"] ?>" type="text" value="<?php echo $pax["booked_pax_departure_airport"] ?>" />
                </td>
                <td class="text-center td_booked_pax_departure_flight_number">
                  <input class="form-control reqField" id="booked_pax_departure_flight_number__<?php echo $pax["booked_pax_id"] ?>" name="booked_pax_departure_flight_number__<?php echo $pax["booked_pax_id"] ?>" type="text" value="<?php echo $pax["booked_pax_departure_flight_number"] ?>" />
                </td>
                <td class="text-center td_booked_pax_visa">
                  <input class="yesVisa" type="checkbox" id="booked_pax_visa__<?php echo $pax["booked_pax_id"] ?>" name="booked_pax_visa__<?php echo $pax["booked_pax_id"] ?>" <?php if ($pax["booked_pax_visa"] == 1) { ?>checked="checked"<?php } ?>
                </td>
                <td class="text-center td_booked_pax_departure_arrival_airport">
                  <input class="form-control airport_ac reqField" airport_ac id="booked_pax_departure_arrival_airport__<?php echo $pax["booked_pax_id"] ?>" name="booked_pax_departure_arrival_airport__<?php echo $pax["booked_pax_id"] ?>" type="text" value="<?php echo $pax["booked_pax_departure_arrival_airport"] ?>" />
                </td>
                <td class="text-center td_booked_pax_arrival_departure_airport">
                  <input class="form-control airport_ac reqField" id="booked_pax_arrival_departure_airport__<?php echo $pax["booked_pax_id"] ?>" name="booked_pax_arrival_departure_airport__<?php echo $pax["booked_pax_id"] ?>" type="text" value="<?php echo $pax["booked_pax_arrival_departure_airport"] ?>" />
                </td>
              </tr>
          <?php
            }
          ?>
        </tbody>
      </table>
      <input type="hidden" name="noChanges" id="noChanges" value="NOSEND" />
    </form>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $("#copyFirst").click(function() {
      campi = new Array("booked_pax_arrival_airport", "booked_pax_departure_airport", "booked_pax_arrival_flight_date", "booked_pax_campus_departure_date", "booked_pax_campus_arrival_date", "booked_pax_campus_departure_date", "booked_pax_arrival_flight_number", "booked_pax_departure_flight_number", "booked_pax_gl_rif", "ora_arrivo_volo", "ora_partenza_volo", "booked_pax_departure_arrival_airport", "booked_pax_arrival_departure_airport");
      for (index = 0; index < campi.length; index++)
      {
        nomecampo = campi[index];
        valorecampo = $("#" + nomecampo + "__<?php echo $idFirstLine ?>").val();
        writeValues(valorecampo, "td.td_" + campi[index]);
      }
      campiCheck = new Array("booked_pax_transfer_in", "booked_pax_transfer_out");
      for (index = 0; index < campiCheck.length; index++)
      {
        nomecampo = campiCheck[index];
        valorecampo = $("#" + nomecampo + "__<?php echo $idFirstLine ?>").prop("checked");
        writeCKValues(valorecampo, "td.td_" + campiCheck[index]);
      }
    });

    $("#booked_pax_visa__<?php echo $idFirstLine1 ?>").click(function(){
      $(".yesVisa").each(function(){
        $(this).prop("checked",$("#booked_pax_visa__<?php echo $idFirstLine1 ?>").prop('checked'));
      });
    });

    $(".chooseDate1").datepicker({
      numberOfMonths: 1,
      dateFormat: "dd/mm/yy",
      onClose: function() {
        var a = $(this).attr("id").split("__");
        changeIdIs = "ritorno_data_partenza__" + a[1];
        dataGirata = parseDate($(this).val());
        $("#" + changeIdIs).datepicker("option", "minDate", new Date(dataGirata));
      }
    });

    $(".chooseDate2").datepicker({
      numberOfMonths: 1,
      dateFormat: "dd/mm/yy",
      onClose: function() {
        var a = $(this).attr("id").split("__");
        changeIdIs = "andata_data_arrivo__" + a[1];
        dataGirata = parseDate($(this).val());
        $("#" + changeIdIs).datepicker("option", "maxDate", new Date(dataGirata));
      }
    });

    $(".chooseDateTime1").datepicker({
      numberOfMonths: 1,
      dateFormat: "dd/mm/yy",
      autoSize: false
    });

    $(".chooseDateTime2").datepicker({
      numberOfMonths: 1,
      dateFormat: "dd/mm/yy",
      autoSize: false
    });

    $(".chooseTime1").timepicker({
      autoSize: false,
      format: "HH:ii"
    });

    $(".chooseTime2").timepicker({
      autoSize: false,
      format: "HH:ii"
    });

    $(".airport_ac").autocomplete({
      source: function(a, b) {
        $.ajax({
          url: "<?php echo base_url(); ?>index.php/agents/searchAP",
          dataType: "json",
          data: {
            style: "full",
            term: a.term
          },
          success: function(a) {
            b($.map(a.airports, function(a) {
              return {
                id: a.id,
                label: a.value,
                value: a.value
              };
            }));
          }
        });
      },
      minLength: 3
    });

    $(".nationality_ac").autocomplete({
      source: function(a, b) {
        $.ajax({
          url: "<?php echo base_url(); ?>index.php/agents/searchNat",
          dataType: "json",
          data: {
            style: "full",
            term: a.term
          },
          success: function(a) {
            b($.map(a.nationalities, function(a) {
              return {
                id: a.id,
                label: a.value,
                value: a.value
              };
            }));
          }
        });
      },
      minLength: 3
    });

    $(document).on("blur", ".nationality_ac", function() {
      var a = $(this);
      var b = a.val();
      if ("" != b && "undefined" != typeof b) $.post(siteUrl + "agents/checkTypedNationality", {
        nationality: b
      }, function(b) {
        if (1 != b) a.val("");
      });
    });

    $(document).on("mouseover", "a.ui-corner-all", function(a) {
      a.preventDefault();
      $(".nationality_ac:focus").val($(this).html());
    });

    $(".chooseDOB").datepicker({
      numberOfMonths: 1,
      dateFormat: "dd/mm/yy",
      changeMonth: true,
      changeYear: true
    });
  });

  function writeValues(a, b) {
    $(b + " input").each(function() {
      $(this).val(a);
    });
  }

  function writeCKValues(a, b) {
    $(b + " input").each(function() {
      $(this).prop("checked", a);
    });
  }

  function parseDate(a) {
    var b = a.split("/");
    return new Date(b[2], b[1] - 1, b[0]);
  }

  $(document).on("keyup keydown blur", "input[type=text]", function() {
    if ($(this).hasClass("ui-autocomplete-loading"))
      $(this).removeClass("ui-autocomplete-loading");
  });

  function validateFile()
  {
    var a = $.trim($("#importPaxFile").val());
    if (!a || "" == a) {
      swal("Error", "Please select excel file to upload");
      return false;
    }
    else
      return true;
  }
</script>
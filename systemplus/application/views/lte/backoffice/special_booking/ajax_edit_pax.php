<style type="text/css">
  .chooseDOB {
    z-index: 100000;
  }
</style>
<div class="row">
  <div class="col-sm-12">
    <?php echo showSessionMessageIfAny($this);?>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <form name="postPax" id="postPax" method="POST" action="<?php echo base_url(); ?>index.php/specialbooking/postPax/<?php echo $booking_detail["sb_id"] ?>">
      <table class="table table-bordered table-hover width-full vertical-middle pax_list_table" style="width:99.98%;">
        <thead>
          <tr>
            <th>No.</th>
            <th>Surname</th>
            <th>Name</th>
            <th>Date of birth</th>
            <th>Position</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $i = 0;
            foreach ( $booked_pax as $pax )
            {
              $i++;
          ?>
              <tr>
                <td class="text-center">
                  <?php echo $i; ?>
                </td>
                <td class="text-center">
                  <input class="form-control" id="sb_pax_surname__<?php echo $pax["sb_pax_id"] ?>" name="sb_pax_surname__<?php echo $pax["sb_pax_id"] ?>" type="text" value="<?php echo $pax["sb_pax_surname"] ?>" />
                </td>
                <td class="text-center">
                  <input class="form-control" id="sb_pax_name__<?php echo $pax["sb_pax_id"] ?>" name="sb_pax_name__<?php echo $pax["sb_pax_id"] ?>" type="text" value="<?php echo $pax["sb_pax_name"] ?>" />
                </td>
                <td class="text-center">
                  <input class="form-control chooseDOB" id="sb_pax_dob__<?php echo $pax["sb_pax_id"] ?>"name="sb_pax_dob__<?php echo $pax["sb_pax_id"] ?>" type="text" value="<?php echo ( $pax["sb_pax_dob"] ) ? date("d/m/Y", strtotime($pax["sb_pax_dob"])) : '' ?>" readonly/>
                </td>
                <td class="text-center">
                  <input class="form-control" id="sb_pax_position__<?php echo $pax["sb_pax_id"] ?>" name="sb_pax_position__<?php echo $pax["sb_pax_id"] ?>" type="text" value="<?php echo $pax["sb_pax_position"] ?>" />
                </td>
              </tr>
          <?php
            }
          ?>
        </tbody>
      </table>
    </form>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {

    $(".chooseDOB").datepicker({
      numberOfMonths: 1,
      dateFormat: "dd/mm/yy",
      changeMonth: true,
      changeYear: true,
      maxDate: new Date()
    });

  });
</script>
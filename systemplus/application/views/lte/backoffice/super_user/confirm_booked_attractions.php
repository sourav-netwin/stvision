<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
          <div class="row">
            <?php showSessionMessageIfAny($this);?>
          </div>
          <form id="box_transport" name="box_transport" action="<?php echo base_url(); ?>index.php/backoffice/reviewBookedAttractions" method="POST">
            <div class="row payment_row">
              <div class="col-sm-4 col-md-2">
                <label for="centricampus">Campus:</label>
                <select class="form-control" id="centricampus" name="centri">
                  <?php
                    foreach($centri as $key=>$item) 
                    { 
                  ?>
                      <option <?php if($campus==$item['id']){?>selected <?php }?>value="<?php echo $item['id']?>"><?php echo $item['nome_centri']?></option>
            <?php   } ?>
                </select>
              </div>
              <div class="col-sm-4 col-md-2 mr-top-25">
                <input class="btn btn-primary" type="submit" value="Search" id="transpmi" name="transpmi"/>
              </div>
            </div>
          </form>
        </div>
        <div class="box-body">
          <table id="dataTableStaffPriority" class="table datatable table-bordered table-striped">
            <thead>
              <tr>
                <th>Booking id</th>
                <th>Agency</th>
                <th>Attraction</th>
                <th>Pax</th>
                <th>Cost</th>
                <th class="no-sort">Confirm</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if (!empty($all_excursions)) 
                {
                  foreach($all_excursions as $exc)
                  {
                    $costArray = explode(".",$exc["atb_total_price"]);
              ?>
                    <tr id="n_<?php echo $exc["atb_id"]?>">
                      <td>
                        <strong><?php echo $exc["atb_id_year"]?>_<?php echo $exc["atb_id_book"]?></strong>
                      </td>
                      <td>
                        <?php echo $exc["businessname"]?>
                      </td>
                      <td>
                        <?php echo $exc["pat_name"]?>
                        <font style="font-weight:bold;display:block;clear:both;">
                          Students: <?php echo $exc["pat_student_price"]?> <?php echo $exc["cur_codice"]?> - Adults: <?php echo $exc["pat_adult_price"]?> <?php echo $exc["cur_codice"]?>
                        </font>
                      </td>
                      <td><?php echo $exc["atb_tot_pax"]?></td>
                      <td data-sort="<?php echo $costArray[0] ?>,<?php echo $costArray[1] ?>">
                        <input type="text" name="cost1_<?php echo $exc["atb_id"]?>" id="cost1_<?php echo $exc["atb_id"]?>" value="<?php echo $costArray[0] ?>" style="text-align:right;width:30px;" maxlength="4"> , <input type="text" style="text-align:left;width:20px;" name="cost2_<?php echo $exc["atb_id"]?>" id="cost2_<?php echo $exc["atb_id"]?>" value="<?php echo $costArray[1] ?>" maxlength="2"></td>
                      <td>
                        <a data-gravity="s" class="btn btn-danger confAtt" href="javascript:void(0);" name="Confirm attraction" original-title="Confirm attraction" id="bookC_<?php echo $exc["atb_id"]?>">Confirm attraction</a>
                      </td>
                    </tr>
            <?php
                  }
                }
            ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Booking id</th>
                <th>Agency</th>
                <th>Attraction</th>
                <th>Pax</th>
                <th>Cost</th>
                <th>Confirm</th>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          &nbsp;
        </div>
        <!-- /.box-footer-->
      </div>
    </div>
  </div>
</section>

<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $(".confAtt").click(function(e){
    if(confirm("Are you sure you want to confirm this attraction booking?")){
      arrattID = ($(this).attr("id")).split("_");
      inte = $("#cost1_"+arrattID[1]).val();
      deci = $("#cost2_"+arrattID[1]).val();
      $.ajax({
        url: '<?php echo base_url(); ?>index.php/backoffice/confirmBookAttraction/'+arrattID[1]+'/'+inte+'/'+deci,
        cache: false,
        type: 'POST',
        success: function(msg) {
          if(msg=="UPDATED"){
            $("#n_"+arrattID[1]).hide();
            alert("Attraction booking confirmed!");
          }else{
            alert("Invalid cost format!");
          }
        }
      });
    }else{
      return void(0);
    }
  }); 
});
</script>
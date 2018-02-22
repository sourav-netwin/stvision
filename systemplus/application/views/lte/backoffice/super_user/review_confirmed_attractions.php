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
          <form id="box_transport" name="box_transport" action="<?php echo base_url(); ?>index.php/backoffice/reviewConfirmedAttractions" method="POST">
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
          <table id="dataTableStaffPriority" class="table datatable table-bordered table-striped" style="table-layout: fixed; width: 100%;">
            <thead>
              <tr>
                <th style="width:10%;">Booking id</th>
                <th style="width:20%;">Agency</th>
                <th style="width:40%;">Attraction</th>
                <th style="width:10%;">Pax</th>
                <th style="width:10%;">Cost</th>
                <th style="width:10%;">Confirmation date</th>
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
                      <td>
                        <?php echo $exc["atb_tot_pax"]?>
                      </td>
                      <td data-sort="<?php echo $exc["atb_total_price"] ?>">
                        <?php echo str_replace(".",",",$exc["atb_total_price"]) ?> <?php echo $exc["cur_codice"]?>
                      </td>
                      <td>
                        <?php echo date("d/m/Y",strtotime($exc["atb_confirmed_date"])); ?>
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
                <th>Confirmation date</th>
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
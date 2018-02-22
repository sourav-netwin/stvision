<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
    <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
            <div class="row">
                <div class="col-sm-6 btn-create">
                    <a href="<?php echo base_url(); ?>index.php/packages/addedit" class="btn btn-primary btn-sm" id="createClass" ><i class="fa fa-plus"></i>&nbsp;Create new package</a>
                </div>
                <?php showSessionMessageIfAny($this);?>
            </div>
        </div>
        <div class="box-body">
            <table class="datatable table table-bordered table-striped" style="width:99.98%">
                <thead>
                        <tr>
                                <th>Package</th>
                                <th>Campus</th>								
                                <th>Category program</th>								
                                <th>Course type</th>								
                                <th>Start date</th>
                                <th>Expiry date</th>
                                <th class="no-sort">Action</th>
                        </tr>
                </thead>
                <tbody>
                <?php 
                if($packageData)
                foreach($packageData as $package){
                ?>
                        <tr>
                                <td class="center">
                                <?php echo html_entity_decode($package["pack_package"]);?>
                                </td>
                                <td class="center">
                                    <?php 
                                        echo $package["nome_centri"]." ";
                                        if(strlen($package["accommodation"]))
                                            echo "<label style='display: inline-block;' class='label label-info'>".str_replace(',', ', ', $package["accommodation"]) . "</label>";
                                    ?>
                                </td>
                                <td class="center">
                                <?php 
                                    echo htmlentities(ucwords($package["procat_name"]));
                                ?></td>
                                <td class="center">
                                <?php 
                                    echo str_replace(',', ', ', $package["ct_courses_type"]);
                                ?></td>
                                <td class="center"><?php 
                                    $txtStartDate = new DateTime($package["pack_start_date"]);
                                    $txtStartDate = $txtStartDate->format('d/m/Y');
                                    echo $txtStartDate;?></td>
                                <td class="center"><?php 
                                    $txtExpiryDate = new DateTime($package["pack_expiry_date"]);
                                    $txtExpiryDate = $txtExpiryDate->format('d/m/Y');
                                    echo $txtExpiryDate;?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="javascript:void(0);" data-valuta="<?php echo $package['valuta_fattura'];?>" data-pack-id="<?php echo $package["pack_package_id"]?>" class="min-wd-24 dialogbtn btn btn-xs btn-primary" ><span data-original-title="View" data-container="body" data-toggle="tooltip"><i class="fa fa-eye"></i></span></a>
                                        <a href="<?php echo base_url().'index.php/packages/addedit/'.$package["pack_package_id"];?>" class="min-wd-24 btn btn-xs btn-info" ><span data-original-title="Edit" data-container="body" data-toggle="tooltip"><i class="fa fa-edit"></i></span></a>
                                    </div>
                                </td>
                        </tr>
                <?php
                        }
                ?>
                </tbody>
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
<!-- THIS IS TEACHER VIEW DETAILS MODAL -->
<div id="dialog_modal_excursion_activities" data-backdrop="static" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Package composition
                    <button aria-label="Close" onclick="$('#dialog_modal_excursion_activities').modal('hide');" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div id="viewModalBody" style="overflow-x: auto;" class="modal-body">
            </div>
            <div class="modal-footer">
                <button  onclick="$('#dialog_modal_excursion_activities').modal('hide');"  class="btn btn-default pull-left" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
        var SITE_PATH = "<?php echo base_url();?>index.php/";
	$(document).ready(function() {
               // start here..
               $("body").on('click','.dialogbtn',function(e){
                  var pack_id = $(this).attr('data-pack-id');
                  var valuta = $(this).attr('data-valuta');
                  //getPackExcActivities
                  $.post(SITE_PATH + 'packages/getViewCompositionsTable',{'pack_id':pack_id,'valuta':valuta},function(data){
                      $("#viewModalBody").html(data);
                  });
                  $("#dialog_modal_excursion_activities").modal('show');
               });
	});
</script>
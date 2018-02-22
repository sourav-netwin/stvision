<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header with-border">
            <h4 class="box-title">Booked Attractions</h4>
        </div>
        <div class="box-body">
            <div class="row">
            <?php showSessionMessageIfAny($this);?>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                <?php 
                if(count($allAtt) > 0){
                ?>
                <table class="datatable table table-bordered table-striped" style="width:99.98%;">
                    <thead>
                        <tr>
                            <th class="text-center">Book Id</th>
                            <th class="text-center" >Campus</th>
                            <th class="text-center" >Students</th>
                            <th class="text-center" >Attraction</th>
                            <th class="text-center" >Status</th>
                            <th class="text-center no-sort" style="width:35%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($allAtt as $eex) {
                            $colorF = "#990000";
                            $statusF = "STANDBY";
                            if ($eex["atb_confirmed"] == "YES") {
                                $statusF = "CONFIRMED";
                                $colorF = "#009900";
                            }
                            ?>
                            <tr>
                                <td class="text-center" ><?php echo $eex["atb_id_year"] ?>_<?php echo $eex["atb_id_book"] ?></td>
                                <td class="text-center" ><?php echo $eex["nome_centri"] ?></td>
                                <td class="text-center"><?php echo $eex["atb_tot_pax"] ?></td>
                                <td class="text-center"><?php echo $eex["pat_name"] ?></td>
                                <td class="text-center" style="color:<?php echo $colorF ?>"><strong><?php echo $statusF ?></strong></td>
                                <td  class="text-center">
                                    <?php if ($eex["atb_confirmed"] == "STANDBY") { ?>
                                        <a data-toggle="tooltip" class="remAtt min-wd-24 btn btn-xs btn-danger" href="javascript:void(0);" name="Remove booked attraction now" title="Remove booked attraction now" id="bookA_<?php echo $eex["atb_id"] ?>_<?php echo $eex["atb_id_book"] ?>">Remove booked attraction</a>
                                    <?php } ?>
                                    <?php //if($eex["atb_confirmed"]=="YES"){ ?>
                                        <a data-toggle="tooltip" class="viewAtt min-wd-24 btn btn-xs btn-primary" href="javascript:void(0);" name="View attraction invoice" title="View attraction invoice" id="viewA_<?php echo $eex["atb_id"] ?>_<?php echo $eex["atb_id_book"] ?>">View attraction invoice</a>
                                    <?php //} ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                }else{
                ?>
                <table class="datatable table table-bordered table-striped">
                    <tr><td>No booked attractions available</td></tr>
                </table>							
                <?php
                }
                ?>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            &nbsp;
        </div>
        <!-- /.box-footer-->
      </div>
      </div>
    </div>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
$(document).ready(function() {
        $(".remAtt").click(function(e){
            if(confirm("Are you sure you want to remove this attraction booking?")){
                    arrattID = ($(this).attr("id")).split("_");
                    window.location.href="<?php echo base_url(); ?>index.php/agents/remBookAttraction/"+arrattID[1]+"/"+arrattID[2];
            }else{
                    return void(0);
            }
            });

            $(".viewAtt").click(function(e){
                    arrattID = ($(this).attr("id")).split("_");
                    window.open("<?php echo base_url(); ?>index.php/agents/PDF_BookAttraction/"+arrattID[1]+"/"+arrattID[2]);
                    return void(0);
            });	
});
        
</script>
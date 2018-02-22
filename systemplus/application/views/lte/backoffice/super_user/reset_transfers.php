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
        </div>
        <div class="box-body">
            <table id="dataTableStaffPriority" class="table datatable table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Transfer date</th>
                        <th>Campus</th>
                        <th>Type</th>
                        <th>Airport</th>
                        <th>Flight(s)<br />N. pax</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (!empty($losttransfers)) 
                        {
                            foreach($losttransfers as $exc)
                            {
                    ?>
                                <tr>
                                    <td><?php echo date("d/m/Y",strtotime($exc["ptt_excursion_date"]))?></td>
                                    <td><strong><?php echo $exc["nome_centri"]?></strong></td>  
                                    <td>
                                        <?php if($exc["ptt_type"]=="inbound") { ?>
                                            <font style="color:#009900;font-weight:bold;">INBOUND</font>
                                        <?php } ?>                                  
                                        <?php if($exc["ptt_type"]=="outbound") { ?>
                                            <font style="color:#990000;font-weight:bold;">OUTBOUND</font>
                                        <?php } ?>  
                                    </td>                                   
                                    <?php  if($exc["ptt_type"]=="inbound") { ?>
                                        <td><?php echo $exc["ptt_airport_to"]?></td>
                                    <?php } else { ?>
                                        <td><?php echo $exc["ptt_airport_from"]?></td>
                                    <?php
                                        }
                                    ?>
                                    <td class="neretto"><strong><?php echo $exc["ptt_flight"]?></strong><br /><?php echo $exc["allpax"]?> pax</td>                                   
                                </tr>
                    <?php
                            }
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Transfer date</th>
                        <th>Campus</th>
                        <th>Type</th>
                        <th>Airport</th>
                        <th>Flight(s)<br />N. pax</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <?php if (!empty($losttransfers)) { ?>
                <input type="button" class="btn btn-danger pull-right" value="Reset transfers" name="resetTra" id="resetTra" />
            <?php } ?>
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
    $("#resetTra").click(function(){
        if(confirm("Are you sure you want to reset all the lost transfers?")){
            window.location.replace("<?php echo base_url(); ?>index.php/backoffice/actionResetLostTrasfers/");
        }else{
            return void(0);
        }
    });
});
</script>
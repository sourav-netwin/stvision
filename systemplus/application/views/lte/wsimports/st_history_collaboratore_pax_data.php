<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
            <div class="row">
                <?php showSessionMessageIfAny($this);?>
            </div>
        </div>
        <div class="box-body">
            <div class="col-sm-12">
            <form id="frmExport" action="<?php echo base_url(); ?>index.php/sthistory/collaboratorepax" method="post">
                <input type="hidden" name="txtCollaboratore" value="<?php echo htmlspecialchars($txtCollaboratore);?>" />
                <input type="hidden" name="hiddCollaboratoreType" value="<?php echo $hiddCollaboratoreType;?>" />
                <input type="hidden" name="isExport" value="1" />
                    
            
                <div class="pull-right mr-bot-10">
                    <input id="backToFilter" class="export-button btn btn-primary" type="button" value="Back" />
                    <input <?php echo (empty($resultData) ? "disabled = 'disabled'" : "");?> id="exportExcel" class="export-button btn btn-primary" type="submit" value="Export" />
                </div>
            </form>
            </div>
            <div class="col-sm-12">
                <table class="datatable table table-bordered table-striped" style="width:99.98%;">
                    <thead>
                        <tr>
                                <th class="text-center">Traveling year [data partenza]</th>
                                <th class="text-center"><?php echo ($hiddCollaboratoreType == "professori" ? "Collaboratore" : "Azienda")?></th>
                                <th class="text-center">Pax</th>
                                <th class="text-center">Previous pax</th>
                                <th class="text-center">Previous pax %</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($resultData as $data) { 
                                $prevPaxPercent = round($data["old_pax"] * 100 / $data["pax"],2);
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $data["traveling_year"]; ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($data['collaboratore']); ?></td>
                                        <td class="text-center"><?php echo $data["pax"]; ?></td>
                                        <td class="text-center"><?php echo $data["old_pax"]; ?></td>
                                        <td class="text-center <?php echo ($prevPaxPercent >= 30 ? 'prevPaxPercentGreen' : 'prevPaxPercentRed');?>"><?php echo $prevPaxPercent; ?></td>
                                    </tr>
                        <?php } ?>
                    </tbody>
                </table>
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
</section>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    var SITE_PATH = "<?php echo base_url(); ?>index.php/";
    $(document).ready(function() {
        $("#backToFilter").click(function(){
                window.location.href= SITE_PATH + "sthistory/collaboratorepax";
        });
   });
</script>
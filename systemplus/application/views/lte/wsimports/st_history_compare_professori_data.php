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
            <form id="frmExport" action="<?php echo base_url(); ?>index.php/sthistory/compareprofessori" method="post">
                <input type="hidden" name="selCollaboratorePro" value="<?php echo (is_array($txtCollaboratore) ? implode(',', $txtCollaboratore) : '');?>" />
                <input type="hidden" name="anno" value="<?php echo (is_array($txtAnnoYears) ? implode(',', $txtAnnoYears) : '');?>" />
                <input type="hidden" name="hiddCollaboratoreType" value="<?php echo $hiddCollaboratoreType;?>" />
                <input type="hidden" id="isExport" name="isExport"  value="1" />

            <div class="col-sm-12 mr-bot-10">
                <div class="pull-right mr-bot-10">
                    <input id="backToFilter" class="export-button btn btn-primary" type="button" value="Back" />
                    <input <?php echo (empty($resultData) ? "disabled = 'disabled'" : "");?> id="exportExcel" class="export-button btn btn-primary" type="submit" value="Export" />
                    <input <?php echo (empty($resultData) ? "disabled = 'disabled'" : "");?> onclick="$('#isExport').val('2');" id="exportExcelAll" class="export-button btn btn-primary" type="submit" value="Export all" />
                </div>
            </div>
            </form>
            <div class="col-sm-12">
                <table class="datatable table table-bordered table-striped" style="width:99.98%;">
                    <thead>
                        <tr>
                                <th class="text-center"><?php echo ($hiddCollaboratoreType == "professori" ? "Collaboratore" : "Azienda")?></th>
                                <th class="text-center">Traveling year [data partenza]</th>
                                <th class="text-center">Tipologia prodotto</th>
                                <th class="text-center">Destinazione nazione</th>
                                <th class="text-center">Pax</th>
                                <th class="text-center">Fatturatto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($resultData as $data) { 
                                    ?>
                                    <tr>
                                            <td class="text-center"><?php echo htmlspecialchars($data['collaboratore']); ?></td>
                                            <td class="text-center"><?php echo $data["traveling_year"]; ?></td>
                                            <td class="text-center"><?php echo $data["tipologia_prodotto"]; ?></td>
                                            <td class="text-center"><?php echo $data["destinazione_nazione"]; ?></td>
                                            <td class="text-center"><?php echo $data["pax"]; ?></td>
                                            <td class="text-center" data-sort="<?php echo $data["fatturato"];?>"><?php echo number_format($data["fatturato"],2,',','.'); ?></td>
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
                window.location.href= SITE_PATH + "sthistory/compareprofessori";
        });
    });
</script>
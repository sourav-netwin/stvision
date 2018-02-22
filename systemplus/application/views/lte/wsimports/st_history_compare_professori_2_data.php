<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<style>
    .table-striped > tbody > tr:nth-of-type(2n+1) {
        background-color: #e9e9e9;
    }
    .yearSeparator {
        border-right: 2px solid silver !important;
    }
</style>
<div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
            <div class="row">
                <?php showSessionMessageIfAny($this);
                $CI = & get_instance();
                ?>
            </div>
        </div>
        <div class="box-body">
            <form id="frmExport" action="<?php echo base_url(); ?>index.php/sthistory/compareprofessori" method="post">
                <input type="hidden" name="selCollaboratoreMacroRegione" value="<?php echo (is_array($selCollaboratoreMacroRegione) ? implode(',', $selCollaboratoreMacroRegione) : '');?>" />
                <input type="hidden" name="anno" value="<?php echo (is_array($txtAnnoYears) ? implode(',', $txtAnnoYears) : '');?>" />
                <input type="hidden" name="hiddCollaboratoreType" value="<?php //echo $hiddCollaboratoreType;?>" />
                <input type="hidden" id="isExport" name="isExport"  value="1" />

            <div class="col-sm-12 mr-bot-10">
                <div class="pull-right mr-bot-10">
                    <input id="backToFilter" class="export-button btn btn-primary" type="button" value="Back" />
                </div>
            </div>
            </form>
            <div class="col-sm-12">
                <?php foreach($selTiplogiaProdotto as $tipologiaProdotto){?>
                <strong>Tipologia prodotto: <?php echo $tipologiaProdotto;?></strong>
                <table class="datatable table table-bordered table-striped" style="width:99.98%;">
                    <thead>
                        <tr>
                            <th class="text-center" rowspan="2">Collaboratore macro regione</th>
                            <th class="text-center" rowspan="2">Collaboratore</th>
                            <?php 
                            $cCount = count($selDestinazioneNazione);
                            $lastCountry = end($selDestinazioneNazione);
                            foreach($txtAnnoYears as $annoYear){
                            ?>
                                <th class="text-center no-sort yearSeparator" colspan="<?php echo $cCount;?>"><?php echo $annoYear;?></th>
                            <?php    
                            }?>
                        </tr>
                        <tr>
                            <?php 
                            
                            foreach($txtAnnoYears as $annoYear){
                            $colIndex = 0;
                            foreach($selDestinazioneNazione as $destiNazione){
                                $colIndex++;
                                $colIndexClass = "";
                                if($cCount == $colIndex)
                                    $colIndexClass = "yearSeparator";
                                ?>
                                    <td class="text-center nation-cell  no-sort <?php echo $colIndexClass;?>"><?php echo $destiNazione;?></td>
                                <?php 
                                }
                            }?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $resultData = $CI->getColTipologiaPaxCount($tipologiaProdotto,$selCollaboratoreMacroRegione,$txtAnnoYears,$selDestinazioneNazione);
                    if(isset($resultData))
                        foreach ($resultData as $row) 
                        {
                    ?>
                      <tr>
                            <?php 
                            foreach ($row as $key => $cell) {
                                $cellColor = "";
                                if(is_numeric($cell))
                                if($cell > 0)
                                    $cellColor = "nonZeroPax";
                                else
                                    $cellColor = "zeroPax";
                                $yearSep = "";
                                                                
                                if(strtolower(substr($key, 5)) == strtolower($lastCountry))
                                    $yearSep = " yearSeparator";
                                
                                ?>
                                <td class="text-center <?php echo $cellColor; echo " ".$yearSep;?>"><?php echo htmlspecialchars($cell); ?></td>
                            <?php }?>
                      </tr>
                    <?php 
                        } ?>
                    </tbody>
                </table>
                <?php }?>
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
                window.location.href= SITE_PATH + "sthistory/compareprofessorisecond";
        });
    });
</script>
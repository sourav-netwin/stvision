<div class="box box-primary">
<form id="frmCollaboratorPro" onsubmit="return validateForm('frmCollaboratorPro');" action="<?php echo base_url(); ?>index.php/sthistory/compareprofessorisecond<?php echo (empty($ischart) ? '' : '/'.$ischart)?>" method="post">
<div class="box-header with-border">
    <h3 class="box-title">Collaboratore (professori)</h3>
    <div class="box-tools pull-right">
        <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button" data-original-title="Collapse" data-container="body">
            <i class="fa fa-minus"></i></button>
        <!--            <button title="Remove" data-toggle="tooltip" data-widget="remove" class="btn btn-box-tool" type="button">
                        <i class="fa fa-times"></i></button>-->
    </div>
</div>
<!-- /.box-header -->
<!-- /.box-body -->
<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
        <!-- DIRECT SEARCH PRIMARY -->
        <div class="">
        <!-- /.box-header -->
        <!-- /.box-body -->
        <div class="box-body">
            <div class="form-group">
                <label for="selCollaboratoreMacroRegione">Collaboratore macro regione<span class="error">*</span></label>
                <div class="form-data">
                    <select class="form-control" autocomplete="off" id="selCollaboratoreMacroRegione" name="selCollaboratoreMacroRegione[]" multiple="multiple">
                            <?php
                                if ($collaboratoreProfessori) {
                                    foreach ($collaboratoreProfessori as $data) {
                                        ?>
                                            <option value="<?php echo $data['collaboratoreMacroRegione']; ?>"><?php echo $data['collaboratoreMacroRegione']; ?></option>
                                        <?php
                                    }
                                }
                            ?>
                    </select>
                </div>
            </div>
           
        </div>
        <!-- /.box-footer-->
        </div>
        <!--/.direct-chat -->
    </div>
    <div class="col-sm-8">
        <!-- DIRECT SEARCH PRIMARY -->
        <div class="">
        <!-- /.box-header -->
        <!-- /.box-body -->
        <div class="box-body">
            <div class="form-group">
                <label >Anno<span class="error">*</span></label>
                <div class="form-data row">
                    <?php 
                    $firstRecord = true;
                    foreach($anno as $ddyear){
                        ?>
                        <div class="col-xs-4 col-md-4 col-lg-4">
                            <input type="checkbox" autocomplete="off" class="chAnno <?php echo ($firstRecord ? "currentYear" : 'otherYears');?> " id="chk_<?php echo $ddyear['anno']; ?>" name="anno[]" value="<?php echo $ddyear['anno']; ?>"> 
                            <label class="normal chAnno-label" for="chk_<?php echo $ddyear['anno']; ?>"><?php echo $ddyear['anno']; ?></label>
                        </div>
                        <?php 
                        $firstRecord = false;
                    }?>
                </div>
            </div>
        </div>
        <!-- /.box-footer-->
        </div>
        <!--/.direct-chat -->
    </div>
    </div>
    <div class="row">
    <div class="col-sm-4">
        <!-- DIRECT SEARCH PRIMARY -->
        <div class="">
        <!-- /.box-header -->
        <!-- /.box-body -->
        <div class="box-body">
            <div class="form-group">
                <label for="selTiplogiaProdotto">Tipologia prodotto<span class="error">*</span></label>
                <div class="form-data">
                    <select class="form-control" autocomplete="off" id="selTiplogiaProdotto" name="selTiplogiaProdotto[]" multiple="multiple">
                            <?php
                                if ($tipologiaProdotto) {
                                    foreach ($tipologiaProdotto as $data) {
                                        ?>
                                            <option value="<?php echo $data['tipologia_prodotto']; ?>"><?php echo $data['tipologia_prodotto']; ?></option>
                                        <?php
                                    }
                                }
                            ?>
                    </select>
                </div>
            </div>
        </div>
        <!-- /.box-footer-->
        </div>
        <!--/.direct-chat -->
    </div>
    <div class="col-sm-4">
        <!-- DIRECT SEARCH PRIMARY -->
        <div class="">
        <!-- /.box-header -->
        <!-- /.box-body -->
        <div class="box-body">
            <div class="form-group">
                <label for="selDestinazioneNazione">Destinazione nazione</label>
                <div class="form-data">
                    <select class="form-control" autocomplete="off" id="selDestinazioneNazione" name="selDestinazioneNazione[]" multiple="multiple">
                            <?php
                                if ($destinazioneNazione) {
                                    foreach ($destinazioneNazione as $data) {
                                        ?>
                                            <option value="<?php echo $data['destinazione_nazione']; ?>"><?php echo $data['destinazione_nazione']; ?></option>
                                        <?php
                                    }
                                }
                            ?>
                    </select>
                </div>
            </div>
        </div>
        <!-- /.box-footer-->
        </div>
        <!--/.direct-chat -->
    </div>
    </div>
</div>
<div class="box-footer">
    <input type="hidden" name="hiddCollaboratoreType" value="professori" />
    <input class="btn btn-primary pull-right" id="btnReportPro" type="submit" value="Report">
</div>
</form>
</div>
<script src="<?php echo LTE; ?>plugins/select2/select2.full.min.js"></script>
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<link href="<?php echo LTE; ?>plugins/iCheck/all.css" rel="stylesheet">
<script>
    $(document).ready(function() {
        iCheckInit();
        $('#selCollaboratoreMacroRegione').select2({
            dropdownAutoWidth : true,
            width: '100%'
        });
        $('#selTiplogiaProdotto').select2({
            dropdownAutoWidth : true,
            width: '100%'
        });
        $('#selDestinazioneNazione').select2({
            dropdownAutoWidth : true,
            width: '100%'
        });
        
        $('input:checkbox.currentYear').on('ifUnchecked', function(event){
           setTimeout(function(){$('input:checkbox.currentYear').iCheck('check'); }, 200);
        });
        
/* temporory not required. */
//        $( "#selCollaboratoreMacroRegione" ).change(function() {
//            console.log($(this).val());
//            var collaboratore = $(this).val();
//            $.post("<?php //echo base_url();?>index.php/sthistory/gettipologia",{'collaboratore':collaboratore},function(data){
//                
//            });
//        });
        
    });
    function iCheckInit(){
        $('.chAnno').iCheck('destroy'); 
        $('.chAnno').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            increaseArea: '10%' // optional
        });
        $('input:checkbox.currentYear').iCheck('check');
    }
    function validateForm(myFormId){
        if(myFormId == "frmCollaboratorPro"){
            var atLeastOneIsChecked = $('input:checkbox.otherYears').is(':checked');
            
            if($("#selCollaboratoreMacroRegione").val() == null ||  $('#selTiplogiaProdotto').val() == null || atLeastOneIsChecked == false){
                swal("Error","Please select collaboratore macro regione, Tipologia prodotto and at least one other than current year(anno).");
                return false;
            }
            else{
                return true;
            }
        }
        return false;
    }
</script>
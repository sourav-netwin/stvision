<div class="box box-primary">
<form id="frmCollaboratorPro" onsubmit="return validateForm('frmCollaboratorPro');" action="<?php echo base_url(); ?>index.php/sthistory/compareprofessori" method="post">
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
                <label for="selCollaboratorePro">Collaboratore</label>
                <div class="form-data">
                    <select class="form-control" autocomplete="off" id="selCollaboratorePro" name="selCollaboratorePro[]" multiple="multiple">
                            <?php
                                if ($collaboratoreProfessori) {
                                    foreach ($collaboratoreProfessori as $data) {
                                        ?>
                                        <option value="<?php echo $data['collaboratore']; ?>"><?php echo $data['collaboratore']; ?></option>
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
        <div class="box-body row">
            <div class="form-group">
                <label >Anno</label>
                <div class="form-data">
                    <?php foreach($anno as $ddyear){
                        ?>
                        <div class="col-xs-4 col-md-4 col-lg-4">
                            <input type="checkbox" autocomplete="off" class="chAnno" id="chk_<?php echo $ddyear['anno']; ?>" name="anno[]" value="<?php echo $ddyear['anno']; ?>"> 
                            <label class="normal chAnno-label" for="chk_<?php echo $ddyear['anno']; ?>"><?php echo $ddyear['anno']; ?></label>
                        </div>
                        <?php 
                    }?>
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
        $('#selCollaboratorePro').select2({
            dropdownAutoWidth : true,
            width: '100%'
        });
    });
    function iCheckInit(){
        $('.chAnno').iCheck('destroy'); 
        $('.chAnno').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            increaseArea: '10%' // optional
        });
    }
    function validateForm(myFormId){
        if(myFormId == "frmCollaboratorPro"){
            if($("#selCollaboratorePro").val() == null || $("#selCollaboratorePro").val() == ""){
                swal("Error","Please select collaboratore");
                return false;
            }
            else{
                return true;
            }
        }
        return false;
    }
</script>
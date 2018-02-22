<div class="box box-primary">
<form id="frmCollaboratoreCor"  onsubmit="return validateForm('frmCollaboratoreCor');" action="<?php echo base_url(); ?>index.php/sthistory/collaboratorepax" method="post">
<div class="box-header with-border">
    <h3 class="box-title">Azienda (corporate)</h3>
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
                <label for="txtCollaboratore">Azienda</label>
                <div class="form-data">
                    <select class="form-control" id="selCollaboratoreCor" name="txtCollaboratore">
                        <option value="">Select</option>
                            <?php
                                if ($collaboratoreCorporate) {
                                    foreach ($collaboratoreCorporate as $data) {
                                        ?>
                                            <option value="<?php echo htmlspecialchars($data['azienda']); ?>"><?php echo htmlspecialchars($data['azienda']); ?></option>
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
    <input type="hidden" name="hiddCollaboratoreType" value="corporate"/>
    <input class="btn btn-primary pull-right" id="btnReportCor" type="submit" value="Report">
</div>
</form>
</div>
<div class="box box-primary">
<form id="frmCollaboratorPro" onsubmit="return validateForm('frmCollaboratorPro');" action="<?php echo base_url(); ?>index.php/sthistory/collaboratorepax" method="post">
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
                <label for="txtCollaboratore">Collaboratore</label>
                <div class="form-data">
                    <select class="form-control" id="selCollaboratorePro" name="txtCollaboratore">
                        <option value="">Select</option>
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
        
    </div>
</div>
<div class="box-footer">
    <input type="hidden" name="hiddCollaboratoreType" value="professori" />
    <input class="btn btn-primary pull-right" id="btnReportPro" type="submit" value="Report">
</div>
</form>
</div>
<script>
    $(document).ready(function() {
        
    });
    function validateForm(myFormId){
        if(myFormId == "frmCollaboratoreCor"){
            if($("#selCollaboratoreCor").val() == ""){
                swal("Error","Please select azienda");
                return false;
            }
            else{
                return true;
            }
        }
        else if(myFormId == "frmCollaboratorPro"){
            if($("#selCollaboratorePro").val() == ""){
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
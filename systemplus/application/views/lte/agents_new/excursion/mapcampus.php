<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<link href="<?php echo base_url();?>css/external/jquery-ui-1.8.21.custom.css" rel="stylesheet">  
<section class="">
    <div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Select type</h3>
            </div>
            <div class="box-body selectTypeRadio">
                <label class="mr-right-15"><input <?php echo ($excType == 'exc' ? 'checked' : '');?> class="changeType" type="radio" id="radExcursion" name="excType" value="excursion" /> Excursions</label>
                <label><input <?php echo ($excType == 'tra' ? 'checked' : '');?> class="changeType" type="radio" id="radTransfer" name="excType" value="transfer" /> Transfers</label>
            </div>
        </div>  
        <div class="box" >
            <div class="box-header with-border">
                <h3 class="box-title">Select details</h3>
            </div>
            <div class="box-body">
                <form method="post" class="validate" id="frmMapExcursion" action="">
                    <div class="row form-group">
                        <label for="selCampus" class="col-sm-2">
                            <strong>Campus</strong>
                        </label>
                        <div class="col-sm-4">
                            <select class="required form-control" id="selCampus" name="selCampus"  required>
                                <option value="">Select campus</option>
                                <?php
                                if (!empty($campuses)) {
                                    foreach ($campuses as $campus) {
                                        ?>
                                        <option <?php echo ($formData['selCampus'] == $campus['id'] ? "selected='selected'" : ''); ?> value="<?php echo $campus['id'] ?>"><?php echo $campus['nome_centri'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <div class="frm-error"><?php echo form_error('selCampus'); ?></div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="selExcursion"  class="col-sm-2">
                            <strong><?php echo ($excType == 'exc' ? 'Excursions' : 'Transfers'); ?></strong>
                        </label>
                        <div class="col-sm-10">
                            <select multiple class="required width-full" id="selExcursion" name="selExcursion[]"  required>
                                <?php 
                                if($all_exc_or_transfer){
                                    foreach($all_exc_or_transfer as $excTransfer){
                                        ?><option <?php echo (in_array($excTransfer['exc_id'], $mapExcursionsIds) ? "selected='selected'" : ''); ?> value="<?php echo $excTransfer['exc_id'];?>"><?php echo $excTransfer['exc_excursion_name'];?></option><?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-offset-2 col-sm-10">
                                <!--<input type="hidden" id="edit_id" name="edit_id" value="<?php echo $edit_id; ?>" />-->
                            <input class="btn btn-primary" type="submit" id="btnMap" name="btnMap" value="Map" />
                            <input class="btn btn-danger" type="reset" id="btnCancel" name="btnCancel" value="Cancel" />
                        </div>
                    </div>
                </form>
            </div><!-- End of .content -->
        </div><!-- End of .box -->
      <div class="box">
        <div class="box-header col-sm-12">
            <div class="row">
                <div class="col-sm-6 btn-create">
                </div>
                <?php showSessionMessageIfAny($this);?>
            </div>
        </div>
        <div class="box-body">
            <table id="dataTableCampusExcursions" class="datatable table table-bordered table-striped" style="width: 98.98%;">
                <thead>
                    <tr>
                        <th>Campus</th>
                        <th><?php echo ($excType == 'exc' ? 'Excursions' : 'Transfers');?></th>								
                        <th class="no-sort">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                if($all_campuses)
                foreach($all_campuses as $campus){
                ?>
                    <tr>
                        <td style="width:10%;" class="center">
                        <?php echo html_entity_decode($campus["nome_centri"]);?>
                            <div id="myModal_<?php echo $campus["campus_id"]?>" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Campus - <?php echo htmlspecialchars($campus["nome_centri"]);?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong><?php echo ($excType == 'exc' ? 'Excursions' : 'Transfers');?>: </strong><?php echo print_tags($campus["exc_excursion_name"], 1,$campus);?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td style="width:80%;" class="center"><?php echo print_tags($campus["exc_excursion_name"]);?></td>
                        <td style="width:10%;" class="text-center">
                            <div class="btn-group">
                                <a href="#" data-toggle="modal" data-target="#myModal_<?php echo $campus["campus_id"];?>" class="min-wd-24 dialogbtn btn btn-xs btn-primary" ><span data-original-title="View" data-container="body" data-toggle="tooltip"><i class="fa fa-eye"></i></span></a>
                                <a href="<?php echo base_url().'index.php/excursion/mapcampus/'.$excType.'/'.$campus["campus_id"];?>" data-toggle="tooltip" class="btn btn-xs btn-info min-wd-24" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                            </div>
                        </td>
                    </tr>
                <?php
                        }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>Campus</th>
                    <th><?php echo ($excType == 'exc' ? 'Excursion' : 'Transfer');?></th>								
                    <th>Action</th>
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
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script src="<?php echo LTE; ?>plugins/select2/select2.full.min.js"></script>
<style>
    .selectTypeRadio input, .selectTypeRadio label{
        cursor: pointer;
    }
</style>
<script>
    var pageHighlightMenu = "excursion/mapcampus";
    $(document).ready(function() {
        $( "body" ).on( "change", "[name='excType']", function() {
           var excType = $(this).val();
           if(excType == "transfer")
               window.location.href = "<?php echo base_url().'index.php/excursion/mapcampus/tra'?>";
           else
               window.location.href = "<?php echo base_url().'index.php/excursion/mapcampus/exc'?>";
        });
        
        $("#frmMapExcursion").validate({
                //errorElement:"div",
                ignore: [],
                rules: {
                        selCampus: {
                                required: true
                        },
                        selExcursion: {
                                required: true
                        }
                },
                messages: {
                        selCampus: "Please select campus",
                        'selExcursion[]': "Please select atleast one <?php echo ($excType == 'exc' ? 'excursion' : 'transfer');?>"
                },
                submitHandler: function(form) {
                        form.submit();
                },
                errorPlacement: function(error, element) {
                        if (element.attr("name") == "selExcursion[]") {
                                error.insertAfter(".select2-container");
                        }else{
                                error.insertAfter(element);
                        }
                }
        });
        $('#selExcursion').select2({
                dropdownAutoWidth : true,
                width: '100%'
        });
        
        $( "body" ).on( "click", "#btnCancel", function() {
            var excType = $("[name='excType']:checked").val();
            if(excType == "transfer")
                window.location.href = "<?php echo base_url().'index.php/excursion/mapcampus/tra'?>";
            else
                window.location.href = "<?php echo base_url().'index.php/excursion/mapcampus/exc'?>";
        });
        
        $( "body" ).on( "change", "#selCampus", function() {
            var cmpId = $(this).val();
            var excType = $("[name='excType']:checked").val();
            if(excType == "transfer")
                window.location.href = "<?php echo base_url().'index.php/excursion/mapcampus/tra/';?>" + cmpId;
            else
                window.location.href = "<?php echo base_url().'index.php/excursion/mapcampus/exc/';?>" + cmpId;
        });
    });
</script>
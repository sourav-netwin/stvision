<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<link href="<?php echo base_url(); ?>css/external/jquery-ui-1.8.21.custom.css" rel="stylesheet">  
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header col-sm-12">
                <div class="row">
                    <div class="col-sm-6 btn-create">
                    </div>
                    <?php showSessionMessageIfAny($this); ?>
                </div>
            </div>
            <div class="box-body">
                <table id="dataTableEmailTemplate" class="datatable table table-bordered table-striped" style="width: 99.98%;">
                    <thead>
                        <tr>
                            <th>Seq.</th>
                            <th>Email title</th>
                            <th>From email</th>
                            <th>To email</th>
                            <th>To type</th>
                            <th class="no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        if ($allEmailTemplate)
                            foreach ($allEmailTemplate as $aSingleRow) {
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td ><?php echo (empty($aSingleRow['emt_title'])) ? "-" : $aSingleRow['emt_title']; ?></td>
                                    <td ><?php echo (empty($aSingleRow['emt_from_email'])) ? "-" : $aSingleRow['emt_from_email']; ?></td>
                                    <td ><?php echo (empty($aSingleRow['emt_to']) == 2) ? "-" : $aSingleRow['emt_to_email']; ?></td>                               
                                    <td ><?php echo (($aSingleRow['emt_to']) == 1) ? "Admin" : "User"; ?></td>                                
                                    <td>
                                        <div class="btn-group">
                                            <a href="javascript:void(0);" data-emt-id="<?php echo $aSingleRow["emt_id"]?>" data-title="<?php echo (empty($aSingleRow['emt_title'])) ? "-" : $aSingleRow['emt_title']; ?>" class="min-wd-24 dialogbtn btn btn-xs btn-primary" >
                                                <span data-original-title="Preview" data-container="body" data-toggle="tooltip">
                                                    <i class="fa fa-eye"></i>
                                                </span>
                                            </a>
                                            <a href="<?php echo base_url() . 'index.php/emailtemplate/addedit/' . $aSingleRow['emt_id']; ?>" data-toggle="tooltip" class="btn btn-xs btn-info min-wd-24" data-original-title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Seq.</th>
                            <th>Email title</th>
                            <th>From email</th>
                            <th>To email</th>
                            <th>To type</th>
                            <th class="no-sort">Action</th>
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
    
<div id="dialog_modal_template_preview" data-backdrop="static" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span id="spnName">Email template</span>
                    <button aria-label="Close" onclick="$('#dialog_modal_template_preview').modal('hide');$('body').addClass('modal-open')" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div id="previewData" class="modal-body">
            </div>
            <div class="modal-footer">
                <button  onclick="$('#dialog_modal_template_preview').modal('hide');$('body').addClass('modal-open')"  class="btn btn-default pull-left" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</div>
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $("body").on("click",".dialogbtn",function(){
            var emt_id = $(this).attr('data-emt-id');
            var emt_title = $(this).attr('data-title');
            $("#spnName").html(emt_title);
            $("#dialog_modal_template_preview").modal('show');
            $.post( "<?php echo base_url();?>index.php/emailtemplate/genratepreview",{'emt_id':emt_id}, function( data ) {
                $( "#previewData" ).html(data);
            });
        });
        
        $('#dialog_modal_template_preview').on('hidden.bs.modal', function () {
            setTimeout(function(){$('body').removeClass("modal-open");},500);
        });
    });
</script>
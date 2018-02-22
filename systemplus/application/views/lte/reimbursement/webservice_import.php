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
            <form method="post" action="<?php echo base_url(); ?>index.php/webservice/import">
            <div class="form-data webservice-import">
                <input class="btn btn-primary" type="submit" id="btnSave" name="btnSave" value="Import" />
                <input class="btn btn-primary" type="reset" id="btnCancel" name="btnCancel" value="Cancel" onclick="window.location.href='<?php echo base_url();?>index.php/webservice/index'" />
            </div>
            </form>
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
<script>
    var SITE_PATH = "<?php echo base_url(); ?>index.php/";
    $(document).ready(function() {
        $("#btnSave").click(function(){
            loading();
        });
    });
</script>
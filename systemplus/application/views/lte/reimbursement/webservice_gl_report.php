<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<div class="row">
    <div class="col-xs-12">
        <form class="webservice-report-form" id="frmWebserviceGlReport" onsubmit="return validate();" action="<?php echo base_url(); ?>index.php/webservice/glReport" method="post">
        <div class="box">
            <div class="box-header with-border col-sm-12 mr-bot-10">
                <h3 class="box-title">Select options</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <?php showSessionMessageIfAny($this);?>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-4 col-xs-6  ">
                        <label class="normal" for="txtCollaboratore">Collaboratore</label>
                        <select class="form-control" id="txtCollaboratore" name="txtCollaboratore">
                        <option value="">Select collaboratore</option>
                        <?php
                        if( $collaboratore )
                        {
                            foreach ( $collaboratore as $data )
                            {
                        ?>
                            <option value="<?php echo trim($data['collaboratore']);?>"><?php echo trim($data['collaboratore']);?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6  ">
                        <label class="normal" for="txtAccompagnatore">Accompagnatore</label>
                        <select class="form-control" id="txtAccompagnatore" name="txtAccompagnatore">
                            <option value="">Select accompagnatore</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="pull-right">
                    <input id="btnReport" type="submit" value="Report" class="btn btn-primary">
                </div>
            </div>
            <!-- /.box-footer-->
        </div>
        </form>
      </div>
    </div>
<script>
    var SITE_PATH = "<?php echo base_url(); ?>index.php/";
    $(document).ready(function() {
        $( "body" ).on( "change", "#txtCollaboratore", function() {
            var txtCollaboratore = $(this).val();
            $.post( SITE_PATH + "webservice/getAccompagnatore",{'txtCollaboratore':txtCollaboratore}, function( data ) {
                $("#txtAccompagnatore").html(data);
                $("#txtAccompagnatore").trigger("liszt:updated");
            });
        });
    });
    
    function validate(){
        var txtAccompagnatore = $("#txtAccompagnatore").val();
        var txtCollaboratore = $("#txtCollaboratore").val();

        if( txtAccompagnatore != '' && txtCollaboratore != '') {
            return true;
        } else {
            swal("Error","Please select collaboratore and accompagnatore to search");
            return false;
        }
    }
</script>
<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<link href="<?php echo base_url(); ?>css/added.css" rel="stylesheet">  
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border col-sm-12  mr-bot-10">
                <h4 class="box-title">Invoice history</h4>
                <div class="box-tools pull-right">
                    <!-- top right links -->
                </div>
            </div>
            <div class="box-body">
                <div class="row mr-bot-10">
                    <?php showSessionMessageIfAny($this); ?>
                </div>
                <div class="row mr-bot-10">
                    <div class="col-sm-3">
                        <label class="control-label" for="selCampus">Campus</label>
                        <select class="form-control" autocomplete="off" id="selCampus" name="selCampus"  >
                            <option value="">Select Campus</option>
                            <?php
                            if ($campusList) {
                                foreach ($campusList as $campus) {
                                    ?><option <?php echo ($campusId == $campus['id'] ? "selected='selected'" : "");?> value="<?php echo $campus['id']; ?>"><?php echo $campus['nome_centri'];?></option><?php
                                    }
                                }
                            ?>
                        </select>
                        <div class="error"><?php echo form_error('selCampus'); ?></div>
                    </div>
                    
                    <div class="col-sm-2">
                        <label class="control-label" for="txtBookingId">Booking Id</label>
                        <input class="form-control" type="text" id="txtBookingId" name="txtBookingId" value="<?php echo (!empty($bookingId) ? $bookingId : '');?>" />
                    </div>
                    <div class="col-sm-3">
                        <label class="control-label" for="txtBookingId">Agent</label>
                        <input class="form-control" type="text" id="txtAgentName" name="txtAgentName" value="<?php echo (!empty($agentName) ? $agentName : '');?>" />
                    </div>
                    <div class="col-sm-3">
                        <label class="control-label">&nbsp;</label>
                        <div >
                            <input class="btn btn-primary mr-right-15" value="Show" id="btnShow" type="button">
                            <input class="btn btn-danger" value="Clear" id="btnClear" type="button">
                        </div>
                        
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                        <table id="invoiceGrid" class="table table-bordered table-striped" style="width: 99.98%;"> 
                            <thead>
                                <tr>
                                    <th style="width:15px">Campus</th>
                                    <th style="width:70px">Booking id</th>
                                    <th>Agent</th>								
                                    <th style="width:20px">Date</th>								
                                    <th style="width:10px">Weeks</th>
                                    <th>Package</th>
                                    <th style="width:15px">Pax</th>
                                    <th style="width:80px;text-align:right;">Net amount</th>
                                    <th style="width:80px;text-align: center">Pdf file</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- ajax data -->
                            </tbody>
                        </table>
                    </div>
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
<style>
    .cCenter{
        text-align: center;
    }
    .cRight{
        text-align: right;
    }
</style>
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    var SITE_PATH = "<?php echo base_url() ?>index.php/";
    $(document).ready(function() {
        $( "body" ).on( "click", "#btnClear", function() {
            $('#selCampus').val('');
            $('#txtBookingId').val('');
            $('#txtAgentName').val('');
           dataReload();
        });
        $( "body" ).on( "click", "#btnShow", function() {
           dataReload();
        });
         dataReload();
    });
    var table;
    function dataReload(){
        if(typeof table != 'undefined')
            table.destroy();
         table = $('#invoiceGrid').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax": {
                "type": 'GET',
                "url": SITE_PATH + "bookinginvoice/invoice_ajax",
                data: {
                    'campus': $('#selCampus').val(),
                    'bookingId': $('#txtBookingId').val(),
                    'agentName': $("#txtAgentName").val()
                }
            },
            "columns": [
                {"data": "nome_centri", "name": "nome_centri"},
                {"data": "inv_booking_id", "name": "inv_booking_id"},
                {"data": "agentname", "name": "agentname"},
                {"data": "inv_date", "name": "inv_date"},
                {"data": "inv_number_of_week", "name": "inv_number_of_week"},
                {"data": "pack_package", "name": "pack_package"},
                {"data": "inv_number_of_pax", "name": "inv_number_of_pax"},
                {"data": "inv_total_cost", "name": "inv_total_cost","sClass":"cRight"},
                {"data": "inv_pdf_file", "name": "inv_pdf_file","orderable":false,'sClass':'cCenter'}
            ]
        });
    }
</script>
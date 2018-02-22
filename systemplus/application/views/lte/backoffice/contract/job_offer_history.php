<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<?php $pageType = $this->uri->segment(2);?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
        <div class="box">
            <div class="box-header col-sm-12">
                <div class="row">
                    <?php showSessionMessageIfAny($this);?>
                </div>
            </div>
            <div class="box-body">
                <div class="mr-bot-10">
                    <form action="<?php echo base_url() . 'index.php/jobofferhistory/exporthistory'; ?>" method="post">
                        <div class="row" >
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <label for="txtName" >
                                    <strong>Name</strong>
                                </label>
                                <input class="form-control" maxlength="100" type="text" id="txtName" name="txtName" value="" />
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <label for="selPosition" >
                                    <strong>Position</strong>
                                </label>
                            
                                <select class="form-control" id="selPosition" name="selPosition"  >
                                    <option value="0">Select Position</option>
                                    <?php
                                    if (!empty($positiondetails)) {
                                        foreach ($positiondetails as $value) {
                                            ?>
                                            <option value="<?php echo $value['pos_id'] ?>"><?php echo $value['pos_position'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <label for="selSex" >
                                    <strong>Gender</strong>
                                </label>
                            
                                <select class="form-control" id="selSex" name="selSex"  >
                                    <option value="">All</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <label for="selCurrency" >
                                    <strong>Currency</strong>
                                </label>
                            
                                <select class="form-control" id="selCurrency" name="selCurrency" >
                                    <option value="">Select Currency</option>
                                    <option value="GBP">GBP</option>
                                    <option value="EUR">EUR</option>
                                    <option value="USD">USD</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <label for="selType" >
                                    <strong>Type</strong>
                                </label>
                           
                                <select class="form-control" id="selType" name="selType" >
                                    <option value="">Select Type</option>
                                    <option value="London">London</option>
                                    <option value="Non London">Non London</option>
                                    <option value="Academy 1">Academy 1</option>
                                    <option value="Academy 2">Academy 2</option>
                                </select>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <label for="selRate" >
                                    <strong>Rate</strong>
                                </label>
                            
                                <select class="form-control" id="selRate" name="selRate" >
                                    <option value="">Select Rate</option>
                                    <?php
                                    for ($rateInx = 13; $rateInx <= 28; $rateInx++) {
                                        ?>
                                        <option value="<?php echo $rateInx; ?>"><?php echo $rateInx; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        
                            <div class="col-sm-6 col-md-6 col-lg-3" >
                                <label for="txtCalFromDate" >
                                    <strong>Offer date from</strong>
                                </label>
                                <input autocomplete="off" class="form-control" type="text" id="txtCalFromDate" name="fd" value="<?php echo '01/01/' . date('Y');?>" />
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3" >
                                <label for="txtCalToDate" >
                                    <strong>Offer date to</strong>
                                </label>
                                <input autocomplete="off" class="form-control" type="text" id="txtCalToDate" name="td" value="<?php echo date('d/m/Y');?>" /> 
                            </div>
                            <div class="form-data col-sm-12 mr-top-10">
                                <input class="btn btn-primary" id="btnSearchApplication" type="button" value="Search" >
                                <input class="btn btn-danger" id="btnClear" type="reset" value="Clear" >
                                <small>(By default records are loaded only for current year - <?php echo date('Y');?>)</small>
                                <input class="btn btn-primary pull-right" id="btnExport" type="submit" value="Export" >
                            </div>
                        </div>
                    </form>
                </div>
            
                <hr />
                <div class="row">
                    <div class="col-sm-12">
                        <table class="datatable table table-bordered table-striped vertical-middle" width="99.9%" >
                            <thead>
                                <tr>
                                    <th>Applicant name</th>
                                    <th>Position</th>
                                    <th>Type</th>								
                                    <th>Offer letter</th>
                                    <th>Offer date</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (is_array($historydetails)) {
                                    foreach ($historydetails as $value) {
                                        ?>
                                        <tr>
                                            <td><?php echo $value['ta_firstname'] . ' ' . $value['ta_lastname'] ?>
                                                <div id="dialog_modal_<?php echo $value['jof_id'] ?>" class="modal">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button aria-label="Close" onclick="$('#dialog_modal_<?php echo $value['jof_id'] ?>').modal('hide');"  class="close" type="button">
                                                            <span aria-hidden="true">×</span></button>
                                                            <h4 class="modal-title">Job History - <?php echo htmlspecialchars($value['ta_firstname'] . ' ' . $value['ta_lastname']) ?></h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="detailContainer">
                                                                <div class="row">
                                                                    <div class="col-sm-3"><strong>Applicant name:</strong></div>
                                                                    <div class="col-sm-3"><?php echo html_entity_decode($value['ta_firstname'] . ' ' . $value['ta_lastname']); ?></div>
                                                                                        
                                                                    <div class="col-sm-3"><strong>Position:</strong></div>
                                                                    <div class="col-sm-3"><?php echo $value['pos_position']; ?></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-3"><strong>Type:</strong></div>
                                                                    <div class="col-sm-3"><?php echo $value['jof_teacher_type']; ?></div>
                                                                                        
                                                                    <div class="col-sm-3"><strong>Currency:</strong></div>
                                                                    <div class="col-sm-3"><?php echo $value['jof_currency']; ?></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-3"><strong>Rate:</strong></div>
                                                                    <div class="col-sm-3"><?php echo $value['jof_rates']; ?></div>
                                                                                        
                                                                    <div class="col-sm-3"><strong>Wage:</strong></div>
                                                                    <div class="col-sm-3"><?php echo $value['jof_wages']; ?></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-3"><strong>Offer letter:</strong></div>
                                                                    <div class="col-sm-9 hlt-link"><?php echo $value['job_offer_file'] ? '<a class="underline" target="_blank" href="' . base_url() . SENT_JOB_OFFER_PATH . $value['job_offer_file'] . '">' . $value['job_offer_file'] . '</a>' : '' ?></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-3"><strong>Offer date:</strong></div>
                                                                    <div class="col-sm-9"><?php echo date('d/m/Y', strtotime($value['jof_created_on'])) ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Teachers detail</h4>
                                                        </div>
                                                        <div class="modal-body detailContainer">
                                                            <div id="teacherDetail_<?php echo $value['jof_id'] ?>"></div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </td>
                                            <td><?php echo $value['pos_position'] ?></td>
                                            <td><?php echo $value['jof_teacher_type'] ?></td>
                                            <td class="hlt-link"><?php echo $value['job_offer_file'] ? '<a target="_blank" href="' . base_url() . SENT_JOB_OFFER_PATH . $value['job_offer_file'] . '">' . $value['job_offer_file'] . '</a>' : '' ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($value['jof_created_on'])); ?></td>
                                            <td class="center operation">
                                                <a title="View" data-toggle="tooltip" href="javascript:void(0);" data-ta-id="<?php echo $value["jof_teacher_app_id"]; ?>" data-track-id="<?php echo $value['jof_id'] ?>" data-id="dialog_modal_btn_<?php echo $value['jof_id'] ?>" class="getappdetail dialogbtn btn btn-xs btn-primary">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a title="Add to contract" data-toggle="tooltip" href="<?php echo base_url(); ?>index.php/contract/addedit/contract/<?php echo $value['jof_teacher_app_id'] ?>" data-id="<?php echo $value['jof_teacher_app_id'] ?>" class="btn btn-xs btn-warning">
                                                    <i class="fa fa-copy"> Contract</i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
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
</section>

<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo LTE; ?>plugins/select2/select2.full.min.js"></script>
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<link href="<?php echo LTE; ?>plugins/iCheck/all.css" rel="stylesheet">
<script>
    function iCheckInit(){
        $('[type=checkbox]').iCheck('destroy'); 
        $('[type=checkbox]').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '10%' // optional
        });
    }
    $(document).ready(function() {
        $(document).on('click', ".dialogbtn", function() {
                var iddia = $(this).attr("data-id").replace('_btn','');
                $("#"+iddia).modal('show');
                return false;
        });

        $( "#txtCalFromDate" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                changeYear: true,		  
                dateFormat: "dd/mm/yy",		
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                        $( "#txtCalToDate" ).datepicker( "option", "minDate", selectedDate );
                }
        });

        $( "#txtCalToDate" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                changeYear: true,		  
                dateFormat: "dd/mm/yy",		
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                        $( "#txtCalFromDate" ).datepicker( "option", "maxDate", selectedDate );
                }
        });
    $("#btnClear").click(function(){
        //window.location.href = "<?php //echo base_url().'index.php/teachers/review';?>";
        setTimeout(function(){$("#btnSearchApplication").trigger('click');;},'500');

    });

    $( "body" ).on( "click", ".getappdetail", function() {
        var ta_id = $(this).attr('data-ta-id');
        var id = $(this).attr('data-track-id');
        $.post( "<?php echo base_url();?>index.php/teachers/applicationdetail",{
                'id':ta_id
            }, function( data ) {
                $("#teacherDetail_"+id).html(data);
        });
    });

});
$( "body" ).on( "click", "#btnSearchApplication", function() {
        var txtName = $('#txtName').val();
        var position = $('#selPosition').val();
        var sex = $('#selSex').val();
        var currency = $('#selCurrency').val();
        var type = $('#selType').val();
        var rate = $('#selRate').val();
        var txtCalFromDate = $('#txtCalFromDate').val();
        var txtCalToDate = $('#txtCalToDate').val();

        $.post( "<?php echo base_url(); ?>index.php/jobofferhistory/searchAjax",{
                'txtName':txtName,
                'position':position,
                'sex':sex,
                'currency':currency,
                'type':type,
                'rate':rate,
                'txtCalFromDate':txtCalFromDate,
                'txtCalToDate':txtCalToDate
        }, function( data ) {
//                var oTable = $('table.dynamic').dataTable();
//                var ott = TableTools.fnGetInstance('tableSearchResults');
//                if ( typeof ott != 'undefinded' && ott != null) ott.fnSelectNone();
//				oTable.fnClearTable();
//				//oTable.fnDestroy();
//				oTable.fnAddData(data);
//				oTable.fnDraw();
                oTable.clear();
                oTable.rows.add(data);
                oTable.draw();
                $("table.datatable tr td:last-child").addClass('center operation');
                //$("table.dynamic tr td:last-child").addClass('operation');
        },'json');
});
</script>
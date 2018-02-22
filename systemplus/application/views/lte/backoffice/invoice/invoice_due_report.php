<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
    <div class="row">
        <div class="col-md-12">
            <?php showSessionMessageIfAny($this); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?php echo $pageHeader;?> for date: <?php echo date("d/m/Y",strtotime($calFromDate))," - ".date("d/m/Y",strtotime($calToDate));?></h3>
                    <div class="pull-right">
                        <form id="frmExport" action="<?php echo base_url().'index.php/invoice/dueoverdueexport'?>" method="post" >
                            <input type="hidden" id="hiddReportType" name="hiddReportType" value="<?php echo $reportType; ?>" />
                            <input class="btn btn-primary pull-right" id="btnExport" value="Export" type="submit">
                        </form>
                    </div>
                </div>
                <div class="box-body scrollx">
                    <table class="table table-hovered table-bordered table-striped" id="reportTable">
                        <thead>
                            <tr>
                                <th>Arrival date</th>
                                <th>Invoices total</th>
                                <th>Cashed total</th>
                                <th>Overdue total</th>
                                <th>Day's</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $existingCurrency = "";
                            if (!empty($reportData)) {
                                    foreach ($reportData as $report) { 
                                        $areaCode = $report['valuta_fattura'];
                                        if($existingCurrency != $areaCode)
                                        {
                                            $existingCurrency = $areaCode;
                                            ?>
                                            <tr>
                                                <th colspan="5">
                                                    Area <?php echo getCurrencyArea($existingCurrency);?>
                                                </th>
                                            </tr>
                                            <?php 
                                        }
                            ?>
                                    <tr>
                                        <td>
                                            <a href="javascript:void(0);" class="bookingReport" data-toggle="tooltip" data-date-mysql="<?php echo $report['arrival_date'];?>" data-date="<?php echo date("d/m/Y",strtotime($report['arrival_date']));?>" data-book-ids="<?php echo $report['gr_bookings'];?>" title="Click here to show detailed debt report of - <?php echo date("d/m/Y",strtotime($report['arrival_date']));?>">
                                                <?php echo date("d/m/Y",strtotime($report['arrival_date']));?>
                                            </a>
                                        </td>
                                        <td><?php echo customNumFormat($report['total_cost']);?></td>
                                        <td><?php echo customNumFormat($report["pfp_import"]);?></td>
                                        <td><?php echo customNumFormat($report["overdue"]);?></td>
                                        <td>
                                        <?php 
                                            $dateFrom = date_create($report['arrival_date']);
                                            $dateTo = date_create(date("Y-m-d"));
                                            $diff = date_diff($dateFrom,$dateTo);
                                            echo $diff->days;
                                        ?></td>
                                    </tr>
                                    
                            <?php }
                            }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<div id="dialog_modal_bookings" data-backdrop="static" class="modal">
    <div class="modal-dialog modal-lg-95-per">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Invoice debt report for booking(s) on: <label id="lblDate"></label>
                    <button aria-label="Close" onclick="$('#dialog_modal_bookings').modal('hide');$('body').addClass('modal-open')" class="close" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                    <div class="modal-export-btn pull-right">
                        <form id="frmExportBooking" action="<?php echo base_url().'index.php/invoice/datewiseexport'?>" method="post" >
                            <input type="hidden" id="hiddBookingIds" name="hiddBookingIds" value="" />
                            <input type="hidden" id="hiddDate" name="hiddDate" value="" />
                            <input class="btn btn-primary pull-right" id="btnExport" value="Export" type="submit">
                        </form>
                    </div>
                </h4>
            </div>
            <div class="modal-body">
                <div id="bookingDiv"></div>
            </div>
            <div class="modal-footer">
                <button onclick="$('#dialog_modal_bookings').modal('hide');$('body').addClass('modal-open');"  class="btn btn-default pull-left" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div id="dialog_modal_agentsrpt" data-backdrop="static" class="modal">
    <div class="modal-dialog modal-lg-95-per">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Invoice debt report for agent: <label id="lblAgent"></label>
                    
                    <span class="mr-left-10 label label-info"><i class="fa fa-envelope mr-right-5"></i><label id="lblAgentEmail"></label></span>
                    <span class="mr-left-10 label label-info"><i class="fa fa-phone mr-right-5"></i><label id="lblAgentPhone"></label></span>
                <button aria-label="Close" onclick="$('#dialog_modal_agentsrpt').modal('hide');$('body').addClass('modal-open')" class="close" type="button">
                    <span aria-hidden="true">×</span>
                </button>
                    <div class="modal-export-btn pull-right">
                        <form id="frmExportAgent" action="<?php echo base_url().'index.php/invoice/agentwiseexport';?>" method="post" >
                            <input type="hidden" id="hiddAgentId" name="hiddAgentId" value="" />
                            <input type="hidden" id="hiddAgentName" name="hiddAgentName" value="" />
                            <input class="btn btn-primary pull-right" id="btnExport" value="Export" type="submit">
                        </form>
                    </div>
                </h4>
            </div>
            <div class="modal-body">
                <div id="agentDiv"></div>
            </div>
            <div class="modal-footer">
                <button  onclick="$('#dialog_modal_agentsrpt').modal('hide');$('body').addClass('modal-open');"  class="btn btn-default pull-left" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    var SITE_PATH = "<?php echo base_url(); ?>index.php/";
    $(document).ready(function () {
        $(".bookingReport").on('click',function(){
            var bookingIds = $(this).attr('data-book-ids');
            var selectedDate = $(this).attr('data-date');
            var selectedDateF = $(this).attr('data-date-mysql');
            $("#lblDate").html(selectedDate);
            $("#hiddBookingIds").val(bookingIds);
            $("#hiddDate").val(selectedDateF);
            $.post(SITE_PATH + 'invoice/get_booking_report',{'bookingIds':bookingIds},function(data){
                $("#bookingDiv").html(data);
            });
            $('#dialog_modal_bookings').modal('show');
        });
        
        $('#dialog_modal_bookings').on('hidden.bs.modal', function () {
            setTimeout(function(){ $("body").removeClass("modal-open"); }, 1000);
        })
    });
</script>
<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<style>
    .custom-btn-group{
        width:auto;
    }
</style>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border col-sm-12 mr-bot-10">
                <h4 class="box-title">Bookings</h4>
                <div class="box-tools pull-right">
                    <a class="pull-right" href="<?php echo base_url(); ?>downloads/extras/guide_for_insert_list_vision.pdf" target="_blank" data-toggle="tooltip" title="Guide for insert pax list"><i class="fa fa-info-circle"> How to insert your pax lists</i></a>
                </div>
            </div>
            <div class="box-body">
                <div class="row mr-bot-10">
                    <div class="col-sm-6">
                        <a class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>index.php/agentbooking/enrol"><i class="fa fa-plus"> Enrol new group</i></a>
                    </div>
                    <?php showSessionMessageIfAny($this); ?>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-striped enrol_table" id="bookingTable" style="width: 99.98%;">
                            <thead>
                                <tr>
                                    <th>Booking id</th>
                                    <th>Date in</th>
                                    <th>Date out</th>
                                    <th>Week(s)</th>
                                    <th>Campus</th>
                                    <th>Package</th>
                                    <th>Pax</th>
                                    <th>Free GL(s)</th>
                                    <th>Total price</th>
                                    <th>Status</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                &nbsp;
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-solid box-primary">
            <div class="box-header with-border">
                <h4 class="box-title"><i class="fa fa-info-circle"> Status label</i></h4>
            </div>
            <div class="box-body">
                <div class="alert note sticky no-margin-bottom">
                    <ul class="legenda">
                        <li><span class="li-tbc">To be confirmed</span>Your booking has been submitted and is waiting for confirmation by Head Office</li>
                        <li><span class="li-active">Active</span>We have reserved spaces for your group and these will be valid until the expiration date shown</li>
                        <li><span class="li-confirmed">Confirmed</span>Your booking is now confirmed and the deposit has being cleared</li>
                        <li><span class="li-elapsed">Elapsed</span>No deposit was received before the expiration date given</li>
                        <li><span class="li-rejected">Rejected</span>Your booking can not be accepted. Please contact a sales representative</li>
                    </ul>
                </div>
            </div>
            <div class="box-footer"></div>
        </div>
    </div>
</div>
<div id="dialog_modal" data-backdrop="static" class="modal" style="top: unset!important;">
    <div class="modal-dialog modal-lg-95-per">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pax List | Booking detail
                    <button aria-label="Close" onclick="$('#dialog_modal').modal('hide');" class="close" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button id="btnCloseAndSendData" class="buttonSendPax btn btn-primary pull-left" type="button">Close and send data (No more changes allowed!)</button>
                <button id="btnCloseAndSaveDraft" class="btn btn-primary pull-right" type="button">Close and save draft</button>
                <button id="btnCopyCommonData" class="btn btn-primary pull-right" type="button">Copy common data from first line</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="dialog_modal_booking_detail" class="modal">
    <div class="modal-dialog modal-lg-95-per">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Booking detail
                    <button aria-label="Close" onclick="$('#dialog_modal_booking_detail').modal('hide');window.location.reload();" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button onclick="$('#dialog_modal_booking_detail').modal('hide');window.location.reload();"  class="btn btn-default pull-left" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="dialog_modal_booking_detail_visa" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span id="dmbdv_title">Booking detail</span>
                    <button aria-label="Close" onclick="$('#dialog_modal_booking_detail_visa').modal('hide');$('body').addClass('modal-open');" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button  onclick="$('#dialog_modal_booking_detail_visa').modal('hide');$('body').addClass('modal-open');"  class="btn btn-default pull-left" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="dialog_modal_print_visa" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span id="dmbdv_title">Sales detail</span>
                    <button aria-label="Close" onclick="$('#dialog_modal_print_visa').modal('hide');$('body').addClass('modal-open');" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button class="btn btn-primary pull-left" type="button" id="printLockedVisa">Print Visa</button>
                <button  onclick="$('#dialog_modal_print_visa').modal('hide');$('body').addClass('modal-open');"  class="btn btn-default pull-left" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="bookingModalLabel">Booking detail</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
                    $(function () {
                        var table = $('#bookingTable').DataTable({
                            "processing": true,
                            "serverSide": true,
                            "ajax": {
                                "type": 'GET',
                                "url": "<?php echo base_url() . 'index.php/agentbooking/getBookings' ?>",
                            },
                            "order": [[0, "desc"]],
                            "columns": [
                                {"data": "id_book", "name": "id_book"},
                                {"data": "date_in", "name": "enrol_arrival_date"},
                                {"data": "date_out", "name": "enrol_departure_date"},
                                {"data": "weeks", "name": "enrol_number_of_week"},
                                {"data": "nome_centri", "name": "nome_centri"},
                                {"data": "package", "name": "pack_package"},
                                {"data": "pax", "name": "pax"},
                                {"data": "free_gl", "name": "free_gl_count"},
                                {"data": "total_price", "name": "total_price"},
                                {"data": "status", "name": "status"},
                                {"data": "actions", "name": "actions", orderable: false, searchable: false}
                            ]
                        });
                        table.on('draw', function () {
                            $('tr td:nth-child(10)').each(function () {
                                var class_name = $(this).find('span').attr('data-class');
                                $(this).addClass(class_name);
                            })
                        });

                        $(document).on('click', ".insertPaxList", function (e) {
                            e.preventDefault();
                            var bytd = $(this).attr("id");
                            var splitbytd = bytd.split("_");
                            var year = splitbytd[1];
                            var enroll_id = splitbytd[2];
                            $.ajax({
                                url: siteUrl + 'agentroster/checkPaxLock',
                                type: 'POST',
                                data: {
                                    enroll_id: enroll_id,
                                    year: year
                                },
                                success: function (data) {
                                    if (data == '1')
                                    {
                                        $("#dialog_modal .modal-body").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />');
                                        $("#dialog_modal .modal-body").load('<?php echo base_url(); ?>index.php/agentroster/editPaxList/' + enroll_id + '/' + year);
                                        $("#dialog_modal").modal('show');
                                        return false;
                                    } else {
                                        swal("Error", 'Roster locked. Can not modify records');
                                        return false;
                                    }
                                },
                                error: function () {
                                    swal("Error", 'Failed to complete action');
                                    return false;
                                }
                            });
                        });
                        $(document).on('click', "#btnCopyCommonData", function (e) {
                            $('#copyFirst').trigger('click');
                        });
                        $(document).on('click', "#btnCloseAndSendData", function (e) {
                            var campiVuoti = 0;
                            $(".reqField").each(function () {
                                if ($(this).val().length == 0) {
                                    campiVuoti++;
                                }
                            });
                            if (campiVuoti == 0)
                            {
                                if (confirm("Are you sure you want to confirm pax data? No more changes will be allowed after you send them!"))
                                {
                                    $("#noChanges").val("SEND");
                                    $("#postPax").submit();
                                } else
                                {
                                    return void(0);
                                }
                            } else
                            {
                                swal("Error", "Please fill-in all fields in the roster! (" + campiVuoti + " more fields needed)");
                                return void(0);
                            }
                        });
                        $(document).on('click', "#btnCloseAndSaveDraft", function (e) {
                            $("#noChanges").val("NOSEND");
                            $("#postPax").submit();
                        });
                        $('body').on('click', '.visaPopup', function (e) {
                            var elm = $(this);
                            var enroll_id = elm.attr('data-id');
                            if (enroll_id != '' && typeof enroll_id != 'undefined')
                            {
                                $.ajax({
                                    url: siteUrl + 'agentroster/bookingExists',
                                    type: 'POST',
                                    data: {
                                        enroll_id: enroll_id
                                    },
                                    success: function (response) {
                                        if (response == 1)
                                        {
                                            e.preventDefault();
                                            $("#dialog_modal_booking_detail .modal-body").html("");
                                            $.get(siteUrl + "agentroster/getVisaPopupDetails/" + enroll_id, function (data) {
                                                $("#dialog_modal_booking_detail .modal-body").html(data);
                                                $("#dialog_modal_booking_detail").modal('show');
                                            });
                                        } else
                                        {
                                            swal("Error", "This booking id doesn't exists!");
                                        }
                                    },
                                    error: function ()
                                    {
                                        swal("Error", "This booking id doesn't exists!");
                                    }
                                });
                            }
                        });
                    });
                    $('body').on('click', '.booking_modal', function () {
                        var booking_id = $(this).attr('data-id');
                        $.ajax({
                            type: 'post',
                            data: {booking_id: booking_id},
                            url: '<?php echo base_url() . 'index.php/agentbooking/getSingleBooking' ?>',
                            success: function (data) {
                                $("#bookingModal .modal-body").html(data);
                                $("#bookingModal").modal('show');
                            }
                        });
                    });
</script>
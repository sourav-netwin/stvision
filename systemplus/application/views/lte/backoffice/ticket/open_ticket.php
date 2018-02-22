<link href="<?php echo LTE; ?>plugins/iCheck/all.css" rel="stylesheet">
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header col-sm-12">
                    <div class="row">
                        <?php showSessionMessageIfAny($this); ?>
                    </div>
                </div>

                <form class="form-horizontal validate" name="openTicketForm" id="openTicketForm" action="<?php echo site_url() ?>/ticketmanagement/openTicket" method="POST" onsubmit="return btnDsbl()" enctype="multipart/form-data">

                    <div class="box-body">

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="campus">Campus</label>
                            <div class="col-sm-4 col-md-2 campus_box">
                                <?php
                                $contaCentri = 0;
                                $newLine = 0;
                                foreach ($centri as $key => $item) {
                                    ?>
                                    <input type="checkbox" autocomplete="off" class="chCentri sel_<?php echo $item['valuta_fattura'] ?>" name="centri[]" id="c_<?php echo $item['id'] ?>" value="<?php echo $item['id'] ?>">&nbsp;<label class="normal" for="c_<?php echo $item['id'] ?>"><?php echo $item['nome_centri'] ?></label><br />
                                    <?php
                                    $contaCentri++;
                                    $newLine++;
                                    if ($contaCentri % 5 == 0) {
                                        ?>
                                    </div>
                                    <?php if ($newLine % 4 == 0) { ?>
                                        <div class="col-md-2"></div>
                                    <?php } ?>
                                    <div class="col-sm-4 col-md-2 campus_box">
                                        <?php
                                    }
                                }
                                ?>
                                <div class="error" id="centriError"><?php echo form_error('centri'); ?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="type">Ticket type</label>
                            <div class="col-sm-10 col-md-4">
                                <input class="chType" type="checkbox" autocomplete="off" name="type[]" id="s_cm" value="Campus Manager"><label class="normal" for="s_open"><span style="color:#05ca05">&nbsp;Campus Manager</span></label>&nbsp;&nbsp;
                                <input class="chType" type="checkbox" autocomplete="off" name="type[]" id="s_cd" value="Course Director"><label class="normal" for="s_closed"><span style="color:#FF0000">&nbsp;Course Director</span></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="priority">Priority</label>
                            <div class="col-sm-6 col-md-4">
                                <label class="radio-inline">
                                    <input type="radio" name="priority" value="low"> <span style="color: #05ca05">Low</span>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="priority" value="medium"> <span style="color: #d0c100">Medium</span>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="priority" value="high"> <span style="color: #FF0000">High</span>
                                </label>
                                <div class="error"><?php echo form_error('priority'); ?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="selCategory">Category</label>
                            <div class="col-sm-6 col-md-4">
                                <select class="form-control" name="selCategory" id="selCategory">
                                    <option value="">Select</option>
                                    <option value="TUITION">TUITION</option>
                                    <option value="TRANSPORTATION">TRANSPORTATION</option>
                                    <option value="ACCOMODATION">ACCOMODATION</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="tktTitle">Title</label>
                            <div class="col-sm-6 col-md-4">
                                <input class="form-control" type="text" name="tktTitle" id="tktTitle" value="">
                                <div class="error"><?php echo form_error('tktTitle'); ?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="tktContent">Text</label>
                            <div class="col-sm-6 col-md-4">
                                <textarea class="form-control" name="tktContent" id="tktContent"></textarea>
                                <div class="error"><?php echo form_error('tktContent'); ?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="fileAttachment">Attachment</label>
                            <div class="col-sm-6 col-md-4">
                                <input type="file" id="fileAttachment" name="fileAttachment"/>
                                <div class="fileInfo">Max. file size allowed is 2 MB</div>
                                <div class="error"><?php echo form_error('fileAttachment'); ?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="selRefBooking">Reference booking</label>
                            <div class="col-sm-6 col-md-4">
                                <select class="form-control" name="selRefBooking" id="selRefBooking">
                                    <option value="all">All</option>
                                    <?php
                                    if ($bookings) {
                                        foreach ($bookings as $booking) {
                                            ?>
                                            <option value="<?php echo $booking['booking_id'] ?>"><?php echo $booking['booking_id'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="error"><?php echo form_error('selRefBooking'); ?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-data col-sm-10 col-md-offset-2">
                                <input class="btn btn-primary" id="btnSave" name="btnSave" value="Submit" type="submit"/>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        &nbsp;
                    </div>
                    <!-- /.box-footer-->
                </form>
            </div>
        </div>
    </div>
</section>
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<script>
                    function btnDsbl() {
                        if ($('input:radio[name=centri[]]:checked').val() != '' && typeof $('input:radio[name=centri[]]:checked').val() != 'undefined' && $('input:radio[name=type[]]:checked').val() != '' && typeof $('input:radio[name=type[]]:checked').val() != 'undefined' && $('input:radio[name=priority]:checked').val() != '' && typeof $('input:radio[name=priority]:checked').val() != 'undefined' && $('#selCategory').val() != '' && $('#tktTitle').val() != '' && $('#tktContent').val() != '' && $('#selRefBooking').val() != '') {
                            $('#btnSave').prop('disabled', true);
                            return true;
                        }
                    }

                    $(function () {
                        $('input[type="checkbox"]').iCheck({checkboxClass: 'icheckbox_square-blue'});
                        var SITE_PATH = "<?php echo base_url(); ?>index.php/";
                        $('input').on('ifChanged', function (event) {
                            var campusIds = [];
                            $(".chCentri:checked").each(function () {
                                campusIds.push($(this).val());
                            });
                            $.post(SITE_PATH + "ticketmanagement/getAjaxBooking", {'campusIds': campusIds}, function (data) {
                                $("#selRefBooking").html(data);
                            }, 'html');

                        });


                        $("#openTicketForm").validate({
                            errorElement: "div",
                            ignore: "",
                            rules: {
                                "centri[]": "required",
                                "type[]": "required",
                                priority: "required",
                                selCategory: "required",
                                tktTitle: "required",
                                tktContent: "required",
                                selRefBooking: "required"
                            },
                            messages: {
                                "centri[]": "Please select campus",
                                "type[]": "Please select type",
                                priority: "Please select priority",
                                selCategory: "Please select category",
                                tktTitle: "Please enter title",
                                tktContent: "Please enter text",
                                selRefBooking: "Please select reference booking"
                            },
                            errorPlacement: function (error, element) {
                                if (element.is(':radio'))
                                {
                                    error.appendTo($("input[name='priority']").last().parent().parent());
                                } else if (element.attr('name') == 'centri[]')
                                {
                                    error.appendTo($("input[name='centri[]']").parent().parent().parent());
                                    error.addClass('col-md-offset-2');
                                    error.css({'clear': 'both', 'padding-left': '15px'});
                                } else if (element.attr('name') == 'type[]')
                                {
                                    error.appendTo($("input[name='type[]']").parent().parent());
                                } else
                                {
                                    error.insertAfter(element);
                                }
                            },
                            submitHandler: function (form) {
                                form.submit();
                            }
                        });
                    });
</script>
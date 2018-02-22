<div class="modal fade editmodal" id="weekEditModal" tabindex="-1" role="dialog" aria-labelledby="weekEditModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close week_edit_close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="dateEditModalLabel">Edit Week</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="validate" name="edit_week" id="edit_week" method="POST">
                            <div class="form-group">
                                <label for="date_in">Week:</label>
                                <select name="week" class="form-control required" id="week">
                                    <option value="">Select week</option>
                                    <option value="1" <?php echo ($week == 1 ? 'selected' : ''); ?>>1</option>
                                    <option value="2" <?php echo ($week == 2 ? 'selected' : ''); ?>>2</option>
                                    <option value="3" <?php echo ($week == 3 ? 'selected' : ''); ?>>3</option>
                                </select>
                                <div class="help-block message-holder"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="edit_week_close">Close</button>
                <button type="button" class="btn btn-primary" id="edit_week_btn">Update</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#open_edit_week').on('click', function () {
            $('.message-holder').html('');
            $("#week").removeClass('error');
        });
        $("#edit_week_btn").on('click', function () {
            $('.message-holder').html('');
            if ($("#week").val() == '') {
                $("#week").addClass('error');
                $('.message-holder').html('<span class="error">Please select week</span>');
                return false;
            }
            var week = $('#week').val();
            var bookId = $('#booking_id').val();
            $.ajax({
                url: siteUrl + 'backofficeajax/updateBookingWeek',
                type: 'POST',
                data: {'week': week, 'booking_id': bookId},
                dataType: 'json',
                success: function (data) {
                    if (data.success) {
                        var bookingStatus = $("#bookingStatus").val();
                        var bookingWeeks = $("#bookingWeeks").val();
                        if (bookingStatus == "confirmed" && bookingWeeks != week) {
                            generateNewInvoiceForBooking(siteUrl, bookId);
                            $("#bookingWeeks").val(week);
                        }
                        $('#week_field').html(week);
                        $('.message-holder').html('<span style="color: green;">' + data.message + '</span>');
                    } else {
                        $('.message-holder').html('<span style="color: red;">' + data.message + '</span>');
                    }
                }
            });
        });
        $("#edit_week_close, .week_edit_close").click(function () {
            $('#weekEditModal').modal('hide');
            $('.message-holder').html('');
            setTimeout(function(){ $('.tooltip').remove(); }, 1000);           
            
        });
    });
</script>
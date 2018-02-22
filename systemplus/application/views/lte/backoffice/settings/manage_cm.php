<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<link href="<?php echo base_url(); ?>css/external/jquery-ui-1.8.21.custom.css" rel="stylesheet">
<style>
    table { 
        table-layout: fixed;
        overflow: hidden;
    }
    td { width: 33%; }
    .asterick{
        color: #dd4b39;
    }
</style>
<section class="content">
    <div class="row">
        <div class="box">
            <div class="box-header col-sm-12">
                <div class="row">
                    <?php showSessionMessageIfAny($this); ?>
                </div>
            </div>
            <div class="box-body">
                <table id="reportTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Campus</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                &nbsp;
            </div>
        </div>
    </div>
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update details</h4>
                </div>
                <div class="modal-body">
                    <div class="update-err"></div>
                    <form class="form-horizontal" id="userForm">
                        <div class="form-group">
                            <label class="col-sm-2">Name <span class="asterick">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="first_name" class="form-control first_name" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">Surname <span class="asterick">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="last_name" class="form-control last_name" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">Email <span class="asterick">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="email" class="form-control email" />
                                <input type="hidden" name="user_id" class="form-control user_id" />
                                <input type="hidden" name="orig_email" class="form-control orig_email" />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="updateDetail">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</section>


<input type="hidden" value="0" id="hiddPageNumber" />

<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script>
    var validator;
    $(function () {
        table = $('#reportTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "type": 'GET',
                "url": "<?php echo base_url() . 'index.php/settings/getUsers' ?>",
                data: {
                    role: 'college_adm'
                }
            },
            "order": [[0, "asc"]],
            "columns": [
                {"data": "nome_centri", "name": "nome_centri"},
                {"data": "first_name", "name": "first_name"},
                {"data": "email", "name": "email"},
                {"data": "action", "name": "action", "orderable": false, "searchable": false}
            ],
        });
        $('body').on('click', '.open-modal', function () {
            validator.resetForm();
            var id = $(this).attr('data-id');
            if (id == '') {
                return;
            }
            $.ajax({
                type: 'post',
                url: '<?php echo base_url() . 'index.php/settings/getUser' ?>',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    if (data.success) {
                        var user = data.user;
                        $('.first_name').val(user.first_name);
                        $('.last_name').val(user.last_name);
                        $('.email, .orig_email').val(user.email);
                        $('.user_id').val(id);
                        $('#editModal').modal('show');
                    }
                }
            });
        });
        $('#updateDetail').on('click', function () {
            if (!$("#userForm").valid()) {
                return;
            }
            $.ajax({
                type: 'post',
                url: '<?php echo base_url() . 'index.php/settings/updateUser' ?>',
                data: {
                    formData: $('#userForm').serialize()
                },
                dataType: 'json',
                success: function (data) {
                    if (data.success) {
                        $('#editModal').modal('hide');
                        table.draw();
                        swal('Success', 'Information updated successfully');
                    } else {
                        swal('Error', data.message);
                    }
                }
            });
        });
        $.validator.addMethod("name_valid", function (value, element) {
            return this.optional(element) || /^[A-Z]'?[-a-zA-Z]+$/i.test(value);
        }, "Please enter valid name.");
        validator = $("#userForm").validate({
            errorElement: "div",
            ignore: "",
            rules: {
                email: {
                    required: true,
                    email: true
                },
                first_name: {
                    required: true,
                    name_valid: true
                },
                last_name: {
                    required: true,
                    name_valid: true
                },
            },
            messages: {
                email: {
                    required: 'Please enter email',
                    email: 'Please enter valid email'
                },
                first_name: {
                    required: "Please enter name",
                    name_valid: "Please enter valid name"
                },
                last_name: {
                    required: "Please enter surname",
                    name_valid: "Please enter valid surname"
                },
            }
        });
    });
</script>

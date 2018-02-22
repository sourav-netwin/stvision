<link rel="stylesheet" href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css">
<style>
    .loadingSpan{
        margin-left: 2px;
        margin-top: 6px;
    }
</style>      

<!-- Here goes the content. -->
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Test report</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="form-data col-sm-6 col-md-4" >
                        <label for="selTest" style="width: 115px;">
                            <strong>Test</strong>
                        </label>
                        <select class="form-control" id="selTest" name="selTest"  >
                            <option value="">All</option>
                            <?php
                            if (!empty($testDropdown)) {
                                foreach ($testDropdown as $testdd) {
                                    ?>
                                    <option value="<?php echo $testdd['test_id']; ?>"><?php echo $testdd['test_title']; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-data col-sm-6 col-md-4" >
                        <label for="txtSearch" style="width: 115px;">
                            <strong>Student name</strong>
                        </label>
                        <input class="form-control" type="text" id="txtSearch" name="txtSearch" value="" />
                    </div>
                    <div class="form-data col-sm-6 col-md-4 mr-top-25" >
                        <div class="col-sm-6">
                            <input id="btnSearch" type="submit" value="Search" class="btn btn-primary" >
                            <input id="btnClear" type="reset" value="Clear" class="btn btn-danger" >                        
                        </div>
                        <div class="col-sm-6 text-right exportExcelWrapper">

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mr-top-30" id="testListDiv">
                        <table class="table table-bordered table-hover" id="reportTable">
                            <thead>
                                <tr>
                                    <th>Test</th>
                                    <th>Submitted date</th>								
                                    <th>Student name</th>								
                                    <th>Campus name</th>								
                                    <th>Booking id</th>
                                    <th>Total questions</th>
                                    <th>Correct answers</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>



            <div class="row"></div>
        </div><!-- End of .box -->
    </div><!-- End of .col-md-12 -->
</div>
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    var SITE_PATH = "<?php echo base_url(); ?>index.php/";
    var table, test, studentName;
    $(document).ready(function () {

        datatable();
        $("body").on("click", "#btnClear", function () {
            $('#txtSearch').val('');
            $('#selTest').val('');
            $('#selTest').trigger("liszt:updated");
            $("#btnSearch").trigger('click');
        });

        $("body").on("click", "#btnSearch", function () {
            studentName = $('#txtSearch').val();
            test = $('#selTest').val();
            table.destroy();
            datatable(test, studentName);
        });
        $('body').on('click', '#exportExcel', function () {
            $.ajax({
                type: 'post',
                url: "<?php echo base_url() . 'index.php/studentsreport/exportReport' ?>",
                data: {
                    test: test,
                    studentName: studentName
                },
                dataType: 'json',
                success: function (data) {
                    var $a = $("<a>");
                    $a.attr("href", data.file);
                    $("body").append($a);
                    $a.attr("download", "" + data.file_name + ".xls");
                    $a[0].click();
                    $a.remove();
                }
            });
        });
    });
    function datatable(test = '', studentName = '') {
        table = $('#reportTable').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax": {
                "type": 'GET',
                "url": "<?php echo base_url() . 'index.php/studentsreport/getReport' ?>",
                data: {
                    test: test,
                    studentName: studentName
                },
            },
            "drawCallback": function (settings, json) {
                var api = this.api();
                var rows = api.rows();
                if (typeof rows[0] != 'undefined' && rows[0].length > 0) {
                    $('.exportExcelWrapper').html('<input id="exportExcel" class="export-button btn btn-primary" type="button" value="Export" />');
                } else {
                    $('.exportExcelWrapper').html('');
                }
            },
            "columns": [
                {"data": "test_title", "name": "test_title"},
                {"data": "ts_submitted_on", "name": "ts_submitted_on"},
                {"data": "nome", "name": "nome"},
                {"data": "nome_centri", "name": "nome_centri"},
                {"data": "id_book", "name": "id_book"},
                {"data": "total_questions", "name": "total_questions"},
                {"data": "correct_answers", "name": "correct_answers"}
            ],
        });
    }
</script>	


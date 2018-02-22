<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <div class="row">
        <div class="col-md-12">
            <?php showSessionMessageIfAny($this); ?>
            <form id="box_campus" name="box_campus" action="<?php echo base_url(); ?>index.php/invoice/exportDetailedReport" method="post">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 mr-bot-10 mr-top-10">
                                <label >Campus:</label>
                                <div class="box-tools pull-right sort-text">
                                    <a href="javascript:void(0);" id="s_USA">USA</a> -
                                    <a href="javascript:void(0);" id="s_UK">UK</a> -
                                    <a href="javascript:void(0);" id="s_EUR">EUR</a> -
                                    <a href="javascript:void(0);" id="s_all">All</a> -
                                    <a href="javascript:void(0);" id="s_none">None</a>
                                </div>
                            </div>
                        </div>
                        <div class="row mr-bot-10">
                            <div class="col-sm-3">
                                <?php
                                $contaCentri = 0;
                                foreach ($centri as $key => $item) {
                                    $contaCentri++;
                                    ?>
                                    <input type="checkbox" autocomplete="off" class="chCentri sel_<?php echo $item['valuta_fattura'] ?>" name="centri[]" id="c_<?php echo $item['id'] ?>" value="<?php echo $item['id'] ?>"> <label class="normal" for="c_<?php echo $item['id']; ?>"><?php echo $item['nome_centri'] ?></label><br />
                                    <?php
                                    if ($contaCentri % 5 == 0) {
                                        ?>
                                    </div>
                                    <div class="col-sm-3">
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mr-bot-10 mr-top-10">
                                    <label for="season">Agent</label>
                                </div>
                                <div class="mr-bot-10" >
                                    <select class="form-control mr-bot-10 select2" name="agent_id[]" multiple="multiple" data-placeholder="Select Agents">
                                        <?php foreach ($agents as $agent) { ?>
                                            <option value="<?php echo $agent['id'] ?>"><?php echo $agent['businessname'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input id="getReport" type="button" value="Get Report" class="btn btn-primary pull-right">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <div class="exportExcelWrapper text-right"></div>
                </div>
                <div class="box-body scrollx">
                    <table class="table table-hovered table-bordered table-striped" id="reportTable">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Customer email</th>
                                <th>Customer telephone</th>
                                <th>Group ref</th>
                                <th>Inv no</th>
                                <th>Campus</th>
                                <th>Inv date</th>
                                <th>Due date</th>
                                <th>Arr date</th>
                                <th>Dep date</th>
                                <th>Inv value</th>
                                <th>Not yet due</th>
                                <th>Overdue</th>
<!--                                <th>Total</th>-->
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <div class="table_footer" style="padding-top: 2%;">
                        <div class="col-sm-3">
                            <label class="col-sm-6">Total balance</label>
                            <span class="balance_total"></span>
                        </div>
                        <div class="col-sm-3">
                            <label class="col-sm-6">Not yet due</label>
                            <span class="due_amount"></span>
                        </div>
                        <div class="col-sm-3">
                            <label class="col-sm-7">Total overdue</label>
                            <span class="overdue_amount"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<style>
    .ui-widget-content{
        overflow: auto;
        max-height: 170px;
    }
    .scrollx{
        overflow-x: scroll; 
    }
</style>
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<link href="<?php echo LTE; ?>plugins/iCheck/all.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script src="<?php echo LTE; ?>custom/backoffice.js"></script>
<script src="<?php echo LTE; ?>plugins/select2/select2.full.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    var table;
    function iCheckInit() {
        $('input.chCentri').iCheck('destroy');
        $('input.chCentri').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            increaseArea: '10%' // optional
        });
    }
    function getAgents() {
        return $(".select2").select2('data');
        var selectedValues = [];
        $.each($("select.select2"), function () {
            $(this).select2('val', selectedValues);
        });
        return selectedValues;
        var agents = [];
        $("select.select2").each(function () {
            if ($(this).is(':selected')) {
                agents.push($(this).val());
            }
        });
        return agents;
    }
    function getChecked() {
        var centri = [];
        $("input.chCentri:checked").each(function () {
            centri.push($(this).val());
        });
        return centri;
    }

    var SITE_PATH = "<?php echo base_url(); ?>";

    $(document).ready(function () {
        datatable([], []);
        getTotal([], []);
        var agents = $('.select2');
        iCheckInit();
        agents.select2();
        $("#s_USA").click(function () {
            $("input.chCentri").each(function () {
                $(this).iCheck("uncheck");
            });
            $("input.sel_USD").each(function () {
                $(this).iCheck("check");
            });
        });
        $("#s_UK").click(function () {
            $("input.chCentri").each(function () {
                $(this).iCheck("uncheck");
            });
            $("input.sel_GBP").each(function () {
                $(this).iCheck("check");
            });
        });
        $("#s_EUR").click(function () {
            $("input.chCentri").each(function () {
                $(this).iCheck("uncheck");
            });
            $("input.sel_EUR").each(function () {
                $(this).iCheck("check");
            });
        });
        $("#s_all").click(function () {
            $("input.chCentri").each(function () {
                $(this).iCheck("check");
            });
        });
        $("#s_none").click(function () {
            $("input.chCentri").each(function () {
                $(this).iCheck("uncheck");
            });
        });
        $('#getReport').on('click', function () {
            $("html, body").animate({ scrollTop: $(document).height() }, 1000);
            var campuses = getChecked();
            var selectedAgents = agents.select2('data');
            var _agents = [];
            if (selectedAgents.length > 0) {
                $.each(selectedAgents, function (key, value) {
                    _agents.push(value.id);
                });
            }
            if (typeof table != 'undefined') {
                table.destroy();
            }
            datatable(campuses, _agents);
            getTotal(campuses, _agents);
        });
        
        $('body').on('click', '#exportExcel', function () {
            $('#box_campus').submit();
        });
        
    });
    function datatable(campuses, selectedAgents) {
        table = $('#reportTable').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax": {
                "type": 'GET',
                "url": "<?php echo base_url() . 'index.php/invoice/getDetailedReport' ?>",
                data: {
                    campuses: campuses,
                    agents: selectedAgents
                }
            },
            "drawCallback": function (settings, json) {
                //getTotal(campuses, selectedAgents);
                var api = this.api();
                var rows = api.rows();
                if (typeof rows[0] != 'undefined' && rows[0].length > 0) {
                    $('.exportExcelWrapper').html('<input id="exportExcel" class="export-button btn btn-primary" type="button" value="Export" />');
                } else {
                    $('.exportExcelWrapper').html('');
                }
                
            },
            "columns": [
                {"data": "businessname", "name": "businessname"},
                {"data": "email", "name": "email"},
                {"data": "businesstelephone", "name": "businesstelephone"},
                {"data": "inv_booking_id", "name": "inv_booking_id"},
                {"data": "inv_number", "name": "inv_number"},
                {"data": "nome_centri", "name": "nome_centri"},
                {"data": "inv_date", "name": "inv_date"},
                {"data": "due_date", "name": "due_date"},
                {"data": "arrival_date", "name": "arrival_date"},
                {"data": "departure_date", "name": "departure_date"},
                {"data": "inv_total_cost", "name": "inv_total_cost"},
                {"data": "pfp_import", "name": "pfp_import"},
                {"data": "overdue", "name": "overdue"},
//                {"data": "total_cost", "name": "total_cost"},
                {"data": "status", "name": "status"}
            ]
        });
    }
    function getTotal(campuses, selectedAgents) {
        $.ajax({
            type: 'post',
            url: '<?php echo base_url() . 'index.php/invoice/getTotals' ?>',
            data: {
                campuses: campuses,
                agents: selectedAgents
            },
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    var total = data.total;
                    var balanceTotal = (typeof total.balanceTotal != 'undefined') ? total.balanceTotal : 0;
                    var dueTotal = (typeof total.dueTotal != 'undefined') ? total.dueTotal : 0;
                    var overdueTotal = (typeof total.overdueTotal != 'undefined') ? total.overdueTotal : 0;
                    $('.balance_total').html(balanceTotal);
                    $('.due_amount').html(dueTotal);
                    $('.overdue_amount').html(overdueTotal);
                }
            }
        });
    }
</script>
<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php showSessionMessageIfAny($this); ?>
            <form id="box_campus" name="box_campus">
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
                                    <input type="checkbox" autocomplete="off" class="chCentri sel_<?php echo $item['valuta_fattura'] ?>" name="campuses[]" id="c_<?php echo $item['id'] ?>" value="<?php echo $item['id'] ?>"> <label class="normal" for="c_<?php echo $item['id']; ?>"><?php echo $item['nome_centri'] ?></label><br />
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
                                    <select class="form-control mr-bot-10 select2" name="agents[]" multiple="multiple" data-placeholder="Select agents">
                                        <?php foreach ($agents as $agent) { ?>
                                            <option value="<?php echo $agent['id'] ?>"><?php echo $agent['businessname'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input id="getReport" type="button" value="Get report" class="btn btn-primary pull-right">
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
                <div class="box-body">
                    <table class="table table-hovered table-bordered table-striped" id="reportTable">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Customer email</th>
                                <th>Customer telephone</th>
                                <th>Total balance</th>
                                <th>Not yet due</th>
                                <th>Overdue</th>
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
                            <label class="col-sm-7">Total Overdue</label>
                            <span class="overdue_amount"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .ui-widget-content{
        overflow: auto;
        max-height: 170px;
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
    function getAgents(agents) {
        var selectedAgents = agents.select2('data');
        var _agents = [];
        if (selectedAgents.length > 0) {
            $.each(selectedAgents, function (key, value) {
                _agents.push(value.id);
            });
        }
        return _agents;
    }
    function getChecked() {
        var centri = [];
        $("input.chCentri:checked").each(function () {
            centri.push($(this).val());
        });
        return centri;
    }

    var SITE_PATH = "<?php echo base_url(); ?>";
    var campuses, _agents;
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
            $("html, body").animate({scrollTop: $(document).height()}, 1000);
            campuses = getChecked();
            _agents = getAgents(agents);
            if (typeof table != 'undefined') {
                table.destroy();
            }
            datatable(campuses, _agents);
        });
        $('body').on('click', '#exportExcel', function () {
            $.ajax({
                type: 'post',
                url: "<?php echo base_url() . 'index.php/invoice/exportSummary' ?>",
                data: {
                    campuses: campuses,
                    agents: _agents
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
    function datatable(campuses, selectedAgents) {
        table = $('#reportTable').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax": {
                "type": 'GET',
                "url": "<?php echo base_url() . 'index.php/invoice/getSummary' ?>",
                data: {
                    campuses: campuses,
                    agents: selectedAgents
                },
            },
            "drawCallback": function (settings, json) {
                getTotal(campuses, selectedAgents);
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
                {"data": "total_cost", "name": "total_cost"},
                {"data": "pfp_import", "name": "pfp_import"},
                {"data": "overdue", "name": "overdue"}
            ],
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
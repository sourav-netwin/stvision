<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<link href="<?php echo base_url(); ?>css/external/jquery-ui-1.8.21.custom.css" rel="stylesheet">
<style>
    table { 
        table-layout: fixed;
        overflow: hidden;
    }
    td { width: 33%; }
</style>
<section class="content">
    <div class="row">
        <!-- DIRECT SEARCH PRIMARY -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Search agent by</h3>
            </div>
            <!-- /.box-header -->
            <!-- /.box-body -->
            <div class="box-body">
                <form id="search_agent_filter_form" name="box_campus" action="<?php echo base_url(); ?>index.php/manageagents" method="post">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Agent name</label> 
                            <input type="text" name="agentname" id="agentname" value="<?php echo htmlentities($agentName) ?>" class="form-control ui-autocomplete-input" autocomplete="off" >
                        </div>
                    </div>

                    <div class="col-md-4">							
                        <div class="form-group">
                            <label>Account manager name</label> 
                            <input type="text" name="accountmanagername" id="accountmanagername" value="<?php echo htmlentities($accountmanagername) ?>" class="form-control ui-autocomplete-input" autocomplete="off" >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Agent Country</label> 
                            <select class="form-control" id="selCountry" name="selCountry[]" multiple="multiple">
                                <?php
                                if ($countries) {
                                    foreach ($countries as $country) {
                                        ?>
                                        <option <?php
                                        if ($selCountry) {
                                            if (in_array($country['country'], $selCountry))
                                                echo "selected";
                                        }
                                        ?> value="<?php echo $country['country']; ?>"><?php echo $country['country']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="box-footer">
                <input id="btnsearchagent" name="btnsearchagent" type="button" value="Search agent" class="btn btn-primary pull-right">
                <a href="javascript:void(0);" value="Reset" class="btn btn-primary pull-right" id="resetList" style="margin-right:5px;"> Reset</a>
            </div>

            <!-- /.box-footer-->
        </div>
    </div>


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
                            <th>Agent name</th>
                            <th>Agent business name</th>
                            <th>Agent city</th>								
                            <th>Agent country</th>
                            <th>Account manager name</th>
                            <th style="width:150px !important">Account manager position</th>
                            <th class="no-sort" style="width:75px !important">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th>Agent name</th>
                            <th>Agent business name</th>
                            <th>Agent city</th>								
                            <th>Agent country</th>
                            <th>Account manager name</th>
                            <th style="width:150px !important">Account manager position</th>
                            <th class="no-sort" style="width:75px !important">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="box-footer">
                &nbsp;
            </div>
        </div>

    </div>	
    <div id="viewModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Agent detail - <span class="agent_name"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4"><strong>Name:</strong></div>
                        <div class="col-sm-8 agent_name"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"><strong>Email:</strong></div>
                        <div class="col-sm-8 agent_email"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"><strong>Business name:</strong></div>
                        <div class="col-sm-8 businessname"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"><strong>Business address:</strong></div>
                        <div class="col-sm-8 businessaddress"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"><strong>Business city:</strong></div>
                        <div class="col-sm-8 businesscity"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"><strong>Business country:</strong></div>
                        <div class="col-sm-8 businesscountry"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"><strong>Business postal code:</strong></div>
                        <div class="col-sm-8 businesspostalcode"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"><strong>Business telephone:</strong></div>
                        <div class="col-sm-8 businesspostalcode"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"><strong>Account manager name:</strong></div>
                        <div class="col-sm-8 account_manager_name"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"><strong>Account manager position:</strong></div>
                        <div class="col-sm-8 position"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</section>


<input type="hidden" value="0" id="hiddPageNumber" />

<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script src="<?php echo LTE; ?>plugins/select2/select2.full.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo LTE; ?>custom/backoffice.js"></script>
<script>
    var agentName = '', accountmanagername = '', selCountry = '';
    $(function () {
        datatable();
        $('#selCountry').select2({
            dropdownAutoWidth: true,
            width: '100%'
        });

        $("#agentname").autocomplete({
            source: function (request, response) {
                // request.term is the term searched for.
                // response is the callback function you must call to update the autocomplete's
                // suggestion list.
                $.ajax({
                    url: "manageagents/getAgentNameAutoComplete",
                    type: "POST",
                    data: {
                        'name': request.term
                    },
                    dataType: "json",
                    success: response,
                    error: function () {
                        response([]);
                    }
                });
            }
        });

        $("#accountmanagername").autocomplete({
            source: function (request, response) {
                // request.term is the term searched for.
                // response is the callback function you must call to update the autocomplete's
                // suggestion list.
                $.ajax({
                    url: "manageagents/getAccountManagerNameAutoComplete",
                    type: "POST",
                    data: {
                        'name': request.term
                    },
                    dataType: "json",
                    success: response,
                    error: function () {
                        response([]);
                    }
                });
            }
        });

        $("#agentname").on("autocompleteselect", function (e, ui) {
            e.preventDefault();
            this.value = ui.item.label;
        });

        $("#accountmanagername").on("autocompleteselect", function (e, ui) {
            e.preventDefault();
            this.value = ui.item.label;
        });

        $("#btnsearchagent").click(function () {
            agentName = $.trim($('#agentname').val());
            accountmanagername = $.trim($('#accountmanagername').val());
            selCountry = $('#selCountry').val();
            if (agentName == '' && accountmanagername == '' && selCountry == null)
            {
                swal("Error", "Please, select one or more filter!");
            } else {
                table.destroy();
                datatable(agentName, accountmanagername, selCountry);
            }
        });
        $('#resetList').on('click', function () {
            if (agentName == '' && accountmanagername == '' && selCountry == '') {
                return;
            }
            $('#agentname').val('');
            $('#accountmanagername').val('');
            $('#selCountry').val('');
            agentName = '';
            accountmanagername = '';
            selCountry = '';
            table.destroy();
            datatable();
        });
        $('body').on('click', '.view_agent', function () {
            $('#viewModal').modal();
            var id = $(this).attr('data-id');
            $.ajax({
                url: "manageagents/getAgent",
                type: "POST",
                data: {
                    'id': id
                },
                dataType: "json",
                success: function (data) {
                    if (data.success) {
                        var agent = data.agent;
                        $('.agent_name').html(agent.agentname);
                        $('.agent_email').html(agent.agentemail);
                        $('.businessname').html(agent.businessname);
                        $('.businessaddress').html(agent.businessaddress);
                        $('.businesscity').html(agent.businesscity);
                        $('.businesscountry').html(agent.businesscountry);
                        $('.businesspostalcode').html(agent.businesspostalcode);
                        $('.businesstelephone').html(agent.businesstelephone);
                        $('.account_manager_name').html(agent.account_manager_name);
                        $('.position').html(agent.position);
                    }
                }
            });
        });
    });
    function datatable(agentName = '', accountmanagername = '', selCountry = '') {
        table = $('#reportTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "type": 'GET',
                "url": "<?php echo base_url() . 'index.php/manageagents/getAgents' ?>",
                data: {
                    agentname: agentName,
                    accountmanagername: accountmanagername,
                    selCountry: selCountry
                },
            },
            "order": [[0, "asc"]],
            "columns": [
                {"data": "agentname", "name": "agentname"},
                {"data": "businessname", "name": "businessname"},
                {"data": "businesscity", "name": "businesscity"},
                {"data": "businesscountry", "name": "businesscountry"},
                {"data": "account_manager_name", "name": "account_manager_name"},
                {"data": "position", "name": "position"},
                {"data": "action", "name": "action", "orderable": false, "searchable": false}
            ],
        });
    }
</script>

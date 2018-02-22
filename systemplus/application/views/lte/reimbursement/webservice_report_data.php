<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header col-sm-12">
                <h3 class="box-title">&nbsp;</h3>
                <div class="box-tools pull-right">
                    <input id="backToFilter" class="export-button btn btn-primary" type="button" value="Back" />
                    <span class="exportExcelWrapper"></span>
                </div>
            </div>
            <div class="box-body">
                <div class="row mr-bot-10">
                    <?php showSessionMessageIfAny($this); ?>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="reportTable" class="table table-bordered table-striped" style="width: 99.98%;" >
                            <thead>
                                <tr>
                                    <th>Accompagnatore</th>
                                    <th>Collaboratore</th>
                                    <th>Prodotto</th>
                                    <th>Codice prodotto</th>
                                    <th>Passeggero</th>
                                    <th>Tipologia passeggero</th>
                                    <th>Total due</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
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
<style>
    #reportTable_length{
        display: none;
    }
</style>
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    var SITE_PATH = "<?php echo base_url(); ?>index.php/";
    $(document).ready(function () {

        var table = $('#reportTable').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax": {
                "type": 'GET',
                "url": "<?php echo base_url() . 'index.php/webservice/getReport' ?>",
                data: {
                    'txtAccompagnatore': '<?php echo $accompagnatore; ?>',
                    'txtCollaboratore': '<?php echo $collaboratore; ?>',
                    'txtProdotto': '<?php echo htmlspecialchars($prodotto); ?>',
                    'txtCodiceProdotto': '<?php echo $codice_prodotto; ?>',
                    'txtPasseggero': '<?php echo htmlspecialchars($passeggero); ?>',
                    'selTipologiaPasseggero': '<?php echo $tipologia_passeggero; ?>',
                    'selGlf': '<?php echo $glf; ?>',
                    'report': true
                },
            },
            "drawCallback": function (settings, json) {
                var api = this.api();
                var rows = api.rows();
                if (typeof rows[0] != 'undefined' && rows[0].length > 0) {
                    $('.exportExcelWrapper').html('<input id="exportExcel" class="export-button btn btn-primary" type="button" value="Export" />');
                }
            },
            "columns": [
                {"data": "accompagnatore", "name": "accompagnatore"},
                {"data": "collaboratore", "name": "collaboratore"},
                {"data": "prodotto", "name": "prodotto"},
                {"data": "codice_prodotto", "name": "codice_prodotto"},
                {"data": "passeggero", "name": "passeggero"},
                {"data": "tipologia_passeggero", "name": "tipologia_passeggero"},
                {"data": "total_due", "name": "total_due"},
                {"data": "balance", "name": "balance"}
            ]
        });
        $("#backToFilter").click(function () {
            window.location.href = SITE_PATH + "webservice/report";
        });
        $("body").on('click', "#exportExcel", function () {
            var exportForm = $('<form method="post" action="' + SITE_PATH + "webservice/report" + '"></form>').appendTo('body');
            exportForm.append("<input type='hidden' name='txtAccompagnatore' value='<?php echo $accompagnatore; ?>' />");
            exportForm.append("<input type='hidden' name='txtCollaboratore' value='<?php echo $collaboratore; ?>' />");
            exportForm.append("<input type='hidden' name='txtProdotto' value='<?php echo htmlspecialchars($prodotto); ?>' />");
            exportForm.append("<input type='hidden' name='txtCodiceProdotto' value='<?php echo $codice_prodotto; ?>' />");
            exportForm.append("<input type='hidden' name='txtPasseggero' value='<?php echo htmlspecialchars($passeggero); ?>' />");
            exportForm.append("<input type='hidden' name='selTipologiaPasseggero' value='<?php echo $tipologia_passeggero; ?>' />");
            exportForm.append("<input type='hidden' name='selGlf' value='<?php echo $glf; ?>' />");
            exportForm.append("<input type='hidden' name='type' value='export' />");
            exportForm.submit();
        });
        // Code so that table structure does not fluctuate when sorting the columns
//        $.each($("table th"), function( index, value ) {
//            $(this).attr('style', 'width: '+$(this).width()+'px !important');
//        });
    });
</script>
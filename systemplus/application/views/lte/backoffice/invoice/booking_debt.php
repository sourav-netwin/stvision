<table class="table table-hovered table-bordered table-striped">
    <thead>
        <tr>
            <th>Booking ID</th>
            <th>Agent</th>
            <th>Invoices total</th>
            <th>Cashed total</th>
            <th>Overdue total</th>
            <th>Days</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $existingCurrency = "";
        if (!empty($reportData)) {
            foreach ($reportData as $report) {
                $areaCode = $report['valuta_fattura'];
                if ($existingCurrency != $areaCode) {
                    $existingCurrency = $areaCode;
                    ?>
                    <tr>
                        <th colspan="6">
                            Area <?php echo getCurrencyArea($existingCurrency); ?>
                        </th>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td><?php echo $report['id_book']; ?></td>
                    <td>
                        <a href="javascript:void(0);" class="agentsReport" data-agent-phone="<?php echo htmlentities($report['agent_phone']); ?>" data-agent-email="<?php echo htmlentities($report['agent_email']); ?>" data-agent-name="<?php echo htmlentities(ucwords($report['agent_name'])); ?>" data-agent-id="<?php echo $report['agent_id']; ?>" title="Click here to show detailed debt report of - <?php echo htmlentities(ucwords($report['agent_name'])); ?>" data-toggle="tooltip" >
                            <?php echo htmlentities(ucwords($report['agent_name'])); ?>
                        </a>
                    </td>
                    <td><?php echo customNumFormat($report['total_cost']); ?></td>
                    <td><?php echo customNumFormat($report["pfp_import"]); ?></td>
                    <td><?php echo customNumFormat($report["overdue"]); ?></td>
                    <td>
                        <?php
                        $dateFrom = date_create($report['arrival_date']);
                        $dateTo = date_create(date("Y-m-d"));
                        $diff = date_diff($dateFrom, $dateTo);
                        echo $diff->days;
                        ?></td>
                </tr>

            <?php }
        }
        ?>
    </tbody>
</table>
<script>
    var SITE_PATH = "<?php echo base_url(); ?>index.php/";
    $(document).ready(function () {
        $(".agentsReport").on('click',function(){
            var agentId = $(this).attr('data-agent-id');
            var selectedAgent = $(this).attr('data-agent-name');
            var agentPhone = $(this).attr('data-agent-phone');
            var agentEmail = $(this).attr('data-agent-email');
            $("#lblAgent").html(selectedAgent);
            $("#lblAgentEmail").html(agentEmail);
            $("#lblAgentPhone").html(agentPhone);
            $("#hiddAgentId").val(agentId);
            $("#hiddAgentName").val(selectedAgent);
            $.post(SITE_PATH + 'invoice/get_agentwise_report',{'agentId':agentId},function(data){
                $("#agentDiv").html(data);
            });
            $('#dialog_modal_agentsrpt').modal('show');
        });
    });
</script>
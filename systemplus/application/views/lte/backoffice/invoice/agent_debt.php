<table class="table table-hovered table-bordered table-striped">
    <thead>
        <tr>
            <th>Booking ID</th>
            <th>Arrival date</th>
            <th>Campus</th>
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
                        <th colspan="7">
                            Area <?php echo getCurrencyArea($existingCurrency); ?>
                        </th>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td><?php echo $report['id_book']; ?></td>
                    <td><?php echo date("d/m/Y", strtotime($report['arrival_date'])); ?></td>
                    <td>
                        <?php echo htmlentities(ucwords($report['nome_centri'])); ?>
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
                        ?>
                    </td>
                </tr>

            <?php }
        }
        ?>
    </tbody>
</table>

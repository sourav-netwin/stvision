<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>N.</th>
            <th>Company</th>
            <th>Bus</th>
            <th>Qty</th>
            <th>Price per bus</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $counter = 1;
            if (!empty($coaches)) 
            {
                foreach($coaches as $bus)
                {
        ?>
                    <tr<?php if($counter % 2){ ?> style="background-color:#eee;"<?php } ?>>
                        <td><?php echo $counter ?></td>
                        <td><font style="color:#222;font-weight:bold;"><?php echo $bus["tra_cp_name"] ?></font><br />Phone: <?php echo $bus["tra_cp_phone"] ?></td>
                        <td><?php echo $bus["tra_bus_name"] ?><br /><?php echo $bus["tra_bus_seat"] ?> seats</td>
                        <td><?php echo $bus["pbe_qtybus"] ?></td>
                        <td><?php echo $bus["pbe_jnprice"] ?> <?php echo $bus["pbe_jncurrency"] ?></td>
                    </tr>
        <?php
                $counter++;
                }
            }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>N.</th>
            <th>Company</th>
            <th>Bus</th>
            <th>Qty</th>
            <th>Price per bus</th>
        </tr>
    </tfoot>
</table>
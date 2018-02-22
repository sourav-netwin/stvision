<table style="width:750px;">
	<thead>
	<tr>
		<th style="text-align:left;">N.</th>
		<th style="text-align:left;">Company</th>
		<th style="text-align:left;">Bus</th>
		<th style="text-align:left;">Qty</th>
		<th style="text-align:left;">Price per bus</th>
	</tr>
	</thead>
	<tbody>
<?php
	$counter = 1;
	foreach($coaches as $bus){
?>
	<tr<?php if($counter % 2){ ?> style="background-color:#eee;"<?php } ?>>
		<td style="padding:4px;width:30px;vertical-align:middle;"><?php echo $counter ?></td>
		<td style="padding:4px;vertical-align:middle;"><font style="color:#222;font-weight:bold;"><?php echo $bus["tra_cp_name"] ?></font><br />Phone: <?php echo $bus["tra_cp_phone"] ?></td>
		<td style="padding:4px;vertical-align:middle;"><?php echo $bus["tra_bus_name"] ?><br /><?php echo $bus["tra_bus_seat"] ?> seats</td>
		<td style="padding:4px;width:30px;vertical-align:middle;"><?php echo $bus["pbe_qtybus"] ?></td>
		<td style="padding:4px;width:100px;vertical-align:middle;"><?php echo $bus["pbe_jnprice"] ?><?php echo $bus["pbe_jncurrency"] ?></td>
	</tr>
<?php
	$counter++;
	}
?>
	</tbody>
</table>
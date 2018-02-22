<table style="width:750px;">
	<thead>
	<tr>
		<th style="text-align:left;">N.</th>
		<th style="text-align:left;">Book ID</th>
		<th style="text-align:left;">Agency</th>
		<th>Pax Type</th>
		<th style="text-align:left;">Pax</th>
	</tr>
	</thead>
	<tbody>
<?php
	$counter = 1;
	foreach($all_all as $mypax){
?>
	<tr<?php if($counter % 2){ ?> style="background-color:#eee;"<?php } ?>>
		<td style="padding:4px;width:30px;vertical-align:middle;"><?php echo $counter ?></td>
		<td style="padding:4px;width:80px;vertical-align:middle;"><?php echo $mypax["bookID"] ?></td>
		<td style="padding:4px;width:150px;vertical-align:middle;"><?php echo $mypax["businessname"] ?></td>
		<td class="center" style="padding:4px;width:80px;text-transform:capitalize;vertical-align:middle;"><?php echo $mypax["tipo_pax"] ?></td>
		<td style="padding:4px;vertical-align:middle;"><?php echo $mypax["pax"] ?></td>
	</tr>
<?php
	$counter++;
	}
?>
	</tbody>
</table>
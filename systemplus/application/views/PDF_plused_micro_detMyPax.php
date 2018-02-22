<table style="width:2000px;">
	<thead>
	<tr>
		<th style="text-align:left;">N.</th>
		<th>Type</th>
		<th style="text-align:left;">Accomodation</th>
		<th style="text-align:left;">Surname</th>
		<th style="text-align:left;">Name</th>
		<th>Sex</th>
		<th>Date of birth</th>
		<th>Allergies</th>
		<th>Document number</th>
		<th>Referring GL</th>
		<th>Share room with</th>
		<th>Arrival Date</th>
		<th>Arrival Flight Info</th>
		<th>Departure Date</th>
		<th>Departure Flight Info</th>
	</tr>
	</thead>
	<tbody>
<?php
	$counter = 1;
	foreach($detMyPax as $mypax){
?>
	<tr<?php if($counter % 2){ ?> style="background-color:#eee;"<?php } ?>>
		<td style="padding:4px;width:20px;vertical-align:middle;"><?php echo $counter ?></td>
		<td class="center" style="padding:4px;width:30px;vertical-align:middle;"><?php echo $mypax["tipo_pax"] ?></td>
		<td style="padding:4px;width:80px;text-transform:capitalize;vertical-align:middle;"><?php echo $mypax["accomodation"] ?></td>
		<td style="padding:4px;width:100px;vertical-align:middle;"><?php echo $mypax["cognome"] ?></td>
		<td style="padding:4px;width:100px;vertical-align:middle;"><?php echo $mypax["nome"] ?></td>
		<td class="center" style="padding:4px;width:30px;vertical-align:middle;"><?php echo $mypax["sesso"] ?></td>
		<td class="center" style="padding:4px;width:80px;vertical-align:middle;"><?php echo date("d/m/Y", strtotime($mypax["pax_dob"])) ?></td>
		<td style="padding:4px;vertical-align:middle;"><?php echo $mypax["salute"] ?></td>
		<td style="padding:4px;width:80px;vertical-align:middle;"><?php echo $mypax["numero_documento"] ?></td>
		<td style="padding:4px;width:200px;vertical-align:middle;"><?php echo $mypax["gl_rif"] ?></td>
		<td style="padding:4px;width:200px;vertical-align:middle;"><?php echo $mypax["share_room"] ?></td>
		<td class="center" style="padding:4px;width:80px;vertical-align:middle;"><?php echo date("d/m/Y",strtotime($mypax["andata_data_arrivo"])) ?></td>
		<td class="center" style="padding:4px;width:200px;vertical-align:middle;">Flight <strong><?php echo $mypax["andata_volo"] ?></strong><br /><?php echo date("H:i", strtotime($mypax["andata_data_arrivo"])) ?> at <strong><?php echo $mypax["andata_apt_arrivo"] ?></strong> from <?php echo $mypax["andata_apt_partenza"] ?></td>
		<td class="center" style="padding:4px;width:80px;vertical-align:middle;"><?php echo date("d/m/Y",strtotime($mypax["ritorno_data_partenza"])) ?></td>
		<td class="center" style="padding:4px;width:200px;vertical-align:middle;">Flight <strong><?php echo $mypax["ritorno_volo"] ?></strong><br /><?php echo date("H:i", strtotime($mypax["ritorno_data_partenza"])) ?> from <strong><?php echo $mypax["ritorno_apt_partenza"] ?></strong> at <?php echo $mypax["ritorno_apt_arrivo"] ?></td>		
	</tr>
<?php
	$counter++;
	}
?>
	</tbody>
</table>
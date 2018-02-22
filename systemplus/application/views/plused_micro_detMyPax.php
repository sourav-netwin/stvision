<table style="width:2200px;">
	<thead>
	<tr>
		<th style="padding:4px;text-align:left;">N.</th>
		<th style="padding:4px;text-align:left;">Book ID</th>
		<!--<th style="padding:4px;text-align:left;">Agency</th>-->
		<th style="padding:4px;text-align:left;">Type</th>
		<th style="padding:4px;text-align:left;">Accomodation</th>
		<th style="padding:4px;text-align:left;">Surname</th>
		<th style="padding:4px;text-align:left;">Name</th>
		<th>Sex</th>
		<th style="padding:4px;text-align:center;">Date of birth</th>
		<th style="padding:4px;text-align:left;">Allergies</th>
		<th style="padding:4px;text-align:left;">Document number</th>
		<th style="padding:4px;text-align:left;">Referring GL</th>
		<th style="padding:4px;text-align:left;">Share room with</th>
		<th style="padding:4px;text-align: center">Campus Arrival Date</th>
		<th style="padding:4px;text-align: center">Arrival Flight Info</th>
		<th style="padding:4px;text-align: center">Campus Departure Date</th>
		<th style="padding:4px;text-align: center">Departure Flight Info</th>
		<?php if($supl == 'all_list'){
			?>
		<th style="padding:4px;text-align:left;">Supplement Bought by the pax</th>
		<?php
		} ?>
		
	</tr>
	</thead>
	<tbody>
<?php
	$counter = 1;
	foreach($detMyPax as $mypax){
?>
	<tr<?php if($counter % 2){ ?> style="background-color:#eee;"<?php } ?>>
		<td style="padding:4px;width:20px;vertical-align:middle;"><?php echo $counter ?></td>
		<td style="padding:4px;width:70px;vertical-align:middle;"><?php echo $mypax["bookid"] ?></td>
		<!--<td style="padding:4px;width:130px;vertical-align:middle;"><?php /*echo $mypax["businessname"]*/ ?></td>-->
		<td class="" style="padding:4px;width:45px;vertical-align:middle;"><?php echo $mypax["tipo_pax"] ?></td>
		<td style="padding:4px;width:95px;text-transform:capitalize;vertical-align:middle;"><?php echo $mypax["accomodation"] ?></td>
		<td style="padding:4px;width:100px;vertical-align:middle;"><?php echo $mypax["cognome"] ?></td>
		<td style="padding:4px;width:100px;vertical-align:middle;"><?php echo $mypax["nome"] ?></td>
		<td class="center" style="padding:4px;width:30px;vertical-align:middle;"><?php echo $mypax["sesso"] ?></td>
		<td class="center" style="padding:4px;width:80px;vertical-align:middle;"><?php echo date("d/m/Y", strtotime($mypax["pax_dob"])) ?></td>
		<td style="padding:4px;vertical-align:middle;"><?php echo $mypax["salute"] ?></td>
		<td style="padding:4px;width:80px;vertical-align:middle;"><?php echo $mypax["numero_documento"] ?></td>
		<td style="padding:4px;width:200px;vertical-align:middle;"><?php echo $mypax["gl_rif"] ?></td>
		<td style="padding:4px;width:200px;vertical-align:middle;"><?php echo $mypax["share_room"] ?></td>
		<td class="center" style="padding:4px;width:80px;vertical-align:middle;"><?php echo date("d/m/Y",strtotime($mypax["data_arrivo_campus"])) ?></td>
		<td class="center" style="padding:4px;width:200px;vertical-align:middle;">Flight <strong><?php echo $mypax["andata_volo"] ?></strong> - <?php echo date("d/m/Y", strtotime($mypax["andata_data_arrivo"])) ?><br /><?php echo date("H:i", strtotime($mypax["andata_data_arrivo"])) ?> at <strong><?php echo $mypax["andata_apt_arrivo"] ?></strong> from <?php echo $mypax["andata_apt_partenza"] ?></td>
		<td class="center" style="padding:4px;width:80px;vertical-align:middle;"><?php echo date("d/m/Y",strtotime($mypax["data_partenza_campus"])) ?></td>
		<td class="center" style="padding:4px;width:200px;vertical-align:middle;">Flight <strong><?php echo $mypax["ritorno_volo"] ?></strong> - <?php echo date("d/m/Y", strtotime($mypax["ritorno_data_partenza"])) ?><br /><?php echo date("H:i", strtotime($mypax["ritorno_data_partenza"])) ?> from <strong><?php echo $mypax["ritorno_apt_partenza"] ?></strong> at <?php echo $mypax["ritorno_apt_arrivo"] ?></td>
		<?php if($supl == 'all_list'){
			?>
		<td style="padding:4px;width:200px;vertical-align:middle;"><?php echo $mypax["description"] ?></td>
		<?php
		} ?>
	</tr>
<?php
	$counter++;
	}
?>
	</tbody>
</table>
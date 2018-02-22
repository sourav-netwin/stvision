<table id="det_my_dt" class="campus_table datatable table table-bordered table-striped">
	<thead>
		<tr>
			<th>N.</th>
			<th>Book id</th>
			<th>Type</th>
			<th>Accomodation</th>
			<th>Surname</th>
			<th>Name</th>
			<th>Sex</th>
			<th>Date of birth</th>
			<th>Allergies</th>
			<th>Document number</th>
			<th>Referring GL</th>
			<th>Share room with</th>
			<th>Campus arrival date</th>
			<th>Arrival flight info</th>
			<th>Campus departure date</th>
			<th>Departure flight info</th>
			<?php if($supl == 'all_list'){ ?>
				<th>Supplement bought by the pax</th>
			<?php } ?>		
		</tr>
	</thead>
	<tbody>
	<?php 
		$counter = 1;
		foreach($detMyPax as $mypax)
		{
	?>
			<tr<?php if($counter % 2){ ?> style="background-color:#eee;"<?php } ?>>
				<td><?php echo $counter ?></td>
				<td><?php echo $mypax["bookid"] ?></td>
				<td><?php echo $mypax["tipo_pax"] ?></td>
				<td style="text-transform: capitalize;"><?php echo $mypax["accomodation"] ?></td>
				<td><?php echo $mypax["cognome"] ?></td>
				<td><?php echo $mypax["nome"] ?></td>
				<td><?php echo $mypax["sesso"] ?></td>
				<td><?php echo date("d/m/Y", strtotime($mypax["pax_dob"])) ?></td>
				<td><?php echo $mypax["salute"] ?></td>
				<td><?php echo $mypax["numero_documento"] ?></td>
				<td><?php echo $mypax["gl_rif"] ?></td>
				<td><?php echo $mypax["share_room"] ?></td>
				<td><?php echo date("d/m/Y",strtotime($mypax["data_arrivo_campus"])) ?></td>
				<td>Flight <strong><?php echo $mypax["andata_volo"] ?></strong> - <?php echo date("d/m/Y", strtotime($mypax["andata_data_arrivo"])) ?><br /><?php echo date("H:i", strtotime($mypax["andata_data_arrivo"])) ?> at <strong><?php echo $mypax["andata_apt_arrivo"] ?></strong> from <?php echo $mypax["andata_apt_partenza"] ?></td>
				<td><?php echo date("d/m/Y",strtotime($mypax["data_partenza_campus"])) ?></td>
				<td>Flight <strong><?php echo $mypax["ritorno_volo"] ?></strong> - <?php echo date("d/m/Y", strtotime($mypax["ritorno_data_partenza"])) ?><br /><?php echo date("H:i", strtotime($mypax["ritorno_data_partenza"])) ?> from <strong><?php echo $mypax["ritorno_apt_partenza"] ?></strong> at <?php echo $mypax["ritorno_apt_arrivo"] ?></td>
				<?php if($supl == 'all_list'){ ?>
					<td><?php echo $mypax["description"] ?></td>
				<?php } ?>
			</tr>
	<?php
			$counter++;
		}
	?>
	</tbody>
</table>
<script>
// initDataTable("det_my_dt");
</script>
<table class="table table-bordered table-striped">
	<thead>
	<tr>
		<th >N.</th>
		<th >Book ID</th>
		<th >Agency</th>
		<th>Pax Type</th>
		<th >Pax</th>
	</tr>
	</thead>
	<tbody>
<?php
	$counter = 1;
	foreach($all_all as $mypax){
?>
	<tr>
		<td ><?php echo $counter ?></td>
		<td ><?php echo $mypax["bookID"] ?></td>
		<td ><?php echo $mypax["businessname"] ?></td>
		<td class="text-center" style="text-transform:capitalize;vertical-align:middle;"><?php echo $mypax["tipo_pax"] ?></td>
		<td style="vertical-align:middle;"><?php echo $mypax["pax"] ?></td>
	</tr>
<?php
	$counter++;
	}
?>
	</tbody>
</table>
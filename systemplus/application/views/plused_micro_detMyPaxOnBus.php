<table style="width:750px;">
	 <caption>
	  Bus code: <strong><?php echo $codebus?> for <?php echo $tipo?> transfer</strong>
	  <details style="margin-bottom:20px;">
	   <?php 
	   if($tipo=="inbound"){
	   ?>
	   Inbound transfer from <?php echo ( $allPaxOnBus ) ? $allPaxOnBus[0]["ptt_airport_to"] : "" ?> airport - Flight number: <?php echo ( $allPaxOnBus ) ? $allPaxOnBus[0]["ptt_flight"] : "" ?> @ <?php echo ( $allPaxOnBus ) ? date("d/m/Y H:i",strtotime($allPaxOnBus[0]["ptt_dataora"])) : "" ?>
	   <?php }else{ ?>
	   Outbound transfer to <?php echo ( $allPaxOnBus ) ? $allPaxOnBus[0]["ptt_airport_from"] : "" ?> - Flight number: <?php echo ( $allPaxOnBus ) ? $allPaxOnBus[0]["ptt_flight"] : "" ?> @ <?php echo ( $allPaxOnBus ) ? date("d/m/Y H:i",strtotime($allPaxOnBus[0]["ptt_dataora"])) : "" ?>
	   <?php
	   }
	   ?>
	  </details>
	 </caption>
	<thead>
	<tr>
		<th style="text-align:left;">N.</th>
		<th style="text-align:left;">Book id</th>
		<th style="text-align:left;">Agency</th>
		<th>Pax type</th>
		<th style="text-align:left;">Pax</th>
	</tr>
	</thead>
	<tbody>
<?php
	$counter = 1;
	foreach($allPaxOnBus as $mypax){
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
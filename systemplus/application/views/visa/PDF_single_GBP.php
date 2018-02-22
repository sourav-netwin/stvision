<!DOCTYPE html>
<html>
	<head>
		<style>
			*{margin:0;padding:0;font-size:8pt;font-family:sans-serif,Arial;}
			body{margin:0;}
			table.grande{margin-left: auto; margin-right: auto;width:540pt;background-color:#fff;border-collapse:collapse;margin-top:20px;page-break-after:always;}
			table.detaila{width:100%;margin:0;padding:0;border-collapse:collapse;margin-left:10px;page-break-inside:auto}
			table.detaila tr{ page-break-inside:avoid; page-break-after:auto }
			table.detaila td{border:1px solid #000;}
			table.detaila td span{margin:4px;line-height:1.6em;}
			table.grande2{margin-left: auto; margin-right: auto;width:540pt;background-color:#fff;border-collapse:collapse;margin-top:20px;page-break-before:always;}
		</style>
	</style>
</head>
<?php
$campi = $booking_detail[0];
$agency = $agency[0];
//print_r($detSTD);
?>
<body>
	
	<?php
	if ($det[0]['tipo_pax'] == "GL") {
		foreach ($det as $single) {
			if ($single["cognome"] != "") {
				?>
				<table cellpadding="0" cellspacing="0" class="grande">
					<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/top_visas.gif" border="0" /></td></tr>	
					<tr><td style="text-align:right;">London, <?php echo date("d M Y"); ?></td></tr>
					<tr><td style="height:20px;">&nbsp;</td></tr>
					<tr>
						<td align="center"><b style="font-size:11pt;">To whom it may concern,</b></td>
					</tr>
					<tr><td style="height:20px;">&nbsp;</td></tr>
					<tr>
						<td>This is to confirm that <?php echo $single["nome"] ?> <?php echo $single["cognome"] ?>, born on the <?php echo date("d/m/Y", strtotime($single["pax_dob"])); ?>, Passport no. <?php echo $single["numero_documento"] ?> is accompanying a Group of students participating in an English Language Course taking place at <?php echo $campi["school_name"]; ?>.<br /><br />From:	<?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?>      To: <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?><br /><br />Address: <?php echo $campi["school_name"]; ?><br /><br />The course is inclusive of full board accommodation, English Lessons (15 hours a week) and an afternoon, evening and weekend Leisure Programmes. The payment is being made.<br /><br />Type of visa: General Visitor<br /><br />Group Leaders are responsible for students’ participation in the activities.<br /><br />Plus is accredited by ABLS and the British Council.<br /><br />Yours sincerely,<br /><em>Stefano Marra<br /><img src="http://www.plus-ed.com/vision_ag/img/firma_stefano_marra.gif" border="0" /></em></td>
					</tr>		
				</table>
				<?php
			}
		}
	}
	else {
		foreach ($det as $single) {
			if ($single["cognome"] != "") {
				?>
				<table cellpadding="0" cellspacing="0" class="grande">
					<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/top_visas.gif" border="0" /></td></tr>	
					<tr><td style="text-align:right;">London, <?php echo date("d M Y"); ?></td></tr>
					<tr><td style="height:20px;">&nbsp;</td></tr>
					<tr>
						<td align="center"><b style="font-size:11pt;">To whom it may concern,</b></td>
					</tr>
					<tr><td style="height:20px;">&nbsp;</td></tr>
					<tr>
						<td>This is to confirm that <?php echo $single["nome"] ?> <?php echo $single["cognome"] ?>, born on the <?php echo date("d/m/Y", strtotime($single["pax_dob"])); ?>, Passport no. <?php echo $single["numero_documento"] ?>, is part of a group of students participating in an English Language Course taking place at <?php echo $campi["school_name"]; ?>.<br /><br />From:	<?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?>      To: <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?><br /><br />Address: <?php echo $campi["school_name"]; ?><br /><br />The course is inclusive of full board accommodation, English Lessons (15 hours a week) and an afternoon, evening and weekend Leisure Programmes. The payment is being made.<br /><br />Type of visa: Child Visitor<br /><br />Group Leaders are responsible for students’ participation in the activities.<br /><br />Plus is accredited by ABLS and the British Council.<br /><br />Yours sincerely,<br /><em>Stefano Marra<br /><img src="http://www.plus-ed.com/vision_ag/img/firma_stefano_marra.gif" border="0" /></em></td>
					</tr>		
				</table>
				<?php
			}
		}
	}
	?>	
</body>
</html>
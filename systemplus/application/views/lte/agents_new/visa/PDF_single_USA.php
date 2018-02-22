<!DOCTYPE html>
<html>
	<head>
		<title>USA</title>
		<style>
			*{margin:0;padding:0;font-size:8pt;font-family:sans-serif,Arial;}
			body{margin:0;}
			table.grande{margin-left: auto; margin-right: auto;width:540pt;background-color:#fff;border-collapse:collapse;margin-top:20px;}
			table.detaila{width:100%;margin:0;padding:0;border-collapse:collapse;margin-left:10px;page-break-inside:auto}
			table.detaila tr{ page-break-inside:avoid; page-break-after:auto }
			table.detaila td{border:1px solid #000;}
			table.detaila td span{margin:4px;line-height:1.6em;}
			table.grande2{margin-left: auto; margin-right: auto;width:540pt;background-color:#fff;border-collapse:collapse;margin-top:20px;page-break-before:always;}
			.pdf-footer { position: absolute; left: 0px; right: 0px; bottom: 0px; text-align: center; color: #005dc7; font-weight: bold }
			.pdf-footer p:last-child{ height: 40px; background-color: #005dc7; color: #fff !important; padding-top: 10px }
		</style>
	</style>
</head>
<body>
	<?php
	if ($pax_detail['booked_tipo_pax'] == "GL") {
		if ($pax_detail["booked_pax_surname"] != "") {
			?>
			<table cellpadding="0" cellspacing="0" class="grande">
				<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/top_visas.gif" border="0" /></td></tr>
				<tr><td style="text-align:right;">London, <?php echo $pax_detail['booked_template_date'] ? date("d M Y", strtotime($pax_detail['booked_template_date'])) : date("d M Y"); ?></td></tr>
				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr>
					<td align="center"><b style="font-size:11pt;">To whom it may concern,</b></td>
				</tr>
				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr>
					<td>This is to confirm that <?php echo $pax_detail["booked_pax_name"] ?> <?php echo $pax_detail["booked_pax_surname"] ?>, born on the <?php echo date("d/m/Y", strtotime($pax_detail["booked_pax_dob"])); ?>, Passport no. <?php echo $pax_detail["booked_pax_passport_no"] ?> is accompanying a Group of students participating in an English Language Course taking place at <?php echo $booking_detail["nome_centri"]; ?>.<br /><br />From:	<?php echo date("d/m/Y", strtotime($booking_detail["enrol_arrival_date"])); ?>      To: <?php echo date("d/m/Y", strtotime($booking_detail["enrol_departure_date"])); ?><br /><br />Address: <?php echo $booking_detail["nome_centri"]; ?><br /><br />The course is inclusive of full board accommodation, English Lessons (15 hours a week) and an afternoon, evening and weekend Leisure Programmes.<br /><br />Type of visa: General Visitor<br /><br />Group Leaders are responsible for students’ participation in the activities.<br /><br />Plus is accredited by ABLS and the British Council.<br /><br />Yours sincerely,<br /><em>Stefano Marra<br /><img src="http://www.plus-ed.com/vision_ag/img/firma_stefano_marra.gif" border="0" /></em></td>
				</tr>
			</table>
			<?php
		}
	}
	elseif ($pax_detail['booked_tipo_pax'] == "STD") {
		if ($pax_detail["booked_pax_surname"] != "") {
			?>
			<table cellpadding="0" cellspacing="0" class="grande">
				<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/top_visas.gif" border="0" /></td></tr>
				<tr><td style="text-align:right;">London, <?php echo $pax_detail['booked_template_date'] ? date("d M Y", strtotime($pax_detail['booked_template_date'])) : date("d M Y"); ?></td></tr>
				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr>
					<td align="center"><b style="font-size:11pt;">To whom it may concern,</b></td>
				</tr>
				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr>
					<td>This is to confirm that <?php echo $pax_detail["booked_pax_name"] ?> <?php echo $pax_detail["booked_pax_surname"] ?>, born on the <?php echo date("d/m/Y", strtotime($pax_detail["booked_pax_dob"])); ?>, Passport no. <?php echo $pax_detail["booked_pax_passport_no"] ?>, is part of a group of students participating in an English Language Course taking place at <?php echo $booking_detail["nome_centri"]; ?>.<br /><br />From:	<?php echo date("d/m/Y", strtotime($booking_detail["enrol_arrival_date"])); ?>      To: <?php echo date("d/m/Y", strtotime($booking_detail["enrol_departure_date"])); ?><br /><br />Address: <?php echo $booking_detail["nome_centri"]; ?><br /><br />The course is inclusive of full board accommodation, English Lessons (15 hours a week) and an afternoon, evening and weekend Leisure Programmes.<br /><br />Type of visa: Child Visitor<br /><br />Group Leaders are responsible for students’ participation in the activities.<br /><br />Plus is accredited by ABLS and the British Council.<br /><br />Yours sincerely,<br /><em>Stefano Marra<br /><img src="http://www.plus-ed.com/vision_ag/img/firma_stefano_marra.gif" border="0" /></em></td>
				</tr>
			</table>
			<?php
		}
	}
	?>

</body>
</html>
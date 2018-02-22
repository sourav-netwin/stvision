<!DOCTYPE html>
<html>
	<head>
		<style>
			@page { margin: 180px 50px; }
			*{margin:0;padding:0;font-size:8pt;font-family:sans-serif,Arial;}
			body{margin:0;}
			table.grande{margin-left: auto; margin-right: auto;width:540pt;background-color:#fff;border-collapse:collapse;margin-top:20px;}
			table.detaila{width:100%;margin:0;padding:0;border-collapse:collapse;margin-left:10px;page-break-inside:auto}
			table.detaila tr{ page-break-inside:avoid; page-break-after:auto }
			table.detaila td{border:1px solid #000;}
			table.detaila td span{margin:4px;line-height:1.6em;}
			table.grande2{margin-left: auto; margin-right: auto;width:540pt;background-color:#fff;border-collapse:collapse;margin-top:20px;page-break-before:always;}
			.pdf-footer { position: absolute; left: 0px; right: 0px; bottom: 0px; page-break-after:always; text-align: center; color: #005dc7; font-weight: bold }
			.pdf-footer:last-child { page-break-after: avoid; }
			.pdf-footer p:last-child{ height: 40px; background-color: #005dc7; color: #fff !important; padding-top: 10px }
		</style>
	</style>
</head>
<?php
$campi = $booking_detail[0];
$agency = $agency[0];
//print_r($detSTD);
?>
<body>
	<table cellpadding="0" cellspacing="0" class="grande">
		<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/top_visas.gif" border="0" /></td></tr>	
		<tr><td style="text-align:right;">London, <?php echo date("d M Y"); ?></td></tr>
		<tr><td style="height:20px;">&nbsp;</td></tr>
		<tr>
			<td align="center"><b style="font-size:11pt;">To whom it may concern</b></td>
		</tr>
		<tr>
			<td>This is to confirm that the following students and group leader(s) from <?php echo $agency["businessname"] . ', ' . $agency["businesscountry"]; ?> are part of a group enrolling on an English language short course programme for <?php echo $campi["weeks"] <= 1 ? $campi["weeks"] . ' week' : $campi["weeks"] . ' weeks'; ?>, from <?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?> to <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?> , taking place at  <?php echo $campi["school_name"] . ', ' . $campi["located_in"]; ?>.
			</td>
		</tr>		
		<tr><td style="height:20px;">&nbsp;</td></tr>
		<tr>
			<td style="text-align:center;">
				<table class="detaila">
					<tr>
						<td><span>No</span></td>
						<td><span>Name</span></td>
						<td><span>Surname</span></td>
						<td><span>Gender</span></td>
						<td><span>DOB</span></td>
						<td><span>Passport No</span></td>
						<td><span>Country Issued</span></td>
					</tr>
					<?php
					$contaSTD = 1;
					foreach ($detSTD as $STD) {
						?>
						<tr>
							<td><span><?php echo $contaSTD ?></span></td>
							<td><span><?php echo $STD["nome"] ?></span></td>
							<td><span><?php echo $STD["cognome"] ?></span></td>
							<td><span><?php echo $STD["sesso"] ?></span></td>
							<td><span><?php echo date("d/m/Y", strtotime($STD["pax_dob"])); ?></span></td>
							<td><span><?php echo $STD["numero_documento"] ?></span></td>
							<td><span>--</span></td>
						</tr>					
						<?php
						$contaSTD++;
					}
					?>
				</table>
			</td>
		</tr>
		<tr><td style="height:20px;">&nbsp;</td></tr>
		<tr>
			<td>Group Leaders:</td>
		</tr>		
		<tr><td style="height:20px;">&nbsp;</td></tr>
		<tr>
			<td style="text-align:center;">
				<table class="detaila">
					<tr>
						<td><span>No</span></td>
						<td><span>Name</span></td>
						<td><span>Surname</span></td>
						<td><span>Gender</span></td>
						<td><span>DOB</span></td>
						<td><span>Passport No</span></td>
						<td><span>Country Issued</span></td>
					</tr>
					<?php
					$contaSTD = 1;
					foreach ($detGL as $STD) {
						?>
						<tr>
							<td><span><?php echo $contaSTD ?></span></td>
							<td><span><?php echo $STD["nome"] ?></span></td>
							<td><span><?php echo $STD["cognome"] ?></span></td>
							<td><span><?php echo $STD["sesso"] ?></span></td>
							<td><span><?php echo date("d/m/Y", strtotime($STD["pax_dob"])); ?></span></td>
							<td><span><?php echo $STD["numero_documento"] ?></span></td>
							<td><span>--</span></td>
						</tr>					
	<?php
	$contaSTD++;
}
?>
				</table>
			</td>
		</tr>	
		<tr><td style="height:20px;">&nbsp;</td></tr>
		<tr>
			<td>Upon arrival date, <?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?> students and group leaders will be met by a Plus Representative at the Airport and transferred to <?php echo $campi["school_name"]; ?>. This transfer has been arranged and organised by Plus Ltd.<br /><br />Students and group leaders will be met at <?php echo $campi["school_name"]; ?> by the residential campus manager and be allocated a room.<br /><br /></td>
		</tr>
		<tr>
			<td>The programme is inclusive of full - board accommodation, English lessons (15 hours lessons a week) and an afternoon, evening and weekend leisure programmes.<br /><br />From Monday to Friday the students will have English lessons in the mornings and some afternoons. There are planned afternoon and evening activities and weekend excursions. All activities will be supervised by the group leaders and the PLUS residential staff.<br /><br /></td>
		</tr>
		<tr>
			<td>There is a PLUS emergency mobile number which is available 24 / 7. The number is 07956 218 226.<br /><br /><br /><strong>Accommodation address:</strong><br /><?php echo $campi["school_name"]; ?><br /><br />Departure date is <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?>, students and group leaders will be transferred from <?php echo $campi["school_name"]; ?> to the airport. This transfer has been arranged and organised by PLUS Ltd.<br /><br /></td>
		</tr>
		<tr>
			<td>Visa type for students: Child Visitor<br /><br />Visa type for group leaders: General Visitor<br /><br />Plus UK summer courses are accredited by the British Council and ABLS.<br /><br />Yours sincerely, <br /><em>Stefano Marra<br />Managing Director<br /><img src="http://www.plus-ed.com/vision_ag/img/firma_stefano_marra.gif" border="0" /></em>
			</td>
		</tr>

	</table>
	<div class="pdf-footer">
		<p class="page">Plus-8-10 Grosvenor Gardens, Mezzanine floor, London, SW1W 0DH-P: +44(0)20 7730 2223 - F: +44 (0)20 7730 9209 - E: info@plus-ed.com </p>
		<p>
			Registered Office: 8-10 Grosvenor Gardens, London SW1W 0DH - Reg. No. 2965176 - www.plus-ed.com 
		</p>
	</div>
<?php
foreach ($detGL as $single) {
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
					<td>This is to confirm that <?php if ($single["sesso"] == 'M') {
			echo 'MR ';
		}
		elseif ($single["sesso"] == 'F') {
			echo 'MS ';
		}
		else {
			echo 'MR/MS';
		} ?><?php echo $single["nome"] ?> <?php echo $single["cognome"] ?>, born on the <?php echo date("d/m/Y", strtotime($single["pax_dob"])); ?>, Passport no. <?php echo $single["numero_documento"] ?> is accompanying a group of students participating in an English language course for <?php echo $campi["weeks"] <= 1 ? $campi["weeks"] . ' week' : $campi["weeks"] . ' weeks'; ?>, taking place at <?php echo $campi["school_name"] . ', ' . $campi["located_in"]; ?>.<br /><br />From:	<?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?>      To: <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?><br /><br />Campus address: <?php echo $campi["school_name"]; ?><br /><br />The course is inclusive of full board accommodation, English lessons (15 hours a week) and an afternoon, evening and weekend leisure programme. The payment is being made. <br /><br />Type of visa: General Visitor<br /><br />Group Leaders are responsible for students’ participation in the activities.<br /><br />Plus UK summer courses are accredited by the British Council and ABLS.<br /><br />Yours sincerely,<br /><em>Stefano Marra<br />Managing Director<br /><img src="http://www.plus-ed.com/vision_ag/img/firma_stefano_marra.gif" border="0" /></em></td>
				</tr>		
			</table>
	<div class="pdf-footer">
		<p class="page">Plus-8-10 Grosvenor Gardens, Mezzanine floor, London, SW1W 0DH-P: +44(0)20 7730 2223 - F: +44 (0)20 7730 9209 - E: info@plus-ed.com </p>
		<p>
			Registered Office: 8-10 Grosvenor Gardens, London SW1W 0DH - Reg. No. 2965176 - www.plus-ed.com 
		</p>
	</div>
		<?php
	}
}
?>	
	<?php
	foreach ($detSTD as $single) {
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
					<td>This is to confirm that <?php if ($single["sesso"] == 'M') {
			echo 'MR ';
		}
		elseif ($single["sesso"] == 'F') {
			echo 'MS ';
		}
		else {
			echo 'MR/MS';
		} ?><?php echo $single["nome"] ?> <?php echo $single["cognome"] ?>, born on the <?php echo date("d/m/Y", strtotime($single["pax_dob"])); ?>, Passport no. <?php echo $single["numero_documento"] ?>, is part of a group of students participating in an English language course for <?php echo $campi["weeks"] <= 1 ? $campi["weeks"] . ' week' : $campi["weeks"] . ' weeks'; ?>, taking place at <?php echo $campi["school_name"] . ', ' . $campi["located_in"]; ?>.<br /><br />From:	<?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?>      To: <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?><br /><br />Campus address: <?php echo $campi["school_name"]; ?><br /><br />The course is inclusive of full board accommodation, English lessons (15 hours a week) and an afternoon, evening and weekend leisure programme. The payment is being made. <br /><br />Type of visa: Child Visitor<br /><br />Group leaders are responsible for students’ participation in the activities.<br /><br />Plus UK summer courses are accredited by the British Council and ABLS.<br /><br />Yours sincerely,<br /><em>Stefano Marra<br />Managing Director<br /><img src="http://www.plus-ed.com/vision_ag/img/firma_stefano_marra.gif" border="0" /></em></td>
				</tr>		
			</table>
	<div class="pdf-footer">
		<p class="page">Plus-8-10 Grosvenor Gardens, Mezzanine floor, London, SW1W 0DH-P: +44(0)20 7730 2223 - F: +44 (0)20 7730 9209 - E: info@plus-ed.com </p>
		<p>
			Registered Office: 8-10 Grosvenor Gardens, London SW1W 0DH - Reg. No. 2965176 - www.plus-ed.com 
		</p>
	</div>
		<?php
	}
}
?>	
</body>
</html>
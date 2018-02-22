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
	<table cellpadding="0" cellspacing="0" class="grande">
		<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/top_visas.gif" border="0" /></td></tr>	
		<tr><td style="text-align:right;">London, <?php echo date("d M Y"); ?></td></tr>
		<tr><td style="height:20px;">&nbsp;</td></tr>
		<tr>
			<td align="center"><b style="font-size:11pt;">To whom it may concern,</b></td>
		</tr>
		<tr>
			<td>This is to confirm that the following students and group leaders from <?php echo $agency["businessname"]; ?> are part of a group enrolling on an English Language Short Course Programme for <?php echo $campi["weeks"]; ?> weeks from <?php echo date("d/m/Y",strtotime($campi["arrival_date"])); ?> to <?php echo date("d/m/Y",strtotime($campi["departure_date"])); ?> , taking place at  <?php echo $campi["centro_name"]; ?>.
			</td>
		</tr>		
		<tr><td style="height:20px;">&nbsp;</td></tr>
		<tr>
			<td style="text-align:center;">
				<table class="detaila">
					<tr>
						<td><span>#</span></td>
						<td><span>Student's Name</span></td>
						<td><span>Surname</span></td>
						<td><span>Gender</span></td>
						<td><span>Date of Birth</span></td>
						<td><span>Passport Number</span></td>
					</tr>
					<?php 
						$contaSTD = 1;
						foreach($detSTD as $STD){ ?>
					<tr>
						<td><span><?php echo $contaSTD ?></span></td>
						<td><span><?php echo $STD["nome"] ?></span></td>
						<td><span><?php echo $STD["cognome"] ?></span></td>
						<td><span><?php echo $STD["sesso"] ?></span></td>
						<td><span><?php echo date("d/m/Y",strtotime($STD["pax_dob"])); ?></span></td>
						<td><span><?php echo $STD["numero_documento"] ?></span></td>
					</tr>					
					<?php 
						$contaSTD++;
						} ?>
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
						<td><span>#</span></td>
						<td><span>Group Leader's Name</span></td>
						<td><span>Surname</span></td>
						<td><span>Gender</span></td>
						<td><span>Date of Birth</span></td>
						<td><span>Passport Number</span></td>
					</tr>
					<?php 
						$contaSTD = 1;
						foreach($detGL as $STD){ ?>
					<tr>
						<td><span><?php echo $contaSTD ?></span></td>
						<td><span><?php echo $STD["nome"] ?></span></td>
						<td><span><?php echo $STD["cognome"] ?></span></td>
						<td><span><?php echo $STD["sesso"] ?></span></td>
						<td><span><?php echo date("d/m/Y",strtotime($STD["pax_dob"])); ?></span></td>
						<td><span><?php echo $STD["numero_documento"] ?></span></td>
					</tr>					
					<?php 
						$contaSTD++;
						} ?>
				</table>
			</td>
		</tr>	
		<tr><td style="height:20px;">&nbsp;</td></tr>
		<tr>
			<td>Upon arrival date, <?php echo date("d/m/Y",strtotime($campi["arrival_date"])); ?> students and group leaders will be met by a Plus Representative at the Airport and transferred to <?php echo $campi["centro_name"]; ?>. This transfer has been arranged and organised by Plus Ltd.<br />Students and group leaders will be met at <?php echo $campi["centro_name"]; ?> by the residential campus manager and be allocated a room.<br /><br /></td>
		</tr>
		<tr>
			<td>The programme is inclusive of full - board accommodation, English Lessons (20 Lessons a week) and an afternoon, evening and weekend Leisure Programmes.<br />From Monday to Friday the students will have English lessons in the morning and afternoon and evening activities after lunch. All activities will be supervised by the group leaders and the PLUS residential staff.<br /><br /></td>
		</tr>
		<tr>
			<td>There is a PLUS emergency mobile number which is available 24 / 7. The number is 07956 218 226.<br />Accommodation address:<br /><?php echo $campi["centro_name"]; ?><br />Departure date: <?php echo date("d/m/Y",strtotime($campi["departure_date"])); ?>.<br />Students and group leaders will be transferred from <?php echo $campi["centro_name"]; ?>. This transfer has been arranged and organised by PLUS Ltd.<br /><br /></td>
		</tr>
		<tr>
			<td>Visa type for students: Child Visitor<br />Visa type for group leaders: General Visitor<br />PLUS is accredited by ABLS and the British Council.<br /><br />Yours sincerely,<br /><em>Stefano Marra<br /><img src="http://www.plus-ed.com/vision_ag/img/firma_stefano_marra.gif" border="0" /></em>
		</td>
		</tr>		
	</table>
	<?php 
		foreach($detGL as $single){ 
			if($single["cognome"]!=""){ ?>
		<table cellpadding="0" cellspacing="0" class="grande">
			<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/top_visas.gif" border="0" /></td></tr>	
			<tr><td style="text-align:right;">London, <?php echo date("d M Y"); ?></td></tr>
			<tr><td style="height:20px;">&nbsp;</td></tr>
			<tr>
				<td align="center"><b style="font-size:11pt;">To whom it may concern,</b></td>
			</tr>
			<tr><td style="height:20px;">&nbsp;</td></tr>
			<tr>
				<td>This is to confirm that <?php echo $single["nome"] ?> <?php echo $single["cognome"] ?>, born on the <?php echo date("d/m/Y",strtotime($single["pax_dob"])); ?>, Passport no. <?php echo $single["numero_documento"] ?> is accompanying a Group of students participating in an English Language Course taking place at <?php echo $campi["centro_name"]; ?>.<br /><br />From:	<?php echo date("d/m/Y",strtotime($campi["arrival_date"])); ?>      To: <?php echo date("d/m/Y",strtotime($campi["departure_date"])); ?><br /><br />Address: <?php echo $campi["centro_name"]; ?><br /><br />The course is inclusive of full board accommodation, English Lessons (15 hours a week) and an afternoon, evening and weekend Leisure Programmes.<br /><br />Type of visa: General Visitor<br /><br />Group Leaders are responsible for students’ participation in the activities.<br /><br />Plus is accredited by ABLS and the British Council.<br /><br />Yours sincerely,<br /><em>Stefano Marra<br /><img src="http://www.plus-ed.com/vision_ag/img/firma_stefano_marra.gif" border="0" /></em></td>
			</tr>		
		</table>
	<?php 
			}
		}?>	
	<?php 
		foreach($detSTD as $single){ 
			if($single["cognome"]!=""){ ?>
		<table cellpadding="0" cellspacing="0" class="grande">
			<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/top_visas.gif" border="0" /></td></tr>	
			<tr><td style="text-align:right;">London, <?php echo date("d M Y"); ?></td></tr>
			<tr><td style="height:20px;">&nbsp;</td></tr>
			<tr>
				<td align="center"><b style="font-size:11pt;">To whom it may concern,</b></td>
			</tr>
			<tr><td style="height:20px;">&nbsp;</td></tr>
			<tr>
				<td>This is to confirm that <?php echo $single["nome"] ?> <?php echo $single["cognome"] ?>, born on the <?php echo date("d/m/Y",strtotime($single["pax_dob"])); ?>, Passport no. <?php echo $single["numero_documento"] ?>, is part of a group of students participating in an English Language Course taking place at <?php echo $campi["centro_name"]; ?>.<br /><br />From:	<?php echo date("d/m/Y",strtotime($campi["arrival_date"])); ?>      To: <?php echo date("d/m/Y",strtotime($campi["departure_date"])); ?><br /><br />Address: <?php echo $campi["centro_name"]; ?><br /><br />The course is inclusive of full board accommodation, English Lessons (15 hours a week) and an afternoon, evening and weekend Leisure Programmes.<br /><br />Type of visa: Child Visitor<br /><br />Group Leaders are responsible for students’ participation in the activities.<br /><br />Plus is accredited by ABLS and the British Council.<br /><br />Yours sincerely,<br /><em>Stefano Marra<br /><img src="http://www.plus-ed.com/vision_ag/img/firma_stefano_marra.gif" border="0" /></em></td>
			</tr>		
		</table>
	<?php 
			}
		} ?>
</body>
</html>
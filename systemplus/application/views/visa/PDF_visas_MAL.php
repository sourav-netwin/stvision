<!DOCTYPE html>
<html>
	<head>
		<title>Malta</title>
		<style>
			*{margin:0;padding:0;font-size:8pt;font-family:sans-serif,Arial;}
			body{margin:0;}
			table.grande{margin-left: auto; margin-right: auto;width:540pt;background-color:#fff;border-collapse:collapse;margin-top:20px;}
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
		<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/logo-pdf.png" style="width: 150px; float: left" border="0" /></td>
			<td style="vertical-align: middle">
				<p><strong>Dr. Flavio Vigna B.A., LL.D</strong></p>
				<p><strong>Student Travel Schools</strong></p>
				<p><strong>c/o 67, Old Railway Road</strong></p>
				<p><strong>B’Kara  BKR 1615. Malta</strong></p>
				<p><strong>Tel No: +356 27201277</strong></p>
				</span>
			</td>
		</tr>	
		<tr><td colspan="2" style="text-align:right;">London, <?php echo date("d M Y"); ?></td></tr>
		<tr><td colspan="2" style="height:20px;">&nbsp;</td></tr>
		<tr>
			<td colspan="2" align="center"><b style="font-size:25pt; font-family: cursive,sans-serif,Arial">Certificate of Enrolment</b><br /><br /></td>
		</tr>
		<tr>
			<td colspan="2">To whom it may concern,<br /><br /></td>
		</tr>
		<tr>
			<td colspan="2">This is to confirm that the following student of <?php echo $agency["businesscountry"]; ?> is enrolled on the Malta Summer General Language Course by Plus, produced by Language Schools, which consists of 15 hours a week English tuition and excursion programme and Half Board accommodation in Malta from <?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?> to <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?>.
			</td>
		</tr>		
		<tr><td colspan="2" style="height:20px;">&nbsp;</td></tr>
	</table>
	<table cellpadding="0" cellspacing="0" class="grande grande-us detaila" style="width: 88%; margin: auto">
		<tr>
			<td><span>Forename</span></td>
			<td><span>Surname</span></td>
			<td><span>Date of Birth</span></td>
			<td><span>Gender</span></td>						
			<td><span>PAX</span></td>
			<td><span>Passport #</span></td>
			<td><span>Country Issued</span></td>
		</tr>
		<?php
		if (!empty($detSTD)) {
			foreach ($detSTD as $STD) {
				?>
				<tr>
					<td><span><?php echo $STD["nome"] ?></span></td>
					<td><span><?php echo $STD["cognome"] ?></span></td>							
					<td><span><?php echo date("d/m/Y", strtotime($STD["pax_dob"])); ?></span></td>
					<td><span><?php echo $STD["sesso"] ?></span></td>
					<td><span>STD</span></td>
					<td><span><?php echo $STD["numero_documento"] ?></span></td>
					<td><span>--</span></td>
				</tr>					
				<?php
			}
		}
		if (!empty($detGL)) {
			foreach ($detGL as $STD) {
				?>
				<tr>
					<td><span><?php echo $STD["nome"] ?></span></td>
					<td><span><?php echo $STD["cognome"] ?></span></td>							
					<td><span><?php echo date("d/m/Y", strtotime($STD["pax_dob"])); ?></span></td>
					<td><span><?php echo $STD["sesso"] ?></span></td>
					<td><span>GL</span></td>
					<td><span><?php echo $STD["numero_documento"] ?></span></td>
					<td><span>--</span></td>
				</tr>					
				<?php
			}
		}
		?>
	</table>
	<table cellpadding="0" cellspacing="0" class="grande grande-us">
		<tr><td colspan="2" style="height:20px;">&nbsp;</td></tr>
		<tr>
			<td colspan="2">The student / group will be accompanied by their Group Leader.<br /><br /></td>
		</tr>
		<tr>
			<td colspan="2">This full-time English language programme will be carried out by our fully-qualified EFL instructors. Lessons will take place at St. Theresa , Secondary School Mriehel.<br /><br /></td>
		</tr>
		<tr>
			<td colspan="2">This letter is issued by Student Travel Language Schools, 67, Old Railway Road, B’kara, MALTA Tel: 27 201277, a recognized  EFL Language School  and recognized by the Ministry of Education in Malta.<br /><br /></td>
		</tr>
		<tr>
			<td colspan="2">Yours faithfully, <br /><img src="http://www.plus-ed.com/vision_ag/img/mal-sign.jpg" style="height: 65px; width: 100px" border="0" /></em>
				<br /><br />
				<strong>Dr. Flavio Vigna B.A., LL.D -- Local Agent & Head of School</strong>
			</td>
		</tr>		
	</table>

</body>
</html>
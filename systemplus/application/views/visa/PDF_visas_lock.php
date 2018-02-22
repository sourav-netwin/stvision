<!DOCTYPE html>
<html>
	<head>
		<title>Locked VISA</title>
		<style>
			@page { margin: 180px 50px; }
			*{margin:0;padding:0;font-size:8pt;font-family:sans-serif,Arial;}
			body{margin:0;}
			table.grande{margin-left: auto; margin-right: auto;width:540pt;background-color:#fff;border-collapse:collapse;margin-top:20px;}
			table.detaila{width:100%;margin:0;padding:0;border-collapse:collapse;margin-left:10px;page-break-inside:auto}
			table.detaila tr{ page-break-inside:avoid; page-break-after:auto }
			table.detaila td{border:1px solid #000;}
			table.detaila td span{margin:4px;line-height:1.6em;}
			table.grande2{margin-left: auto; margin-right: auto;width:540pt;background-color:#fff;border-collapse:collapse;margin-top:20px;}
			.pdf-footer { position: absolute; left: 0px; right: 0px; bottom: 0px; text-align: center; color: #005dc7; font-weight: bold }
			.pdf-footer p:last-child{ height: 40px; background-color: #005dc7; color: #fff !important; padding-top: 10px }
			.brk-each-page{page-break-after:always;}
			.brk-each-page:last-child{page-break-after:never;}
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
	if ($locked == 'locked') {
		if ($initTemp == 'USA') {
			?>
			<table cellpadding="0" cellspacing="0" class="grande grande-us">
				<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/top_visas.gif" border="0" /></td></tr>	
				<tr><td style="text-align:right;">London, <?php echo $campi['template_date'] ? date('d M Y', strtotime($campi['template_date'])) : date("d M Y"); ?></td></tr>
				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr>
					<td align="center"><b style="font-size:11pt;">To whom it may concern</b></td>
				</tr>
				<tr>
					<td>This is to confirm that the following students and group leaders from <?php echo $agency["businessname"]; ?> are part of a group enrolling on an English Language Short Course Programme for <?php echo $campi["weeks"]; ?> weeks from <?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?> to <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?> , taking place at  <?php echo $campi["school_name"]; ?>.
					</td>
				</tr>		
				<tr><td style="height:20px;">&nbsp;</td></tr>
			</table>

			<table cellpadding="0" cellspacing="0" class="grande grande-us detaila" style="width: 88%; margin: auto">
				<tr>
					<td><span>#</span></td>
					<td><span>Student's Name</span></td>
					<td><span>Surname</span></td>
					<td><span>Gender</span></td>
					<td><span>Date of Birth</span></td>
					<td><span>Passport Number</span></td>
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
						<td><span><?php if ($STD["sesso"] == 'M') {
				echo 'Male';
			}
			elseif ($STD["sesso"] == 'F') {
				echo 'Female';
			} ?></span></td>
						<td><span><?php echo date("d/m/Y", strtotime($STD["pax_dob"])); ?></span></td>
						<td><span><?php echo $STD["numero_documento"] ?></span></td>
						<td><span>--</span></td>
					</tr>

					<?php
					$contaSTD++;
				}
				?>
			</table>
			<table cellpadding="0" cellspacing="0" class="grande grande-us">
				<tr>
					<td>Group Leaders:</td>
				</tr>
				<tr><td style="height:20px;">&nbsp;</td></tr>
			</table>

			<table cellpadding="0" cellspacing="0" class="grande grande-us detaila" style="width: 88%; margin: auto">
				<tr>
					<td><span>#</span></td>
					<td><span>Group Leader's Name</span></td>
					<td><span>Surname</span></td>
					<td><span>Gender</span></td>
					<td><span>Date of Birth</span></td>
					<td><span>Passport Number</span></td>
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
						<td><span><?php if ($STD["sesso"] == 'M') {
				echo 'Male';
			}
			elseif ($STD["sesso"] == 'F') {
				echo 'Female';
			} ?></span></td>
						<td><span><?php echo date("d/m/Y", strtotime($STD["pax_dob"])); ?></span></td>
						<td><span><?php echo $STD["numero_documento"] ?></span></td>
						<td><span>--</span></td>
					</tr><?php
			$contaSTD++;
		}
				?>
			</table>
			<table cellpadding="0" cellspacing="0" class="grande grande-us">


				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr>
					<td>Upon arrival date, <?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?> students and group leaders will be met by a Plus Representative at the Airport and transferred to <?php echo $campi["school_name"]; ?>. This transfer has been arranged and organised by Plus Ltd.<br />Students and group leaders will be met at <?php echo $campi["school_name"]; ?> by the residential campus manager and be allocated a room.<br /><br /></td>
				</tr>
				<tr>
					<td>The programme is inclusive of full - board accommodation, English Lessons (20 Lessons a week) and an afternoon, evening and weekend Leisure Programmes.<br />From Monday to Friday the students will have English lessons in the morning and afternoon and evening activities after lunch. All activities will be supervised by the group leaders and the PLUS residential staff.<br /><br /></td>
				</tr>
				<tr>
					<td>There is a PLUS emergency mobile number which is available 24 / 7. The number is 07956 218 226.<br />Accommodation address:<br /><?php echo $campi["school_name"]; ?><br />Departure date: <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?>.<br />Students and group leaders will be transferred from <?php echo $campi["school_name"]; ?>. This transfer has been arranged and organised by PLUS Ltd.<br /><br /></td>
				</tr>
				<tr>
					<td>Visa type for students: Child Visitor<br />Visa type for group leaders: General Visitor<br />PLUS is accredited by ABLS and the British Council.<br /><br />Yours sincerely,<br /><em>Stefano Marra<br /><img src="http://www.plus-ed.com/vision_ag/img/firma_stefano_marra.gif" border="0" /></em>
					</td>
				</tr>		
			</table>
			<span class="brk-each-page"></span>
			<?php
		}
		elseif ($initTemp == 'UKIR') {
			?>
			<table cellpadding="0" cellspacing="0" class="grande">
				<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/top_visas.gif" border="0" /></td></tr>	
				<tr><td style="text-align:right;">London, <?php echo $campi['template_date'] ? date('d M Y', strtotime($campi['template_date'])) : date("d M Y"); ?></td></tr>
				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr>
					<td align="center"><b style="font-size:11pt;">To whom it may concern</b></td>
				</tr>
				<tr>
					<td>This is to confirm that the following students and group leader(s) from <?php echo $agency["businessname"] . ', ' . $agency["businesscountry"]; ?> are part of a group enrolling on an English language short course programme for <?php echo $campi["weeks"] <= 1 ? $campi["weeks"] . ' week' : $campi["weeks"] . ' weeks'; ?>, from <?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?> to <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?> , taking place at  <?php echo $campi["school_name"] . ', ' . $campi["located_in"]; ?>.
					</td>
				</tr>
				<tr><td style="height:20px;">&nbsp;</td></tr>
			</table>


			<table cellpadding="0" cellspacing="0" class="grande grande-us detaila" style="width: 88%; margin: auto">
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
						<td><span><?php if ($STD["sesso"] == 'M') {
				echo 'Male';
			}
			elseif ($STD["sesso"] == 'F') {
				echo 'Female';
			} ?></span></td>
						<td><span><?php echo date("d/m/Y", strtotime($STD["pax_dob"])); ?></span></td>
						<td><span><?php echo $STD["numero_documento"] ?></span></td>
						<td><span>--</span></td>
					</tr>					
					<?php
					$contaSTD++;
				}
				?>
			</table>
			<table cellpadding="0" cellspacing="0" class="grande grande-us">

				<tr>
					<td>Group Leaders:</td>
				</tr>		
				<tr><td style="height:20px;">&nbsp;</td></tr>
			</table>


			<table cellpadding="0" cellspacing="0" class="grande grande-us detaila" style="width: 88%; margin: auto">
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
						<td><span><?php if ($STD["sesso"] == 'M') {
				echo 'Male';
			}
			elseif ($STD["sesso"] == 'F') {
				echo 'Female';
			} ?></span></td>
						<td><span><?php echo date("d/m/Y", strtotime($STD["pax_dob"])); ?></span></td>
						<td><span><?php echo $STD["numero_documento"] ?></span></td>
						<td><span>--</span></td>
					</tr>					
					<?php
					$contaSTD++;
				}
				?>
			</table>

			<table cellpadding="0" cellspacing="0" class="grande grande-us">
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
			<span class="brk-each-page"></span>
			<?php
		}
		elseif ($initTemp == 'MAL') {
			?>
			<table cellpadding="0" cellspacing="0" class="grande grande-mal">
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
				<tr><td colspan="2" style="text-align:right;">London, <?php echo $campi['template_date'] ? date('d M Y', strtotime($campi['template_date'])) : date("d M Y"); ?></td></tr>
				<tr><td colspan="2" style="height:20px;">&nbsp;</td></tr>
				<tr>
					<td colspan="2" align="center"><b style="font-size:25pt; font-family: cursive,sans-serif,Arial">Certificate of Enrolment</b><br /><br /></td>
				</tr>
				<tr>
					<td colspan="2">To whom it may concern<br /><br /></td>
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
							<td><span><?php if ($STD["sesso"] == 'M') {
				echo 'Male';
			}
			elseif ($STD["sesso"] == 'F') {
				echo 'Female';
			} ?></span></td>
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
							<td><span><?php if ($STD["sesso"] == 'M') {
				echo 'Male';
			}
			elseif ($STD["sesso"] == 'F') {
				echo 'Female';
			} ?></span></td>
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
			<span class="brk-each-page"></span>
			<?php
		}
		elseif ($initTemp == 'UKIRGLSTD' || $initTemp == 'UKIRSTDSTD' || $initTemp == 'UKIRSTDST') {
			?>
			<table cellpadding="0" cellspacing="0" class="grande">
				<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/top_visas.gif" border="0" /></td></tr>	
				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr><td style="text-align:left;">London, <?php echo $campi['template_date'] ? date('d M Y', strtotime($campi['template_date'])) : date("d M Y"); ?></td></tr>
				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr>
					<td align="center"><b style="font-size:11pt;">To whom it may concern</b></td>
				</tr>
				<tr>
					<td>This is to confirm that the following students from <?php echo $agency["businessname"] . ', ' . $agency["businesscountry"]; ?> are part of a group enrolling on an English Language Course programme for <?php echo $campi["weeks"] <= 1 ? $campi["weeks"] . ' week' : $campi["weeks"] . ' weeks'; ?>, from <?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?> to <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?> , taking place at  <?php echo $campi["school_name"] . ', ' . $campi["located_in"]; ?>.
					</td>
				</tr>
				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr>
					<td>Campus address: <?php echo $campi["address"] . ',' . $campi['post_code']; ?></td>
				</tr>
			</table>
			<table cellpadding="0" cellspacing="0" class="grande grande-us">
				<tr>
					<td style="text-decoration: underline">Students:</td>
				</tr>
				<tr><td style="height:20px;">&nbsp;</td></tr>
			</table>

			<table cellpadding="0" cellspacing="0" class="grande grande-us detaila" style="width: 88%; margin: auto">
				<tr>
					<td><span>No</span></td>
					<td><span>Forename</span></td>
					<td><span>Surname</span></td>
					<td><span>Date of Birth</span></td>
					<td><span>Gender</span></td>
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
						<td><span><?php echo date("d/m/Y", strtotime($STD["pax_dob"])); ?></span></td>
						<td><span><?php if ($STD["sesso"] == 'M') {
				echo 'Male';
			}
			elseif ($STD["sesso"] == 'F') {
				echo 'Female';
			} ?></span></td>
						<td><span><?php echo $STD["numero_documento"] ?></span></td>
						<td><span>--</span></td>
					</tr>					
			<?php
			$contaSTD++;
		}
		?>
			</table>
			<table cellpadding="0" cellspacing="0" class="grande">

				<tr>
					<td style="text-decoration: underline">Group Leader(s):</td>
				</tr>		
				<tr><td style="height:20px;">&nbsp;</td></tr>
			</table>
			<table cellpadding="0" cellspacing="0" class="grande detaila" style="width: 88%; margin: auto">
				<tr>
					<td><span>No</span></td>
					<td><span>Forename</span></td>
					<td><span>Surname</span></td>
					<td><span>Date of Birth</span></td>
					<td><span>Gender</span></td>
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
						<td><span><?php echo date("d/m/Y", strtotime($STD["pax_dob"])); ?></span></td>
						<td><span><?php if ($STD["sesso"] == 'M') {
				echo 'Male';
			}
			elseif ($STD["sesso"] == 'F') {
				echo 'Female';
			} ?></span></td>
						<td><span><?php echo $STD["numero_documento"] ?></span></td>
						<td><span>--</span></td>
					</tr>					
			<?php
			$contaSTD++;
		}
		?>
			</table>
			<table cellpadding="0" cellspacing="0" class="grande">
				<tr>
					<td>Upon arrival date <?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?>, the group will be met by a PLUS representative at the Airport and transferred to <?php echo $campi["school_name"]; ?>. This transfer will be organised and arranged by PLUS. <br /><br />
						Students and group leader will be met at <?php echo $campi["school_name"]; ?> by the residential campus manager and be allocated a room.<br /><br /></td>
				</tr>
				<tr>
					<td>The course is inclusive of full board residence accommodation, English lessons (15 hours a week) and an afternoon, evening and weekend leisure programme.  The payment is being made. <br /><br />
						From Monday to Friday the students will have English lessons in the mornings and some afternoons, followed by planned excursions and activities. All activities will be supervised by the group leaders and PLUS residential staff. <br /><br /></td>
				</tr>
				<tr>
					<td>
					Departure date is <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?>, they will be transferred from <?php echo $campi["school_name"]; ?> to the airport. These transfers have been arranged and organised by PLUS Ltd.<br /><br /></td>
		</tr>
		<tr>
			<td>Type of visa for students: Standard visitor visa<br /><br />
				Type of visa for group leader: Standard visitor visa<br /><br />
				Group leaders are responsible for students’ participation in the activities.<br /><br />
				Company registered in England no. 2965196<br /><br />
				PLUS UK summer courses are accredited by the British Council and PLUS is a member of English UK.<br /><br />Yours sincerely, <br /><em>Stefano Marra<br />Managing Director<br />
			</td>
		</tr>
		<tr>
			<td><img style="width: 150px" src="http://www.plus-ed.com/vision_ag/img/md-sign-plus.PNG" border="0" /></em></td>
		</tr>

		</table>
		
		<span class="brk-each-page"></span>
		<?php
	}
}
foreach ($detGL as $single) {
	if ($single["cognome"] != "") {
		if (isset($uriArray[$single['id_prenotazione']])) {
			if ($uriArray[$single['id_prenotazione']] == 'UKIR') {
				?>
				<table cellpadding="0" cellspacing="0" class="grande">
					<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/top_visas.gif" border="0" /></td></tr>	
					<tr><td style="text-align:right;">London, <?php echo $single['template_date'] ? date("d M Y", strtotime($single['template_date'])) : date("d M Y"); ?></td></tr>
					<tr><td style="height:20px;">&nbsp;</td></tr>
					<tr>
						<td align="center"><b style="font-size:11pt;">To whom it may concern</b></td>
					</tr>
					<tr><td style="height:20px;">&nbsp;</td></tr>
					<tr>
						<td>This is to confirm that <?php
				if ($single["sesso"] == 'M') {
					echo 'MR ';
				}
				elseif ($single["sesso"] == 'F') {
					echo 'MS ';
				}
				else {
					echo 'MR/MS';
				}
				?><?php echo $single["nome"] ?> <?php echo $single["cognome"] ?>, born on the <?php echo date("d/m/Y", strtotime($single["pax_dob"])); ?>, Passport no. <?php echo $single["numero_documento"] ?> is accompanying a group of students participating in an English language course for <?php echo $campi["weeks"] <= 1 ? $campi["weeks"] . ' week' : $campi["weeks"] . ' weeks'; ?>, taking place at <?php echo $campi["school_name"] . ', ' . $campi["located_in"]; ?>.<br /><br />From:	<?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?>      To: <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?><br /><br />Campus address: <?php echo $campi["school_name"]; ?><br /><br />The course is inclusive of full board accommodation, English lessons (15 hours a week) and an afternoon, evening and weekend leisure programme. The payment is being made. <br /><br />Type of visa: General Visitor<br /><br />Group Leaders are responsible for students’ participation in the activities.<br /><br />Plus UK summer courses are accredited by the British Council and ABLS.<br /><br />Yours sincerely,<br /><em>Stefano Marra<br />Managing Director<br /><img src="http://www.plus-ed.com/vision_ag/img/firma_stefano_marra.gif" border="0" /></em></td>
					</tr>		
				</table>
				<div class="pdf-footer">
					<p class="page">Plus-8-10 Grosvenor Gardens, Mezzanine floor, London, SW1W 0DH-P: +44(0)20 7730 2223 - F: +44 (0)20 7730 9209 - E: info@plus-ed.com </p>
					<p>
						Registered Office: 8-10 Grosvenor Gardens, London SW1W 0DH - Reg. No. 2965176 - www.plus-ed.com 
					</p>
				</div>
				<span class="brk-each-page"></span>
				<?
			}
			elseif ($uriArray[$single['id_prenotazione']] == 'USA') {
				?>
				<table cellpadding="0" cellspacing="0" class="grande grande-us">
					<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/top_visas.gif" border="0" /></td></tr>	
					<tr><td style="text-align:right;">London, <?php echo $single['template_date'] ? date("d M Y", strtotime($single['template_date'])) : date("d M Y"); ?></td></tr>
					<tr><td style="height:20px;">&nbsp;</td></tr>
					<tr>
						<td align="center"><b style="font-size:11pt;">To whom it may concern</b></td>
					</tr>
					<tr><td style="height:20px;">&nbsp;</td></tr>
					<tr>
						<td>This is to confirm that <?php echo $single["nome"] ?> <?php echo $single["cognome"] ?>, born on the <?php echo date("d/m/Y", strtotime($single["pax_dob"])); ?>, Passport no. <?php echo $single["numero_documento"] ?> is accompanying a Group of students participating in an English Language Course taking place at <?php echo $campi["school_name"]; ?>.<br /><br />From:	<?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?>      To: <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?><br /><br />Address: <?php echo $campi["school_name"]; ?><br /><br />The course is inclusive of full board accommodation, English Lessons (15 hours a week) and an afternoon, evening and weekend Leisure Programmes. The payment is being made.<br /><br />Type of visa: General Visitor<br /><br />Group Leaders are responsible for students’ participation in the activities.<br /><br />Plus is accredited by ABLS and the British Council.<br /><br />Yours sincerely,<br /><em>Stefano Marra<br /><img src="http://www.plus-ed.com/vision_ag/img/firma_stefano_marra.gif" border="0" /></em></td>
					</tr>		
				</table>
				<span class="brk-each-page"></span>
				<?php
			}
			elseif ($uriArray[$single['id_prenotazione']] == 'MAL') {
				?>
				<table cellpadding="0" cellspacing="0" class="grande grande-mal">
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
					<tr><td colspan="2" style="text-align:right;">London, <?php echo $single['template_date'] ? date("d M Y", strtotime($single['template_date'])) : date("d M Y"); ?></td></tr>
					<tr><td colspan="2" style="height:20px;">&nbsp;</td></tr>
					<tr>
						<td colspan="2" align="center"><b style="font-size:25pt; font-family: cursive,sans-serif,Arial">Certificate of Enrolment</b><br /><br /></td>
					</tr>
					<tr>
						<td colspan="2">To whom it may concern<br /><br /></td>
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
					<tr>
						<td><span><?php echo $single["nome"] ?></span></td>
						<td><span><?php echo $single["cognome"] ?></span></td>							
						<td><span><?php echo date("d/m/Y", strtotime($single["pax_dob"])); ?></span></td>
						<td><span><?php if ($single["sesso"] == 'M') {
				echo 'Male';
			}
			elseif ($single["sesso"] == 'F') {
				echo 'Female';
			} ?></span></td>
						<td><span>GL</span></td>
						<td><span><?php echo $single["numero_documento"] ?></span></td>
						<td><span>--</span></td>
					</tr>
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
				<span class="brk-each-page"></span>
				<?php
			}
			elseif ($uriArray[$single['id_prenotazione']] == 'UKIRGLSTD') {
				?>
				<table cellpadding="0" cellspacing="0" class="grande">
					<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/top_visas.gif" border="0" /></td></tr>	
					<tr><td style="text-align:left;">London, <?php echo $single['template_date'] ? date("d M Y", strtotime($single['template_date'])) : date("d M Y"); ?></td></tr>
					<tr><td style="height:20px;">&nbsp;</td></tr>
					<tr>
						<td align="center"><b style="font-size:11pt;">To whom it may concern</b></td>
					</tr>
					<tr><td style="height:20px;">&nbsp;</td></tr>
					<tr>
						<td>This is to confirm that 
							<?php
							if ($single["sesso"] == 'M') {
								echo 'MR ';
							}
							elseif ($single["sesso"] == 'F') {
								echo 'MS ';
							}
							else {
								echo 'MR/MS ';
							}
							?><?php echo $single["nome"] ?> <?php echo $single["cognome"] ?>, born on the <?php echo date("d/m/Y", strtotime($single["pax_dob"])); ?>, Passport no. <?php echo $single["numero_documento"] ?> is accompanying a group of students participating in an English language course for <?php echo $single["weeks"] <= 1 ? $campi["weeks"] . ' week' : $campi["weeks"] . ' weeks'; ?>, taking place at <?php echo $campi["school_name"] . ', ' . $campi["located_in"]; ?>.
							<br /><br />
							From: <?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?><br/>
							To: <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?><br /><br />
							Campus address: <?php echo $campi["address"] . ',' . $campi['post_code']; ?><br /><br />
							The course is inclusive of full – board residence accommodation, English Lessons (15 hours a week) and an afternoon, evening and weekend leisure programme. The payment is being made.<br /><br />
							Upon arrival date <?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?>, the group will be met by a PLUS representative at the Airport and transferred to <?php echo $campi["school_name"]; ?>. <br /><br />
							Students will be met at <?php echo $campi["school_name"]; ?> by the residential campus manager and be allocated a room.<br /><br />
							Departure date is <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?>, they will be transferred from <?php echo $campi["school_name"]; ?> to the airport. These transfers have been arranged and organised by PLUS Ltd.<br /><br />

							Type of visa: Standard visitor visa <br /><br />
							PLUS UK summer courses are accredited by the British Council and PLUS is a member of English UK.<br /><br />Yours sincerely,<br /><em>Stefano Marra<br />Managing Director<br/><img style="width: 150px" src="http://www.plus-ed.com/vision_ag/img/md-sign-plus.PNG" border="0" /></em></td>
					</tr>		
				</table>
				<div class="pdf-footer">
					<p class="page">Plus-8-10 Grosvenor Gardens, Mezzanine floor, London, SW1W 0DH-P: +44(0)20 7730 2223 - F: +44 (0)20 7730 9209 - E: info@plus-ed.com </p>
					<p>
						Registered Office: 8-10 Grosvenor Gardens, London SW1W 0DH - Reg. No. 2965176 - www.plus-ed.com 
					</p>
				</div>
				<span class="brk-each-page"></span>
				<?php
			}
			elseif ($uriArray[$single['id_prenotazione']] == 'UKIRSTDSTD') {
				?>
				<table cellpadding="0" cellspacing="0" class="grande">
				<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/top_visas.gif" border="0" /></td></tr>	
				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr><td style="text-align:left;">London, <?php echo $single['template_date'] ? date("d M Y", strtotime($single['template_date'])) : date("d M Y"); ?></td></tr>
				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr>
					<td align="center"><b style="font-size:11pt;">To whom it may concern</b></td>
				</tr>
				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr>
					<td>This is to confirm that 
						<?php
						if ($single["sesso"] == 'M') {
							echo 'MR ';
						}
						elseif ($single["sesso"] == 'F') {
							echo 'MS ';
						}
						else {
							echo 'MR/MS ';
						}
						?><?php echo $single["nome"] ?> <?php echo $single["cognome"] ?>, born on the <?php echo date("d/m/Y", strtotime($single["pax_dob"])); ?>, Passport no. <?php echo $single["numero_documento"] ?> is part of a group of students participating in an English language course for <?php echo $campi["weeks"] <= 1 ? $campi["weeks"] . ' week' : $campi["weeks"] . ' weeks'; ?>, taking place at <?php echo $campi["school_name"] . ', ' . $campi["located_in"]; ?>.
						<br /><br />
						From: <?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?><br/>
						To: <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?><br /><br />
						Campus address: <?php echo $campi["address"].','.$campi['post_code']; ?><br /><br />
						The course is inclusive of full – board residence accommodation, English Lessons (15 hours a week) and an afternoon, evening and weekend leisure programme. The payment is being made. <br /><br />
						Upon arrival date <?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?>, the group will be met by a PLUS representative at the Airport and transferred to <?php echo $campi["school_name"]; ?>. <br /><br />
						Students will be met at <?php echo $campi["school_name"]; ?> by the residential campus manager and be allocated a room.<br /><br />
						Departure date is <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?>, they will be transferred from <?php echo $campi["school_name"]; ?> to the airport. These transfers have been arranged and organised by PLUS Ltd.<br /><br />

						Type of visa: Standard visitor visa <br /><br />
						PLUS UK summer courses are accredited by the British Council and PLUS is a member of English UK.<br /><br />Yours sincerely,<br /><em>Stefano Marra<br />Managing Director<br/><img style="width: 150px" src="http://www.plus-ed.com/vision_ag/img/md-sign-plus.PNG" border="0" /></em></td>
				</tr>		
			</table>
				<div class="pdf-footer">
					<p class="page">Plus-8-10 Grosvenor Gardens, Mezzanine floor, London, SW1W 0DH-P: +44(0)20 7730 2223 - F: +44 (0)20 7730 9209 - E: info@plus-ed.com </p>
					<p>
						Registered Office: 8-10 Grosvenor Gardens, London SW1W 0DH - Reg. No. 2965176 - www.plus-ed.com 
					</p>
				</div>
				<span class="brk-each-page"></span>
				<?php
			}
			elseif ($uriArray[$single['id_prenotazione']] == 'UKIRSTDST') {
				?>
				<table cellpadding="0" cellspacing="0" class="grande">
				<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/top_visas.gif" border="0" /></td></tr>	
				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr><td style="text-align:left;">London, <?php echo $single['template_date'] ? date("d M Y", strtotime($single['template_date'])) : date("d M Y"); ?></td></tr>
				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr>
					<td align="center"><b style="font-size:11pt;">To whom it may concern</b></td>
				</tr>
				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr>
					<td>This is to confirm that 
						<?php
						if ($single["sesso"] == 'M') {
							echo 'MR ';
						}
						elseif ($single["sesso"] == 'F') {
							echo 'MS ';
						}
						else {
							echo 'MR/MS ';
						}
						?><?php echo $single["nome"] ?> <?php echo $single["cognome"] ?>, born on the <?php echo date("d/m/Y", strtotime($single["pax_dob"])); ?>, Passport no. <?php echo $single["numero_documento"] ?> is part of a group of students participating in an English language course for <?php echo $campi["weeks"] <= 1 ? $campi["weeks"] . ' week' : $campi["weeks"] . ' weeks'; ?>, taking place at <?php echo $campi["school_name"] . ', ' . $campi["located_in"]; ?>.
						<br /><br />
						From: <?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?><br/>
						To: <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?><br /><br />
						Campus address: <?php echo $campi["address"].','.$campi['post_code']; ?><br /><br />
						The course is inclusive of full – board residence accommodation, English Lessons (15 hours a week) and an afternoon, evening and weekend leisure programme. The payment is being made. <br /><br />
						Upon arrival date <?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?>, the group will be met by a PLUS representative at the Airport and transferred to <?php echo $campi["school_name"]; ?>. <br /><br />
						Students will be met at <?php echo $campi["school_name"]; ?> by the residential campus manager and be allocated a room.<br /><br />
						Departure date is <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?>, they will be transferred from <?php echo $campi["school_name"]; ?> to the airport. These transfers have been arranged and organised by PLUS Ltd.<br /><br />

						Type of visa: Short-term study visa  <br /><br />
						PLUS UK summer courses are accredited by the British Council and PLUS is a member of English UK.<br /><br />Yours sincerely,<br /><em>Stefano Marra<br />Managing Director<br/><img style="width: 150px" src="http://www.plus-ed.com/vision_ag/img/md-sign-plus.PNG" border="0" /></em></td>
				</tr>		
			</table>
				<div class="pdf-footer">
					<p class="page">Plus-8-10 Grosvenor Gardens, Mezzanine floor, London, SW1W 0DH-P: +44(0)20 7730 2223 - F: +44 (0)20 7730 9209 - E: info@plus-ed.com </p>
					<p>
						Registered Office: 8-10 Grosvenor Gardens, London SW1W 0DH - Reg. No. 2965176 - www.plus-ed.com 
					</p>
				</div>
				<span class="brk-each-page"></span>
				<?php
			}
		}
	}
}
?>	
<?php
foreach ($detSTD as $single) {
	if ($single["cognome"] != "") {
		if (isset($uriArray[$single['id_prenotazione']])) {
			if ($uriArray[$single['id_prenotazione']] == 'UKIR') {
				?>
				<table cellpadding="0" cellspacing="0" class="grande">
					<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/top_visas.gif" border="0" /></td></tr>	
					<tr><td style="text-align:right;">London, <?php echo $single['template_date'] ? date("d M Y", strtotime($single['template_date'])) : date("d M Y"); ?></td></tr>
					<tr><td style="height:20px;">&nbsp;</td></tr>
					<tr>
						<td align="center"><b style="font-size:11pt;">To whom it may concern</b></td>
					</tr>
					<tr><td style="height:20px;">&nbsp;</td></tr>
					<tr>
						<td>This is to confirm that <?php
				if ($single["sesso"] == 'M') {
					echo 'MR ';
				}
				elseif ($single["sesso"] == 'F') {
					echo 'MS ';
				}
				else {
					echo 'MR/MS';
				}
				?><?php echo $single["nome"] ?> <?php echo $single["cognome"] ?>, born on the <?php echo date("d/m/Y", strtotime($single["pax_dob"])); ?>, Passport no. <?php echo $single["numero_documento"] ?>, is part of a group of students participating in an English language course for <?php echo $campi["weeks"] <= 1 ? $campi["weeks"] . ' week' : $campi["weeks"] . ' weeks'; ?>, taking place at <?php echo $campi["school_name"] . ', ' . $campi["located_in"]; ?>.<br /><br />From:	<?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?>      To: <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?><br /><br />Campus address: <?php echo $campi["school_name"]; ?><br /><br />The course is inclusive of full board accommodation, English lessons (15 hours a week) and an afternoon, evening and weekend leisure programme. The payment is being made. <br /><br />Type of visa: Child Visitor<br /><br />Group leaders are responsible for students’ participation in the activities.<br /><br />Plus UK summer courses are accredited by the British Council and ABLS.<br /><br />Yours sincerely,<br /><em>Stefano Marra<br />Managing Director<br /><img src="http://www.plus-ed.com/vision_ag/img/firma_stefano_marra.gif" border="0" /></em></td>
					</tr>		
				</table>
				<div class="pdf-footer">
					<p class="page">Plus-8-10 Grosvenor Gardens, Mezzanine floor, London, SW1W 0DH-P: +44(0)20 7730 2223 - F: +44 (0)20 7730 9209 - E: info@plus-ed.com </p>
					<p>
						Registered Office: 8-10 Grosvenor Gardens, London SW1W 0DH - Reg. No. 2965176 - www.plus-ed.com 
					</p>
				</div>
				<span class="brk-each-page"></span>
				<?php
			}
			elseif ($uriArray[$single['id_prenotazione']] == 'USA') {
				?>
				<table cellpadding="0" cellspacing="0" class="grande grande-us">
					<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/top_visas.gif" border="0" /></td></tr>	
					<tr><td style="text-align:right;">London, <?php echo $single['template_date'] ? date("d M Y", strtotime($single['template_date'])) : date("d M Y"); ?></td></tr>
					<tr><td style="height:20px;">&nbsp;</td></tr>
					<tr>
						<td align="center"><b style="font-size:11pt;">To whom it may concern</b></td>
					</tr>
					<tr><td style="height:20px;">&nbsp;</td></tr>
					<tr>
						<td>This is to confirm that <?php echo $single["nome"] ?> <?php echo $single["cognome"] ?>, born on the <?php echo date("d/m/Y", strtotime($single["pax_dob"])); ?>, Passport no. <?php echo $single["numero_documento"] ?>, is part of a group of students participating in an English Language Course taking place at <?php echo $campi["school_name"]; ?>.<br /><br />From:	<?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?>      To: <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?><br /><br />Address: <?php echo $campi["school_name"]; ?><br /><br />The course is inclusive of full board accommodation, English Lessons (15 hours a week) and an afternoon, evening and weekend Leisure Programmes. The payment is being made.<br /><br />Type of visa: Child Visitor<br /><br />Group Leaders are responsible for students’ participation in the activities.<br /><br />Plus is accredited by ABLS and the British Council.<br /><br />Yours sincerely,<br /><em>Stefano Marra<br /><img src="http://www.plus-ed.com/vision_ag/img/firma_stefano_marra.gif" border="0" /></em></td>
					</tr>		
				</table>
				<span class="brk-each-page"></span>
				<?php
			}
			elseif ($uriArray[$single['id_prenotazione']] == 'MAL') {
				?>
				<table cellpadding="0" cellspacing="0" class="grande grande-mal">
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
					<tr><td colspan="2" style="text-align:right;">London, <?php echo $single['template_date'] ? date("d M Y", strtotime($single['template_date'])) : date("d M Y"); ?></td></tr>
					<tr><td colspan="2" style="height:20px;">&nbsp;</td></tr>
					<tr>
						<td colspan="2" align="center"><b style="font-size:25pt; font-family: cursive,sans-serif,Arial">Certificate of Enrolment</b><br /><br /></td>
					</tr>
					<tr>
						<td colspan="2">To whom it may concern<br /><br /></td>
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
					<tr>
						<td><span><?php echo $single["nome"] ?></span></td>
						<td><span><?php echo $single["cognome"] ?></span></td>							
						<td><span><?php echo date("d/m/Y", strtotime($single["pax_dob"])); ?></span></td>
						<td><span><?php if ($single["sesso"] == 'M') {
				echo 'Male';
			}
			elseif ($single["sesso"] == 'F') {
				echo 'Female';
			} ?></span></td>
						<td><span>STD</span></td>
						<td><span><?php echo $single["numero_documento"] ?></span></td>
						<td><span>--</span></td>
					</tr>
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
				<span class="brk-each-page"></span>
				<?php
			}
			elseif ($uriArray[$single['id_prenotazione']] == 'UKIRGLSTD') {
				?>
				<table cellpadding="0" cellspacing="0" class="grande">
					<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/top_visas.gif" border="0" /></td></tr>	
					<tr><td style="text-align:left;">London, <?php echo $single['template_date'] ? date("d M Y", strtotime($single['template_date'])) : date("d M Y"); ?></td></tr>
					<tr><td style="height:20px;">&nbsp;</td></tr>
					<tr>
						<td align="center"><b style="font-size:11pt;">To whom it may concern</b></td>
					</tr>
					<tr><td style="height:20px;">&nbsp;</td></tr>
					<tr>
						<td>This is to confirm that 
							<?php
							if ($single["sesso"] == 'M') {
								echo 'MR ';
							}
							elseif ($single["sesso"] == 'F') {
								echo 'MS ';
							}
							else {
								echo 'MR/MS ';
							}
							?><?php echo $single["nome"] ?> <?php echo $single["cognome"] ?>, born on the <?php echo date("d/m/Y", strtotime($single["pax_dob"])); ?>, Passport no. <?php echo $single["numero_documento"] ?> is accompanying a group of students participating in an English language course for <?php echo $campi["weeks"] <= 1 ? $campi["weeks"] . ' week' : $campi["weeks"] . ' weeks'; ?>, taking place at <?php echo $campi["school_name"] . ', ' . $campi["located_in"]; ?>.
							<br /><br />
							From: <?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?><br/>
							To: <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?><br /><br />
							Campus address: <?php echo $campi["address"] . ',' . $campi['post_code']; ?><br /><br />
							The course is inclusive of full – board residence accommodation, English Lessons (15 hours a week) and an afternoon, evening and weekend leisure programme. The payment is being made.<br /><br />
							Upon arrival date <?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?>, the group will be met by a PLUS representative at the Airport and transferred to <?php echo $campi["school_name"]; ?>. <br /><br />
							Students will be met at <?php echo $campi["school_name"]; ?> by the residential campus manager and be allocated a room.<br /><br />
							Departure date is <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?>, they will be transferred from <?php echo $campi["school_name"]; ?> to the airport. These transfers have been arranged and organised by PLUS Ltd.<br /><br />

							Type of visa: Standard visitor visa <br /><br />
							PLUS UK summer courses are accredited by the British Council and PLUS is a member of English UK.<br /><br />Yours sincerely,<br /><em>Stefano Marra<br />Managing Director<br/><img style="width: 150px" src="http://www.plus-ed.com/vision_ag/img/md-sign-plus.PNG" border="0" /></em></td>
					</tr>		
				</table>
				<div class="pdf-footer">
					<p class="page">Plus-8-10 Grosvenor Gardens, Mezzanine floor, London, SW1W 0DH-P: +44(0)20 7730 2223 - F: +44 (0)20 7730 9209 - E: info@plus-ed.com </p>
					<p>
						Registered Office: 8-10 Grosvenor Gardens, London SW1W 0DH - Reg. No. 2965176 - www.plus-ed.com 
					</p>
				</div>
				<span class="brk-each-page"></span>
				<?php
			}
			elseif ($uriArray[$single['id_prenotazione']] == 'UKIRSTDSTD') {
				?>
				<table cellpadding="0" cellspacing="0" class="grande">
				<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/top_visas.gif" border="0" /></td></tr>	
				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr><td style="text-align:left;">London, <?php echo $single['template_date'] ? date("d M Y", strtotime($single['template_date'])) : date("d M Y"); ?></td></tr>
				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr>
					<td align="center"><b style="font-size:11pt;">To whom it may concern</b></td>
				</tr>
				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr>
					<td>This is to confirm that 
						<?php
						if ($single["sesso"] == 'M') {
							echo 'MR ';
						}
						elseif ($single["sesso"] == 'F') {
							echo 'MS ';
						}
						else {
							echo 'MR/MS ';
						}
						?><?php echo $single["nome"] ?> <?php echo $single["cognome"] ?>, born on the <?php echo date("d/m/Y", strtotime($single["pax_dob"])); ?>, Passport no. <?php echo $single["numero_documento"] ?> is part of a group of students participating in an English language course for <?php echo $campi["weeks"] <= 1 ? $campi["weeks"] . ' week' : $campi["weeks"] . ' weeks'; ?>, taking place at <?php echo $campi["school_name"] . ', ' . $campi["located_in"]; ?>.
						<br /><br />
						From: <?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?><br/>
						To: <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?><br /><br />
						Campus address: <?php echo $campi["address"].','.$campi['post_code']; ?><br /><br />
						The course is inclusive of full – board residence accommodation, English Lessons (15 hours a week) and an afternoon, evening and weekend leisure programme. The payment is being made. <br /><br />
						Upon arrival date <?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?>, the group will be met by a PLUS representative at the Airport and transferred to <?php echo $campi["school_name"]; ?>. <br /><br />
						Students will be met at <?php echo $campi["school_name"]; ?> by the residential campus manager and be allocated a room.<br /><br />
						Departure date is <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?>, they will be transferred from <?php echo $campi["school_name"]; ?> to the airport. These transfers have been arranged and organised by PLUS Ltd.<br /><br />

						Type of visa: Standard visitor visa <br /><br />
						PLUS UK summer courses are accredited by the British Council and PLUS is a member of English UK.<br /><br />Yours sincerely,<br /><em>Stefano Marra<br />Managing Director<br/><img style="width: 150px" src="http://www.plus-ed.com/vision_ag/img/md-sign-plus.PNG" border="0" /></em></td>
				</tr>		
			</table>
				<div class="pdf-footer">
					<p class="page">Plus-8-10 Grosvenor Gardens, Mezzanine floor, London, SW1W 0DH-P: +44(0)20 7730 2223 - F: +44 (0)20 7730 9209 - E: info@plus-ed.com </p>
					<p>
						Registered Office: 8-10 Grosvenor Gardens, London SW1W 0DH - Reg. No. 2965176 - www.plus-ed.com 
					</p>
				</div>
				<span class="brk-each-page"></span>
				<?php
			}
			elseif ($uriArray[$single['id_prenotazione']] == 'UKIRSTDST') {
				?>
				<table cellpadding="0" cellspacing="0" class="grande">
				<tr><td style="height:100px;"><img src="http://www.plus-ed.com/vision_ag/img/top_visas.gif" border="0" /></td></tr>	
				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr><td style="text-align:left;">London, <?php echo $single['template_date'] ? date("d M Y", strtotime($single['template_date'])) : date("d M Y"); ?></td></tr>
				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr>
					<td align="center"><b style="font-size:11pt;">To whom it may concern</b></td>
				</tr>
				<tr><td style="height:20px;">&nbsp;</td></tr>
				<tr>
					<td>This is to confirm that 
						<?php
						if ($single["sesso"] == 'M') {
							echo 'MR ';
						}
						elseif ($single["sesso"] == 'F') {
							echo 'MS ';
						}
						else {
							echo 'MR/MS ';
						}
						?><?php echo $single["nome"] ?> <?php echo $single["cognome"] ?>, born on the <?php echo date("d/m/Y", strtotime($single["pax_dob"])); ?>, Passport no. <?php echo $single["numero_documento"] ?> is part of a group of students participating in an English language course for <?php echo $campi["weeks"] <= 1 ? $campi["weeks"] . ' week' : $campi["weeks"] . ' weeks'; ?>, taking place at <?php echo $campi["school_name"] . ', ' . $campi["located_in"]; ?>.
						<br /><br />
						From: <?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?><br/>
						To: <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?><br /><br />
						Campus address: <?php echo $campi["address"].','.$campi['post_code']; ?><br /><br />
						The course is inclusive of full – board residence accommodation, English Lessons (15 hours a week) and an afternoon, evening and weekend leisure programme. The payment is being made. <br /><br />
						Upon arrival date <?php echo date("d/m/Y", strtotime($campi["arrival_date"])); ?>, the group will be met by a PLUS representative at the Airport and transferred to <?php echo $campi["school_name"]; ?>. <br /><br />
						Students will be met at <?php echo $campi["school_name"]; ?> by the residential campus manager and be allocated a room.<br /><br />
						Departure date is <?php echo date("d/m/Y", strtotime($campi["departure_date"])); ?>, they will be transferred from <?php echo $campi["school_name"]; ?> to the airport. These transfers have been arranged and organised by PLUS Ltd.<br /><br />

						Type of visa: Short-term study visa  <br /><br />
						PLUS UK summer courses are accredited by the British Council and PLUS is a member of English UK.<br /><br />Yours sincerely,<br /><em>Stefano Marra<br />Managing Director<br/><img style="width: 150px" src="http://www.plus-ed.com/vision_ag/img/md-sign-plus.PNG" border="0" /></em></td>
				</tr>		
			</table>
				<div class="pdf-footer">
					<p class="page">Plus-8-10 Grosvenor Gardens, Mezzanine floor, London, SW1W 0DH-P: +44(0)20 7730 2223 - F: +44 (0)20 7730 9209 - E: info@plus-ed.com </p>
					<p>
						Registered Office: 8-10 Grosvenor Gardens, London SW1W 0DH - Reg. No. 2965176 - www.plus-ed.com 
					</p>
				</div>
				<span class="brk-each-page"></span>
				<?php
			}
		}
	}
}
?>	
</body>
</html>
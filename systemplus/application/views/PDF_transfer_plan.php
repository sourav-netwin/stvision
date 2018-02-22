<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<style>
*{margin:0;padding:0;font-size:8pt;font-family:sans-serif,Arial;}
body{margin:0;}
table.grande, table.conbordo{margin-left: auto; margin-right: auto;width:540pt;background-color:#fff;border-collapse:collapse;margin-top:20px;}
table.conbordo{border:0.5pt solid #000;vertical-align:middle;}
table.conbordo td{line-height:1.2em;}
span.rigasopra{margin:5px 5px 0 5px;float:left;display:block;clear:right;}
span.rigacentro{margin:0 5px 0 5px;float:left;display:block;clear:right;}
span.rigasotto{margin:0 5px 5px 5px;float:left;display:block;clear:right;}
table.corpopre{border-collapse:collapse;width:100%;}
table.corpopre td span{margin:2px;line-height:15px;}
table.corpopre tr.testapreventivo td span{margin:2px;line-height:15px;font-weight:bold;color:#fff;}
table.corpopre tr.testapreventivo td{background-color:#aaa;border-bottom:1px solid #666;}
</style>

</head>
<?php
	$plan = $plan_detail[0];
	$cpny = $first_company_detail;
?>
<body style="font-size:10px;">
	<table cellpadding="0" cellspacing="0" class="grande">
		<tr>
			<td style="vertical-align:middle;font-size:14pt;font-weight:bold;" colspan="2">
				<?php echo $plan["nome_centri"] ?> <?php echo ucfirst($tipotransfer)?> Transfer Booking Form
			</td>
		</tr>
		<tr><td colspan="2" style="height:20px;">&nbsp;</td></tr>		
		<tr>
			<td style="border-right:1px solid #ddd;width:60%;">
				<span class="rigasopra"><font style="font-weight:bold;">To:</font></span>
				<span class="rigacentro"><font style="font-weight:bold;"><?php echo $cpny["tra_cp_name"] ?></font></span>
				<span class="rigacentro"><?php echo $cpny["tra_cp_address"] ?></span>
				<span class="rigacentro">Telephone: <?php echo $cpny["tra_cp_phone"] ?></span>
				<span class="rigacentro">Fax: <?php echo $cpny["tra_cp_fax"] ?></span>
				<span class="rigacentro">Email: <?php echo $cpny["tra_cp_email"] ?></span>
				<span class="rigasotto">Emergency Line: <?php echo $cpny["tra_cp_emergency"] ?></span>
			</td>
			<td>
				<span class="rigasopra"><font style="font-weight:bold;">From:</font></span>
				<span class="rigacentro"><font style="font-weight:bold;">Plus LTD</font></span>
				<span class="rigacentro">8-10 Grosvenor Gardens, Mezzanine floor, London, SW1W 0DH</span>
				<span class="rigacentro">Telephone: + 44 (0)20 7730 2223</span>
				<span class="rigacentro">Fax: + 44 (0)20 7730 9209</span>
				<span class="rigasotto">Email: plus@plus-ed.com</span>
			</td>
		</tr>
		<tr><td colspan="2" style="height:20px;">&nbsp;</td></tr>
		<tr><td colspan="2">Transfer CODE: <font style="font-weight:bold;"><?php echo $bus_code?></font></td></tr>
		<?if($tipotransfer=="inbound"){ ?>
		<tr><td colspan="2">From Airport: <font style="font-weight:bold;"><?php echo str_replace("to/from ","",$plan["exc_excursion"]) ?></font></td></tr>
		<tr><td colspan="2">To College: <font style="font-weight:bold;"><?php echo $plan["nome_centri"] ?></font></td></tr>
		<?php }else{ ?>
		<tr><td colspan="2">From College: <font style="font-weight:bold;"><?php echo $plan["nome_centri"] ?></font></td></tr>		
		<tr><td colspan="2">To Airport: <font style="font-weight:bold;"><?php echo str_replace("to/from ","",$plan["exc_excursion"]) ?></font></td></tr>		
		<?php } ?>
		<tr><td colspan="2" style="height:20px;">&nbsp;</td></tr>
		<tr>
			<td colspan="2" style="border-bottom:1px solid #ddd;">
				<?if($tipotransfer=="inbound"){ ?>
				Transfer information: <strong>from <?php echo str_replace("to/from ","",$plan["exc_excursion"]) ?> to <?php echo $plan["nome_centri"] ?>  |  <?php echo $plan["exc_type"] ?> / <?php echo $plan["exc_length"] ?></strong><br />
				<?php }else{ ?>
				Transfer information: <strong>from <?php echo $plan["nome_centri"] ?> to <?php echo str_replace("to/from ","",$plan["exc_excursion"]) ?>  |  <?php echo $plan["exc_type"] ?> / <?php echo $plan["exc_length"] ?></strong><br />				
				<?php } ?>
				Date: <strong><?php echo date("d/m/Y",strtotime($plan["pbe_excdate"])) ?></strong><br />
				Extra information: <strong><?php echo $plan["pbe_pickupplace"] ?></strong><br />
				<?php
				if(date("H:i",strtotime($plan["pbe_hpickup"]))!="00:00"){
				?>
				Pickup time: <strong><?php echo date("H:i",strtotime($plan["pbe_hpickup"])) ?></strong><br />
				<?php
				}
				?>
				Pax Number: <strong><?php echo $allpax ?></strong><br /><br />
			</td>
		</tr>
		<?php
		foreach($bkg_detail as $book){
		?>		
		<tr><td colspan="2" style="height:20px;">&nbsp;</td></tr>		
		<tr>
			<td colspan="2" style="border-bottom:1px solid #ddd;">
				<strong>Booking reference: </strong><?php echo $book["ptt_book_id"] ?>  |  <?php echo $book["businessname"] ?> | <?php echo $book["ptt_tot_pax"] ?> pax<br /><br />
				<?if($tipotransfer=="inbound"){ ?>
				<strong>Flight</strong>: <?php echo $book["ptt_flight"] ?> | <strong>Flight arrival time</strong>: <?php echo date("H:i",strtotime($book["ptt_dataora"])) ?> | <strong>Origin Airport</strong>: <?php echo $book["ptt_airport_from"] ?> | <strong>Destination Airport</strong>: <?php echo $book["ptt_airport_to"] ?><br /><br />
				<?php }else{ ?>
				<strong>Flight</strong>: <?php echo $book["ptt_flight"] ?> | <strong>Flight departure time</strong>: <?php echo date("H:i",strtotime($book["ptt_dataora"])) ?> | <strong>Origin Airport</strong>: <?php echo $book["ptt_airport_from"] ?> | <strong>Destination Airport</strong>: <?php echo $book["ptt_airport_to"] ?><br /><br />
				<?php } ?>
				
			</td>
		</tr>
		<?php
		}
		?>		
		<tr><td colspan="2" style="height:20px;">&nbsp;</td></tr>		
		<tr>
			<td colspan="2" style="border-bottom:1px solid #ddd;">
				<table class="corpopre">
					<tr class="testapreventivo">
						<td><span>Company</span></td>
						<td><span>Bus type</span></td>
						<td style="text-align:center;"><span>Seats</span></td>
						<td style="text-align:center;"><span>Coaches</span></td>
						<td style="text-align:right;"><span>Price per coach</span></td>
						<td style="text-align:right;"><span>Agreed Total Price<br />(including parking and taxes)</span></td>
					</tr>
					<tr><td style="height:15px;" colspan="6">&nbsp;</td></tr>			
						<?php
							$contabus = 1;
							foreach($bus_detail as $bus){
						?>
						<tr>
							<td><span><?php echo $bus["tra_cp_name"] ?></span></td>
							<td><span><?php echo $bus["tra_bus_name"] ?></span></td>
							<td style="text-align:center;"><span><?php echo $bus["tra_bus_seat"] ?></span></td>
							<td style="text-align:center;"><span><?php echo $bus["pbe_qtybus"] ?></span></td>
							<td style="text-align:right;"><span><?php echo $bus["pbe_jnprice"] ?><?php echo utf8_decode($bus["pbe_jncurrency"]) ?></span></td>
							<td style="text-align:right;"><span><?php echo number_format($bus["pbe_qtybus"]*$bus["pbe_jnprice"],2,'.','') ?><?php echo utf8_decode($bus["pbe_jncurrency"]) ?></span></td>
						</tr>
						<?php
							$contabus++;
							}
						?>
					</tr>
				</table>						
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<br /><br /><br />
				<span style="font-weight:bold;">In order to confirm this booking please put a stamp and signature and fax this form to our Office onto + 44 (0)20 7730 9209</span><br />
				Professional Linguistic &amp; Upper Studies (PLUS) will only pay for what has been booked or charged in writing by PLUS Head Office (8-10 Grosvenor Gardens, Mezzanine Floor London, SW1W 0DH).<br />
				All correspondence should be directed to PLUS Head Office. PLUS will not take responsibility for any excursions or transfers booked by any member of staff on location (ie, centre secretaries or group leaders).
				No coach booked through PLUS Head Office can be cancelled over the telephone. All cancellations must come in writing from PLUS Head Office.
			</td>
		</tr>
		<tr><td colspan="2" style="height:80px;">&nbsp;</td></tr>	
		<tr>
			<td>&nbsp;</td>
			<td style="text-align:right;">
				Signed ______________________________________
			</td>
		</tr>	
		<tr><td colspan="2" style="height:30px;">&nbsp;</td></tr>		
		<tr>
			<td>&nbsp;</td>
			<td style="text-align:right;">
				Print Name ______________________________________
			</td>
		</tr>		
	</table>
</body>
</html>
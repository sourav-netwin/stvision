<!DOCTYPE html>
<html>
<head>
<style>
*{margin:0;padding:0;font-size:9pt;font-family:Arial;}
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
</style>
</head>
<?php
	$campi = $booking_detail[0];
	$agency = $agency[0];
?>
<body style="font-size:10px;">
	<table cellpadding="0" cellspacing="0" class="grande">
		<tr>
			<td style="vertical-align:middle;" colspan="2">
				<img src="/var/www/html/www.plus-ed.com/application/images/logo_PLU.png" border="0" style="width:560px;margin-bottom:20px;" />
			</td>
		</tr>
		<tr>
			<td style="border-right:1px solid #ddd;">
				<span class="rigasopra"><font style="font-weight:bold;">To:</font></span>
				<span class="rigacentro"><?php echo $agency['businessname']?></span>
				<span class="rigasotto"><?php echo $agency['businessaddress']?> - <?php echo $agency['businesspostalcode']?> <?php echo $agency['businesscity']?><br /><?php echo $agency['businesscountry']?></span>
			</td>
			<?php switch ($campi['valuta_fattura']){
				case "GBP":
			?>
			<td style="border:1px solid #ddd;">
				<span class="rigasopra"><font style="font-weight:bold;">Please Remit:</font></span>
				<span class="rigacentro">Professional Linguistic & Upper Studies Ltd</span>
				<span class="rigacentro">Coutts and Co</span>
				<span class="rigacentro">440 Strand, London WC2R 0QS</span>
				<span class="rigacentro">(Please quote your group ID and our BIC number as your reference)</span>				
				<span class="rigacentro"><font style="font-weight:bold;">Sort Code: </font>18-00-02 - <font style="font-weight:bold;">Account No. </font>08323534</span>
				<span class="rigasotto"><font style="font-weight:bold;">IBAN: </font>GB63 COUT 1800 0208 3235 34 - <font style="font-weight:bold;">BIC: </font>COUTGB22</span>
			</td>
			<?php
				break;
				case "USD":
			?>
			<td style="border:1px solid #ddd;">
				<span class="rigasopra"><font style="font-weight:bold;">Please Remit:</font></span>
				<span class="rigacentro">Professional Linguistic & Upper Studies Ltd</span>
				<span class="rigacentro">Coutts and Co</span>
				<span class="rigacentro">440 Strand, London WC2R 0QS</span>
				<span class="rigacentro">(Please quote your group ID and our BIC number as your reference)</span>				
				<span class="rigacentro"><font style="font-weight:bold;">Sort Code: </font>18-00-91 - <font style="font-weight:bold;">Account No. </font>09467971</span>
				<span class="rigasotto"><font style="font-weight:bold;">IBAN: </font>GB38 COUT 1800 9109 4679 71 - <font style="font-weight:bold;">BIC: </font>COUTGB22</span>
			</td>
			<?php
				break;	
				case "EUR":
			?>
			<td style="border:1px solid #ddd;">
				<span class="rigasopra"><font style="font-weight:bold;">Please Remit:</font></span>
				<span class="rigacentro">Professional Linguistic & Upper Studies Ltd</span>
				<span class="rigacentro">Coutts and Co</span>
				<span class="rigacentro">440 Strand, London WC2R 0QS</span>
				<span class="rigacentro">(Please quote your group ID and our BIC number as your reference)</span>				
				<span class="rigacentro"><font style="font-weight:bold;">Sort Code: </font>18-00-91 - <font style="font-weight:bold;">Account No. </font>07467974</span>
				<span class="rigasotto"><font style="font-weight:bold;">IBAN: </font>GB57 COUT 1800 9107 4679 74 - <font style="font-weight:bold;">BIC: </font>GBCOUT22</span>
			</td>
			<?php
				break;				
			} ?>
		</tr>
		<tr><td colspan="2" style="height:20px;">&nbsp;</td></tr>
		<tr><td colspan="2">ID File: <font style="font-weight:bold;"><?php echo $campi['rand']?></font></td></tr>
		<tr><td colspan="2" style="height:20px;">&nbsp;</td></tr>
		<tr>
			<td colspan="2">
				Destination: <font style="font-weight:bold;"><?php echo $campi['id_centro']?></font><br />
				Accomodation: <font style="font-weight:bold;"><?php echo $campi['accomodation']?></font><br />
				Arrival: <font style="font-weight:bold;"><?php echo $campi['data_inizio']?></font><br />
				Departure: <font style="font-weight:bold;"><?php echo $campi['data_fine']?></font>
			</td>
		</tr>
<?php
	switch ($campi['accomodation']) {
    		case 'College En suite':
     		   $costosingolo=$campi['costo_ensuite'];
     		   break;
    		case 'College Standard':
     		   $costosingolo=$campi['costo_standard'];
     		   break;
   		case 'Home stay':
     		   $costosingolo=$campi['costo_homestay'];
    		    break;
	}

	$totalegroupleaders=$campi['extragl']*1;
	$scontoextra=$campi['extradiscount']*1;
	$extraperiod=$campi['extraperiod']*1;
	$costopax=$campi['tot_pax']*$costosingolo*$campi['weeks'];

?>
		<tr><td colspan="2" style="height:20px;">&nbsp;</td></tr>
		<tr>
			<td colspan="2">
				<table class="corpopre">
					<tr class="testapreventivo">
						<td style="width:100px;"><span>&nbsp;</span></td>
						<td style="width:380px;"><span>Description</span></td>
						<td style="text-align:right;width:80px;"><span>Total</span></td>
					</tr>
					<tr><td colspan="3" style="height:15px;">&nbsp;</td></tr>  
					<tr>
						<td><span>Price <?php echo $costosingolo?> <?php echo $campi['valuta']?> for</span></td>
						<td>
							<span>N. <?php echo $campi['tot_pax']?> students for <?php echo $campi['weeks']?> week/s course<br /></span>
							<span>Full Board<br /></span>
							<span>Social Programme<br /></span>
							<span>ESL Course<br /><br /></span>
						</td>
						<td style="text-align:right"><span><?php echo $costopax?> <?php echo $campi['valuta']?></span></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
							<span>Excursion Package :<br /></span>
<?php foreach($escursioni as $key => $item){?>
						<span style="font-size:7pt;"><?php echo $item["excursion"]?><br /></span>

<?php	}?>
						<br /></span></td>
						<td>&nbsp;</td>
					</tr>
<?php
	$agentdiscount=(($campi['tot_pax']*$costosingolo*$campi['weeks'])/100)*$agency['sconto'];
?>
					<tr>
						<td><span>&nbsp;</span></td>
						<td><span><?php echo $agency['sconto']?>% agent agreement</span></td>
						<td style="text-align:right"><span> - <?php echo $agentdiscount?> <?php echo $campi['valuta']?></span></td>
					</tr>
					<tr>
						<td><span>&nbsp;</span></td>
						<td><span>N. <?php echo $campi['n_gruppo']?> Group Leader Cost</span></td>
						<td style="text-align:right"><span><?php echo $totalegroupleaders?> <?php echo $campi['valuta']?></span></td>
					</tr>
<?php
	if($scontoextra > 0){?>
					<tr>
						<td><span>&nbsp;</span></td>
						<td><span>Extra Discount</span></td>
						<td style="text-align:right"><span> - <?php echo $scontoextra?> <?php echo $campi['valuta']?></span></td>
					</tr>
<?php
	}

	$accontoricevuto = $campi['acconto_versato']*1;
?>

<?php
	if($extraperiod > 0){?>
					<tr>
						<td><span>&nbsp;</span></td>
						<td><span>Extra Period</span></td>
						<td style="text-align:right"><span><?php echo $extraperiod?> <?php echo $campi['valuta']?></span></td>
					</tr>
<?php
	}
?>
					<tr>
						<td><span>&nbsp;</span></td>
						<td><span>Deposit Received</span></td>
						<td style="text-align:right"><span> - <?php echo $accontoricevuto?> <?php echo $campi['valuta']?></span></td>
					</tr>
					<tr><td colspan="4" style="height:15px;border-bottom:1px solid #ddd;">&nbsp;</td></tr>  
					<tr>
						<td colspan="2" style="text-align:right;"><span><b>Grand Total Due</b></span></td>
						<td style="text-align:right;"><span><b><?php echo ($costopax-$agentdiscount-$scontoextra-$accontoricevuto+$totalegroupleaders+$extraperiod)?> <?php echo $campi['valuta']?></b></span></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr><td colspan="2" style="height:20px;">&nbsp;</td></tr>  
	</table>
</body>
</html>
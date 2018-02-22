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
    $ag = $agency[0];
?>
<body style="font-size:10px;">
	<table cellpadding="0" cellspacing="0" class="grande">
        <tr>
            <td style="vertical-align:middle;" colspan="2">
                <img src="/var/www/html/www.plus-ed.com/application/images/logo_PLU.png" border="0" style="width:560px;margin-bottom:20px;" />
            </td>
        </tr>
        <tr><td colspan="2" style="height:40px;">&nbsp;</td></tr>
		<tr>
			<td style="vertical-align:middle;font-size:14pt;font-weight:bold;" colspan="2">
				Group Leader background check form - Booking ID <?php echo $glDetails[0]["bkId"]; ?><hr />
			</td>
		</tr>
		<tr><td colspan="2" style="height:20px;">&nbsp;</td></tr>
		<tr>
			<td colspan="2" style="border-bottom:1px solid #ddd;">
				Agency Name: <strong><?php echo $ag["businessname"]; ?></strong><br /><br />
                Agency Contact Email: <strong><?php echo $ag["email"]; ?></strong><br /><br />
                Agency Phone Number: <strong><?php echo $ag["businesstelephone"]; ?></strong><br /><br />
			</td>
		</tr>
        <tr><td colspan="2" style="height:40px;">&nbsp;</td></tr>
        <tr>
            <td colspan="2">
                <span>I confirm that the following group leader(s) have supplied proof of their suitability to work with children by providing
either a police ‘certificate of good conduct’ or ‘certificate of criminal record’ from their home country.</span>
            </td>
        </tr>
		<tr><td colspan="2" style="height:40px;">&nbsp;</td></tr>
		<tr>
			<td colspan="2" style="border-bottom:1px solid #ddd;">
				<table class="corpopre">
					<tr class="testapreventivo">
                        <td><span>#</span></td>
						<td><span>Group Leader</span></td>
						<td><span>Centre Name</span></td>
						<td style="text-align:center;"><span>Arrival Date</span></td>
						<td style="text-align:center;"><span>Departure Date</span></td>
					</tr>
					<tr><td style="height:15px;" colspan="5">&nbsp;</td></tr>
						<?php
                            $contaGl = 1;
							foreach($glDetails as $gl){
						?>
						<tr>
                            <td><span><?php echo $contaGl ?></span></td>
							<td><span><?php echo ucwords(strtolower($gl["glName"])) ?></span></td>
							<td><span><?php echo ucwords(strtolower($gl["nome_centri"])) ?></span></td>
							<td style="text-align:center;"><span><?php echo date("d/m/Y",strtotime($gl["andata_data_arrivo"])) ?></span></td>
							<td style="text-align:center;"><span><?php echo date("d/m/Y",strtotime($gl["ritorno_data_partenza"])) ?></span></td>
						</tr>
						<?php
                            $contaGl++;
							}
						?>
					</tr>
                    <tr><td style="height:30px;" colspan="5">&nbsp;</td></tr>
				</table>						
			</td>
		</tr>
		<tr><td colspan="2" style="height:80px;">&nbsp;</td></tr>	
		<tr>
			<td>&nbsp;</td>
			<td style="text-align:right;">
				Accepted by agency on <?php echo date("d/m/Y",strtotime($glDetails[0]["data_insert"])); ?>
			</td>
		</tr>
	</table>
</body>
</html>
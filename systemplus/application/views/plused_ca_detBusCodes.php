<style type="text/css">
	#printDiv{
		display: none;
	}
</style>						
<div class="box">
						<table class="dynamic styled" data-table-tools='{"display":false}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Bus Code</th>
									<th>Transfer Date</th>
									<th>Transfer Type</th>
									<th>Pax</th>
									<th>Flight Details</th>
									<th>View detail</th>
								</tr>
							</thead>
							<tbody>
							<?php 
								foreach($detBusCodes as $bus){					
							?>
								<tr>
									<td class="center"><?php echo $bus["ptt_buscompany_code"]?></td>
									<td class="center"><?php echo date("d/m/Y",strtotime($bus["ptt_dataora"])) ?></td>
									<td class="center"<?php if($bus["ptt_type"]=="inbound"){ ?> style="color:#090;"<?php }else{ ?> style="color:#f00;"<?php } ?>><?php echo $bus["ptt_type"] ?></td>
									<td class="center"><?php echo $bus["tuttipax"]?></td>
									<td class="center">
										<?php
										if(!empty($flgDetails)){
											if(isset($flgDetails[$bus["ptt_buscompany_code"]])){
												foreach($flgDetails[$bus["ptt_buscompany_code"]] as $flight){
													echo '<span class="refstandby">'.$flight['ptt_book_id'].'</span>&nbsp;&nbsp'.$flight["ptt_flight"].'@</span><span class="refstandby">'.date("H:i",strtotime($flight["ptt_dataora"])).'</span> | '.$flight["ptt_airport_from"].'&#x2708;'.$flight["ptt_airport_to"].'<br />';
												}
											}
										}
										?>
									</td>
									<td class="center">
										<a data-gravity="s" class="button small grey tooltip dialogbtn" id="code_<?php echo $bus["ptt_buscompany_code"]?>" target="_blank" href="<?php echo base_url(); ?>index.php/backoffice/busTraDetail/code_<?php echo $bus["ptt_buscompany_code"]?>" original-title="View detail"><i class="icon-zoom-in" style="font-size:14px;"></i></a>
									</td>									
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
							<table id="printDiv" style="border: 1px solid; border-collapse: collapse"> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th style="border: 1px solid;">Bus Code</th>
									<th style="border: 1px solid;">Transfer Date</th>
									<th style="border: 1px solid;">Transfer Type</th>
									<th style="border: 1px solid;">Pax</th>
									<th style="border: 1px solid;">Flight Details</th>
								</tr>
							</thead>
							<tbody>
							<?php 
								foreach($detBusCodes as $bus){					
							?>
								<tr>
									<td style="border: 1px solid;"><?php echo $bus["ptt_buscompany_code"]?></td>
									<td style="border: 1px solid;"><?php echo date("d/m/Y",strtotime($bus["ptt_dataora"])) ?></td>
									<td style="border: 1px solid;"<?php if($bus["ptt_type"]=="inbound"){ ?> style="color:#090;"<?php }else{ ?> style="color:#f00;"<?php } ?>><?php echo $bus["ptt_type"] ?></td>
									<td style="border: 1px solid;"><?php echo $bus["tuttipax"]?></td>
									<td style="border: 1px solid;">
										<?php
										if(!empty($flgDetails)){
											if(isset($flgDetails[$bus["ptt_buscompany_code"]])){
												foreach($flgDetails[$bus["ptt_buscompany_code"]] as $flight){
													echo '<span class="refstandby">'.$flight['ptt_book_id'].'</span>&nbsp;&nbsp'.$flight["ptt_flight"].'@</span><span class="refstandby">'.date("H:i",strtotime($flight["ptt_dataora"])).'</span> | '.$flight["ptt_airport_from"].'&#x2708;'.$flight["ptt_airport_to"].'<br />';
												}
											}
										}
										?>
									</td>								
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
						</div>

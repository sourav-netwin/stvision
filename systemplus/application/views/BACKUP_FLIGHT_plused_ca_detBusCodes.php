						<div class="box">
						<table class="dynamic styled" data-table-tools='{"display":false}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Bus Code</th>
									<th>Transfer Date</th>
									<th>Transfer Type</th>
									<th>Flight Details</th>								
									<th>Pax</th>
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
									<td class="center" style="width:235px;"><div style="width:60px;background-color:#ddd;float:left;color:#17549B;"><?php echo date("H:i",strtotime($bus["ptt_dataora"]))?></div><div style="width:60px;background-color:#ccc;float:left;font-weight:bold;color:#333;"><?php echo $bus["ptt_flight"]?></div><div style="width:120px;background-color:#bbb;clear:left;float:left;font-weight:normal;color:#000;"><?php echo $bus["ptt_airport_from"]?> &#x2708; <?php echo $bus["ptt_airport_to"]?></div></td>
									<td class="center"><?php echo $bus["tuttipax"]?></td>
									<td class="center">
										<a data-gravity="s" class="button small grey tooltip dialogbtn" id="code_<?php echo $bus["ptt_buscompany_code"]?>" target="_blank" href="<?php echo base_url(); ?>index.php/backoffice/busTraDetail/code_<?php echo $bus["ptt_buscompany_code"]?>" original-title="View detail"><i class="icon-zoom-in" style="font-size:14px;"></i></a>
									</td>									
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
						</div>
						<div class="box">
						<table class="dynamic styled" data-table-tools='{"display":false}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Bus Code</th>
									<th>Excursion</th>
									<th>Excursion Date</th>
									<th>Pax</th>
									<th>View detail</th>
								</tr>
							</thead>
							<tbody>
							<?php 
								foreach($detBusCodes as $bus){					
							?>
								<tr>
									<td class="center"<?php if($bus["pte_confirmed"]=="YES"){ ?> style="color:#090;"<?php }else{ ?> style="color:#f00;"<?php } ?>><?php echo $bus["pte_buscompany_code"]?></td>
									<td class="center"><?php echo $bus["exc_excursion"]?> | <?php echo $bus["exc_length"]?></td>
									<td class="center"><?php echo date("d/m/Y",strtotime($bus["pte_excursion_date"])) ?></td>
									<td class="center"><?php echo $bus["pte_tot_pax"]?></td>
									<td class="center">
										<a data-gravity="s" class="button small grey tooltip dialogbtn" id="code_<?php echo $bus["pte_buscompany_code"]?>" target="_blank" href="<?php echo base_url(); ?>index.php/backoffice/busAllExcDetail/code_<?php echo $bus["pte_buscompany_code"]?>" original-title="View detail"><i class="icon-zoom-in" style="font-size:14px;"></i></a>
									</td>									
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
						</div>
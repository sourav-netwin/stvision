<?php
	$bkg = $booking_detail[0];
?>						
						<form name="postaPax" id="postaPax" method="POST" action="<?php echo base_url(); ?>index.php/agents/postaPax/<?php echo $bkg["id_book"]?>">
						<a href="javascript:void(0);" id="copyFirst">Copy common data from first line</a>
						<table style="width:100%;" class="styled paxlist" >
							<thead>
								<tr>
									<th>Type</th>
									<th>Surname</th>								
									<th>Name</th>
									<th>Sex</th>
									<th>Date Of Birth</th>									
									<th>Citizenship</th>
									<th>Passport No</th>
									<th>Health Info</th>
									<th>GL Ref.</th>
									<th>Campus Date In</th>		
									<th>Campus Date Out</th>									
									<th>Arr Flight Date</th>
									<th>Arr Time</th>
									<th>Transfer In</th>
									<th>Arrival Airport</th>
									<th>Flight Number In</th>
									<th>Dep Flight Date</th>
									<th>Dep Time</th>
									<th>Transfer Out</th>
									<th>Departure Airport</th>
									<th>Flight Number Out</th>
									<th>Visa</th>									
								</tr>
							</thead>
							<tbody>
							
							<?php
							$idFirstLine = $paxs[0]["id_prenotazione"];
							//print_r($paxs);
							$contarighe = 1;
							foreach($paxs as $pax){
								if(is_null($pax["pax_dob"]) or $pax["pax_dob"]=="0000-00-00")
									$pax["pax_dob"]="1970-01-01";
							?>
								<tr>
									<td class="center"><?php echo $pax["tipo_pax"]?><br /><?php echo $pax["accomodation"]?></td>
									<td class="center"><input class="rosterField reqField" id="cognome__<?php echo $pax["id_prenotazione"]?>" name="cognome__<?php echo $pax["id_prenotazione"]?>" type="text" value="<?php echo $pax["cognome"]?>" /></td>
									<td class="center"><input class="rosterField reqField" id="nome__<?php echo $pax["id_prenotazione"]?>" name="nome__<?php echo $pax["id_prenotazione"]?>" type="text" value="<?php echo $pax["nome"]?>" /></td>
									<td class="center">
										<select id="sesso__<?php echo $pax["id_prenotazione"]?>" name="sesso__<?php echo $pax["id_prenotazione"]?>" style="font-size:10px;" class="reqField">
											<option value="">-</option>
											<option value="M" <?php if($pax["sesso"]=="M"){ ?>selected<?php } ?>>M</option>
											<option value="F" <?php if($pax["sesso"]=="F"){ ?>selected<?php } ?>>F</option>
										</select>
									</td>
									<td class="center"><input class="rosterField w55 chooseDOB reqField" id="pax_dob__<?php echo $pax["id_prenotazione"]?>"name="pax_dob__<?php echo $pax["id_prenotazione"]?>" type="text" value="<?php echo date("d/m/Y",strtotime($pax["pax_dob"]))?>" /></td>
									<td class="center td_nazionalita"><input class="rosterField reqField" id="nazionalita__<?php echo $pax["id_prenotazione"]?>" name="nazionalita__<?php echo $pax["id_prenotazione"]?>" type="text" value="<?php echo $pax["nazionalita"]?>" /></td>
									<td class="center"><input class="rosterField reqField" id="numero_documento__<?php echo $pax["id_prenotazione"]?>" name="numero_documento__<?php echo $pax["id_prenotazione"]?>" type="text" value="<?php echo $pax["numero_documento"]?>" /></td>
									<td class="center"><input class="rosterField" id="salute__<?php echo $pax["id_prenotazione"]?>" name="salute__<?php echo $pax["id_prenotazione"]?>" type="text" value="<?php echo $pax["salute"]?>" /></td>
									<td class="center td_gl_rif"><input class="rosterField reqField" id="gl_rif__<?php echo $pax["id_prenotazione"]?>" name="gl_rif__<?php echo $pax["id_prenotazione"]?>" type="text" value="<?php echo $pax["gl_rif"]?>" /></td>
									<td class="center td_data_arrivo_campus"><input class="rosterField w55 chooseDate1 reqField" id="data_arrivo_campus__<?php echo $pax["id_prenotazione"]?>"name="data_arrivo_campus__<?php echo $pax["id_prenotazione"]?>" type="text" value="<?php echo date("d/m/Y",strtotime($pax["data_arrivo_campus"]))?>" /></td>
									<td class="center td_data_partenza_campus"><input class="rosterField w55 chooseDate2 reqField" id="data_partenza_campus__<?php echo $pax["id_prenotazione"]?>" name="data_partenza_campus__<?php echo $pax["id_prenotazione"]?>" type="text" value="<?php echo date("d/m/Y",strtotime($pax["data_partenza_campus"]))?>" /></td>									
									<td class="center td_andata_data_arrivo"><input class="rosterField w55 chooseDateTime1 reqField" id="andata_data_arrivo__<?php echo $pax["id_prenotazione"]?>"name="andata_data_arrivo__<?php echo $pax["id_prenotazione"]?>" type="text" value="<?php echo date("d/m/Y",strtotime($pax["andata_data_arrivo"]))?>" /></td>
									<td class="center td_ora_arrivo_volo"><input class="rosterField w30 chooseTime1 reqField" id="ora_arrivo_volo__<?php echo $pax["id_prenotazione"]?>"name="ora_arrivo_volo__<?php echo $pax["id_prenotazione"]?>" type="text" value="<?php echo date("H:i",strtotime($pax["andata_data_arrivo"]))?>" /></td>
									<td class="center td_transfer_in"><input type="checkbox" id="transfer_in__<?php echo $pax["id_prenotazione"]?>" name="transfer_in__<?php echo $pax["id_prenotazione"]?>" <?php if($pax["transfer_in"]==1){ ?>checked="checked"<?php } ?>></td>
									<td class="center td_andata_apt_arrivo"><input class="rosterField w30 airport_ac" id="andata_apt_arrivo__<?php echo $pax["id_prenotazione"]?>"name="andata_apt_arrivo__<?php echo $pax["id_prenotazione"]?>" type="text" value="<?php echo $pax["andata_apt_arrivo"]?>" /></td>
									<td class="center td_andata_volo"><input class="rosterField w40" id="andata_volo__<?php echo $pax["id_prenotazione"]?>" name="andata_volo__<?php echo $pax["id_prenotazione"]?>" type="text" value="<?php echo $pax["andata_volo"]?>" /></td>
									<td class="center td_ritorno_data_partenza"><input class="rosterField w55 chooseDateTime2 reqField" id="ritorno_data_partenza__<?php echo $pax["id_prenotazione"]?>" name="ritorno_data_partenza__<?php echo $pax["id_prenotazione"]?>" type="text" value="<?php echo date("d/m/Y",strtotime($pax["ritorno_data_partenza"]))?>" /></td>
									<td class="center td_ora_partenza_volo"><input class="rosterField w30 chooseTime2 reqField" id="ora_partenza_volo__<?php echo $pax["id_prenotazione"]?>" name="ora_partenza_volo__<?php echo $pax["id_prenotazione"]?>" type="text" value="<?php echo date("H:i",strtotime($pax["ritorno_data_partenza"]))?>" /></td>
									<td class="center td_transfer_out"><input type="checkbox" id="transfer_out__<?php echo $pax["id_prenotazione"]?>" name="transfer_out__<?php echo $pax["id_prenotazione"]?>" <?php if($pax["transfer_out"]==1){ ?>checked="checked"<?php } ?>></td>
									<td class="center td_ritorno_apt_partenza"><input class="rosterField w30 airport_ac" id="ritorno_apt_partenza__<?php echo $pax["id_prenotazione"]?>" name="ritorno_apt_partenza__<?php echo $pax["id_prenotazione"]?>" type="text" value="<?php echo $pax["ritorno_apt_partenza"]?>" /></td>
									<td class="center td_ritorno_volo"><input class="rosterField w40" id="ritorno_volo__<?php echo $pax["id_prenotazione"]?>" name="ritorno_volo__<?php echo $pax["id_prenotazione"]?>" type="text" value="<?php echo $pax["ritorno_volo"]?>" /></td>		
									<td class="center td_visa"><input class="yesVisa" type="checkbox" id="visa__<?php echo $pax["id_prenotazione"]?>" name="visa__<?php echo $pax["id_prenotazione"]?>" <?php if($pax["visa"]==1){ ?>checked="checked"<?php } ?><?php if($contarighe > 1){ ?> onclick="return false;"<?php } ?>></td>									
								</tr>
							<?php
									$contarighe++;
								}
							?>
							</tbody>
						</table>
						<input type="hidden" name="noChanges" id="noChanges" value="NOSEND" />
						</form>						
	<script type="text/javascript">
	function writeValues(valore, cella){
		$(cella+" input").each(function(){
			$(this).val(valore);
		});
	}
	function writeCKValues(valore, cella){
		$(cella+" input").each(function(){
			$(this).prop('checked',valore);
		});
	}	
	$(document).ready(function(){
		$("#visa__<?php echo $idFirstLine?>").click(function(){
			if($(this).attr("checked")=="checked"){
				$(".yesVisa").each(function(){
					$(this).prop("checked",true);
				});
			}else{
				$(".yesVisa").each(function(){
					$(this).prop("checked",false);
				});			
			}
		});
		$( ".chooseDate1" ).datepicker({
			numberOfMonths: 1,
			dateFormat: "dd/mm/yy",
			onClose: function() {
				var idToChange = $(this).attr("id").split("__");
				changeIdIs="ritorno_data_partenza__"+idToChange[1];
				dataGirata = parseDate($(this).val());
				$( "#"+changeIdIs ).datepicker( "option", "minDate", new Date(dataGirata) );
			}
        });	
		$( ".chooseDate2" ).datepicker({
			numberOfMonths: 1,
			dateFormat: "dd/mm/yy",
			onClose: function() {
				var idToChange = $(this).attr("id").split("__");
				changeIdIs="andata_data_arrivo__"+idToChange[1];
				dataGirata = parseDate($(this).val());
				$( "#"+changeIdIs ).datepicker( "option", "maxDate", new Date(dataGirata) );
			}
		});			
		$( ".chooseDOB" ).datepicker({
			numberOfMonths: 1,
			dateFormat: "dd/mm/yy",
			changeMonth: true,
			changeYear: true
		});	
		$( ".chooseDateTime1" ).datepicker({
			numberOfMonths: 1,
			dateFormat: "dd/mm/yy",
			autoSize: false
			//format: "dd/mm/yy HH:ii"
		});	
		$( ".chooseDateTime2" ).datepicker({
			numberOfMonths: 1,
			dateFormat: "dd/mm/yy",
			autoSize: false
			//format: "dd/mm/yy HH:ii"
		});		
		$( ".chooseTime1" ).timepicker({
			autoSize: false,
			format: "HH:ii"
		});	
		$( ".chooseTime2" ).timepicker({
			autoSize: false,
			format: "HH:ii"
		});			
		$(".airport_ac").autocomplete({
			source: function (request, response) {
					$.ajax({
					  url: "<?php echo base_url(); ?>index.php/agents/searchAP",
					  dataType: "json",
					  data: {
						style: "full",
						term: request.term
					  },
					  success: function( data ) {
						response( $.map( data.airports, function( item ) {
						  return {
							id: item.id,
							label: item.value,
							value: item.value
						  }
						}));
					  }
					});					
			},
			minLength: 3
		});	
		$("#copyFirst").click(function(){
			campi = new Array("nazionalita","andata_apt_arrivo","ritorno_apt_partenza","andata_data_arrivo","data_partenza_campus","data_arrivo_campus","ritorno_data_partenza","andata_volo","ritorno_volo","gl_rif","ora_arrivo_volo","ora_partenza_volo");
			for(index=0;index<campi.length;index++){
				nomecampo = campi[index];
				valorecampo = $("#"+nomecampo+"__<?php echo $idFirstLine?>").val();
				writeValues(valorecampo,"td.td_"+campi[index]);
			}
			campiCheck = new Array("transfer_in","transfer_out");
			for(index=0;index<campiCheck.length;index++){
				nomecampo = campiCheck[index];
				valorecampo = $("#"+nomecampo+"__<?php echo $idFirstLine?>").prop('checked');
				writeCKValues(valorecampo,"td.td_"+campiCheck[index]);
			}			
		});
	});
	
	function parseDate(str) {
		var mdy = str.split('/')
		return new Date(mdy[2], mdy[1]-1, mdy[0]);
	}
	</script>
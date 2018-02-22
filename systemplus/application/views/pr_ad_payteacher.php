<?php $this->load->view('admin_header_center');?>
	<section id="main" class="column">
	<div id="box_radius">
		

			
			<article class="module width_full">
			<header><h3></h3></header>
				<div class="module_content">
				
				<h2>Work Hours/Cost</h2>
				<ol>
				</ol>
				</div>
			<table class="tablesorter" cellspacing="0">
			<thead> 
				<tr> 
   					<th>Date</th> 
    				<th>DayWeek</th> 
    				<th>Status</th> 
    				<th>Detail</th> 
					<th>Note</th>
				</tr> 
			</thead> 
			<tbody> 
				 
				<?php
				//Ore inziali previste sett 15
				$hourinit=$hourweek;
				// Set temp ore lavorative per detreminare i segmenti di pagamento
				$temphourday=0;
				/*
				echo "<pre>";
				print_r($teachers);
				echo "</pre>";
				*/
			foreach($teachers as $key => $item)
				{	

					//echo "------>". count($teachers);
					
					
					list($anno_start, $mese_start, $giorno_start) = explode("-",$item['date_rif']);
					$h = mktime(0, 0, 0, $mese_start, $giorno_start, $anno_start);
					$d = date("F d, Y", $h);
					$w= date("l", $h);

					$hourday=(int)$item['work'];
					//Sia che sia negativo o positivo calcola la diff tra giorni settimana iniziali e valore ore giorno
					$budget=$hourweek + $hourday;
					//Hourweek prende il nuovo valore 
					$hourweek=$budget;
					echo "<tr>";
					echo "<td>" .$d . "</td><td>" . $w . " </td> ";
					if($hourday==0){
						$temphourday=$temphourday+3;
						echo "<td><strong>On budget: </strong>".$hourday."</td><td>".$temphourday."</td><td></td>";
					}elseif($hourday>0){
						$temphourday=$temphourday+($hourday+3);
						echo "<td><strong>Over budget:  " . $hourday . "</strong></td><td>".$temphourday."</td><td>".$item['motivi']."</td>";
					}elseif($hourday<0){
						$temphourday=$temphourday+($hourday+3);
						
						echo "<td><strong>Under budget:  " . $hourday . "</strong></td><td>".$temphourday."</td><td>".$item['motivi']."</td>";
					}
					echo "</tr>";
					// Se corrisponde ad un numero dell'array dei giorni di pagamento es: 100 gg lavorativi
					for($z=0; $z<count($time_pay); $z++){

					if($key==$time_pay[$z]){
						 
						 echo "<tr><td colspan=3 style=\"background-color:#f0f0f0;\"><h3> Effective hours work - " .$temphourday."</h3><h3>Effective cost work - " .$temphourday*$salary_hours."</h3></td><td style=\"background-color:#fafafa;\" colspan=1 align=\"center\">";

						 if($checkpay>=$time_pay[$z] || $checkpay=="yes"){
							echo "Status payment is: Authorized";
							 
						 }else{
							 
							 echo form_open('payroll/autorizza/'.$this->uri->segment(3)."/".$this->uri->segment(4));
							 echo "<h3>Authorized Payment?</h3>";
							 echo "<input type=\"hidden\" name=\"autorizza\" value=\"".$key."\">";
							 echo "<input type=\"submit\" value=\" Submit \" />";
							 echo "</form>";
						 }	 
						 echo "</td></tr>";

						 //Resetto tempday per il prossimo segmento
						 $temphourday=0;
					}

					}
					
			}
				
				// Actual Cost
				$actualcost=$hourweek * $salary_hours;
				echo "<tr><td><strong>Budget hours all contract time:</strong>" . $hourinit . "</td></tr><tr><td><strong>Hours worked:</strong> " . $hourweek;
				echo "</td></tr><tr><td><strong>Budget cost:</strong> " . $costo_previsto;
				echo "</td></tr><tr><td><strong>Actual cost:</strong> " . $hourweek * $salary_hours . "</td></tr>";
				echo "</td></tr><tr><td><strong>Holiday Pay Slip:</strong> " . number_format($actualcost * 10.77/100,2) . "</td></tr>";
				?>
				
			</tbody> 
			</table>
			<?php
				//Sommo le attività
				if($details){
				$sumactivity=0;
				$sumactivity=$details[0]['activity_one'] + $details[0]['activity_two'];
				$totactivity=$sumactivity * 25;
				$actcost=$hourweek * $salary_hours;
				
				$totale=$actcost+$totactivity;
				
				echo "<hr/>";
				echo "<div style=\"padding:10px; background-color:#f3f3f3\">";
				echo "<p class=\"overview_type\">Hour of activity: " . $sumactivity . "</p>";
				echo "<p class=\"overview_type\">Budget of activity: " . $totactivity . "</p>";
				echo "<h2>Total: " . $totale . "</h2>";

				echo "</div>";
				echo "<hr/>";
				echo "</div><!-- end of #tab2 -->";
			
				}
				echo "</div>";
				echo "<article class=\"module width_full\">";
				echo "<header><h3>". $heading . "</h3></header>";
				echo "<div class=\"module_content\">";
					echo "<div class=\"module_content\">";
									
					if($details){
					
						echo "<h3>Residential: " . $details[0]['residential'] ;
						echo " - Activity one: " . $details[0]['activity_one'] ;
						echo " - Activity two: " . $details[0]['activity_two'];
						echo " - Bonus: " . $details[0]['bonus'];
						echo " - P: " . $details[0]['p'] . "</h3>";
						
					
					}

					foreach($pay as $detail){
					echo "<h2>".$detail['nome']. " - " . $detail['cognome']. "</h2>";
					echo "<h4>Contract from: ".$detail['date_start']. " to: " . $detail['date_end']. "</h4>";
					echo "<h4>Salary Hours " . $salary_hours . "</h4>";
					echo "<h4>Salary Week " . $costo_settimana . "</h4>";
					
					echo "<div style=\"display:block; float:left;  width:50%; margin:4px; padding:10px; background-color:#fff\">";
					echo "<h3>Bank Details</h3>";
					echo "<h4>Sortcode:</h4>".$detail['sortcode']. " <h4>Account Number</h4> " . $detail['account_number']. " <h4>Insurance</h4> " . @$detail['insurance']. "<br>";
					echo "</div>";
					echo "<div style=\"margin:4px;\">";
					echo "<h3>Teachers Details</h3>";
					echo "<h4>Nationality:</h4> " . $detail['nationality']. " <h4>Address </h4>" . $detail['address']. " <h4>Mail </h4>" . $detail['email']. "<br>";
					echo "<h4>County:</h4> " . $detail['county']. " <h4>Postcode</h4>" . $detail['postcode']. " <h4>Town </h4>" . $detail['towncity']. "<br>";
					echo "</div>";
				}
					echo "<br><br>";
					if($checkpay=="yes"){
							echo "Status payment is: Authorized";
					}else{
							echo form_open('payroll/autorizza/'.$this->uri->segment(3)."/".$this->uri->segment(4));
							echo "<h3>Close Payment Contract</h3>";
							echo "<select name=\"autorizza\"><option value=\"\" ></option><option value=\"yes\" >yes</option><option value=\"no\">no</option></select>";
							echo "<input type=\"submit\" value=\" Submit \" />";
							echo "</form>";
					}
					echo "</div>";
					echo "</article>";

		$this->load->view('footer_html5');

?>
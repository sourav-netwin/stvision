<?php $this -> load -> view('plused_header'); ?>
<style type="text/css">
	@media(max-width: 650px){
		table td{
			min-height: 15px !important;
		}
	}
	@media(max-width: 430px){
		.dataTables_length{
			float:left !important;
		}
	}
	.summary-table{
		width: 100%;
	}
	.summary-table td, .summary-table th {
		padding: 6px;
		text-align: center;
	}
	.summary-table td, .summary-table th {
		border: 1px solid #D2D2D2;
		border-collapse: collapse;
	}
	.summary-head {
		font-size: 13px;
	}
	@media(max-width: 825px){
		.grid_6{
			width: 98% !important;
			margin-bottom: 10px;
		}
	}

	.dvd_div {
		border: 1px solid #D2D2D2;
	}
	.summary-main{
		margin-top: 10px;
		margin-bottom: 10px;
	}
</style>
<!-- The container of the sidebar and content box -->
<div role="main" id="main" class="container_12 clearfix">

	<!-- The blue toolbar stripe -->
	<section class="toolbar">
		<div class="user">
			<div class="avatar">
				<img src="<?php echo base_url(); ?>img/layout/content/toolbar/user/avatar.png">
			</div>
			<span><?php echo $this -> session -> userdata('businessname') ?></span>
			<ul>
				<?php
				$bOArray = array(200, 300, 400, 100, 550); // BACKOFFICE USERS ROLE IDS
				if ($this -> session -> userdata('username') && in_array($this -> session -> userdata('role'), $bOArray)) {
					?>
					<li><a href="<?php echo base_url(); ?>index.php/backoffice/profile">Profile</a></li>
					<li class="line"></li>
					<li><a href="<?php echo base_url(); ?>index.php/backoffice/logout">Logout</a></li>
					<?php
				}
				elseif ($this -> session -> userdata('role') != 97) {
					?>
					<li><a href="<?php echo base_url(); ?>index.php/agents/changeCredential">Profile</a></li>
					<li class="line"></li>
					<li><a href="<?php echo base_url(); ?>index.php/agents/logout">Logout</a></li>
					<?php
				}
				else {
					?>
					<li><a href="<?php echo base_url(); ?>index.php/agents/logout">Logout</a></li>
				<?php } ?>

			</ul>
		</div>
	</section><!-- End of .toolbar-->

	<?php $this -> load -> view('plused_sidebar'); ?>

	<!-- Here goes the content. -->
	<section id="content" class="container_12 clearfix" data-sort=true>
		<h1 class="grid_12 margin-top no-margin-top-phone">ST History Data Report</h1>
		<div class="row" style="margin-right:10px;">
			<div class="grid_12" id="report-view">
				<input id="backToFilter" class="export-button" type="button" value="Back" />
				<?php if (!empty($report_data)) { ?>
					<input id="exportExcelWithoutGroup" class="export-button" type="button" value="Export all" />
                                        <input id="exportExcel" class="export-button" type="button" value="Export" />
					<?php
				}
				if (!empty($summary_data)) {
					echo '<div class="grid_12 summary-main"><table class="summary-table">';
					$tbCnt = 0;
					$totalFatturato = 0;
					foreach ($summary_data as $tipoProdo => $countries) {
						echo '<tr><th colspan="3" style="text-align: left"><strong>Tipologia Prodotto:</strong> ' . $tipoProdo . '</th></tr><tr><th>Country</th><th>Campus</th><th>Fatturato</th></tr>';
						foreach ($countries as $country => $values) {
							$ct = 0;
							echo '<tr><td style="vertical-align:middle" rowspan="' . sizeof($values) . '">' . $country . '</td>';
							foreach ($values as $key => $val) {
								echo $ct > 0 ? '<tr>' : '';
								echo '<td>' . $val['codice_destinazione'] . '</td>';
								echo '<td>' . $val['fatturato'] . '</td>';
								$totalFatturato += $val['fatturato'] * 1;
								echo $ct > 0 ? '</tr>' : '';
								$ct++;
							}
							echo '</tr>';
						}
					}
					echo '<tr><th colspan="2" style="text-align: right">Total</th><th>' . $totalFatturato . '</th></tr></table></div>';
				}
				?>
				<table  class="dynamic styled webservice-report-table" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true}]}'>
					<thead>
						<tr>
							<th>Anno</th>
							<th>Collaboratore</th>
							<th>Provincia collaboratore</th>
							<th>Nazione collaboratore</th>
							<th>Regione collaboratore</th>
							<th>Macroregione collaboratore</th>
							<th>Codice prodotto</th>
							<th>Tipologia prodotto</th>
							<th>Destinazione</th>
							<th>Destinazione nazione</th>
							<th>Pax</th>
							<th>Fatturato</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($report_data as $data) {
							?>
							<tr>
								<td class="center"><?php echo $data["anno"]; ?></td>
								<td class="center"><?php echo $data['collaboratore']; ?></td>
								<td class="center"><?php echo $data["collaboratoreProvincia"]; ?></td>
								<td class="center"><?php echo $data["collaboratoreNazione"]; ?></td>
								<td class="center"><?php echo $data["collaboratoreRegione"]; ?></td>
								<td class="center"><?php echo $data["collaboratoreMacroRegione"]; ?></td>
								<td class="center"><?php echo $data["codice_prodotto"]; ?></td>
								<td class="center"><?php echo $data["tipologia_prodotto"]; ?></td>
								<td class="center"><?php echo $data["destinazione"]; ?></td>
								<td class="center"><?php echo $data["destinazione_nazione"]; ?></td>
								<td class="center"><?php echo $data["pax"]; ?></td>
								<td class="center"><?php echo number_format($data["fatturato"]*1/100,2,',','.'); ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</section>

</div>

<script>
    var SITE_PATH = "<?php echo base_url(); ?>index.php/";
    $(document).ready(function() {
        $( "li#mnusthistory" ).addClass("current");
        $( "li#mnusthistory a" ).addClass("open");
        $( "li#mnusthistory ul.sub" ).css('display','block');
        $( "li#mnusthistory ul.sub li#mnusthistory_2" ).addClass("current");

        $("#backToFilter").click(function(){
			window.location.href= SITE_PATH + "sthistory/report";
        });

        $("#exportExcel").click(function(){
			var exportForm = $('<form method="post" action="'+SITE_PATH + "sthistory/report"+'"></form>').appendTo('body');
			exportForm.append("<input type='hidden' name='txtCollaboratore' value='<?php echo $collaboratore; ?>' />");
			exportForm.append("<input type='hidden' name='txtCodiceProdotto' value='<?php echo $codice_prodotto; ?>' />");
			exportForm.append("<input type='hidden' name='selTipologiaProdotto' value='<?php echo (!empty($tipologia_prodotto) ) ? implode(",", $tipologia_prodotto) : ""; ?>' />");
			exportForm.append("<input type='hidden' name='selDestinazioneNazione' value='<?php echo (!empty($destinazione_nazione) ) ? implode(",", $destinazione_nazione) : ""; ?>' />");
			exportForm.append("<input type='hidden' name='type' value='export' />");
			
                        exportForm.append("<input type='hidden' name='selRegione' value='<?php echo $regione; ?>' />");
                        exportForm.append("<input type='hidden' name='selMacroRegione' value='<?php echo $macro_regione; ?>' />");
                        exportForm.append("<input type='hidden' name='selNazione' value='<?php echo $nazione; ?>' />");
                        
                        exportForm.append("<input type='hidden' name='selCollaboratoreProvincia' value='<?php echo $collaboratoreProvincia; ?>' />");
			exportForm.append("<input type='hidden' name='selCollaboratoreNazione' value='<?php echo $collaboratoreNazione; ?>' />");
			exportForm.append("<input type='hidden' name='selCollaboratoreRegione' value='<?php echo $collaboratoreRegione; ?>' />");
			exportForm.append("<input type='hidden' name='selCollaboratoreMacroRegione' value='<?php echo $collaboratoreMacroRegione; ?>' />");
			
                        exportForm.append("<input type='hidden' name='selDestinazione' value='<?php echo $destinazione; ?>' />");
			exportForm.append("<input type='hidden' name='selAnno' value='<?php echo $anno; ?>' />");
			
                        exportForm.append("<input type='hidden' name='selStartAge' value='<?php echo $ageStart; ?>' />");
			exportForm.append("<input type='hidden' name='selEndAge' value='<?php echo $ageEnd; ?>' />");
			exportForm.submit();
        });
        
        $("#exportExcelWithoutGroup").click(function(){
			var exportForm = $('<form method="post" action="'+SITE_PATH + "sthistory/report"+'"></form>').appendTo('body');
			exportForm.append("<input type='hidden' name='txtCollaboratore' value='<?php echo $collaboratore; ?>' />");
			exportForm.append("<input type='hidden' name='txtCodiceProdotto' value='<?php echo $codice_prodotto; ?>' />");
			exportForm.append("<input type='hidden' name='selTipologiaProdotto' value='<?php echo (!empty($tipologia_prodotto) ) ? implode(",", $tipologia_prodotto) : ""; ?>' />");
			exportForm.append("<input type='hidden' name='selDestinazioneNazione' value='<?php echo (!empty($destinazione_nazione) ) ? implode(",", $destinazione_nazione) : ""; ?>' />");
			exportForm.append("<input type='hidden' name='type' value='exportAll' />");
			
                        exportForm.append("<input type='hidden' name='selRegione' value='<?php echo $regione; ?>' />");
                        exportForm.append("<input type='hidden' name='selMacroRegione' value='<?php echo $macro_regione; ?>' />");
                        exportForm.append("<input type='hidden' name='selNazione' value='<?php echo $nazione; ?>' />");
                        
                        exportForm.append("<input type='hidden' name='selCollaboratoreProvincia' value='<?php echo $collaboratoreProvincia; ?>' />");
			exportForm.append("<input type='hidden' name='selCollaboratoreNazione' value='<?php echo $collaboratoreNazione; ?>' />");
			exportForm.append("<input type='hidden' name='selCollaboratoreRegione' value='<?php echo $collaboratoreRegione; ?>' />");
			exportForm.append("<input type='hidden' name='selCollaboratoreMacroRegione' value='<?php echo $collaboratoreMacroRegione; ?>' />");
			
                        exportForm.append("<input type='hidden' name='selDestinazione' value='<?php echo $destinazione; ?>' />");
			exportForm.append("<input type='hidden' name='selAnno' value='<?php echo $anno; ?>' />");
			
                        exportForm.append("<input type='hidden' name='selStartAge' value='<?php echo $ageStart; ?>' />");
			exportForm.append("<input type='hidden' name='selEndAge' value='<?php echo $ageEnd; ?>' />");
			exportForm.submit();
        });
    });
</script>
<?php $this -> load -> view('plused_footer'); ?>

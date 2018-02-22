<?php $this -> load -> view('plused_header'); ?>

<style type="text/css">
	@media(max-width: 900px){
		.grid_6.mr-top-10{
			width: 98% !important;
		}
		.grid_6.mr-top-10{
			height: auto !important;
			min-height: auto !important;
		}
	}
	@media(max-width: 400px){
		.form-data.grid_6{
			width: 98% !important;
		}
	}
</style>

<!-- The container of the sidebar and content box -->
<div role="main" id="main" class="container_12 clearfix reportsFilters">

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
	<section id="content" class="container_12 clearfix survey-report-content" data-sort=true>
		<h1 class="grid_12 margin-top no-margin-top-phone">ST History Data Report</h1>
		<div class="row">
			<form class="webservice-report-form" id="frmSTHistoryReport" action="<?php echo base_url(); ?>index.php/sthistory/report" method="post">
				<div class="grid_6 mr-top-10"  >
					<div class="box">

						<div class="header">
							<h2>Select options</h2>
						</div>
						<div class="content" style="margin: 10px;">

							<div class="form-data grid_6">
								<div class="left-class">
									<label for="txtCollaboratore" style="width: 115px;">
										<strong>Collaboratore</strong>
									</label>
								</div>
								<div class="left-class form-custom-select-container">
									<select id="txtCollaboratore" name="txtCollaboratore">
										<option value="">All</option>
										<?php
										if ($collaboratore) {
											foreach ($collaboratore as $data) {
												?>
												<option value="<?php echo $data['collaboratore']; ?>"><?php echo $data['collaboratore']; ?></option>
												<?php
											}
										}
										?>
									</select>
								</div>
							</div>
                                                        <div class="form-data grid_6">
								<div class="left-class">
									<label for="selCollaboratoreProvincia" style="width: 115px;">
										<strong>Provincia Collaboratore</strong>
									</label>
								</div>
								<div class="left-class form-custom-select-container">
									<select id="selCollaboratoreProvincia" name="selCollaboratoreProvincia">
										<option value="">All</option>
										<?php
										if ($collaboratoreProvincia) {
											foreach ($collaboratoreProvincia as $provincia) {
												?>
												<option value="<?php echo $provincia['collaboratoreProvincia']; ?>"><?php echo $provincia['collaboratoreProvincia']; ?></option>
												<?php
											}
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-data grid_6">
								<div class="left-class">
									<label for="selCollaboratoreRegione" style="width: 115px;">
										<strong>Regione Collaboratore</strong>
									</label>
								</div>
								<div class="left-class form-custom-select-container">
									<select id="selCollaboratoreRegione" name="selCollaboratoreRegione">
										<option value="">All</option>
										<?php
										if ($collaboratoreRegione) {
											foreach ($collaboratoreRegione as $data) {
												?>
												<option value="<?php echo $data['collaboratoreRegione']; ?>"><?php echo $data['collaboratoreRegione']; ?></option>
												<?php
											}
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-data grid_6">
								<div class="left-class">
									<label for="selCollaboratoreMacroRegione" style="width: 115px;">
										<strong>Macroregione Collaboratore</strong>
									</label>
								</div>
								<div class="left-class form-custom-select-container">
									<select id="selCollaboratoreMacroRegione" name="selCollaboratoreMacroRegione">
										<option value="">All</option>
										<?php
										if ($collaboratoreMacroRegione) {
											foreach ($collaboratoreMacroRegione as $data) {
												?>
												<option value="<?php echo $data['collaboratoreMacroRegione']; ?>"><?php echo $data['collaboratoreMacroRegione']; ?></option>
												<?php
											}
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-data grid_6">
								<div class="left-class">
									<label for="selCollaboratoreNazione" style="width: 115px;">
										<strong>Nazione Collaboratore</strong>
									</label>
								</div>
								<div class="left-class form-custom-select-container">
									<select id="selCollaboratoreNazione" name="selCollaboratoreNazione">
										<option value="">All</option>
										<?php
										if ($collaboratoreNazione) {
											foreach ($collaboratoreNazione as $data) {
												?>
												<option value="<?php echo $data['collaboratoreNazione']; ?>"><?php echo $data['collaboratoreNazione']; ?></option>
												<?php
											}
										}
										?>
									</select>
								</div>
							</div>
						</div>

					</div>
				</div>

				<div class="grid_6 mr-top-10"  >
					<div class="box">

						<div class="header">
							<h2>Select options</h2>
						</div>
						<div class="content" style="margin: 10px;">

							<div class="form-data grid_6">
								<div class="left-class">
									<label for="txtCodiceProdotto" style="width: 115px;">
										<strong>Codice Prodotto</strong>
									</label>
								</div>
								<div class="left-class form-custom-select-container">
									<select id="txtCodiceProdotto" name="txtCodiceProdotto">
										<option value="">All</option>
										<?php
										if ($codice_prodotto) {
											foreach ($codice_prodotto as $data) {
												?>
												<option value="<?php echo $data['codice_prodotto']; ?>"><?php echo $data['codice_prodotto']; ?></option>
												<?php
											}
										}
										?>
									</select>
								</div>
							</div>

							<div class="form-data grid_6" >
								<div class="left-class">
									<label for="selTipologiaProdotto" style="width: 115px;">
										<strong>Tipologia Prodotto</strong>
									</label>
								</div>
								<div>
									<select id="selTipologiaProdotto" name="selTipologiaProdotto[]" multiple="multiple">
										<?php
										if ($tipologia_prodotto) {
											foreach ($tipologia_prodotto as $tp) {
												?>
												<option value="<?php echo $tp['tipologia_prodotto']; ?>"><?php echo $tp['tipologia_prodotto']; ?></option>
												<?php
											}
										}
										?>
									</select>
								</div>
							</div>

							<div class="form-data grid_6" >
								<div class="left-class">
									<label for="selDestinazione" style="width: 115px;">
										<strong>Destinazione</strong>
									</label>
								</div>
								<div>
									<select id="selDestinazione" name="selDestinazione">
										<option value="">All</option>
										<?php
										if ($destinazione) {
											foreach ($destinazione as $data) {
												?>
												<option value="<?php echo $data['destinazione']; ?>"><?php echo $data['destinazione']; ?></option>
												<?php
											}
										}
										?>
									</select>
								</div>
							</div>

							<div class="form-data grid_6" >
								<div class="left-class">
									<label for="selDestinazioneNazione" style="width: 115px;">
										<strong>Destinazione Nazione</strong>
									</label>
								</div>
								<div>
									<select id="selDestinazioneNazione" name="selDestinazioneNazione[]" multiple="multiple">
										<?php
										if ($destinazione_nazione) {
											foreach ($destinazione_nazione as $dn) {
												?>
												<option value="<?php echo $dn['destinazione_nazione']; ?>"><?php echo $dn['destinazione_nazione']; ?></option>
												<?php
											}
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-data grid_6" >
								<div class="left-class">
									<label for="selAnno" style="width: 115px;">
										<strong>Anno</strong>
									</label>
								</div>
								<div>
									<select id="selAnno" name="selAnno">
										<option value="">All</option>
										<?php
										if ($anno) {
											foreach ($anno as $data) {
												?>
												<option value="<?php echo $data['anno']; ?>"><?php echo $data['anno']; ?></option>
												<?php
											}
										}
										?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
                            <div class="grid_6 mr-top-10" >
                                    <div class="box">
                                        <div class="header">
                                                <h2>Select options</h2>
                                        </div>
                                        <div class="content" style="margin: 10px;">
                                                <div class="form-data grid_6">
                                                        <div class="left-class">
                                                                <label for="selRegione" style="width: 115px;">
                                                                        <strong>Regione</strong>
                                                                </label>
                                                        </div>
                                                        <div class="left-class form-custom-select-container">
                                                                <select id="selRegione" name="selRegione">
                                                                        <option value="">All</option>
                                                                        <?php
                                                                        if ($regione) {
                                                                                foreach ($regione as $data) {
                                                                                        ?>
                                                                                        <option value="<?php echo $data['regione']; ?>"><?php echo $data['regione']; ?></option>
                                                                                        <?php
                                                                                }
                                                                        }
                                                                        ?>
                                                                </select>
                                                        </div>
                                                </div>
                                                <div class="form-data grid_6">
                                                        <div class="left-class">
                                                                <label for="selMacroRegione" style="width: 115px;">
                                                                        <strong>Macro Regione</strong>
                                                                </label>
                                                        </div>
                                                        <div class="left-class form-custom-select-container">
                                                                <select id="selMacroRegione" name="selMacroRegione">
                                                                        <option value="">All</option>
                                                                        <?php
                                                                        if ($macro_regione) {
                                                                                foreach ($macro_regione as $data) {
                                                                                        ?>
                                                                                        <option value="<?php echo $data['macro_regione']; ?>"><?php echo $data['macro_regione']; ?></option>
                                                                                        <?php
                                                                                }
                                                                        }
                                                                        ?>
                                                                </select>
                                                        </div>
                                                </div>
                                                <div class="form-data grid_6">
                                                        <div class="left-class">
                                                                <label for="selNazione" style="width: 115px;">
                                                                        <strong>Nazione</strong>
                                                                </label>
                                                        </div>
                                                        <div class="left-class form-custom-select-container">
                                                                <select id="selNazione" name="selNazione">
                                                                        <option value="">All</option>
                                                                        <?php
                                                                        if ($nazione) {
                                                                                foreach ($nazione as $data) {
                                                                                        ?>
                                                                                        <option value="<?php echo $data['nazione']; ?>"><?php echo $data['nazione']; ?></option>
                                                                                        <?php
                                                                                }
                                                                        }
                                                                        ?>
                                                                </select>
                                                        </div>
                                                </div>
                                                <div class="form-data grid_6">
                                                        <div class="left-class">
                                                                <label for="selStartAge" style="width: 115px;">
                                                                        <strong>Age range</strong>
                                                                </label>
                                                        </div>
                                                        <div class="left-class form-custom-select-container">
                                                            <div style="float: left;width: 45%;" >
                                                                <select id="selStartAge" name="selStartAge">
                                                                        <option value="">Any</option>
                                                                        <?php
                                                                                for ($ageLimit = 5; $ageLimit <60; $ageLimit++ ) {
                                                                                        ?>
                                                                                        <option value="<?php echo $ageLimit; ?>"><?php echo $ageLimit; ?> years</option>
                                                                                        <?php
                                                                                }
                                                                        ?>
                                                                </select>
                                                            </div>
                                                            <div style="float: left;margin-left: 16px;width: 45%;" >
                                                                <select id="selEndAge" name="selEndAge">
                                                                        <option value="">Any</option>
                                                                        <?php
                                                                                for ($ageEndLimit = 6; $ageEndLimit <=60; $ageEndLimit++ ) {
                                                                                        ?>
                                                                                        <option value="<?php echo $ageEndLimit; ?>"><?php echo $ageEndLimit; ?> years</option>
                                                                                        <?php
                                                                                }
                                                                        ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="grid_12" >
                                <input id="btnReport" type="submit" value="Report" style="float: right;width:100px!important;">
                            </div>
			</form>
		</div>
	</section>

</div>
<script>
	var SITE_PATH = "<?php echo base_url(); ?>index.php/";
	$(document).ready(function() {
		$('form').removeClass('no-box');
		$( "li#mnusthistory" ).addClass("current");
		$( "li#mnusthistory a" ).addClass("open");
		$( "li#mnusthistory ul.sub" ).css('display','block');
		$( "li#mnusthistory ul.sub li#mnusthistory_2" ).addClass("current");
	});
</script>
<?php $this -> load -> view('plused_footer'); ?>

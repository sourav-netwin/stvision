<!--------------Datatable CSS and JS---------------->
<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/style.css?v=1.1">

<!---------------Sweet Alert CSS and JS----------------->
<link rel="stylesheet" href="<?php echo LTE; ?>plugins/sweetalert/sweetalert.css">
<script src="<?php echo LTE; ?>custom/custom.js"></script>
<script src="<?php echo LTE; ?>plugins/sweetalert/sweetalert.min.js"></script>

<!------------custom javascript for program course------------>
<script>
	var pageType = 'list';
	var inactive_confirmation = "<?php echo $this->lang->line("inactive_confirmation"); ?>";
	var active_confirmation = "<?php echo $this->lang->line("active_confirmation"); ?>";
	var delete_confirmation = "<?php echo $this->lang->line("delete_confirmation"); ?>";
</script>
<script src="<?php echo LTE; ?>frontweb/custom/ministay_program.js?v=1.1"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel box">
				<div class="box-header col-sm-12">
					<div class="row">
						<div class="col-sm-6 btn-create">
							<a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/frontweb/ministay_program/add_edit"><i class="fa fa-plus" aria-hidden="true"></i> Add ministay program</a>
						</div>
						<?php showSessionMessageIfAny($this);?>
					</div>
				</div>
				<div class="x_content box-body">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Si no.</th>
								<th>Icon</th>
								<th>Program name</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

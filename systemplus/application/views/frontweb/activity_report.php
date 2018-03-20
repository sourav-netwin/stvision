<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/style.css">

<!------------custom javascript for for master modules------------>
<script>
	var please_enter_dynamic = "<?php echo $this->lang->line("please_enter_dynamic"); ?>";
	var please_select_dynamic = "<?php echo $this->lang->line("please_select_dynamic"); ?>";
	var start_end_date_validation = "<?php echo $this->lang->line("start_end_date_validation"); ?>";
</script>
<script src="<?php echo LTE; ?>frontweb/custom/master_activity.js?v=0.3"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel box">
				<div class="box-header col-sm-12">
					<div class="row">
						<div class="col-lg-12">
<?php
							$formAttribute = array(
								'class' => 'show-custom-error-tag',
								'id' => 'activityReportForm',
								'method' =>'post'
							);
							echo form_open_multipart('frontweb/master_activity/report' , $formAttribute);
?>
								<input type="hidden" name="flag" value="search">
								<div class="col-lg-3 form-group">
<?php
									$centreId = (isset($post['centre_id'])) ? $post['centre_id'] : '';
									echo form_dropdown('centre_id' , getCentreDetails() , $centreId , 'class="form-control" id="centre_id"');
?>
								</div>
								<div class="col-lg-3 form-group">
<?php
									$inputAttribute = array(
										'name' => 'start_date',
										'id' => 'start_date',
										'class' => 'form-control datepicker',
										'placeholder' => 'Start Date',
										'value' => (isset($post['start_date'])) ? $post['start_date'] : ''
									);
									echo form_input($inputAttribute);
?>
									<span class="error showDateError"></span>
								</div>
								<div class="col-lg-3 form-group">
<?php
									$inputAttribute = array(
										'name' => 'end_date',
										'id' => 'end_date',
										'class' => 'form-control datepicker',
										'placeholder' => 'End Date',
										'value' => (isset($post['end_date'])) ? $post['end_date'] : ''
									);
									echo form_input($inputAttribute);
?>
								</div>
								<div class="col-lg-3 form-group">
									<button class="btn btn-warning" type="submit">
										<i class="fa fa-search"></i>&nbsp;&nbsp;Search
									</button>
<?php
									if(!empty($post))
									{
?>
										<button class="btn btn-success" type="button" style="margin-left: 10px;" onclick="window.location='export_to_excel'">
											<i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Export to excel
										</button>
<?php
									}
?>
								</div>
							<?php echo form_close(); ?>
						</div>
						<div class="form-conrol"></div>
					</div>
				</div>
				<div class="x_content box-body">
<?php
					if(!empty($post))
					{
?>
						<table id="datatable" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Date</th>
									<th>Type of activity</th>
									<th>Location</th>
									<th>Activity</th>
									<th>From time</th>
									<th>To time</th>
									<th>Name</th>
								</tr>
								<tr>
									<th>
										<select data-field_ref = 'date' class="form-control filterDropdown">
											<option value="">All</option>
<?php
											if(!empty($post['dropdownArr']['dateValue']))
											{
												foreach($post['dropdownArr']['dateValue'] as $value)
													echo '<option value="'.$value.'">'.date('d-M-Y' , strtotime($value)).'</option>';
											}
?>
										</select>
									</th>
									<th>
										<select data-field_ref = 'program_name' class="form-control filterDropdown">
											<option value="">All</option>
<?php
											if(!empty($post['dropdownArr']['proramName']))
											{
												foreach($post['dropdownArr']['proramName'] as $value)
													echo '<option value="'.$value.'">'.$value.'</option>';
											}
?>
										</select>
									</th>
									<th>
										<select data-field_ref = 'location' class="form-control filterDropdown">
											<option value="">All</option>
<?php
											if(!empty($post['dropdownArr']['location']))
											{
												foreach($post['dropdownArr']['location'] as $value)
													echo '<option value="'.$value.'">'.$value.'</option>';
											}
?>
										</select>
									</th>
									<th>
										<select data-field_ref = 'activity' class="form-control filterDropdown">
											<option value="">All</option>
<?php
											if(!empty($post['dropdownArr']['activity']))
											{
												foreach($post['dropdownArr']['activity'] as $value)
													echo '<option value="'.$value.'">'.$value.'</option>';
											}
?>
										</select>
									</th>
									<th>
										<select data-field_ref = 'from_time' class="form-control filterDropdown">
											<option value="">All</option>
<?php
											if(!empty($post['dropdownArr']['fromTime']))
											{
												foreach($post['dropdownArr']['fromTime'] as $value)
													echo '<option value="'.$value.'">'.date('H:i' , strtotime($value)).'</option>';
											}
?>
										</select>
									</th>
									<th>
										<select data-field_ref = 'to_time' class="form-control filterDropdown">
											<option value="">All</option>
<?php
											if(!empty($post['dropdownArr']['toTime']))
											{
												foreach($post['dropdownArr']['toTime'] as $value)
													echo '<option value="'.$value.'">'.date('H:i' , strtotime($value)).'</option>';
											}
?>
										</select>
									</th>
									<th>
										<select data-field_ref = 'managed_by' class="form-control filterDropdown">
											<option value="">All</option>
<?php
											if(!empty($post['dropdownArr']['managedBy']))
											{
												foreach($post['dropdownArr']['managedBy'] as $value)
													echo '<option value="'.$value.'">'.$value.'</option>';
											}
?>
										</select>
									</th>
								</tr>
							</thead>
							<tbody class="activityreportBody">
<?php
								if(!empty($post['details']))
								{
									foreach($post['details'] as $value)
									{
?>
										<tr>
											<td><?php echo date('d-M-Y' , strtotime($value['date'])); ?></td>
											<td><?php echo $value['program_name']; ?></td>
											<td><?php echo $value['location']; ?></td>
											<td><?php echo $value['activity']; ?></td>
											<td><?php echo date('H:i' , strtotime($value['from_time'])); ?></td>
											<td><?php echo date('H:i' , strtotime($value['to_time'])); ?></td>
											<td><?php echo $value['managed_by']; ?></td>
										</tr>
<?php
									}
								}
?>
							</tbody>
						</table>
<?php
					}
					else
						echo '<p style="font-size: 20px;" class="error text-center">No activity available</p>';
?>
				</div>
			</div>
		</div>
	</div>
</div>

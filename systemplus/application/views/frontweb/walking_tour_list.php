<!--------------Datatable CSS and JS---------------->
<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>

<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/style.css">

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel box">
				<div class="box-header col-sm-12">
					<div class="row">
						<?php showSessionMessageIfAny($this);?>
					</div>
				</div>
				<div class="x_content box-body">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Si no.</th>
								<th>Centre</th>
								<th>Video</th>
								<th>Description</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!---------------------Edit Description Modal Start----------------->
<div class="modal fade" id="editDescriptionModal" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Description</h4>
			</div>
<?php
			$formAttribute = array(
				'class' => 'form-horizontal form-label-left show-custom-error-tag',
				'id' => 'editDescriptionModalForm',
				'method' =>'post'
			);
			echo form_open_multipart('' , $formAttribute);
?>
				<input type="hidden" name="plus_walking_tour_id" id="plus_walking_tour_id">
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Description<span class="required">*</span></label>
						<div class="col-md-9 col-sm-9 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'description',
								'id' => 'description',
								'class' => 'form-control',
								'rows' => 6
							);
							echo form_textarea($inputFieldAttribute);
?>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-info">Update</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!---------------------Edit description Modal End----------------->

<script type = "text/javascript">
	var pageHighlightMenu = "frontweb/walking_tour";
	$(document).ready(function(){
		//For Datatable
		var table = $("#datatable").DataTable({
			processing : true,
			stateSave : true,
			serverSide : true,
			ajax : {
				url : '<?php echo base_url(); ?>index.php/frontweb/walking_tour/get_walking_tour',
				type : 'POST'
			},
			aoColumnDefs: [
				{"bSortable" : false , "aTargets" : [1,2,3]}
			]
		});

		//After click on the edit icon , open edit modal to edit the description
		$(document).on('click' , '.editDescription' , function(){
			$('#plus_walking_tour_id').val($(this).data('id'));
			$('#description').val($(this).parent().parent().parent().find('td:eq(3)').text());
			$('#editDescriptionModal').modal();
		});

		//Initialize form validation for features management
		$('#editDescriptionModalForm').validate({
			errorElement : 'span',
			rules : {
				'description' : {
					required : true
				}
			},
			messages : {
				'description' : {
					required : "<?php echo str_replace('**field**' , 'Description' , $this->lang->line('please_enter_dynamic')); ?>"
				}
			}
		});

		//After submit the edit description form , update data in database and update in table also
		$('#editDescriptionModalForm').submit(function(e){
			if($(this).valid())
			{
				e.preventDefault();
				var formData = new FormData(this);
				$.ajax({
					url : '<?php echo base_url(); ?>index.php/frontweb/walking_tour/update',
					type : 'POST',
					data : formData,
					contentType: false,
					cache: false,
					processData: false,
					dataType : 'JSON',
					success : function(response){
						$('#editDescriptionModal').modal('hide');
						table.ajax.reload();
					}
				});
			}
		});
	});
</script>

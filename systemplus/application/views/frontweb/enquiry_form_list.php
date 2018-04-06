<!--------------Datatable CSS and JS---------------->
<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>

<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/style.css?v=1.1">

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel box">
				<div class="x_content box-body">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Si no.</th>
								<th>Added Date</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!---------------------Show enquiry form details Modal Start--------------------->
<div class="modal fade" id="formDetails" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">University Enquiry Form</h4>
			</div>
			<div class="modal-body formDetailsBody"></div>
		</div>
	</div>
</div>
<!---------------------Show enquiry form details Modal End--------------------->

<script type = "text/javascript">
	var pageHighlightMenu = "frontweb/course";
	$(document).ready(function(){
		//For Datatable
		var table = $("#datatable").DataTable({
			processing : true,
			stateSave : true,
			serverSide : true,
			ajax : {
				url : '<?php echo base_url(); ?>index.php/frontweb/course/get_form_details',
				type : 'POST'
			},
			aoColumnDefs: [
				{"bSortable" : false , "aTargets" : [1,2]}
			]
		});

		//After click on extra management icon for pdf management open modal with dynamic content
		$(document).on('click' , '.showDetails' , function(e){
			$.ajax({
				url : '<?php echo base_url(); ?>index.php/frontweb/course/get_user_form',
				type : 'POST',
				data : {'user' : $(this).data('user')},
				success : function(response){
					if(response)
						$('.formDetailsBody').empty().append(response);
				}
			});
			$('#formDetails').modal();
		});
	});
</script>

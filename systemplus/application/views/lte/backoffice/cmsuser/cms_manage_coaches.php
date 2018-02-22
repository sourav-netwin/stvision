<link rel="stylesheet" href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css">

<div class="row">
	<?php
	showSessionMessageIfAny($this);
	?>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-header with-border">
				<h2 class="box-title width-full"><?php echo $breadcrumb2; ?></h2>
                                <div class="box-tools pull-right">
                                    <a title="Add new coach company" data-toggle="tooltip" href="<?php echo base_url() . 'index.php/backoffice/cmsAddCoach'; ?>">
                                        <i class="fa fa-plus"> Add new coach company</i>
                                    </a>
                                </div>
			</div>
			<div class="box-body">
				<table class="datatable table table-bordered table-hover width-full vertical-middle" >
                                    <thead>
                                        <tr>
                                            <th>Company name</th>
                                            <th>Contact name</th>
                                            <th>Email</th>								
                                            <th>Phone</th>
                                            <th class="no-sort">Action</th>						
                                        </tr>
                                    </thead>
					<tbody>
                                            <?php foreach($companies as $company){

                                            ?>
                                                    <tr>
                                                            <td><?php echo htmlspecialchars($company["tra_cp_name"])?></td>
                                                            <td><?php echo htmlspecialchars($company["tra_cp_contact_name"])?></td>
                                                            <td><?php echo $company["tra_cp_email"]?></td>
                                                            <td><?php echo $company["tra_cp_phone"]?></td>
                                                            <td class="center">
                                                                <div class="btn-group">
                                                                    <a class="btn btn-xs btn-w24 btn-info" data-toggle="tooltip" href="<?php echo base_url(); ?>index.php/backoffice/cmsEditCoach/<?php echo $company["tra_cp_id"]?>" title="Edit coach company <?php echo htmlspecialchars($company["tra_cp_name"]);?>">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    <a class="btn btn-xs btn-warning" data-toggle="tooltip" href="<?php echo base_url(); ?>index.php/backoffice/cmsManageBusCoaches/<?php echo $company["tra_cp_id"]?>" title="Edit bus for <?php echo htmlspecialchars($company["tra_cp_name"]);?>">
                                                                        <i class="fa fa-dashboard"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                    </tr>
                                            <?php
                                                    }
                                            ?>
                                        </tbody>
				</table>
			</div>

		</div>
	</div>
</div>
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    $(function(){
        
    });
</script>
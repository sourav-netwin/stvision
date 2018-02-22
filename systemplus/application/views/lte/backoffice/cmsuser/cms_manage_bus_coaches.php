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
				<h2 class="box-title width-full">Manage bus for <?php echo $company["tra_cp_name"]?></h2>
                                
                                <div class="box-tools pull-right">
                                    <a data-toggle="tooltip" href="<?php echo base_url(); ?>index.php/backoffice/cmsAddBusForCoach/<?php echo $idC ?>" title="Add new bus for <?php echo $company["tra_cp_name"]?>">
                                        <i class="fa fa-plus"> Add new bus for <?php echo $company["tra_cp_name"];?></i>
                                    </a>
                                </div>
			</div>
			<div class="box-body">
				<table class="datatable table table-bordered table-hover width-full vertical-middle" >
                                    <thead>
                                        <tr>
                                            <th>Bus name</th>
                                            <th>Number of seats</th>
                                            <th class="no-sort">Action</th>
                                        </tr>
                                    </thead>
					<?php foreach($bus as $bb){?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($bb["tra_bus_name"]);?></td>
                                                    <td><?php echo $bb["tra_bus_seat"]?></td>
                                                    <td class="center">
                                                        <div class="btn-group">
                                                            <a data-toggle="tooltip" class="btn btn-xs btn-w24 btn-info" href="<?php echo base_url(); ?>index.php/backoffice/cmsEditBusForCoach/<?php echo $bb["tra_bus_cp_id"]?>/<?php echo $bb["tra_bus_id"]?>" title="Edit bus <?php echo htmlspecialchars($bb["tra_bus_name"])?>" >
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a data-toggle="tooltip" class="btn btn-xs btn-w24 btn-danger deleteBus" href="<?php echo base_url(); ?>index.php/backoffice/cmsDeleteBus/<?php echo $bb["tra_bus_id"]?>/<?php echo $bb["tra_bus_cp_id"]?>" title="Delete bus <?php echo htmlspecialchars($bb["tra_bus_name"])?>">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        ?>
				</table>
			</div>

		</div>
	</div>
</div>
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    pageHighlightMenu = "backoffice/cmsManageCoaches";
    $(function(){
        $(".deleteBus").click(function(e){
            e.preventDefault();
            if(confirm("Are you sure you want to delete this bus?")){
                    window.location.href=$(this).attr("href");
            }
        });
    });
</script>
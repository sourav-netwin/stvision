<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<link href="<?php echo base_url();?>css/external/jquery-ui-1.8.21.custom.css" rel="stylesheet">  
<section class="">
    <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
            <div class="row">
                <div class="col-sm-6 btn-create">
                    <a href="<?php echo base_url(); ?>index.php/excursion/addedit/<?php echo $exc_type;?>" class="btn btn-primary btn-sm" id="createExcursion" ><i class="fa fa-plus"></i>&nbsp;Create new <?php echo ($exc_type == 'transfer' ? 'transfer' : 'excursion')?></a>
                </div>
                <?php showSessionMessageIfAny($this);?>
            </div>
        </div>
        <div class="box-body">
            <table id="dataTableCampusExcursions" class="datatable table table-bordered table-striped" style="width: 99.98%;">
                <thead>
                    <tr>
                        <th><?php echo ($exc_type == 'transfer' ? 'Transfer' : 'Excursion')?></th>
                        <th>Brief description
                <p>
                    <span style="float: left;margin-top: 5px;" class="label label-success mr-right-5">Mapped campus </span>
                </p>
                        </th>
                        <th>Duration</th>
                        <th>Days</th>
                        <th>Airport</th>
                        <th class="no-sort">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                if($all_excursions)
                foreach($all_excursions as $excursion){
                ?>
                        <tr>
                                <td class="center">
                                <?php echo html_entity_decode($excursion["exc_excursion_name"]);?>
                                    <div id="myModal_<?php echo $excursion["exc_id"]?>" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Excursion detail - <?php echo htmlspecialchars($excursion["exc_excursion_name"]);?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Description: </strong><?php echo htmlspecialchars($excursion["exc_brief_description"]);?></p>
                                                <p><strong>Days: </strong><?php echo htmlspecialchars($excursion["exc_days"]);?></p>
                                                <p><strong>Airport: </strong><?php echo htmlspecialchars($excursion["exc_airport"]);?></p>
                                                <p>
                                                    <strong>Mapped campus: </strong>
                                                </p>
                                                <p>
                                                    <?php 
                                                    $campusArr = 0;
                                                    if(strlen($excursion["campus_name"]))
                                                    $campusArr = explode(',', $excursion["campus_name"]);
                                                    if($campusArr){
                                                        foreach ($campusArr as $cmp){
                                                            ?>
                                                            <span style="float: left;margin-top: 5px;" class="label label-success mr-right-5"><?php echo ucwords(htmlspecialchars($cmp));?> </span>
                                                            <?php 
                                                        }
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                                <td class="center"><?php echo htmlspecialchars($excursion["exc_brief_description"]);?>
                                <p>
                                    <?php 
                                    $campusArr = 0;
                                    if(strlen($excursion["campus_name"]))
                                    $campusArr = explode(',', $excursion["campus_name"]);
                                    if($campusArr){
                                        foreach ($campusArr as $cmp){
                                            ?>
                                            <span style="float: left;margin-top: 5px;" class="label label-success mr-right-5"><?php echo ucwords(htmlspecialchars($cmp));?> </span>
                                            <?php 
                                        }
                                    }
                                    ?>
                                </p>
                                </td>
                                <td class="center"><?php echo htmlspecialchars($excursion["exc_day_type"]);?></td>
                                <td class="center"><?php echo htmlspecialchars($excursion["exc_days"]);?></td>
                                <td class="center"><?php echo htmlspecialchars($excursion["exc_airport"]);?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="#" data-toggle="modal" data-target="#myModal_<?php echo $excursion["exc_id"]?>" class="min-wd-24 dialogbtn btn btn-xs btn-primary" ><span data-original-title="View" data-container="body" data-toggle="tooltip"><i class="fa fa-eye"></i></span></a>
                                    <?php
                                    if($this->session->userdata('role') != 400){?>
                                        <a href="<?php echo base_url().'index.php/excursion/addedit/'.$exc_type.'/'.$excursion["exc_id"];?>" data-toggle="tooltip" class="btn btn-xs btn-info min-wd-24" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                        <a data-status="<?php echo $excursion['exc_is_active'];?>" data-id="<?php echo $excursion['exc_id'];?>" href="javascript:void(0);" data-toggle="tooltip" class="min-wd-24 changeStatus btn btn-xs btn-warning" data-original-title="Change status"><i class="fa <?php echo ($excursion['exc_is_active'] == '1' ? 'fa-check-square-o' : 'fa-square-o');?>"></i></a>
                                        <a onclick="return confirmLinkAction('Are you sure to delete this <?php echo ($exc_type == 'transfer' ? 'transfer' : 'excursion')?>?','<?php echo base_url().'index.php/excursion/deleteexcursions/'.$excursion["exc_id"].'/'.$exc_type;?>');" href="javascript:void(0);" data-toggle="tooltip" class="min-wd-24 btn btn-xs btn-danger" data-original-title="Delete"><i class="fa fa-trash"></i></a>
                                    <?php }?>
                                    </div>
                                    
                                </td>
                        </tr>
                <?php
                        }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th><?php echo ($exc_type == 'transfer' ? 'Transfer' : 'Excursion')?></th>
                    <th>Brief description</th>
                    <th>Duration</th>
                    <th>Days</th>
                    <th>Airport</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            &nbsp;
        </div>
        <!-- /.box-footer-->
      </div>
      </div>
    </div>
</section>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
	$(document).ready(function() {
                $( "body" ).on( "click", ".changeStatus", function() {
                    var thisEle = $(this);
                    var id = $(this).attr('data-id');
                    var status = $(this).attr('data-status');
                    confirmAction("Are you sure to change active/inactive status?", function(c)
                    {
                        if(c)
                        {
                            $.post( "<?php echo base_url();?>index.php/excursion/change_status",{'id':id,'status':status}, function( data ) {
                                if(parseInt(data.result)){
                                    if(parseInt(data.status))
                                    {
                                        thisEle.children().switchClass('fa-square-o','fa-check-square-o',1);
                                        thisEle.attr('data-status',data.status);
                                    }
                                    else
                                    {
                                        thisEle.children().switchClass('fa-check-square-o','fa-square-o',1);
                                        thisEle.attr('data-status',data.status);
                                    }
                                }
                                else{

                                }
                            },'json');
                        }
                    },true,true);
                });
	});
</script>
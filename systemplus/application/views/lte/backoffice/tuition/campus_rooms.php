<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<link href="<?php echo base_url();?>css/external/jquery-ui-1.8.21.custom.css" rel="stylesheet">  
<section class="">
    <div class="row">
    
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
            <div class="row">
                <div class="col-sm-6 btn-create">
                <?php if($this->session->userdata('role') != 400){?>
                        <a href="<?php echo base_url(); ?>index.php/campusrooms/addedit" class="btn btn-primary btn-sm" id="createRoom" ><i class="fa fa-plus"></i>&nbsp;Create new rooms</a>
                <?php }?>
                </div>
                <?php showSessionMessageIfAny($this);?>
            </div>
        </div>
        <div class="box-body">
            <table id="dataTableCampusRooms" class="datatable table table-bordered table-striped" style="width: 99.98%;">
                <thead>
                        <tr>
                                <th>Campus</th>
                                <th>Number of rooms</th>								
                                <th>Students per room</th>
                                <th>From date</th>
                                <th>To date</th>
                                <th class="no-sort">Action</th>
                        </tr>
                </thead>
                <tbody>
                <?php 
                if($all_rooms)
                foreach($all_rooms as $rooms){
                ?>
                        <tr>
                                <td class="center">
                                <?php echo html_entity_decode($rooms["nome_centri"]);?>
                                    <div id="myModal_<?php echo $rooms["cr_id"]?>" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Campus room detail - <?php echo htmlspecialchars($rooms["nome_centri"]);?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Campus: </strong><?php echo html_entity_decode($rooms["nome_centri"]);?></p>
                                                <p><strong>Number of rooms: </strong><?php echo $rooms["cr_number_of_rooms"];?></p>
                                                <p><strong>Students per room: </strong><?php echo $rooms["cr_students_per_room"];?></p>
                                                <p><strong>Allotment from: </strong><?php echo date('d/m/Y',strtotime($rooms["cr_allotment_from_date"]));?> to </strong><?php echo date('d/m/Y',strtotime($rooms["cr_allotment_to_date"]));?></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                                <td class="center"><?php echo $rooms["cr_number_of_rooms"];?></td>
                                <td class="center"><?php echo $rooms["cr_students_per_room"];?></td>
                                <td class="center"><?php echo date('d/m/Y',  strtotime($rooms["cr_allotment_from_date"]));?></td>
                                <td class="center"><?php echo date('d/m/Y',  strtotime($rooms["cr_allotment_to_date"]));?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="#" data-toggle="modal" data-target="#myModal_<?php echo $rooms["cr_id"]?>" class="min-wd-24 dialogbtn btn btn-xs btn-primary" ><span data-original-title="View" data-container="body" data-toggle="tooltip"><i class="fa fa-eye"></i></span></a>
                                    <?php
                                    if($this->session->userdata('role') != 400){?>
                                        <a href="<?php echo base_url().'index.php/campusrooms/addedit/'.$rooms["cr_id"];?>" data-toggle="tooltip" class="btn btn-xs btn-info min-wd-24" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                        <a data-status="<?php echo $rooms['cr_is_active'];?>" data-id="<?php echo $rooms['cr_id'];?>" href="javascript:void(0);" data-toggle="tooltip" class="min-wd-24 changeStatus btn btn-xs btn-warning" data-original-title="Change status"><i class="fa <?php echo ($rooms['cr_is_active'] == '1' ? 'fa-check-square-o' : 'fa-square-o');?>"></i></a>
                                        <a onclick="return confirmLinkAction('Are you sure to delete this campus rooms?','<?php echo base_url().'index.php/campusrooms/deleterooms/'.$rooms["cr_id"];?>');" href="javascript:void(0);" data-toggle="tooltip" class="min-wd-24 btn btn-xs btn-danger" data-original-title="Delete"><i class="fa fa-trash"></i></a>
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
                        <th>Campus</th>
                        <th>Number of rooms</th>								
                        <th>Students per room</th>
                        <th>From date</th>
                        <th>To date</th>
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
                            $.post( "<?php echo base_url();?>index.php/campusrooms/rooms_change_status",{'id':id,'status':status}, function( data ) {
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
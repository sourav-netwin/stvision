<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<section class="">
    <div class="row">
    
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
            <div class="row">
                <div class="col-sm-6 btn-create">
                        <a href="<?php echo base_url(); ?>index.php/backoffice/addcourse" class="btn btn-primary btn-sm" id="createClass" ><i class="fa fa-plus"></i>&nbsp;Create new course</a>
                </div>
                <?php showSessionMessageIfAny($this);?>
            </div>
        </div>
        <div class="box-body">
            <table id="dataTableCampusRooms" class="datatable table table-bordered table-striped" >
                <thead>
                    <tr>
                        <th>Course name</th>
                        <th>Campus</th>								
                        <th>Course type</th>
                        <th>Total hours</th>
                        <th class="no-sort">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                if($all_courses)	
                foreach($all_courses as $courses){
                ?>
                        <tr>
                                <td class="center">
                                <?php echo html_entity_decode($courses["cc_course_name"]);?>
                                    <div id="myModal_<?php echo $courses["cc_id"]?>" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Course detail - <?php echo htmlspecialchars($courses["cc_course_name"])?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Name: </strong><?php echo html_entity_decode($courses['cc_course_name']);?></p>
                                                <p><strong>Campus: </strong><?php echo $courses["nome_centri"]?></p>
                                                <p><strong>Course Type: </strong><?php echo $courses["cc_course_type"]?></p>
                                                <p><strong>Total Hours: </strong><?php echo $courses["cc_total_hours"]?></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="center"><?php echo $courses["nome_centri"]?></td>
                                <td class="center"><?php echo $courses["cc_course_type"]?></td>
                                <td class="center"><?php echo $courses["cc_total_hours"]?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        
                                        <a href="#" data-toggle="modal" data-target="#myModal_<?php echo $courses["cc_id"]?>" class="min-wd-24 dialogbtn btn btn-xs btn-primary" ><span data-original-title="View" data-container="body" data-toggle="tooltip"><i class="fa fa-eye"></i></span></a>
                                        
                                        <a href="<?php echo base_url().'index.php/backoffice/addcourse/'.$courses["cc_id"];?>" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-info min-wd-24" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                        <a data-status="<?php echo $courses['cc_is_active'];?>" data-id="<?php echo $courses['cc_id'];?>" href="javascript:void(0);" data-toggle="tooltip" data-container="body" class="min-wd-24 changeStatus btn btn-xs btn-warning" data-original-title="Change status"><i class="fa <?php echo ($courses['cc_is_active'] == '1' ? 'fa-check-square-o' : 'fa-square-o');?>"></i></a>
                                        <a onclick="return confirmLinkAction('Are you sure to delete this campus course?','<?php echo base_url().'index.php/backoffice/deletecourse/'.$courses["cc_id"];?>');" href="javascript:void(0);" data-toggle="tooltip" data-container="body" class="min-wd-24 btn btn-xs btn-danger" data-original-title="Delete"><i class="fa fa-trash"></i></a>
                                    
                                    </div>
                                    
                                </td>
                        </tr>
                <?php
                        }
                ?>
                </tbody>
                <tfoot>
                <tr>
                        <th>Course name</th>
                        <th>Campus</th>								
                        <th>Course type</th>
                        <th>Total hours</th>
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
                            $.post( "<?php echo base_url();?>index.php/backoffice/course_change_status",{'id':id,'status':status}, function( data ) {
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
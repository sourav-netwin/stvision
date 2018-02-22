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
                        <a href="<?php echo base_url(); ?>index.php/categoryprogram/addedit" class="btn btn-primary btn-sm" id="createCategoryProgram" ><i class="fa fa-plus"></i>&nbsp;Create new category program</a>
                <?php }?>
                </div>
                <?php showSessionMessageIfAny($this);?>
            </div>
        </div>
        <div class="box-body">
            <table id="dataTableCategoryProgram" class="datatable table table-bordered table-striped" style="width: 99.98%;">
                <thead>
                        <tr>
                                <th>Name</th>
                                <th>Brief Description</th>								
                                <th>Image</th>
                                <th class="no-sort">Action</th>
                        </tr>
                </thead>
                <tbody>
                <?php 
                if($all_categoryprogram)
                foreach($all_categoryprogram as $categoryprogram){
                    $thumbnailImage = getThumbnailName($categoryprogram['procat_main_image']);
                ?>
                        <tr>
                                <td class="center">
                                <?php echo html_entity_decode($categoryprogram["procat_name"]);?>
                                    <div id="myModal_<?php echo $categoryprogram["procat_id"]?>" class="modal fade" role="dialog">
                                        <div class="modal-dialog modal-lg">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Category program detail - <?php echo htmlspecialchars($categoryprogram["procat_name"]);?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Campus: </strong><?php echo html_entity_decode($categoryprogram["procat_name"]);?></p>
                                                <p><strong>Brief description: </strong><?php echo $categoryprogram["procat_brief_description"];?></p>
                                                <p><strong>Extended description: </strong></p>
                                                <div><?php echo $categoryprogram["procat_extended_description"];?></div>
                                                <p><strong>Image: </strong></p>
                                                <div style="text-align: center;">
                                                    <img src="<?php echo base_url().CATEGORY_PROGRAM_IMAGE_PATH.$categoryprogram["procat_main_image"];?>"  />
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                                <td class="center"><?php echo $categoryprogram["procat_brief_description"];?></td>
                                <td class="center"><img src="<?php echo base_url().CATEGORY_PROGRAM_IMAGE_PATH.$thumbnailImage;?>" width="<?php echo CATEGORY_PROGRAM_THUMB_WIDTH;?>" /></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="#" data-toggle="modal" data-target="#myModal_<?php echo $categoryprogram["procat_id"]?>" class="min-wd-24 dialogbtn btn btn-xs btn-primary" ><span data-original-title="View" data-container="body" data-toggle="tooltip"><i class="fa fa-eye"></i></span></a>
                                    <?php
                                    if($this->session->userdata('role') != 400){?>
                                        <a href="<?php echo base_url().'index.php/categoryprogram/addedit/'.$categoryprogram["procat_id"];?>" data-toggle="tooltip" class="btn btn-xs btn-info min-wd-24" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                        <a data-status="<?php echo $categoryprogram['procat_is_active'];?>" data-id="<?php echo $categoryprogram['procat_id'];?>" href="javascript:void(0);" data-toggle="tooltip" class="min-wd-24 changeStatus btn btn-xs btn-warning" data-original-title="Change status"><i class="fa <?php echo ($categoryprogram['procat_is_active'] == '1' ? 'fa-check-square-o' : 'fa-square-o');?>"></i></a>
                                        <a onclick="return confirmLinkAction('Are you sure to delete this category program?','<?php echo base_url().'index.php/categoryprogram/deleteaction/'.$categoryprogram["procat_id"];?>');" href="javascript:void(0);" data-toggle="tooltip" class="min-wd-24 btn btn-xs btn-danger" data-original-title="Delete"><i class="fa fa-trash"></i></a>
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
                        <th>Name</th>
                        <th>Brief Description</th>								
                        <th>Image</th>
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
                            $.post( "<?php echo base_url();?>index.php/categoryprogram/catpro_change_status",{'id':id,'status':status}, function( data ) {
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
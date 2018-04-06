<div class="row">
    <div class="col-sm-12">
            <table id="dataTableContacts" class="datatable table table-bordered table-striped" style="width: 99.98%;">
                <thead>
                        <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone number</th>								
                                <th>Role</th>
                                <th>Category</th>
                                <th class="no-sort">Action</th>
                        </tr>
                </thead>
                <tbody>
                <?php 
                if($all_contacts)
                foreach($all_contacts as $contacts){
                ?>
                        <tr>
                                <td class="center">
                                <?php echo ucwords(html_entity_decode($contacts["cont_name"].' '.$contacts["cont_surname"]));?>
                                    <div id="myModal_<?php echo $contacts["cont_id"]?>" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" onclick="$('#myModal_<?php echo $contacts["cont_id"]?>').modal('hide');">&times;</button>
                                                <h4 class="modal-title">Contact detail - <?php echo htmlspecialchars($contacts["cont_name"].' '.$contacts["cont_surname"]);?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Name: </strong><?php echo html_entity_decode($contacts["cont_name"].' '.$contacts["cont_surname"]);?></p>
                                                <p><strong>Email: </strong><?php echo $contacts["cont_email"];?></p>
                                                <p><strong>Phone number: </strong><?php echo $contacts["cont_phone_number"];?></p>
                                                <p><strong>Role: </strong><?php echo $contacts["cont_role"];?></p>
                                                <p><strong>Category: </strong><?php echo $contacts["cont_category"];?></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" onclick="$('#myModal_<?php echo $contacts["cont_id"]?>').modal('hide');">Close</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="center"><?php echo $contacts["cont_email"];?></td>
                                <td class="center"><?php echo $contacts["cont_phone_number"];?></td>
                                <td class="center"><?php echo $contacts["cont_role"];?></td>
                                <td class="center"><?php echo $contacts["cont_category"];?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="#" data-toggle="modal" data-target="#myModal_<?php echo $contacts["cont_id"]?>" class="min-wd-24 dialogbtn btn btn-xs btn-primary" ><span data-original-title="View" data-container="body" data-toggle="tooltip"><i class="fa fa-eye"></i></span></a>
                                        <a href="javascript:void(0);" data-cont-id="<?php echo $contacts["cont_id"];?>" data-toggle="tooltip" class="btn btn-xs btn-info min-wd-24 editContact" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                        <a data-status="<?php echo $contacts['cont_is_active'];?>" data-id="<?php echo $contacts['cont_id'];?>" href="javascript:void(0);" data-toggle="tooltip" class="min-wd-24 changeStatus btn btn-xs btn-warning" data-original-title="Change status"><i class="fa <?php echo ($contacts['cont_is_active'] == '1' ? 'fa-check-square-o' : 'fa-square-o');?>"></i></a>
                                        <a href="javascript:void(0);" data-id="<?php echo $contacts['cont_id'];?>" data-toggle="tooltip" class="deleteContact min-wd-24 btn btn-xs btn-danger" data-original-title="Delete"><i class="fa fa-trash"></i></a>
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
                        <th>Email</th>
                        <th>Phone number</th>								
                        <th>Role</th>
                        <th>Category</th>
                        <th class="no-sort">Action</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
<script>
	$(document).ready(function() {
            initDataTable("dataTableContacts");
            
                $( "body" ).on( "click", ".editContact", function() {
                    var edit_id = $(this).attr('data-cont-id');
                    $.post( "<?php echo base_url();?>index.php/contacts/get_detail",{'edit_id':edit_id}, function( data ) {
                        if(data){
                            $("#txtFirstname").val(data.txtFirstname);
                            $("#txtLastname").val(data.txtLastname);
                            $("#txtEmail").val(data.txtEmail);
                            $("#txtPhoneNumber").val(data.txtPhoneNumber);
                            $("#txtRole").val(data.txtRole);
                            $("#selCategory").val(data.selCategory);
                            $("#edit_id").val(edit_id);
                            var tabIsOpened = $("#btnContactCreateTab").attr('data-original-title');
                            if(tabIsOpened == "Expand")
                            {
                                $("#btnContactCreateTab").trigger('click').trigger('blur');
                            }
                        }
                    },'json');
                });
                
                $( "body" ).on( "click", ".deleteContact", function() {
                    var cont_id = $(this).attr('data-id');
                    var agent_id = $('#agent_id').val();
                    confirmAction("Are you sure to delete this contact?", function(c)
                    {
                        if(c)
                        {
                            $.post( "<?php echo base_url();?>index.php/contacts/deleteAjaxContact",{'cont_id':cont_id}, function( data ) {
                                if(parseInt(data.result))
                                {
                                    swal('Success',data.message);
                                    reloadContactList(agent_id);
                                }
                                else
                                {
                                    swal('Error',data.message);
                                }
                            },'json');
                        }
                    },true,true);
                });
                
                $( "body" ).on( "click", ".changeStatus", function() {
                    var thisEle = $(this);
                    var id = $(this).attr('data-id');
                    var status = $(this).attr('data-status');
                    confirmAction("Are you sure to change active/inactive status?", function(c)
                    {
                        if(c)
                        {
                            $.post( "<?php echo base_url();?>index.php/contacts/contact_change_status",{'id':id,'status':status}, function( data ) {
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
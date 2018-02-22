<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<script type="text/javascript" >
        $(document).ready(function() {
              var BASE_PATH = "<?php echo base_url();?>index.php/";
              $('#frmMenu').validate({
                        rules:{
                            txtMenuTitle:{
                                    required:true
                            },
                            selMenuType:{
                                required:true
                            }
                        },
                        messages:{
                                txtMenuTitle:{
                                        required:"Please enter menu title."
                                },
                                selMenuType:{
                                        required:"Please select menu type."
                                }
                        }
                });

                // $("#selMenuType").change(function(){
                    // var menuType = $(this).val();
                    // if(menuType == "Left" || menuType == 'Other')
                    // {
                        // $("#selParentMenu").val(0);
                        // $("#selParentMenu").attr('disabled','disabled');
                    // }else
                    // {
                        // $("#selParentMenu").removeAttr('disabled');
                    // }
                // });

                $(".editmenu").click(function(){
                    var mnu_id = $(this).attr('data-mnuid');
                    var mnu_pid = $(this).attr('data-mnu_pid');
                    var mnu_text = $(this).attr('data-text');
                    var my_current_level = $(this).attr('data-level');
                    var my_type = $(this).attr('data-type');

					$("#selMenuType").val(my_type);
					//Call a function to refresh the parent menu dropdown
					loadParentMenuDropdown(mnu_pid);

                    var all_child_ids = "";
                    $.post( BASE_PATH + "frontweb/cmsmenu/getallchildid",{'mnu_id':mnu_id}, function( data ) {
                        $.each( data, function( i, item ) {
                           if(item){
                               $("#selParentMenu option[value='"+ item +"']").attr('disabled','disabled');
                               all_child_ids += item+',';
                           }
                        });
                        $("#all_child_ids").val(all_child_ids);
                    },'JSON');

                    //$("#theSelect option:selected").attr('disabled','disabled');
                    $("#selParentMenu option").removeAttr('disabled');
                    $("#selParentMenu option[value='"+ mnu_id +"']").attr('disabled','disabled');
                    $("#txtMenuTitle").val(mnu_text);
                    $("#edit_id").val(mnu_id);
                    $("#my_current_level").val(my_current_level);
                    $("#selParentMenu").val(mnu_pid);
                    $("#selMenuType").val(my_type);
                    $("#addeditMnuLable").html("Update menu");
                    $("#btnAddMenu").val('Update');
                    $("#txtMenuTitle").focus();
                });

                $("#btnCancelMenuAdd").click(function(){
                    $("#txtMenuTitle").val('');
                    $("#selParentMenu").val(0);
                    $("#addeditMnuLable").html("Add new menu");
                    $("#btnAddMenu").val('Add');
                    $("#selParentMenu option").removeAttr('disabled');
                    $("#edit_id").val('0');
                    $("#txtMenuTitle").focus();
                });


                $(".status").click(function(){
                    var ele_id = $(this).attr('data-id');
                    var ele_status = $(this).attr('data-status');
                    $("#btn-status").attr('data-status',ele_status);
                    $("#btn-status").attr('data-id',ele_id);
                    $("#btn-status").attr('data-all-child','');
                    $("#status-error-text").html("Are you sure you want to change the status?");
                    $.post( BASE_PATH + "frontweb/cmsmenu/getallchildid",{'mnu_id':ele_id}, function( data ) {
                        if(data != ""){
                            $("#status-error-text").html("Are you sure you want to change the status? <br />If you change status of this parent menu status of all its child menus will be changed.");
                            $("#btn-status").attr('data-all-child',data);
                        }
                    },'JSON');
                });

                $("#btn-status").click(function(){
                    var ele_id = $(this).attr('data-id');
                    var ele_status = $(this).attr('data-status');
                    var ele_all_child = $("#btn-status").attr('data-all-child');
                    $.post( BASE_PATH + "frontweb/cmsmenu/update_mnu_status",{'mnu_id':ele_id,'ele_status':ele_status,'ele_all_child':ele_all_child}, function( data ) {
                        if(data != ""){
                            if(data == '1')
                                window.location.reload();
                        }
                    });
                });

                 $(".delete_button").click(function(){
                    var ele_id = $(this).attr('data-id');
                    $("#btn-danger1").attr('data-id',ele_id);
                    $("#btn-danger1").removeAttr('disabled');
                    $("#status-error-text").html("Are you sure you want to delete role?<br />This cannot be undone.");
                    $.post( BASE_PATH + "frontweb/cmsmenu/getallchildid",{'mnu_id':ele_id}, function( data ) {
                        if(data != ""){
                            $("#delete-error-text").html("You can not delete parent menu,<br />When it's child menus are present.");
                            $("#btn-danger1").attr('disabled','disabled');
                        }
                    },'JSON');
                });

                $("#btn-danger1").click(function(){
                    var ele_id = $(this).attr('data-id');
                    $.post( BASE_PATH + "frontweb/cmsmenu/delete_mnu",{'mnu_id':ele_id}, function( data ) {
                        if(data != ""){
                            if(data == '1')
                                window.location.reload();
                        }
                    },'JSON');
                });

                $("#btnCancelLeftMenu").click(function(){
                        window.location.reload();
                });



				//On change of menu type dropdown , refresh the parent menu dropdown
				$('#selMenuType').on('change' , function(){
					loadParentMenuDropdown();
				});

				//This function is used to delete old options from parent menu dropdown and add new options as per the menu type
				function loadParentMenuDropdown(selectedOption = 0)
				{
					if($('#selMenuType').val() == 'Left' || $('#selMenuType').val() == 'Other')
					{
						$("#selParentMenu").val(0);
						$("#selParentMenu").attr('disabled','disabled');
					}
					else
					{
						$("#selParentMenu").removeAttr('disabled');
						$('#selParentMenu').find('option').remove();
						$.ajax({
							url : "<?php echo base_url(); ?>index.php/frontweb/cmsmenu/getParentMenuDropdown",
							data : {'menuType' : $('#selMenuType').val()},
							type : 'POST',
							dataType : 'JSON',
							success : function(response){
								if(response.optionStr)
									$('#selParentMenu').append(response.optionStr);
								$('#selParentMenu').val(selectedOption);
							}
						});
					}
				}



           });
	</script>
        <style>
            .fa-2x {
                font-size: 1.5em;
            }

            .list-group-item:not(.level_1){
                border-left: 1px solid silver!important;
            }
            .level_2{
                margin-left: 25px;
            }
            .level_3{
                margin-left: 50px;
            }
            .level_4{
                margin-left: 75px;
            }
            .level_5{
                margin-left: 100px;
            }
            .first .moveup{
                display: none;
            }
            .last .movedown{
                display: none;
            }
            .single .moveup{
                display: none;
            }
            .single .movedown{
                display: none;
            }
        </style>
        <div class="row">
            <div class="col-sm-12"><?php showSessionMessageIfAny($this);?></div>
        <div class="col-md-3">
            <div style="margin-bottom: 20px!important;" class="panel panel-default">
                <div id="addeditMnuLable" class="panel-heading">
                    Add new menu
                </div>
                <div class="panle-body" style="padding:20px;">
                    <form id="frmMenu" method="post" action="<?php echo base_url().'index.php/frontweb/cmsmenu/addmenu'?>">
                        <input type="hidden" id="edit_id" name="edit_id" class="form-control" value="0">
                        <input type="hidden" id="all_child_ids" name="all_child_ids" class="form-control" value="0">
                        <input type="hidden" id="my_current_level" name="my_current_level" class="form-control" value="0">
                        <div class="form-group">
                        <label>Menu Title</label>
                        <input type="text" id="txtMenuTitle" name="txtMenuTitle" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label>Menu Type</label>
                            <select  class="form-control" id="selMenuType" name="selMenuType">
                            <option value="">Select menu type</option>
                            <option value="Top">Top</option>
                            <option value="Footer">Footer</option>
                            <option value="Other">Other</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Parent Menu</label>
                            <select  class="form-control" id="selParentMenu" name="selParentMenu">
                            <option value="0">Select parent menu</option>
                            <!-- <?php foreach ($parentMenu as $mnu_row) {
                                $CI = &get_instance();
                                $CI->getSelectOption($mnu_row);
                            }?> -->
                            </select>
                        </div>
                        <div class="form-group-btn">
                                <input id="btnAddMenu" type="submit" class="btn btn-primary" value="Add">
                                <input id="btnCancelMenuAdd" type="button" class="btn btn-primary" value="Cancel">
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <div class="col-md-9">
            <div id="menu-grid" class="panel panel-default">
                <div id="collapseListGroupHeading1" class="panel-heading">
                    <h4 class="panel-title">
                    <a aria-controls="collapseListGroup1"  href="#collapseListGroup1" data-toggle="collapse" class="collapse in">
                        Top Menu List
                    </a>
                    </h4>
                </div>
                <div id="collapseListGroup1" class="panel-collapse collapse in">
                <ul class="list-group tree" id="tree">
                <?php
                if($contentMenuData){
                $CI = &get_instance();
                $first = 'first';
                $count = 0;
                $last = '';
                foreach($contentMenuData as $mnu){
                        $count++;
                        if(count($contentMenuData) == $count)
                        {
                            $first = 'last';
                        }
                        $CI->getMenuHtml($mnu,$first);
                        $first = '';
                    }
                }else{
                    ?>
                    <li class="list-group-item level_1 last">No record(s) found</li>
                    <?php
                }?>
                </ul>
                </div>
            </div>

            <div id="menu-grid" class="panel panel-default">
                <div id="collapseListGroupHeading2" class="panel-heading">
                    <h4 class="panel-title">
                    <a aria-controls="collapseListGroup1"  href="#collapseListGroup2" data-toggle="collapse" class="collapse in">
                        Footer Menu List
                    </a>
                    </h4>
                </div>
                <div id="collapseListGroup2" class="panel-collapse collapse in">
                <ul class="list-group tree" id="tree">
                <?php
                if($contentFooterMenuData){
                    $CI = &get_instance();
                    $first = 'first';
                    $count = 0;
                    $last = '';
                foreach($contentFooterMenuData as $mnu){
                        $count++;
                        if(count($contentFooterMenuData) == $count)
                        {
                            if($first != 'first')
                                $first = 'last';
                            else
                                $first = 'single';
                        }
                        $CI->getMenuHtml($mnu,$first);
                        $first = '';
                    }
                }else{
                    ?>
                    <li class="list-group-item level_1 last">No record(s) found</li>
                    <?php
                }?>
                </ul>
                </div>
            </div>

            <div id="menu-grid" class="panel panel-default">
                <div id="collapseListGroupHeading3" class="panel-heading">
                    <h4 class="panel-title">
                    <a aria-controls="collapseListGroup1"  href="#collapseListGroup3" data-toggle="collapse" class="collapse in">
                        Other Menu List
                    </a>
                    </h4>
                </div>
                <div id="collapseListGroup3" class="panel-collapse collapse in">
                <ul class="list-group tree" id="tree">
                <?php
                if($contentOtherMenuData){
                    $CI = &get_instance();
                foreach($contentOtherMenuData as $mnu){
                        $CI->getMenuHtml($mnu);
                    }
                }else{
                    ?>
                    <li class="list-group-item level_1 last">No record(s) found</li>
                    <?php
                }?>
                </ul>
                </div>
            </div -->
        </div>

    </div>

            <!-- end of content menu list -->

            <div class="modal small fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                            <div class="modal-content">
                                    <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                            <h3 id="myModalLabel">Delete Confirmation</h3>
                                    </div>
                                    <div class="modal-body">
                                        <p class="error-text">

                                            <label id="delete-error-text">
                                               <i class="fa fa-warning modal-icon"></i>
                                               Are you sure you want to delete role?
                                               <br> This cannot be undone.
                                            </label>
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                            <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button>
                                            <button class="btn btn-primary" id="btn-danger1" data-dismiss="modal">Delete</button>
                                    </div>
                            </div>
                    </div>
            </div>

            <div class="modal small fade" id="myStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                            <div class="modal-content">
                                    <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                            <h3 id="myModalLabel">Change Status</h3>
                                    </div>
                                    <div class="modal-body">
                                        <p class="error-text">
                                            <i class="fa fa-warning modal-icon"></i>
                                        <lable id="status-error-text">Are you sure you want to change the status?</lable></p>
                                    </div>
                                    <div class="modal-footer">
                                            <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button>
                                            <button class="btn btn-primary" id="btn-status" data-dismiss="modal">Change</button>
                                    </div>
                            </div>
                    </div>
            </div>
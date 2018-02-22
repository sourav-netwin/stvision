<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo LTE;?>plugins/iCheck/all.css" rel="stylesheet">
<!-- iCheck for checkboxes and radio inputs -->
  <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
<!--            <div class="box-header">
              <h3 class="box-title">Data Table With Full Features</h3>
            </div>-->
            <!-- /.box-header -->
            <div class="box-body">
              <table id="dataTableRole" class="datatable table table-bordered table-striped">
                <thead>
                <tr>
                  <th >Role</th>
                  <th >Menus</th>
                  <th class="no-sort">Action</th>
                </tr>
                </thead>
                <tbody>
                
                <?php 
                    if($roleData){
                        foreach($roleData as $role){
                            ?>
                                <tr>
                                    <td style="width:25%;"><?php echo $role['role_name'];?></td>
                                    <td style="width:60%;"><?php echo $role['menu_name'];?></td>
                                    <td style="width:15%;"><a class="linkRoles" href="#listMenus" data-backdrop="static" data-id="<?php echo $role['role_id'];?>" data-role="<?php echo $role['role_name'];?>" title="Change menus" role="button" data-toggle="modal"><span class="fa fa-list"> Change menus</span></a></td>
                                </tr>
                            <?php 
                        }
                    }
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Role</th>
                  <th>Menus</th>
                  <th>Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
<style>
    .box < .fa-check{
        color:red;
    }
</style>
    <div class="modal fade row" id="listMenus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-lg-95-per">
            <div class="modal-content">
              <div class="modal-header">
                <button aria-label="Close" data-dismiss="modal" class="close" type="button">
                  <span aria-hidden="true">×</span></button>
                  <h4 class="modal-title">Assigned menus for role: <span id="lblRole"></span>
                    <span class="pull-right-container">
                        <small class="label pull-right btn-primary mr-right-15">Not assigned</small>
                        <small class="label pull-right bg-green mr-right-15">Assigned</small>
                    </span>
                  </h4>
                  <input type="hidden" id="hidd_role" name="hidd_role" value="0" />
              </div>
              <div class="modal-body row">
                
                    <?php 
                            if($roleMenuData){
                            $CI = &get_instance();
                            $first = 'first';   
                            $count = 0;
                            $last = ''; 
                            foreach($roleMenuData as $mnu){
                                $count++;
                                if(count($roleMenuData) == $count)
                                {
                                    $first = 'last';
                                }
                                ?>
                  <div class="col-sm-4">
                      <div class="box box-primary box-solid collapsed-box mr-bot-10" id="menu-grid-<?php echo $mnu['mnu_menuid'];?>">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php 
                                echo $mnu['mnu_menu_name'];
                                echo (!empty($mnu['mnu_caption']) ? " [".$mnu['mnu_caption']."]" : '');
                            ?></h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <div class="box-body">
                            <ul class="list-group tree" id="tree">
                        <?php 
                            $CI->getMenuHtml($mnu,$first);
                        ?></ul>
                        </div>
                    </div>
                  </div>
                                <?php 
                                $first = '';
                            }
                        }else{
                            ?>
                            <div>No record(s) found</div>
                            <?php 
                        }?>
                    
              </div>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
<!--                <button class="btn btn-primary" type="button">Save changes</button>-->
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        <!-- /.modal -->
    </div>
<style>
    /*
    .modal-dialog:not(.access) {
        width: 90%;
        max-width: 650px;
        height: 90%;
        margin: 3% auto;
        padding: 0;
    }

    .modal-content:not(.access) {
        height: auto;
        min-height: 90%;
        border-radius: 0;
    }
    */
    .list-group-item:not(.level_1){
        border-left: 1px solid #ccc !important;
    }
    .list-group-item.level_1 {
        font-size: 13px;
        font-weight: 700;
    }
    .level_2 {
        margin-left: 25px;
        font-size: 13px;
    }
    .level_3 {
        margin-left: 50px;
        font-style: italic;
        font-size: 12px;
    }
    .level_4 {
        margin-left: 75px;
    }
    .level_5 {
        margin-left: 100px;
    }
    
/*    .first .moveup {
        display: none;
    }
    .last .movedown {
        display: none;
    }
    .single .moveup {
        display: none;
    }
    .single .movedown {
        display: none;
    }*/

</style>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo LTE;?>plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        //$('#dataTableRole').DataTable({sScrollX: true});
        function iCheckInit(){
                $('input').iCheck('destroy'); 
                $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '10%' // optional
                });
            }
        $(document).on("click",".linkRoles",function() {
            iCheckInit();
            
            var roleText = $(this).attr('data-role');
            $('#lblRole').html(roleText);
            // load current role access-rights
            var role = $(this).attr('data-id');
            $('#hidd_role').val(role);
            //$(".access i").switchClass("fa-check","fa-ban"); 
            $(".access i").removeClass("fa-check"); 
            $(".access i").addClass("fa-ban"); 
            $(".chkSelectAll").iCheck('uncheck'); 
            $(".box").removeClass("box-success"); 
             $.post( "<?php echo base_url();?>index.php/roleaccess/loadaccess",
             {'role':role}, function( data ) {
                if(parseInt(data.result)){
                    var menus = data.menus;
                    $.each(menus, function (index, value) {
                        var menu_id = value.id;
                        //$("#st_"+menu_id+ " i").switchClass("fa-ban","fa-check"); 
                        $("#st_"+menu_id+ " i").removeClass("fa-ban"); 
                        $("#st_"+menu_id+ " i").addClass("fa-check"); 
                        $("#menu-grid-"+menu_id).addClass("box-success"); 
                        $("#chk_"+menu_id).iCheck('check'); 
                    });
                }
            },'json');
        });
        
        $('#listMenus').on('hidden.bs.modal', function () {
            window.location.reload();
        })
        
//        $(".content").on("click",".access",function() {
//            var ele_id = $(this).attr('data-id');
//            var ele_pid = $(this).attr('data-pid');
//            var ele_status = $(this).attr('data-access');
//            $("#btn-access").attr('data-access',ele_status);
//            $("#btn-access").attr('data-id',ele_id);
//            $("#btn-access").attr('data-pid',ele_pid);
//            $("#status-error-text").html("&nbsp;Are you sure you want to change the access?");
//        });
        
        $(".content").on("click",".access",function() {
            var ele_id = $(this).attr('data-id');
            var ele_pid = $(this).attr('data-pid');
            var ele_status = $(this).attr('data-access');
            var role = $("#hidd_role").val();
            confirmAction("Are you sure to change menu access?", function(c){
                if(c)
                    $.post( "<?php echo base_url();?>index.php/roleaccess/changemenu",
                    {
                        'role':role,
                        'access':ele_status,
                        'menu_id':ele_id,
                        'p_menu_id':ele_pid
                    }, function( data ) {
                        if(parseInt(data.result)){
                            $("#st_"+ele_id+ " i").switchClass("fa-ban","fa-check"); 
                            $("#menu-grid-"+ele_pid).addClass("box-success"); 
                        }
                        else
                        {
                            $("#st_"+ele_id+ " i").switchClass("fa-check","fa-ban"); 
                            $("#menu-grid-"+ele_pid).removeClass("box-success"); 
                        }
                    },'json');
            },true,true);
            
        });
        
        //myAccessAll
        //ifClicked
        $('input').on('ifClicked', function(event){
            var ele_id = $(this).attr('data-id');
            var role = $("#hidd_role").val();
            var checked = $(this). prop("checked");
            if(checked)
                checked = 0
            else
                checked = 1;
            
            confirmAction("Are you sure to change access to all it's sub menu(s)?", function(c){
                if(c)
                {
                    $.post( "<?php echo base_url();?>index.php/roleaccess/changechildmenu",
                        {
                            'role':role,
                            'menu_id':ele_id,
                            'checked':checked
                        }, function( data ) {
                            var mnuArr = data.childmenus;
                            if(parseInt(data.result)){
                                if(checked)
                                    $("#menu-grid-"+ele_id).addClass("box-success"); 
                                else
                                    $("#menu-grid-"+ele_id).removeClass("box-success"); 
                                $.each(mnuArr, function(ele,eleid){ 
                                    if(checked)
                                    {
                                        $("#st_"+eleid+ " i").switchClass("fa-ban","fa-check"); 
                                        $("#chk_"+eleid).iCheck('check'); 
                                    }
                                    else
                                    {
                                        $("#st_"+eleid+ " i").switchClass("fa-check","fa-ban"); 
                                        $("#chk_"+eleid).iCheck('uncheck'); 
                                    }
                                });
                                //swal('Error', 'No records found');
                            }
                        },'json');
                }
                else
                {
                    if(checked)
                        $("#chk_"+ele_id).iCheck('uncheck'); 
                    else
                        $("#chk_"+ele_id).iCheck('check'); 
                }
            }, true, true);
        });
        
    });
    
</script>
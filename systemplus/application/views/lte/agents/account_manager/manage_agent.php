<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <img src="<?php echo base_url(); ?>img/elements/profile/avatar.png">
                </div>
                <div class="profile-agent">
                    <h4 class="box-title" id="business_name_title"><?php echo $ag_details[0]['businessname'] ?></h4>
                    <input type="text" class="form-control business_name" name="business_name" id="business_name" value="<?php echo $ag_details[0]['businessname'] ?>" style="display: none;">
                    <small><?php echo $ag_details[0]['businesscountry'] ?></small>
                    <a data-toggle="tooltip" class="btn btn-xs btn-primary mr-left-10" href="javascript:void(0);" data-original-title="Edit business name" id="edit_business_name">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <div class="book">
                        <a data-toggle="tooltip" href="<?php echo base_url(); ?>index.php/agents/viewAgentBookings/<?php echo $ag_details[0]['id'] ?>" title="View agent bookings">
                            <?php echo $n_books; ?>
                            <small>Bookings</small>
                        </a>
                    </div>

                </div>
            </div>
            <div class="box-header with-border">
                <h4 class="box-title">Personal Details</h4>
                <div class="box-tools pull-right">
                    <a href="<?php echo base_url(); ?>index.php/agents/viewAgentBookings/<?php echo $ag_details[0]['id'] ?>" data-toggle="tooltip" href="" title="View agent bookings">
                        <i class="fa fa-list"> View agent bookings</i>
                    </a>
                </div>
            </div>
            <div class="box-body">
                <?php showSessionMessageIfAny($this); ?>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <form class="validate" name="persoprofile" id="persoprofile" action="<?php echo base_url(); ?>index.php/agents/updateProfileAgent/<?php echo $ag_details[0]['id'] ?>" method="POST">
                            <div class="form-group row">
                                <div class="col-sm-2 col-md-2 col-lg-2">
                                    Name:
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3 mr-bot-10">
                                    <input type="text" name="mainfamilyname" class="required form-control" value="<?php echo $ag_details[0]['mainfamilyname'] ?>">
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    <input type="text" name="mainfirstname" class="required form-control" value="<?php echo $ag_details[0]['mainfirstname'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 col-md-2 col-lg-2">
                                    Email:
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <input type="text" class="form-control" name="email" id="email_address" value="<?php echo $ag_details[0]['email'] ?>" style="display: none;width:47%;float: left;">
                                    <label style="font-weight: normal;" id="email_address_title"><?php echo $ag_details[0]['email'] ?></label>
                                    <a data-toggle="tooltip" class="btn btn-xs btn-primary mr-left-10" href="javascript:void(0);" data-original-title="Edit email address" id="edit_email_address">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 col-md-2 col-lg-2">
                                    Telephone:
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <input type="text" class="form-control" name="businesstelephone" value="<?php echo $ag_details[0]['businesstelephone'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 col-md-2 col-lg-2">
                                    Mobile phone:
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <input type="text" class="form-control" name="mobilephone" value="<?php echo $ag_details[0]['mobilephone'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 col-md-2 col-lg-2">
                                    Skype name:
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <input type="text" class="form-control" name="skypename" value="<?php echo $ag_details[0]['skypename'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 col-md-2 col-lg-2">
                                    Address:
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <input type="text" class="form-control" name="businessaddress" value="<?php echo $ag_details[0]['businessaddress'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 col-md-2 col-lg-2">
                                    Postal Code:
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <input type="text" class="form-control" name="businesspostalcode" value="<?php echo $ag_details[0]['businesspostalcode'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 col-md-2 col-lg-2">
                                    City:
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <input type="text" class="form-control" name="businesscity" value="<?php echo $ag_details[0]['businesscity'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 col-md-2 col-lg-2">
                                    Country:
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <?php echo $ag_details[0]['businesscountry'] ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 col-md-2 col-lg-2">
                                    Origin:
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <select class="form-control" name="origin" id="origin">
                                        <option value="">Select origin</option>
                                        <option value="Fairs"<?php if ($ag_details[0]['origin'] == "Fairs") { ?> selected<?php } ?>>Fairs</option>
                                        <option value="Internet"<?php if ($ag_details[0]['origin'] == "Internet") { ?> selected<?php } ?>>Internet</option>
                                        <option value="Advertising LTM"<?php if ($ag_details[0]['origin'] == "Advertising LTM") { ?> selected<?php } ?>>Advertising LTM</option>
                                        <option value="Word of mouth"<?php if ($ag_details[0]['origin'] == "Word of mouth") { ?> selected<?php } ?>>Word of mouth</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 col-md-2 col-lg-2">
                                    Client status:
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <select class="form-control" name="statuscrm" id="statuscrm">
                                        <option value="Trusted"<?php if ($ag_details[0]['statuscrm'] == "Trusted") { ?> selected<?php } ?>>Trusted</option>
                                        <option value="Prospect"<?php if ($ag_details[0]['statuscrm'] == "Prospect") { ?> selected<?php } ?>>Prospect</option>
                                        <option value="Undesired"<?php if ($ag_details[0]['statuscrm'] == "Undesired") { ?> selected<?php } ?>>Undesired</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-offset-2 col-sm-6 col-md-6 col-lg-6">
                                    <input class="btn btn-primary" id="modprofile" type="submit" value="Update personal details" name=modprofile />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                &nbsp;
            </div>
            <!-- /.box-footer-->
        </div>
        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">Destinations of interest</h4>
            </div>
            <div class="box-body">
                <form action="<?php echo base_url(); ?>index.php/agents/updateProductsAgent/<?php echo $ag_details[0]['id'] ?>" name="prodform" id="prodform" method="POST">
                    <?php
                    foreach ($all_prodotti as $prodotto) {
                        ?>
                        <div class="row">
                            <div class="col-sm-12 mr-bot-10">
                                <h4 class="box-title" style="text-transform:uppercase;"><?php echo $prodotto["prd_name"] ?></h4>
                                <a class="btn btn-primary selall" id="sel_all_<?php echo $prodotto["prd_id"] ?>" href="javascript:void(0);">Select all</a>
                                <a class="btn btn-danger deselall" id="desel_all_<?php echo $prodotto["prd_id"] ?>" href="javascript:void(0);">Deselect all</a>
                            </div>
                        </div>
                        <div class="row">
                            <?php foreach ($doi[$prodotto["prd_id"]] as $singdest) {
                                ?>
                                <div class="col-sm-4">
                                    <input class="custCheckbox doi_<?php echo $prodotto["prd_id"]; ?>" type="checkbox" id="doi_<?php echo $ag_details[0]['id'] ?>_<?php echo $singdest["id"] ?>" name="doi_<?php echo $ag_details[0]['id'] ?>_<?php echo $singdest["id"] ?>" value="1" />
                                    <label class="normal"><?php echo $singdest["nome_centri"] ?></label>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="row">
                        <div class="col-sm-12 mr-top-10">
                            <input class="btn btn-primary" id="moddesti" type="submit" value="Update destinations of interest" name=moddesti />
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                &nbsp;
            </div>
            <!-- /.box-footer-->
        </div>
        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">Profile detail</h4>
            </div>
            <div class="box-body">
                <form action="<?php echo base_url(); ?>index.php/agents/updateStatusAgent/<?php echo $ag_details[0]['id'] ?>" name="commform" id="commform" method="POST">
                    <?php
                    foreach ($all_prodotti as $prodotto) {
                        ?>
                        <div class="form-group row" id="row_pr_<?php echo $prodotto["prd_id"] ?>">
                            <div class="col-sm-3">
                                <label for="spinner_<?php echo $prodotto["prd_id"] ?>">
                                    <strong>% <?php echo $prodotto["prd_name"] ?> commission</strong>
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <input class="contastudenti form-control" data-type="spinner" name=spinner_<?php echo $prodotto["prd_id"] ?> id=spinner_<?php echo $prodotto["prd_id"] ?> value="<?php echo $prodotto['sconto'] ?>" min="0" max="35" />
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ranking_select">
                                <strong>Client Ranking</strong>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <select name=ranking_select id=ranking_select class="form-control search required" data-placeholder="Choose a rank">
                                <option value="Small"<?php if ($ag_details[0]['ranking'] != "Small") { ?> selected<?php } ?>>Small</option>
                                <option value="Standard"<?php if ($ag_details[0]['ranking'] == "Standard") { ?> selected<?php } ?>>Standard</option>
                                <option value="Medium"<?php if ($ag_details[0]['ranking'] == "Medium") { ?> selected<?php } ?>>Medium</option>
                                <option value="Large"<?php if ($ag_details[0]['ranking'] == "Large") { ?> selected<?php } ?>>Large</option>
                                <option value="VIP"<?php if ($ag_details[0]['ranking'] == "VIP") { ?> selected<?php } ?>>VIP</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="status_select">
                                <strong>Status</strong>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <select name=status_select id=status_select class="search form-control required" data-placeholder="Choose a product">
                                <option value="pending"<?php if ($ag_details[0]['status'] != "active") { ?> selected<?php } ?>>Pending</option>
                                <option value="active"<?php if ($ag_details[0]['status'] == "active") { ?> selected<?php } ?>>Active</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="price_category">
                                <strong>Price Category</strong>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <select name=price_category id=price_category class="form-control search required">
                                <option value="No profile"<?php if ($ag_details[0]['pricecategory'] != "No profile") { ?> selected<?php } ?>>No profile</option>
                                <option value="Profile A"<?php if ($ag_details[0]['pricecategory'] == "Profile A") { ?> selected<?php } ?>>Profile A</option>
                                <option value="Profile B"<?php if ($ag_details[0]['pricecategory'] == "Profile B") { ?> selected<?php } ?>>Profile B</option>
                                <option value="Profile C"<?php if ($ag_details[0]['pricecategory'] == "Profile C") { ?> selected<?php } ?>>Profile C</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mr-bot-10">
                            <input class="btn btn-danger" id="credentag" type="button" class="red" value="Send credentials" name="credentag" />
                            <input class="btn btn-primary" id="writeag" type="button" value="Update status and commissions" name="writeag" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="box-footer">

            </div>
        </div>
    </div>
</div>
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<link href="<?php echo LTE; ?>plugins/iCheck/all.css" rel="stylesheet">
<script>
    pageHighlightMenu = "agents/listAgents";
    function iCheckInit(){
        $('input.custCheckbox').iCheck('destroy');
        $('input.custCheckbox').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '10%' // optional
        });
    }

    $(document).ready(function() {

        $("#writeag").click(function(){
            document.getElementById("commform").submit();
        });
        $("#credentag").click(function(){
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/agents/send_agent_credentials/<?php echo $ag_details[0]['id'] ?>",
                success: function(html){
                    swal("Success","Credentials has been sent to the agent");
                }
            });
        });
<?php
foreach ($doi_agent as $doi_attivo) {
    ?>
                    $("#doi_<?php echo $ag_details[0]['id'] ?>_<?php echo $doi_attivo["doi_id_dest"] ?>").attr('checked', true);
    <?php
}
?>
        iCheckInit();
                $(".selall").click(function(){
                    var idst = $(this).attr("id").split("_");
                    var globalsel = ".doi_"+idst[2];
                    //$(globalsel).attr('checked', true);
                    $(globalsel).iCheck("check");
                });
                $(".deselall").click(function(){
                    var idst = $(this).attr("id").split("_");
                    var globalsel = ".doi_"+idst[2];
                    //$(globalsel).attr('checked', false);
                    $(globalsel).iCheck("uncheck");
                });
                //        $("input.chCentri").each(function(){
                //                $(this).iCheck("uncheck");
                //            });

    $("#edit_business_name").click(function(e){
        if( $('#business_name').is(':visible') )
        {
            // Edit code
            if ( confirm('Are you sure you want to edit the business name?') )
            {
                var business_name = $('#business_name').val();
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/agents/updateBusinessName",
                    data:{ 'agent' : <?php echo $ag_details[0]['id'] ?>, 'business_name' : business_name },
                    type: 'POST',
                    success: function(data){
                        if( data == 1 )
                        {
                            $('#business_name').hide();
                            $('#business_name_title').show();
                            $('#business_name_title').html(business_name);
                            swal("Success","Business name successfully updated");
                        }
                    }
                });
            }
        }
        else
        {
            $('#business_name').show();
            $('#business_name_title').hide();
        }
    });
    
    // EDIT EMAIL ADDRESS
    
    
    $("#edit_email_address").click(function(e){
        if( $('#email_address').is(':visible') )
        {
            // Edit code
            if ( confirm('Are you sure you want to edit the email?') )
            {
                var email_address = $('#email_address').val();
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/agents/updateEmailAddress",
                    data:{ 'agent' : <?php echo $ag_details[0]['id'] ?>, 'email_address' : email_address },
                    type: 'POST',
                    dataType: "json",
                    success: function(data){
                        if( parseInt(data.result) == 1 )
                        {
                            $('#email_address').hide();
                            $('#email_address_title').show();
                            $('#email_address_title').html(email_address);
                            swal("Success",data.message);
                        }
                        else{
                            swal("Error",data.message);
                        }
                    }
                },'json');
            }
        }
        else
        {
            $('#email_address').show();
            $('#email_address_title').hide();
        }
     });
    
});
</script>
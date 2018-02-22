<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<style>
    .badge.block {
        display: inline-block;
        margin: 5px;
    }
    .badge.green {
        background: #40913f url("./img/elements/badges/green.png") repeat-x scroll 0 0;
        border: 1px solid #1d5d1c;
    }
    .badge.red {
        background: #b32626 url("./img/elements/badges/red.png") repeat-x scroll 0 0;
        border: 1px solid #931616;
    }
    .badge {
        color: #fff;
        text-shadow: 0 1px 0 #000;
    }
    .badge {
        border-radius: 3px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.76), 0 1px 0 rgba(255, 255, 255, 0.45) inset;
        cursor: default;
    }
    .ui-datepicker{
        font-size: small;
    }
</style>
<div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header with-border">
            <h4 class="box-title">Agents list</h4>
        </div>
        <div class="box-body">
            <?php showSessionMessageIfAny($this);?>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                <table class="datatable table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Business name</th>
                            <th>Agent name</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>CRM</th>
                            <th>Bkgs</th>
                            <th class="no-sort">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($all_agents as $agent){
                            $colorestato = "green";
                            if($agent["status"] != "active")
                                            $colorestato = "red";
                            switch ($agent["statuscrm"]) {
                                    case 'Prospect':
                                            $icocrm = "money";
                                            break;
                                    case 'Trusted':
                                            $icocrm = "hand-shake";
                                            break;
                                    case 'Undesired':
                                            $icocrm = "minus-circle";
                                            break;
                            }
                            switch ($agent["ranking"]) {
                                    case 'Small':
                                            $n_stars = 1;
                                            break;
                                    case 'Standard':
                                            $n_stars = 2;
                                            break;
                                    case 'Medium':
                                            $n_stars = 3;
                                            break;
                                    case 'Large':
                                            $n_stars = 4;
                                            break;
                                    case 'VIP':
                                            $n_stars = 5;
                                            break;										
                            }								
                    ?>
                            <tr>
                                    <td><span class="badge block <?php echo $colorestato?>" style="text-indent:-9999px;padding:1px 8px;"><?php echo $agent["status"]?></span></td>
                                    <td id="agency_<?php echo $agent["id"]?>"><?php echo $agent["businessname"]?><br /><?php for($contastar=1;$contastar<=$n_stars;$contastar++){ ?><img border="0" src="http://plus-ed.com/vision_ag/img/icons/packs/fugue/16x16/star-small.png" style="margin-left:-5px"><?php } ?></td>
                                    <td><?php echo $agent["mainfamilyname"]?> <?php echo $agent["mainfirstname"]?></td>
                                    <td><?php echo $agent["businesscity"]?></td>
                                    <td class="text-center"><?php echo $agent["businesscountry"]?></td>
                                    <td class="text-center"><img height="16" width="16" alt="<?php echo $agent["statuscrm"]?>"  data-container="body" data-toggle="tooltip" title="<?php echo $agent["statuscrm"]?>" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/<?php echo $icocrm ?>.png"><span style="display:none;"><?php echo $agent["statuscrm"]?></span></td>
                                    <td class="text-center"><?php echo $agent["contarighe"]?></td>
                                    <td class="text-center">
                                        <a data-container="body" data-toggle="tooltip" class="min-wd-24 btn btn-xs btn-primary" href="<?php echo base_url(); ?>index.php/agents/manageAgent/<?php echo $agent["id"]?>" title="Edit agent profile" ><i class="fa fa-pencil"></i></a>
                                        <a data-container="body" data-toggle="tooltip" class="min-wd-24 btn btn-xs btn-danger" href="<?php echo base_url(); ?>index.php/agents/viewAgentBookings/<?php echo $agent["id"]?>" title="View agent booking" ><i class="fa fa-list"></i></a>
                                        <a data-container="body" data-toggle="tooltip" class="min-wd-24 btn btn-xs btn-info" href="<?php echo base_url(); ?>index.php/agents/viewChatHistory/<?php echo $agent["id"]?>/sales" title="View conversation history" ><i class="fa fa-comments"></i></a>	
                                        <?php //if($this->session->userdata('email')=="a.sudetti@gmail.com"){?>		
                                            <a onclick="javascript:apriReminder('agente_<?php echo $agent["id"]?>');" id="agente_<?php echo $agent["id"]?>" class="min-wd-24 btn btn-xs btn-warning openreminder" href="javascript:void(0);" data-container="body" data-toggle="tooltip" title="Set agent reminder" ><i class="fa fa-edit"></i></a>		
                                        <?php
                                        //}
                                    ?>
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
        <!-- /.box-body -->
        <div class="box-footer">
            &nbsp;
        </div>
        <!-- /.box-footer-->
      </div>
      </div>
    </div>
    <div id="dialog_modal_agent_reminder" data-backdrop="static" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="modal-title-span">Set reminder</span>
                        <button aria-label="Close" onclick="$('#dialog_modal_agent_reminder').modal('hide');" class="close" type="button">
                            <span aria-hidden="true">×</span></button>
                    </h4>
                </div>
                <div class="modal-body">
                    <form action="" id="form_remind" method="POST">
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="normal" for="rem_messagetext">
                                        <strong>Reminder text</strong>
                                </label>
                            </div>
                            <div class="col-sm-9 form-data">
                                    <input class="form-control required" type=text name="rem_messagetext" id="rem_messagetext" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="normal" for="rem_datetime">
                                        <strong>Reminder date/time</strong>
                                </label>
                            </div>
                            <div class="col-sm-9 form-data">
                                <input class="form-control" type="datetime" name="rem_datetime" id="rem_datetime" />
                            </div>
                        </div>	
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="normal" for="ch_from_am">
                                    <strong>Reminder type</strong>
                                    <small>(For better use)</small>
                                </label>
                            </div>
                            <div class="form-data col-sm-9">
                                <select class="form-control required" name="rem_type" id="rem_type" data-placeholder="Choose reminder type">
                                        <option value="0">Send an email</option> 
                                        <option value="1">Make a call</option> 
                                        <option value="2">Call in Skype</option> 
                                        <option value="3">Go to meeting</option> 
                                        <option value="4">Remember birthday</option> 
                                </select>
                            </div>
                        </div>										
                        <input type="hidden" name="rem_id_ag" id="rem_id_ag" value="">
                        <input type="hidden" name="rem_id_am" id="rem_id_am" value="<?echo $this->session->userdata('id') ?>">
                    </form>
                </div>
                <div class="modal-footer">
                    <button  onclick="$('#dialog_modal_agent_reminder').modal('hide');"  class="btn btn-default pull-left" type="button">Close</button>
                    <button id="btnCancelReminder" class="btn btn-danger cancel">Cancel</button>
                    <button id="btnSubmitReminder" class="btn btn-primary">Submit</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
//        $("#rem_datetime").datetimepicker('setDate', (new Date()));
        $("#rem_datetime").datetimepicker( {dateFormat: "dd/mm/yy"} );	
        
        $("#btnSubmitReminder").click(function(){
            var reminderText = $("#rem_messagetext").val();
            var rem_datetime = $("#rem_datetime").val();
            var rem_type = $("#rem_type").val();
            if(reminderText == "" || rem_datetime == "" || rem_type == "")
                swal("Error","Reminder text, date and type fields are mandatory.");
            else
                $("#form_remind").submit();
        });
        
        $("#btnCancelReminder").click(function(){
            document.getElementById("form_remind").reset();
            $("#dialog_modal_agent_reminder").modal("hide");
        });
        
        
        
    });
    function apriReminder(idThis) {
            $("#rem_id_ag").val("");
            var idattr = idThis.split("_");
            var idag = idattr[1];
            var nameag = $("#agency_"+idag).text();
            $(".modal-title-span").text("Set reminder for agent "+nameag);			
            $("#rem_id_ag").val(idag);
            $("#form_remind").attr("action","<?php echo base_url(); ?>index.php/agents/insertReminder/"+idag);
            //alert(idag);
            $("#dialog_modal_agent_reminder").modal("show");
            return false;
    }
</script>
<style>
    .ui-datepicker{
        font-size: small;
    }
</style>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">Click here to insert new conversation - Agent <?php echo $ag_details[0]['businessname'] ?> - <?php echo $ag_details[0]['businesscountry'] ?></a></h4>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <?php showSessionMessageIfAny($this);
                ?>
                <form id="frmConversation" method="POST" action="<?php echo base_url(); ?>index.php/agents/insertChat/<?php echo $ag_details[0]['id'] ?>">
                    <legend>Insert conversation fields</legend>
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <label class="normal" for="ch_category">
                                     Category 
                                    <small>(Sales / Operations)</small>
                            </label>
                        </div>
                        <div class="form-data col-sm-6">
                            <select class="required form-control" name="ch_category" id="ch_category" data-placeholder="Choose category">
                                    <option value="">Choose category</option>
                                    <option value="sales">Sales</option> 
                                    <option value="operations">Operations</option> 
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="normal" for="ch_messagetext">
                                     Message 
                                    <small>(copy and paste)</small>
                                </label>
                            </div>
                            <div class="form-data col-sm-6">
                                    <textarea class="required form-control" rows=5 name="ch_messagetext" id="ch_messagetext"></textarea>
                            </div>
                    </div>	
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <label class="normal" for="ch_datetime">
                                     Conversation date/time 
                            </label>
                        </div>
                            <div class="form-data col-sm-6">
                                <input class="form-control" type="datetime" name="ch_datetime" id="ch_datetime" />
                            </div>
                    </div>										
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <label class="normal" for="ch_from_am">
                                     Sender 
                                    <small>(You / Agent <?php echo $ag_details[0]['businessname'] ?>)</small>
                            </label>
                        </div>
                        <div class="form-data col-sm-3">
                                <select class="required form-control" name="ch_from_am" id="ch_from_am" data-placeholder="Choose the sender">
                                        <option value="">Choose the sender</option>
                                        <option value="0">Agent <?php echo $ag_details[0]['businessname'] ?></option> 
                                        <option value="1">You</option> 
                                </select>
                        </div>
                    </div>										
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <label class="normal">
                                     Conversation type 
                            </label>
                        </div>
                        <div class="form-data col-sm-6">
                            <div><input class="required" type="radio" name="ch_type" id="ch_type0" value="0">&nbsp;<label class="normal" for="ch_type0">Mail</label></div>											
                            <div><input class="required" type="radio" name="ch_type" id="ch_type1" value="1">&nbsp;<label class="normal" for="ch_type1">Skype</label></div>
                            <div><input class="required" type="radio" name="ch_type" id="ch_type2" value="2">&nbsp;<label class="normal" for="ch_type2">Phone</label></div>
                            <div><input class="required" type="radio" name="ch_type" id="ch_type3" value="3">&nbsp;<label class="normal" for="ch_type3">SMS</label></div>
                            <div><input class="required" type="radio" name="ch_type" id="ch_type4" value="4">&nbsp;<label class="normal" for="ch_type4">Live conversation</label></div>
                            <div for="ch_type" generated="true" class="error"></div>
                        </div>
                    </div>		
                    <div class="row form-data">
                        <div class="col-sm-6 col-sm-offset-3">
                                <input class="btn btn-primary" type="submit" value="Submit" name=submit />
                        </div>
                    </div>										
                <input type="hidden" name="ch_id_ag" id="ch_id_ag" value="<?php echo $ag_details[0]['id'] ?>">
                <input type="hidden" name="ch_id_am" id="ch_id_am" value="">
            </form>	
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                &nbsp;
            </div>
            <!-- /.box-footer-->
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary direct-chat direct-chat-primary">
            <div class="box-header with-border row">
                <?php
                if($categoria=="sales"){
                ?>
                <div class="col-sm-8">
                    <h4 class="box-title">SALES | Conversation history - Agent <?php echo $ag_details[0]['businessname'] ?> - <?php echo $ag_details[0]['businesscountry'] ?></h4>
                </div>
                <div class="col-sm-4">
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url(); ?>index.php/agents/viewChatHistory/<?php echo $ag_details[0]['id'] ?>/operations">
                            <button type="button" class="btn btn-primary" >View OPERATIONS history</button>
                        </a>
                    </div>
                </div>
                <?php
                }else{
                ?>
                <div class="col-sm-8">
                    <h4 class="box-title">OPERATIONS | Conversation history - Agent <?php echo $ag_details[0]['businessname'] ?> - <?php echo $ag_details[0]['businesscountry'] ?></h4>
                </div>
                <div class="col-sm-4">
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url(); ?>index.php/agents/viewChatHistory/<?php echo $ag_details[0]['id'] ?>/sales">
                            <button type="button" class="btn btn-primary" >View SALES history</button>
                        </a>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
            <div class="box-body">
                <div class="direct-chat-messages" style="height: unset!important;">
                    <?php foreach($all_chats as $chat){
                    switch ($chat["ch_type"]) {
                            case 0:
                                    $imgtipo = "mail";
                                    break;
                            case 1:
                                    $imgtipo = "skype";
                                    break;
                            case 2:
                                    $imgtipo = "telephone-handset";
                                    break;
                            case 3:
                                    $imgtipo = "mobile-phone";
                                    break;
                            case 4:
                                    $imgtipo = "user-share";
                                    break;								
                    }
                    $datetime = strtotime($chat["ch_datetime"]);
                    $okidate = date("d/m/Y H:i", $datetime);
                    ?>
                    <!-- Message. Default to the left -->
                    <div class="direct-chat-msg<?php if($chat["ch_from_am"]==0){ ?> right<?php } ?>">
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name <?php echo ($chat["ch_from_am"] == 0 ? "pull-right" : "pull-left");?>">
                            <?php if($chat["ch_from_am"]==0){ ?>
                                <?php echo $ag_details[0]['businessname'] ?> 
                                <span>says:</span>
                                <?php } else { ?>
                                You <span>say:</span> 
                                <?php } ?>
                                
                        </span>
                        <span class="direct-chat-timestamp <?php echo ($chat["ch_from_am"] == 0 ? "pull-left" : "pull-right");?>">
                            <small>
                                    <?php echo $okidate?>
                                    <img style="margin-left:5px;" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/<?php echo $imgtipo?>.png" class="icon">
                            </small>
                        </span>
                      </div>
                      <!-- /.direct-chat-info -->
<!--                      <img class="direct-chat-img" src="<?php echo base_url(); ?>img/icons/packs/iconsweets2/25x25/<?php // if($chat["ch_from_am"]==1){ ?>admin-<?php // } ?>user-2.png" alt="image"> /.direct-chat-img -->
                      <img class="direct-chat-img" src="<?php echo base_url(); ?>lte/dist/img/avatar<?php echo ($chat["ch_from_am"]==1 ? '5' : '04'); ?>.png" alt="image"><!-- /.direct-chat-img -->
                      <div class="direct-chat-text">
                        <?php echo $chat["ch_messagetext"]?>
                      </div>
                      <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->
                     <?php
                        }
                    ?>
            </div>
            <div class="box-footer">
                
            </div>
        </div>
    </div>
</div>
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<link href="<?php echo LTE; ?>plugins/iCheck/all.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script>
    function iCheckInit(){
        $("input[name='ch_type']").iCheck('destroy'); 
        $("input[name='ch_type']").iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '10%' // optional
        });
    }
    
    pageHighlightMenu = "agents/listAgents";
    $(document).ready(function() {
        iCheckInit();
        //$("#ch_datetime").datetimepicker('setDate', (new Date()));
        $("#ch_datetime").datetimepicker({ dateFormat: "dd/mm/yy"});
        
        $.validator.addMethod(
            "australianDate",
            function(value, element) {
                return value.match(/^\d\d?\/\d\d?\/\d\d\d\d?\s?\d\d:\d\d$/);
            },
            "Please enter a date in the format dd/mm/yyyy hh:mm"
        );
        $.validator.addMethod("nonzero", function(value, element) {
            if(value > 0)
                return true;
            else
                return false;
            }, "Should not be zero(0)");

        $("#frmConversation").validate({
            errorElement:"div",
            ignore: "",
            rules: {
                ch_category: "required",
                ch_messagetext: "required",
                ch_from_am: "required",
                ch_datetime:{
                    australianDate: true,
                    required: true
                },
                "ch_type": {
                    required: true
                }
            },
            messages: {
                ch_category: "Please choose category",
                ch_messagetext: "Please enter message text",
                ch_from_am: "Please choose sender",
                ch_datetime: {
                    required: "Please select conversation date/time"
                },
                "ch_type": {
                    required: "Please select conversation type"
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
    });
        
        
    });
</script>
<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header with-border">
            <h4 class="box-title">Organizer</h4>
            <div class="box-tools pull-right">
                <form action="" name="cambiaAnno" id="cambiaAnno" method="POST">
                <input type="number" style="width: 85px;float: left; margin-right: 10px" class="form-control" data-type="spinner" name=annoOrg id=annoOrg value="<?php echo $annoAttuale?>" min="2011" max="<?php echo date("Y" )?>" />
                <input class="btn btn-primary" type="button" name="send" id="send" value="Send">
                </form>
            </div>
        </div>
        <div class="box-body">
            <?php showSessionMessageIfAny($this);?>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                <div id="accordionmesi">
                    <?php 
                    $month = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                    for($mese=1;$mese<=12;$mese++){
                    ?>
                            <h3><a href="#"><?php echo $month[$mese] ?> (<?php echo count($remindme[$mese]) ?>)</a></h3>
                            <div>
                            <?php
                                    if(count($remindme[$mese])){
                                            $adesso = strtotime("now");
                                            foreach($remindme[$mese] as $remino){
                                                    $datagiro = strtotime($remino["r_data"]);
                                                    $diffgiro = $datagiro-$adesso;
                                                    if($diffgiro > 0)
                                                            $coloreg = "success";
                                                    if($diffgiro <= 0 and $diffgiro >= -86400)
                                                            $coloreg = "warning";
                                                    if($diffgiro < -86400)
                                                            $coloreg = "danger";									
                                                    //echo $coloreg."--".$diffgiro."<br />";
                                                    if($remino["r_completo"]==1)
                                                            $coloreg = "note";	
                                                    $pieces = explode(" ", $remino["r_data"]);
                                                    //print_r($pieces);
                                                    $piecesdata = explode("-", $pieces[0]);
                                                    $newdt = $piecesdata[2]."/".$piecesdata[1]."/".$piecesdata[0];
                                                    $piecestime = explode(":", $pieces[1]);
                                                    $newti = $piecestime[0].":".$piecestime[1];		
                                                    switch ($remino["r_tipo"]) {
                                                            case 0:
                                                                    $imgtipo = "mail";
                                                                    break;
                                                            case 1:
                                                                    $imgtipo = "telephone-handset";
                                                                    break;
                                                            case 2:
                                                                    $imgtipo = "skype";
                                                                    break;
                                                            case 3:
                                                                    $imgtipo = "hand-shake";
                                                                    break;
                                                            case 4:
                                                                    $imgtipo = "present";
                                                                    break;								
                                                    }
                                    ?>
                                    <?php
                                    /*
                                     <div class="alert <?php echo $coloreg?>" style="padding-left:5px;">
                                            <img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/calendar.png">
                                            <strong><?php echo $newdt?> <?php echo $newti?> - <?php echo $remino["r_agente"]?>:</strong> <?php echo $remino["r_testo"]?>
                                            <img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/<?php echo $imgtipo?>.png" style="float:right;margin-right:105px;">
                                            <?php 
                                                    if($remino["r_completo"]==0){ 
                                            ?>
                                            <span class="close" id="remi_<?php echo $remino["r_id"]?>">Mark as complete</span>
                                            <?php
                                                    }else{
                                            ?>
                                            <span style="font-weight:bold;position:absolute;right:8px;">Completed</span>
                                            <?php
                                                    }
                                            ?>
                                    </div>
                                     */
                                    ?>
                                <div id="callout_<?php echo $remino["r_id"] ?>" style="font-size: smaller;" class="callout callout-<?php echo $coloreg ?>">
                                <h4>
                                    <i class="fa fa-calendar"></i>
                                    <?php echo $newdt ?> <?php echo $newti ?> - <?php echo $remino["r_agente"] ?>
                                <div class="box-tools pull-right">
                                    <?php 
                                        if($remino["r_completo"]==0){ 
                                    ?>
                                    <button id="remi_<?php echo $remino["r_id"] ?>" class="btn btn-block btn-primary btn-xs reminder-close" type="button">
                                    <img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/<?php echo $imgtipo ?>.png" > Mark as complete</button>
                                    <?php }else{?>
                                    <img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/<?php echo $imgtipo ?>.png" > Completed</button>
                                    <?php }?>
                                </div>
                                </h4>
                                <p><?php echo $remino["r_testo"] ?></p>
                            </div>
                                    <?php
                                            }
                                    }else{
                                            echo "No reminders";
                                    }
                            ?>
                            </div>
                    <?php
                    }
                    ?>	
                    </div>
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
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $( "#accordionmesi" ).accordion({ collapsible: true, active:false,autoHeight: false, clearStyle: true });
        $(".reminder-close").click(function(){
            var thisButton = this;
                var arremi = $(this).attr("id").split("_");
                var chiudo = arremi[1];
                $.ajax({
                        type: "POST",
                        data: "idremi=" + chiudo,
                        url: "<?php echo base_url(); ?>index.php/agents/completeReminder",
                        success:function(){
                            $("#callout_"+chiudo).addClass('callout-note');
                            $("#callout_"+chiudo).removeClass('callout-success');
                            $("#callout_"+chiudo).removeClass('callout-danger');
                            $("#callout_"+chiudo).removeClass('callout-warning');
                            thisButton.remove();
                        }
                });
        });
        $("#send").click(function(){
                $("#cambiaAnno").attr("action","<?php echo base_url(); ?>index.php/agents/viewOrganizer/"+$("#annoOrg").val());
                $("#cambiaAnno").submit();
        });
    });
</script>
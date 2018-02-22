<?php
$plan = isset($plan_detail[0]) ? $plan_detail[0] : null;
  $status_ex1 = $status_ex[0];
  $statook="CONFIRMED";
  $coloreok="#00aa00";
  if($status_ex1=="STANDBY"){
    $statook="STAND BY";
    $coloreok="#dd0000";  
  }
  if($plan["exc_type"]=="planned"){
    $tipoe = "included";
  }else{
    $tipoe = "extra"; 
  } 
  $dataCheckExc = strtotime($plan["pbe_excdate"]);
  $dataCheckToday = strtotime(date("Y-m-d"));
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <form action="" name="excdetail" id="excdetail" class="grid12" method="POST">
        <div class="box box-primary">

          <div class="box-body pos_rel">                

            <h4>
              <?php echo ucfirst($tipoe) ?> excursion detail - Code: <?php echo $bus_code?><span style="float:right;color:<?php echo $coloreok ?>;"><?php echo $statook ?></span>               
            </h4>

            <div>
              <h3 class="evidence"><?php echo $plan["exc_excursion"] ?> - <em><?php echo ucfirst($plan["exc_length"]) ?></em>
              <div class="excursion_type"><?php echo ucfirst($tipoe) ?> excursion</div></h3>
              <p>Campus: <span><?php echo $plan["nome_centri"] ?></span></p>
              <p>Date: <span class="refstandby"><?php echo date("d/m/Y",strtotime($plan["pbe_excdate"])) ?></span></p>
              <p>Pickup place @ time: <span><?php echo $plan["pbe_pickupplace"] ?> @ </span><span class="refstandby"><?php echo date("H:i",strtotime($plan["pbe_hpickup"])) ?></span></p>
              <p>Return time: @ <span><?php echo date("H:i",strtotime($plan["pbe_hreturn"])) ?></span></p>
              <p>Pax Number: <span><?php echo $allpax ?></span></p> 
            </div>

          </div>
        </div>

        <div class="box box-primary">

          <div class="box-body pos_rel">                

            <h4>
              Bookings detail               
            </h4>

            <?php
              foreach($bkg_detail as $book)
              {
            ?>
                <div>
                  <p>Booking reference: <span class="refstandby"><?php echo $book["exb_id_year"] ?>_<?php echo $book["exb_id_book"] ?></span><span>  |  <img class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $book["businesscountry"]?>.png" alt="<?php echo $book["businesscountry"]?>" title="<?php echo $book["businesscountry"]?>" /><?php echo $book["businessname"] ?> | <?php echo $book["tot_pax"] ?> pax</span></p>
                  <p>Booking dates: <span>from <?php echo date("d/m/Y",strtotime($book["arrival_date"])) ?> to <?php echo date("d/m/Y",strtotime($book["departure_date"])) ?></span></p>
                </div>
            <?php 
              } 
            ?>
          </div>
        </div>

      <?php if($this->session->userdata('role')==100) 
            {
      ?>
              <div class="box box-primary">

                <div class="box-body pos_rel">                

                  <h4>
                    Bus and companies detail             
                  </h4>

                  <?php
                    $contaposti=0;
                    $contabus = 1;
                    foreach($bus_detail as $bus)
                    {
                  ?>
                      <div>
                        <p>Bus type <?php echo $contabus?>: <span class="refstandby"><?php echo $bus["tra_cp_name"] ?></span><span> | <?php echo $bus["tra_bus_name"] ?> (<?php echo $bus["tra_bus_seat"] ?> seats)</span></p>
                        <p>Cost: <span><?php echo $bus["pbe_qtybus"] ?> x <?php echo $bus["pbe_jnprice"] ?><?php echo $bus["pbe_jncurrency"] ?> = <strong><?php echo number_format($bus["pbe_qtybus"]*$bus["pbe_jnprice"],2,'.','') ?><?php echo $bus["pbe_jncurrency"] ?></span></p>
                      </div>
                  <?php 
                      $contaposti = $contaposti+($bus["pbe_qtybus"]*$bus["tra_bus_seat"]);
                      $contabus++;
                    }
                    $tipoalert = "success";
                    $infoalert = $allpax." pax - ".$contaposti." seats on booked bus";
                    if($allpax > $contaposti)
                    {
                      $tipoalert = "error";
                      $infoalert = $allpax." pax - ".$contaposti." seats on booked bus - <a href='".base_url()."index.php/backoffice/reviewBusForPlan/".$bus_code."'>Click here</a> to review bus seats";
                    }
                  ?>
                  <div class="alert alert-<?php echo $tipoalert ?>">
                    <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                    <?php echo $infoalert ?>
                  </div>
                </div>
              </div>

              <?php 
                if($dataCheckExc > $dataCheckToday)
                { 
              ?>
                  <div class="box box-primary">

                    <div class="box-body pos_rel">                

                      <h4>
                        Other groups on campus           
                      </h4>

                      <?php
                        if(count($others))
                        {
                          foreach($others as $oth)
                          {
                      ?>
                            <div>
                              <p>Booking reference: <span class="refstandby"><?php echo $oth["id_year"] ?>_<?php echo $oth["id_book"] ?></span><span>  |  <img class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $oth["businesscountry"]?>.png" alt="<?php echo $oth["businesscountry"]?>" title="<?php echo $oth["businesscountry"]?>" /><?php echo $oth["businessname"] ?> | <?php echo $oth["tot_pax"] ?> pax</span></p>
                              <p>Booking dates: <span>from <?php echo date("d/m/Y",strtotime($oth["arrival_date"])) ?> to <?php echo date("d/m/Y",strtotime($oth["departure_date"])) ?></span></p>
                              <input type="button" class="btn btn-primary addGroup" value="Add group <?php echo $oth["id_year"] ?>_<?php echo $oth["id_book"] ?> to excursion code <?php echo $bus_code?>" name="addExc" id="addExc_<?php echo $oth["exb_id"] ?>" />
                            </div>
                      <?php 
                          }
                        }
                        else
                        {
                      ?>
                          <div>
                            <p>No booking on campus matching the selected excursion!</p>
                          </div>  
                      <?php
                        }
                      ?>
                    </div>
                  </div>

          <?php } ?>
                <div class="box box-primary">

                  <div class="box-body pos_rel">                

                    <h4>
                      Campus Manager excursion review               
                    </h4>

                    <div>
                      <p><label style="width:170px;float:left;">Service completed </label><input type="checkbox" name="service_completed_view" disabled value="yes"<?php if($plan["pbe_cm_done"]==1){ ?> checked="checked" <?php } ?>></p>
                    </div>

                    <div>
                      <p><label style="width:170px;float:left;">Bus Service not compliant </label><input type="checkbox" name="bus_not_compliant_view" disabled value="yes"<?php if($plan["pbe_cm_ok"]==1){ ?> checked="checked" <?php } ?>></p>
                    </div>

                    <div>
                      <p><label style="width:170px;float:left;">Excursion/Service Notes </label><textarea disabled style="width:400px;" name="exc_notes_view"><?php echo $plan["pbe_cm_notes"]?></textarea></p>
                    </div>

                  </div>
                </div>

                <div class="actions">
                  <div class="left">
                    <a href="<?php echo base_url(); ?>index.php/backoffice/printPDFExc/<?php echo $bus_code?>" target="_blank"><input type="button" class="btn btn-danger" value="Print PDF for Companies" name="printPDFExc" id="printPDFExc" /></a>
                  </div>          
                  <div class="right">
                  <?php if($dataCheckExc > $dataCheckToday){ 
                  ?>
                    <input type="button" class="btn btn-danger" value="Reset" name="resetExc" id="resetExc" />
                  <?php
                  if($status_ex1=="STANDBY"){
                  ?>
                    <input type="button" value="Confirm" name="confirmExc" id="confirmExc" class="btn btn-default"/>
                  <?php
                  }
                  }
                  ?>
                  </div>
                </div>
      <?php 
            }
            else
            {
      ?>
              <div class="box box-primary">

                <div class="box-body pos_rel">                

                  <h4>
                    Bus and companies detail              
                  </h4>

                  <?php
                    $contabus = 1;
                    foreach($bus_detail as $bus){
                  ?>
                  <div>
                    <p>Bus type <?php echo $contabus?>: <span class="refstandby"><?php echo $bus["tra_cp_name"] ?></span><span> | <?php echo $bus["pbe_qtybus"] ?> x <?php echo $bus["tra_bus_name"] ?> (<?php echo $bus["tra_bus_seat"] ?> seats)</span></p>
                  </div>
                  <?php
                    $contabus++;
                    }
                  ?>

                </div>
              </div>

              <?php if($dataCheckExc <= $dataCheckToday){ ?>
                <div class="box box-primary">

                  <div class="box-body pos_rel">                

                    <h4>
                      Excursion review             
                    </h4>

                    <div>
                      <p><label style="width:170px;float:left;">Service completed </label><input type="checkbox" name="service_completed" id="service_completed" value="yes"<?php if($plan["pbe_cm_done"]==1){ ?> checked="checked" <?php } ?>></p>
                    </div>            
                    <div>
                      <p><label style="width:170px;float:left;">Bus Service not compliant </label><input type="checkbox" name="bus_not_compliant" id="bus_not_compliant" value="yes"<?php if($plan["pbe_cm_ok"]==1){ ?> checked="checked" <?php } ?>></p>
                    </div>  
                    <div>
                      <p><label style="width:170px;float:left;">Excursion/Service Notes </label><textarea style="width:400px;" name="exc_notes" id="exc_notes"><?php echo $plan["pbe_cm_notes"]?></textarea></p>
                    </div>

                  </div>
                </div>
                <div class="actions">
                  <div class="left"></div>          
                  <div class="right">
                    <input type="button" class="btn btn-danger" value="Set review for excursion" name="setRevExc" id="setRevExc" />
                  </div>
                </div>
        <?php } 
            } 
      ?>
      </form>
      <?php 
        if($this->session->userdata('role')==200)
        { 
      ?>         
          <form name="revExcForm" id="revExcForm" method="POST" action="<?php echo base_url(); ?>index.php/backoffice/setExcReview/<?php echo $bus_code?>">
            <input type="hidden" name="cm_bus_not_compliant" id="cm_bus_not_compliant" value="" />
            <input type="hidden" name="cm_service_completed" id="cm_service_completed" value="" />
            <input type="hidden" name="cm_exc_notes" id="cm_exc_notes" value="" />
          </form> 
  <?php } ?>  
    </div>
  </div>
</section>
<script>
  pageHighlightMenu = "backoffice/servicesReview";
  $(document).ready(function() {
    <?php if($this->session->userdata('role')==100){ ?> 
    
    $("#resetExc").click(function(){
      if(confirm("Are you sure you want to reset this excursion plan?")){
        window.location.replace("<?php echo base_url(); ?>index.php/backoffice/busExcReset/<?php echo $bus_code?>");
      }
    });
    $("#confirmExc").click(function(){
      if(confirm("Are you sure you want to confirm this excursion plan?")){
        window.location.replace("<?php echo base_url(); ?>index.php/backoffice/busExcConfirm/<?php echo $bus_code?>");
      }
    }); 
    $(".addGroup").click(function(){
      if(confirm("Are you sure you want to add this group to the excursion plan?")){
        var exbId = $(this).attr("id").split("_")[1];
        window.location.replace("<?php echo base_url(); ?>index.php/backoffice/addGroupToBusCode/<?php echo $bus_code?>/"+exbId+"/<?php echo $plan["pbe_excdate"] ?>");
        return false;
      }
    }); 

    <?php }else{ ?>
    
    $("#setRevExc").click(function(){
      if(confirm("Are you sure you want to review informations and notes for this excursion plan?")){
        if($("#bus_not_compliant").attr("checked")=="checked"){
          $("#cm_bus_not_compliant").val("1");
        }else{
          $("#cm_bus_not_compliant").val("0");
        } 
        if($("#service_completed").attr("checked")=="checked"){
          $("#cm_service_completed").val("1");
        }else{
          $("#cm_service_completed").val("0");
        }       
        $("#cm_exc_notes").val($("#exc_notes").val());        
        $("#revExcForm").submit();
      }
    }); 
    <?php } ?>
    
  });
</script> 
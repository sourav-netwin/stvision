<?php
  $plan = $plan_detail[0];
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
                foreach($bkg_detail as $book){
            ?>
            <div class="row" style="padding:8px 12px;">
                    <p>Booking reference: <span class="refstandby"><?php echo $book["pte_book_id"] ?></span><span>  |  <img class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $book["businesscountry"]?>.png" alt="<?php echo $book["businesscountry"]?>" title="<?php echo $book["businesscountry"]?>" /><?php echo $book["businessname"] ?> | <?php echo $book["pte_tot_pax"] ?> pax</span></p>
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
                            $contabus = 1;
                            foreach($bus_detail as $bus){
                    ?>
                    <div style="padding:8px 12px;">
                            <p>Bus type <?php echo $contabus?>: <span class="refstandby"><?php echo $bus["tra_cp_name"] ?></span><span> | <?php echo $bus["tra_bus_name"] ?> (<?php echo $bus["tra_bus_seat"] ?> seats)</span></p>
                            <p>Cost: <span><?php echo $bus["pbe_qtybus"] ?> x <?php echo $bus["pbe_jnprice"] ?><?php echo $bus["pbe_jncurrency"] ?> = <strong><?php echo number_format($bus["pbe_qtybus"]*$bus["pbe_jnprice"],2,'.','') ?><?php echo $bus["pbe_jncurrency"] ?></span></p>
                    </div>	
                    <?php
                            $contabus++;
                            }
                    ?>
                </div>
              </div>
              
          <div class="box box-primary">
              <div class="box-body">
                  <h4 class="box-title">Other groups on campus</h4>
                        <?php
                                if(count($others)){
                                        foreach($others as $oth){
                                ?>
                                <div  style="padding:8px 12px;">
                                        <p>Booking reference: <span class="refstandby"><?php echo $oth["id_year"] ?>_<?php echo $oth["id_book"] ?></span><span>  |  <img class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $oth["businesscountry"]?>.png" alt="<?php echo $oth["businesscountry"]?>" title="<?php echo $oth["businesscountry"]?>" /><?php echo $oth["businessname"] ?> | <?php echo $oth["tot_pax"] ?> pax</span></p>
                                        <p>Booking dates: <span>from <?php echo date("d/m/Y",strtotime($oth["arrival_date"])) ?> to <?php echo date("d/m/Y",strtotime($oth["departure_date"])) ?></span></p>
                                        <input type="button" class="btn btn-primary bookForGroup" value="Book this excursion for group <?php echo $oth["id_year"] ?>_<?php echo $oth["id_book"] ?>" name="bookExc" id="bookExc_<?php echo $plan["pbe_jnidexc"] ?>_<?php echo $oth["id_book"] ?>_<?php echo $bus_code?>" />
                                </div>	
                                <?php
                                        }
                                }else{
                                ?>
                                <div style="padding:8px 12px;">
                                        <p>No booking on campus matching the selected excursion!</p>
                                </div>								

                                <?php
                                }
                        ?>
              </div>
          </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-sm-12">
                <a href="<?php echo base_url(); ?>index.php/backoffice/printPDFAllExc/<?php echo $bus_code?>" target="_blank">
                    <input type="button" class="btn btn-danger" value="Print PDF for Companies" name="printPDFExc" id="printPDFExc" />
                </a>
                    <input type="button" class="btn btn-danger pull-right" value="Reset" name="resetExc" id="resetExc" />
                    <?php
                    if($status_ex1=="STANDBY"){
                    ?>
                            <input class="btn btn-primary" type="button" value="Confirm" name="confirmExc" id="confirmExc" />
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div><!-- End of .actions -->
        <?php } ?>
     </form>  
    </div>
  </div>
</section>
<script>
  pageHighlightMenu = "backoffice/viewPlannedAllExcursions";
  $(document).ready(function() {
    $("#resetExc").click(function(){
            if(confirm("Are you sure you want to reset this excursion plan?")){
                    window.location.replace("<?php echo base_url(); ?>index.php/backoffice/busAllExcReset/<?php echo $bus_code?>/<?php echo $tipoe ?>");
            }
    });
    $("#confirmExc").click(function(){
            if(confirm("Are you sure you want to confirm this excursion plan?")){
                    window.location.replace("<?php echo base_url(); ?>index.php/backoffice/busAllExcConfirm/<?php echo $bus_code?>");
            }
    });		
    $(".bookForGroup").click(function(){
            if(confirm("Are you sure you want to book this excursion for the selected group?")){
                    window.location.replace("<?php echo base_url(); ?>index.php/backoffice/bookExtraExcursionForGroup/"+$(this).attr("id"));
            }
    });		    
  });
</script> 
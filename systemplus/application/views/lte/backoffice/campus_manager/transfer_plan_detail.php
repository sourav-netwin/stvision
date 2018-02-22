<?php
  $plan = @$plan_detail[0];
  $status_ex1 = @$status_ex[0];
  $statook="CONFIRMED";
  $coloreok="#00aa00";
  if($status_ex1=="STANDBY"){
    $statook="STAND BY";
    $coloreok="#dd0000";  
  }
  $tipoe = "transfer";
?>
<style type="text/css">
  .evidence{
    height: 50px;
    color: #B00;
  }
  .transfer-plan-content span {
    font-weight: bold;
  }
  .refstandby {
    color: #B00;
  }
</style>
<section class="content transfer-plan-content">
  
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header col-sm-12">
          <div class="text-right">
            <span style="color:<?php echo $coloreok ?>;"><?php echo $statook ?></span>
          </div>
        </div>

        <div class="box-body">                

          <?php
            if($tipo_ex=="inbound")
            {
          ?>
              <h4 class="evidence">
                Transfer inbound from <?php echo str_replace("to/from","",$plan["exc_excursion"]) ?> to <?php echo $plan["nome_centri"] ?>
                <font><?php echo ucfirst($tipoe) ?></font>
              </h4>

              <p>
                From airport: <span><?php echo str_replace("to/from","",$plan["exc_excursion"]) ?></span>
              </p>

              <p>
                To campus: <span><?php echo $plan["nome_centri"] ?></span>
              </p>
        <?php
            }
            else
            {
        ?>
              <h4>
                Transfer outbound from <?php echo $plan["nome_centri"] ?> to <?php echo str_replace("to/from","",$plan["exc_excursion"]) ?>
                <font><?php echo ucfirst($tipoe) ?></font>
              </h4>

              <p>
                From campus: <span><?php echo $plan["nome_centri"] ?></span>
              </p>

              <p>
                To airport: <span><?php echo str_replace("to/from","",$plan["exc_excursion"]) ?></span>
              </p>

        <?php
            }
        ?>
            <p>
              Date: <span class="refstandby"><?php echo date("d/m/Y",strtotime($plan["pbe_excdate"])) ?></span>
            </p>

            <p>
              Extra Info: <span><?php echo $plan["pbe_pickupplace"] ?></span>
            </p>

        <?php
            if(date("H:i",strtotime($plan["pbe_hpickup"]))!="00:00")
            {
        ?>              
              <p>
                Pickup time: <span class="refstandby"><?php echo date("H:i",strtotime($plan["pbe_hpickup"])) ?></span>
              </p>
        <?php
            }
        ?>              
        <?php
            if($ruolo==100)
            {
        ?>
              <p>
                Pax Number: <span><?php echo $allpax ?><?php if($allpax != $effettivi){ ?><font style="color:#f00;font-weight:bold;"> (<?php echo $effettivi ?> actual pax)</font><?php } ?></span><a style="float:right;" href="javascript:void(0);" class="viewEntirePaxList"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/edit-list-order.png"><span style="float:right;width:100px;text-align:center;">View pax list</span></a>
              </p>
        <?php
            }
            else
            {
        ?>
              <p>
                Pax Number: <span><?php echo $effettivi ?><a style="float:right;" href="javascript:void(0);" class="viewEntirePaxList"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/edit-list-order.png"></span><span style="float:right;width:100px;text-align:center;">View pax list</span></a>
              </p>
        <?php
            }
        ?>

        </div>
      </div>

      <div class="box box-primary">
        <div class="box-header col-sm-12">
          <h4>Transfer detail</h4>
        </div>

        <div class="box-body">                

          <?php
              //print_r($bkg_detail);
              foreach($bkg_detail as $book){
            ?>
            <div class="row" style="padding:8px 12px;">
              <?php
              if($ruolo==100){
              ?>            
              <p>Booking reference: <span><?php echo $book["ptt_book_id"] ?>  |  <img class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $book["businesscountry"]?>.png" alt="<?php echo $book["businesscountry"]?>" title="<?php echo $book["businesscountry"]?>" /><?php echo $book["businessname"] ?> | <?php echo $book["ptt_tot_pax"] ?> pax <?php if($book["realpax"] != $book["ptt_tot_pax"]){ ?><font style="font-weight:bold;color:red;">(<?php echo $book["realpax"] ?> actual pax)</font><?php } ?></span></p>
              <?php
              }else{
              ?>
              <p>Booking reference: <span><?php echo $book["ptt_book_id"] ?>  |  <img class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $book["businesscountry"]?>.png" alt="<?php echo $book["businesscountry"]?>" title="<?php echo $book["businesscountry"]?>" /><?php echo $book["businessname"] ?> | <?php echo $book["realpax"] ?> pax </span></p>
              <?php
              }
              ?>              
              <p>Flight Detail: <span><?php echo $book["ptt_flight"] ?>@</span><span class="refstandby"><?php echo date("H:i",strtotime($book["ptt_dataora"])) ?></span> | <?php echo $book["ptt_airport_from"] ?> &#x2708; <?php echo $book["ptt_airport_to"] ?></span></p>
            </div>  
            <?php
              }
            ?>

        </div>
      </div>

      <div class="box box-primary">
        <div class="box-header col-sm-12">
          <h4>Bus and companies detail</h4>
        </div>

        <div class="box-body">                

          <?php
              $contabus = 1;
              foreach($bus_detail as $bus){
            ?>
            <div class="row" style="padding:8px 12px;">
              <p>Bus type <?php echo $contabus?>: <span class="refstandby"><?php echo $bus["tra_cp_name"] ?></span><span> | <?php echo $bus["pbe_qtybus"] ?> x <?php echo $bus["tra_bus_name"] ?> (<?php echo $bus["tra_bus_seat"] ?> seats)</span></p>
              <?php
                if($ruolo==100){
              ?>
              <p>Cost: <span><?php echo $bus["pbe_qtybus"] ?> x <?php echo $bus["pbe_jnprice"] ?><?php echo $bus["pbe_jncurrency"] ?> = <strong><?php echo number_format($bus["pbe_qtybus"]*$bus["pbe_jnprice"],2,'.','') ?><?php echo $bus["pbe_jncurrency"] ?></strong></span></p>
              <?php
              }
              ?>
            </div>  
            <?php
              $contabus++;
              }
            ?>

        </div>
      </div>

      <?php
        if($ruolo==100)
        {
      ?>          
          <div class="actions">
            <span class="pull-left">
              <a href="<?php echo base_url(); ?>index.php/backoffice/printPDFTra/<?php echo $bus_code?>" target="_blank"><input type="button" class="btn btn-danger" value="Print PDF for Companies" name="printPDFTra" id="printPDFTra" /></a>
            </span>          
            <span class="pull-right">
              <input type="button" class="btn btn-danger" value="Reset" name="resetExc" id="resetExc" />
            <?php
            if($status_ex1=="STANDBY"){
            ?>
              <input type="button" class="btn btn-primary" value="Confirm" name="confirmExc" id="confirmExc" />
            <?php
            }
            ?>
            </span>
          </div><!-- End of .actions -->
          <?php
          }
          ?>
    </div>
  </div>
</section>

<div class="modal fade" id="dialog_modal_paxlist" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="padding: 15px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="pdfModalLabel">Pax List | Bus code <?php echo $bus_code?> (Please set orientation to LANDSCAPE before print!)</h4>
      </div>
      <div id="modal_paxlist_body" class="modal-body" style="overflow: auto;height: 500px;"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="print_dialog_modal_paxlista">Print</button>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url(); ?>js/jquery.printElement.min.js"></script>  
<script>
  pageHighlightMenu = "backoffice/ca_viewBookedTransfers";
  $(document).ready(function() {

    $("#print_dialog_modal_paxlista").click(function(){
      $('#dialog_modal_paxlist table').printElement();
    });  
    
    $("#resetExc").click(function(){
      if(confirm("Are you sure you want to reset this transfer plan?")){
        window.location.replace("<?php echo base_url(); ?>index.php/backoffice/busTraReset/<?php echo $bus_code?>");
      }
    });
    $("#confirmExc").click(function(){
      if(confirm("Are you sure you want to confirm this transfer plan?")){
        window.location.replace("<?php echo base_url(); ?>index.php/backoffice/busTraConfirm/<?php echo $bus_code?>");
      }
    });   
    $(".viewEntirePaxList").click(function(){
      $.post( '<?php echo base_url(); ?>index.php/backoffice/ca_getTransfersPaxFromBusCode/<?php echo $bus_code?>/<?php echo $tipo_ex?>', function( data ) {
          $("#modal_paxlist_body").html('');
          $("#dialog_modal_paxlist").modal("show");
          $("#modal_paxlist_body").html(data);

          if( $.trim( $("#modal_paxlist_body table tbody").html() ) == "" )
          {
            $("#print_dialog_modal_paxlista").hide();
          }
          else
          {
            $("#print_dialog_modal_paxlista").show();
          }
      });    
    });     
  
  });
</script>
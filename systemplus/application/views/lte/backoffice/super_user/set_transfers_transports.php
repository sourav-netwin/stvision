<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<section class="content">
  <div class="row">
    
    <div class="col-xs-12">
      <div class="box">
        <form name="allbuses" id="allbuses" method="POST" action="<?php echo base_url(); ?>index.php/backoffice/plusedConfirmTransfersBuses">
        <input type="hidden" name="id_exc_join" id="id_exc_join" value="<?php echo $excursion_id ?>" />
        <div class="box-body table-responsive">
          <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID book</th>
                  <th>Agency</th>
                  <th>Flight info</th>
                  <th>Total pax</th>  
                </tr>
              </thead>
              <tbody>
                <?php
                  if( count($allTransfers) > 0 )
                  {
                    foreach($allTransfers as $aT)
                    {
                ?>
                      <input type="hidden" name="exc_numb[]" value="<?php echo $aT["ptt_id"]?>">
                      <tr>
                        <td class="center">
                          <?php echo $aT["ptt_book_id"]?>
                        </td>
                        <td class="center">
                          <?php echo $aT["agency"]?>
                        </td>                 
                        <td class="center" style="width:235px;"><div style="width:60px;background-color:#ddd;float:left;color:#17549B;"><?php echo date("H:i",strtotime($aT["ptt_dataora"]))?></div><div style="width:60px;background-color:#ccc;float:left;font-weight:bold;color:#333;"><?php echo $aT["ptt_flight"]?></div><div style="width:120px;background-color:#bbb;clear:left;float:left;font-weight:normal;color:#000;"><?php echo $aT["ptt_airport_from"]?> &#x2708; <?php echo $aT["ptt_airport_to"]?></div></td>
                        <td class="center"><?php echo $aT["tot_pax"]?></td>
                      </tr>
                <?php
                    }
                  }
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>ID book</th>
                  <th>Agency</th>
                  <th>Flight info</th>
                  <th>Total pax</th>
                </tr>
              </tfoot>
            </table>

            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Set extra info (please specify pickup place)</th>
                  <th>Select pickup time</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <?php if($in_out=="inbound") { ?>
                      <textarea id="pickup_place" name="pickup_place" style="width:80%;">FROM <?php echo str_replace("to/from","",$airport) ?> TO <?php echo $pickupPlace ?></textarea>         
                    <?php } else { ?>
                      <textarea id="pickup_place" name="pickup_place" style="width:80%;">FROM <?php echo $pickupPlace ?> TO <?php echo str_replace("to/from","",$airport) ?></textarea>         
                    <?php } ?>
                  </td>
                  <td>
                    <input type="text" id="pickup_time" name="pickup_time" value="" style="width:60px;" />
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th>Set extra info (please specify pickup place)</th>
                  <th>Select pickup time</th>
                </tr>
              </tfoot>
            </table>

            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Company</th>
                  <th>Bus type / Seats</th>
                  <th>Transfer</th>
                  <th>Cost</th>                 
                  <th>Select</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  if( $bus ) 
                  {
                    foreach( $bus as $bb )
                    { 
                ?>
                      <tr>
                        <td>
                          <?php echo $bb["tra_cp_name"]?>
                        </td>
                        <td>
                          <?php echo $bb["tra_bus_name"]?> / <?php echo $bb["tra_bus_seat"]?>
                        </td>                 
                        <td><?php echo $bb["exc_excursion"]?></td>
                        <td style="text-align:right;"><?php echo $bb["jn_price"]?> <?php echo $bb["jn_currency"]?></td>
                        <td class="center containcheck">
                          <select class="bus_num" name="bus_<?php echo $bb["jn_id_bus"] ?>" id="bus_<?php echo $bb["jn_id_bus"] ?>">
                            <option value="0">-</option>
                            <option value="1">1 bus</option>
                            <option value="2">2 buses</option>
                            <option value="3">3 buses</option>
                            <option value="4">4 buses</option>
                            <option value="5">5 buses</option>
                          </select>
                        </td>
                        <input type="hidden" name="currency_<?php echo $bb["jn_id_bus"] ?>" id="currency_<?php echo $bb["jn_id_bus"] ?>" value="<?php echo $bb["jn_currency"]?>" />
                        <input type="hidden" name="cost_<?php echo $bb["jn_id_bus"] ?>" id="cost_<?php echo $bb["jn_id_bus"] ?>" value="<?php echo $bb["jn_price"]?>" />
                        <input type="hidden" class="tcost" name="totcost_<?php echo $bb["jn_id_bus"] ?>" id="totcost_<?php echo $bb["jn_id_bus"] ?>" value="0" />
                        <input type="hidden" name="pax_<?php echo $bb["jn_id_bus"] ?>" id="pax_<?php echo $bb["jn_id_bus"] ?>" value="<?php echo $bb["tra_bus_seat"]?>" />
                        <input type="hidden" class="tpax" name="totpax_<?php echo $bb["jn_id_bus"] ?>" id="totpax_<?php echo $bb["jn_id_bus"] ?>" value="0" />                  
                      </tr>
            <?php   } ?>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                      <td class="center"><input style="text-align:center;" type="text" readonly value="0" name="suppax" id="suppax" /></td>
                      <td style="text-align:right;"><input style="text-align:right;" type="text" readonly value="0" name="supcost" id="supcost" /> <?php echo $bb["jn_currency"]?></td>
                      <td></td>
                    </tr> 
                    <tr>
                      <td colspan="2">&nbsp;</td>
                      <td class="center"><input style="text-align:center;border:none;box-shadow:none;background-color:transparent;width:150px;" type="text" readonly value="" name="exppax" id="exppax" /></td>
                      <td colspan="2"><input style="text-align:right;border:none;box-shadow:none;background-color:transparent;width:150px;color:#5E6267;padding-right:0;" type="text" readonly value="" name="pricepax" id="pricepax" /> <?php echo $bb["jn_currency"]?> @pax</td>
                    </tr>
              <?php
                  } 
              ?>
              </tbody>
              <input type="hidden" name="pppax" id="pppax" value="<?php echo $tot_pax?>" />
              <tfoot>
                <tr>
                  <th>Company</th>
                  <th>Bus type / Seats</th>
                  <th>Transfer</th>
                  <th>Cost</th>                 
                  <th>Select</th>
                </tr>
              </tfoot>
            </table>

          
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-right">
            <button disabled class="btn btn-danger alt_btn" type="submit" id="bus_all" name="bus_all">Confirm bus transportation for selected excursions</button>
        </div>
        <input type="hidden" name="quando_tra" id="quando_tra" value="<?php echo $quando?>" />
        </form>
        <!-- /.box-footer-->
      </div>
    </div>
  </div>
</section>

<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  function aggpaxcost(){
    var supcost = 0;
    var suppax = 0;
    $(".tcost").each(function(){
      supcost += $(this).val()*1;
    });
    $(".tpax").each(function(){
      suppax += $(this).val()*1;
    }); 
    $("#supcost").val(supcost.toFixed(2));
    $("#suppax").val(suppax);
    $("#pricepax").val(((supcost/<?php echo $tot_pax ?>)*1).toFixed(2));
    var diff = $("#suppax").val() - $("#pppax").val();
    if(diff < 0){
      $("#suppax").css("background-color","#880000");
      $("#suppax").css("color","#ffffff");  
      $("#exppax").val(diff+" pax remaining!");   
    }
    if(diff >= 0 && diff <= 5){
      $("#suppax").css("background-color","#008800");
      $("#suppax").css("color","#ffffff");  
      $("#exppax").val("Just "+diff+" extra seats selected!");      
    }
    if(diff > 5){
      $("#suppax").css("background-color","#d14000");
      $("#suppax").css("color","#ffffff");  
      $("#exppax").val(diff+" extra seats selected!");    
    }
    if($("#suppax").val() > 0){
      $('#bus_all').prop("disabled", false);
    }else{
      $('#bus_all').prop("disabled", true);
    }
  }

  $(document).ready(function() {
  
    var dateT = new Date(<?php echo date("Y",strtotime($aT["ptt_dataora"]))?>,<?php echo date("n",strtotime($aT["ptt_dataora"]))?>,<?php echo date("j",strtotime($aT["ptt_dataora"]))?>,<?php echo date("H",strtotime($aT["ptt_dataora"]))?>,<?php echo date("i",strtotime($aT["ptt_dataora"]))?>,0);
      aggpaxcost();
    $(".bus_num").change(function(){
      var arrclassi = $(this).attr("id").split("_");
      var arrid = "#cost_"+arrclassi[1];
      var totid = "#totcost_"+arrclassi[1];
      var arrpx = "#pax_"+arrclassi[1];
      var totpx = "#totpax_"+arrclassi[1];
      $(totid).val($(arrid).val()*$(this).val());
      $(totpx).val($(arrpx).val()*$(this).val());
      aggpaxcost();
    }); 
    $( "#pickup_time" ).timepicker({timeFormat: "hh:mm"}).timepicker("setTime", dateT);

  });
</script>
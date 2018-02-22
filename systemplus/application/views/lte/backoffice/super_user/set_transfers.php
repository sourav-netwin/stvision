<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<section class="content">
  <div class="row">

    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
          <div class="row">
            <?php showSessionMessageIfAny($this);?>
          </div>
          <form id="box_transport" name="box_transport" action="<?php echo base_url(); ?>index.php/backoffice/setTransfers/<?php echo $in_out ?>" method="POST">
            <div class="row payment_row">

              <div class="form-group col-sm-4 col-md-2">
                <label for="centricampus">Campus:</label>
                <select class="form-control" id="centricampus" name="centri">
                  <option <?php if($campus==""){?>selected <?php }?> value="">All campus</option>
                  <?php
                    foreach($centri as $key=>$item)
                    {
                  ?>
                      <option <?php if($campus==$item['id']){?>selected <?php }?>value="<?php echo $item['id']?>"><?php echo $item['nome_centri']?></option>
            <?php   } ?>
                </select>
              </div>

              <div class="form-group col-sm-4 col-md-2">
                <label for="centricampus"><?php echo ( $in_out == "inbound" ) ? "Arrival day" : "Departure day"; ?>:</label>
                <input type="text" id="when" name="when" value="<?php echo $when ?>" class="form-control" readonly/>
              </div>

              <div class="col-sm-4 col-md-2 mr-top-25">
                <input class="btn btn-primary" type="submit" value="Search" id="transpmi" name="transpmi"/>
              </div>

              <div class="col-sm-4 col-md-6">
                <a href="javascript:void(0);" id="findTr" class="pull-right">
                  <i class="fa fa-minus-circle" aria-hidden="true"></i>
                </a>
              </div>

            </div>
          </form>
        </div>
        <div class="box-body">
          <?php
            $arrdataw = explode("/",$when);
            $datagiusta = $arrdataw[2]."-".$arrdataw[1]."-".$arrdataw[0];
          ?>
          <form id="alltran" name="alltran" action="<?php echo base_url(); ?>index.php/backoffice/setTransfersTransport/<?php echo $in_out ?>/<?php echo $campus ?>/<?php echo $datagiusta ?>" method="POST">
            <table id="dataTableStaffPriority" class="table datatable table-bordered table-striped">
              <thead>
                <tr>
                  <th>Campus</th>
                  <th>Booking id</th>
                  <th>Agency</th>
                  <th>Arrival date</th>
                  <th>Arrival flight</th>
                  <th>Pax</th>
                  <th class="no-sort">Select</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  if( count($all_transfers) > 0 )
                  {
                    foreach($all_transfers as $exc)
                    {
                ?>
                      <tr>
                        <td>
                          <?php echo $exc["nome_centri"]?>
                        </td>
                        <td class="center n_<?php echo $exc["statopre"]?>">
                          <strong>
                            <?php echo $exc["bookid"]?>
                            <?php if($exc["start_end_overnight"]=="end"){ ?>
                              <br />
                              <span style="background-color: #FFF;color: #f00;padding: 1px 4px;border-radius: 5px;font-size: 10px;">NO TRNSF IN (ref. <?php echo $exc["id_ref_overnight"] ?>)</span>
                            <?php } ?>
                            <br />
                            <span style="color:#f00"><?php echo $exc["totForBook"]?> pax unmatched</span>
                          </strong>
                        </td>
                        <td>
                          <img src="<?php echo base_url(); ?>img/flags/16/<?php echo $exc["businesscountry"]?>.png" alt="<?php echo $exc["businesscountry"]?>" data-toggle="tooltip" data-original-title="<?php echo $exc["businesscountry"]?>" style="margin-right: 5px;"/><?php echo $exc["businessname"]?>
                        </td>
                        <td>
                          <?php echo date("d/m/Y",strtotime($exc["andata_data_arrivo"]))?>
                        </td>
                        <td>
                          <div style="width:60px;background-color:#ddd;float:left;color:#17549B;">
                            <?php echo date("H:i",strtotime($exc["andata_data_arrivo"]))?>
                          </div>
                          <div style="width:60px;background-color:#ccc;float:left;font-weight:bold;color:#333;">
                            <?php echo $exc["andata_volo"]?>
                          </div>
                          <div style="width:120px;background-color:#bbb;clear:left;float:left;font-weight:normal;color:#000;">
                            <?php echo $exc["andata_apt_partenza"]?> &#x2708; <?php echo $exc["andata_apt_arrivo"]?>
                          </div>
                          <?php if($exc["ptt_buscompany_code"]!=""){ ?>
                            <button <?php if($campus==""){ ?>disabled <?php } ?>class="btn btn-danger addToTransfer" id="<?php echo $exc["ptt_buscompany_code"]?>_<?php echo $exc["id_book"] ?>_<?php echo $exc["id_year"] ?>_<?php echo $exc["totnumpax"]?>" name="">Add to <?php echo $exc["ptt_buscompany_code"]?><br /><?php echo $exc["oldName"]?></button>
                          <?php } ?>
                        </td>
                        <td><?php echo $exc["totnumpax"]?></td>
                        <td>
                          <input <?php if($campus=="" or $exc["andata_volo"]=="" or $exc["andata_apt_arrivo"] == ""){ ?>disabled <?php } ?>type="checkbox" name="transfer[]" value="<?php echo $exc["bookid"]?>_<?php echo date("U",strtotime($exc["andata_data_arrivo"]))?>_<?php echo $exc["andata_apt_partenza"]?>_<?php echo $exc["andata_apt_arrivo"]?>_<?php echo $exc["andata_volo"]?>_<?php echo $exc["idcentro"]?>_<?php echo $exc["totnumpax"]?>" class="transfer" />
                        </td>
                      </tr>
                <?php
                    }
                  }
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>Campus</th>
                  <th>Booking id</th>
                  <th>Agency</th>
                  <th>Arrival date</th>
                  <th>Arrival flight</th>
                  <th>Pax</th>
                  <th>Select</th>
                </tr>
              </tfoot>
            </table>
          </form>
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-right">
          <button <?php if($campus==""){ ?>disabled <?php } ?>class="btn btn-danger alt_btn" id="tra_all" name="tra_all">Set transportation for selected transfers</button>
        </div>
        <!-- /.box-footer-->
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="setTransferModal" tabindex="-1" role="dialog" aria-labelledby="setTransferModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="setTransferModalLabel">Transfer calendar</h4>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {

  $( "#when" ).datepicker({
    defaultDate: "+1d",
    changeMonth: true,
    numberOfMonths: 1,
    dateFormat: "dd/mm/yy"
  });

  $("#tra_all").click(function(){
    $("#alltran").submit();
  });

  $(".addToTransfer").click(function(e){
    e.preventDefault();
    arrmid = $(this).attr("id").split("_");
    if(confirm("Are you sure you want to add these pax to this service?")){
      window.location.replace("<?php echo base_url(); ?>index.php/backoffice/addPaxToExistingTransfer/"+arrmid[0]+"/"+arrmid[1]+"/"+arrmid[2]+"/"+arrmid[3]);
    }
    else
    {
      return(void(0));
    }
  });

  $('#findTr').on('click', function(e){
    passingData = $('#box_campus').serialize();

    $.post( "http://plus-ed.com/vision_ag/index.php/backoffice/transferCalendar/?"+passingData, function( data ) {
      $("#setTransferModal .modal_body").html('');
      $("#setTransferModal").modal("show");
      $("#setTransferModal .modal_body").html(data);
    });
  });

});
</script>
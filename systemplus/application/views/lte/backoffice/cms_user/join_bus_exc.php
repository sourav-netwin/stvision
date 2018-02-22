<?php $CC = $excursion; ?>
<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">

<section class="content">
  <div class="row">

    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
          <div class="row">
            <div class="col-sm-6 btn-create">
              <a href="javascript:void(0);" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>&nbsp;Add new bus</a>
            </div>
            <?php showSessionMessageIfAny($this);?>
          </div>
        </div>
        <div class="box-body">
          <div class="mr-bot-10">
            <?php echo $CC['exc_excursion'] ?> from <?php echo $CC['exc_centro'] ?> | <?php echo $CC['exc_type'] ?> | <?php echo $CC['exc_length'] ?>
          </div>
          <table id="dataTableCampusRooms" class="datatable table table-bordered table-striped">
            <thead>
              <tr>
                <th>Coach company</th>
                <th>Bus</th>
                <th>Seats</th>
                <th>Price</th>
                <th class="no-sort">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if( $allBus )
                {
                  foreach( $allBus as $bus )
                  {
              ?>
                    <tr>
                      <td><?php echo $bus["tra_cp_name"]?></td>
                      <td><?php echo $bus["tra_bus_name"]?></td>
                      <td class="text-right"><?php echo $bus["tra_bus_seat"]?> seats</td>
                      <td class="text-right">
                        <div class="currency_container">
                          <input class="form-control" type="text" value="<?php echo str_replace(".",",",$bus["jn_price"])?>" name="prez_<?php echo $bus["jn_id"]?>" id="prez_<?php echo $bus["jn_id"]?>" style="width:100px;"> <span class="bus_currency"><?php echo $bus["jn_currency"]?></span>
                        </div>
                      </td>
                      <td class="text-center">
                        <div class="btn-group custom-btn-group containremover">

                          <a href="javascript:void(0);" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-info min-wd-24 busEDIT" data-original-title="Edit bus <?php echo $bus['tra_bus_name']?>" id="bus_<?php echo $bus["jn_id"]?>">
                          <i class="fa fa-edit"></i>
                          </a>

                          <a href="javascript:void(0);" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-danger min-wd-24 busREMOVE" data-original-title="Remove bus <?php echo $bus["tra_bus_name"]?>" id="bus_<?php echo $bus["jn_id"]?>">
                            <i class="fa fa-trash"></i>
                          </a>

                        </div>
                      </td>
                    </tr>
              <?php
                  }
                }
              ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Coach company</th>
                <th>Bus</th>
                <th>Seats</th>
                <th>Price</th>
                <th>Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          &nbsp;
        </div>
        <!-- /.box-footer-->
      </div>
    </div>
  </div>

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add bus for excursion <?php echo $CC['exc_excursion'] ?> FROM <?php echo $CC['exc_centro'] ?></h4>
      </div>
      <div class="modal-body">
        <form name="addBusE" id="addBusE" action="<?php echo base_url(); ?>index.php/backoffice/cmsAddBusToExc/<?php echo $CC['exc_id'] ?>/<?php echo $CC['exc_id_centro'] ?>" method="POST">
          <div class="form-group">
            <label for="add_buse">Bus</label>
            <select class="form-control" name="add_buse" id="add_buse">
              <?php
                foreach( $totalBus as $bs )
                {
              ?>
                  <option value="<?php echo $bs["tra_bus_id"]?>"><?php echo $bs["tra_cp_name"]?> - <?php echo $bs["tra_bus_seat"]?> seats</option>
              <?php
                }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="Price">Price</label>
            <input type="text" class="form-control" name="prezzoAdd" id="prezzoAdd" placeholder="Price">
          </div>
          <div class="form-group">
            <label for="add_buse">Currency</label>
            <select class="form-control" name="add_curr" id="add_curr">
              <?php
                foreach( $curs as $cur )
                {
              ?>
                  <option value="<?php echo $cur["cur_id"]?>"><?php echo $cur["cur_codice"]?> - <?php echo $cur["cur_nome_esteso"]?></option>
              <?php
                }
              ?>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addMe">Add bus</button>
      </div>
    </div>
  </div>
</div>

</section>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
  pageHighlightMenu = "backoffice/cmsManageExcursions/planned";

  $(document).ready(function(){
    $( ".containremover a.busREMOVE" ).click(function(e){
      e.preventDefault();
      if(confirm("Are you sure you want to remove this bus from <?php echo $CC['exc_excursion'] ?>?")){
        var myid = $(this).attr("id").split("_");
        window.location.href="<?php echo base_url(); ?>index.php/backoffice/cmsDelBusExc/"+myid[1]+"/<?php echo $CC['exc_id'] ?>";
      }
    });

    $( ".containremover a.busEDIT" ).click(function(e){
      e.preventDefault();
      var myid = $(this).attr("id").split("_");
      var prezid = "prez_"+myid[1];
      var prezzo = $("#"+prezid).val();
      var re =  /^[+\-]?\d+,\d{2}$/
      if(re.test(prezzo)){
        prezzoOK = prezzo.split(",");
        window.location.href="<?php echo base_url(); ?>index.php/backoffice/cmsUpdateBusExcPrice/"+myid[1]+"/<?php echo $CC['exc_id'] ?>/"+prezzoOK[0]+"/"+prezzoOK[1];
      }else{
        alert("Price format is not corrected! It MUST have two decimals, comma separated!");
        return false;
      }
    });

    $("#addMe").click(function(){
      var re =  /^[+\-]?\d+,\d{2}$/
      if(re.test($("#prezzoAdd").val())){
        $("#addBusE").submit();
      }else{
        alert("Price format is not corrected! It MUST have two decimals, comma separated!");
        return false;
      }
    });
  });
</script>
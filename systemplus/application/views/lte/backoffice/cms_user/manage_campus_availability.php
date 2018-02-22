<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">

<?php $camp=$campus[0]; ?>

<section class="content">
  <div class="row">

    <div class="col-xs-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Insert new campus availability for <?php echo $camp["nome_centri"] ?></h3>
        </div>
        <div class="box-body">
          <form name="formSaveAva" id="formSaveAva" action="<?php echo base_url(); ?>index.php/backoffice/cmsAddCampusAvailability/<?php echo $camp["id"] ?>" method="POST">
            <table id="dataTableCampusRooms" class="datatable table table-bordered table-striped">
              <thead>
                <tr>
                  <th class="no-sort">Campus name</th>
                  <th class="no-sort">Accomodation type</th>
                  <th class="no-sort">Availability #</th>
                  <th class="no-sort">Start date</th>
                  <th class="no-sort">End date</th>
                  <th class="no-sort">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><?php echo $camp["nome_centri"]?></td>
                  <td class="center">
                    <select name="tipoAcc" id="tipoAcc" class="form-control">
                      <option value="">Select a type</option>
                      <?php foreach($campusSis as $tSis){ ?>
                      <option value="<?php echo strtolower($tSis["sistemazione"]) ?>"><?php echo $tSis["sistemazione"] ?></option>
                      <?php } ?>
                    </select>
                  </td>
                  <td class="center">
                    <input type="text" id="numAcco" name="numAcco" class="form-control"/>
                  </td>
                  <td class="center">
                    <input type="text" readonly id="dateStart" name="dateStart" class="form-control"/>
                  </td>
                  <td class="center">
                    <input type="text" readonly id="dateFinish" name="dateFinish" class="form-control"/>
                  </td>
                  <td class="center">
                    <input type="button" id="saveAva" name="saveAva" value="Insert new availability" class="btn btn-danger"/>
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th>Campus name</th>
                  <th>Accomodation type</th>
                  <th>Availability #</th>
                  <th>Start date</th>
                  <th>End date</th>
                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
          </form>
        </div>
        <div class="box-body">
          <table id="dataTableCampusRooms" class="datatable table table-bordered table-striped">
            <thead>
              <tr>
                <th>Campus name</th>
                <th>Accomodation type</th>
                <th>Availability #</th>
                <th>Start date</th>
                <th>End date</th>
                <th class="no-sort">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if( $dates )
                {
                  foreach( $dates as $date )
                  {
              ?>
                    <tr>
                      <td><?php echo $camp["nome_centri"]?></td>
                      <td><?php echo $date["accomodation_type"]?></td>
                      <td><?php echo $date["availability"]?></td>
                      <td><?php echo date("d/m/Y",strtotime($date["start_date"]))?></td>
                      <td><?php echo date("d/m/Y",strtotime($date["finish_date"]))?></td>
                      <td class="text-center">
                        <div class="btn-group custom-btn-group containremover">

                          <a href="javascript:void(0);" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-danger min-wd-20" data-original-title="Remove this availability for <?php echo $camp["nome_centri"]?>" id="dataa_<?php echo $date["id"]?>">
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
                <th>Campus name</th>
                <th>Accomodation type</th>
                <th>Availability #</th>
                <th>Start date</th>
                <th>End date</th>
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
</section>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
  pageHighlightMenu = "backoffice/cmsManageCampus";
  $(document).ready(function() {

    $( ".containremover a" ).click(function(e){
      e.preventDefault();
      if(confirm("Are you sure you want to remove this availability for <?php echo $camp["nome_centri"]?>?")){
        var myid = $(this).attr("id").split("_");
        window.location.href="<?php echo base_url(); ?>index.php/backoffice/cmsDelCampusAvailability/"+myid[1]+"/<?php echo $camp["id"]?>";
      }
    });

    $( "#dateStart" ).datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: "dd/mm/yy",
      maxDate: "+1Y",
      onClose: function( selectedDate ) {
        $( "#dateFinish" ).datepicker( "option", "minDate", selectedDate );
      }
    });

    $( "#dateFinish" ).datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: "dd/mm/yy",
      onClose: function( selectedDate ) {
        $( "#dateStart" ).datepicker( "option", "maxDate", selectedDate );
      }
    });

    $("#saveAva").click(function(){
      if( $("#numAcco").val()=="" || $("#dateStart").val()=="" || $("#dateFinish").val()=="" || $("#tipoAcc").val()=="" )
      {
        alert("Please fill-in all the required fileds!");
        return void(0);
      }
      else
      {
        var rx = new RegExp(/\d+/);
        if(rx.test($("#numAcco").val()))
        {
          $("#formSaveAva").submit();
        }
        else
        {
          alert("Please insert only digits in Availability field!");
          return void(0);
        }
      }
    });
  });
  $(window).on('load', function() {
    $('.dataTables_filter').first().remove();
  });
</script>
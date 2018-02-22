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
          <div id="priority-box" class="row">
            <form style="margin:10px;" id="box_transport" name="box_transport" action="<?php echo base_url(); ?>index.php/backoffice/ca_viewBookedTransfers" method="post">

              <div class="row">
                <div class="col-sm-3">
                  <label for="selCampus">Select type:</label>
                  <select class="form-control" id="tipo" name="tipo" autocomplete="off" name="selCampus">
                    <option <?php if($tipo=="inbound"){?>selected <?php }?>value="inbound">Inbound</option>
                    <option <?php if($tipo=="outbound"){?>selected <?php }?>value="outbound">Outbound</option>
                  </select>
                </div>

                <div class="col-sm-3">
                  <label for="txtCalFromDate">From date:</label> 
                  <input autocomplete="off" class="form-control" type="text" id="from" name="from" value="<?php echo $from;?>" readonly/>
                </div>

                <div class="col-sm-3">
                  <label for="txtCalToDate">To date:</label> 
                  <input autocomplete="off"  class="form-control" type="text" id="to" name="to" value="<?php echo $to;?>" readonly/>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6 mr-top-10">
                  <input class="btn btn-primary" type="button" value="Search" name="transpmi" id="transpmi" />
                </div>
              </div>

            </form>
          </div>
        </div>
        <div class="box-body">
          <table style="width: 100%;" id="dataTableStaffPriority" class="datatable table table-bordered table-striped">
            <thead>
              <tr>
                <th>Reference code</th>
                <th>Transfer date</th>
                <th>Campus</th>
                <th>Airport</th>
                <th>Flight details</th>
                <th>Pax number</th>
                <th class="no-sort">View detail</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if ( !empty( $all_transfers ) ) 
                {
                  foreach ( $all_transfers as $exc ) 
                  {
              ?>
                    <tr>
                      <td><?php echo $exc["ptt_buscompany_code"]?></td>
                      <td><?php echo date("d/m/Y",strtotime($exc["ptt_excursion_date"]))?></td>
                      <td><?php echo $exc["nome_centri"]?></td>
                      <?php if($tipo=="inbound") { ?>
                        <td>
                          <?php
                            if( !empty( $flgDetails ) )
                            {
                              $aptDet = array();
                              $cnt = 0;
                              if( isset( $flgDetails[$exc["ptt_buscompany_code"]] ) )
                              {
                                foreach( $flgDetails[$exc["ptt_buscompany_code"]] as $flight )
                                {
                                  if( !in_array($flight["ptt_airport_to"], $aptDet) )
                                  {
                                    if($cnt == 0)
                                    {
                                      echo $flight["ptt_airport_to"];
                                    }
                                    else
                                    {
                                      echo ', '.$flight["ptt_airport_to"];
                                    }
                                    $aptDet[] = $flight["ptt_airport_to"];
                                    $cnt += 1;
                                  }
                                }
                              }
                            }
                          ?>
                        </td>
                      <?php } else { ?>
                        <td>
                          <?php
                            if( !empty($flgDetails) )
                            {
                              $aptDet = array();
                              $cnt = 0;
                              if( isset( $flgDetails[$exc["ptt_buscompany_code"]] ) )
                              {
                                foreach( $flgDetails[$exc["ptt_buscompany_code"]] as $flight )
                                {
                                  if( !in_array($flight["ptt_airport_from"], $aptDet) )
                                  {
                                    if( $cnt == 0 )
                                    {
                                      echo $flight["ptt_airport_from"];
                                    }
                                    else
                                    {
                                      echo ', '.$flight["ptt_airport_from"];
                                    }
                                    $aptDet[] = $flight["ptt_airport_from"];
                                    $cnt += 1;
                                  }
                                }
                              }
                            }
                          ?>
                        </td>
                      <?php }  ?>
                      <td>
                        <?php
                          if( !empty($flgDetails) )
                          {
                            if(isset($flgDetails[$exc["ptt_buscompany_code"]]))
                            {
                              foreach($flgDetails[$exc["ptt_buscompany_code"]] as $flight)
                              {
                                echo '<span class="refstandby">'.$flight['ptt_book_id'].'</span>&nbsp;&nbsp'.$flight["ptt_flight"].'@</span><span class="refstandby">'.date("H:i",strtotime($flight["ptt_dataora"])).'</span> | '.$flight["ptt_airport_from"].'&#x2708;'.$flight["ptt_airport_to"].'<br />';
                              }
                            }
                          }
                        ?>
                      </td>
                      <td><?php echo $exc["effettivi"]?></td>
                      <td>
                        <a id="code_<?php echo $exc["ptt_buscompany_code"]?>" href="javascript:void(0);" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-info min-wd-24 dialogbtn" data-original-title="View detail">
                          <i class="fa fa-search"></i>
                        </a>
                      </td>
                    </tr>
                <?php
                  }
                }
            ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Reference code</th>
                <th>Transfer date</th>
                <th>Campus</th>
                <th>Airport</th>
                <th>Flight details</th>
                <th>Pax number</th>
                <th>View detail</th>
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
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/additional-methods.min.js"></script>
<script>
  $(document).ready(function(){

    $("#box_transport").validate({
      errorElement:"div",
      ignore: "",
      rules: {
        from: {
          required: true
        },
        to: {
          required: true
        }
      },
      messages: {
        from: {
          required: "Please select from date"
        },
        to: {
          required: "Please select to date"
        }
      },
      submitHandler: function(form) {
        form.submit();
      }
    });

    $('#transpmi').click(function(){
      $('#loading-data').show();
      $('#box_transport').submit();
    });

    $( "#from" ).datepicker({
      defaultDate: "+1d",
      changeMonth: true,
      numberOfMonths: 1,
      dateFormat: "dd/mm/yy",   
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });

    $( "#to" ).datepicker({
      defaultDate: "+1d",
      changeMonth: true,
      numberOfMonths: 1,
      dateFormat: "dd/mm/yy",
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });

    $(".dialogbtn").click(function(){
      window.location.replace("<?php echo base_url(); ?>index.php/backoffice/busTraDetail/"+$(this).attr("id"));
    });
  });
</script>
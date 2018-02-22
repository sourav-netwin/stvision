<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<style type="text/css">
  #printDiv{
    display: none;
  }
  .bookPrint{
    display: none;
  }
</style>
<section class="content">
  <div class="row">

    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
          <div class="row">
            <div class="col-sm-12 btn-create">
              <a href="javascript:void(0)" class="btn btn-primary btn-sm" id="xlsBtn"><i class="fa fa-download"></i>&nbsp;Download excel</a>
              <a href="javascript:void(0)" class="btn btn-primary btn-sm" id="printBtn"><i class="fa fa-print"></i>&nbsp;Print credentials</a>              
            </div>
            <?php showSessionMessageIfAny($this);?>
          </div>
        </div>
        <div class="box-body">
          <table id="dataTableCampusRooms" class="campus_table datatable table table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Booking id</th>
                <th class="no-sort">Agent nationality</th>
                <th>Arrival date</th>
                <th>Departure date</th>
                <th>No. GL(s)</th>
                <th>No. STD(s)</th>
                <th class="no-sort">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $cnt = 1;
              	if( $gldetails )
              	{
              		foreach( $gldetails as $gld )
              		{
              ?>
          			    <tr>
  								    <td><?php echo $cnt ?></td>
  								    <td><?php echo $gld['book_id'] ?></td>
  								    <td><?php echo $gld['businesscountry'] ? '<img src="' . base_url() . 'img/flags/16/' . $gld['businesscountry'] . '.png" toolTip title="' . $gld['businesscountry'] . '"/>' : '' ?></td>
  								    <td><?php echo $gld['data_arrivo_campus'] ? date('d/m/Y', strtotime($gld['data_arrivo_campus'])) : '' ?></td>
                      <td><?php echo $gld['data_partenza_campus'] ? date('d/m/Y', strtotime($gld['data_partenza_campus'])) : '' ?></td>
                      <td><?php echo $gld['Glcount'] ?></td>
                      <td><?php echo $gld['Stdcount'] ?></td>
  								    <td class="text-center">
                        <div class="btn-group custom-btn-group">

                          <?php if ($gld['Glcount'] > 0) { ?>
                              <a href="javascript:void(0)" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-primary min-wd-24 xlsRow" data-original-title="Excel" data-id="<?php echo $gld['book_id'] ?>">
                                <i class="fa fa-download"></i>
                              </a>

                              <a href="javascript:void(0)" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-info min-wd-24 printRow" data-original-title="Print" data-id="<?php echo $gld['book_id'] ?>">
                                <i class="fa fa-print"></i>
                              </a>
                          <?php } ?>

                        </div>
                      </td>
							      </tr>
              <?php
                    $cnt += 1;
                  }
                }
              ?>
            </tbody>
            <tfoot>
              <tr>
                <th>#</th>
                <th>Booking id</th>
                <th>Agent nationality</th>
                <th>Arrival date</th>
                <th>Departure date</th>
                <th>No. GL(s)</th>
                <th>No. STD(s)</th>
                <th>Action</th>
              </tr>
            </tfoot>
          </table>

          <table id="printDiv" style="border: 1px solid; border-collapse: collapse;">
            <tr>
              <th colspan="6" style="text-align: center; border: 1px solid;">Survey URL: <a href="http://plus-ed.com/vision_ag/index.php/survey">http://plus-ed.com/vision_ag/index.php/survey</a></th>
            </tr>
            <tr>
              <th style="text-align: center; border: 1px solid;">#</th>
              <th style="text-align: center; border: 1px solid;">Name</th>
              <th style="text-align: center; border: 1px solid;">Surname</th>
              <th style="text-align: center; border: 1px solid;">Date of birth</th>
              <th style="text-align: center; border: 1px solid;">Pax Type</th>
              <th style="text-align: center; border: 1px solid;">Booking ID</th>
            </tr>
            <?php
              $cnt = 1;
              if($gldetails)
              {
                foreach ($gldetails as $gld) 
                {
                  if ($gld) 
                  {
                    $gluuidArr = explode(',', $gld['gluuid']);
                    if (!empty($gluuidArr)) 
                    {
                      foreach ($gluuidArr as $uuid) 
                      {
                        $uuidArr = explode(':', $uuid);
                        $aVal = isset($uuidArr[2]) ? $uuidArr[2] : '';
                        $bVal = isset($uuidArr[3]) ? $uuidArr[3] : '';
                        $cVal = $gld['book_id'];
                        $dVal = isset($uuidArr[0]) ? $uuidArr[0] : '';
                        $eVal = '';
                        if (isset($uuidArr[1])) 
                        {
                          $eVal = $uuidArr[1] ? date('d/m/Y', strtotime($uuidArr[1])) : '';
                        }
              ?>
                        <tr>
                          <td style="border: 1px solid;"><?php echo $cnt; ?></td>
                          <td style="border: 1px solid;"><?php echo $aVal ?></td>
                          <td style="border: 1px solid;"><?php echo $bVal ?></td>
                          <td style="border: 1px solid;"><?php echo $eVal ?></td>
                          <td style="border: 1px solid;"><?php echo $dVal ?></td>
                          <td style="border: 1px solid;"><?php echo $cVal ?></td>
                        </tr>
              <?php
                        $cnt += 1;
                      }
                    }
                  }
                }
              }
            ?>
          </table>

          <?php
            if($gldetails)
            {
              foreach ($gldetails as $gld) 
              {
                if ($gld) 
                {
                  $gluuidArr = explode(',', $gld['gluuid']);
                  if (!empty($gluuidArr)) 
                  {
          ?>
                    <table class="bookPrint" id="printDiv-<?php echo $gld['book_id'] ?>" style="border: 1px solid; border-collapse: collapse;">
                      <tr>
                        <th colspan="6" style="text-align: center; border: 1px solid;">Survey URL: <a href="http://plus-ed.com/vision_ag/index.php/survey">http://plus-ed.com/vision_ag/index.php/survey</a></th>
                      </tr>
                      <tr>
                        <th style="text-align: center; border: 1px solid;">#</th>
                        <th style="text-align: center; border: 1px solid;">Name</th>
                        <th style="text-align: center; border: 1px solid;">Surname</th>
                        <th style="text-align: center; border: 1px solid;">Date of birth</th>
                        <th style="text-align: center; border: 1px solid;">Pax Type</th>
                        <th style="text-align: center; border: 1px solid;">Booking ID</th>
          <?php
                        $cnt = 1;
                        foreach ($gluuidArr as $uuid) 
                        {
                          $uuidArr = explode(':', $uuid);
                          $aVal = isset($uuidArr[2]) ? $uuidArr[2] : '';
                          $bVal = isset($uuidArr[3]) ? $uuidArr[3] : '';
                          $cVal = $gld['book_id'];
                          $dVal = isset($uuidArr[0]) ? $uuidArr[0] : '';
                          $eVal = '';
                          if (isset($uuidArr[1])) 
                          {
                            $eVal = $uuidArr[1] ? date('d/m/Y', strtotime($uuidArr[1])) : '';
                          }
          ?>
                      </tr>
                          <tr>
                            <td style="border: 1px solid;"><?php echo $cnt; ?></td>
                            <td style="border: 1px solid;"><?php echo $aVal ?></td>
                            <td style="border: 1px solid;"><?php echo $bVal ?></td>
                            <td style="border: 1px solid;"><?php echo $eVal ?></td>
                            <td style="border: 1px solid;"><?php echo $dVal ?></td>
                            <td style="border: 1px solid;"><?php echo $cVal ?></td>
                          </tr>

          <?php
                          $cnt += 1;
                        }
          ?>
                    </table>
                <?php
                  }
                }
              }
            }
          ?>
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
<script src="<?php echo base_url() ?>js/jquery.browser.min.js"></script>  
<script src="<?php echo base_url() ?>js/jquery.printElement.min.js"></script>
<script>
  $(document).ready(function() {
    $('body').on('click', '#printBtn', function(){
      $("#printDiv").printElement();
    });
    $('body').on('click', '.printRow', function(){
      var book = $(this).attr('data-id');
      $("#printDiv-"+book).printElement();
    });
  });
  $(document).on('click', '.paginate_button,.first paginate_button,.last paginate_button', function(){
    setTimeout(function(){
      $('[toolTip]').tipsy({gravity:'s'});
    },200);
  });
  
  $('body').on('click', '#xlsBtn', function(){
    window.open(siteUrl + 'backoffice/exportGldetails');
  });
  $('body').on('click', '.xlsRow', function(){
    var book = $(this).attr('data-id');
    window.open(siteUrl + 'backoffice/exportGldetailsRow/'+book);
  });
</script> 
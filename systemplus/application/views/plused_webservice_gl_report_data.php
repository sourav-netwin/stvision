<?php $this->load->view('plused_header');?>
<!-- The container of the sidebar and content box -->
<div role="main" id="main" class="container_12 clearfix">

  <!-- The blue toolbar stripe -->
  <section class="toolbar">
    <div class="user">
      <div class="avatar">
        <img src="<?php echo base_url(); ?>img/layout/content/toolbar/user/avatar.png">
      </div>
      <span><?php echo $this->session->userdata('businessname') ?></span>
      <ul>
        <?php
          $bOArray = array(200,300,400,100,550); // BACKOFFICE USERS ROLE IDS
          if($this->session->userdata('username') && in_array($this->session->userdata('role'), $bOArray)){
        ?>
            <li><a href="<?php echo base_url(); ?>index.php/backoffice/profile">Profile</a></li>
            <li class="line"></li>
            <li><a href="<?php echo base_url(); ?>index.php/backoffice/logout">Logout</a></li>
        <?php
        } elseif ($this->session->userdata('role')!=97) { ?>
            <li><a href="<?php echo base_url(); ?>index.php/agents/changeCredential">Profile</a></li>
            <li class="line"></li>
            <li><a href="<?php echo base_url(); ?>index.php/agents/logout">Logout</a></li>
        <?php } else { ?>
              <li><a href="<?php echo base_url(); ?>index.php/agents/logout">Logout</a></li>
        <?php } ?>

      </ul>
    </div>
  </section><!-- End of .toolbar-->

  <?php $this->load->view('plused_sidebar');?>

  <!-- Here goes the content. -->
  <section id="content" class="container_12 clearfix" data-sort=true>
    <h1 class="grid_12 margin-top no-margin-top-phone">Export By GL</h1>
    <div class="row" style="margin-right:10px;">
      <div class="grid_12" id="report-view">
        <input id="backToFilter" class="export-button" type="button" value="Back" />
        <?php if ( !empty( $report_table_data ) ) { ?>
          <input id="exportExcel" class="export-button" type="button" value="Export" />
        <?php } ?>

        <?php
          // Code to get max additional columns
          $fixed_column_count = 8;
          $additional_column_count = 0;
          $arr_cnt = array();
          foreach ( $reportData as $rData )
          {
            $arr_cnt[] = count($rData['additional_columns']);
          }
          $additional_column_count = max( $arr_cnt );
          $total_column_count = $fixed_column_count + $additional_column_count;
        ?>

        <table class="dynamic styled webservice-report-table" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aoColumns":[<?php for( $i = 0; $i < $total_column_count; $i++ ){ echo '{"bSearchable": true,"bSortable": true}'; } ?>]}'>
          <thead>
            <tr>
              <th>Collaboratore</th>
              <th>Accompagnatore</th>
              <th>Codice Prodotto</th>
              <th>Total Rows (including gl)</th>
              <th>Total Rows (excluding gl)</th>
              <th>Total Rows (excluding gl and glf)</th>
              <th>Total Rows Cleared</th>
              <th>GL</th>

              <?php
                // Display additional Column headers
                for( $i = 1; $i <= $additional_column_count; $i++ )
                {
              ?>
                  <th>Group <?php echo $i; ?></th>
              <?php
                }
              ?>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach ( $reportData as $rData )
              {
            ?>
              <tr>
                <td class="center"><?php echo $rData["collaboratore"]; ?></td>
                <td class="center"><?php echo $rData['accompagnatore']; ?></td>
                <td class="center"><?php echo $rData["codice_prodotto"]; ?></td>
                <td class="center"><?php echo $rData["rows_including_gl"]; ?></td>
                <td class="center"><?php echo $rData["rows_excluding_gl"]; ?></td>
                <td class="center"><?php echo $rData["rows_excluding_gl_si"]; ?></td>
                <td class="center"><?php echo $rData["rows_cleared"]; ?></td>
                <td class="center"><?php echo $rData["gl_rows"]; ?></td>
                <?php
                  // Additional column values
                  if( !empty( $rData['additional_columns'] ) )
                  {
                    $i = 0;
                    foreach ( $rData['additional_columns'] as $additional_column )
                    {
                      echo "<td class='center'>$additional_column</td>";
                      $i++;
                    }
                    if( $i < $additional_column_count )
                    {
                      for( $j = $i; $j < $additional_column_count; $j++ )
                      {
                        echo "<td class='center'>-</td>";
                      }
                    }
                  }
                  else if( $additional_column_count > 0 )
                  {
                    for( $i = 1; $i <= $additional_column_count; $i++ )
                    {
                      echo "<td class='center'>-</td>";
                    }
                  }
                ?>
              </tr>
            <?php
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <?php if( !empty( $report_analysis_data ) ) { ?>
      <div class="row">
        <div class="grid_12 mr-top-10">
          <div class="box">
            <div class="header">
                <h2>Report Analysis</h2>
              </div>
              <div class="content" style="margin: 10px;">

              <?php foreach ( $report_analysis_data as $analysis_data )
                    {
                      if( array_key_exists('trinity_total', $analysis_data) )
                      {
              ?>
                        <div class="form-data grid_12">
                          Number of students who made the Trinity examination: <strong><?php echo $analysis_data['trinity_total']; ?></strong>
                        </div>
              <?php
                      }
                      else if( array_key_exists('magic_bonus_total', $analysis_data) )
                      {
              ?>
                        <div class="form-data grid_12">
                          Number of students eligible for magic bonus: <strong><?php echo $analysis_data['magic_bonus_total']; ?></strong>
                        </div>
              <?php
                      }
                      else
                      {
              ?>
                        <div class="form-data grid_12">
                          Group: <strong><?php echo $analysis_data['group']; ?></strong>
                        </div>
                        <div class="form-data grid_12">
                          Eligible for the reimbursement: <strong><?php echo $analysis_data['reimbursement_eligibility']; ?></strong>
                        </div>
                        <div class="form-data grid_12">
                          Eligible for the double session bonus: <strong><?php echo $analysis_data['double_turn_eligibility']; ?></strong>
                        </div>
                        <div class="form-data grid_12">
                          <hr>
                        </div>
              <?php
                      }
                    }
              ?>
              </div>
          </div>
        </div>
      </div>
    <?php } ?>

    <div class="row" style="margin-right:10px;">
      <div class="grid_12" id="report-view">
        <h1 class="grid_12 margin-top no-margin-top-phone">Report</h1>
        <?php if( !empty( $report_table_data ) ) { ?>
          <input id="printPdf" class="pdf-button" type="button" value="Print PDF">
        <?php } ?>
        <?php
          if( !empty( $report_table_data ) )
          {
        ?>
            <table class="styled reimbursement-report">
              <thead>
                <tr>
                  <th>Product Code</th>
                  <th>Accomodation</th>
                  <th>Type</th>
                  <th>Group</th>
                  <th>Country</th>
                  <th>Level</th>
                  <th>Pax</th>
                  <th>Amount Per Pax</th>
                  <th>Total Reimbursement</th>
                </tr>
              </thead>
              <tbody>
              <?php
                foreach( $report_table_data as $rdata )
                {
              ?>
                  <tr>
                    <td class="center <?php echo ( $rdata['codice_prodotto'] == 'Total' ) ? 'text-bold' : '' ?>"><?php echo $rdata['codice_prodotto']; ?></td>
                    <td class="center"><?php echo $rdata['accomodation']; ?></td>
                    <td class="center"><?php echo $rdata['type']; ?></td>
                    <td class="center"><?php echo $rdata['group']; ?></td>
                    <td class="center"><?php echo $rdata['country']; ?></td>
                    <td class="center"><?php echo $rdata['level']; ?></td>
                    <td class="center"><?php echo $rdata['pax']; ?></td>
                    <td class="center"><?php echo $rdata['amount_per_pax']; ?></td>
                    <td class="right <?php echo ( $rdata['codice_prodotto'] == 'Total' ) ? 'text-bold' : '' ?>"><?php echo $rdata['total_reimbursement']; ?></td>
                  </tr>
              <?php
                }
              ?>
              </tbody>
            </table>
        <?php
          }
          else
          {
            echo "Not eligible";
          }
        ?>
      </div>
    </div>

  </section>

</div>

<script>
    var SITE_PATH = "<?php echo base_url();?>index.php/";
    $(document).ready(function() {
        $( "li#mnuwebservice" ).addClass("current");
        $( "li#mnuwebservice a" ).addClass("open");
        $( "li#mnuwebservice ul.sub" ).css('display','block');
        $( "li#mnuwebservice ul.sub li#mnuwebservice_3" ).addClass("current");

        $("#backToFilter").click(function(){
          window.location.href= SITE_PATH + "webservice/glReport";
        });

        $("#exportExcel").click(function(){
          var exportForm = $('<form method="post" action="'+SITE_PATH + "webservice/glReport"+'"></form>').appendTo('body');
          exportForm.append("<input type='hidden' name='txtAccompagnatore' value='<?php echo $accompagnatore;?>' />");
          exportForm.append("<input type='hidden' name='txtCollaboratore' value='<?php echo $collaboratore;?>' />");
          exportForm.append("<input type='hidden' name='type' value='export' />");
          exportForm.submit();
        });

        $("#printPdf").click(function(){
          var exportForm = $('<form method="post" action="'+SITE_PATH + "webservice/glReport"+'"></form>').appendTo('body');
          exportForm.append("<input type='hidden' name='txtAccompagnatore' value='<?php echo $accompagnatore;?>' />");
          exportForm.append("<input type='hidden' name='txtCollaboratore' value='<?php echo $collaboratore;?>' />");
          exportForm.append("<input type='hidden' name='type' value='pdf' />");
          exportForm.submit();
        });

        // Code so that table structure does not fluctuate when sorting the columns
        // $.each($(".webservice-report-table th"), function( index, value ) {
        //   $(this).attr('style', 'width: '+$(this).width()+'px !important');
        // });
    });
</script>
<?php $this->load->view('plused_footer'); ?>

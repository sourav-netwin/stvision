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
    <h1 class="grid_12 margin-top no-margin-top-phone">Webservice Data Report</h1>
    <div class="row" style="margin-right:10px;">
      <div class="grid_12" id="report-view">
        <input id="backToFilter" class="export-button" type="button" value="Back" />
        <?php if ( !empty( $report_data ) ) { ?>
          <input id="exportExcel" class="export-button" type="button" value="Export" />
        <?php } ?>
        <table class="dynamic styled webservice-report-table" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true}]}'>
          <thead>
            <tr>
              <th>Accompagnatore</th>
              <th>Collaboratore</th>
              <th>Prodotto</th>
              <th>Codice Prodotto</th>
              <th>Passeggero</th>
              <th>Tipologia Passeggero</th>
              <th>Total Due</th>
              <th>Balance</th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach ( $report_data as $data ) {
                $total_due = $data["costo_base"] + $data["importo_tasse_volo"] + $data["importo_aeroporto_aggiuntivo"] + $data["supplementi"];
                $balance = round(( $total_due - $data["pagamenti"] ),2);
            ?>
              <tr <?php echo ( $balance <= 2 ) ? 'class="green-row"' : ""; ?>>
                <td class="center"><?php echo $data['accompagnatore'];?></td>
                <td class="center"><?php echo $data["collaboratore"];?></td>
                <td class="center"><?php echo $data["prodotto"];?></td>
                <td class="center"><?php echo $data["codice_prodotto"];?></td>
                <td class="center"><?php echo $data["passeggero"];?></td>
                <td class="center"><?php echo $data["tipologia_passeggero"];?></td>
                <td class="center"><?php echo $total_due;?></td>
                <td class="center"><?php echo $balance;?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
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
        $( "li#mnuwebservice ul.sub li#mnuwebservice_2" ).addClass("current");

        $("#backToFilter").click(function(){
          window.location.href= SITE_PATH + "webservice/report";
        });

        $("#exportExcel").click(function(){
          var exportForm = $('<form method="post" action="'+SITE_PATH + "webservice/report"+'"></form>').appendTo('body');
          exportForm.append("<input type='hidden' name='txtAccompagnatore' value='<?php echo $accompagnatore;?>' />");
          exportForm.append("<input type='hidden' name='txtCollaboratore' value='<?php echo $collaboratore;?>' />");
          exportForm.append("<input type='hidden' name='txtProdotto' value='<?php echo $prodotto;?>' />");
          exportForm.append("<input type='hidden' name='txtCodiceProdotto' value='<?php echo $codice_prodotto;?>' />");
          exportForm.append("<input type='hidden' name='txtPasseggero' value='<?php echo $passeggero;?>' />");
          exportForm.append("<input type='hidden' name='selTipologiaPasseggero' value='<?php echo $tipologia_passeggero;?>' />");
          exportForm.append("<input type='hidden' name='selGlf' value='<?php echo $glf;?>' />");
          exportForm.append("<input type='hidden' name='type' value='export' />");
          exportForm.submit();
        });

        // Code so that table structure does not fluctuate when sorting the columns
        $.each($("table th"), function( index, value ) {
          $(this).attr('style', 'width: '+$(this).width()+'px !important');
        });
    });
</script>
<?php $this->load->view('plused_footer'); ?>

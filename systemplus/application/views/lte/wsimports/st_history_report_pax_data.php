<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header col-sm-12">
        <div class="row">
          <?php showSessionMessageIfAny($this);?>
        </div>
      </div>
      <div class="box-body">
        <form id="frmExport" action="<?php echo base_url(); ?>index.php/sthistory/reportpax" method="post">
          <div class="row" style="margin-right:0px;">
            <div class="col-sm-12 mr-bot-10">
              <div class="pull-right mr-bot-10">
                <input id="backToFilter" class="export-button btn btn-primary" type="button" value="Back" />
                <input id="exportExcel" class="export-button btn btn-primary" type="submit" value="Export" />
                <input type="hidden" id="selTipologiaProdotto" name="selTipologiaProdotto" value="<?php echo $tipologiaProdotto ?>" />
                <input type="hidden" id="timesPaxTravelled" name="timesPaxTravelled" value="<?php echo $timesPaxTravelled ?>" />
                <input type="hidden" id="selRegione" name="selRegione" value="<?php echo $regione ?>" />
                <input type="hidden" id="selMacroRegione" name="selMacroRegione" value="<?php echo $macroRegione ?>" />
                <input type="hidden" id="selNazione" name="selNazione" value="<?php echo $nazione ?>" />
                <input type="hidden" id="selStartAge" name="selStartAge" value="<?php echo $startAge ?>" />
                <input type="hidden" id="selEndAge" name="selEndAge" value="<?php echo $endAge ?>" />
                <input type="hidden" id="selDestinazioneNazione" name="selDestinazioneNazione" value="<?php echo ( !empty( $destinazione_nazione ) ) ? implode(",", $destinazione_nazione ) : "" ?>" />
                <input type="hidden" id="clientiDiretti" name="clientiDiretti" value="<?php echo $clientiDiretti ?>">
                <input type="hidden" id="selAnno" name="selAnno" value="<?php echo $annoYear ?>">
                <input type="hidden" id="isExport" name="isExport"  value="1" />
              </div>
            </div>
          </div>
        </form>
        <div class="col-sm-12">
          <table id="report_pax" class="table table-bordered table-striped">
            <thead>
              <tr>                
                <th>Passeggero</th>
                <th>Anno</th>
                <th>Data partenza</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>Data nascita</th>
                <th>Indirizzo</th>
                <th>Provincia</th>
                <th>Comune</th>
                <th>Cap</th>
                <th>Regione</th>
                <th>Macro regione</th>
                <th>Nazione</th>
                <th>Destinazione nazione</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        &nbsp;
      </div>
      <!-- /.box-footer-->
    </div>
  </div>
</div>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
  var SITE_PATH = "<?php echo base_url(); ?>index.php/";
  $(document).ready(function() {
    $("#backToFilter").click(function(){
      window.location.href= SITE_PATH + "sthistory/reportpax";
    });

    $("#report_pax").DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
      "order": [],
      "columnDefs": [
      {
        "targets"  : 'no-sort',
        "orderable": false
      },
      {
        "targets"  : 'col-text-numeric',
        "sSortDataType": 'dom-text-numeric'
      },
      {
        "targets"  : 'col-html-formated-numeric',
        "sSortDataType": 'dom-html-formated-numeric'
      }
      ],
      "ajax": {
        "url" : SITE_PATH + "sthistory/report_pax_listing",
        "data": {'tipologiaProdotto' : '<?php echo $tipologiaProdotto ?>', 'timesPaxTravelled' : '<?php echo $timesPaxTravelled ?>', 'regione' : '<?php echo $regione ?>', 'macroRegione' : '<?php echo $macroRegione ?>', 'nazione' : '<?php echo $nazione ?>', 'startAge' : '<?php echo $startAge ?>', 'endAge' : '<?php echo $endAge ?>', 'destinazioneNazione' : '<?php echo ( !empty( $destinazione_nazione ) ) ? implode(",", $destinazione_nazione ) : "" ?>', 'clientiDiretti' : '<?php echo $clientiDiretti ?>', 'selAnno' : '<?php echo $annoYear; ?>' },
        'type': 'POST',
        complete: function( ) {
          if( $("#report_pax tbody tr td.dataTables_empty").length )
            $("#exportExcel").hide();
          else
            $("#exportExcel").show();

          $("#report_pax").parent().addClass("table-responsive");
        }
      },
      "iDisplayLength":10,
      "lengthMenu": [ 10, 25, 50, 100 ],
      "serverSide": true
    });
  });
</script>
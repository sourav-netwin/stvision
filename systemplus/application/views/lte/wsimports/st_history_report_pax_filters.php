<div class="box box-primary">
  <form action="<?php echo base_url(); ?>index.php/sthistory/reportpax" method="post">
    <div class="box-header with-border">
      <h3 class="box-title">Destinazione, prodotto, clienti</h3>
      <div class="box-tools pull-right">
        <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button" data-original-title="Collapse" data-container="body">
          <i class="fa fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-sm-4">
          <div>
            <div class="box-header with-border">
              <h3 class="box-title">Select options destinazione</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <label for="selDestinazioneNazione">Destinazione nazione</label>
                <div class="form-data">
                  <select class="form-control" id="selDestinazioneNazione" name="selDestinazioneNazione[]" multiple="multiple">
                  <?php
                    if ($destinazione_nazione) 
                    {
                      foreach ($destinazione_nazione as $dn) 
                      {
                  ?>
                        <option value="<?php echo $dn['destinazione_nazione']; ?>"><?php echo $dn['destinazione_nazione']; ?></option>
                  <?php
                      }
                    }
                  ?>
                  </select>
                </div>
              </div>          
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div>
            <div class="box-header with-border">
              <h3 class="box-title">Select options prodotto</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <label for="selTipologiaProdotto">Tipologia prodotto</label>
                <div class="form-data">
                  <select class="form-control" id="selTipologiaProdotto" name="selTipologiaProdotto">
                    <option value="">All</option>
                    <?php
                      if ($tipologia_prodotto) {
                        foreach ($tipologia_prodotto as $tp) {
                    ?>
                          <option value="<?php echo $tp['tipologia_prodotto']; ?>"><?php echo $tp['tipologia_prodotto']; ?></option>
                    <?php
                        }
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label>Number of times pax travelled</label>
                <div class="form-data">
                  <select class="form-control" id="timesPaxTravelled" name="timesPaxTravelled">
                    <option value="1">1 times</option>
                    <option value="2">2 times</option>
                    <option value="3">3 times</option>
                    <option value="4">4 times</option>
                    <option value="5">5 times</option>
                  </select>
                </div>
              </div>          
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div>
            <div class="box-header with-border">
              <h3 class="box-title">Select options clienti</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <label for="selRegione">Regione</label>
                <div class="form-data">
                  <select class="form-control" id="selRegione" name="selRegione">
                    <option value="">All</option>
                    <?php
                      if ($regione) 
                      {
                        foreach ($regione as $data) 
                        {
                    ?>
                          <option value="<?php echo $data['regione']; ?>"><?php echo $data['regione']; ?></option>
                    <?php
                        }
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="selMacroRegione">Macro regione</label>
                <div class="form-data">
                  <select class="form-control" id="selMacroRegione" name="selMacroRegione">
                    <option value="">All</option>
                    <?php
                      if ($macro_regione) 
                      {
                        foreach ($macro_regione as $data) 
                        {
                    ?>
                          <option value="<?php echo $data['macro_regione']; ?>"><?php echo $data['macro_regione']; ?></option>
                    <?php
                        }
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="selNazione">Nazione</label>
                <div class="form-data">
                  <select class="form-control" id="selNazione" name="selNazione">
                    <option value="">All</option>
                    <?php
                      if ($nazione) 
                      {
                        foreach ($nazione as $data) 
                        {
                    ?>
                          <option value="<?php echo $data['nazione']; ?>"><?php echo $data['nazione']; ?></option>
                    <?php
                        }
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="selStartAge">Age range</label>
                <div class="form-data">
                  <div class="row">
                    <div class="col-sm-6 mr-bot-10">
                      <select style="min-width: 60px;" class="form-control" id="selStartAge" name="selStartAge">
                        <option value="">Any</option>
                        <?php
                          for ($ageLimit = 5; $ageLimit <60; $ageLimit++ ) 
                          {
                        ?>
                            <option value="<?php echo $ageLimit; ?>"><?php echo $ageLimit; ?> years</option>
                        <?php
                          }
                        ?>
                      </select>
                    </div>
                    <div class="col-sm-6 mr-bot-10">
                      <select style="min-width: 60px;" class="form-control" id="selEndAge" name="selEndAge">
                        <option value="">Any</option>
                        <?php
                          for ($ageEndLimit = 6; $ageEndLimit <=60; $ageEndLimit++ ) 
                          {
                        ?>
                            <option value="<?php echo $ageEndLimit; ?>"><?php echo $ageEndLimit; ?> years</option>
                        <?php
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
             <div class="form-group">
                <label for="selAnno">Anno</label>
                <div class="form-data">
                  <select class="form-control" id="selAnno" name="selAnno">
                    <option value="">All</option>
                    <?php
                      if ($annoYear) 
                      {
                        foreach ($annoYear as $data) 
                        {
                    ?>
                          <option value="<?php echo $data['anno']; ?>"><?php echo $data['anno']; ?></option>
                    <?php
                        }
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <input type="checkbox" id="chkClientiDiretti" name="clientiDiretti" value="1">
                <label class="normal" for="chkClientiDiretti">Clienti diretti</label>
              </div>
            </div>
          </div>
        </div>       
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="box-footer">
            <input class="btn btn-primary pull-right" id="btnReportPro" type="submit" value="Report">
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<script src="<?php echo LTE; ?>plugins/select2/select2.full.min.js"></script>
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<link href="<?php echo LTE; ?>plugins/iCheck/all.css" rel="stylesheet">
<script type="text/javascript">
  $(document).ready(function() {
    $('#selDestinazioneNazione').select2({
      dropdownAutoWidth : true,
      width: '100%'
    });

    $("#selStartAge").change(function(){
      var minAge = $(this).val();
      var maxAge = $("#selEndAge").val();
      $('#selEndAge option').show();
      $('#selEndAge option').filter(function() {
          return $(this).val() < parseInt(minAge);
      }).hide();
      if(parseInt(minAge) > parseInt(maxAge))
          $('#selEndAge').val(minAge);
    });

    $("#selEndAge").change(function(){
      var maxAge = $(this).val();
      var minAge = $("#selStartAge").val();
      $('#selStartAge option').show();
      $('#selStartAge option').filter(function() {
          return $(this).val() > parseInt(maxAge);
      }).hide();
      if(parseInt(minAge) > parseInt(maxAge))
          $('#selStartAge').val(maxAge);
    });

    $('#chkClientiDiretti').iCheck('destroy'); 
    $('#chkClientiDiretti').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      increaseArea: '10%' // optional
    });

  });
</script>
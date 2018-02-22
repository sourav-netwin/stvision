<style>
    .icheckbox_square-blue, .iradio_square-blue{
        height: 26px!important;
    }
</style>
<div class="box box-primary">
<div class="box-header with-border">
    <h3 class="box-title"><?php echo ($reportType == "corporate" ? "Corporate" : "Professori");?>, clienti and prodotto</h3>
    <div class="box-tools pull-right">
        <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button" data-original-title="Collapse" data-container="body">
            <i class="fa fa-minus"></i></button>
        <!--            <button title="Remove" data-toggle="tooltip" data-widget="remove" class="btn btn-box-tool" type="button">
                        <i class="fa fa-times"></i></button>-->
    </div>
</div>
<!-- /.box-header -->
<!-- /.box-body -->
<div class="box-body">
<form id="frmSTHistoryReport" action="<?php echo base_url(); ?>index.php/sthistory/report/<?php echo $reportType;?>" method="post">
<div class="row">
    <div class="col-sm-4">
        <!-- DIRECT SEARCH PRIMARY -->
        <div class="">
        <div class="box-header with-border">
            <h3 class="box-title">Select options <?php echo ($reportType == "corporate" ? "corporate" : "professori");?></h3>
        </div>
        <!-- /.box-header -->
        <!-- /.box-body -->
        <div class="box-body">
            <div class="form-group">
                <label for="txtCollaboratore"><?php echo ($reportType == "corporate" ? "Azienda" : "Collaboratore");?></label>
                <div class="form-data">
                    <select class="form-control" id="txtCollaboratore" name="txtCollaboratore">
                        <option value="">All</option>
                            <?php 
                                if ($collaboratore) {
                                    foreach ($collaboratore as $data) {
                                        if($reportType == "corporate"){
                                            ?>
                                            <option value="<?php echo htmlspecialchars($data['azienda']); ?>"><?php echo htmlspecialchars($data['azienda']); ?></option>
                                            <?php
                                        }
                                        else{
                                            ?>
                                            <option value="<?php echo htmlspecialchars($data['collaboratore']); ?>"><?php echo htmlspecialchars($data['collaboratore']); ?></option>
                                            <?php
                                        }
                                    }
                                }
                            ?>
                    </select>
                </div>
            </div>
            <?php 
            if($reportType == "professori"){
            ?>
            <div class="form-group">
                    <label for="selCollaboratoreProvincia">
                            Provincia collaboratore
                    </label>
                    <div class="form-data">
                        <select class="form-control" id="selCollaboratoreProvincia" name="selCollaboratoreProvincia">
                                <option value="">All</option>
                                <?php
                                if ($collaboratoreProvincia) {
                                        foreach ($collaboratoreProvincia as $provincia) {
                                                ?>
                                                <option value="<?php echo $provincia['collaboratoreProvincia']; ?>"><?php echo $provincia['collaboratoreProvincia']; ?></option>
                                                <?php
                                        }
                                }
                                ?>
                        </select>
                    </div>
            </div>
            <div class="form-group">
                    <label for="selCollaboratoreRegione">
                            Regione collaboratore
                    </label>
                    <div class="form-data">
                            <select class="form-control" id="selCollaboratoreRegione" name="selCollaboratoreRegione">
                                    <option value="">All</option>
                                    <?php 
                                    if ($collaboratoreRegione) {
                                            foreach ($collaboratoreRegione as $data) {
                                                    ?>
                                                    <option value="<?php echo $data['collaboratoreRegione']; ?>"><?php echo $data['collaboratoreRegione']; ?></option>
                                                    <?php
                                            }
                                    }
                                    ?>
                            </select>
                    </div>
            </div>
            <div class="form-group">
                <label for="selCollaboratoreMacroRegione">
                        Macroregione collaboratore
                </label>
                <div class="form-data">
                    <select class="form-control" id="selCollaboratoreMacroRegione" name="selCollaboratoreMacroRegione">
                        <option value="">All</option>
                        <?php
                        if ($collaboratoreMacroRegione) {
                            foreach ($collaboratoreMacroRegione as $data) {
                                ?>
                                <option value="<?php echo $data['collaboratoreMacroRegione']; ?>"><?php echo $data['collaboratoreMacroRegione']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                    <label for="selCollaboratoreNazione">
                            <strong>Nazione collaboratore</strong>
                    </label>
                    <div class="form-data">
                        <select class="form-control" id="selCollaboratoreNazione" name="selCollaboratoreNazione">
                            <option value="">All</option>
                            <?php
                            if ($collaboratoreNazione) {
                                foreach ($collaboratoreNazione as $data) {
                                        ?>
                                        <option value="<?php echo $data['collaboratoreNazione']; ?>"><?php echo $data['collaboratoreNazione']; ?></option>
                                        <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
            </div>
            <?php }?>
        </div>
        <!-- /.box-footer-->
        </div>
        <!--/.direct-chat -->
    </div>
    <div class="col-sm-4">
        <div class="">
        <div class="box-header with-border">
            <h3 class="box-title">Select options clienti</h3>
        </div>
        <!-- /.box-header -->
        <!-- /.box-body -->
        <div class="box-body">
            <div class="form-group">
                <label for="selRegione">Regione</label>
                <div class="form-data">
                    <select class="form-control" id="selRegione" name="selRegione">
                            <option value="">All</option>
                            <?php
                            if ($regione) {
                                    foreach ($regione as $data) {
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
                    <label for="selMacroRegione">
                            <strong>Macro regione</strong>
                    </label>
                    <div class="form-data">
                        <select class="form-control" id="selMacroRegione" name="selMacroRegione">
                                <option value="">All</option>
                                <?php
                                if ($macro_regione) {
                                        foreach ($macro_regione as $data) {
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
                    <label for="selNazione">
                            <strong>Nazione</strong>
                    </label>
                    <div class="form-data">
                        <select class="form-control" id="selNazione" name="selNazione">
                                <option value="">All</option>
                                <?php
                                if ($nazione) {
                                        foreach ($nazione as $data) {
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
                    <label for="selStartAge">
                            <strong>Age range</strong>
                    </label>
                    <div class="form-data">
                        <div class="row">
                            <div class="col-sm-6 mr-bot-10">
                                <select style="min-width: 77px;" class="form-control" id="selStartAge" name="selStartAge">
                                        <option value="">Any</option>
                                        <?php
                                                for ($ageLimit = 5; $ageLimit <60; $ageLimit++ ) {
                                                        ?>
                                                        <option value="<?php echo $ageLimit; ?>"><?php echo $ageLimit; ?> years</option>
                                                        <?php
                                                }
                                        ?>
                                </select>
                            </div>
                            <div class="col-sm-6 mr-bot-10">
                                <select style="min-width: 77px;" class="form-control" id="selEndAge" name="selEndAge">
                                        <option value="">Any</option>
                                        <?php
                                                for ($ageEndLimit = 6; $ageEndLimit <=60; $ageEndLimit++ ) {
                                                        ?>
                                                        <option value="<?php echo $ageEndLimit; ?>"><?php echo $ageEndLimit; ?> years</option>
                                                        <?php
                                                }
                                        ?>
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <input type="checkbox" id="chkCheckAgeToday" name="chkCheckAgeToday" value="1">
                                <label class="normal" for="chkCheckAgeToday">Check age today</label>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <!-- /.box-footer-->
        </div>
        <!--/.second box -->
    </div>
    <div class="col-sm-4">
        <div class="">
        <div class="box-header with-border">
            <h3 class="box-title">Select options prodotto</h3>
        </div>
        <!-- /.box-header -->
        <!-- /.box-body -->
        <div class="box-body">
            <div class="form-group">
                <label for="txtCodiceProdotto">Codice prodotto</label>
                <div class="form-data">
                    <select class="form-control" id="txtCodiceProdotto" name="txtCodiceProdotto">
                        <option value="">All</option>
                        <?php
                            if ($codice_prodotto) {
                                foreach ($codice_prodotto as $data) {
                                    ?>
                                        <option value="<?php echo $data['codice_prodotto']; ?>"><?php echo $data['codice_prodotto']; ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="selTipologiaProdotto">Tipologia prodotto</label>
                <div class="form-data">
                    <select class="form-control" id="selTipologiaProdotto" name="selTipologiaProdotto[]" multiple="multiple">
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
                <label for="selDestinazione">Destinazione</label>
                <div class="form-data">
                    <select class="form-control" id="selDestinazione" name="selDestinazione">
                            <option value="">All</option>
                            <?php
                            if ($destinazione) {
                                    foreach ($destinazione as $data) {
                                            ?>
                                            <option value="<?php echo $data['destinazione']; ?>"><?php echo $data['destinazione']; ?></option>
                                            <?php
                                    }
                            }
                            ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="selDestinazioneNazione">Destinazione nazione</label>
                <div class="form-data">
                    <select class="form-control" id="selDestinazioneNazione" name="selDestinazioneNazione[]" multiple="multiple">
                            <?php
                            if ($destinazione_nazione) {
                                    foreach ($destinazione_nazione as $dn) {
                                            ?>
                                            <option value="<?php echo $dn['destinazione_nazione']; ?>"><?php echo $dn['destinazione_nazione']; ?></option>
                                            <?php
                                    }
                            }
                            ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="selAnno">Anno</label>
                <div class="form-data">
                    <select class="form-control" id="selAnno" name="selAnno">
                        <option value="">All</option>
                        <?php
                        if ($anno) {
                            foreach ($anno as $data) {
                                ?>
                                <option value="<?php echo $data['anno']; ?>"><?php echo $data['anno']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <!-- /.box-footer-->
        </div>
        <!--/.second box -->
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="box-footer">
            <input class="btn btn-primary pull-right" id="btnReport" type="submit" value="Report">
        </div>
    </div>
</div>
    
</form>
</div>
<div class="box-footer">
    
</div>
</div>
<div class="box box-primary">
<form id="frmSTHistoryReport_2" action="<?php echo base_url(); ?>index.php/sthistory/report/<?php echo $reportType;?>" method="post">
<div class="box-header with-border">
    <h3 class="box-title">Fatturato and prodotto</h3>
    <div class="box-tools pull-right">
        <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button" data-original-title="Collapse" data-container="body">
            <i class="fa fa-minus"></i></button>
        <!--            <button title="Remove" data-toggle="tooltip" data-widget="remove" class="btn btn-box-tool" type="button">
                        <i class="fa fa-times"></i></button>-->
    </div>
</div>
<!-- /.box-header -->
<!-- /.box-body -->
<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class="">
                <div class="box-header with-border">
                    <h3 class="box-title">Select options fatturato</h3>
                </div>
                <!-- /.box-header -->
                <!-- /.box-body -->
                <div class="box-body">
                    <div class="form-group">
                        <label for="selFatturatoMin">
                                <strong>Fatturato range</strong>
                                
                        </label>
                        <div class="form-data">
                            <div class="row">
                                <div class="col-sm-12">
                                    <small>Select min and max values for fatturato(fatturato * 1000).</small>
                                </div>
                                <div class="col-sm-6">
                                    <select class="form-control" id="selFatturatoMin" name="selFatturatoMin">
                                        <option value="0">0</option>
                                        <?php
                                            $minFatturatoArr = array(10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 200, 500);
                                            foreach($minFatturatoArr as $minFatturato)
                                            {
                                        ?>
                                                <option value="<?php echo $minFatturato."000"; ?>"><?php echo $minFatturato; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <select class="form-control" id="selFatturatoMax" name="selFatturatoMax">
                                            <?php
                                            $maxFatturatoArr = array(10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 200, 500,'> 500');
                                                foreach($maxFatturatoArr as $maxFatturato)
                                                {
                                                    ?>
                                                    <option value="<?php echo $maxFatturato."000"; ?>"><?php echo $maxFatturato; ?></option>
                                                    <?php
                                                }
                                            ?>
                                    </select>
                                </div>
                                <div class="col-sm-12 mr-top-10">
                                    <input type="checkbox" id="chkAccumulative" name="chkAccumulative" value="1" />
                                    <label for="chkAccumulative" class="normal">Accumulative</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                </div>
            </div>
        </div>
        <div class="col-sm-4">
        <div class="">
        <div class="box-header with-border">
            <h3 class="box-title">Select options prodotto</h3>
        </div>
        <!-- /.box-header -->
        <!-- /.box-body -->
        <div class="box-body">
            <div class="form-group">
                <label for="txtCodiceProdotto_2">Codice prodotto</label>
                <div class="form-data">
                    <select class="form-control" id="txtCodiceProdotto_2" name="txtCodiceProdotto">
                        <option value="">All</option>
                        <?php
                            if ($codice_prodotto) {
                                foreach ($codice_prodotto as $data) {
                                    ?>
                                        <option value="<?php echo $data['codice_prodotto']; ?>"><?php echo $data['codice_prodotto']; ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="selTipologiaProdotto_2">Tipologia prodotto</label>
                <div class="form-data">
                    <select class="form-control" id="selTipologiaProdotto_2" name="selTipologiaProdotto[]" multiple="multiple">
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
                <label for="selDestinazione_2">Destinazione</label>
                <div class="form-data">
                    <select class="form-control" id="selDestinazione_2" name="selDestinazione">
                            <option value="">All</option>
                            <?php
                            if ($destinazione) {
                                    foreach ($destinazione as $data) {
                                            ?>
                                            <option value="<?php echo $data['destinazione']; ?>"><?php echo $data['destinazione']; ?></option>
                                            <?php
                                    }
                            }
                            ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="selDestinazioneNazione_2">Destinazione nazione</label>
                <div class="form-data">
                    <select class="form-control" id="selDestinazioneNazione_2" name="selDestinazioneNazione[]" multiple="multiple">
                            <?php
                            if ($destinazione_nazione) {
                                    foreach ($destinazione_nazione as $dn) {
                                            ?>
                                            <option value="<?php echo $dn['destinazione_nazione']; ?>"><?php echo $dn['destinazione_nazione']; ?></option>
                                            <?php
                                    }
                            }
                            ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="selAnno_2">Anno</label>
                <div class="form-data">
                    <select class="form-control" id="selAnno_2" name="selAnno">
                        <option value="">All</option>
                        <?php
                        if ($anno) {
                            foreach ($anno as $data) {
                                ?>
                                <option value="<?php echo $data['anno']; ?>"><?php echo $data['anno']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <!-- /.box-footer-->
        </div>
        <!--/.second box -->
    </div>
    </div>
</div>
<div class="box-footer">
    <input class="btn btn-primary pull-right" onclick="return validation();" id="btnReport" type="submit" value="Report">
</div>
</form>
</div>
<script src="<?php echo LTE; ?>plugins/select2/select2.full.min.js"></script>
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<link href="<?php echo LTE; ?>plugins/iCheck/all.css" rel="stylesheet">
<script>
     function iCheckInit(){
        $('#chkAccumulative').iCheck('destroy'); 
        $('#chkAccumulative').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            increaseArea: '10%' // optional
        });
        $('#chkCheckAgeToday').iCheck('destroy'); 
        $('#chkCheckAgeToday').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            increaseArea: '10%' // optional
        });
    }
    $(document).ready(function() {
        iCheckInit();
//        $( "body" ).on( "change", "#selCampus", function() {
//        
//        });
        $('#selDestinazioneNazione').select2({
            dropdownAutoWidth : true,
            width: '100%'
        });
        $('#selTipologiaProdotto').select2({
            dropdownAutoWidth : true,
            width: '100%'
        });
        
        $('#selDestinazioneNazione_2').select2({
            dropdownAutoWidth : true,
            width: '100%'
        });
        $('#selTipologiaProdotto_2').select2({
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
            
            console.log('min changed');
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
            
            console.log('max changed');
        });
        
        $("#selFatturatoMin").change(function(){
            var minAge = $(this).val();
            var maxAge = $("#selFatturatoMax").val();
            $('#selFatturatoMax option').show();
            $('#selFatturatoMax option').filter(function() {
                return $(this).val() < parseInt(minAge);
            }).hide();
            if(parseInt(minAge) > parseInt(maxAge))
                $('#selFatturatoMax').val(minAge);
            
            console.log('min changed');
        });
        $("#selFatturatoMax").change(function(){
            var maxAge = $(this).val();
            var minAge = $("#selFatturatoMin").val();
            $('#selFatturatoMin option').show();
            $('#selFatturatoMin option').filter(function() {
                return $(this).val() > parseInt(maxAge);
            }).hide();
            if(parseInt(minAge) > parseInt(maxAge))
                $('#selFatturatoMin').val(maxAge);
            
            console.log('max changed');
        });
        
    });
    function validation(){
        var minFatturato = $("#selFatturatoMin").val();
        var maxFatturato = $("#selFatturatoMax").val();
        if(minFatturato == "" || maxFatturato == "")
        {
            swal("Error","Please select fatturato min and max value");
            return false;
        }
        return true;
    }
</script>
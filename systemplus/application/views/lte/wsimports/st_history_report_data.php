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
            <div class="col-sm-12 mr-bot-10">
                <div class="pull-right mr-bot-10">
                    <input id="backToFilter" class="export-button btn btn-primary" type="button" value="Back" />
                    <?php if (!empty($report_data)) { ?>
                            <input id="exportExcelWithoutGroup" class="export-button btn btn-primary" type="button" value="Export all" />
                            <input id="exportExcel" class="export-button btn btn-primary" type="button" value="Export" />
                            <?php
                    }
                    ?>
                </div>
            </div>
            <?php 
                if (!empty($summary_data)) {
                        echo '<div class="col-sm-12 summary-main"><table class="summary-table table table-bordered table-striped">';
                        $tbCnt = 0;
                        $totalFatturato = 0;
                        foreach ($summary_data as $tipoProdo => $countries) {
                                echo '<tr><th colspan="3" style="text-align: left"><strong>Tipologia Prodotto:</strong> ' . $tipoProdo . '</th></tr><tr><th>Country</th><th>Campus</th><th>Fatturato</th></tr>';
                                foreach ($countries as $country => $values) {
                                        $ct = 0;
                                        echo '<tr><td style="vertical-align:middle" rowspan="' . sizeof($values) . '">' . $country . '</td>';
                                        foreach ($values as $key => $val) {
                                                echo $ct > 0 ? '<tr>' : '';
                                                echo '<td>' . $val['codice_destinazione'] . '</td>';
                                                echo '<td>' . $val['fatturato'] . '</td>';
                                                $totalFatturato += $val['fatturato'] * 1;
                                                echo $ct > 0 ? '</tr>' : '';
                                                $ct++;
                                        }
                                        echo '</tr>';
                                }
                        }
                        echo '<tr><th colspan="2" style="text-align: right">Total</th><th>' . $totalFatturato . '</th></tr></table></div>';
                }
            ?>
            <div class="col-sm-12">
                <table class="datatable table table-bordered table-striped" style="width:99.98%;">
                    <thead>
                        <tr>
                                <th>Anno</th>
                            <?php if($reportType == 'professori'){?>
                                <th>Collaboratore</th>
                                <th>Provincia collaboratore</th>
                                <th>Nazione collaboratore</th>
                                <th>Regione collaboratore</th>
                                <th>Macroregione collaboratore</th>
                            <?php }else{?>
                                <th>Azienda</th>
                            <?php }?>
                                <th>Tipologia prodotto</th>
                                <?php if(!$accumulative){?>
                                <th>Codice prodotto</th>
                                <th>Destinazione</th>
                                <th>Destinazione nazione</th>
                                <?php }?>
                                <th>Pax</th>
                                <th >Fatturato</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($report_data as $data) { 
                                    ?>
                                    <tr>
                                            <td class="text-center"><?php echo $data["anno"]; ?></td>
                                        <?php if($reportType == 'professori'){?>
                                            <td class="text-center"><?php echo $data['collaboratore']; ?></td>
                                            <td class="text-center"><?php echo $data["collaboratoreProvincia"]; ?></td>
                                            <td class="text-center"><?php echo $data["collaboratoreNazione"]; ?></td>
                                            <td class="text-center"><?php echo $data["collaboratoreRegione"]; ?></td>
                                            <td class="text-center"><?php echo $data["collaboratoreMacroRegione"]; ?></td>
                                        <?php }else{?>
                                            <td class="text-center"><?php echo $data['azienda']; ?></td>
                                        <?php }?>
                                            <td class="text-center"><?php echo $data["tipologia_prodotto"]; ?></td>
                                            <?php if(!$accumulative){?>
                                                <td class="text-center"><?php echo $data["codice_prodotto"]; ?></td>
                                                <td class="text-center"><?php echo $data["destinazione"]; ?></td>
                                                <td class="text-center"><?php echo $data["destinazione_nazione"]; ?></td>
                                            <?php }?>
                                            <td class="text-center"><?php echo $data["pax"]; ?></td>
                                            <td class="text-center" data-sort="<?php echo $data["fatturato"];?>"><?php echo number_format($data["fatturato"],2,',','.'); ?></td>
                                    </tr>
                        <?php } ?>
                    </tbody>
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
</section>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    var SITE_PATH = "<?php echo base_url(); ?>index.php/";
    $(document).ready(function() {
        
//        $.extend( $.fn.dataTableExt.oSort, {
//            "formatted-num-pre": function ( a ) {
//                    a = (a === "-" || a === "") ? 0 : a.replace( /[^\d\-\.]/g, "" );
//                    return parseFloat( a );
//            },
//            "formatted-num-asc": function ( a, b ) {
//                    return a - b;
//            },
//            "formatted-num-desc": function ( a, b ) {
//                    return b - a;
//            }
//        });
        
        
        $("#backToFilter").click(function(){
                window.location.href= SITE_PATH + "sthistory/report/<?php echo $reportType;?>";
        });

        $("#exportExcel").click(function(){
                var exportForm = $('<form method="post" action="'+SITE_PATH + "sthistory/report/<?php echo $reportType;?>"+'"></form>').appendTo('body');
                exportForm.append("<input type='hidden' name='txtCollaboratore' value='<?php echo $collaboratore; ?>' />");
                exportForm.append("<input type='hidden' name='txtCodiceProdotto' value='<?php echo $codice_prodotto; ?>' />");
                exportForm.append("<input type='hidden' name='selTipologiaProdotto' value='<?php echo (!empty($tipologia_prodotto) ) ? implode(",", $tipologia_prodotto) : ""; ?>' />");
                exportForm.append("<input type='hidden' name='selDestinazioneNazione' value='<?php echo (!empty($destinazione_nazione) ) ? implode(",", $destinazione_nazione) : ""; ?>' />");
                exportForm.append("<input type='hidden' name='type' value='export' />");

                exportForm.append("<input type='hidden' name='selRegione' value='<?php echo $regione; ?>' />");
                exportForm.append("<input type='hidden' name='selMacroRegione' value='<?php echo $macro_regione; ?>' />");
                exportForm.append("<input type='hidden' name='selNazione' value='<?php echo $nazione; ?>' />");

                exportForm.append("<input type='hidden' name='selCollaboratoreProvincia' value='<?php echo $collaboratoreProvincia; ?>' />");
                exportForm.append("<input type='hidden' name='selCollaboratoreNazione' value='<?php echo $collaboratoreNazione; ?>' />");
                exportForm.append("<input type='hidden' name='selCollaboratoreRegione' value='<?php echo $collaboratoreRegione; ?>' />");
                exportForm.append("<input type='hidden' name='selCollaboratoreMacroRegione' value='<?php echo $collaboratoreMacroRegione; ?>' />");

                exportForm.append("<input type='hidden' name='selDestinazione' value='<?php echo $destinazione; ?>' />");
                exportForm.append("<input type='hidden' name='selAnno' value='<?php echo $anno; ?>' />");

                exportForm.append("<input type='hidden' name='selStartAge' value='<?php echo $ageStart; ?>' />");
                exportForm.append("<input type='hidden' name='selEndAge' value='<?php echo $ageEnd; ?>' />");
                exportForm.append("<input type='hidden' name='selFatturatoMin' value='<?php echo $fatturatoMin; ?>' />");
                exportForm.append("<input type='hidden' name='selFatturatoMax' value='<?php echo $fatturatoMax; ?>' />");
                exportForm.append("<input type='hidden' name='chkAccumulative' value='<?php echo $accumulative; ?>' />");
                exportForm.append("<input type='hidden' name='chkCheckAgeToday' value='<?php echo $checkagetoday; ?>' />");
                exportForm.submit();
        });
        
        $("#exportExcelWithoutGroup").click(function(){
			var exportForm = $('<form method="post" action="'+SITE_PATH + "sthistory/report/<?php echo $reportType;?>"+'"></form>').appendTo('body');
			exportForm.append("<input type='hidden' name='txtCollaboratore' value='<?php echo $collaboratore; ?>' />");
			exportForm.append("<input type='hidden' name='txtCodiceProdotto' value='<?php echo $codice_prodotto; ?>' />");
			exportForm.append("<input type='hidden' name='selTipologiaProdotto' value='<?php echo (!empty($tipologia_prodotto) ) ? implode(",", $tipologia_prodotto) : ""; ?>' />");
			exportForm.append("<input type='hidden' name='selDestinazioneNazione' value='<?php echo (!empty($destinazione_nazione) ) ? implode(",", $destinazione_nazione) : ""; ?>' />");
			exportForm.append("<input type='hidden' name='type' value='exportAll' />");
			
                        exportForm.append("<input type='hidden' name='selRegione' value='<?php echo $regione; ?>' />");
                        exportForm.append("<input type='hidden' name='selMacroRegione' value='<?php echo $macro_regione; ?>' />");
                        exportForm.append("<input type='hidden' name='selNazione' value='<?php echo $nazione; ?>' />");
                        
                        exportForm.append("<input type='hidden' name='selCollaboratoreProvincia' value='<?php echo $collaboratoreProvincia; ?>' />");
			exportForm.append("<input type='hidden' name='selCollaboratoreNazione' value='<?php echo $collaboratoreNazione; ?>' />");
			exportForm.append("<input type='hidden' name='selCollaboratoreRegione' value='<?php echo $collaboratoreRegione; ?>' />");
			exportForm.append("<input type='hidden' name='selCollaboratoreMacroRegione' value='<?php echo $collaboratoreMacroRegione; ?>' />");
			
                        exportForm.append("<input type='hidden' name='selDestinazione' value='<?php echo $destinazione; ?>' />");
			exportForm.append("<input type='hidden' name='selAnno' value='<?php echo $anno; ?>' />");
			
                        exportForm.append("<input type='hidden' name='selStartAge' value='<?php echo $ageStart; ?>' />");
			exportForm.append("<input type='hidden' name='selEndAge' value='<?php echo $ageEnd; ?>' />");
                        
                        exportForm.append("<input type='hidden' name='selFatturatoMin' value='<?php echo $fatturatoMin; ?>' />");
			exportForm.append("<input type='hidden' name='selFatturatoMax' value='<?php echo $fatturatoMax; ?>' />");
			exportForm.append("<input type='hidden' name='chkAccumulative' value='<?php echo $accumulative; ?>' />");
                        exportForm.append("<input type='hidden' name='chkCheckAgeToday' value='<?php echo $checkagetoday; ?>' />");
			exportForm.submit();
        });
    });
</script>
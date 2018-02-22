<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<link rel="stylesheet" href="<?php echo LTE;?>kendochart/kendo.common-material.min.css" />
<link rel="stylesheet" href="<?php echo LTE;?>kendochart/kendo.material.min.css" />
<link rel="stylesheet" href="<?php echo LTE;?>kendochart/kendo.material.mobile.min.css" />
<!--<script src="//kendo.cdn.telerik.com/2016.3.1118/js/jquery.min.js"></script>-->
<script src="<?php echo LTE;?>kendochart/kendo.all.min.js"></script>
      <div class="box">
        <div class="box-header col-sm-12">
            <div class="row">
                <?php showSessionMessageIfAny($this);
                $CI = & get_instance();
                ?>
            </div>
        </div>
        <div class="box-body">
        <div class="row">
            <div class="col-sm-12 mr-bot-10">
                <div class="pull-right mr-bot-10">
                    <input id="backToFilter" class="export-button btn btn-primary" type="button" value="Back" />
                </div>
            </div>
            <div class="col-sm-12">
                <?php 
                $prodottoCount = 0;
                foreach($selTiplogiaProdotto as $tipologiaProdotto){
                $strJs = "";
                $prodottoCount++;
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <strong>Tipologia prodotto: <?php echo $tipologiaProdotto;?></strong><br/>
                        <strong>Legends:</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="pull-left">
                        <strong>Collaboratore macro regione: </strong><?php 
                        foreach($selCollaboratoreMacroRegione as $colMacroRegion)
                        {
                            echo "<span class='label mr-left-10' style='background-color:#3C8DBC;' >".$colMacroRegion."</span>";
                        }
                        ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="pull-right">
                        <strong>Destinazione nazione: </strong><?php 
                        $randColorArr = array();
                        foreach($selDestinazioneNazione as $destiNazione){
                            $randColor = random_color();
                            if(!in_array($randColor, $randColorArr))
                            {
                                $randColorArr[$destiNazione] = $randColor;
                                echo "<span class='label mr-left-10' style='background-color:".$randColor."'>".$destiNazione."</span>";
                            }
                            else{
                                $randColor = random_color();
                                $randColorArr[$destiNazione] = $randColor;
                                echo "<span class='label mr-left-10' style='background-color:".$randColor."'>".$destiNazione."</span>";
                            }
                        }
                        ?>
                        </div>
                    </div>
                </div>
                <?php 
                $chartData = array();
                $chartRow = array();
                //$chartRow[0] = "Collaboratore macro regione";
                
                foreach($selCollaboratoreMacroRegione as $colMacroRegion)
                {
                    foreach($selDestinazioneNazione as $destiNazione){
                        $resultData = $CI->getColTipologiaPaxCountForChart($tipologiaProdotto,$colMacroRegion,$txtAnnoYears,$destiNazione,$selCollaboratoreMacroRegione,$selDestinazioneNazione);
                        $sumAll = array_sum($resultData);
                        if($sumAll)
                        $strJs .= '{
                            name: "'.$destiNazione.'",
                            stack: {
                                    group: "'.$colMacroRegion.'"
                                },
                                data: ['.  implode(",", $resultData).'],
                                color: "'.$randColorArr[$destiNazione].'"
                        },';
                    }
                }
                $strJs = trim($strJs,',');
                
                ?>
                <div class="row">
                    <div class="demo-section col-sm-12">
                        <div id="chart-<?php echo $prodottoCount;?>"><span class="font:16px Arial,Helvetica,sans-serif;">No records to generate report chart!</span></div>
                    </div>  
                    <div class="col-sm-12 text-center">
                        <span style="font:16px Arial,Helvetica,sans-serif;">
Collaboratore macro regione / Years</span>
                    </div>
                </div>
                <hr/>
            </div>
            </div>
            
                <script> 
                    <?php if($strJs){?>
                    function createChart() {
                       
                        $("#chart-<?php echo $prodottoCount;?>").kendoChart({
                            title: {
                                text: "Compare professori pax chart"
                            },
                            legend: {
                                visible:false
                            },
                            seriesDefaults: {
                                type: "column",
                                stack: {
                                    type: "100"
                                }
                            },
                            series: [<?php echo $strJs;?>],
                            //seriesColors: ['<?php //echo implode($randColorArr,"','");?>'],
//                            valueAxis: {
//                                line: {
//                                    visible: true
//                                }
//                            },
                            valueAxis: [{
                                name: "travelling pax",
                                title: {
                                    text: "Number pax travelled"
                                }
                            }],
                            categoryAxis: {
                                categories: [<?php echo implode($txtAnnoYears,',')?>],
                                majorGridLines: {
                                    visible: true
                                }
                            },
                            tooltip: {
                                visible: true,
                                template: "#= series.stack.group #, #= series.name #, #= value #"
                            }
                        });
                    }
                    
                    $(document).ready(createChart);
                    $(document).bind("kendo:skinChange", createChart);
                    <?php }?>
                </script>
                <?php 
                }
                ?>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            &nbsp;
        </div>
        <!-- /.box-footer-->
      </div>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    var SITE_PATH = "<?php echo base_url(); ?>index.php/";
    $(document).ready(function() {
        $("#backToFilter").click(function(){
                window.location.href= SITE_PATH + "sthistory/compareprofessorisecond/chart";
        });
    });
</script>

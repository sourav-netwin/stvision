<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border col-sm-12">
                <h3 class="box-title">&nbsp;</h3>
                <div class="box-tools pull-right">
                    <input id="backToFilter" class="btn btn-primary export-button" type="button" value="Back" />
                    <?php if ( !empty( $report_table_data ) ) { ?>
                        <input id="exportExcel" class="btn btn-primary export-button" type="button" value="Export" />
                    <?php } ?>
                </div>
            </div>
            <div class="box-body">
                <div class="row mr-bot-10">
                    <?php showSessionMessageIfAny($this);?>
                </div>
                <div class="row">
                    <div class="col-sm-12">
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

                        <table class="datatable table table-bordered table-striped webservice-report-table" style="width: 99.98%;">
                        <thead>
                            <tr>
                            <th>Collaboratore</th>
                            <th>Accompagnatore</th>
                            <th>Codice prodotto</th>
                            <th>Total rows (including gl)</th>
                            <th>Total rows (excluding gl)</th>
                            <th>Total rows (excluding gl and glf)</th>
                            <th>Total rows cleared</th>
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
            </div>
             <?php 
             if( !empty( $report_analysis_data ) ) { ?>
            <div class="box-header with-border col-sm-12 mr-bot-10">
                <h3 class="box-title">Report analysis</h3>
            </div>
            <div class="box-body">
                 <?php foreach ( $report_analysis_data as $analysis_data )
                    {
                      if( array_key_exists('trinity_total', $analysis_data) )
                      {
                ?>
                        <div class="form-data ">
                          Number of students who made the Trinity examination: <strong><?php echo $analysis_data['trinity_total']; ?></strong>
                        </div>
                <?php
                      }
                      else if( array_key_exists('magic_bonus_total', $analysis_data) )
                      {
                ?>
                        <div class="form-data ">
                          Number of students eligible for magic bonus: <strong><?php echo $analysis_data['magic_bonus_total']; ?></strong>
                        </div>
                <?php
                      }
                      else
                      {
                ?>
                        <div class="form-data ">
                          Group: <strong><?php echo $analysis_data['group']; ?></strong>
                        </div>
                        <div class="form-data ">
                          Eligible for the reimbursement: <strong><?php echo $analysis_data['reimbursement_eligibility']; ?></strong>
                        </div>
                        <div class="form-data ">
                          Eligible for the double session bonus: <strong><?php echo $analysis_data['double_turn_eligibility']; ?></strong>
                        </div>
                        <div class="form-data ">
                          <hr>
                        </div>
                <?php
                      }
                    }
                ?>
            </div>
            <?php }?>
            <div class="box-header with-border col-sm-12 mr-bot-10">
                <h3 class="box-title">Report</h3>
                <div class="box-tools pull-right">
                    <?php if( !empty( $report_table_data ) ) { ?>
                        <input id="printPdf" class="pdf-button btn btn-primary" type="button" value="Print PDF">
                    <?php } ?>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                <div class="col-sm-12">
                <?php
                if( !empty( $report_table_data ) )
                {
                ?>
                    <table class="table table-bordered table-striped reimbursement-report" style="width: 99.98%;">
                    <thead>
                        <tr>
                        <th class="no-sort">Product code</th>
                        <th class="no-sort">Accomodation</th>
                        <th class="no-sort">Type</th>
                        <th class="no-sort">Group</th>
                        <th class="no-sort">Country</th>
                        <th class="no-sort">Level</th>
                        <th class="no-sort">Pax</th>
                        <th class="no-sort">Amount per pax</th>
                        <th class="no-sort">Total reimbursement</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach( $report_table_data as $rdata )
                        {
                    ?>
                        <tr>
                            <td class="center <?php echo ( $rdata['codice_prodotto'] == 'Total' || $rdata['codice_prodotto'] == 'Fee Accompagnamento' ) ? 'text-bold' : '' ?>"><?php echo $rdata['codice_prodotto']; ?></td>
                            <td class="center"><?php echo $rdata['accomodation']; ?></td>
                            <td class="center"><?php echo $rdata['type']; ?></td>
                            <td class="center"><?php echo $rdata['group']; ?></td>
                            <td class="center"><?php echo $rdata['country']; ?></td>
                            <td class="center"><?php echo $rdata['level']; ?></td>
                            <td class="center"><?php echo $rdata['pax']; ?></td>
                            <td class="center"><?php echo $rdata['amount_per_pax']; ?></td>
                            <td class="right <?php echo ( $rdata['codice_prodotto'] == 'Total' || $rdata['codice_prodotto'] == 'Fee Accompagnamento' ) ? 'text-bold' : '' ?>">
							<?php 
								if($rdata['codice_prodotto'] == 'Total')
								{
									echo $rdata['total_reimbursement'] - FEE_ACCOMPAGNAMENTO; 
								}else{
									echo $rdata['total_reimbursement']; 
								}
								
							?>
							</td>
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
                </div></div>
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
            window.location.href= SITE_PATH + "webservice/glReport";
        });

        $("#exportExcel").click(function(){
            var exportForm = $('<form method="post" action="'+SITE_PATH + "webservice/glReport"+'"></form>').appendTo('body');
            exportForm.append("<input type='hidden' name='txtAccompagnatore' value='<?php echo htmlspecialchars($accompagnatore);?>' />");
            exportForm.append("<input type='hidden' name='txtCollaboratore' value='<?php echo htmlspecialchars($collaboratore);?>' />");
            exportForm.append("<input type='hidden' name='type' value='export' />");
            exportForm.submit();
        });

        $("#printPdf").click(function(){
            var exportForm = $('<form method="post" action="'+SITE_PATH + "webservice/glReport"+'"></form>').appendTo('body');
            exportForm.append("<input type='hidden' name='txtAccompagnatore' value='<?php echo htmlspecialchars($accompagnatore);?>' />");
            exportForm.append("<input type='hidden' name='txtCollaboratore' value='<?php echo htmlspecialchars($collaboratore);?>' />");
            exportForm.append("<input type='hidden' name='type' value='pdf' />");
            exportForm.submit();
        });
    });
</script>
<script>
    var arraycontabkgs = new Array();
</script>
<div class="box">
    <div class="box-header with-border text-center">
        <ul class="nav nav-pills" role="tablist">
            <li role="presentation" class="active"><a href="#d" data-toggle="pill"><span class="glyphicon glyphicon-calendar"></span> Multi Campus Availability from <?php echo date("d/m/Y", strtotime($datein)) ?> to <?php echo date("d/m/Y", strtotime($dateout)) ?></a></li>
        </ul>
    </div>
    <!-- /.box-header -->
    <div class="box-body test-head">
        <?php
        foreach ($statusArray as $statovecchio) {
            $statiNew[] = "n_" . $statovecchio;
        }
        //print_r($statiNew);
        for ($a = 0; $a < count($campusArray); $a++) {

            $dateArr = array();
            foreach ($dates[$a] as $dataArr) {
                $dateArr[] = strtotime($dataArr["start_date"]);
            }
            ?>
            <div class="row">
                <div class="col-sm-12 mr-bot-10">
                    <input type="button" value="<?php echo $campusName[$a]; ?>" class="btn btn-primary btnToggle" id="btnToggle_0">
                </div>
            </div>
            <div class="row">
                <div style="overflow-x: auto;" id="tabAvail_<?php echo $a ?>" class="collapse in col-sm-12">
                    <table class="table table-bordered table-condensed table-striped tabAvail" style="font-size:9px;">
                        <thead>
                            <tr>
                                <th  >&nbsp;</th>
                                <?php
                                $datecycle = $datein;
                                while (strtotime($datecycle) <= strtotime($dateout)) {
                                    ?>
                                    <th  <?php if (in_array(strtotime($datecycle), $dateArr)) { ?>class="text-info info"<?php } ?>><span <?php if (strtotime($datecycle) == strtotime($datechoose)) { ?>class="text-danger"<?php } ?>><?php echo date("d/m", strtotime($datecycle)) ?></span></th>
                                    <?php
                                    $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="rigaAvail">
                                <td>Allotment</td>
                                <?php
                                $datecycle = $datein;
                                $contagiorni = 0;
                                while (strtotime($datecycle) <= strtotime($dateout)) {
                                    ?>
                                    <td><input type="text" class="form-control" readonly value="<?php echo $simcalendar[$a][$contagiorni]["totale"] ?>"></td>
                                    <?php
                                    $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                    $contagiorni++;
                                }
                                ?>	
                            </tr>
                            <tr>
                                <td>Booked</td>
                                <?php
                                $datecycle = $datein;
                                $contagiorni = 0;
                                while (strtotime($datecycle) <= strtotime($dateout)) {
                                    /*
                                      $totGiorno=0;
                                      if(in_array("n_confirmed",$statiNew))
                                      $totGiorno=$totGiorno+$simcalendar[$a][$contagiorni]["n_confirmed"];
                                      if(in_array("n_active",$statiNew))
                                      $totGiorno=$totGiorno+$simcalendar[$a][$contagiorni]["n_active"];
                                      if(in_array("n_elapsed",$statiNew))
                                      $totGiorno=$totGiorno+$simcalendar[$a][$contagiorni]["n_elapsed"];
                                      if(in_array("n_tbc",$statiNew))
                                      $totGiorno=$totGiorno+$simcalendar[$a][$contagiorni]["n_tbc"];
                                     */
                                    ?>
                                    <td><input type="text" class="form-control"  readonly value="<?php echo $simcalendar[$a][$contagiorni]["booked"]; ?>"></td>
                                    <?php
                                    $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                    $contagiorni++;
                                }
                                ?>	
                            </tr>	
                            <tr class="avalRow">
                                <td>Availability</td>
                                <?php
                                $datecycle = $datein;
                                $contagiorni = 0;
                                while (strtotime($datecycle) <= strtotime($dateout)) {
                                    ?>
                                    <td class="text-center <?php if ($simcalendar[$a][$contagiorni]["n_available"] >= 0) { ?>success<? } else { ?>danger<?php } ?>"><input type="text" class="form-control"  readonly value="<?php echo $simcalendar[$a][$contagiorni]["n_available"] ?>"></td>
                                    <?php
                                    $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                    $contagiorni++;
                                }
                                ?>	
                            </tr>									
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<script>
$(document).ready(function(){
	$("td input").each(function(){
		if($(this).val()=="0"){
			$(this).val("-");
		}
	});
});
</script>
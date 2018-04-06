<script>
    var arraycontabkgs = new Array();
</script>
<div class="box">
    <div class="box-header with-border text-center row">
        <div class="col-sm-8">
            <ul class="nav nav-pills" role="tablist">
                <li role="presentation" class="active"><a href="#d" data-toggle="pill"><span class="glyphicon glyphicon-calendar"></span> Multi Campus tuition from <?php echo date("d/m/Y", strtotime($datein)) ?> to <?php echo date("d/m/Y", strtotime($dateout)) ?></a></li>
            </ul>
        </div>
        <div class="pull-right col-sm-4 highlight-status">
            <span class="label weekends">Weekend</span> | 
            <span class="label success">Confirmed</span>
            <span class="label warning">Active</span>
            <span class="label info">To Be Confirmed</span>
            <span class="label danger">Elapsed</span>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body test-head">
        <?php
        for ($a = 0; $a < count($simbooking); $a++) {
            $contarighe = 1;
            $dateArr = array();
            foreach ($dates[$a] as $dataArr) {
                $dateArr[] = strtotime($dataArr["start_date"]);
            }
            ?>

            <div class="row">
                <div class="col-sm-12 mr-bot-10">
                    <input type="button" id="btnToggle_<?php echo $a ?>" class="btn btn-primary btnToggle" value="<?php echo $campusName[$a] ?>">
                </div>
            </div>
            <div class="row">
                <div style="overflow-x: auto;" id="tabAvail_<?php echo $a ?>" class="collapse in  col-sm-12 highlight-dark">
                    <table class="table table-bordered table-condensed table-striped tabAvail" style="font-size:9px;">
                        <thead>
                            <tr>
                                <th  >Agency</th>
                                <?php
                                $datecycle = $datein;
                                while (strtotime($datecycle) <= strtotime($dateout)) {
                                    $festivo = 0;
                                    if (date("D", strtotime($datecycle)) == "Sat" or date("D", strtotime($datecycle)) == "Sun") {
                                        $festivo = 1;
                                    }
                                    ?>
                                    <th  <?php if (in_array(strtotime($datecycle), $dateArr) or $festivo == 1) { ?>class="text-info info<?php if ($festivo == 1) { ?> weekends text-danger danger<?php } ?>"<?php } ?>><span><?php echo substr(date("D", strtotime($datecycle)), 0,1). " " .date("d/m", strtotime($datecycle)) ?></span></th>
                                    <?php
                                    $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($simbooking[$a] as $book) {
                                $da = explode("-", $book["data_arrivo_campus"]);
                                $dd = explode("-", $book["data_partenza_campus"]);
                                switch ($book["status"]) {
                                    case "confirmed":
                                        $statusBTS = "success";
                                        break;
                                    case "active":
                                        $statusBTS = "warning";
                                        break;
                                    case "tbc":
                                        $statusBTS = "info";
                                        break;
                                    case "elapsed":
                                        $statusBTS = "danger";
                                        break;
                                }
                                ?>
                                <tr id="riga_<?php echo $contarighe ?>">
                                    <td  class="n_<?php echo $book["status"] ?>"><input type="hidden" value="<?php echo $book["num_in"] ?>" id="pax_<?php echo $contarighe ?>"><span class="tdTool" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $book["businessname"] ?>"><img style="margin-top:-1px;" class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $book["businesscountry"] ?>.png" alt="<?php echo $book["businesscountry"] ?>" data-toggle="tooltip"  data-placement="top" title="<?php echo $book["businesscountry"] ?>" /> <?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?></span></td>
                                    <?php
                                    //echo $datein."-->";
                                    $datecycle = date("Y-m-d", strtotime("+0 day", strtotime($datein)));
                                    //$datecycle = $datein;								
                                    while (strtotime($datecycle) <= strtotime($dateout)) {
                                        $dayCount = 0;
                                        if(isset($book['bookings_on_days']))
                                            $dayCount = ($book['bookings_on_days'][$datecycle]);
                                        $weekends = "";
                                        $weekEndDays = array("Sat","Sun");
                                        $weekDay = date("D", strtotime($datecycle));
                                            if(in_array($weekDay, $weekEndDays))
                                            $weekends = "weekends ";
                                        if ($dayCount) {
                                            ?>
                                            <td  class="text-center <?php echo $weekends;?> <?php echo $statusBTS ?>"><input class="contapax nobbg form-control" id="pax_<?php echo $contarighe ?>_<?php echo strtotime($datecycle) ?>" type="text" readonly value="<?php echo $dayCount; ?>"></td>
                                            <?php
                                        } else {
                                            ?>
                                            <td  class="text-center <?php echo $weekends;?>"><input class="contapax nobbg form-control" id="pax_<?php echo $contarighe ?>_<?php echo strtotime($datecycle) ?>" type="text" readonly value="0"></td>
                                            <?php
                                        }
                                        $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                    }
                                    ?>									
                                </tr>
                                <?php
                                $contarighe++;
                            }
                            ?>
                            <tr class="rigaAvail">
                                <td>Students</td>
                                <?php
                                $datecycle = $datein;
                                foreach ($simcalendar[$a] as $cAva) {
                                    $festivo = 0;
                                    if (date("D", strtotime($datecycle)) == "Sat" or date("D", strtotime($datecycle)) == "Sun") {
                                        $festivo = 1;
                                    }
                                    ?>
                                    <td <?php if ($festivo == 1) { ?>class="weekends text-danger danger"<?php } ?>><input id="totava_<?php echo strtotime($datecycle) ?>" type="text" class="nobbg form-control" readonly value="<?php echo $cAva["booked"] ?>"></td>
                                    <?php
                                    $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                }
                                ?>	
                            </tr>								
                            <tr class="avalRow">
                                <td>Teachers</td>
                                <?php
                                $datecycle = $datein;
                                foreach ($simcalendar[$a] as $cAva) {
                                    $festivo = 0;
                                    if (date("D", strtotime($datecycle)) == "Sat" or date("D", strtotime($datecycle)) == "Sun") {
                                        $festivo = 1;
                                    }
                                    ?>
                                    <td <?php if ($festivo == 1) { ?>class="weekends text-danger danger"<?php } ?>><input id="totava_<?php echo strtotime($datecycle) ?>" type="text" class="nobbg form-control" readonly value="<?php echo ceil($cAva["booked"] * 1 / 15) ?>"></td>
                                        <?php
                                        $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                    }
                                    ?>
                            </tr>								
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
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
<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<style>
    @media only screen and (max-width: 767px) {
        .toDateDiv {
            margin-top: 40px;
        }
    }
</style>
<div class="row">
    <div class="col-md-12">
        <form id="box_transport" name="box_transport" action="<?php echo base_url(); ?>index.php/enrolexcursions/planned" method="post">  
            <div class="box box-primary">
                <div class="box-body">
                    <h4 class="box-title" class="col-sm-12"><?php echo $breadcrumb2;?></h4>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <label >Select campus</label>
                            <div class="form-data mr-bot-5">
                                <select name="centri" class="form-control" id="centricampus">
                                    <?php foreach ($centri as $key => $item) { ?>
                                        <option <?php if ($campus == $item['id']) { ?>selected <?php } ?>value="<?php echo $item['id'] ?>"><?php echo $item['nome_centri'] ?></option>
                                    <?php }
                                    ?>
                                </select> 
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <label>Select excursion type</label>
                            <div class="form-data mr-bot-5">
                                <select class="form-control" name="tipo" id="tipo">
                                    <option <?php if ($tipo == "planned") { ?>selected <?php } ?>value="planned">Included</option>
                                </select> 		
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3 mr-bot-5">
                            <label>Select date range (from)</label>
                            <div class="form-data mr-bot-5">						
                                <input class="form-control pull-left" type="text" id="from" name="from" value="<?php echo $from ?>"  />
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3 toDateDiv">
                            <div class="form-data ">						
                                <label for="to" class="pull-left">(to)</label>
                                <input class="form-control pull-left" type="text" id="to" name="to" value="<?php echo $to ?>"  />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="button" name="transpmi" id="transpmi" class="btn btn-primary mr-top-10" value="Search" />
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    &nbsp;
                </div>
                <!-- /.box-footer-->
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form name="allexcu" id="allexcu" method="POST" action="<?php echo base_url(); ?>index.php/enrolexcursions/plannedTransfer">
                            <table class="datatable table table-bordered table-striped" style="width:99.98%;">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Date in</th>
                                        <th>Date out</th>
                                        <th>Agency</th>									
                                        <th>Week</th>
                                        <th>Excursion</th>								
                                        <th>Pax</th>
                                        <th class="no-sort">Select</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($all_excursions)
                                        foreach ($all_excursions as $exc) {
                                            ?>
                                            <tr>
                                                <td class="center n_<?php echo $exc["statopre"] ?>">
                                                    <span class="idofbook"><?php echo $exc["id_year"] ?>_<?php echo $exc["enroll_id"] ?></span>
                                                </td>
                                                <td class="center"><?php echo date("d/m/Y", strtotime($exc["enrol_arrival_date"])) ?></td>
                                                <td class="center"><?php echo date("d/m/Y", strtotime($exc["enrol_departure_date"])) ?></td>
                                                <td><img class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $exc["businesscountry"] ?>.png" alt="<?php echo $exc["businesscountry"] ?>" title="<?php echo $exc["businesscountry"] ?>" /><?php echo $exc["businessname"] ?></td>
                                                <td class="center"><?php echo $exc["exc_weeks"] ?></td>
                                                <td>
                                                    <?php echo $exc["exc_excursion_name"] ?>
                                                    <font style="font-weight:bold;display:block;clear:both;">
                                                    <?php //echo ucfirst($exc["exc_length"]) ?>
                                                    </font>
                                                </td>									
                                                <td><?php echo $exc["exb_tot_pax"] ?></td>
                                                <td class="center containcheck">
                                                    <input type="checkbox" name="excur_<?php echo $exc["exb_id"] ?>" value="<?php echo date("d-m-Y", strtotime($exc["enrol_arrival_date"])) ?>_<?php echo date("d-m-Y", strtotime($exc["enrol_departure_date"])) ?>_<?php echo $exc["exc_id"] ?>_<?php echo $exc["exb_tot_pax"] ?>" class="excn_<?php echo $exc["exc_id"] ?>" id="group<?php echo $exc["enroll_id"] ?>_<?php echo $exc["exb_id"] ?>" />
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                </tbody>
                                <input type="hidden" value="<?php echo $campus ?>" name="id_centro" id="id_centro" />
                                <input type="hidden" value="<?php echo $to ?>" name="to" id="to" />
                                <input type="hidden" value="<?php echo $from ?>" name="from" id="from" />
                            </table>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <button class="btn btn-danger pull-right" id="bus_all" name="bus_all" class="alt_btn">Set transportation for selected excursions</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
	$('#transpmi').click(function(){
            $('#loading-data').show();
            $('#box_transport').submit();
	});
        
        $( "#from" ).datepicker({
            defaultDate: "+1d",
            changeMonth: true,
            numberOfMonths: 1,
            dateFormat: "dd/mm/yy",	  
            onClose: function( selectedDate ) {
                $( "#to" ).datepicker( "option", "minDate", selectedDate );
            }
        });
        $( "#to" ).datepicker({
            defaultDate: "+1d",
            changeMonth: true,
            numberOfMonths: 1,
            dateFormat: "dd/mm/yy",
            onClose: function( selectedDate ) {
                $( "#from" ).datepicker( "option", "maxDate", selectedDate );
            }
        });
        
    })
</script>
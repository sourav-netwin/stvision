<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<script>
    var SITE_PATH = "<?php echo base_url();?>index.php/";
    var SUSER = "<?php echo $this->session->userdata('role');?>";
</script>
<style>
    .form-group.row {
        margin-bottom: 10px;
    }
</style>
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<script src="<?php echo base_url();?>js/jquery.browser.min.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery.printElement.min.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script src="<?php echo LTE;?>custom/tuition_schedule_for_lte.js?v=1.3"></script>
<section class="">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header col-sm-12">
                    <div class="row">
                        <?php showSessionMessageIfAny($this); ?>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>
                                            <span class="text">From date:</span>
                                        </label>
                                        <input class="form-control" type="text" id="txtCalFromDate" name="fd" value="<?php echo date("d/m/Y",strtotime($calFromDate));?>" />
                                    </div>
                                    <div class="col-sm-4">
                                        <label>
                                            <span class="text">To date:</span>
                                        </label>
                                        <input class="form-control" type="text" id="txtCalToDate" name="td" value="<?php echo date("d/m/Y",strtotime($calToDate));?>" />
                                    </div>
                                    <div class="col-sm-4 mr-top-25">
                                        <input type="button" value="Show" id="btnCalShow" class="btn btn-primary" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-4">
                                <div class="pull-right"><span class="abook">#Green</span> - Number of students placed in class.</div>
                                <div class="pull-right"><span class="pbook">#Red</span> - Total number of students on campus.</div>
                            </div>
                           
                    </div>
                        <div class="tuitionCalDiv mr-top-10">
                            <table id="tuitionCalTable" class="table table-bordered table-striped vertical-middle">
                                <tr>
                                    <th>Campus</th>
                                <?php 
                                    $monthDates=array();
                                    $date1 = new DateTime($calFromDate);
                                    $date2 = new DateTime($calToDate);
                                    $diff = 1 + $date2->diff($date1)->format("%a");
                                    $currDate = $calFromDate;
                                    for($d=1; $d<=$diff; $d++)
                                    {
                                        $todaysDay = date('l', strtotime($currDate));
                                        $dontAllowToSchedule = FALSE;
                                        if($todaysDay == "Saturday" || $todaysDay == "Sunday")
                                            $dontAllowToSchedule = TRUE;
                                        $monthDates[] = date('Y-m-d', strtotime($currDate));

                                        ?><th data-toggle="tooltip" title="<?php echo $todaysDay;?>" class="<?php echo ($dontAllowToSchedule) ? 'satSun'  : '';?>"><?php echo date('d/m', strtotime($currDate));?></th><?php 
                                        $currDate = date('Y-m-d', strtotime($currDate. ' + 1 days'));
                                    }
                                ?></tr><?php    
                                if($campusList){
                                    $CI = & get_instance();
                                        foreach ($campusList as $campus){
                                            ?>
                                            <tr>
                                                <td><?php echo $campus['nome_centri'];?></td>
                                                <?php 
                                                foreach($monthDates as $dates){
                                                    $todaysDay = date('l', strtotime($dates));
                                                    $dontAllowToSchedule = FALSE;
                                                    if($todaysDay == "Saturday" || $todaysDay == "Sunday")
                                                    {
                                                        $dontAllowToSchedule = TRUE;
                                                    }

                                                    ?><td class="<?php echo ($dontAllowToSchedule ? 'satSun' : '');?>">
                                                        <?php if(!$dontAllowToSchedule){?>
                                                        <i id="<?php echo strtotime($dates).$campus['id'];?>" data-campus-id="<?php echo $campus['id'];?>" data-campus="<?php echo $campus['nome_centri'];?>" data-pickdate="<?php echo date('d/m/Y',  strtotime($dates));?>" data-book-date="<?php echo $dates;?>" class="icon-plus-book dialogbtn"></i>
                                                        <div><?php echo $CI->getTodaysBookings($dates,$campus['id']);?> </div>
                                                        <?php }else{ 
                                                            $todaysClasses = $CI->checkTodaysClass($dates,$campus['id']);
                                                            if($todaysClasses)
                                                            {
                                                                ?>
                                                                    
                                                                    <i id="<?php echo strtotime($dates).$campus['id'];?>" data-campus-id="<?php echo $campus['id'];?>" data-campus="<?php echo $campus['nome_centri'];?>" data-pickdate="<?php echo date('d/m/Y',  strtotime($dates));?>" data-book-date="<?php echo $dates;?>" class="icon-plus-book dialogbtn"></i>
                                                                    <div>
                                                                        <?php echo $CI->getTodaysBookings($dates,$campus['id']);?>
                                                                    </div>
                                                                <?php 
                                                            }
                                                            else{
                                                                echo "--";
                                                            }
                                                            
                                                        }?>
                                                    </td><?php 
                                                }
                                                ?>
                                            </tr>
                                            <?php 
                                        }
                                }
                                ?>
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
    <?php 
    // THIS IS A COMMON VIEW USED TO SHOW ALL TYPES OF MODAL POPUP FOR TUITION SCHEDULE
    // THIS FILE IS ALSO LOADED IN TUITION SCHEDULE FOR COURSE DIRECTOR..
    $this->load->view('lte/backoffice/tuition/schedule_modal');?>
</section>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {

    });
</script>
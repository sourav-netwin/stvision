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
<section class="content">
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
                                    //error_reporting(E_ALL);
                                    $campus = $campusList[0];
                                        foreach ($campusList as $campus){
                                            ?>
                                                <tr>
                                                    <td>STUDENTS ON CAMPUS</td>
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
                                                            <?php }else{ echo "--";}?>
                                                        </td><?php 
                                                    }
                                                    ?>
                                                </tr>
                                            <?php 
                                        }

                                        $testedStudents = "";
                                        $studentsToBeTested = "";
                                        $studentsLeavingTomorrow = "";
                                        foreach($monthDates as $dates){
                                            $todaysDay = date('l', strtotime($dates));
                                            $dontAllowToSchedule = FALSE;
                                            if($todaysDay == "Saturday" || $todaysDay == "Sunday")
                                            {
                                                $dontAllowToSchedule = TRUE;
                                            }
                                            $qResult = $CI->getStudentsStats($dates,$campus['id']);
                                            if($qResult){
                                                foreach($qResult as $dayStats){
                                                    // Tested Students
                                                    $testedStudents .= "<td class='".($dontAllowToSchedule ? 'satSun' : '')."'>";
                                                    if($dontAllowToSchedule){
                                                        $testedStudents .= "<a href='javascript:void(0);'>--</a>"; 
                                                    }
                                                    else{
                                                        $testedStudents .= "<a href='javascript:void(0);' data-title='Tested students list' data-campus-id='".$campus['id']."' data-classdate='".$dates."' data-uuid='".$dayStats['std_uuids']."' class='showstdlist hlt-link-a'>";
                                                        $testedStudents .= $dayStats['students_count'];
                                                        $testedStudents .= "</a>";
                                                    }
                                                    $testedStudents .= "</td>";

                                                    // Students to be tested
                                                    $studentsToBeTested .= "<td class='".($dontAllowToSchedule ? 'satSun' : '')."'>";
                                                    if($dontAllowToSchedule){
                                                        $studentsToBeTested .= "<a href='javascript:void(0);'>--</a>"; 
                                                    }
                                                    else{
                                                        $studentsToBeTested .= "<a href='javascript:void(0);' data-title='To be tested students list' data-campus-id='".$campus['id']."' data-classdate='".$dates."' data-uuid='".$dayStats['untested_std_uuids']."' class='showstdlist hlt-link-a'>";
                                                        $studentsToBeTested .= $dayStats['untested_students_count'];
                                                        $studentsToBeTested .= "</a>";
                                                    }
                                                    $studentsToBeTested .= "</td>";

                                                    // Students leaving tomorrow
                                                    $studentsLeavingTomorrow .= "<td class='".($dontAllowToSchedule ? 'satSun' : '')."'>";

                                                    $studentsLeavingTomorrow .= "<a href='javascript:void(0);' data-title='Leaving tomorrow students list' data-campus-id='".$campus['id']."' data-classdate='".$dates."' data-uuid='".$dayStats['leavingto_std_uuids']."' class='showstdlist hlt-link-a'>";
                                                    $studentsLeavingTomorrow .= $dayStats['leavingto_students_count'];
                                                    $studentsLeavingTomorrow .= "</a>";

                                                    $studentsLeavingTomorrow .= "</td>";
                                                }
                                            }

                                        }

                                        echo "<tr><td style='text-transform: uppercase;'>Tested Students</td>".$testedStudents."</tr>";
                                        echo "<tr><td style='text-transform: uppercase;'>Students to be tested</td>".$studentsToBeTested."</tr>";
                                        echo "<tr><td style='text-transform: uppercase;'>Students leaving tomorrow</td>".$studentsLeavingTomorrow."</tr>";
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
    // THIS FILE IS ALSO LOADED IN TUITION SCHEDULE FOR ALL..
    $this->load->view('lte/backoffice/tuition/schedule_modal');?>
        <div id="dialog_modal_std_showlist" data-backdrop="static" class="modal">
            <div class="modal-dialog modal-lg-95-per">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><span class="statTitle">Students list</span>
                        <button aria-label="Close" onclick="$('#dialog_modal_std_showlist').modal('hide');$('body').addClass('modal-open')" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                        <div class="studentlist-legents pull-right">
                            <div class="studentlist-elmentary">Elementary  1 – 33</div>
                            <div class="studentlist-pre-int">Pre-intermediate  34 – 50</div>
                            <div class="studentlist-intermediate">Intermediate  51 – 66</div>
                            <div class="studentlist-upper-int">Upper-intermediate  67 – 83</div>
                            <div class="studentlist-advanced">Advanced  84 - 100</div>
                        </div>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div id="statsStudentsList"></div>
                    </div>
                    <div class="modal-footer">
                        <button  onclick="$('#dialog_modal_std_showlist').modal('hide');$('body').addClass('modal-open');"  class="btn btn-default pull-left" type="button">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
</section>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $( "body" ).on( "click", ".showstdlist", function() {
            var uuidsStr = $(this).attr('data-uuid');
            var classDate = $(this).attr('data-classdate');
            var campusId = $(this).attr('data-campus-id');
            var dataTitle = $(this).attr('data-title');
            $.post( SITE_PATH + "tuitions/getStatsStudentsList",{'uuidsStr':uuidsStr,'classDate':classDate,'campusId':campusId}, function( data ) {
                $("#statsStudentsList").html(data);
                initDataTable('statsStdTable');
            }); 
            $("#dialog_modal_std_showlist").modal("show");
            $("#dialog_modal_std_showlist .statTitle").html(dataTitle);
        });
    });
</script>
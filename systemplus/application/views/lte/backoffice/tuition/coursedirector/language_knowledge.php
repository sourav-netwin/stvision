<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<section class="">
    <div class="row">

        <div class="col-xs-12">
            <div class="box">
                <div class="box-header col-sm-12">
                    <div class="row">
                        <div class="col-sm-6">

                        </div>
                        <?php showSessionMessageIfAny($this); ?>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            Please enter name, campus arrival date, campus departure date and click search button to filter.
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 form-group">
                            <label for="txtSearchText" class="control-label">Search</label>
                            <input type="text" class="form-control" id="txtSearchText" name="txtSearchText" value="" />
                        </div>
                        <div class="col-sm-3 form-group">
                            <label for="txtCalFromDate" class="control-label">From date</label>
                            <input type="text" class="form-control" readonly id="txtCalFromDate" name="fd" value="" />
                        </div>
                        <div class="col-sm-3 form-group">
                            <label for="txtCalToDate" class="control-label">To date</label>
                            <input type="text" class="form-control" readonly id="txtCalToDate" name="td" value="" /> 
                        </div>
                        <div class="col-sm-3 form-group mr-top-25">
                            <input id="btnSearch" class="btn btn-primary" type="submit" value="Search" >
                            <input id="btnClear" class="btn btn-danger" type="reset" value="Clear" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            Sort columns by clicking on the arrow on the right of first row cells.
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="langStudentsList">
                                <table class="datatable table table-bordered table-striped vertical-middle" style="width:99.98%;" >
                                    <thead>
                                        <tr>
                                            <th class="col-sm-3">Name</th>
                                            <th>Age</th>								
                                            <th>Nationality</th>								
                                            <th>Booking Id</th>
                                            <th>Campus arrival</th>
                                            <th>Campus departure</th>
                                            <th class="col-text-numeric">Listening &<br/> comprehension<br /><small>a (0-10)</small></th>
                                            <th style="width:43px!important;" class="col-text-numeric">Oral&nbsp;test<br /><small>b (0-40)</small></th>
                                            <th class="col-text-numeric">Student <br />test score<br /><small>c (0-50)</small></th>
                                            <th class="col-text-numeric">Language knowledge<br /><small>(a + b + c)</small></th>
<!--                                            <th id="sortLK" >Language knowledge</th>
                                            <th style="display: none;"></th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($studentsList)
                                            foreach ($studentsList as $student) {
                                                ?>
                                                <tr>
                                                    <td >
                                                        <?php
                                                        if (empty($student["nome"]) && empty($student["cognome"]))
                                                            echo '-';
                                                        else
                                                            echo html_entity_decode($student["nome"] . ' ' . $student["cognome"]);
                                                        ?>
                                                    </td>
                                                    <td  ><?php echo date_diff(date_create($student["pax_dob"]), date_create('today'))->y; ?></td>
                                                    <td  ><?php echo (empty($student["nazionalita"]) ? '-' : $student["nazionalita"]); ?></td>
                                                    <td  ><?php echo $student["id_book"] . '_' . $student["id_year"]; ?></td>
                                                    <td  ><?php echo date('d/m/Y', strtotime($student["data_arrivo_campus"])); ?></td>
                                                    <td  ><?php echo date('d/m/Y', strtotime($student["data_partenza_campus"])); ?></td>
                                                    <td class="text-center">
                                                        <input style="width:40px;text-align: center;" type="text" class="updatelang form-control" data-type="listening_comprehension" data-uuid="<?php echo $student["uuid"]; ?>" id="txt_listening_comprehension<?php echo $student["uuid"]; ?>" autocomplete="off" maxlength="3" onkeypress="return keyRestrict(event, '1234567890');" value="<?php echo (!empty($student["lk_listening_comprehension"]) ? $student["lk_listening_comprehension"] : 0); ?>" />
                                                    </td>
                                                    <td class="text-center">
                                                        <input style="width:40px;text-align: center;" type="text" class="updatelang form-control" data-type="oral_test" data-uuid="<?php echo $student["uuid"]; ?>" id="txt_oral_test<?php echo $student["uuid"]; ?>" autocomplete="off" maxlength="3" onkeypress="return keyRestrict(event, '1234567890');" value="<?php echo (!empty($student["lk_oral_test"]) ? $student["lk_oral_test"] : 0); ?>" />
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if (isset($student['ts_id']) && !empty($student['ts_id'])) { ?>
                                                            <input style="width:40px;text-align: center;" disabled="disabled" type="text" class="form-control" id="txt_english_test_score<?php echo $student["uuid"]; ?>" autocomplete="off" maxlength="3" onkeypress="return keyRestrict(event, '1234567890');" value="<?php echo (!empty($student["lk_english_test_score"]) ? $student["lk_english_test_score"] : 0); ?>" />
                                                        <?php } else { ?>
                                                            <input style="width:40px;text-align: center;" type="text" class="form-control updateTestMarks" id="txt_english_test_score<?php echo $student["uuid"]; ?>" data-id="<?php echo $student["uuid"]; ?>" autocomplete="off" maxlength="2" onkeypress="return keyRestrict(event, '1234567890');" value="<?php echo (!empty($student["lk_english_test_score"]) ? $student["lk_english_test_score"] : 0); ?>" />
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <input style="width:50px;text-align: center;" disabled="disabled" type="text" class="form-control"  id="txt_lang_knowledge<?php echo $student["uuid"]; ?>" autocomplete="off" maxlength="3" onkeypress="return keyRestrict(event, '1234567890');" value="<?php echo (!empty($student["lk_lang_knowledge"]) ? $student["lk_lang_knowledge"] : 0); ?>" />
                                                    </td>
            <!--                                        <td   id="td_<?php //echo $student["uuid"];              ?>" style="text-align:right;border-right:none;display: none;"><?php //echo (!empty($student["lk_lang_knowledge"]) ? $student["lk_lang_knowledge"] : 0);              ?></td>
                                                    <td class="center operation" >
                                                        <span style="display:hide;"><?php //echo (!empty($student["lk_lang_knowledge"]) ? $student["lk_lang_knowledge"] : 0);              ?></span>
                                                        <input style="width:40px;text-align: center;" type="text" class="updatelang" data-uuid="<?php //echo $student["uuid"];              ?>" id="txt_<?php //echo $student["uuid"];              ?>" autocomplete="off" maxlength="3" onkeypress="return keyRestrict(event,'1234567890');" value="<?php //echo (!empty($student["lk_lang_knowledge"]) ? $student["lk_lang_knowledge"] : 0);              ?>" />
                                                    </td>-->
                                                </tr>
                                                <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
<style>
    .err-border{
        border: 1px solid #d73925;
    }
</style>
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<script>
                                                            $(document).ready(function () {
                                                                $("li#mnutuition").addClass("current");
                                                                var loadingImg = "<span class='imgLoading loadingSpan' style='float:right;position:absolute;'><img  src='<?php echo base_url() . 'img/tuition/throbber.gif' ?>' /></span>"
                                                                var saveAlert = "<span class='saveAlert loadingSpan' style='float:right;position:absolute;color:green;'>Saved!</span>"
                                                                $("body").on("change", ".updatelang", function () {
                                                                    var thisEle = $(this);
                                                                    var uuid = $(this).attr('data-uuid');
                                                                    var action = $(this).attr('data-type');
                                                                    var knowledge_lang = $(this).val();
                                                                    if (action == "listening_comprehension" && (0 > knowledge_lang || knowledge_lang > 10))
                                                                    {
                                                                        $(this).val('0');
                                                                        thisEle.parent().append(saveAlert);
                                                                        thisEle.parent().find(".saveAlert").css('margin-top', '0px').css('color', 'red').html('Not<br />Allowed!').fadeOut(4500);
                                                                    } else if (action == "oral_test" && (0 > knowledge_lang || knowledge_lang > 40))
                                                                    {
                                                                        $(this).val('0');
                                                                        thisEle.parent().append(saveAlert);
                                                                        thisEle.parent().find(".saveAlert").css('margin-top', '0px').css('color', 'red').html('Not<br />Allowed!').fadeOut(4500);
                                                                    } else {
                                                                        thisEle.parent().append(loadingImg);
                                                                        $.post("<?php echo base_url(); ?>index.php/tuitions/updatelang", {'action': action, 'uuid': uuid, 'knowledge_lang': knowledge_lang}, function (data) {
                                                                            $("#td_" + action + uuid).html(knowledge_lang);
                                                                            $("#txt_lang_knowledge" + uuid).val(data.result);
                                                                            thisEle.parent().find(".imgLoading").replaceWith(saveAlert);
                                                                            thisEle.parent().find(".saveAlert").fadeOut(4500);
                                                                        }, 'json');
                                                                    }

                                                                });

                                                                $("#txtCalFromDate").datepicker({
                                                                    defaultDate: "+1w",
                                                                    changeMonth: true,
                                                                    changeYear: true,
                                                                    dateFormat: "dd/mm/yy",
                                                                    numberOfMonths: 1,
                                                                    onClose: function (selectedDate) {
                                                                        $("#txtCalToDate").datepicker("option", "minDate", selectedDate);
                                                                    }
                                                                });

                                                                $("#txtCalToDate").datepicker({
                                                                    defaultDate: "+1w",
                                                                    changeMonth: true,
                                                                    changeYear: true,
                                                                    dateFormat: "dd/mm/yy",
                                                                    numberOfMonths: 1,
                                                                    onClose: function (selectedDate) {
                                                                        $("#txtCalFromDate").datepicker("option", "maxDate", selectedDate);
                                                                    }
                                                                });

                                                                $("body").on("click", "#btnClear", function () {
                                                                    $('#txtSearchText').val('');
                                                                    $('#txtCalFromDate').val('');
                                                                    $('#txtCalToDate').val('');
                                                                    $("#btnSearch").trigger('click');
                                                                });
                                                                $("body").on("click", "#btnSearch", function () {
                                                                    var keyword = $('#txtSearchText').val();
                                                                    var campfrom = $('#txtCalFromDate').val();
                                                                    var campto = $('#txtCalToDate').val();
                                                                    $.post("<?php echo base_url(); ?>index.php/tuitions/searchlangknowledgeajax", {
                                                                        'keyword': keyword,
                                                                        'campfrom': campfrom,
                                                                        'campto': campto
                                                                    }, function (data) {
                                                                        $("#langStudentsList").html(data);
                                                                        initDataTable();
                                                                        //                            oTable.clear();
                                                                        //                            oTable.rows.add(data);
                                                                        //                            oTable.draw();
                                                                    }, 'html');
                                                                });
                                                                $('body').on('change','.updateTestMarks', function () {
                                                                    var $control = $(this);
                                                                    var uuid = $(this).attr('data-id');
                                                                    var marks = $(this).val();
                                                                    if (marks == '' || marks < 0 || marks > 50) {
                                                                        $(this).addClass('err-border');
                                                                        return;
                                                                    }
                                                                    $(this).removeClass('err-border');
                                                                    $control.parent().append(loadingImg);
                                                                    $.post("<?php echo base_url(); ?>index.php/tuitions/updatelang", {'action': 'english_test_score', 'uuid': uuid, 'knowledge_lang': marks}, function (data) {
                                                                        $("#txt_lang_knowledge" + uuid).val(data.result);
                                                                        $control.parent().find(".imgLoading").replaceWith(saveAlert);
                                                                        $control.parent().find(".saveAlert").fadeOut(4500);
                                                                    }, 'json');
                                                                });
                                                            });
</script>
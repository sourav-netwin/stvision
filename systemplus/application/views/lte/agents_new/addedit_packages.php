<style>
    .input-price, .input-price-sum{
        width:100px;
        display: inline!important;
    }
    .updateExtraValue:hover{
        color: #367fa9!important;
    }
    table th{
        width: 140px;
    }
    table th:first-of-type{
        width: 130px;
    }
    table th:last-of-type{
        width: 75px;
    }
    .input-price-symbol {
        float: left;
        margin-left: 6px;
        margin-top: 7px;
        position: absolute;
    }
    .chLabel{
        cursor: pointer;
        padding-top: 2px;
    }
    
    @media only screen and (max-width: 500px) {
        #bodyDiv {
            overflow-x: auto;
        }
    }
</style>
<div class="row">
    <div class="col-xs-12">
      <div class="box" >
        <div class="box-header col-sm-12">
            <div class="row">
                <?php showSessionMessageIfAny($this,'error_message',$error_message);?>
            </div>
        </div>
        <div id="bodyDiv" class="box-body" >
            <form id="frmPackages" method="post" >
            <div class="form-group row">
                <label class="col-sm-2 control-label">Package for the weeks</label>
                <div class="col-sm-7 col-lg-4">
                    <label class="chLabel" for="chkOneWeek1"><input autocomplete="off" type="checkbox" class="chPackageWeeks" id="chkOneWeek1" name="packageWeeks[]" <?php echo ( $formData['chkWeek1'] ? 'checked' : '')?> value="1 Week" /> 1 Week</label>&nbsp;&nbsp;&nbsp;
                    <label class="chLabel" for="chkOneWeek2"><input autocomplete="off" type="checkbox" class="chPackageWeeks" id="chkOneWeek2" name="packageWeeks[]" <?php echo ( $formData['chkWeek2'] ? 'checked' : '')?> value="2 Week" /> 2 Week</label>&nbsp;&nbsp;&nbsp;
                    <label class="chLabel" for="chkOneWeek3"><input autocomplete="off" type="checkbox" class="chPackageWeeks" id="chkOneWeek3" name="packageWeeks[]" <?php echo ( $formData['chkWeek3'] ? 'checked' : '')?> value="3 Week" /> 3 Week</label>
                    <div for="packageWeeks[]" generated="true" class="error"></div>
                </div>
            </div>
            <div class="form-group row">
                    <label class="col-sm-2 control-label" for="selCampus">Campus</label>
                    <div class="col-sm-6  col-lg-4">
                        <select <?php echo ($edit_id ? "disabled" : "");?> class="form-control" autocomplete="off" id="selCampus" name="selCampus"  >
                            <option value="">Select campus</option>
                            <?php if($campusList){
                                    foreach ($campusList as $campus){
                                        ?><option <?php echo ($formData['selCampus'] == $campus['id'] ? "selected='selected'" : '');?> data-valuta="<?php echo $campus['valuta_fattura'];?>" value="<?php echo $campus['id'];?>"><?php echo $campus['nome_centri'];?></option><?php 
                                    }
                            }
                            ?>
                        </select>
                        <?php if($edit_id){?>
                        <input type="hidden" name="selCampus" value="<?php echo $formData['selCampus'];?>" >
                        <?php }?>
                        <div class="error"><?php echo form_error('selCampus');?></div>
                        <?php if($edit_id){?>
                        <script>
                            $("#selCampus").trigger('change');
                        </script>
                        <?php }?>
                    </div>
            </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label" for="txtPackageName">Package name</label>
            <div class="col-sm-7 col-lg-4">
                <input type="text" id="txtPackageName" autocomplete="off" name="txtPackageName"  class="form-control" maxlength="250" value="<?php echo set_value('txtPackageName', htmlentities($formData['txtPackageName']));?>" >
                <div class="error"><?php echo form_error('txtPackageName');?></div>
            </div>
        </div>
                
        <div class="form-group row">
            <label class="col-sm-2 control-label" for="selCategoryProgram">Category program</label>
            <div class="col-sm-7 col-lg-4">
                <select autocomplete="off" class="form-control" id="selCategoryProgram" name="selCategoryProgram">
                    <option value="">Select category program</option>
                    <?php 
                    if(is_array($categoryProgram)){
                        foreach($categoryProgram as $category){
                            ?><option <?php echo ($formData['selCategoryProgram'] == $category['procat_id'] ? "selected='selected'" : '');?> value="<?php echo $category['procat_id'];?>"><?php echo htmlentities(ucwords($category['procat_name']));?></option><?php 
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label" for="txtProgDescription">Extended description</label>
            <div class="col-sm-10 col-lg-8">
                <textarea id="txtProgDescription" name="txtProgDescription" class="editor form-control required"><?php echo set_value('txtProgDescription',$formData['txtProgDescription']);?></textarea>
                <div class="error"><?php echo form_error('txtProgDescription');?></div>
            </div>
        </div>
                
        <div class="form-group row">
            <label class="col-sm-2 control-label" for="chkLocation">Location</label>
            <div class="col-sm-10 col-lg-8">
                <div id="collapsedBox" class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <input autocomplete="off" type="checkbox" class="chkLocation" id="chkValidRegion" name="chkValidRegion"  <?php echo ( $formData['chkValidRegion'] ? 'checked' : '')?> value="1" /> Valid for region
                            </h3>
                        <div class="box-tools pull-right">
                            <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" type="button" data-original-title="Collapse" data-container="body">
                            <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        </div>
                        <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="box-body">
                                <div class="form-group">
                                    <label for="selRegion">Region</label>
                                    <div class="form-data">
                                    <select autocomplete="off" class="form-control" id="selRegion" name="selRegion">
                                        <option value="">Select region</option>
                                        <?php 
                                        if(is_array($locationRegion)){
                                            foreach($locationRegion as $region){
                                                ?><option <?php echo ($formData['selRegion'] == $region['reg_id'] ? "selected='selected'" : '');?> value="<?php echo $region['reg_id'];?>"><?php echo $region['reg_descrizione'];?></option><?php 
                                            }
                                        }
                                        ?>
                                    </select>
                                    </div>
                                </div>          
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="box-body">
                                <div class="form-group">
                                    <label for="selCountry">Country</label>
                                    <div class="form-data">
                                    <select autocomplete="off" class="form-control" id="selCountry" name="selCountry[]" multiple="multiple">
                                    </select>
                                    <small>(Please select country)</small>
                                    <div for="selCountry" generated="true" class="error"></div>
                                    </div>
                                </div>          
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="selAgents">Agent</label>
                                        <label class="chLabel" for="selectAllAgent" style="float: right;">
                                        <input autocomplete="off" type="checkbox" class="chSelectAll" id="selectAllAgent" /> Select All</label>&nbsp;&nbsp;&nbsp;
                                        <div class="form-data">
                                        <select autocomplete="off" class="form-control" id="selAgents" name="selAgents[]" multiple="multiple">
                                        </select>
                                        <small>(Please select agents)</small>
                                        <div for="selAgents" generated="true" class="error"></div>
                                        </div>
                                    </div>    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                
        <div class="price-cal-validate">
            <div class="form-group row">
                <label class="col-sm-2 control-label" style="word-break:break-all;" for="btnAddSTAccSelect">Accommodation</label>
                <div class="col-sm-7 col-lg-4">
                    <select style="width:70%;" autocomplete="off" class="form-control pull-left mr-right-5" id="btnAddSTAccSelect" >
                        <option>Select accommodation</option>
                        <?php 
                            if($accommodationListStudents){
                                foreach ($accommodationListStudents as $accomodation){
                                    ?><option value="<?php echo $accomodation['accom_id'];?>"><?php echo $accomodation['accom_name'];?></option><?php 
                                }
                            }
                        ?>
                    </select>
                    <button id="btnAddSTAcc" type="button" data-itype="stdAcc" class="btnAddServices btn btn-primary pull-left" ><i class="fa fa-plus"> Add</i></button>
                    <div class="error"><?php echo form_error('btnAddSTAccSelect');?></div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-offset-2 col-sm-10">
                    <table id="btnAddSTAccTable" class="table table-responsive table-bordered">
                    <tbody>
                        <tr>
                            <th>Accommodation</th>
                            <th>Cost</th>
                            <th>Extra night cost</th>
                            <th>Remove</th>
                        </tr>
                        <?php 
                        if(isset($addedAccommodation)){
                            if($addedAccommodation)
                            foreach($addedAccommodation as $addAcc)
                            {
                        ?>
                                <tr id="tr-btnAddSTAcc_<?php echo $addAcc['serv_service_id'];?>">
                                    <td>
                                        <label id="lbl-service-<?php echo $addAcc['serv_service_id'];?>"><?php echo $addAcc['service_name'];?></label>
                                        <input name="stdAcc[<?php echo $addAcc['serv_service_id'];?>][service_name]" value="<?php echo $addAcc['service_name'];?>" type="hidden">
                                    </td>
                                    <td>
                                        <span class='input-price-symbol'></span><input autocomplete="off" onkeypress="return keyRestrict(event,'1234567890.');" maxlength='13' class="form-control input-price" name="stdAcc[<?php echo $addAcc['serv_service_id'];?>][cost]" value="<?php echo $addAcc['serv_cost'];?>" type="text">
                                    </td>
                                    <td>
                                        <span class='input-price-symbol'></span><input autocomplete="off" onkeypress="return keyRestrict(event,'1234567890.');" maxlength='13' class="form-control input-price" id="txt_serv_<?php echo $addAcc['serv_id'];?>" name="stdAcc[<?php echo $addAcc['serv_service_id'];?>][extra_night]" value="<?php echo $addAcc['serv_extra_night'];?>" type="text">
                                        <lable class="updateExtraValue label label-info btn" data-serv-type="accomodation" data-serv-id="<?php echo $addAcc['serv_id'];?>">update</lable>
                                    </td>
                                    <td>
                                        <a class="lnkRemove" title='Remove' data-toggle='tooltip' data-table="#btnAddSTAccTable" data-select="#btnAddSTAccSelect" data-option="<?php echo $addAcc['serv_service_id'];?>" data-tr="tr-btnAddSTAcc_<?php echo $addAcc['serv_service_id'];?>" href="javascript:void(0);">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <script>
                                    $("#btnAddSTAccSelect option[value="+<?php echo $addAcc['serv_service_id'];?>+"]").attr('disabled','disabled');
                                </script>
                        <?php }
                        }?>
                    </tbody>
                        <!-- will be populated on select of services -->
                    </table>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label" for="btnAddCoursesTypeSelect">Courses type</label>
                <div class="col-sm-7 col-lg-4">
                    <select style="width:70%;" class="form-control pull-left mr-right-5" id="btnAddCoursesTypeSelect" >
                        <option>Select course type</option>
                        <?php 
                            if($coursesType){
                                foreach ($coursesType as $coursetype){
                                    ?><option value="<?php echo $coursetype['courses_type_id'];?>"><?php echo $coursetype['courses_type'];?></option><?php 
                                }
                            }
                        ?>
                    </select>
                    <button id="btnAddCoursesType" type="button" data-itype="coursesType" class="btnAddServices btn btn-primary pull-left" ><i class="fa fa-plus"> Add</i></button>
                    <div class="error"><?php echo form_error('btnAddCoursesTypeSelect');?></div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-offset-2 col-sm-10">
                    <table id="btnAddCoursesTypeTable" class="table table-bordered table-responsive table-striped">
                        <tbody>
                        <tr>
                            <th>Courses type</th>
                            <th>Cost</th>
                            <th>Extra tuition cost</th>
                            <th>Remove</th>
                        </tr>
                        <?php 
                        if(isset($addedCourseType)){
                            if($addedCourseType)
                            foreach($addedCourseType as $addCType)
                            {
                        ?>
                                <tr id="tr-btnAddCoursesType_<?php echo $addCType['serv_service_id'];?>">
                                    <td>
                                        <label id="lbl-service-<?php echo $addCType['serv_service_id'];?>"><?php echo $addCType['service_name'];?></label>
                                        <input name="coursesType[<?php echo $addCType['serv_service_id'];?>][service_name]" value="<?php echo $addCType['service_name'];?>" type="hidden">
                                    </td>
                                    <td>
                                        <span class='input-price-symbol'></span><input autocomplete="off" onkeypress="return keyRestrict(event,'1234567890.');" maxlength='13' class="form-control input-price" name="coursesType[<?php echo $addCType['serv_service_id'];?>][cost]" value="<?php echo $addCType['serv_cost'];?>" type="text">
                                    </td>
                                    <td>
                                        <span class='input-price-symbol'></span><input autocomplete="off" onkeypress="return keyRestrict(event,'1234567890.');" maxlength='13' class="form-control input-price" id="txt_serv_<?php echo $addCType['serv_id'];?>" name="coursesType[<?php echo $addCType['serv_service_id'];?>][extra_tuition]" value="<?php echo $addCType['serv_extra_tuition'];?>" type="text">
                                        <lable class="updateExtraValue label label-info btn" data-serv-type="courseType" data-serv-id="<?php echo $addCType['serv_id'];?>">update</lable>
                                    </td>
                                    <td>
                                        <a class="lnkRemove" title='Remove' data-toggle='tooltip' data-table="#btnAddCoursesTypeTable" data-select="#btnAddCoursesTypeSelect" data-option="<?php echo $addCType['serv_service_id'];?>" data-tr="tr-btnAddCoursesType_<?php echo $addCType['serv_service_id'];?>" href="javascript:void(0);">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <script>
                                    $("#btnAddCoursesTypeSelect option[value="+<?php echo $addCType['serv_service_id'];?>+"]").attr('disabled','disabled');
                                </script>
                        <?php }
                        }?>
                        </tbody>
                        <!-- will be populated on select of services -->
                    </table>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label" for="btnAddActivitySelect">Activities</label>
                <div class="col-sm-7 col-lg-4">
                    <select style="width:70%;" class="form-control pull-left mr-right-5" id="btnAddActivitySelect" >
                        <option>Select activity</option>
                    </select>
                    <button id="btnAddActivity" type="button" data-itype="activities" class="btnAddServices btn btn-primary pull-left" ><i class="fa fa-plus"> Add</i></button>
                    <div class="error"><?php echo form_error('btnAddActivitySelect');?></div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-offset-2 col-sm-10">
                    <table id="btnAddActivityTable" class="table table-responsive table-bordered">
                        <tbody>
                            <tr>
                                <th>Activities</th>
                                <th>Cost</th>
                                <th>Extra activity cost</th>
                                <th>Remove</th>
                            </tr>
                            <?php 
                                if(isset($addedActivity)){
                                    if($addedActivity)
                                    foreach($addedActivity as $addActv)
                                    {
                                ?>
                                        <tr id="tr-btnAddActivity_<?php echo $addActv['serv_service_id'];?>">
                                            <td>
                                                <label id="lbl-service-<?php echo $addActv['serv_service_id'];?>"><?php echo $addActv['service_name'];?></label>
                                                <input name="activities[<?php echo $addActv['serv_service_id'];?>][service_name]" value="<?php echo $addActv['service_name'];?>" type="hidden">
                                            </td>
                                            <td>
                                                <span class='input-price-symbol'></span><input autocomplete="off" onkeypress="return keyRestrict(event,'1234567890.');" maxlength='13' class="form-control input-price" name="activities[<?php echo $addActv['serv_service_id'];?>][cost]" value="<?php echo $addActv['serv_cost'];?>" type="text">
                                            </td>
                                            <td>
                                                <span class='input-price-symbol'></span><input autocomplete="off" onkeypress="return keyRestrict(event,'1234567890.');" maxlength='13' class="form-control input-price" id="txt_serv_<?php echo $addActv['serv_id'];?>" name="activities[<?php echo $addActv['serv_service_id'];?>][extra_activity]" value="<?php echo $addActv['serv_extra_activity'];?>" type="text">
                                                <lable class="updateExtraValue label label-info btn" data-serv-type="activity" data-serv-id="<?php echo $addActv['serv_id'];?>">update</lable>
                                            </td>
                                            <td>
                                                <a class="lnkRemove" title='Remove' data-toggle='tooltip' data-table="#btnAddActivityTable" data-select="#btnAddActivitySelect" data-option="<?php echo $addActv['serv_service_id'];?>" data-tr="tr-btnAddActivity_<?php echo $addActv['serv_service_id'];?>" href="javascript:void(0);">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <script>
                                            setTimeout(function(){
                                                $("#btnAddActivitySelect option[value="+<?php echo $addActv['serv_service_id'];?>+"]").attr('disabled','disabled');
                                            },3000);
                                        </script>
                                <?php }
                                }?>
                        </tbody>
                        <!-- will be populated on select of services -->
                    </table>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label" for="btnAddExcursionSelect">Excursion</label>
                <div class="col-sm-10 col-lg-10">
                    <div class="row">
                        <div class="col-xs-4">
                            <select class="form-control pull-left" id="btnAddExcursionSelect" >
                                <option>Select excursion</option>
                            </select>
                        </div>
                        <div class="col-xs-4">
                            <select class="form-control pull-left" id="btnAddExcursionSelectWeek" >
                                <option value="">Select week</option>
                                <?php 
                                if($formData['chkWeek1'])
                                    echo "<option value='1 Week'>1 Week</option>";
                                if($formData['chkWeek2'])
                                    echo "<option value='2 Week'>2 Week</option>";
                                if($formData['chkWeek3'])
                                    echo "<option value='3 Week'>3 Week</option>";
                                ?>
                            </select>
                        </div>
                        <div class="col-xs-4">
                            <button id="btnAddExcursion" type="button" data-itype="excursion" class="btnAddServices btn btn-primary pull-left" ><i class="fa fa-plus"> Add</i></button>
                        </div>
                    </div>
                    <small>Please select week while adding excursion to the package, you can add same excursion for multiple weeks.</small>
                    <div class="error"><?php echo form_error('btnAddExcursionSelect');?></div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-offset-2 col-sm-10">
                    <table id="btnAddExcursionTable" class="table table-responsive table-bordered">
                        <tbody>
                        <tr>
                            <th>Excursion</th>
                            <th>Week</th>
                            <th>Cost</th>
                            <th>Remove</th>
                        </tr>
                        <?php 
                                if(isset($addedExcursion)){
                                    if($addedExcursion)
                                    foreach($addedExcursion as $addExcu)
                                    {
                                        $addExcu['serv_service_id'] = $addExcu['serv_service_id'].'_'. strtolower(str_replace(' ','-',$addExcu['serv_week']));
                                ?>
                                        <tr id="tr-btnAddExcursion_<?php echo $addExcu['serv_service_id'];?>">
                                            <td>
                                                <label id="lbl-service-<?php echo $addExcu['serv_service_id'];?>"><?php echo $addExcu['service_name'];?></label>
                                                <input name="excursion[<?php echo $addExcu['serv_service_id'];?>][service_name]" value="<?php echo $addExcu['service_name'];?>" type="hidden">
                                            </td>
                                            <td>
                                                <label id="lbl-service-<?php echo $addExcu['serv_service_id'];?>"><?php echo $addExcu['serv_week'];?></label>
                                                <input name="excursion[<?php echo $addExcu['serv_service_id'];?>][service_week]" value="<?php echo $addExcu['serv_week'];?>" type="hidden">
                                            </td>
                                            <td>
                                                <span class='input-price-symbol'></span><input autocomplete="off" onkeypress="return keyRestrict(event,'1234567890.');" maxlength='13' class="form-control input-price" name="excursion[<?php echo $addExcu['serv_service_id'];?>][cost]" value="<?php echo $addExcu['serv_cost'];?>" type="text">
                                            </td>
                                            <td>
                                                <a class="lnkRemove" title='Remove' data-opt-week="<?php echo $addExcu['serv_week'];?>" data-toggle='tooltip' data-table="#btnAddExcursionTable" data-select="#btnAddExcursionSelect" data-option="<?php echo $addExcu['serv_service_id'];?>" data-tr="tr-btnAddExcursion_<?php echo $addExcu['serv_service_id'];?>" href="javascript:void(0);">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <script>
                                            setTimeout(function(){
                                                $("#btnAddExcursionSelect option[value="+<?php echo $addExcu['serv_service_id'];?>+"]").attr('disabled','disabled');
                                            },3000);
                                        </script>
                                <?php }
                                }?>
                        </tbody>
                        <!-- will be populated on select of services -->
                    </table>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12 col-lg-12">
                    <h3 class="box-title">Staff charges (per week)</h3>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label" for="txtCourseDirectorSalary">Course director salary</label>
                <div class="col-sm-4 col-lg-4">
                    <span class='input-price-symbol'></span><input type="text" id="txtCourseDirectorSalary" name="txtCourseDirectorSalary" autocomplete="off" class="form-control input-price staff-charges" onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13' value="<?php echo set_value('txtCourseDirectorSalary',  $formData['txtCourseDirectorSalary']);?>" >
                    <div class="error"><?php echo form_error('txtCourseDirectorSalary');?></div>
                </div>
                <label class="col-sm-2 control-label" for="txtCourseDirectorAcco">Course director accommodation</label>
                <div class="col-sm-4 col-lg-4">
                    <span class='input-price-symbol'></span><input type="text" id="txtCourseDirectorAcco" name="txtCourseDirectorAcco" autocomplete="off" class="form-control staff-charges" onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13' value="<?php echo set_value('txtCourseDirectorAcco',  $formData['txtCourseDirectorAcco']);?>" >
                    <div class="error"><?php echo form_error('txtCourseDirectorAcco');?></div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label" for="txtAssistantCDSalary">Assistant course director salary</label>
                <div class="col-sm-4 col-lg-4">
                    <span class='input-price-symbol'></span><input type="text" id="txtAssistantCDSalary" name="txtAssistantCDSalary" autocomplete="off" class="form-control staff-charges" onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13' value="<?php echo set_value('txtAssistantCDSalary',  $formData['txtAssistantCDSalary']);?>" >
                    <div class="error"><?php echo form_error('txtAssistantCDSalary');?></div>
                </div>
                <label class="col-sm-2 control-label" for="txtAssistantCDAcco">Assistant course director accommodation</label>
                <div class="col-sm-4 col-lg-4">
                    <span class='input-price-symbol'></span><input type="text" id="txtAssistantCDAcco" name="txtAssistantCDAcco" autocomplete="off" class="form-control staff-charges" onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13' value="<?php echo set_value('txtAssistantCDAcco',  $formData['txtAssistantCDAcco']);?>" >
                    <div class="error"><?php echo form_error('txtAssistantCDAcco');?></div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label" for="txtCampusManagerSalary">Campus manager salary</label>
                <div class="col-sm-4 col-lg-4">
                    <span class='input-price-symbol'></span><input type="text" id="txtCampusManagerSalary" name="txtCampusManagerSalary" autocomplete="off" class="form-control input-price staff-charges" onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13' value="<?php echo set_value('txtCampusManagerSalary',  $formData['txtCampusManagerSalary']);?>" >
                    <div class="error"><?php echo form_error('txtCampusManagerSalary');?></div>
                </div>
                <label class="col-sm-2 control-label" for="txtCampusManagerAcco">Campus manager accommodation</label>
                <div class="col-sm-4 col-lg-4">
                    <span class='input-price-symbol'></span><input type="text" id="txtCampusManagerAcco" name="txtCampusManagerAcco" autocomplete="off" class="form-control staff-charges" onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13' value="<?php echo set_value('txtCampusManagerAcco',  $formData['txtCampusManagerAcco']);?>" >
                    <div class="error"><?php echo form_error('txtCampusManagerAcco');?></div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label" for="txtAssistantCMSalary">Assistant campus manager salary</label>
                <div class="col-sm-4 col-lg-4">
                    <span class='input-price-symbol'></span><input type="text" id="txtAssistantCMSalary" name="txtAssistantCMSalary" autocomplete="off" class="form-control staff-charges" onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13' value="<?php echo set_value('txtAssistantCMSalary',  $formData['txtAssistantCMSalary']);?>" >
                    <div class="error"><?php echo form_error('txtAssistantCMSalary');?></div>
                </div>
                <label class="col-sm-2 control-label" for="txtAssistantCMAcco">Assistant campus manager accommodation</label>
                <div class="col-sm-4 col-lg-4">
                    <span class='input-price-symbol'></span><input type="text" id="txtAssistantCMAcco" name="txtAssistantCMAcco" autocomplete="off" class="form-control staff-charges" onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13' value="<?php echo set_value('txtAssistantCMAcco',  $formData['txtAssistantCMAcco']);?>" >
                    <div class="error"><?php echo form_error('txtAssistantCMAcco');?></div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label" for="txtTeacherAccommodation">Teacher accommodation</label>
                <div class="col-sm-4 col-lg-4">
                    <span class='input-price-symbol'></span><input type="text" id="txtTeacherAccommodation" name="txtTeacherAccommodation" autocomplete="off" class="form-control staff-charges" onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13' value="<?php echo set_value('txtTeacherAccommodation',  $formData['txtTeacherAccommodation']);?>" >
                    <div class="error"><?php echo form_error('txtTeacherAccommodation');?></div>
                </div>
                <label class="col-sm-2 control-label" for="txtTeacherLunch">Teacher lunch</label>
                <div class="col-sm-4 col-lg-4">
                    <span class='input-price-symbol'></span><input type="text" id="txtTeacherLunch" name="txtTeacherLunch" autocomplete="off" class="form-control staff-charges" onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13' value="<?php echo set_value('txtTeacherLunch',  $formData['txtTeacherLunch']);?>" >
                    <div class="error"><?php echo form_error('txtTeacherLunch');?></div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label" for="txtTeacherAccommodation">Total charges</label>
                <div class="col-sm-4 col-lg-4">
                    <span class='input-price-symbol'></span>
                    <input type="text" readonly id="txtTotalStaffCharges" name="txtTotalStaffCharges" autocomplete="off" class="form-control" onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13' value="" >
                </div>
            </div>
          
            <div class="form-group row">
                <div class="col-sm-12 col-lg-12">
                    <h3 class="box-title">Other charges (per week)</h3>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label" for="txtTravel">Travel</label>
                <div class="col-sm-4 col-lg-4">
                    <span class='input-price-symbol'></span><input type="text" id="txtTravel" name="txtTravel" autocomplete="off" class="form-control other-charges" onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13' value="<?php echo set_value('txtTravel',  $formData['txtTravel']);?>" >
                    <div class="error"><?php echo form_error('txtTravel');?></div>
                </div>
                <label class="col-sm-2 control-label" for="txtPrintingStationery">Printing / Stationery</label>
                <div class="col-sm-4 col-lg-4">
                    <span class='input-price-symbol'></span><input type="text" id="txtPrintingStationery" name="txtPrintingStationery" autocomplete="off" class="form-control other-charges" onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13' value="<?php echo set_value('txtPrintingStationery',  $formData['txtPrintingStationery']);?>" >
                    <div class="error"><?php echo form_error('txtPrintingStationery');?></div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label" for="txtBooks">Books</label>
                <div class="col-sm-4 col-lg-4">
                    <span class='input-price-symbol'></span><input type="text" id="txtBooks" name="txtBooks" autocomplete="off" class="form-control other-charges" onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13' value="<?php echo set_value('txtBooks',  $formData['txtBooks']);?>" >
                    <div class="error"><?php echo form_error('txtBooks');?></div>
                </div>
                <label class="col-sm-2 control-label" for="txtExpenses">Expenses</label>
                <div class="col-sm-4 col-lg-4">
                    <span class='input-price-symbol'></span><input type="text" id="txtExpenses" name="txtExpenses" autocomplete="off" class="form-control other-charges" onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13' value="<?php echo set_value('txtExpenses',  $formData['txtExpenses']);?>" >
                    <div class="error"><?php echo form_error('txtExpenses');?></div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label" for="txtTeacherAccommodation">Total charges</label>
                <div class="col-sm-4 col-lg-4">
                    <span class='input-price-symbol'></span>
                    <input type="text" readonly id="txtTotalOtherCharges" name="txtTotalOtherCharges" autocomplete="off" class="form-control" onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13' value="" >
                </div>
            </div>
        </div>
        
            <div class="form-group row">
                <div class="col-sm-12">
                    <button id="btnGenerateComposition" type="button" class="btn btn-primary pull-left">Generate compositions</button>
                </div>
            </div>
            <div id="divCompositions" class="form-group row">
                <div class="col-sm-12" style="overflow-x: auto;">
                    <table id="divCompositionsTable" class="table table-responsive table-bordered">
                        <thead>
                        <tr>
                            <th>Package composition</th>
                            <th>Excursion cost</th>
                            <th>Staff charges</th>
                            <th>Other charges</th>
                            <th>Composition cost/day/pax</th>
                            <th>Total cost</th>
                            <th>Full price</th>
                            <th>Price A (10 to 19 pax)</th>
                            <th>Price B (20 to 39 pax)</th>
                            <th>Price C (40 pax and over)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if($edit_id)
                        if($addedCompositions){
                            $rowCell = 0;
                            $weekTotalCost = 0;
                            foreach ($addedCompositions as $addComp){
                                $rowCell++;
                                $weekTotalCost = 0;
                                if($addComp['pcomp_week'] == 1){
                                    $weekTotalCost = $addComp['pcomp_total_cost'] * 7 + $addComp['pcomp_excursion_cost'] + ($addComp['pcomp_staff_charges'] + $addComp['pcomp_other_charges']);
                                }
                                elseif($addComp['pcomp_week'] == 2){
                                    $weekTotalCost = $addComp['pcomp_total_cost'] * 14 + $addComp['pcomp_excursion_cost'] + ($addComp['pcomp_staff_charges'] + $addComp['pcomp_other_charges']);
                                }
                                elseif($addComp['pcomp_week'] == 3){
                                    $weekTotalCost = $addComp['pcomp_total_cost'] * 21 + $addComp['pcomp_excursion_cost'] + ($addComp['pcomp_staff_charges'] + $addComp['pcomp_other_charges']);
                                }
                        ?>
                            <tr>
                                <td><?php echo $addComp['composition_name'];?>
                                    <input type='hidden' name='pWeeks[]' value='<?php echo $addComp['pcomp_week'];?> Week' >
                                    <input type='hidden' name='accomIds[]' value='<?php echo $addComp['pcomp_accom_id'];?>' >
                                    <input type='hidden' name='ctypeIds[]' value='<?php echo $addComp['pcomp_course_type_id'];?>' >
                                    <input type='hidden' name='actIds[]' value='<?php echo $addComp['pcomp_activity_id'];?>' >
                                    <input type='hidden' name='rowCell[]' value='<?php echo $rowCell;?>' >
                                </td>
                                <td><span class='input-price-symbol' style='margin-top: 0;position: relative;'></span><?php echo $addComp['pcomp_excursion_cost'];?>
                                    <input type='hidden' id='excursionCost_<?php echo $rowCell;?>' name='excursionCost_<?php echo $rowCell;?>' value='<?php echo $addComp['pcomp_excursion_cost'];?>'>
                                </td>
                                <td><span class='input-price-symbol' style='margin-top: 0;position: relative;'></span><?php echo $addComp['pcomp_staff_charges'];?>
                                    <input type='hidden' id='staffCharges_<?php echo $rowCell;?>' name='staffCharges_<?php echo $rowCell;?>' value='<?php echo $addComp['pcomp_staff_charges'];?>'>
                                </td>
                                <td><span class='input-price-symbol' style='margin-top: 0;position: relative;'></span><?php echo $addComp['pcomp_other_charges'];?>
                                    <input type='hidden' id='otherCharges_<?php echo $rowCell;?>' name='otherCharges_<?php echo $rowCell;?>' value='<?php echo $addComp['pcomp_other_charges'];?>'>
                                </td>
                                <td><span class='input-price-symbol' style='margin-top: 0;position: relative;'></span><?php echo $addComp['pcomp_total_cost'];?>
                                    <input type='hidden' id='totalCost_<?php echo $rowCell;?>' name='totalCost_<?php echo $rowCell;?>' value='<?php echo $addComp['pcomp_total_cost'];?>'>
                                </td>
                                <td><span class='input-price-symbol' style='margin-top: 0;position: relative;'></span><?php echo number_format($weekTotalCost,2,'.',',');?>
                                </td>
                                <td>
                                    <span class='input-price-symbol'></span><input type='text' id='fullPrice_<?php echo $rowCell;?>' name='fullPrice_<?php echo $rowCell;?>' onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13' class='form-control input-price calPercent' data-tcost='<?php echo $weekTotalCost;?>' value='<?php echo $addComp['pcomp_full_price'];?>'><span class='spanPer'></span>
                                </td>
                                <td><span class='input-price-symbol'></span><input type='text' id='priceA_<?php echo $rowCell;?>' name='priceA_<?php echo $rowCell;?>' onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13' class='form-control input-price calPercent' data-tcost='<?php echo $weekTotalCost;?>' value='<?php echo $addComp['pcomp_price_a'];?>'><span class='spanPer'></span></td>
                                <td><span class='input-price-symbol'></span><input type='text' id='priceB_<?php echo $rowCell;?>' name='priceB_<?php echo $rowCell;?>' onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13' class='form-control input-price calPercent' data-tcost='<?php echo $weekTotalCost;?>' value='<?php echo $addComp['pcomp_price_b'];?>'><span class='spanPer'></span></td>
                                <td><span class='input-price-symbol'></span><input type='text' id='priceC_<?php echo $rowCell;?>' name='priceC_<?php echo $rowCell;?>' onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13' class='form-control input-price calPercent' data-tcost='<?php echo $weekTotalCost;?>' value='<?php echo $addComp['pcomp_price_c'];?>'><span class='spanPer'></span></td>
                            </tr>
                        <?php 
                            }
                        }
                        ?>
                        </tbody>
                        <!-- will be populated on select of services -->
                    </table>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label" for="txtFreeGL">Free GL Accommodation per number of pax</label>
                <div class="col-sm-7 col-lg-4">
                    <input type="text" id="txtFreeGL" name="txtFreeGL" autocomplete="off" class="form-control" onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13'  value="<?php echo set_value('txtFreeGL',  $formData['txtFreeGL']);?>" >
                    <div class="error"><?php echo form_error('txtFreeGL');?></div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label" for="txtExtraGLPrice">Extra GL accommodation price</label>
                <div class="col-sm-7 col-lg-4">
                    <span class='input-price-symbol'></span>
                    <input type="text" id="txtExtraGLPrice" name="txtExtraGLPrice" autocomplete="off" class="form-control" onkeypress='return keyRestrict(event,"1234567890.");' maxlength='13'  value="<?php echo set_value('txtExtraGLPrice',  $formData['txtExtraGLPrice']);?>" >
                    <div class="error"><?php echo form_error('txtExtraGLPrice');?></div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label" for="txtStartDate">Start date</label>
                <div class="col-sm-7 col-lg-4">
                    <input type="text" id="txtStartDate" name="txtStartDate" autocomplete="off" class="form-control" maxlength="250" value="<?php echo set_value('txtStartDate',  $formData['txtStartDate']);?>" >
                    <div class="error"><?php echo form_error('txtStartDate');?></div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label" for="txtExpiryDate">Expiry date</label>
                <div class="col-sm-7 col-lg-4">
                    <input type="text" id="txtExpiryDate" name="txtExpiryDate" autocomplete="off" class="form-control" maxlength="250" value="<?php echo set_value('txtExpiryDate',  $formData['txtExpiryDate']);?>" >
                    <div class="error"><?php echo form_error('txtExpiryDate');?></div>
                </div>
            </div>
            
            <div class="form-group row">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="hidden" id="edit_id" name="edit_id" value="<?php echo $edit_id;?>" />
                    <input type="hidden" id="generatedCompositions" name="generatedCompositions" value="0" />
                    <input class="btn btn-primary" type="submit" id="btnSave" name="btnSave" value="Submit" />
                    <input class="btn btn-danger" type="reset" id="btnCancel" name="btnCancel" value="Cancel" onclick="window.location.href='<?php echo base_url();?>index.php/packages'" />
                </div>
            </div>
        </form>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            &nbsp;
        </div>
        <!-- /.box-footer-->
      </div>
      </div>
</div>
<!--<script src="<?php //echo LTE; ?>plugins/select2/select2.full.min.js"></script>-->
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<link href="<?php echo LTE; ?>plugins/iCheck/all.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<script src="<?php echo base_url();?>js/tuition/jquery_validations1.9.0.js"></script>
<script src="<?php echo LTE;?>custom/number_format.js"></script>
<script src="<?php echo LTE; ?>plugins/select2/select2.full.min.js"></script>
<script>
    var SITE_PATH = "<?php echo base_url();?>index.php/";
    var package_edit_id = "<?php echo $edit_id;?>";
    var pageHighlightMenu = "packages/addedit";
    function iCheckInit(){
        $('.chPackageWeeks, #chkValidRegion, .chSelectAll').iCheck('destroy'); 
        $('.chPackageWeeks, #chkValidRegion, .chSelectAll').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            increaseArea: '10%' // optional
        });
    }
    
	$(document).ready(function() {
            iCheckInit();
            
            $('#selCountry').select2({
                dropdownAutoWidth : true,
                width: '100%'
            });
            $('#selAgents').select2({
                dropdownAutoWidth : true,
                width: '100%'
            });
            $("#selectAllAgent").click(function(){
                if($("#selectAllAgent").is(':checked') ){
                    
                }else{
                    
                }
            });
            
            $('#selectAllAgent').on('ifChecked', function(event){
                $("#selAgents > option").prop("selected","selected");
                $("#selAgents").trigger("change");
            });
            $('#selectAllAgent').on('ifUnchecked', function(event){
                $("#selAgents > option").removeAttr("selected");
                $("#selAgents").trigger("change");
            });
            
//            $('#selAccommodation').select2({
//                dropdownAutoWidth : true,
//                width: '100%'
//            });
//            $('#selAccommodationGL').select2({
//                dropdownAutoWidth : true,
//                width: '100%'
//            });
            
            $( "#bodyDiv" ).on( "click", ".btnAddServices", function() {
                var btnId = $(this).attr('id');
                var inputType = $(this).attr('data-itype');
                var id = $("#"+btnId+"Select").val();
                var is_disabled = $("#"+btnId+"Select option:selected").attr('disabled');
                
                if(is_disabled != "disabled" && parseInt(id) > 0)
                {
                    var serviceText = $("#"+btnId+"Select option:selected").text();
                    var serviceWeek = $("#"+btnId+"SelectWeek option:selected").text();
                    var serviceWeekVal = $("#"+btnId+"SelectWeek").val();
                    var alreadAdded = "";
                    if(inputType != "excursion")
                    {
                        $("#"+btnId+"Select option:selected").attr('disabled','disabled');
                    }else{
                        id = id + '_' + serviceWeek.replace(/\s+/g, '-').toLowerCase();
                        //excursion[1_week-1][service_name]
                        alreadAdded = $("input[name='excursion["+id+"][service_name]']").val();
                        if(typeof alreadAdded != 'undefined' || serviceWeekVal == '')
                            return false;
                    }
                    var htmlStr = "<tr id='tr-"+ btnId + "_"+ id +"'>";
                        htmlStr += "<td><label id='lbl-service-1'>"+ serviceText +"</label><input type='hidden' name='"+ inputType + '[' + id + ']' +"[service_name]' value='"+ serviceText +"'></td>";
                        if(inputType == "excursion")
                        {
                            htmlStr += "<td><label >"+ serviceWeek +"</label><input type='hidden' name='"+ inputType + '[' + id + ']' +"[service_week]' value='"+ serviceWeek +"'></td>";
                        }
                        htmlStr += "<td><span class='input-price-symbol'>"+currencySymbol+"</span><input type='text' autocomplete='off' onkeypress='return keyRestrict(event,\"1234567890.\");' maxlength='13' class='form-control input-price' name='"+ inputType + '[' + id + ']' +"[cost]' value=''></td>";
                        if(inputType == "stdAcc")
                        {
                            htmlStr += "<td><span class='input-price-symbol'>"+currencySymbol+"</span><input type='text' autocomplete='off' onkeypress='return keyRestrict(event,\"1234567890.\");' maxlength='13' class='form-control input-price' name='"+ inputType + '[' + id + ']' +"[extra_night]' value=''></td>";
                        }
                        
                        if(inputType == "activities")
                        {
                            htmlStr += "<td><span class='input-price-symbol'>"+currencySymbol+"</span><input type='text' autocomplete='off' onkeypress='return keyRestrict(event,\"1234567890.\");' maxlength='13' class='form-control input-price' name='"+ inputType + '[' + id + ']' +"[extra_activity]' value=''></td>";
                        }
                        
                        if(inputType == "coursesType")
                        {
                            htmlStr += "<td><span class='input-price-symbol'>"+currencySymbol+"</span><input type='text' autocomplete='off' onkeypress='return keyRestrict(event,\"1234567890.\");' maxlength='13' class='form-control input-price' name='"+ inputType + '[' + id + ']' +"[extra_tuition]' value=''></td>";
                        }
                        
                        htmlStr += "<td><a class='lnkRemove' data-opt-week='"+serviceWeek+"' data-table='#"+btnId+"Table' data-select='#"+btnId+"Select' data-option='"+ id +"' data-tr='tr-"+ btnId + "_"+ id +"' href='javascript:void(0);' title='Remove' data-toggle='tooltip'><i class='fa fa-trash'></i></a></td>";
                        htmlStr += "</tr>";
                    
                    $("#"+btnId+"Table").append(htmlStr);
                    $.validator.addClassRules("input-price", {
                        required: true,
                        nonzero: true
                    },'required.');
                }
            });
            $( "#bodyDiv" ).on( "click", ".lnkRemove", function() {
               var tr_id = $(this).attr("data-tr");
               var pTableId = $(this).attr('data-table');
               $("#"+tr_id).remove();
               $(".tooltip").hide();
               $($(this).attr('data-select')+' option[value="'+$(this).attr('data-option')+'"]').removeAttr('disabled');
            });
            
            var currencySymbol = "";
            var selectBoxId = 0;
            $( "#bodyDiv" ).on( "change", "#selCampus", function() {
                //getCampusExcursion
                var campusId = $(this).val();
                if(parseInt(package_edit_id) == 0)
                {
                    if(parseInt(selectBoxId) == 0){
                        selectBoxId = campusId;
                        $("#btnAddActivityTable .lnkRemove").trigger('click');
                        $("#btnAddExcursionTable .lnkRemove").trigger('click');
                        $("#divCompositionsTable tbody").html('');
                        // load campus excursions
                        $.post( SITE_PATH + "packages/getCampusExcursion",{'campusId':campusId}, function( data ) {
                            $("#btnAddExcursionSelect").html(data);
                        });
                        // load campus activities
                        $.post( SITE_PATH + "packages/getCampusActivities",{'campusId':campusId}, function( data ) {
                            $("#btnAddActivitySelect").html(data);
                        });

                        // set currency for prices //valuta_fattura
                        var currencyText = $("#selCampus option:selected").attr('data-valuta');

                        if(currencyText == "EUR")
                            currencySymbol = "&euro;";
                        else if(currencyText == "GBP")
                            currencySymbol = "&pound;";
                        else if(currencyText == "USD")
                            currencySymbol = "$";
                        $(".input-price-symbol").html(currencySymbol);
                    }
                    else{
                        confirmAction("Are you sure to change campus? It will clear activities, excursions and compositions added.", 
                        function(c)
                        {
                            if(c)
                            {
                                selectBoxId = campusId;
                                $("#btnAddActivityTable .lnkRemove").trigger('click');
                                $("#btnAddExcursionTable .lnkRemove").trigger('click');
                                $("#divCompositionsTable tbody").html('');
                                // load campus excursions
                                $.post( SITE_PATH + "packages/getCampusExcursion",{'campusId':campusId}, function( data ) {
                                    $("#btnAddExcursionSelect").html(data);
                                });
                                // load campus activities
                                $.post( SITE_PATH + "packages/getCampusActivities",{'campusId':campusId}, function( data ) {
                                    $("#btnAddActivitySelect").html(data);
                                });

                                // set currency for prices //valuta_fattura
                                var currencyText = $("#selCampus option:selected").attr('data-valuta');

                                if(currencyText == "EUR")
                                    currencySymbol = "&euro;";
                                else if(currencyText == "GBP")
                                    currencySymbol = "&pound;";
                                else if(currencyText == "USD")
                                    currencySymbol = "$";
                                $(".input-price-symbol").html(currencySymbol);
                            }
                            else{
                                $("#selCampus").val(selectBoxId);
                            }
                        },true,true);
                    }
                }
                else{
                        // load campus excursions
                        $.post( SITE_PATH + "packages/getCampusExcursion",{'campusId':campusId}, function( data ) {
                            $("#btnAddExcursionSelect").html(data);
                        });
                        // load campus activities
                        $.post( SITE_PATH + "packages/getCampusActivities",{'campusId':campusId}, function( data ) {
                            $("#btnAddActivitySelect").html(data);
                        });

                        // set currency for prices //valuta_fattura
                        var currencyText = $("#selCampus option:selected").attr('data-valuta');

                        if(currencyText == "EUR")
                            currencySymbol = "&euro;";
                        else if(currencyText == "GBP")
                            currencySymbol = "&pound;";
                        else if(currencyText == "USD")
                            currencySymbol = "$";
                        $(".input-price-symbol").html(currencySymbol);
                }
                
            });
            
            <?php if($edit_id){
                //print_r($excursionData);die;
                ?>
                $("#selCampus").trigger('change');
            <?php }?>
            
            $( "#txtStartDate" ).datepicker({
				defaultDate: "+1w",
				changeMonth: true,
				changeYear: true,		  
				dateFormat: "dd/mm/yy",		
				numberOfMonths: 1,
				onClose: function( selectedDate ) {
					$( "#txtExpiryDate" ).datepicker( "option", "minDate", selectedDate );
				}
            });
            
            $( "#txtExpiryDate" ).datepicker({
				defaultDate: "+1w",
				changeMonth: true,
				changeYear: true,		  
				dateFormat: "dd/mm/yy",		
				numberOfMonths: 1,
				onClose: function( selectedDate ) {
					$( "#txtStartDate" ).datepicker( "option", "maxDate", selectedDate );
				}
            });
            
            $.validator.addMethod(
                "australianDate",
                function(value, element) {
                    return value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/);
                },
                "Please enter a date in the format dd/mm/yyyy"
            );
                
            $.validator.addMethod(
                "nonzero",
                function(value, element) {
                    if(parseFloat(value) > 0)
                        return true;
                    else
                        return false;
                },
                "Please enter any nonzero value"
            );
            
            $("#frmPackages").validate({
                errorElement:"div",
                ignore: "",
                rules: {
                    "packageWeeks[]":{
                        required: true
                    },
                    selCampus:{
                        required: true
                    },
                    selCategoryProgram:{
                        required: true
                    },
                    txtPackageName:{
                        required: true
                    },
                    txtStartDate:{
                        required: true,
                        australianDate:true
                    },
                    txtExpiryDate:{
                        required: true,
                        australianDate:true
                    },
                    txtExtraGLPrice:{
                        required: function(element){
                          if(parseInt($("#txtFreeGL").val()) > 0)
                            return true;
                          else
                            return false;
                        }
                    },
                    txtFullPrice:{
                        required: true
                    },
                    txtPriceA:{
                        required: true
                    },
                    txtPriceB:{
                        required: true
                    },
                    txtPriceC:{
                        required: true
                    },
                    selRegion: {
                        required: function(element) {
                            return $('#chkValidRegion').is(':checked');
                        }
                    },
                    'selCountry[]': {
                        required: function(element) {
                            return $('#chkValidRegion').is(':checked');
                        }
                    },
                    'selAgents[]': {
                        required: function(element) {
                            return $('#chkValidRegion').is(':checked');
                        }
                    }/*,
                    txtCourseDirectorSalary:{
                        required: true,
                        nonzero:true
                    },
                    txtCampusManagerSalary:{
                        required: true,
                        nonzero:true
                    }*/
                },
                messages: {
                    "packageWeeks[]": "Please select at least one week type",
                    selCampus: "Please select campus",
                    selCategoryProgram: "Please select category program",
                    txtPackageName: "Please enter package name",
                    txtStartDate: "Please select package start date",
                    txtExpiryDate: "Please select package expiry date",
                    txtExtraGLPrice: "Please enter extra gl accomodation price",
                    txtFullPrice: "Please enter full price",
                    txtPriceA: "Please enter price for group a",
                    txtPriceB: "Please enter price for group b",
                    txtPriceC: "Please enter price for group c",
                    selRegion: "Please select region",
                    'selCountry[]': "Please select country",
                    'selAgents[]': "Please select agent",
                    txtCourseDirectorSalary: "Please enter course director salary",
                    txtCampusManagerSalary: "Please enter campus manager salary"
                },
                submitHandler: function(form) {
                    
                    $.each($("input[name='packageWeeks[]']"), function( index, ele ) {
                        if($( ele ).prop( "checked" ) == false)
                        {
                            $("#btnAddExcursionTable .lnkRemove[data-opt-week='"+$(ele).val()+"']").trigger('click');
                        }
                    });
                    form.submit();
                    
                }
            });
           
            $('#chkOneWeek2').on('ifUnchecked', function(event){
                if($("#chkOneWeek3").prop('checked') == true){
                    setTimeout(function(){$("#chkOneWeek2").iCheck('check');},200);
                }
            });
            $('#chkOneWeek1').on('ifUnchecked', function(event){
                if($("#chkOneWeek2").prop('checked') == true){
                    setTimeout(function(){$("#chkOneWeek1").iCheck('check');},200);
                }
            });
            
            $('.chPackageWeeks').on('ifChanged', function(event){
                if($(this).prop('checked') && $(this).val() == '2 Week'){
                    $("#chkOneWeek1").iCheck('check');
                }else if($(this).prop('checked') && $(this).val() == '3 Week'){
                    $("#chkOneWeek1").iCheck('check');
                    $("#chkOneWeek2").iCheck('check');
                }
                
                $("#btnAddExcursionSelectWeek").html("");
                $("input[name='packageWeeks[]']:checked").each( function (i,v) {
                    $("#btnAddExcursionSelectWeek").append("<option value='"+$(v).val()+"'>"+$(v).val()+"</option>");
                });
                
            });
            
            
            
            $( "#bodyDiv" ).on( "blur", ".calPercent", function() {
               var totalCost = $(this).attr('data-tcost');
               var enteredPrice = $(this).val();
               var calPerc = 100 - (totalCost * 100 / enteredPrice);
               ///calPerc = calPerc.toFixed(2);
               calPerc = number_format(calPerc, 2, ',', '.');
               $(this).parent().find('.spanPer').html(calPerc + '%').css('padding-left','7px');
            });
            
            
            
            var allowed = true;
            if(parseInt(package_edit_id))
            {
                allowed = false;
                //trigger calculations
                $(".calPercent").trigger('blur');
            }
            $( "#bodyDiv" ).on( "click", "#btnGenerateComposition", function() {
                var validatedForm = true;
                $.each($(".price-cal-validate .input-price"), function( index, ele ) {
                    if($("#frmPackages").validate().element(ele) == false)
                    {
                        validatedForm = false;
                    }
                });
                if(validatedForm)
                {
                    var formData = $("#frmPackages").serialize();
                    var addedHtml = $("#divCompositionsTable tbody").html();
                    if(allowed == false && addedHtml != '')
                    {
                        confirmAction("Are you sure to re-generate the compositions, it will override all the existing data.", 
                        function(c)
                        {
                            if(c)
                            {
                                $.post( SITE_PATH + "packages/getCompositionsTable",formData, function( data ) {
                                    if(data.result == 1)
                                    {
                                        $("#divCompositionsTable tbody").html(data.htmlStr);
                                        $.validator.addClassRules("input-price", {
                                            required: true,
                                            nonzero: true
                                        },'required.');
                                        allowed = false;
                                        $(".input-price-symbol").html(currencySymbol);
                                        $("#generatedCompositions").val(1);
                                    }
                                    else
                                    {
                                        swal('Error',data.message);
                                    }

                                },'json');
                            }
                        }, true, true);
                    }
                    else{
                            $.post( SITE_PATH + "packages/getCompositionsTable",formData, function( data ) {
                                if(data.result == 1)
                                {
                                    $("#divCompositionsTable tbody").html(data.htmlStr);
                                    $.validator.addClassRules("input-price", {
                                        required: true,
                                        nonzero: true
                                    },'required.');
                                    allowed = false;
                                    $(".input-price-symbol").html(currencySymbol);
                                }
                                else
                                {
                                    swal('Error',data.message);
                                }

                            },'json');
                        }
                }
                else
                {
                    $( ".error[html!='']:first" ).prev().focus();
                }
            });
            $.validator.addClassRules("input-price", {
                required: true,
                nonzero: true
            },'required.');
            
            // valid for location
             $('#chkValidRegion').on('ifChecked', function(event){
                    if($("#collapsedBox .btn-box-tool").attr('data-original-title') == "Expand")
                    {
                        $("#collapsedBox .btn-box-tool").trigger('click');
                        $("#collapsedBox .btn-box-tool").trigger('mouseout');
                    }
             });
         
             $('#selRegion').on('change', function(event){
                 //$("#selCountry")
                 var regionId = $(this).val();
                 if(parseInt(regionId)){
                     var editCountry = "<?php echo $formData['selCountry'];?>";
                     $.post(SITE_PATH + 'packages/loadCountry',{'regionId':regionId,'editCountry':editCountry},function(data){
                         $("#selCountry").html(data);
                         $("#selCountry").trigger('change');
                     });
                 }else{
                     $("#selCountry").html("");
                 }
             });
             
             $("#selRegion").trigger('change');
//             setTimeout(function(){
//                $("#selCountry").trigger('change');
//             },1500);
             // 
             $('#selCountry').on('change', function(event){
                 var countryId = $(this).val();
                 if(countryId){
                     $.post(SITE_PATH + 'packages/loadAgents',{'countryId':countryId,'packageId':package_edit_id},function(data){
                         $("#selAgents").html(data);
                     });
                 }else{
                     $("#selAgents").html("");
                 }
             });
             //if(package_edit_id)
             
            // other charges total
            $(".other-charges").on('blur', function(event){
                var totalCharges = 0;
                $(".other-charges").each(function(i, ele){
                  var chValue = parseFloat($(ele).val());
                  if(!isNaN(chValue))
                  {
                    totalCharges += chValue;
                  }
                });
                totalCharges = Math.round(totalCharges * 100) / 100;
                $("#txtTotalOtherCharges").val(totalCharges);
            });
            $(".staff-charges").on('blur', function(event){
                var totalCharges = 0;
                $(".staff-charges").each(function(i, ele){
                  var chValue = parseFloat($(ele).val());
                  if(!isNaN(chValue))
                  {
                    totalCharges += chValue;
                  }
                });
                totalCharges = Math.round(totalCharges * 100) / 100;
                $("#txtTotalStaffCharges").val(totalCharges);
            });
            
            //trigger blur
            $(".other-charges").trigger('blur');
            $(".staff-charges").trigger('blur');
            
            
            $('.updateExtraValue').on('click', function(event){
                 var servId = $(this).attr('data-serv-id');
                 var servType = $(this).attr('data-serv-type');
                 var extraNightCharges = $("#txt_serv_"+servId).val();
                 
                 if(parseInt(servId))
                 if(parseInt(extraNightCharges) > 0){
                     $.post(SITE_PATH + 'packages/updateServiceExtra',{
                         'servId':servId,
                         'servType':servType,
                         'extraNightCharges':extraNightCharges
                     },function(data){
                         
                     });
                 }else{
                    swal("Alert","Please enter any none-zero value");
                 }
             });
	});
        
</script>
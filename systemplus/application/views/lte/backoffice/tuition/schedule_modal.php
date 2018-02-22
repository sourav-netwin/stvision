
    
<!--    <div style="display: none;" id="dialog_modal_create_class" title="Classes for the day" class="modal windia">-->
 <div id="dialog_modal_create_class" data-backdrop="static" class="modal">
          <div class="modal-dialog modal-lg-95-per">
            <div class="modal-content">
              <div class="modal-header">
                <button aria-label="Close" onclick="$('#dialog_modal_create_class').modal('hide');" class="close" type="button">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">--</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="createClass" class="box box-primary collapsed-box">
                            <div class="box-header with-border text-center">
                                <h3 class="box-title">
                                    <a class="underline" onclick="$('#btmClassCreateTab').trigger('click').trigger('blur');" href="javascript:void(0);"><span id="lblCreateClassHeader">Create new class</span></a>
                                </h3>
                                <div class="box-tools pull-right">
                                    <button id="btmClassCreateTab" type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Expand" data-container="body">
                                    <i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <form action="" id="frmClass" class="validate" method="post">
                                <div class="box-body">
                                <div class="col-sm-6 col-sm-offset-3">
                                    <div class="form-group row">
                                        <label class="col-sm-4 "></label>
                                        <div class="col-sm-8">
                                            <label class="control-label">All fields are mandatory.</label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label" for="lblPickdate">Date</label>
                                        <div class="col-sm-8">
                                            <label id="lblPickdate"></label>
                                            <hidden id="hiddClassDate" name="hiddClassDate" value="" />
                                            <hidden id="hiddMyClassDate" name="hiddMyClassDate" value="" />
                                        </div>
                                    </div>
                                
                                    <div id="forLoading" class="form-group row">
                                        <label class="col-sm-4 control-label" for="lblCampus">Campus</label>
                                        <div class="col-sm-8">
                                            <label id="lblCampus"></label>
                                            <hidden id="hiddCampusId" name="hiddCampusId" value="" />
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label" for="selCourse">Course</label>
                                        <div class="col-sm-8">
                                            <select autocomplete="off" class="required form-control" id="selCourse" name="selCourse"  >
                                                <option value="">Select course</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label" for="txtClassName">Class level</label>
                                        <div class="col-sm-8">
                                            <select autocomplete="off" class="form-control" id="txtClassName" name="txtClassName" >
                                                <option value="">Select class level</option>
                                                <option value="Beginner">Beginner</option>
                                                <option value="Elementary">Elementary</option>
                                                <option value="Lower Intermediate">Lower Intermediate</option>
                                                <option value="Intermediate">Intermediate</option>
                                                <option value="Higher Intermediate">Higher Intermediate</option>
                                                <option value="Advanced">Advanced</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label" for="selClassType">Class type</label>
                                        <div class="col-sm-8">
                                            <select autocomplete="off" class="form-control" id="selClassType" name="selClassType" >
                                                <option value="">Select class type</option>
                                                <option value="Regular">Regular</option>
                                                <option value="Supplement">Supplement</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label" for="txtRoomNumber">Room ID</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="txtRoomNumber" name="txtRoomNumber" class="form-control required alphanumericwithspace" style="max-width:200px;"  maxlength="255" value="" >
                                            <label for="txtRoomNumber" generated="true" class="error" style="right: 268px; top: 0px;"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label" >Students to be assigned</label>
                                        <div class="col-sm-8">
                                            <a class="underline" href="javascript:void(0);" id="lnkStudnetsList">Students list (0)</a>
                                            (Click on link to show list of students.)
                                            <div id="lblStudentsPerRooms"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label" >&nbsp;</label>
                                        <div class="col-sm-8">
                                            <input type="hidden" value="0" name="class_edit_id" id="class_edit_id">
                                            <input type="button" value="Submit" name="btnCreateClass" id="btnCreateClass" class="btn btn-primary">
                                            <input type="reset" value="Cancel" name="btnCancel" id="btnCancel" class="btn btn-danger">
                                            <div id="classMessage"></div>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-12" >
                        <div id="createClass" class="box box-primary">
                            <div class="box-header with-border">
                                <div class="text-center">
                                    <h4 class="box-title">All classes</h4>
                                    <span class="classlisting-header-stats">
                                    <small class="label bg-red mr-right-5" id="lbl-unassigned"></small>
                                    <small class="label bg-red mr-right-5" id="lbl-unassigned-teacher"></small>
                                    </span>
                                </div>
                            </div>
                            <div id="classListingData" class="box-body">
                            </div>
                        </div>
                    </div>
                </div>
                    
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default pull-left" type="button">Close</button>
                    <button id="btnPresenceByWeek" class="btn btn-primary" type="button">Mark teachers presence</button>
                    <button id="btnReplicate" class="btn btn-primary" type="button">Replicate for next day</button>
                    <button id="btnReplicateWithEdit" class="btn btn-primary" type="button">Replicate with edit's</button>
                </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>
        
    <!-- Teacher and room pop-up -->
<!--    <div style="display: none;" id="dialog_modal_teacher_class" data-backdrop="static" title="" class="techerview">-->
        <div id="dialog_modal_teacher_class" data-backdrop="static" class="modal">
          <div class="modal-dialog modal-lg-95-per">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-label="Close" onclick="$('#dialog_modal_teacher_class').modal('hide');$('body').addClass('modal-open');" class="close" type="button">
                    <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Assign teachers</h4>
                </div>
                <div class="modal-body">
                    <div id="createTeacher" class="box box-primary collapsed-box">
                            <div class="box-header with-border text-center">
                                <h3 class="box-title">
                                    <a class="underline" onclick="$('#btmTeacherCreateTab').trigger('click').trigger('blur');" href="javascript:void(0);"><span id="lblNewTeacher">Add new teacher</span></a>
                                </h3>
                                <div class="box-tools pull-right">
                                    <button id="btmTeacherCreateTab" type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Expand" data-container="body">
                                    <i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        <form action="" id="frmTeacher" class="validate" method="post">
                            <div class="row box-body">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="form-group row">
                                        <label class="col-sm-4 "></label>
                                        <div class="col-sm-8">
                                            <label class="control-label">All fields are mandatory.</label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label" for="lblTechCampus">Campus-Course-Date</label>
                                        <div class="col-sm-8">
                                            <label id="lblTechCampus"></label>-<label id="lblTechCourse"></label>-<label id="lblTechDate"></label>
                                            <br /><label id="courseHoursStats" title="Assigned hours / Total hours">Course hours: --/--</label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label" for="lblTechCampus">Class level</label>
                                        <div class="col-sm-8">
                                            <label id="lblClass"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label" for="selTeacher">Teacher</label>
                                        <div class="col-sm-8">
                                            <select class="required form-control" id="selTeacher" name="selTeacher"  >
                                                <option value="">Select teacher</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label" for="txtFromTime">From time</label>
                                        <div class="col-sm-8">
                                            <input type="text" style="position: absolute; width: 0px;border: none;padding: 0;" />
                                            <input type="text" id="txtFromTime" data-mask="00:00" placeholder="hh:mm" name="txtFromTime" class="required form-control" onkeypress="return keyRestrict(event,'1234567890');"  style="max-width:200px;"  maxlength="8" value="" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label" for="txtToTime">To time</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="txtToTime" data-mask="00:00" placeholder="hh:mm" name="txtToTime" class="required form-control" onkeypress="return keyRestrict(event,'1234567890');" style="max-width:200px;"  maxlength="8" value="" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-offset-4 col-sm-8">
                                            <input type="hidden" value="0" name="lesson_edit_id" id="lesson_edit_id">
                                                <input type="hidden" value="0" name="hidd_class_id" id="hidd_class_id">
                                                <input type="hidden" value="0" name="hidd_course_id" id="hidd_course_id">
                                                <input type="button" value="Submit" name="btnAddTeacher" id="btnAddTeacher" class="btn btn-primary">
                                                <input type="reset" value="Cancel" name="btnTechCancel" id="btnTechCancel" class="btn btn-danger">
                                                <div id="teacherMessage"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="teacherListing" class="box box-primary">
                        <div class="box-header with-border">
                                <div class="text-center">
                                    <h4 class="box-title">All teachers</h4>
                                </div>
                        </div>
                        <div id="teacherListingData" class="box-body"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="$('#dialog_modal_teacher_class').modal('hide');$('body').addClass('modal-open');" class="btn btn-default pull-left" type="button">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
            </div>
          <!-- /.modal-dialog -->
    </div>

        <!-- THIS IS MODAL TO MARK TEACHER PRESENCE --->
        <div id="dialog_modal_presence_of_teacher" data-backdrop="static" class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Mark presence of teacher
                            <button aria-label="Close" onclick="$('#dialog_modal_presence_of_teacher').modal('hide');$('body').addClass('modal-open')" class="close" type="button">
                                <span aria-hidden="true">×</span></button>
                        </h4>
                    </div>
                    <div id="presenceDiv" class="modal-body">
                        <form action="" id="frmPresence" class="validate myform" method="post">
                            <div class="form-group row">
                                <label class="col-sm-3 control-label" for="lblPresenceClassTeacher">Class-Teacher</label>
                                <div class="col-sm-9">
                                    <span id="lblPresenceClassTeacher"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label" for="chkPresence">Mark as presence</label>
                                <div class="col-sm-9">
                                    <label><input type="checkbox" id="chkPresence" name="chkPresence" value="1" />
                                        Mark teacher as present.</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label" for="txtPrensenceNotes">Notes</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" cols="5" rows="8" maxlength="250" id="txtPrensenceNotes" name="txtPrensenceNotes"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-data col-sm-9 col-sm-offset-3">
                                    <input type="hidden" value="0" name="presence_lesson_id" id="presence_lesson_id">
                                    <input type="button" value="Submit" name="btnPresence" id="btnPresence" class="btn btn-primary">
                                    <input type="reset" value="Cancel" name="btnPresenceCancel" id="btnPresenceCancel" class="btn btn-danger">
                                    <div id="presenceMessage"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button onclick="$('#dialog_modal_presence_of_teacher').modal('hide');$('body').addClass('modal-open');" class="btn btn-default pull-left" type="button">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
                </div>
            <!-- /.modal-dialog -->
        </div>
            
        
        <!-- THIS IS MODAL TO SHOW STUDENTS LISTING FROM CREATE CLASS --->
<!--        <div style="display: none;" id="" title="Students list" class="windia-students">-->
        <div id="dialog_modal_students_list" data-backdrop="static" class="modal">
            <div class="modal-dialog modal-lg-95-per">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Students list
                        <button aria-label="Close" onclick="$('#dialog_modal_students_list').modal('hide');$('body').addClass('modal-open')" class="close" type="button">
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
                    <div id="studentsDiv" class="modal-body">
                        <div id="studentsList"></div>
                    </div>
                    <div class="modal-footer">
                        <button  onclick="$('#dialog_modal_students_list').modal('hide');$('body').addClass('modal-open');"  class="btn btn-default pull-left" type="button">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        
        <!-- THIS IS PRINT STUDENT LIST MODAL -->
            <div id="dialog_modal_students_list_print" data-backdrop="static" class="modal">
                <div class="modal-dialog modal-lg-95-per">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">&nbsp;
                                <button aria-label="Close" onclick="$('#dialog_modal_students_list_print').modal('hide');$('body').addClass('modal-open')" class="close" type="button">
                                    <span aria-hidden="true">×</span></button>
                            </h4>
                        </div>
                        <div id="studentsListPrint" class="modal-body">
                        </div>
                        <div class="modal-footer">
                            <button  onclick="$('#dialog_modal_students_list_print').modal('hide');$('body').addClass('modal-open')"  class="btn btn-default pull-left" type="button">Close</button>
                            <button id="btnPrintStudents" class="btn btn-primary" type="button"><i class="fa fa-print"></i>&nbsp;Print</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
    
        <!-- THIS IS TEACHER VIEW DETAILS MODAL -->
            <div id="dialog_modal_teacher_view" data-backdrop="static" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Teacher detail
                                <button aria-label="Close" onclick="$('#dialog_modal_teacher_view').modal('hide');$('body').addClass('modal-open')" class="close" type="button">
                                    <span aria-hidden="true">×</span></button>
                            </h4>
                        </div>
                        <div id="viewTeacherModalBody" class="modal-body">
                        </div>
                        <div class="modal-footer">
                            <button  onclick="$('#dialog_modal_teacher_view').modal('hide');$('body').addClass('modal-open')"  class="btn btn-default pull-left" type="button">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        
        
        <!-- THIS IS REPLICATION DETAILS MODAL -->
        <div id="dialog_modal_replication" data-backdrop="static" class="modal">
            <div class="modal-dialog modal-lg-95-per">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><label>Replication process</label>
                            <button aria-label="Close" onclick="$('#dialog_modal_replication').modal('hide');$('body').addClass('modal-open')" class="close" type="button">
                                <span aria-hidden="true">×</span></button>
                        </h4>
                    </div>
                    <div id="replicationModal" class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button  onclick="$('#dialog_modal_replication').modal('hide');$('body').addClass('modal-open')"  class="btn btn-default pull-left" type="button">Close</button>
                        <span style="padding:5px;margin-top: 2px;" class="bg-purple mr-left-10 pull-left">
                            <i class="fa fa-info-circle mr-right-5"></i>If there are no students present for the next day, replication process will remove them and class will be replicated with the available students and other data.
                        </span>
                        <button id="btnReplicateWithEditSubmit" class="btn btn-primary" type="button"><i class="fa fa-copy"></i>&nbsp;Replicate</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <script src="<?php echo LTE;?>plugins/mask/jquery.mask.min.js"></script>
        
        <!-- THIS IS MARK TEACHERS PRESENCE FOR WEEK DETAILS MODAL -->
        <div id="dialog_modal_presence_of_teacher_for_week" data-backdrop="static" class="modal">
            <div class="modal-dialog modal-lg-95-per">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Mark teachers presence  
                            <button aria-label="Close" onclick="$('#dialog_modal_presence_of_teacher_for_week').modal('hide');$('body').addClass('modal-open')" class="close" type="button">
                                <span aria-hidden="true">×</span>
                            </button>
                            <br />
                            <button id="btnMarkPresenceForWeekPrevious" class="btn btn-primary btn-xs" data-toggle="tooltip" title="click to load previous day data" type="button"> << Previous </i></button>
                            <label id="currentDate"> -- </label>
                            <input type="hidden" id="mtpCurrentDate" value="" />
                            <button id="btnMarkPresenceForWeekNext" class="btn btn-primary btn-xs" data-toggle="tooltip" title="click to load next day data" type="button"> Next >> </i></button>
                        </h4>
                    </div>
                    <div id="presenceForWeekModal" class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button  onclick="$('#dialog_modal_presence_of_teacher_for_week').modal('hide');$('body').addClass('modal-open')"  class="btn btn-default pull-left" type="button">Close</button>
                        <button id="btnMarkPresenceForWeek" class="btn btn-primary" type="button"><i class="fa fa-check-circle-o"></i>&nbsp;Mark teachers presence</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
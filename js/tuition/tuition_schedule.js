$(document).ready(function() {
                var diaH = $(window).height() * 0.90;
                var diaW = $(window).width() * 0.90;      
                
                $( "li#mnutuition" ).addClass("current");
		$( "li#mnutuition a" ).addClass("open");		
		$( "li#mnutuition ul.sub" ).css('display','block');	
		$( "li#mnutuition ul.sub li#mnutuition_4" ).addClass("current");	
                
                $( "#txtCalFromDate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",		
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				$(".txtCalFromDate").val(selectedDate);
                                $( "#txtCalToDate" ).datepicker( "option", "minDate", selectedDate );
                                //$( "#txtCalToDate" ).datepicker( "option", "maxDate", "+1M" );
                                //maxDate: "+1M +10D"
                                var from = selectedDate.split("/");
                                var f = new Date(from[2], from[1] - 1, from[0]);
                                var sDate = new Date(f);
                                sDate.setMonth(sDate.getMonth() + 1);
                                $( "#txtCalToDate" ).datepicker( "option", "maxDate", sDate );
			}
                });

                $( "#txtCalToDate" ).datepicker({
                            defaultDate: "+1w",
                            changeMonth: true,
                            changeYear: true,		  
                            dateFormat: "dd/mm/yy",		
                            numberOfMonths: 1,
                            onClose: function( selectedDate ) {
                                    $(".txtCalToDate").val(selectedDate);
                                    $( "#txtCalFromDate" ).datepicker( "option", "maxDate", selectedDate );
                            }
                });
                
                $('#txtFromTime').timepicker({
                    hourMin: 7
                    //hourMax: 19
//                    minTime: '7:00 am',
//                    maxTime: '7:00 pm'
//                            onClose: function( selectedDate ) {
//                                    $('#txtFromTime').val(selectedDate);
//                                    $( "#txtToTime" ).timepicker( "option", "minTime", selectedDate );
//                            }
                });
                
                $('#txtToTime').timepicker({
                    hourMin: 7
                    //hourMax: 19
//                            onClose: function( selectedDate ) {
//                                    $('#txtToTime').val(selectedDate);
//                                    $( "#txtFromTime" ).timepicker( "option", "maxTime", selectedDate );
//                            }
                });
                
                
//                if(parseInt(diaH) < 850)
//                    diaH = 850;
                $( ".windia" ).dialog({
                            autoOpen: false,
                            modal: true,
                            hide: "",
                            show: "",
                            width : '92%',
                            height : diaH,
                            buttons: [{
                                    text: "Close",
                                    click: function() { $(this).dialog("close"); }
                                    },
                                    {
                                    text: "Replicate for next day",
                                    click: function() {
                                        if(confirm("Are you sure to replicate all records to next day?"))
                                        {
                                            var classDate = $("#hiddMyClassDate").val();
                                            var campusId = $("#hiddCampusId").val();
                                            var overwrite = 0;
                                            var teacherCheck = 1;
                                            // check teaches
                                            $.post( SITE_PATH + "tuitions/checkTeachersForReplication",{'campusId':campusId,'classDate':classDate}, function( data ) {
                                                if(data.allowed == '0')
                                                {
                                                    if(!confirm("For next day 'one or more' teacher(s) are missing. \nIf you want to replicate data with available teacher(s) then click on 'Ok' otherwise click on 'Cancel'."))
                                                        teacherCheck = 0;
                                                }
                                                if(teacherCheck){
                                                    myloading(1);
                                                    $.post( SITE_PATH + "tuitions/replicate",{'campusId':campusId,'classDate':classDate,'overwrite':overwrite}, function( data ) {
                                                        if(parseInt(data.status) == 2)
                                                        {
                                                            myloading(0);
                                                            if(confirm(data.message + "\nTo overwrite existing data click on 'Ok' otherwise click on 'Cancel'. \nBe sure if you click on 'Ok' this can't be undone.\n\n")){
                                                                overwrite = 1;
                                                                myloading(1);
                                                                $.post( SITE_PATH + "tuitions/replicate",{'campusId':campusId,'classDate':classDate,'overwrite':overwrite}, function( dataOverwrite ) {
                                                                    alert(dataOverwrite.message);
                                                                    refreshCell(data.cellId);
                                                                    myloading(0);
                                                                },'json'); 
                                                            }
                                                        }
                                                        else
                                                        {
                                                            alert(data.message);
                                                            refreshCell(data.cellId);
                                                            myloading(0);
                                                        }
                                                    },'json');
                                                }
                                            },'json'); 
                                        }
                                        }
                                    }
                            ],
                            close: function( event, ui ) {
                                refreshCell(plusid);
                            },
                            open: function( event, ui ) {
                                $("#classListingData").css('height',(diaH - 160));
                            }
                            
                            
		});
                
                var refreshCell = function (id){
                    var dateS = $("#"+id).attr('data-book-date');
                    var campusId = $("#"+id).attr('data-campus-id');
                    $.post( SITE_PATH + "tuitions/getTodaysBookingsAjax",{'campusId':campusId,'dateS':dateS}, function( data ) {
                        $("#"+id).parent().find('.abook').html(data.bookingAssigned);
                        $("#"+id).parent().find('.pbook').html(data.bookingForDay);
                    },'json'); 
                };
                
//                if(parseInt(diaH) < 850)
//                    diaH = 850;
                $( ".techerview" ).dialog({
                            autoOpen: false,
                            modal: true,
                            hide: "",
                            show: "",
                            width : '90%',
                            height : diaH,
                            buttons: [{
                                    text: "Close",
                                    click: function() { 
                                        $(this).dialog("close"); 
                                    }
                            }],
                            close: function( event, ui ) {
                                var dateOfClass = $("#hidd-class-date").val();    
                                var campusId = $("#hidd-class-campus-id").val();   
                                var loadingDiv = "<div style='width:700px;text-align:center;'><div class='showloadingClasslisting'></div></div>";
                                $("#classListingData").html(loadingDiv);
                                $.post( SITE_PATH + "tuitions/getClassListing",{'campusId':campusId,'classDate':dateOfClass}, function( data ) {
                                    $("#classListingData").html(data);
                                    showStudentsUnAssigned();
                                }); 
                            },
                            open: function( event, ui ) {
                                $("#dialog_modal_teacher_class").css('height',(diaH - 160));
                                $("#dialog_modal_teacher_class").parent().css('top','30px');
                                //$("#teacherListingData").css('height',(diaH - 200));
                            }
		});
                
                $("#btnCancel").click(function(){
                    $("#class_edit_id").val('0');
                    $("#lnkStudnetsList").html('Students list (0)');
                    $("#lblCreateClassHeader").html("Create new class");
                    $("#classMessage").html('');
                    $("#classMessage").removeClass('tuition_success');
                    $("#classMessage").removeClass('tuition_error');
                    glob_bookings = [];
                });
                var plusid = 0; // THIS IS FOR REFRESH CELL DATA AFTER POPUP CLOSE.
                $( "body" ).on( "click", ".dialogbtn", function() {
                        plusid = $(this).attr('id');
                        var pickdate = $(this).attr('data-pickdate');
                        var dateOfClass = $(this).attr('data-book-date');
                        var pickcampus = $(this).attr('data-campus');
                        var campusId = $(this).attr('data-campus-id');
                        $("#lblPickdate").html(pickdate);
                        $("#lblCampus").html(pickcampus);
                        $("#lblTechDate").html(pickdate);
                        $("#lblTechCampus").html(pickcampus);
                        $("#hiddCampusId").val(campusId);
                        $("#hiddClassDate").val(pickdate);
                        $("#hiddMyClassDate").val(dateOfClass);
                        $( "#dialog_modal_create_class" ).dialog("open");
                        $("#ui-dialog-title-dialog_modal_create_class").html('Classes for the day ' + pickdate + ' - ' + pickcampus);
                        $("#btnCancel").trigger('click');
                        // load courses
                        $.post( SITE_PATH + "tuitions/getCourses",{'campusId':campusId}, function( data ) {
                            $("#selCourse").html(data);
                            $("#selCourse").trigger("liszt:updated");
                        });        
                        
// load students for the campus
//                        $.post( SITE_PATH + "tuitions/getCampusStudents",{'campusId':campusId,'dateOfClass':dateOfClass}, function( data ) {
//                            $("#studentsList").html(data);
//                        }); 
                                               
                        // load bookings for campus on day
//                        $.post( SITE_PATH + "tuitions/getBookings",{'campusId':campusId,'dateOfClass':dateOfClass}, function( data ) {
//                            $("#selBookings").html(data);
//                            $("#selBookings").trigger("liszt:updated");
//                        }); 
                        
                        // load class listing for the day
                        var loadingDiv = "<div style='width:700px;text-align:center;'><div class='showloadingClasslisting'></div></div>";
                        $("#classListingData").html(loadingDiv);
                        $.post( SITE_PATH + "tuitions/getClassListing",{'campusId':campusId,'classDate':dateOfClass}, function( data ) {
                            $("#classListingData").html(data);
                            showStudentsUnAssigned();
                        }); 
                        
                        
                        // load available rooms and students per room
                        $.post( SITE_PATH + "tuitions/getAvailableRoomsStudents",{'campusId':campusId,'classDate':dateOfClass}, function( data ) {
                            if(parseInt(data.result))
                            {
                                $("#lblStudentsPerRooms").html("<strong>"+ data.numberOfRooms + "</strong> rooms allotted in "+ pickcampus +" campus and capacity of each room is <strong>"+data.studentsPerRoom + "</strong> students.");
                            }
                            else
                                $("#lblStudentsPerRooms").html(data.message);
                        },'json'); 
                        
                        
                        return false;
		});
                
                // students list
                $( "body" ).on( "click", "#lnkStudnetsList", function() {
                    var courseId = $("#selCourse").val();    
                    var class_edit_id = $("#class_edit_id").val();    
                    var hiddCampusId = $("#hiddCampusId").val();  
                    var hiddMyClassDate = $("#hiddMyClassDate").val(); 
                    if(parseInt(class_edit_id))
                    {
                        $("#dialog_modal_students_list").dialog("open");
                    }
                    else
                    {
                        if(parseInt(courseId))
                        {
                            var loadingDiv = "<div class='showloading'></div>";
                            $("#hidd_datatable").remove();
                            $("#studentsList").html(loadingDiv);
                            // load students for the campus
                            $.post( SITE_PATH + "tuitions/getCampusStudents",{'campusId':hiddCampusId,'dateOfClass':hiddMyClassDate,'courseId':courseId,'class_edit_id':class_edit_id}, function( data ) {
                                
                                $("#studentsList").html(data);
                                // ! Table
                                // Initialize DataTables for dynamic tables
                                var dataTableById = $("#hidd_datatable").val();
                                //$('table.stdtable').table();
                                for (i = 0; i < glob_bookings.length; i++) {
                                    $("#chk_"+glob_bookings[i]).prop('checked',true);
                                }
                                if($("#"+dataTableById))
                                    $('#'+ dataTableById).table();
                                $("#studentsList select").chosen();
                            }); 
                            $("#dialog_modal_students_list").dialog("open");
                        }
                        else
                            alert('Please select course first.');
                    }
                    
                });
                
                
                $( "body" ).on( "change", ".chkStudents", function() {
                    var bookings = [];
                    $("input:checkbox[class=chkStudents]:checked").each(function(){
                        bookings.push($(this).attr('data-std-id'));
                    });
                    glob_bookings = glob_bookings.concat(bookings).unique();
                    $("input:checkbox[class=chkStudents]").each(function(){
                        if(!$(this).prop('checked'))
                            glob_bookings.removeFromArray($(this).attr('data-std-id'));
                    });
                    $("#lnkStudnetsList").html("Students list ("+ glob_bookings.length +")");
                });
                
                var glob_bookings = [];
                Array.prototype.unique = function() {
                    var a = this.concat();
                    for(var i=0; i<a.length; ++i) {
                        for(var j=i+1; j<a.length; ++j) {
                            if(a[i] === a[j])
                                a.splice(j--, 1);
                        }
                    }
                    return a;
                };
                
                if(!Array.prototype.indexOf) {
                    Array.prototype.indexOf = function(what, i) {
                        i = i || 0;
                        var L = this.length;
                        while (i < L) {
                            if(this[i] === what) return i;
                            ++i;
                        }
                        return -1;
                    };
                }
                
                Array.prototype.removeFromArray = function() {
                    var what, a = arguments, L = a.length, ax;
                    while (L && this.length) {
                        what = a[--L];
                        while ((ax = this.indexOf(what)) !== -1) {
                            this.splice(ax, 1);
                        }
                    }
                    return this;
                };

                $("#btnCreateClass").click(function(){
                    var courseId = $("#selCourse").val();    
                    var hiddClassDate = $("#hiddClassDate").val();    
                    var hiddCampusId = $("#hiddCampusId").val();    
                    var classname = $("#txtClassName").val();    
                    var roomNumber = $("#txtRoomNumber").val();    
                    //var bookings = $("#selBookings").val();  
                    var bookings = glob_bookings;
//                    $("input:checkbox[class=chkStudents]:checked").each(function(){
//                        bookings.push($(this).attr('data-std-id'));
//                    });
                    
//                    console.log("glob_bookings:" + glob_bookings);
//                    console.log("bookings:" + bookings);
                    
                    var classId = $("#class_edit_id").val();
                    $.post( SITE_PATH + "tuitions/createclass",{'classId':classId,'classDate':hiddClassDate,'campusId':hiddCampusId,'courseId':courseId,'classname':classname,'roomNumber':roomNumber,'bookings':bookings}, function( data ) {
                        if(parseInt(data.result)){
                            $("#btnCancel").trigger('click');
                            $("#classMessage").html(data.message);
                            $("#classMessage").switchClass('tuition_error','tuition_success');
                            $("input:checkbox[class=chkStudents]:checked").each(function(){
                                $(this).prop('checked',false);
                            });
                            // load class listing for the day
                            $(".classview").remove();
                            var hiddMyClassDate = $("#hiddMyClassDate").val(); 
                            var loadingDiv = "<div style='width:700px;text-align:center;'><div class='showloadingClasslisting'></div></div>";
                            $("#classListingData").html(loadingDiv);
                            $.post( SITE_PATH + "tuitions/getClassListing",{'campusId':hiddCampusId,'classDate':hiddMyClassDate}, function( data ) {
                                $("#classListingData").html(data);
                                showStudentsUnAssigned();
                            });
                        }
                        else
                        {
                            $("#classMessage").html(data.message);
                            $("#classMessage").switchClass('tuition_success','tuition_error');
                        }
                    },'json'); 

                });
                
                
                $( "body" ).on( "click", ".editClass", function() {
                    var loadingDiv = "<div id='loadingBox' class='showloading'></div>";
                    $("#forLoading").prepend(loadingDiv);
                        $(".chkStudents").prop('checked', false);
                        var classId = $(this).attr('data-id');
                        var class_edit_id = classId;    
                        $.post( SITE_PATH + "tuitions/getSingleClass",{'classId':classId}, function( data ) {
                            if(parseInt(data.result))
                            {
                                var classDetail = data.classDetail[0];
                                var idsArr = [];
                                if(classDetail.booking_ids)
                                    idsArr = classDetail.booking_ids.split(',');
                                glob_bookings = idsArr;
                                $("#txtClassName").val(classDetail.class_name);
                                $("#txtClassName").trigger("liszt:updated");
                                $("#txtRoomNumber").val(classDetail.class_room_number);
                                $("#class_edit_id").val(classId);
                                $("#lblCreateClassHeader").html("Update class");
                                $("#selCourse").val(classDetail.class_campus_course_id);
                                $("#selCourse").trigger("liszt:updated");
                                //$("#selBookings").val(idsArr);
                                //$("#selBookings").trigger("liszt:updated");
                                
                                // load students for the campus
                                var hiddCampusId = $("#hiddCampusId").val();  
                                var hiddCourseId = classDetail.class_campus_course_id;  
                                var hiddMyClassDate = $("#hiddMyClassDate").val(); 
                                $.post( SITE_PATH + "tuitions/getCampusStudents",{'classId':classId,'campusId':hiddCampusId,'dateOfClass':hiddMyClassDate,'courseId':hiddCourseId,'class_edit_id':class_edit_id}, function( data ) {
                                    $("#hidd_datatable").remove();
                                    $("#studentsList").html(data);
                                    for (i = 0; i < idsArr.length; i++) {
                                        $("#chk_" + idsArr[i]).prop('checked', true);
                                    }
                                    $(".chkStudents").trigger('change');
                                    // ! Table
                                    // Initialize DataTables for dynamic tables
                                    //var oTable = $('table.stdtable').dataTable();
                                    //var ott = TableTools.fnGetInstance('tableSearchResults');
                                    //if ( typeof ott != 'undefinded' && ott != null) ott.fnSelectNone();
                                    //oTable.fnClearTable();
                                   // oTable.fnDestroy();
                                    //oTable.fnAddData('{}');
                                    //oTable.fnDraw();
                                    
                                    var dataTableById = $("#hidd_datatable").val();
                                    //$('table.stdtable').table();
                                    $('#'+ dataTableById).table();
                                    $("#loadingBox").remove();
                                }); 
                            }
                        },'json');
                });
                
                $( "body" ).on( "click", ".deleteClass", function() {
                        var classId = $(this).attr('data-id');
                        if(confirm("Are are you sure to delete this class?"))
                        {
                            $.post( SITE_PATH + "tuitions/deleteClass",{'classId':classId}, function( data ) {
                                if(parseInt(data.result))
                                {
                                    alert(data.message);
                                    var hiddCampusId = $("#hiddCampusId").val();    
                                    // load class listing for the day
                                    var hiddMyClassDate = $("#hiddMyClassDate").val(); 
                                    var loadingDiv = "<div style='width:700px;text-align:center;'><div class='showloadingClasslisting'></div></div>";
                                    $("#classListingData").html(loadingDiv);
                                    $.post( SITE_PATH + "tuitions/getClassListing",{'campusId':hiddCampusId,'classDate':hiddMyClassDate}, function( data ) {
                                        $("#classListingData").html(data);
                                        showStudentsUnAssigned();
                                    });
                                }
                                else
                                    alert(data.message);
                            },'json');
                        }
                        
                });
                
                
                
                $("#btnCalShow").click(function(){
                    var calFromDate = $("#txtCalFromDate").val();
                     calFromDate = calFromDate.replace('/', "-");
                     calFromDate = calFromDate.replace('/', "-");
                     calFromDate = encodeURIComponent(calFromDate);
                    var calToDate = $("#txtCalToDate").val();
                     calToDate = calToDate.replace('/', "-");
                     calToDate = calToDate.replace('/', "-");
                     calToDate = encodeURIComponent(calToDate);
                    window.location.href = SITE_PATH + 'tuitions/index/' + calFromDate + '/' + calToDate;
                });
                
                
                $( "body" ).on( "click", ".assign_teacher_room", function() {
                    $("#btnTechCancel").trigger('click'); 
                        var campusId = $("#hiddCampusId").val();
                        var durationDate = $("#hiddMyClassDate").val();
                        var classId = $(this).attr('data-id');
                        var courseId = $(this).attr('data-course-id');
                        var courseName = $(this).attr('data-coursename');
                        var className = $(this).attr('data-class');
                        $("#dialog_modal_teacher_class").dialog("open");
                        $("#lblTechCourse").html(courseName);
                        $("#lblClass").html(className +" #"+ classId);
                        $("#hidd_class_id").val(classId);
                        $("#hidd_course_id").val(courseId);

                        $.post( SITE_PATH + "tuitions/getCampusTeachers",{'campusId':campusId,'durationDate':durationDate}, function( data ) {
                            $("#selTeacher").html(data);
                            $("#selTeacher").trigger("liszt:updated");
                        });
                        
                        // load teacher listing for class
                        $.post( SITE_PATH + "tuitions/getTeacherListing",{'classId':classId}, function( data ) {
                            $(".teacherdetailview").remove();
                            $("#teacherListingData").html(data);
                            teacherListed();
                        });
                        
                });
                
                
                $( "body" ).on( "click", "#btnAddTeacher", function() {
                    $("#teacherMessage").html('');
                    $("#teacherMessage").removeClass('tuition_success');
                    $("#teacherMessage").removeClass('tuition_error');
                    
                    var clId = $("#lesson_edit_id").val();
                    var classDate = $("#hiddClassDate").val();
                    var classId = $("#hidd_class_id").val();
                    var teacherId = $("#selTeacher").val();
                    var courseId = $("#hidd_course_id").val();
                    var txtFromTime = $("#txtFromTime").val();
                    var txtToTime = $("#txtToTime").val();
                    $.post( SITE_PATH + "tuitions/addteacher",{'clId':clId,'classDate':classDate,'classId':classId,'teacherId':teacherId,'courseId':courseId,'txtFromTime':txtFromTime,'txtToTime':txtToTime}, function( data ) {
                        if(parseInt(data.result)){
                            $("#btnTechCancel").trigger('click');
                            $("#teacherMessage").html(data.message);
                            $("#teacherMessage").switchClass('tuition_error','tuition_success');
                            // load teacher listing for class
                            $.post( SITE_PATH + "tuitions/getTeacherListing",{'classId':classId}, function( data ) {
                                $(".teacherdetailview").remove();
                                $("#teacherListingData").html(data);
                                teacherListed();
                            });
                        }
                        else
                        {
                            $("#teacherMessage").html(data.message);
                            $("#teacherMessage").switchClass('tuition_success','tuition_error');
                        }
                    },'json'); 

                });
                
                $("#btnTechCancel").click(function(){
                    $("#lesson_edit_id").val('0');
                    $("#lblNewTeacher").html("Add new teacher");
                    $("#teacherMessage").html('');
                    $("#teacherMessage").removeClass('tuition_success');
                    $("#teacherMessage").removeClass('tuition_error');
                });
                
                
                $( "body" ).on( "click", ".editTeacher", function() {
                    var lesson_edit_id = $(this).attr('data-id');
                    var teacher_id = $(this).attr('data-teach-id');
                    var from_time = $(this).attr('data-from-time');
                    var to_time = $(this).attr('data-to-time');
                    
                    $("#selTeacher").val(teacher_id);
                    $("#selTeacher").trigger("liszt:updated");
                    $("#txtFromTime").val(from_time);
                    $("#txtToTime").val(to_time);
                    $("#lesson_edit_id").val(lesson_edit_id);
                    $("#lblNewTeacher").html("Update teacher");
                });
                
                $( "body" ).on( "click", ".deleteTeacher", function() {
                    var clId = $(this).attr('data-id');
                    if(confirm("Are you sure to remove this teacher and lesson."))
                    {
                        $.post( SITE_PATH + "tuitions/deleteTeacher",{'clId':clId}, function( data ) {
                            if(parseInt(data.result))
                            {
                                alert(data.message);
                                var classId = $("#hidd_class_id").val();    
                                // load teacher listing for class
                                $.post( SITE_PATH + "tuitions/getTeacherListing",{'classId':classId}, function( data ) {
                                    $(".teacherdetailview").remove();
                                    $("#teacherListingData").html(data);
                                    teacherListed();
                                });
                            }
                            else
                                alert(data.message);
                        },'json');
                    }
                });
                
                $( "body" ).on( "click", ".presence_of_teacher", function() {
                    $("#dialog_modal_presence_of_teacher").dialog("open");
                    //$("#lblPresenceTeacher").html($("#lblTechCampus").html()+'-'+$("#lblTechCourse").html()+'-'+$("#lblTechDate").html());
                    var clId = $(this).attr('data-id');
                    $("#presence_lesson_id").val(clId);
                    $("#btnPresenceCancel").trigger('click'); // get lession detail
                });
                
                $( "body" ).on( "click", "#btnPresence", function() {
                    $("#presenceMessage").html('');
                    $("#presenceMessage").removeClass('tuition_success');
                    $("#presenceMessage").removeClass('tuition_error');
                    
                    var clId = $("#presence_lesson_id").val();
                    var presence = 0;
                    var presentStatus = "absent";
                    if($("#chkPresence").prop('checked'))
                    {
                        presence = 1;
                        presentStatus = "present";
                    }
                    var prensenceNotes = $("#txtPrensenceNotes").val();
                    
                    if(prensenceNotes == "" && presence == 0)
                    {
                        $("#presenceMessage").html("Please enter notes to submit");
                        $("#presenceMessage").switchClass('tuition_success','tuition_error');
                    }
                    else {
                        var allowedUpdate = true;
                        if(parseInt(SUSER) != 100)
                        {
                            allowedUpdate = confirm("Are you sure to mark this teacher as "+ presentStatus +"? You can not modify this information again.");
                        }
                        if(allowedUpdate)
                        $.post( SITE_PATH + "tuitions/updateLesson",{'clId':clId,'presence':presence,'prensenceNotes':prensenceNotes}, function( data ) {
                            if(parseInt(data.result))
                            {
                                $("#presenceMessage").html(data.message);
                                $("#presenceMessage").switchClass('tuition_error','tuition_success');
                                if(parseInt(SUSER) != 100)
                                    $("#btnPresence").attr('disabled','disabled');
                            }
                            else
                            {
                                $("#presenceMessage").html(data.message);
                                $("#presenceMessage").switchClass('tuition_success','tuition_error');
                                $("#txtPrensenceNotes").focus();
                            }
                        },'json');
                    }
                    
                });
                
                $("#btnPresenceCancel").click(function(){
                    $("#presenceMessage").html('');
                    $("#presenceMessage").removeClass('tuition_success');
                    $("#presenceMessage").removeClass('tuition_error');
                    $("#btnPresence").removeAttr('disabled');
                    var clId = $("#presence_lesson_id").val();
                    $.post( SITE_PATH + "tuitions/getTeacherDetail",{'clId':clId}, function( data ) {
                        if(parseInt(data.result))
                        {
                            var teacherRow = data.teacherRow;
                            if(parseInt(teacherRow.presence_of_teacher))
                            {
                                $("#chkPresence").prop('checked',true);
//                                if(parseInt(SUSER) != 100)
//                                    $("#btnPresence").attr('disabled','disabled');
                            }
                            else
                            {
                                $("#chkPresence").prop('checked',false);
                            }
                            //cl_course_director_marked
                            if(parseInt(teacherRow.cl_course_director_marked))
                            {
                                if(parseInt(SUSER) != 100)
                                    $("#btnPresence").attr('disabled','disabled');
                            }
                            
                            $("#txtPrensenceNotes").val(teacherRow.notes);
                            
                            $("#lblPresenceClassTeacher").html(teacherRow.class_name + '-' + teacherRow.teacher_name);
                        }
                        else
                        {
                            alert(data.message);
                        }
                    },'json');
                });
                
                $.validator.addMethod("alphanumericwithspace", function(value, element) {
                    return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
                }, "Only letters, numbers, or dashes are allowed.");
                
                
            $( "body" ).on( "click", ".dialogbtnprint", function() {
                var hiddCampusId = $("#hiddCampusId").val();  
                var hiddMyClassDate = $("#hiddMyClassDate").val(); 
                var classId = $(this).attr('data-id'); 
                var courseId = $(this).attr('data-course-id'); 
                $.post( SITE_PATH + "tuitions/getCampusStudentsForPrint",{'campusId':hiddCampusId,'dateOfClass':hiddMyClassDate,'courseId':courseId,'classId':classId}, function( data ) {
                    $("#studentsListPrint").html(data);
                    setTimeout(function(){
                        $('#studentsListPrint').printElement(
                            {
                                pageTitle:$("#hidd-print-title").val()
                            }
                        );
                    },500);
                }); 
                $("#dialog_modal_students_list_print").dialog("open");
            });
            
            $( ".windia-students-print" ).dialog({
                autoOpen: false,
                modal: true,
                hide: "",
                show: "",
                width : '90%',
                height : diaH,
                buttons: [{
                        text: "Close",
                        click: function() { $(this).dialog("close"); }
                        },
                        {
                        text: "Print",
                        click: function() { 
                                $('#studentsListPrint').printElement(
                                    {
                                        pageTitle:$("#hidd-print-title").val()
                                    }
                                );
                            }
                        }]
            });
            
            // INIT WHEN PAGE LOADS....
            $("#tuitionCalTable th:[title]").tipsy({gravity:'s'});
            
            $( "body" ).on( "hover", ".tipsy-e", function() {
                $(this).hide();
            });
            
            
	});
        
        function showStudentsUnAssigned(){
            var lblunassignedCount = $("#hidd-lblunassignedCount").val();
            var lblunassignedTeacherCount = $("#hidd-lblunassignedTeacherCount").val();
            $("#lbl-unassigned").html("&nbsp;&nbsp;&nbsp;#Students to be placed in class: "+lblunassignedCount);
            $("#lbl-unassigned-teacher").html("&nbsp;&nbsp;&nbsp;#Teachers unassigned: "+lblunassignedTeacherCount);
            // init tipsy tooltip
            $("#classListingData [title]").tipsy({gravity:'e'});
            $(".nationality-flags").tipsy({gravity:'e'});
            $("#classListingData .filters select").css('width','55px');
            $("#classListingData .filters select").chosen();
        }
        
        function teacherListed(){
            $("#teacherListingData .filters select").css('width','55px');
            $("#teacherListingData .filters select").chosen();
            $("#teacherListingData [title]").tipsy({gravity:'e'});
            // show course hours remaining.
            var courseId = $("#hidd_course_id").val();
            $.post( SITE_PATH + "tuitions/getAvailableHours",{'courseId':courseId}, function( data ) {
                    var assignedHours = data.courseAssignedHours;
                    var totalHours = data.courseTotalHours;
                  $("#courseHoursStats").html("Course hours: " + assignedHours + "/" + totalHours );
                  $("#courseHoursStats").tipsy({gravity:'sw'});
            },'json'); 
        }
        
        function myloading(show){
            $("#loading-overlay").css('z-index','999999');
            $("#loading").css('z-index','999999');
            $("#loading").html("<span>Replication is in progress...</span>");
            if(show == 1)
            {
                $("#loading-overlay").show();
                $("#loading").show();
            }
            else
            {
                $("#loading-overlay").hide();
                $("#loading").hide();
            }
        }
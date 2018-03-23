/*
	Description : This js file is used to manage all the javascript related operations
					for the master activity module
	Version : 0.3
*/
$(document).ready(function(){
	var $globalTdSelector;

	//For datepicker initialization
	$('.datepicker').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true
	});

	//On change of the centre dropdown , get the student groups and show
	$(document).on('change' , '#centre_id' , function(){
		$.ajax({
			url : baseUrl+'index.php/frontweb/master_activity/get_student_group',
			type : 'POST',
			data : {'centre_id' : $(this).val()},
			success : function(response){
				$('#group_names').val(response);
			}
		});
	});

	/*Afer click on the generate table button , we have first checked the required validation for
	every field , as well as the date comparison and then generated the table for activity */
	$(document).on('click' , '#generateTable' , function(){
		var errorFlag = 1;
		errorFlag = checkRequired('centre_id' , 'centre' , please_select_dynamic);
		errorFlag = checkRequired('arrival_date' , 'arrival date' , please_select_dynamic);
		errorFlag = checkRequired('departure_date' , 'departure date' , please_select_dynamic);
		errorFlag = checkRequired('activity_name' , 'activity name' , please_enter_dynamic);
		if(errorFlag == 1)
			errorFlag = checkDateRange('arrival_date' , 'departure_date');
		if(errorFlag == 1)
		{
			var htmlStr = '<div style="width:100%;overflow:scroll;">\
							<table class="table table-striped table-bordered activityProgramTable">\
								<thead>\
									<tr>\
										<th class="actionColumn" rowspan="2">Action</th>\
										<th class="timeColumn" colspan="2">Date</th>';
			var arrivalDate = $('#arrival_date').val();
			while(dateObject(arrivalDate) <= dateObject($('#departure_date').val()))
			{
				htmlStr+= '<th>'+formattedDate(arrivalDate)+'</th>';
				arrivalDate = nextDate(arrivalDate);
			}
			htmlStr+= '</tr>\
						<tr>\
							<th>Start</th>\
							<th>Finish</th>';
			var arrivalDate = $('#arrival_date').val();
			while(dateObject(arrivalDate) <= dateObject($('#departure_date').val()))
			{
				htmlStr+= '<th>'+getWeekDay(arrivalDate)+'</th>';
				arrivalDate = nextDate(arrivalDate);
			}
			htmlStr+= '</tr></thead>\
						<tbody>\
							<tr data-reference="'+$('#globalCount').val()+'">\
								<td>\
									<i class="fa fa-lg fa-plus-circle add_section addMoreTable" aria-hidden="true"></i>\
								</td>\
								<td>'+getTimeDropdown()+'</td>\
								<td>'+getTimeDropdown()+'</td>';
			var arrivalDate = $('#arrival_date').val();
			while(dateObject(arrivalDate) <= dateObject($('#departure_date').val()))
			{
				htmlStr+= '<td class="enterDetails" data-date="'+arrivalDate+'"><span class="droppableItem"></span></td>';
				arrivalDate = nextDate(arrivalDate);
			}
			htmlStr+= '</tr></tbody></table></div>';
			$('#previewContainer').empty();
			$('#previewContainer').append(htmlStr);

			$('#submitButton').show();
		}
	});

	//After click on the plus icon it clone the current record and append with the table record
	$(document).on('click' , '.addMoreTable' , function(){
		$('#globalCount').val(parseInt($('#globalCount').val())+1);
		if($(this).parent().find('i').length == 1)
			$(this).parent().append('<i class="fa fa-lg fa-minus-circle delete_section removeMoreTable" aria-hidden="true"></i>');
		$(this).parent().parent().clone().insertAfter($(this).parent().parent()).attr('data-reference' , $('#globalCount').val()).find('.enterDetails').html('<span class="droppableItem"></span>');
		//Initialize drag and drop functionality
		initDrag();
	});

	//After click on the minus icon , it will remove the current record
	$(document).on('click' , '.removeMoreTable' , function(){
		$(this).parent().parent().remove();
		if($('.activityProgramTable').find('tbody tr').length == 1)
			$('.activityProgramTable').find('.removeMoreTable').remove();
	});

	//After click on the table td it will open an modal popup to manage the activity details
	$(document).on('click' , '.enterDetails' , function(){
		$globalTdSelector = $(this);
		$('#activityDetailsForm')[0].reset();
		$('#activityDetailsForm').find('span.error').remove();
		$('#activityDetailsModal').find('.modalTitle').text('Activity Details ('+formattedDate($(this).data('date'))+')');
		if($(this).parent().find('td:eq(1)').find('.hourDropdown').val() != '' && $(this).parent().find('td:eq(1)').find('.minDropdown').val() != '')
			$('#activityDetailsModal').find('#from_time').val($(this).parent().find('td:eq(1)').find('.hourDropdown').val()+':'+$(this).parent().find('td:eq(1)').find('.minDropdown').val());
		if($(this).parent().find('td:eq(2)').find('.hourDropdown').val() != '' && $(this).parent().find('td:eq(2)').find('.minDropdown').val() != '')
			$('#activityDetailsModal').find('#to_time').val($(this).parent().find('td:eq(2)').find('.hourDropdown').val()+':'+$(this).parent().find('td:eq(2)').find('.minDropdown').val());

		//Set the form data if already save the form
		if($('#program_name_'+$(this).parent().data('reference')+'_'+$(this).data('date')).val() != 'undefined')
			$('#activityDetailsForm').find('#program_name').val($('#program_name_'+$(this).parent().data('reference')+'_'+$(this).data('date')).val());
		if($('#location_'+$(this).parent().data('reference')+'_'+$(this).data('date')).val() != 'undefined')
			$('#activityDetailsForm').find('#location').val($('#location_'+$(this).parent().data('reference')+'_'+$(this).data('date')).val());
		if($('#activity_'+$(this).parent().data('reference')+'_'+$(this).data('date')).val() != 'undefined')
			$('#activityDetailsForm').find('#activity').val($('#activity_'+$(this).parent().data('reference')+'_'+$(this).data('date')).val());
		if($('#managed_by_'+$(this).parent().data('reference')+'_'+$(this).data('date')).val() != 'undefined')
			$('#activityDetailsForm').find('#managed_by').val($('#managed_by_'+$(this).parent().data('reference')+'_'+$(this).data('date')).val());

		$('#activityDetailsModal').modal();
	});

	//Check validation for activity details form through jquery validator
	$('#activityDetailsForm').validate({
		errorElement : 'span',
		rules : {
			program_name : {
				required : true
			},
			location : {
				required : true
			},
			activity : {
				required : true
			},
			from_time : {
				required : true
			},
			to_time : {
				required : true
			}
		}
	});

	//After submit the activity details form , check the time validation and save the details in hidden field
	$('#activityDetailsForm').submit(function(e){
		if($(this).valid())
		{
			e.preventDefault();
			if($('#program_name_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')).length)
			{
				$('#program_name_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')).val($('#activityDetailsForm').find('#program_name').val());
				$('#location_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')).val($('#activityDetailsForm').find('#location').val());
				$('#activity_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')).val($('#activityDetailsForm').find('#activity').val());
				$('#from_time_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')).val($('#activityDetailsForm').find('#from_time').val());
				$('#to_time_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')).val($('#activityDetailsForm').find('#to_time').val());
				$('#managed_by_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')).val($('#activityDetailsForm').find('#managed_by').val());
			}
			else
			{
				var htmlStr = '<input type="hidden" name="program_name['+$globalTdSelector.data('date')+'][]" value="'+$('#activityDetailsForm').find('#program_name').val()+'" id="program_name_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')+'">\
								<input type="hidden" name="location['+$globalTdSelector.data('date')+'][]" value="'+$('#activityDetailsForm').find('#location').val()+'" id="location_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')+'">\
								<input type="hidden" name="activity['+$globalTdSelector.data('date')+'][]" value="'+$('#activityDetailsForm').find('#activity').val()+'" id="activity_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')+'">\
								<input type="hidden" name="from_time['+$globalTdSelector.data('date')+'][]" value="'+$('#activityDetailsForm').find('#from_time').val()+'" id="from_time_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')+'">\
								<input type="hidden" name="to_time['+$globalTdSelector.data('date')+'][]" value="'+$('#activityDetailsForm').find('#to_time').val()+'" id="to_time_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')+'">\
								<input type="hidden" name="managed_by['+$globalTdSelector.data('date')+'][]" value="'+$('#activityDetailsForm').find('#managed_by').val()+'" id="managed_by_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')+'">';
				$('#activityDetailsContainer').append(htmlStr);
			}
			var tdText = '<span class="draggableItem" data-tr_reference="'+$globalTdSelector.parent().data('reference')+'" data-td_reference="'+$globalTdSelector.data('date')+'">'+$('#activityDetailsForm').find('#activity').val()+'</span>\
							<br><i class="fa fa-trash-o deleteActivityDetails" style="float: right;color: red;"></i>';
			$globalTdSelector.html(tdText);
			$('#activityDetailsModal').modal('hide');

			//The value of the table row can be dragable and drop to any other td to copy same activity
			initDrag();
		}
	});

	//On the submission of master activity form , check atleast one activity details should present
	$('#masterActivityForm').submit(function(){
		if($.trim($('#activityDetailsContainer').html()) == '')
		{
			swal('Sorry!' , 'Please enter atleast one activity details' , 'warning');
			return false;
		}
	});

	//On click of the delete activity icon , delete the hidden fields for the activity details
	$(document).on('click' , ' .deleteActivityDetails' , function(){
		//alert('pop = '+$(this).parent().find('.draggableItem').data('tr_reference')+'=>'+$(this).parent().find('.draggableItem').data('td_reference'));
	});
});

//This function is used to check the required validation and show error message
function checkRequired(id , fieldName , dynamicMessage)
{
	if($.trim($('#'+id).val()) == '')
	{
		$('#'+id).next('.showErrorMessage').text(dynamicMessage.replace('**field**' , fieldName));
		return 2;
	}
	else
	{
		$('#'+id).next('.showErrorMessage').text('');
		return 1;
	}
}

//This function is used to check if start date is less than or equal to end date
function checkDateRange(startDateField , endDateField)
{
	if(dateObject($('#'+startDateField).val()) > dateObject($('#'+endDateField).val()))
	{
		$('#'+startDateField).next('.showErrorMessage').text(start_end_date_validation);
		return 2;
	}
	else
	{
		$('#'+startDateField).next('.showErrorMessage').text('');
		return 1;
	}
}

//This function is used to return the next date
function nextDate(currentDate)
{
	var dateObj = dateObject(currentDate);
	dateObj.setDate(dateObj.getDate() + 1);
	return dateObj.getDate()+'-'+(dateObj.getMonth() + 1)+'-'+dateObj.getFullYear();
}

//This function is used to get the date object from a given date
function dateObject(dateValue)
{
	var dateArr = dateValue.split('-');
	return new Date(dateArr[2] , (dateArr[1] - 1) , dateArr[0]);
}

//This function is usd to get formatted date(in dd-MM-YYYY format)
function formattedDate(dateValue)
{
	var monthArr = ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
	var dateArr = dateValue.split('-');
	return dateArr[0]+'-'+monthArr[(dateArr[1] - 1)]+'-'+dateArr[2];
}

//This function is used to get the week days from the provided date
function getWeekDay(dateValue)
{
	var daysArr = ["Sunday" , "Monday" , "Tuesday" , "Wednesday" , "Thursday" , "Friday" , "Saturday"];
	var dateObj = dateObject(dateValue);
	return daysArr[dateObj.getDay()];
}

//This function is used to get the hour and minute dropdown to show in the table
function getTimeDropdown()
{
	var htmlStr = '<select class="hourDropdown"><option value="">HH</option>';
	for(var i = 0 ; i <= 23 ; i++)
	{
		var j = (i < 10) ? '0'+i : i;
		htmlStr+= '<option value"'+j+'">'+j+'</option>';
	}
	htmlStr+= '</select>&nbsp;&nbsp;<select class="minDropdown"><option value="">MM</option>';
	for(var i = 0 ; i <= 59 ; i++)
	{
		var j = (i < 10) ? '0'+i : i;
		htmlStr+= '<option value"'+j+'">'+j+'</option>';
	}
	htmlStr+= '</select>';
	return htmlStr;
}

//This function is used to initialize the draggable functionality to drag an activity
function initDrag()
{
	$(".draggableItem").draggable({
		containment : "document",
		cursor : 'move',
		revert : 'invalid',
		helper : 'clone',
		refreshPositions : true,
		revertDuration : 200
	});
	initDrop();
}

//This function is used to initialize the dropable functionality to drop any item to table td
function initDrop()
{
	$(".droppableItem").parent().droppable({
		accept : ".draggableItem",
		greedy: true,
		drop : function(event , ui){
			if($(this).find('.droppableItem').length > 0)
			{
				if($(this).parent().find('td:eq(1)').find('.hourDropdown').val() != '' &&
					$(this).parent().find('td:eq(1)').find('.minDropdown').val() != '' &&
					$(this).parent().find('td:eq(2)').find('.hourDropdown').val() != '' &&
					$(this).parent().find('td:eq(2)').find('.minDropdown').val() != '')
				{
					//Set the hidden field values for dropped activity
					var htmlStr = '<input type="hidden" name="program_name['+$(this).data('date')+'][]" value="'+$('#activityDetailsContainer').find('#program_name_'+ui.helper.data('tr_reference')+'_'+ui.helper.data('td_reference')).val()+'" id="program_name_'+$(this).parent().data('reference')+'_'+$(this).data('date')+'">\
									<input type="hidden" name="location['+$(this).data('date')+'][]" value="'+$('#activityDetailsContainer').find('#location_'+ui.helper.data('tr_reference')+'_'+ui.helper.data('td_reference')).val()+'" id="location_'+$(this).parent().data('reference')+'_'+$(this).data('date')+'">\
									<input type="hidden" name="activity['+$(this).data('date')+'][]" value="'+$('#activityDetailsContainer').find('#activity_'+ui.helper.data('tr_reference')+'_'+ui.helper.data('td_reference')).val()+'" id="activity_'+$(this).parent().data('reference')+'_'+$(this).data('date')+'">\
									<input type="hidden" name="from_time['+$(this).data('date')+'][]" value="'+$(this).parent().find('td:eq(1)').find('.hourDropdown').val()+':'+$(this).parent().find('td:eq(1)').find('.minDropdown').val()+'" id="from_time_'+$(this).parent().data('reference')+'_'+$(this).data('date')+'">\
									<input type="hidden" name="to_time['+$(this).data('date')+'][]" value="'+$(this).parent().find('td:eq(2)').find('.hourDropdown').val()+':'+$(this).parent().find('td:eq(2)').find('.minDropdown').val()+'" id="to_time_'+$(this).parent().data('reference')+'_'+$(this).data('date')+'">\
									<input type="hidden" name="managed_by['+$(this).data('date')+'][]" value="'+$('#activityDetailsContainer').find('#managed_by_'+ui.helper.data('tr_reference')+'_'+ui.helper.data('td_reference')).val()+'" id="managed_by_'+$(this).parent().data('reference')+'_'+$(this).data('date')+'">';
					$('#activityDetailsContainer').append(htmlStr);

					$(this).html(ui.helper.clone().removeAttr('style')).attr('class' , 'enterDetails');
					$(this).find('.draggableItem').attr('data-tr_reference' , $(this).parent().data('reference'))
												.attr('data-td_reference' , $(this).data('date'));
					$(this).append('<br><i class="fa fa-trash-o deleteActivityDetails" style="float: right;color: red;"></i>');
					initDrag();
				}
				else
					swal('Sorry!' , 'Please select start and finish time first' , 'warning');
			}
		}
	});
}

/*
	Description : This js file is used to manage all the javascript related operations
					for the extra activity module
	Version : 0.7
*/
$(document).ready(function(){
	var $globalTdSelector;
	//The value of the table row can be dragable and drop to any other td to copy same activity
	initDrag();

	//On change of the centre dropdown , get the student groups and group reference dropdown values
	$(document).on('change' , '#centre_id' , function(){
		$.ajax({
			url : baseUrl+'index.php/frontweb/extra_activity/get_dropdown',
			type : 'POST',
			data : {'centre_id' : $(this).val()},
			dataType : 'JSON',
			success : function(response){
				$('#student_group').empty().append(
					$('<option></option').attr('value' , '').text('Please slect group')
				);
				$('#group_reference_id').empty().append(
					$('<option></option').attr('value' , '').text('Please select group reference')
				);
				if(response.studentGroup.length > 0)
				{
					$.each(response.studentGroup , function(key , value){
						$('#student_group').append(
							$('<option></option>').attr('value' , value.id).text(value.name)
						);
					});
					//Add validation rules
					$( "#student_group" ).rules( "add", {
						required : true
					});
				}
				else
					$("#student_group").rules("remove");
				if(response.groupReference.length > 0)
				{
					$.each(response.groupReference , function(key , value){
						$('#group_reference_id').append(
							$('<option></option>').attr('value' , value.id).text(value.name)
						);
					});
				}
			}
		});
	});

	//Check validation for activity report search through jquery validator
	$('#extraActivityForm').validate({
		errorElement : 'span',
		rules : {
			centre_id : {
				required : true
			},
			group_reference_id : {
				required : true
			}
		},
		messages : {
			centre_id : {
				required : please_select_dynamic.replace('**field**' , 'centre')
			},
			group_reference_id : {
				required : please_enter_dynamic.replace('**field**' , 'group reference')
			}
		},
		submitHandler : function(form){
			var message = 'It will add default master activity for the selected group . Are you sure ?';
			confirmAction(message , function(c){
				if(c){
					form.submit();
				}
			} , true , true);
			return false;
		}
	});

	//After click on the plus icon it clone the current record and append with the table record
	$(document).on('click' , '.addMoreTable' , function(){
		$('#globalCount').val(parseInt($('#globalCount').val())+1);
		if($(this).parent().find('i').length == 1)
			$(this).parent().append('<i class="fa fa-lg fa-minus-circle delete_section removeMoreTable" aria-hidden="true"></i>');
		var $tempSelector = $(this).parent().parent().clone().insertAfter($(this).parent().parent());
		$tempSelector.attr('data-reference' , $('#globalCount').val()).find('.enterDetails').html('<span class="droppableItem"></span>');
		$tempSelector.find('.hourDropdown').val('');
		$tempSelector.find('.minDropdown').val('');
		//Initialize drag and drop functionality
		initDrag();
	});

	//After click on the minus icon , it will remove the current record
	$(document).on('click' , '.removeMoreTable' , function(){
		if($(this).parent().parent().find('.draggableItem').length > 0)
			swal('Sorry!' , 'Please remove all the activity details first' , 'warning');
		else
		{
			$(this).parent().parent().remove();
			if($('.activityProgramTable').find('tbody tr').length == 1)
				$('.activityProgramTable').find('.removeMoreTable').remove();
		}
	});

	//After click on the table td it will open an modal popup to manage the activity details
	$(document).on('click' , '.enterDetails' , function(){
		//During delete activity details , this should not be executed
		if($(this).data('delete_flag') == 1)
		{
			$(this).data('delete_flag' , '');
			return false;
		}

		$globalTdSelector = $(this);
		$('#activityDetailsForm')[0].reset();
		$('#activityDetailsForm').find('span.error').remove();
		$('#activityDetailsModal').find('.modalTitle').text('Activity Details ('+formattedDate($(this).data('date'))+')');
		$('#activityDetailsModal').find('#activityDetailsParentId').val($(this).data('parent_id'));
		$('#activityDetailsModal').find('#activityDetailsId').val($(this).data('id'));
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
				var activityDetailsFormFlag = 'es';
				$('#program_name_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')).val($('#activityDetailsForm').find('#program_name').val());
				$('#location_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')).val($('#activityDetailsForm').find('#location').val());
				$('#activity_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')).val($('#activityDetailsForm').find('#activity').val());
				$('#from_time_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')).val($('#activityDetailsForm').find('#from_time').val());
				$('#to_time_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')).val($('#activityDetailsForm').find('#to_time').val());
				$('#managed_by_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')).val($('#activityDetailsForm').find('#managed_by').val());
			}
			else
			{
				var activityDetailsFormFlag = 'as';
				var htmlStr = '<input type="hidden" name="program_name['+$globalTdSelector.data('date')+'][]" value="'+$('#activityDetailsForm').find('#program_name').val()+'" id="program_name_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')+'">\
								<input type="hidden" name="location['+$globalTdSelector.data('date')+'][]" value="'+$('#activityDetailsForm').find('#location').val()+'" id="location_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')+'">\
								<input type="hidden" name="activity['+$globalTdSelector.data('date')+'][]" value="'+$('#activityDetailsForm').find('#activity').val()+'" id="activity_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')+'">\
								<input type="hidden" name="from_time['+$globalTdSelector.data('date')+'][]" value="'+$('#activityDetailsForm').find('#from_time').val()+'" id="from_time_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')+'">\
								<input type="hidden" name="to_time['+$globalTdSelector.data('date')+'][]" value="'+$('#activityDetailsForm').find('#to_time').val()+'" id="to_time_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')+'">\
								<input type="hidden" name="managed_by['+$globalTdSelector.data('date')+'][]" value="'+$('#activityDetailsForm').find('#managed_by').val()+'" id="managed_by_'+$globalTdSelector.parent().data('reference')+'_'+$globalTdSelector.data('date')+'">';
				$('#activityDetailsContainer').append(htmlStr);
			}
			//Save activity details in the database
			$.ajax({
				url : baseUrl+'index.php/frontweb/extra_activity/activity_details_add_edit',
				type : 'POST',
				data : $('#activityDetailsForm').serialize()+' &flag='+activityDetailsFormFlag,
				success : function(response){
					var tdText = '<span class="draggableItem" data-tr_reference="'+$globalTdSelector.parent().data('reference')+'" data-td_reference="'+$globalTdSelector.data('date')+'">'+$('#activityDetailsForm').find('#activity').val()+'</span>\
									<br><i class="fa fa-trash-o deleteActivityDetails" style="float: right;color: red;"></i>';
					$globalTdSelector.data('id' , response);
					$globalTdSelector.html(tdText);

					//The value of the table row can be dragable and drop to any other td to copy same activity
					initDrag();
				}
			});
			$('#activityDetailsModal').modal('hide');
		}
	});

	//On click of the delete activity icon , delete the hidden fields for the activity details
	$(document).on('click' , '.deleteActivityDetails' , function(){
		var $tdSelector = $(this).parent();
		$tdSelector.data('delete_flag' , 1);
		if(confirm(delete_confirmation.replace('**module**' , 'activity details')))
		{
			//Delete the hidden field values
			$('#activityDetailsContainer').find('#program_name_'+$tdSelector.find('.draggableItem').data('tr_reference')+'_'+$tdSelector.find('.draggableItem').data('td_reference')).remove();
			$('#activityDetailsContainer').find('#location_'+$tdSelector.find('.draggableItem').data('tr_reference')+'_'+$tdSelector.find('.draggableItem').data('td_reference')).remove();
			$('#activityDetailsContainer').find('#activity_'+$tdSelector.find('.draggableItem').data('tr_reference')+'_'+$tdSelector.find('.draggableItem').data('td_reference')).remove();
			$('#activityDetailsContainer').find('#from_time_'+$tdSelector.find('.draggableItem').data('tr_reference')+'_'+$tdSelector.find('.draggableItem').data('td_reference')).remove();
			$('#activityDetailsContainer').find('#to_time_'+$tdSelector.find('.draggableItem').data('tr_reference')+'_'+$tdSelector.find('.draggableItem').data('td_reference')).remove();
			$('#activityDetailsContainer').find('#managed_by_'+$tdSelector.find('.draggableItem').data('tr_reference')+'_'+$tdSelector.find('.draggableItem').data('td_reference')).remove();

			//Delete from database through ajax
			$.ajax({
				url : baseUrl+'index.php/frontweb/extra_activity/delete_activity_details',
				type : 'POST',
				data : {'id' : $tdSelector.data('id')},
				success : function(response){
					$tdSelector.html('<span class="droppableItem"></span>');
					initDrag();
				}
			});
		}
	});

	//On change of the time slot , it will update hidden field as well as database values for activity details
	$(document).on('change' , '.hourDropdown , .minDropdown' , function(){
		if($(this).parent().parent().find('.draggableItem').length > 0)
		{
			var  $tdSelector = $(this).parent();
			if($(this).parent().attr('class') == 'tdStartTime')
				var fieledName = 'from_time';
			if($(this).parent().attr('class') == 'tdFinishTime')
				var fieledName = 'to_time';
			if(confirm('This time will update to all the related activities . Are you sure ?'))
			{
				var activityIdArr = [];
				$(this).parent().parent().find('.draggableItem').each(function(){
					$('#'+fieledName+'_'+$(this).data('tr_reference')+'_'+$(this).data('td_reference')).val($tdSelector.find('.hourDropdown').val()+':'+$tdSelector.find('.minDropdown').val());
					activityIdArr.push($(this).parent().data('id'));
				});
				//Update the timing in database
				$.ajax({
					url : baseUrl+'index.php/frontweb/extra_activity/update_activity_time',
					type : 'POST',
					data : {'fieldName' : fieledName , 'activityIdArr' : activityIdArr , 'time' : $tdSelector.find('.hourDropdown').val()+':'+$tdSelector.find('.minDropdown').val()},
					success : function(response){}
				});
			}
			else
			{
				$(this).parent().parent().find('.draggableItem').each(function(){
					var tempArr = $('#'+fieledName+'_'+$(this).data('tr_reference')+'_'+$(this).data('td_reference')).val().split(':');
					$tdSelector.find('.hourDropdown').val(tempArr[0]);
					$tdSelector.find('.minDropdown').val(tempArr[1]);
					return false;
				});
			}
		}
	});
});

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
					$tdSelector = $(this);

					//Insert the activity details in the database
					$.ajax({
						url : baseUrl+'index.php/frontweb/extra_activity/activity_details_add_edit',
						type : 'POST',
						data : {
							'activity' : $('#activityDetailsContainer').find('#activity_'+ui.helper.data('tr_reference')+'_'+ui.helper.data('td_reference')).val(),
							'activityDetailsId' : '',
							'activityDetailsParentId' : $tdSelector.data('parent_id'),
							'flag' : 'as',
							'from_time' : $(this).parent().find('td:eq(1)').find('.hourDropdown').val()+':'+$(this).parent().find('td:eq(1)').find('.minDropdown').val(),
							'location' : $('#activityDetailsContainer').find('#location_'+ui.helper.data('tr_reference')+'_'+ui.helper.data('td_reference')).val(),
							'managed_by' : $('#activityDetailsContainer').find('#managed_by_'+ui.helper.data('tr_reference')+'_'+ui.helper.data('td_reference')).val(),
							'program_name' : $('#activityDetailsContainer').find('#program_name_'+ui.helper.data('tr_reference')+'_'+ui.helper.data('td_reference')).val(),
							'to_time' : $(this).parent().find('td:eq(2)').find('.hourDropdown').val()+':'+$(this).parent().find('td:eq(2)').find('.minDropdown').val()
						},
						success : function(response){
							$tdSelector.data('id' , response);
						}
					});
					initDrag();
				}
				else
					swal('Sorry!' , 'Please select start and finish time first' , 'warning');
			}
		}
	});
}

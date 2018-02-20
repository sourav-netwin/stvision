/*
	This file is used to manage all the customize javascript related operation for section
	setting module .
	Current Version : 0.1
*/
var pageHighlightMenu = "frontweb/section_setting";
$(document).ready(function(){
	var table = $("#datatable").DataTable({
		processing : true,
		stateSave : true,
		serverSide : true,
		lengthChange : false,
		ordering : false,
		pageLength : 50,
		ajax : {
			url : 'section_setting/get_section',
			type : 'POST',
			data : function(d){
				d.type = $('#type').val();
			}
		}
	});

	//Open modal popup after click on the edit icon
	$(document).on('click' , '.editBtn' , function(){
		$('#editNameModalForm').find('span.error').remove();
		$('#section_id').val($(this).data('id'));
		$('#name').val($(this).parent().parent().parent().find('td:eq(1)').text()).attr('class' , 'form-control');
		$('#editNameModal').modal();
	});

	//Add Customize rules for jquery validator
	jQuery.validator.addMethod("validData",function(value,element){
		if(/[()+<>\"\'%&;]/.test(value)){
				return false;
		}else{
			return true;
		}
	},valid_data_error_msg);

	//Check validation
	$('#editNameModalForm').validate({
		errorElement : 'span',
		rules : {
			name : {
				required : true,
				validData : true
			}
		},
		messages : {
			name : {
				required : please_enter_dynamic.replace('**field**' , 'Name')
			}
		}
	});

	//SUbmit the form and update data
	$('#editNameModalForm').submit(function(e){
		if($(this).valid())
		{
			e.preventDefault();
			$.ajax({
				url : 'section_setting/edit',
				type : 'POST',
				data : $(this).serialize(),
				success : function(response){
					$('#editNameModal').modal('hide');
					table.ajax.reload();
				}
			});
		}
	});

	//On change if the type dropdown refresh the datatable and load the related content
	$(document).on('change' , '.setTypeClass' , function(){
		table.ajax.reload();
	});

	//On click of the sequence arraw , change the sequence in database and then refresh the data table
	$(document).on('click' , '.changeSequence' , function(){
		var currentId = $(this).parent().find('.currentSectionId').val();
		var currentSequence = $(this).parent().find('.currentSectionSequence').val();
		if($(this).data('sequence') == 'up')
		{
			var switchId = $(this).closest('tr').prev('tr').find('td:eq(3)').find('.currentSectionId').val();
			var switchSequence = $(this).closest('tr').prev('tr').find('td:eq(3)').find('.currentSectionSequence').val();
		}
		else if($(this).data('sequence') == 'down')
		{
			var switchId = $(this).closest('tr').next('tr').find('td:eq(3)').find('.currentSectionId').val();
			var switchSequence = $(this).closest('tr').next('tr').find('td:eq(3)').find('.currentSectionSequence').val();
		}
		$.ajax({
			url : 'section_setting/switch_sequence',
			type : 'POST',
			async : false,
			data : {'currentId' : currentId , 'currentSequence' : currentSequence , 'switchId' : switchId , 'switchSequence' : switchSequence},
			success : function(response){
				table.ajax.reload();
			}
		});
	});

	//After click on the add extra section button open add modal popup
	$(document).on('click' , '.addExtraSection' , function(){
		$('#extraSectionForm')[0].reset();
		$('#extraSectionModal').find('#course_id').val($('.setTypeClass').val());
		$('#extraSectionModal').modal();
	});

	//Onchange of the extra section name create slug
	$(document).on('keyup' , '#name' , function(){
		$('#extraSectionModal').find('#slug').val($(this).val().replace(/ /g , '-').toLowerCase());
	});

	//Check validation for add extra section form
	$('#extraSectionForm').validate({
		errorElement : 'span',
		rules : {
			course_id : {
				required : true
			},
			name : {
				required : true,
				validData : true
			},
			slug : {
				required : true,
				remote: {
					url: "section_setting/check_duplicate",
					type: "post",
					async : false,
					data: {
						slug: function() {
							return $('#extraSectionForm').find("#slug").val();
						}
					}
				}
			}
		},
		messages : {
			course_id : {
				required : please_enter_dynamic.replace('**field**' , 'Course')
			},
			name : {
				required : please_enter_dynamic.replace('**field**' , 'Name')
			},
			slug : {
				required : please_enter_dynamic.replace('**field**' , 'Slug'),
				remote : duplicate_dynamic.replace('**field**' , 'Slug'),
			}
		}
	});

	//SUbmit extra section add form and add values in database
	$('#extraSectionForm').submit(function(e){
		if($(this).valid())
		{
			e.preventDefault();
			$.ajax({
				url : 'section_setting/add',
				type : 'POST',
				data : $(this).serialize(),
				success : function(response){
					$('#extraSectionModal').modal('hide');
					table.ajax.reload();
				}
			});
		}
	});
});

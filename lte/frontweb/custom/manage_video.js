/*
	This file is used to manage all the customize javascript related operation for manage
	video module .
	Current Version : 1.1
*/
var pageHighlightMenu = "frontweb/manage_video";
$(document).ready(function(){
	$("#datatable").DataTable();

	//Generate password for student and manager , campus wise
	$('.passwordGenerator').click(function(){
		confirmAction("<?php echo $this->lang->line('generate_password_confirmation'); ?>" , function(c){
			if(c){
				$.ajax({
					url : 'manage_video/generate_password',
					type : 'POST',
					success : function(response){
						window.location='manage_video';
					}
				});
			}
		} , true , true);
	});

	//On click of the change password icon open change password modal
	$(document).on('click' , '.changePasswordClass' , function(){
		$('#plus_video_id').val($(this).data('id'));
		$('#password').val($(this).parent().parent().find('td:eq(2)').text());
		$('#manager_password').val($(this).parent().parent().find('td:eq(3)').text());
		$('#changePasswordModal').modal();
	});

	//Add customize validation rules for check password
	jQuery.validator.addMethod('checkPassword' , function(value , element){
		var pattern = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/;
		return pattern.test(value);
	} , password_validation);

	//Check form validation using jquery form validator
	$('#changePasswordForm').validate({
		errorElement : 'span',
		rules : {
			password : {
				required : true,
				minlength : 8,
				checkPassword : true
			},
			manager_password : {
				required : true,
				minlength : 8,
				checkPassword : true
			}
		},
		messages : {
			password : {
				required : please_enter_dynamic.replace('**field**' , 'student\'s password')
			},
			manager_password : {
				required : please_enter_dynamic.replace('**field**' , 'manager\'s password')
			}
		}
	});

	//If the validation is done then submit the form and update record in database
	$('#changePasswordForm').submit(function(e){
		if($(this).valid())
		{
			e.preventDefault();
			$.ajax({
				url : 'manage_video/edit',
				data : $(this).serialize(),
				type : 'POST',
				success : function(response){
					$('#changePasswordModal').modal('hide');
					location.reload(true);
				}
			});
		}
	});

});
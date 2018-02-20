/*
	This file is used to manage all the customize javascript related operation for program
	banner module .
	Current Version : 0.2
*/
var pageHighlightMenu = "frontweb/program";
$(document).ready(function(){
	if(pageType == 'list')
	{
		var table = $("#datatable").DataTable({
			processing : true,
			stateSave : true,
			serverSide : true,
			ajax : {
				url : 'program/get_program',
				type : 'POST'
			},
			aoColumnDefs: [
				{"bSortable" : false , "aTargets" : [1,3,4]}
			]
		});
	}

	$(document).on('click' , '.global-list-status-icon' , function(e){
		var message = ($(this).find('.fa').data('status_type') == 1) ? inactive_confirmation.replace('**module**' , 'Program') : active_confirmation.replace('**module**' , 'Program');
		var id = $(this).find('.fa').data('program_id');
		var status = $(this).find('.fa').data('status_type');
		confirmAction(message , function(c){
			if(c){
				$.ajax({
					url : 'program/update_status',
					type : 'POST',
					data : {'program_id' : id , 'program_status' : status},
					success : function(){
						table.ajax.reload();
					}
				});
			}
		} , true , true);
	});

	if(pageType == 'add_edit')
	{
		//Add Customize rules for jquery validator
		jQuery.validator.addMethod("validData",function(value,element){
			if(/[()+<>\"\'%&;]/.test(value)){
					return false;
			}else{
				return true;
			}
		},valid_data_error_msg);

		jQuery.validator.addMethod("checkImageWidth",function(value,element){
			if($('#imgWidthErrorFlag').val() == 2){
					return false;
			}else{
				return true;
			}
		},"");

		jQuery.validator.addMethod("checkImageExt" , function (value , element){
			if(value)
			{
				if(splitByLastDot(value) == 'jpg' || splitByLastDot(value) == 'png' || splitByLastDot(value) == 'jpeg')
					return true;
				else
					return false;
			}
			else
				return true;
		} , image_type_error_msg);

		jQuery.validator.addMethod('requiredImage' , function(value , element){
			if(value == '' && $('#oldImg').val() == '')
				return false;
			else
				return true;
		} , required_upload_image);

		//Initialize jquery validator
		$('#programDetails').validate({
			errorElement : 'span',
			rules : {
				language_id : {
					required : true ,
				},
				program_title : {
					required : true,
					validData : true
				},
				program_short_description : {
					required : true,
					validData : true
				},
				program_description : {
					required : true
				},
				more_link : {
					required : true
				},
				program_image : {
					requiredImage : true,
					checkImageWidth : true,
					checkImageExt : true
				}
			},
			messages : {
				language_id : {
					required : please_select_dynamic.replace('**field**' , 'Language')
				},
				program_title : {
					required : please_enter_dynamic.replace('**field**' , 'Program Title')
				},
				program_short_description : {
					required : please_enter_dynamic.replace('**field**' , 'Short Description')
				},
				program_description : {
					required : please_enter_dynamic.replace('**field**' , 'Description')
				},
				more_link : {
					required : please_enter_dynamic.replace('**field**' , 'Link')
				}
			}
		});

		//On change of the image it checks for the validation and load the image
		$('#program_image').on('change' , function(){
			$(this).next('span.error').text('');
			var files = (this.files) ? this.files : [];
			if(!files.length || !window.FileReader)
				return;
			if(/^image/.test(files[0]['type']))
			{
				var reader = new FileReader();
				reader.readAsDataURL(files[0]);
				reader.onload = function(){
					var image = new Image();
					image.src = this.result;
					image.onload = function(){
						$('.uploadImageProgramClass').attr('src' , this.src);
						if(!(this.height >= height1 && this.width >= width1))
						{
							$('#imgWidthErrorFlag').val('2');
							$('#imgErrorMessage').text(minimum_image_dimension.replace('**width**' , width1).replace('**height**' , height1));
							return false;
						}
						else
						{
							$('#imgWidthErrorFlag').val('1');
							$('#imageChangeFlag').val('2');
							$('#imgErrorMessage').text('');
							return true;
						}
					};
				};
			}
		});
	}
});

//This function is used to confirm before delete
function confirm_delete()
{
	if(confirm(delete_confirmation.replace('**module**' , 'Program Banner')))
		return true;
	else
		return false;
}

//This function is used to return string name after dot
function splitByLastDot(str)
{
	if(str != '')
	{
		var arr = str.split('.');
		return arr[1];
	}
}

/*
	This file is used to manage all the customize javascript related operation for junior
	centre module .
	Current Version : 1.1
*/
var pageHighlightMenu = "frontweb/junior_centre";
$(document).ready(function(){
	//initialize datatable
	var table = $("#datatable").DataTable({
		processing : true,
		stateSave : true,
		serverSide : true,
		ajax : {
			url : 'junior_centre/get_junior_centre',
			type : 'POST'
		},
		aoColumnDefs: [
			{"bSortable" : false , "aTargets" : [1,2,3]}
		]
	});

	//After click on the status icon open status modal
	$(document).on('click' , '.global-list-status-icon' , function(e){
		var message = ($(this).find('.fa').data('status_type') == 1) ? inactive_confirmation.replace('**module**' , 'Junior Centre') : active_confirmation.replace('**module**' , 'Junior Centre');
		var id = $(this).find('.fa').data('junior_centre_id');
		var status = $(this).find('.fa').data('status_type');
		confirmAction(message , function(c){
			if(c){
				$.ajax({
					url : 'junior_centre/update_status',
					type : 'POST',
					data : {'junior_centre_id' : id , 'junior_centre_status' : status},
					success : function(){
						table.ajax.reload();
					}
				});
			}
		} , true , true);
	});

	//After click on extra management icon for pdf management open modal with dynamic content
	$(document).on('click' , '.pdf-management-class' , function(e){
		$('#uploadPdfModalForm')[0].reset();
		if($(this).data('type') == 'addon')
			$('.uploadPdfModal-title').text('Manage add on');
		else if($(this).data('type') == 'factsheet')
			$('.uploadPdfModal-title').text('Manage fact sheet');
		else if($(this).data('type') == 'activity_program')
			$('.uploadPdfModal-title').text('Manage activity program');
		else if($(this).data('type') == 'menu')
			$('.uploadPdfModal-title').text('Manage menu');
		else if($(this).data('type') == 'walking_tour')
			$('.uploadPdfModal-title').text('Manage walking tour');

		//Remove error messages when open the modal
		$('#uploadPdfModalForm').find('span.error').remove();
		$('#fileUploadErrorMsg').text('');

		$('#uploadPdfModalType').val($(this).data('type'));
		$('#juniorCentreId').val($(this).data('junior_centre_id'));
		loadPdfManagementTable($(this).data('junior_centre_id') , $(this).data('type'));
		$('#uploadPdfModal').modal();
	});

	//Add dynamic rules for checking file extension
	jQuery.validator.addMethod("validData",function(value,element){
		if(/[()+<>\"\'%&;]/.test(value)){
				return false;
		}else{
			return true;
		}
	},valid_data_error_msg);
	jQuery.validator.addMethod("checkPdfExt" , function (value , element){
		if(value)
		{
			if(splitByLastDot(value) == 'pdf')
				return true;
			else
				return false;
		}
		else
			return true;
	} , pdf_type_error_msg);

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

	jQuery.validator.addMethod('checkNumericFloat' , function(value , element){
		var pattern = /^([0-9]*[.])?[0-9]+$/;
		return pattern.test(value);
	} , numeric_floating_number);

	//Initialize jquery validator for input fields for pdf management section
	$('#uploadPdfModalForm').validate({
		errorElement : 'span',
		rules : {
			file_description : {
				required : true
			},
			file_name : {
				required : true ,
				checkPdfExt : true
			}
		},
		messages : {
			file_description : {
				required : please_enter_dynamic.replace('**field**' , 'Description')
			},
			file_name : {
				required : required_upload_file
			}
		}
	});

	//This section is used to submit the form through ajax
	$('#uploadPdfModalForm').submit(function(e){
		$('#fileUploadErrorMsg').text('');
		if($(this).valid())
		{
			e.preventDefault();
			var formData = new FormData(this);
			$.ajax({
				url : 'junior_centre/upload_pdf_management',
				type : 'POST',
				data : formData,
				contentType: false,
				cache: false,
				processData: false,
				dataType : 'JSON',
				success : function(response){
					if(response.fileUploadErrorMsg != '')
						$('#fileUploadErrorMsg').text(response.fileUploadErrorMsg);
					else
					{
						$('#uploadPdfModalForm')[0].reset();
						loadPdfManagementTable($('#juniorCentreId').val() , $('#uploadPdfModalType').val());
					}
				}
			});
		}
	});

	//After click on delete icon from modal table , the record will delete from database
	$(document).on('click' , '.deletePdf' , function(){
		if(confirm(delete_confirmation.replace('**module**' , 'Pdf')))
		{
			var juniorcentreid = $(this).data('juniorcentreid');
			var uploadpdfmodaltype = $(this).data('uploadpdfmodaltype');
			$.ajax({
				url : 'junior_centre/delete_pdf_management',
				data : {'id' : $(this).data('refid') , 'uploadpdfmodaltype' : uploadpdfmodaltype},
				type : 'POST',
				dataType : 'JSON',
				success : function(response){
					$('#uploadPdfModalForm')[0].reset();
					loadPdfManagementTable(juniorcentreid , uploadpdfmodaltype);
				}
			});
		}
	});

	//After click on date management icon , open modal for date management
	$(document).on('click' , '.dates-management-class' , function(e){
		$('#dateManagementModalForm')[0].reset();

		//Remove error messages when open the modal
		$('#dateManagementModalForm').find('span.error').remove();

		$('#dateJuniorCentreId').val($(this).data('junior_centre_id'));
		$('#dateManagementModal').find('#datesFlag').val('as');
		loaddateManagementTable($(this).data('junior_centre_id'));
		$('#program_id').multiselect('refresh');
		$('#dateManagementModal').modal();
	});

	//Initialize bootstrap multiselect
	$('#program_id').multiselect({
		buttonWidth : '420px',
		nonSelectedText: 'Please Select'
	});

	//Initialize jquery validator for input fields for dates management section
	$('#dateManagementModalForm').validate({
		errorElement : 'span',
		rules : {
			date : {
				required : true
			},
			overnight : {
				validData : true
			}
		},
		messages : {
			date : {
				required : please_enter_dynamic.replace('**field**' , 'date')
			}
		}
	});

	//This section is used to check validation and submit dates management form through ajax
	$('#dateManagementModalForm').submit(function(e){
		if($(this).valid())
		{
			$programErrorFlag = $weekErrorFlag = 1;
			//Check for program section
			if($('#program_id').val() == null)
			{
				$programErrorFlag = 2;
				$('#programErrorMessage').text(please_select_dynamic.replace('**field**' , 'Program'));
			}
			else
			{
				$('#programErrorMessage').text('');
				$programErrorFlag = 1;
			}

			//Check for week section
			if($('input[name="week[]"]:checked').length == 0)
			{
				$weekErrorFlag = 2;
				$('#weekErrorMessage').text(please_select_dynamic.replace('**field**' , 'Week'));
			}
			else
			{
				$('#weekErrorMessage').text('');
				$weekErrorFlag = 1;
			}
			if($programErrorFlag == 1 && $weekErrorFlag == 1)
			{
				e.preventDefault();
				var formData = new FormData(this);
				$.ajax({
					url : 'junior_centre/add_dates_management',
					type : 'POST',
					data : formData,
					contentType: false,
					cache: false,
					processData: false,
					dataType : 'JSON',
					success : function(response){
						$('#dateManagementModalForm')[0].reset();
						$('#program_id').multiselect('refresh');
						$('#dateManagementModal').find('#datesFlag').val('as');
						loaddateManagementTable($('#dateJuniorCentreId').val());
					}
				});
			}
			else
				return false;
		}
	});

	//After click on delete icon from modal table , the record will delete from database
	$(document).on('click' , '.deletedates' , function(){
		if(confirm(delete_confirmation.replace('**module**' , 'date')))
		{
			var juniorcentreid = $(this).data('juniorcentreid');
			$.ajax({
				url : 'junior_centre/delete_dates_management',
				data : {'id' : $(this).data('refid')},
				type : 'POST',
				dataType : 'JSON',
				success : function(response){
					$('#dateManagementModalForm')[0].reset();
					loaddateManagementTable(juniorcentreid);
				}
			});
		}
	});

	//After click on video gallery management icon , open modal for video gallery management
	$(document).on('click' , '.video-management-class' , function(e){
		$('#videoManagementModalForm')[0].reset();

		//Remove error messages when open the modal
		$('#videoManagementModalForm').find('span.error').remove();

		$('.uploadImageProgramClass').attr('src' , lte+'frontweb/no_flag.jpg');
		$('#videoJuniorCentreId').val($(this).data('junior_centre_id'));
		loadvideoManagementTable($(this).data('junior_centre_id'));
		$('#videoManagementModal').modal();
	});

	//Add custimize validation to check the vimeo url
	jQuery.validator.addMethod('validVimeoUrl' , function(value , element){
		if(value.indexOf('vimeo.com') == -1)
			return false;
		else
			return true;
	} , enter_vimeo_url);

	//Initialize jquery validator for input fields for video gallery management section
	$('#videoManagementModalForm').validate({
		errorElement : 'span',
		rules : {
			video_url : {
				required : true,
				url: true,
				validVimeoUrl : true
			},
			description : {
				required : true
			},
			video_image : {
				required : true,
				checkImageWidth : true,
				checkImageExt : true
			}
		},
		messages : {
			video_url : {
				required : please_enter_dynamic.replace('**field**' , 'video url')
			},
			description : {
				required : please_enter_dynamic.replace('**field**' , 'description')
			},
			video_image : {
				required : required_upload_image
			}
		}
	});

	//With the change of image check the validation and load the image accordingly
	$('#video_image').on('change' , function(){
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
						$('#imgErrorMessage').text('');
						return true;
					}
				};
			};
		}
	});

	//This section is used to submit video management management form through ajax
	/*(Commented on 19th Feb , 2018 - to make normal form submission)
	$('#videoManagementModalForm').submit(function(e){
		if($(this).valid())
		{
			e.preventDefault();
			var formData = new FormData(this);
			$.ajax({
				url : 'junior_centre/add_video_gallery_management',
				type : 'POST',
				data : formData,
				contentType: false,
				cache: false,
				processData: false,
				dataType : 'JSON',
				success : function(response){
					$('#videoManagementModalForm')[0].reset();
					$('.uploadImageProgramClass').attr('src' , lte+'frontweb/no_flag.jpg');
					loadvideoManagementTable($('#videoJuniorCentreId').val());
				}
			});
		}
		else
			return false;
	});
	*/

	//After click on delete icon from modal table , the record will delete from database
	$(document).on('click' , '.deletevideo' , function(){
		if(confirm(delete_confirmation.replace('**module**' , 'video')))
		{
			var juniorcentreid = $(this).data('juniorcentreid');
			$.ajax({
				url : 'junior_centre/delete_video_gallery_management',
				data : {'id' : $(this).data('refid')},
				type : 'POST',
				dataType : 'JSON',
				success : function(response){
					$('#videoManagementModalForm')[0].reset();
					loadvideoManagementTable(juniorcentreid);
				}
			});
		}
	});

	//After click on International mix management icon , open modal for International mix management
	$(document).on('click' , '.international-mix-management-class' , function(e){
		setCountryDropdown();
		$('#internationalMixManagementModalForm')[0].reset();

		//Remove error messages when open the modal
		$('#internationalMixManagementModalForm').find('span.error').remove();

		$('#countryErrorMessage').text('');
		$('#internationalMixJuniorCentreId').val($(this).data('junior_centre_id'));
		loadInternationalMixManagementTable($(this).data('junior_centre_id'));
		$('#internationalMixManagementModal').modal();
	});

	//Initialize spectrum color selector
	$("#color_code").spectrum({
		color: "#f00"
	});

	//Initialize jquery validator for input fields for international mix management section
	$('#internationalMixManagementModalForm').validate({
		errorElement : 'span',
		rules : {
			country_name : {
				required : true
			},
			percentage : {
				required : true,
				checkNumericFloat : true
			}
		},
		messages : {
			country_name : {
				required : please_enter_dynamic.replace('**field**' , 'country name')
			},
			percentage : {
				required : please_enter_dynamic.replace('**field**' , 'percentage')
			}
		}
	});

	//This section is used to submit international mix management form through ajax
	$('#internationalMixManagementModalForm').submit(function(e){
		if($(this).valid())
		{
			e.preventDefault();
			var formData = new FormData(this);
			$.ajax({
				url : 'junior_centre/duplicateCountryCheck',
				data : {'country' : $('#country_name').val() , 'id' : $('#internationalMixJuniorCentreId').val()},
				type : 'POST',
				dataType : 'JSON',
				success : function(response){
					if(response.status == 'ok')
					{
						$('#countryErrorMessage').text('');
						formData.append('color_code' , $('.sp-preview-inner').css('background-color'));
						$.ajax({
							url : 'junior_centre/add_international_mix_management',
							type : 'POST',
							data : formData,
							contentType: false,
							cache: false,
							processData: false,
							dataType : 'JSON',
							success : function(response){
								$('#internationalMixManagementModalForm')[0].reset();
								loadInternationalMixManagementTable($('#internationalMixJuniorCentreId').val());
							}
						});
					}
					else
						$('#countryErrorMessage').text(duplicate_dynamic.replace('**field**' , 'Country'));
				}
			});
		}
		else
			return false;
	});

	//After click on delete icon from modal table , the record will delete from database
	$(document).on('click' , '.deleteInternationalMix' , function(){
		if(confirm(delete_confirmation.replace('**module**' , 'international mix')))
		{
			var juniorcentreid = $(this).data('juniorcentreid');
			$.ajax({
				url : 'junior_centre/delete_international_mix_management',
				data : {'id' : $(this).data('refid')},
				type : 'POST',
				dataType : 'JSON',
				success : function(response){
					$('#internationalMixManagementModalForm')[0].reset();
					loadInternationalMixManagementTable(juniorcentreid);
				}
			});
		}
	});

	//onchange of the sequence value it will update in the database
	$(document).on('change' , '.changeSequence' , function(){
		$.ajax({
			url : 'junior_centre/update_sequence',
			data : {'module' : 'video_gallery' , 'id' : $(this).data('ref_id') , 'sequence' : $(this).val()},
			type : 'POST',
			dataType : 'JSON',
			success : function(){}
		});
	});

	//On click of the manage extra section icon open the management modal
	$(document).on('click' , '.extraSectionClass' , function(){
		$('#extraSectionContentForm')[0].reset();

		//Remove error messages when open the modal
		$('#extraSectionContentForm').find('span.error').remove();
		$('#fileUploadErrorMsg').text('');

		$('#extraSectionContentModal').find('#juniorCentreId').val($(this).data('junior_centre_id'));
		loadExtraSectionTable($(this).data('junior_centre_id'));
		$('#extraSectionContentModal').modal();
	});

	//Add proper validation for extra section content form
	$('#extraSectionContentForm').validate({
		errorElement : 'span',
		rules : {
			extra_section_id : {
				required : true
			},
			description : {
				required : true
			},
			file_name : {
				required : true,
				checkPdfExt : true
			}
		},
		messages : {
			extra_section_id : {
				required : please_select_dynamic.replace('**field**' , 'extra section')
			},
			description : {
				required : please_enter_dynamic.replace('**field**' , 'Description')
			},
			file_name : {
				required : required_upload_file
			}
		}
	});

	//If validation sucessfully done then submit the form through ajax
	$('#extraSectionContentForm').submit(function(e){
		if($(this).valid())
		{
			e.preventDefault();
			var formData = new FormData(this);
			$.ajax({
				url : 'junior_centre/add_extra_section_content',
				data : formData,
				type : 'POST',
				contentType: false,
				cache: false,
				processData: false,
				dataType : 'JSON',
				success : function(response){
					if(response.fileUploadErrorMsg != '')
						$('#extraSectionContentForm').find('#fileUploadErrorMsg').text(response.fileUploadErrorMsg);
					else
					{
						$('#extraSectionContentForm')[0].reset();
						loadExtraSectionTable($('#extraSectionContentForm').find('#juniorCentreId').val());
					}
				}
			});
		}
	});

	//After click on delete icon from extra section content modal , delete record from DB
	$(document).on('click' , '.deleteSectionPdf' , function(){
		if(confirm(delete_confirmation.replace('**module**' , 'Pdf')))
		{
			var juniorcentreid = $(this).data('juniorcentreid');
			$.ajax({
				url : 'junior_centre/delete_extra_section_content',
				data : {'id' : $(this).data('refid')},
				type : 'POST',
				dataType : 'JSON',
				success : function(response){
					$('#extraSectionContentForm')[0].reset();
					loadExtraSectionTable(juniorcentreid);
				}
			});
		}
	});

	//After click on the edit dates icon it will show all the default values in the form
	$(document).on('click' , '.editDates' , function(){
		$('#dateManagementModal').find('#dateModalTable tr').removeAttr('style');
		$('#dateManagementModal').find('.datesWeek').prop('checked' , false);
		$(this).parent().parent().parent().parent().css('background-color' , '#d5aaaa');
		$('#dateManagementModal').find('#datesId').val($(this).data('dates_id'));
		$('#dateManagementModal').find('#datesFlag').val('es');
		$.ajax({
			url : 'junior_centre/get_edit_dates',
			data : {'dates_id' : $(this).data('dates_id')},
			type : 'POST',
			dataType : 'JSON',
			success : function(response){
				$('#dateManagementModal').find('#date').val(response.date);
				$('#dateManagementModal').find('#overnight').val(response.overnight);
				$('#dateManagementModal').find('.datesWeek').each(function(){
					if($.inArray($(this).val() , response.week.split(',')) != -1)
						$(this).prop('checked' , true);
				});
				$('#dateManagementModal').find('#program_id').val(response.program.split(','));
				$('#dateManagementModal').find('#program_id').multiselect('refresh');
			}
		});
	});

	//On change of the file it will remove the validation error generated by jquery validator
	$(document).on('change' , '#file_name' , function(){
		$(this).next('span.error').text('');
	});

	//After click on the manage centre details icon the management popup will open for that centre
	$(document).on('click' , '.centreDeails' , function(){
		$('#centreDetailsForm').find('#centreId').val($(this).data('centre_id'));
		$('#centreDetailsForm').find('#globalCount').val(1);
		$('#centreDetailsForm').find('.modal-body').empty();
		$.ajax({
			url : 'junior_centre/get_centre_details',
			type : 'POST',
			data : {'centreId' : $(this).data('centre_id')},
			dataType : 'json',
			success : function(response){
				var htmlStr = '';
				if(response.length > 0)
				{
					$.each(response , function(index , value){
						htmlStr+= getModalBody(value.icon_class , value.title , value.details , value.sequence , response.length);
					});
				}
				else
					htmlStr+= getModalBody();
				$('#centreDetailsForm').find('.centreDetailsModalBody').append(htmlStr);
				$('.selectpicker').selectpicker();
				$('.summernote').summernote({height: 150});
			}
		});
		$('#centreDetailsModal').modal();
	});

	//After click on the add more icon it will add new block
	$(document).on('click' , '.addMoreIcon' , function(){
		$(this).parent().parent().after(getModalBody('' , '' , '' , '' , ($('#centreDetailsForm').find('.add_more_wrapper').length+1)));
		$('.selectpicker').selectpicker();
		$('.summernote').summernote({height: 150});
		if($(this).parent().find('i').length == 1)
			$(this).after('<i style="margin-left: 15px;" class="fa fa-lg fa-minus-circle removeMoreIcon add_section" aria-hidden="true" data-block_no="'+$(this).data('block_no')+'"></i>');
	});

	//After click on the remove more icon it will remove the old block
	$(document).on('click' , '.removeMoreIcon' , function(){
		$(this).parent().parent().remove();
		if($('.add_more_wrapper').length == 1)
			$('.add_more_wrapper').find('.removeMoreIcon').remove();
	});

	$('#centreDetailsForm').submit(function(e){
		var errorFlag = 1;
		//Check validation for Title
		$('input[name="title[]"]').each(function(){
			if($(this).val() == '')
			{
				$(this).next('.error').text(please_enter_dynamic.replace('**field**' , 'Title'));
				errorFlag = 2;
			}
			else
				$(this).next('.error').text('');
		});

		//Check validation for Sequence
		$('input[name="sequence[]"]').each(function(){
			if($(this).val() == '')
			{
				$(this).next('.error').text(please_enter_dynamic.replace('**field**' , 'sequence'));
				errorFlag = 2;
			}
			else
				$(this).next('.error').text('');
		});

		//Check validation for Sequence
		$('input[name="sequence[]"]').each(function(){
			if($(this).val() == '')
			{
				$(this).next('.error').text(please_enter_dynamic.replace('**field**' , 'sequence'));
				errorFlag = 2;
			}
			else
				$(this).next('.error').text('');
		});

		//Check validation for Description
		$('.summernote').each(function(){
			var textareaStr = $(this).summernote('isEmpty') ? '' : $(this).summernote('code');
			if(strip_html_tags(textareaStr) == '')
			{
				$(this).next('.note-editor').next('.error').text(please_enter_dynamic.replace('**field**' , 'Description'));
				errorFlag = 2;
			}
			else
				$(this).next('.note-editor').next('.error').text('');
		});
		e.preventDefault();
		if(errorFlag == 1)
		{
			$.ajax({
				url : 'junior_centre/save_centre_details',
				type : 'POST',
				data : $('#centreDetailsForm').serialize(),
				success : function(response){
					$('#centreDetailsModal').modal('hide');
				}
			});
		}
	});
});

function confirm_delete()
{
	if(confirm(delete_confirmation.replace('**module**' , 'Junior Centre')))
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

//Function is used to load modal table for pdf upload management dynamically
function loadPdfManagementTable(juniorCentreId , uploadPdfModalType)
{
	$("#uploadPdfModalTableWrapper").empty();
	$.ajax({
		url : 'junior_centre/get_pdf_management',
		data : {'juniorCentreId' : juniorCentreId , 'uploadPdfModalType' : uploadPdfModalType},
		type : 'POST',
		dataType : 'JSON',
		success : function(response){
			if(response.pdfManagemnetDetails)
				$("#uploadPdfModalTableWrapper").append(response.pdfManagemnetDetails);
			$("#uploadPdfModalTable").DataTable();
		}
	});
}

//Function is used to load modal table for dates management dynamically
function loaddateManagementTable(juniorCentreId)
{
	$("#dateManagementModalTableWrapper").empty();
	$.ajax({
		url : 'junior_centre/get_date_management',
		data : {'juniorCentreId' : juniorCentreId},
		type : 'POST',
		dataType : 'JSON',
		success : function(response){
			if(response.dateManagemnetDetails)
				$("#dateManagementModalTableWrapper").append(response.dateManagemnetDetails);
			$("#dateModalTable").DataTable();
		}
	});
}

//Function is used to load modal table for video gallery management dynamically
function loadvideoManagementTable(juniorCentreId)
{
	$("#videoManagementModalTableWrapper").empty();
	$.ajax({
		url : 'junior_centre/get_video_gallery_management',
		data : {'juniorCentreId' : juniorCentreId},
		type : 'POST',
		dataType : 'JSON',
		success : function(response){
			if(response.videoManagemnetDetails)
				$("#videoManagementModalTableWrapper").append(response.videoManagemnetDetails);
			$("#videoModalTable").DataTable();
		}
	});
}

//Function is used to set country dropdown as per the amchart js for international mix management
function setCountryDropdown()
{
	var worldHighObjArr = worldHighObj['svg']['g']['path'];
	worldHighObjArr.sort(function(a , b){
		var nameA = a.title.toUpperCase();
		var nameB = b.title.toUpperCase();
		if(nameA < nameB)
			return -1;
		if(nameA > nameB)
			return 1;
		return 0;
	});
	var str = '<option value="">Please Select</option>';
	$.each(worldHighObjArr , function(index , value){
		str+= '<option value="'+value['title']+'-'+value['id']+'">'+value['title']+'</option>';
	});
	$('#country_name').empty();
	$('#country_name').append(str);
}

//Function is used to load modal table for international mix management dynamically
function loadInternationalMixManagementTable(juniorCentreId)
{
	$("#internationalMixManagementModalTableWrapper").empty();
	$.ajax({
		url : 'junior_centre/get_international_mix_management',
		data : {'juniorCentreId' : juniorCentreId},
		type : 'POST',
		dataType : 'JSON',
		success : function(response){
			if(response.internationalMixManagemnetDetails)
				$("#internationalMixManagementModalTableWrapper").append(response.internationalMixManagemnetDetails);
			$("#internationalMixModalTable").DataTable();
		}
	});
}

//Function is used to load modal table for extra section content
function loadExtraSectionTable(juniorCentreId)
{
	$("#extraSectionTableWrapper").empty();
	$.ajax({
		url : 'junior_centre/get_extra_section_content',
		data : {'juniorCentreId' : juniorCentreId},
		type : 'POST',
		dataType : 'JSON',
		success : function(response){
			if(response.extraSectionDetails)
				$("#extraSectionTableWrapper").append(response.extraSectionDetails);
			$("#extraSectionTable").DataTable();
		}
	});
}

//This function is used to prepare the icon dropdown and return
function getIconDropdown(iconClassVal = '')
{
	var htmlStr = '<select name="icon_class[]" id="icon_class[]" class="selectpicker form-control">\
						<option value="fa-home" data-icon="glyphicon-home" '+((iconClassVal == 'fa-home') ? "selected" : "")+'></option>\
						<option value="fa-phone" data-icon="glyphicon-earphone" '+((iconClassVal == 'fa-phone') ? "selected" : "")+'></option>\
						<option value="fa-fax" data-icon="glyphicon-phone-alt" '+((iconClassVal == 'fa-fax') ? "selected" : "")+'></option>\
						<option value="fa-envelope" data-icon="glyphicon-envelope" '+((iconClassVal == 'fa-envelope') ? "selected" : "")+'></option>\
						<option value="fa-user" data-icon="glyphicon-user" '+((iconClassVal == 'fa-user') ? "selected" : "")+'></option>\
						<option value="fa-globe" data-icon="glyphicon-globe" '+((iconClassVal == 'fa-globe') ? "selected" : "")+'></option>\
						<option value="fa-pencil-alt" data-icon="glyphicon-pencil" '+((iconClassVal == 'fa-pencil-alt') ? "selected" : "")+'></option>\
						<option value="fa-search" data-icon="glyphicon-search" '+((iconClassVal == 'fa-search') ? "selected" : "")+'></option>\
						<option value="fa-star" data-icon="glyphicon-star" '+((iconClassVal == 'fa-star') ? "selected" : "")+'></option>\
						<option value="fa-clock" data-icon="glyphicon-time" '+((iconClassVal == 'fa-clock') ? "selected" : "")+'></option>\
						<option value="fa-lock" data-icon="glyphicon-lock" '+((iconClassVal == 'fa-lock') ? "selected" : "")+'></option>\
						<option value="fa-flag" data-icon="glyphicon-flag" '+((iconClassVal == 'fa-flag') ? "selected" : "")+'></option>\
						<option value="fa-map-marker-alt" data-icon="glyphicon-map-marker" '+((iconClassVal == 'fa-map-marker-alt') ? "selected" : "")+'></option>\
						<option value="fa-exclamation-circle" data-icon="glyphicon-exclamation-sign" '+((iconClassVal == 'fa-exclamation-circle') ? "selected" : "")+'></option>\
						<option value="fa-exclamation-triangle" data-icon="glyphicon-warning-sign" '+((iconClassVal == 'fa-exclamation-triangle') ? "selected" : "")+'></option>\
						<option value="fa-bell" data-icon="glyphicon-bell" '+((iconClassVal == 'fa-bell') ? "selected" : "")+'></option>\
						<option value="fa-graduation-cap" data-icon="glyphicon-education" '+((iconClassVal == 'fa-graduation-cap') ? "selected" : "")+'></option>\
					</select>';
	return htmlStr;
}

//This function is used to get the manage centre modal body dynamically
function getModalBody(iconClassVal = '' , titleVal = '' , detailsVal = '' , sequenceVal = '' , totalBlock = 1)
{
	htmlStr = '<div id="add_more_wrapper_'+$('#centreDetailsForm').find('#globalCount').val()+'" class="add_more_wrapper"><div class="border-box">\
					<div class="form-group">\
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Select Icon<span class="required">*</span></label>\
						<div class="col-md-9 col-sm-9 col-xs-12">\
							'+getIconDropdown(iconClassVal)+'\
							<span class="error"></span>\
						</div>\
						<div class="clearfix"></div>\
					</div>\
					<div class="form-group">\
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Title<span class="required">*</span></label>\
						<div class="col-md-9 col-sm-9 col-xs-12">\
							<input type="text" name="title[]" id="title[]" class="form-control" value="'+titleVal+'">\
							<span class="error"></span>\
						</div>\
						<div class="clearfix"></div>\
					</div>\
					<div class="form-group">\
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Details<span class="required">*</span></label>\
						<div class="col-md-9 col-sm-9 col-xs-12">\
							<textarea name="details[]" id="details[]" class="summernote">'+detailsVal+'</textarea>\
							<span class="error"></span>\
						</div>\
						<div class="clearfix"></div>\
					</div>\
					<div class="form-group">\
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Sequence<span class="required">*</span></label>\
						<div class="col-md-9 col-sm-9 col-xs-12">\
							<input type="text" name="sequence[]" id="sequence[]" class="form-control" value="'+((sequenceVal != '') ? sequenceVal : $('#centreDetailsForm').find('#globalCount').val())+'">\
							<span class="error"></span>\
						</div>\
						<div class="clearfix"></div>\
					</div>\
				</div>\
				<div style="float: right;">\
					<i class="fa fa-lg fa-plus-circle addMoreIcon add_section" aria-hidden="true" data-block_no="'+$('#centreDetailsForm').find('#globalCount').val()+'"></i>';
	if(totalBlock > 1)
		htmlStr+= '<i style="margin-left: 15px;" class="fa fa-lg fa-minus-circle removeMoreIcon add_section" aria-hidden="true" data-block_no="'+$('#centreDetailsForm').find('#globalCount').val()+'"></i>';
	htmlStr+= '</div><br></div>';
	$('#centreDetailsForm').find('#globalCount').val(parseInt($('#centreDetailsForm').find('#globalCount').val())+1);
	return htmlStr;
}

//This function is used to remove html taags from the inputted string
function strip_html_tags(str)
{
	if(str == '')
		return '';
	else
		str = str.toString();
	return str.replace(/<[^>]*>/g , '');
}

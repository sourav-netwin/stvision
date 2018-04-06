/*
	This file is used to manage all the customize javascript related operation for junior
	centre module .
	Current Version : 1.1
*/
var pageHighlightMenu = "frontweb/junior_centre";
$(window).ready(function(){
	//Add customize rules for checking image required
	jQuery.validator.addMethod('checkRequired' , function(value , element){
		if(value == '' && $('#oldImg').val() == '')
			return false;
		else
			return true;
	} , required_upload_image);

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

	$('#juniorCentre').validate({
		errorElement : 'span',
		rules : {
			centre_id : {
				required : true
			},
			centre_banner : {
				checkRequired : true,
				checkImageWidth : true,
				checkImageExt : true
			}
		},
		messages : {
			centre_id : {
				required : please_select_dynamic.replace('**field**' , 'Centre')
			}
		}
	});

	//On submit of the form check validation for required and duplicate centre
	$(document).on('submit' , '#juniorCentre' , function(e){
		if(flag == 'as')
		{
			if($('#successFlag').val() == 1)
				e.preventDefault();
			else
				return true;
		}

		if($('#juniorCentre').valid())
		{
			$programErrorFlag = $programDetailsErrorFlag = 1;

			//Check for the accommodation required validations
			if(tinyMCE.get('accommodation').getContent() == '')
			{
				$('#accommodationErrorMessage').text(please_enter_dynamic.replace('**field**' , 'Accommodation Content'));
				return false;
			}
			else
				$('#accommodationErrorMessage').text('');

			//Check for the course required validations
			if(tinyMCE.get('course').getContent() == '')
			{
				$('#courseErrorMessage').text(please_enter_dynamic.replace('**field**' , 'Course Content'));
				return false;
			}
			else
				$('#courseErrorMessage').text('');

			//Check for program section
			if($('#centre_program').val() == null)
			{
				$programErrorFlag = 2;
				$('#programErrorMessage').text(please_select_dynamic.replace('**field**' , 'Program'));
			}
			else
			{
				$('#programErrorMessage').text('');
				$programErrorFlag = 1;

				//Check for the program details section
				$('#centre_program').val().forEach(function(value , index){
					var textareaStr = $('#program_'+value).summernote('isEmpty') ? '' : $('#program_'+value).summernote('code');
					if(strip_html_tags(textareaStr) == '')
					{
						$('#programDeatilsError_'+value).text(please_enter_dynamic.replace('**field**' , 'Description'));
						$programDetailsErrorFlag = 2;
					}
					else
						$('#programDeatilsError_'+value).text('');
				});
			}

			if(flag == "as")
			{
				//Check for centre section
				$.ajax({
					url : 'duplicateCentreCheck',
					data : {'centreId' : $('#centre_id').val()},
					type : 'POST',
					dataType : 'JSON',
					success : function(response){
						if(response.status == 'ok')
						{
							$('#centreErrorMessage').text('');
							if($programErrorFlag == 1 && $programDetailsErrorFlag == 1)
							{
								$('#successFlag').val(2);
								$('#juniorCentre').submit();
							}
						}
						else
						{
							$('#centreErrorMessage').text(duplicate_dynamic.replace('**field**' , 'Centre'));
							return false;
						}
					}
				});
			}
			else
			{
				if($programErrorFlag == 1 && $programDetailsErrorFlag == 1)
				{
					$('#juniorCentre').submit();
					return true;
				}
				else
					return false;
			}
		}
	});

	//With the change of the centre banner image , check the validation of that image and load accordingly .
	$('#centre_banner').on('change' , function(){
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
						$('#imageChangeFlag').val('2');
						$('#imgWidthErrorFlag').val('1');
						$('#imgErrorMessage').text('');
						return true;
					}
				};
			};
		}
	});

	//Initialize bootstrap multiselect
	$('#centre_program').multiselect({
		buttonWidth : '498px',
		nonSelectedText: 'Please Select'
	});

	//initialize summernote
	$('.summernote').summernote({
		height: 200
	});

	//On change of the program multiselect dropdown show/hide the program details part
	$('.multiselect-container').find('.checkbox').find($('input[type="checkbox"]')).on('change' , function(){
		if($(this).is(':checked') === true)
		{
			var str = '<div class="programDetailsWrapper_'+$(this).val()+'">\
							<div class="form-group">\
								<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">\
									Details of '+$('#centre_program option[value="'+$(this).val()+'"]').text().toLowerCase()+'<span class="required">*</span>\
								</label>\
								<div class="col-md-6 col-sm-6 col-xs-12">\
									<textarea name="program_'+$(this).val()+'" id="program_'+$(this).val()+'" class="form-control summernote"></textarea>\
									<span id="programDeatilsError_'+$(this).val()+'" style="color:#ff0000;display: inline-block;margin-top: 8px;"></span>\
								</div>\
							</div>\
						</div>';
			$('.dynamicProgramDetailsClass').append(str);
			//initialize summernote
			$('.summernote').summernote({
				height: 200
			});
		}
		else
			$('.programDetailsWrapper_'+$(this).val()).remove();
	});
});

//This function is used to return string name after dot
function splitByLastDot(str)
{
	if(str != '')
	{
		var arr = str.split('.');
		return arr[1];
	}
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
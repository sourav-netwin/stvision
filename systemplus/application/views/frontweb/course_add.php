<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/style.css">

<!----------Summernote CSS and JS--------->
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/summernote.css">
<script src="<?php echo LTE; ?>frontweb/summernote.js"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
<?php
					$formAttribute = array(
						'class' => 'form-horizontal form-label-left show-custom-error-tag',
						'id' => 'courseDetails',
						'method' =>'post'
					);
					echo form_open_multipart('/frontweb/course/add' , $formAttribute);
?>
						<div class="box box-primary"><div class="box-body">
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Language<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								echo form_dropdown('language_id' , getLanguageDetails() , '1' , 'class="form-control" id="language_id"');
?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Course title<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'name' => 'course_name',
									'id' => 'course_name',
									'class' => 'form-control',
									'placeholder' => 'Course Title'
								);
								echo form_input($inputFieldAttribute);
?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Description<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'name' => 'corse_description',
									'id' => 'corse_description',
									'class' => 'form-control summernote'
								);
								echo form_textarea($inputFieldAttribute);
?>
								<span id="descriptionErrorMessage" style="color:#ff0000"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Course image (Banner) <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="hidden" id="imgWidthErrorFlag" value="1" />
								<label for="course_image">
									<img class="uploadImageProgramClass" height="50" width="180" src="<?php echo LTE.'frontweb/no_flag.jpg'; ?>"/>
								</label>
<?php
								$inputFieldAttribute = array(
									'id' => 'course_image',
									'name' => 'course_image',
									'type' => 'file',
									'style' => 'visibility: hidden;',
									'data-widthErrorClassRef' => 'imgWidthErrorFlag'
								);
								echo form_input($inputFieldAttribute);
?>
								<small style="display:block">
									( Note: Only JPG|JPEG|PNG images are allowed <br> &amp; Image dimension should be greater or equal to <?php echo COURSE_WIDTH; ?> X <?php echo COURSE_HEIGHT; ?> pixel )
								</small>
								<span id="imgErrorMessage" style="color:#ff0000"><?php echo ($imageError != '') ? $imageError : ''; ?></span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Home page image <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="hidden" id="imgWidthErrorFlagHome" value="1" />
								<label for="course_front_image">
									<img class="uploadImageProgramClassHome" height="50" width="180" src="<?php echo LTE.'frontweb/no_flag.jpg'; ?>"/>
								</label>
<?php
								$inputFieldAttribute = array(
									'id' => 'course_front_image',
									'name' => 'course_front_image',
									'type' => 'file',
									'style' => 'visibility: hidden;',
									'data-widthErrorClassRef' => 'imgWidthErrorFlagHome'
								);
								echo form_input($inputFieldAttribute);
?>
								<small style="display:block">
									( Note: Only JPG|JPEG|PNG images are allowed <br> &amp; Image dimension should be greater or equal to <?php echo COURSE_FRONT_WIDTH; ?> X <?php echo COURSE_FRONT_HEIGHT; ?> pixel )
								</small>
								<span id="imgErrorMessageHome" style="color:#ff0000"><?php echo ($imageErrorHome != '') ? $imageErrorHome : ''; ?></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Course specification Available</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="checkbox" id="specificationAvailable" value="1" checked />
							</div>
						</div>
						<div class="ln_solid"></div><hr>

<!-------------------------Course Specification Section Start-------------------------->
						<div class="courseSpecificationWrapper">
							<div class="x_title">
								<h2>Course specification</h2>
								<ul class="nav navbar-right panel_toolbox"></ul>
								<div class="clearfix"></div>
							</div>
							<input type="hidden" id="global_more_count" value="1" />
							<div class="form-group">
								<div id="add_more_wrapper_1" class="add_more_wrapper">
									<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Specification<span class="required">*</span></label>
									<div class="col-md-3 col-sm-3 col-xs-12">
<?php
										$inputFieldAttribute = array(
											'name' => 'specification_option[1]',
											'id' => 'specification_option[1]',
											'class' => 'form-control',
											'placeholder' => 'Specification Option'
										);
										echo form_input($inputFieldAttribute);
?>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-12">
<?php
										$inputFieldAttribute = array(
											'name' => 'specification_value[1]',
											'id' => 'specification_value[1]',
											'class' => 'form-control',
											'placeholder' => 'Specification Value'
										);
										echo form_input($inputFieldAttribute);
?>
									</div>
									<div class="col-md-1 col-sm-1">
										<i class="fa fa-lg fa-plus-circle add_more_icon" aria-hidden="true"></i>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
						<div class="ln_solid"></div>
<!------------------------Course Specification Section END--------------------------->

						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<?php
								$inputFieldAttribute = array(
									'class' => 'btn btn-success',
									'value' => 'Submit'
								);
								echo form_submit($inputFieldAttribute);

								$inputFieldAttribute = array(
									'class' => 'btn btn-primary',
									'content' => 'Cancel',
									'onclick' => "window.location = '".base_url()."index.php/frontweb/course'",
									'style' => 'margin-left: 10px;'
								);
								echo form_button($inputFieldAttribute);
?>
							</div>
						</div>
						</div></div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script type = "text/javascript">
	var pageHighlightMenu = "frontweb/course";
	$(document).ready(function(){
		var selectedLanguage = [];

		//Add custom validation rules and messages
		jQuery.validator.addMethod("validData",function(value,element){
			if(/[()+<>\"\'%&;]/.test(value)){
					return false;
			}else{
				return true;
			}
		} , "<?php echo $this->lang->line('valid_data_error_msg'); ?>");

		jQuery.validator.addMethod("checkImageWidth",function(value,element){
			if($('#'+element.getAttribute('data-widthErrorClassRef')).val() == 2){
					return false;
			}else{
				return true;
			}
		} , "");

		jQuery.validator.addMethod("checkImageExt" , function (value , element){
			if(value)
			{
				if(splitByLastDot(value).toLowerCase() == 'jpg' || splitByLastDot(value).toLowerCase() == 'png' || splitByLastDot(value).toLowerCase() == 'jpeg')
					return true;
				else
					return false;
			}
			else
				return true;
		} , "<?php echo $this->lang->line('image_type_error_msg'); ?>");

		//Initialize jquery validator for input fields
		$('#courseDetails').validate({
			errorElement : 'span',
			rules : {
				language_id : {
					required : true ,
				},
				course_name : {
					required : true,
					validData : true
				},
				corse_description : {
					required : true,
					validData : true
				},
				course_image : {
					required : true ,
					checkImageWidth : true,
					checkImageExt : true
				},
				course_front_image : {
					required : true ,
					checkImageWidth : true,
					checkImageExt : true
				},
				'specification_option[1]' : {
					required : true,
					validData : true
				},
				'specification_value[1]' : {
					required : true,
					validData : true
				}
			},
			messages : {
				language_id : {
					required : "<?php echo str_replace('**field**' , 'Language' , $this->lang->line('please_enter_dynamic')); ?>"
				},
				course_name : {
					required : "<?php echo str_replace('**field**' , 'Course Title' , $this->lang->line('please_enter_dynamic')); ?>"
				},
				corse_description : {
					required : "<?php echo str_replace('**field**' , 'Course Description' , $this->lang->line('please_enter_dynamic')); ?>"
				},
				course_image : {
					required : "<?php echo $this->lang->line('required_upload_image'); ?>"
				},
				course_front_image : {
					required : "<?php echo $this->lang->line('required_upload_image'); ?>"
				},
				'specification_option[1]' : {
					required : "<?php echo str_replace('**field**' , 'Specification Option' , $this->lang->line('please_enter_dynamic')); ?>"
				},
				'specification_value[1]' : {
					required : "<?php echo str_replace('**field**' , 'Specification Value' , $this->lang->line('please_enter_dynamic')); ?>"
				},
			},
			submitHandler : function(){
				var textareaStr = $('#corse_description').summernote('isEmpty') ? '' : $('#corse_description').summernote('code');
				if(strip_html_tags(textareaStr) == '')
				{
					$('#descriptionErrorMessage').text("<?php echo str_replace('**field**' , 'Description' , $this->lang->line('please_enter_dynamic')); ?>");
					return false;
				}
				else
				{
					$('#descriptionErrorMessage').text('');
					$('#courseDetails').submit();
					return true;
				}
			}
		});

		//On the change of course image it checks the validation and show the image
		$('#course_image').on('change' , function(){
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
						if(!(this.height >= <?php echo COURSE_HEIGHT; ?> && this.width >= <?php echo COURSE_WIDTH; ?>))
						{
							$('#imgWidthErrorFlag').val('2');
							$('#imgErrorMessage').text("<?php echo str_replace(array('**width**' , '**height**') , array(COURSE_WIDTH , COURSE_HEIGHT) , $this->lang->line('minimum_image_dimension')); ?>");
							return false;
						}
						else
						{
							$('#imgWidthErrorFlag').val('1');
							$('#imgErrorMessage').text('');
							return true;
						}
					}
				}
			}
		});

		//On the change of Home page image it checks the validation and show the image
		$('#course_front_image').on('change' , function(){
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
						$('.uploadImageProgramClassHome').attr('src' , this.src);
						if(!(this.height >= <?php echo COURSE_FRONT_HEIGHT; ?> && this.width >= <?php echo COURSE_FRONT_WIDTH; ?>))
						{
							$('#imgWidthErrorFlagHome').val('2');
							$('#imgErrorMessageHome').text("<?php echo str_replace(array('**width**' , '**height**') , array(COURSE_FRONT_WIDTH , COURSE_FRONT_HEIGHT) , $this->lang->line('minimum_image_dimension')); ?>");
							return false;
						}
						else
						{
							$('#imgWidthErrorFlagHome').val('1');
							$('#imgErrorMessageHome').text('');
							return true;
						}
					}
				}
			}
		});

		//After click on the plus icon it will append same rows
		$(document).on('click' , '.add_more_icon' , function(){
			if($('.add_more_wrapper').length == 1)
				$(this).attr('class' , 'fa fa-lg fa-minus-circle remove_more_icon');
			else
				$(this).css('display' , 'none');
			$('#global_more_count').val((parseInt($('#global_more_count').val())+1));
			var dynamic_count = $('#global_more_count').val();
			var str = '<div id="add_more_wrapper_'+dynamic_count+'" class="add_more_wrapper">\
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Specification<span class="required">*</span></label>\
							<div class="col-md-3 col-sm-3 col-xs-12">\
								<input type="text" name="specification_option['+dynamic_count+']" value="" id="specification_option['+dynamic_count+']" class="form-control" placeholder="Specification Option">\
							</div>\
							<div class="col-md-3 col-sm-3 col-xs-12">\
								<input type="text" name="specification_value['+dynamic_count+']" value="" id="specification_value['+dynamic_count+']" class="form-control" placeholder="Specification Value">\
							</div>\
							<div class="col-md-1 col-sm-1">\
								<i class="fa fa-lg fa-minus-circle remove_more_icon" aria-hidden="true"></i>\
								<i class="fa fa-lg fa-plus-circle add_more_icon" aria-hidden="true"></i>\
							</div>\
							<div class="clearfix"></div>\
						</div>';
			$('#'+$(this).parent().parent().attr('id')).after(str);
			$("input[name*='specification_option["+dynamic_count+"]']").rules("add", {
				required : true ,
				validData : true ,
				messages : {
					required: "<?php echo str_replace('**field**' , 'Specification Option' , $this->lang->line('please_enter_dynamic')); ?>"
				}
			});
			$("input[name*='specification_value["+dynamic_count+"]']").rules("add", {
				required : true ,
				validData : true ,
				messages : {
					required: "<?php echo str_replace('**field**' , 'Specification Value' , $this->lang->line('please_enter_dynamic')); ?>"
				}
			});
		});

		//After click on the minus icon it will delete that row
		$(document).on('click' , '.remove_more_icon' , function(){
			if($(this).parent().find('.add_more_icon').css('display') == 'inline-block')
				$(this).parent().parent().prev().find('.add_more_icon').css('display' , 'inline-block');
			$('#'+$(this).parent().parent().attr('id')).remove();
			if($('.add_more_wrapper').length == 1)
			{
				if($('.add_more_wrapper').find('.add_more_icon').length == 1)
					$('.add_more_wrapper').find('.remove_more_icon').css('display' , 'none');
				else
					$('.add_more_wrapper').find('.remove_more_icon').attr('class' , 'fa fa-lg fa-plus-circle add_more_icon');
			}
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

		//initialize summernote
		$('.summernote').summernote({
			height: 200
		});

		//Onchange of the course specification available checkbox show/hide the specification section
		$(document).on('change' , '#specificationAvailable' , function(){
			if($(this).is(':checked') === true)
				$('.courseSpecificationWrapper').show();
			else
				$('.courseSpecificationWrapper').hide();
		});
	});
</script>
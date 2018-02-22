<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>

<!------------Tinymce JS------------->
<script src="<?php echo LTE; ?>frontweb/tinymce/tinymce.min.js"></script>

<style>
    .radlbl{
        cursor: pointer;
        margin-right: 15px;
    }
</style>
<script type="text/javascript">
    var pageHighlightMenu = "frontweb/cmsmenu";
    $(document).ready(function(){
    var BASE_PATH = "<?php echo base_url();?>index.php/";
    $('#frmContent').validate({
        rules:{
            txtwebpageurl:{
                required:true
            },
            pdffile:{
            <?php if (!empty($edit_id)) { ?>
            required:true,
            <?php } ?>
                accept:'pdf'
            },
            en_txtbrowsertitle:{
                required:true
            },
            en_txtpagetitle:{
                required:true
            },
            en_txtpageurl:{
                required:true,
                remote:{
                    url: BASE_PATH + "frontweb/cmsmenu/check_url_exists/<?php echo $edit_menu_id; ?>",
                    type: "post",
                    data: {
                        "link": function(){ return $("#en_txtpageurl").val(); }
                    }
                }
            },
            en_txtContent:{
                required:true

            }
        },
        messages: {
            webpageurl:{
                required:"Please enter web page url."
            },
            pdffile:{
                required:"Please select pdf file.",
                accept:"Please select proper pdf file."
            },
            en_txtbrowsertitle:{
                required:"Please enter browser title."
            },
            en_txtpagetitle:{
                required:"Please enter page title."
            },
            en_txtpageurl:{
                required:"Please enter page url.",
                remote:"This url is already taken."
            },
            en_txtContent:{
                required:"Please enter content."
            }
        }
    });

    // onload setting
    $("#rad_pdf_tab").hide();
    $("#rad_url_tab").hide();
    $('input[type=radio][name=content_radio]').change(function() {
        if (this.value == 'content') {
            $("#rad_content_tab").show();
            $("#rad_pdf_tab").hide();
            $("#rad_url_tab").hide();
        }
        else if (this.value == 'pdf') {
            $("#rad_content_tab").hide();
            $("#rad_pdf_tab").show();
            $("#rad_url_tab").hide();
        }
        else{
            $("#rad_content_tab").hide();
            $("#rad_pdf_tab").hide();
            $("#rad_url_tab").show();
        }
    });

    $("#en_txtpageurl").blur();

    var contentType = '<?php echo $content->cont_content_type; ?>';
    if(contentType == 1)
        $("#rad_content").trigger("click");
    else if(contentType == 2)
        $("#rad_pdf").trigger("click");
    else if(contentType == 3)
        $("#rad_url").trigger("click");

    var menuType = '<?php echo $content->mnu_type; ?>';
    if(menuType == "Other"){
        $(".notOther").hide();
    }
});
</script>
<div class="row">
    <div class="col-sm-12">
            <div class="box box-primary" >
                <div class="box-header with-border">
                    <h3 class="box-title">Add/edit content</h3>
                </div>
                <div class="box-body" >
                    <div class="error">* indicates required field.</div>
                    <div class="dialog1">
                        <form id="frmContent" action="<?php echo base_url(); ?>index.php/frontweb/cmsmenu/content<?php echo (!empty($edit_menu_id) ? '/' . $edit_menu_id : ''); ?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
                            <input type="hidden" id="hidd_edit_menu_id" name="hidd_edit_menu_id" value="<?php echo $edit_menu_id; ?>" >
                            <input type="hidden" id="hidd_menu_type" name="hidd_menu_type" value="<?php echo $content->mnu_type; ?>" >
                            <div class="form-group row">
                                <label class="col-sm-3 control-label">Menu Title<span class="error" ></span></label>
                                <div class="col-sm-6">
                                    <label class="control-label"><?php echo (isset($content->mnu_menu_name) ? $content->mnu_menu_name : ''); ?></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label">Content Type<span class="error" >*</span></label>
                                <div class="col-sm-6">
                                    <input checked="checked" type="radio" value="content" class="form-control-radio" id="rad_content" name="content_radio" autocomplete="off">
                                    <label class="radlbl" for="rad_content">Content</label>
                                    <input type="radio" value="pdf" class="form-control-radio notOther" id="rad_pdf" name="content_radio" autocomplete="off">
                                    <label class="radlbl notOther" for="rad_pdf">Pdf</label>
                                    <input type="radio" value="url" class="form-control-radio notOther" id="rad_url" name="content_radio" autocomplete="off">
                                    <label class="radlbl notOther" for="rad_url">Url</label>
                                </div>
                            </div>
                            <div id="rad_url_tab">
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label">Web page url<span class="error" >*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" value="<?php echo set_value('txtwebpageurl', isset($content->cont_external_url) ? $content->cont_external_url : ''); ?>" class="form-control" id="txtwebpageurl" name="txtwebpageurl">
                                        <span class="error"><?php echo form_error('txtwebpageurl'); ?></span>
                                        <span><?php echo anchor_popup(prep_url($content->cont_external_url), prep_url($content->cont_external_url), array('width' => '800', 'height' => '600', 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0')); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div id="rad_pdf_tab">
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label">Browser Pdf<span class="error" >*</span></label>
                                    <div class="col-sm-6">
                                        <input type="file" value="" id="pdffile" name="pdffile">
                                        <span class="error"><?php echo form_error('pdffile'); ?></span>
                                        <span><?php echo anchor_popup("../".CAMPUS_CONTENT_PDF_FILE . $content->cont_pdf_file, $content->cont_pdf_file, array('width' => '800', 'height' => '600', 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0')); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div id="rad_content_tab">
                                <div class="form-group row notOther">
                                    <label class="col-sm-3 control-label">Browser Title<span class="error" >*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" value="<?php echo set_value('en_txtbrowsertitle', isset($content->cont_browser_title) ? $content->cont_browser_title : ''); ?>" class="form-control" id="en_txtbrowsertitle" name="en_txtbrowsertitle">
                                        <span class="error"><?php echo form_error('en_txtbrowsertitle'); ?></span>
                                    </div>
                                </div>
                                <div class="form-group row notOther">
                                    <label class="col-sm-3 control-label">Page Title<span class="error" >*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" value="<?php echo set_value('en_txtpagetitle', isset($content->cont_page_title) ? $content->cont_page_title : ''); ?>" class="form-control" id="en_txtpagetitle" name="en_txtpagetitle">
                                        <span class="error"><?php echo form_error('en_txtpagetitle'); ?></span>
                                    </div>
                                </div>
                                <div class="form-group row notOther">
                                    <label class="col-sm-3 control-label">Page URL<span class="error" >*</span></label>
                                    <div class="col-sm-6">
                                        <label style="width:250px;"><?php echo $this->config->item('front_url'); ?>content/</label>
                                        <input type="text" value="<?php echo set_value('en_txtpageurl', isset($content->cont_url_name) ? $content->cont_url_name : ''); ?>" class="form-control form-url" id="en_txtpageurl" name="en_txtpageurl" >
                                        <span class="error"><?php echo form_error('en_txtpageurl'); ?></span>
                                    </div>
                                </div>
                                <div class="form-group row notOther">
                                    <label class="col-sm-3 control-label">Meta Description</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" id="en_txtmetadescription" name="en_txtmetadescription"><?php echo set_value('en_txtmetadescription', isset($content->cont_meta_description) ? $content->cont_meta_description : ''); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row notOther">
                                    <label class="col-sm-3 control-label">Keywords</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" id="en_txtkeywords" name="en_txtkeywords"><?php echo set_value('en_txtkeywords', isset($content->cont_keywords) ? $content->cont_keywords : ''); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label">Content<span class="error" >*</span></label>
                                    <span class="error"><?php echo form_error('en_txtContent'); ?></span>
                                    <div class="col-sm-8">
                                        <textarea id="en_txtContent" name="en_txtContent" class="form-control tinymce"><?php echo set_value('en_txtContent', isset($content->cont_content) ? $content->cont_content : ''); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <input type="submit" id="en_submit" name="en_submit" value="Update" class="btn btn-primary" />
                                    <input type="button" id="submit" value="Cancel" class="btn btn-primary" onclick="javascript:window.location.href='<?php echo base_url(); ?>index.php/frontweb/cmsmenu'"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>
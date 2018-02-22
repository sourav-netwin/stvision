<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">

<section class="content">
  <div class="row">

    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
          <div class="row">
            <div class="col-sm-6 btn-create">
              <a href="<?php echo base_url(); ?>index.php/backoffice/cmsAddCampus" class="btn btn-primary btn-sm" id="createClass" ><i class="fa fa-plus"></i>&nbsp;Add new campus</a>
            </div>
            <?php showSessionMessageIfAny($this);?>
          </div>
        </div>
        <div class="box-body">
          <table id="dataTableCampusRooms" style="width:99.98%" class="campus_table datatable table table-bordered table-striped">
            <thead>
              <tr>
                <th>Campus name</th>
                <th>School name</th>
                <th>Location</th>
                <th>Mail</th>
                <th class="no-sort">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              	if( $campus )
              	{
              		foreach( $campus as $cam )
              		{
              ?>
                <tr>
                    <td id="td_<?php echo $cam['id'];?>" <?php if($cam["attivo"]==0){ ?> style="color:#f00;"<?php } ?>><?php echo $cam["nome_centri"]?></td>
                    <td><?php echo $cam["school_name"]?></td>
                    <td><?php echo $cam["located_in"]?></td>
                    <td><?php echo $cam["cm_mail"]?></td>
                    <td class="text-center">
                        <div class="btn-group custom-btn-group">
                          <span>
                          	<a id="uploadCampusWebImage" data-cam-id="<?php echo $cam["id"]?>" data-img="<?php echo $cam['website_image'];?>" href="javascript:void(0);" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-info min-wd-20" data-original-title="Website image for <?php echo $cam["nome_centri"]?>">
                              <i class="fa fa-file-image-o"></i>
                            </a>
                          </span><span>
                          	<a href="<?php echo base_url(); ?>index.php/backoffice/cmsEditCampus/<?php echo $cam["id"]?>" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-info min-wd-20" data-original-title="Edit campus <?php echo $cam["nome_centri"]?>">
                              <i class="fa fa-edit"></i>
                            </a>
                          </span><span>
                            <a href="<?php echo base_url(); ?>index.php/backoffice/cmsManageExcursions/planned/<?php echo $cam["id"]?>" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-success min-wd-20" data-original-title="Edit planned excursions for <?php echo $cam["nome_centri"]?>">
                              <i class="fa fa-globe"></i>
                            </a>
                          </span><span>
                            <a href="<?php echo base_url(); ?>index.php/backoffice/cmsManageExcursions/extra/<?php echo $cam["id"]?>" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-primary min-wd-20" data-original-title="Edit extra excursions for <?php echo $cam["nome_centri"]?>">
                              <i class="fa fa-star"></i>
                            </a>
                          </span><span>
                            <a href="<?php echo base_url(); ?>index.php/backoffice/cmsManageExcTraCampus/<?php echo $cam["id"]?>/transfer" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-warning min-wd-20" data-original-title="Edit transfers for <?php echo $cam["nome_centri"]?>">
                              <i class="fa fa-plane"></i>
                            </a>
                          </span><span>
                            <a href="<?php echo base_url(); ?>index.php/backoffice/cmsManageDatesCampus/<?php echo $cam["id"]?>" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-default min-wd-20" data-original-title="Edit arrival dates for <?php echo $cam["nome_centri"]?>">
                              <i class="fa fa-calendar"></i>
                            </a>
                          </span>
                        </div>
                        <div class="btn-group custom-btn-group">
                        <span>
                            <a href="<?php echo base_url(); ?>index.php/backoffice/cmsManageCampusAvailability/<?php echo $cam["id"]?>" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-danger min-wd-20" data-original-title="Manage campus availability for <?php echo $cam["nome_centri"]?>">
                              <i class="fa fa-cogs"></i>
                            </a>
                          </span><span data-toggle="tooltip" data-original-title="Upload PDFs for <?php echo $cam["nome_centri"]?>">
                              <!-- pdfModal .campus_pdf -->
                            <a href="javascript:void(0);" class="btn btn-xs btn-info min-wd-20 campus_single_pdfs" data-toggle="modal" data-target="#singlePdfsModal" data-original-title="Upload PDFs for <?php echo $cam["nome_centri"]?>" data-id="<?php echo $cam["id"]?>"> 
                              <i class="fa fa-file-pdf-o"></i>
                            </a>
                          </span><span data-toggle="tooltip" data-original-title="Upload images for <?php echo $cam["nome_centri"]?>">
                            <a href="javascript:void(0);" class="btn btn-xs btn-success min-wd-20 campus_image" data-toggle="modal" data-target="#imageModal" data-original-title="Upload images for <?php echo $cam["nome_centri"]?>" data-id="<?php echo $cam["id"]?>">
                              <i class="fa fa-file-image-o"></i>
                            </a>
                          </span><span data-toggle="tooltip" data-original-title="Upload PDF for <?php echo $cam["nome_centri"]?>">
                            <a href="javascript:void(0);" class="btn btn-xs btn-primary min-wd-20 campus_single_pdf" data-toggle="modal" data-target="#singlePdfModal" data-original-title="Upload PDF for <?php echo $cam["nome_centri"]?>" data-id="<?php echo $cam["id"]?>">
                              <i class="fa fa-file-pdf-o"></i>
                            </a>
                          </span><span data-toggle="tooltip" data-original-title="Add video for <?php echo $cam["nome_centri"]?>">
                            <a href="javascript:void(0);" class="btn btn-xs btn-warning min-wd-20 campus_video" data-toggle="modal" data-target="#videoModal" data-original-title="Upload video for <?php echo $cam["nome_centri"]?>" data-id="<?php echo $cam["id"]?>">
                              <i class="fa fa-vimeo"></i>
                            </a>
                          </span><span >
                                <a href="javascript:void(0);" data-toggle="modal" class="btn btn-xs btn-danger min-wd-20 changeStatus" data-original-title="Change status" data-status="<?php echo $cam['attivo'];?>" data-id="<?php echo $cam["id"];?>" >
                                    <i class="fa <?php echo ($cam['attivo'] == '1' ? 'fa-check-square-o' : 'fa-square-o');?>"></i>
                                </a>
                            </span>
                            

                        </div>
                      </td>
                    </tr>
              <?php
                  }
                }
              ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Campus name</th>
                <th>School name</th>
                <th>Location</th>
                <th>Mail</th>
                <th>Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          &nbsp;
        </div>
        <!-- /.box-footer-->
      </div>
    </div>
  </div>

  <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="pdfModalLabel">Upload PDFs</h4>
        </div>
        <div class="modal-body">
          <form class="validate" name="campus_upload_pdf_form" id="campus_upload_pdf_form" action="<?php echo base_url(); ?>index.php/backoffice/cmsUploadPdf" method="POST" enctype="multipart/form-data">

            <div class="form-group">
              <label for="pdf_file_title_1">Factsheets</label>
              <input type="text" class="form-control" name="pdf_file_title_1" id="pdf_file_title_1" placeholder="Enter title">
            </div>
            <div class="form-group">
              <label for="pdf_file_1">Upload PDF</label>
              <input type="file" name="pdf_file_1" id="pdf_file_1">
              <span id="pdf_file_name_1"></span>
            </div>

            <div class="form-group">
              <label for="pdf_file_title_2">Excursions</label>
              <input type="text" class="form-control" name="pdf_file_title_2" id="pdf_file_title_2" placeholder="Enter title">
            </div>
            <div class="form-group">
              <label for="pdf_file_2">Upload PDF</label>
              <input type="file" name="pdf_file_2" id="pdf_file_2">
              <span id="pdf_file_name_2"></span>
            </div>

            <div class="form-group">
              <label for="pdf_file_title_3">Prices</label>
              <input type="text" class="form-control" name="pdf_file_title_3" id="pdf_file_title_3" placeholder="Enter title">
            </div>
            <div class="form-group">
              <label for="pdf_file_3">Upload PDF</label>
              <input type="file" name="pdf_file_3" id="pdf_file_3">
              <span id="pdf_file_name_3"></span>
            </div>

            <input type="hidden" id="pdf_campus_id" name="pdf_campus_id" value="">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="upload_pdf_btn">Upload</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="imageModalLabel">Upload image</h4>
        </div>
        <div class="modal-body">
          <form name="campus_upload_image_form" id="campus_upload_image_form" action="<?php echo base_url(); ?>index.php/backoffice/cmsUploadImage" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="campus_image_file_title">Title</label>
              <input type="text" class="form-control" name="campus_image_file_title" id="campus_image_file_title" placeholder="Enter title">
            </div>
            <div class="form-group">
              <label for="campus_image_category">Category</label>
              <select class="form-control" name="campus_image_category" id="campus_image_category">
                <option value="">Select category</option>
                <option value="college">College</option>
                <option value="city">City</option>
                <option value="student">Student</option>
              </select>
            </div>
            <div class="form-group">
              <label for="campus_image_file">Upload Image</label>
              <input type="file" name="campus_image_file" id="campus_image_file">
            </div>
            <input type="hidden" id="campus_id" name="campus_id" value="">
          </form>

          <div id="campus_image_table"></div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="upload_image_btn">Upload</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="singlePdfModal" tabindex="-1" role="dialog" aria-labelledby="singlePdfModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="pdfModalLabel">Upload PDF</h4>
        </div>
        <div class="modal-body">
          <form class="validate" name="campus_upload_single_pdf_form" id="campus_upload_single_pdf_form" action="<?php echo base_url(); ?>index.php/backoffice/cmsUploadSinglePdf" method="POST" enctype="multipart/form-data">

            <div class="form-group">
              <label for="campus_pdf_file_title">Title</label>
              <input type="text" class="form-control" name="campus_pdf_file_title" id="campus_pdf_file_title" placeholder="Enter title">
            </div>
            <div class="form-group">
              <label for="campus_pdf_file">Upload PDF</label>
              <input type="file" name="campus_pdf_file" id="campus_pdf_file">
            </div>

            <input type="hidden" id="single_pdf_campus_id" name="single_pdf_campus_id" value="">
          </form>

          <div id="campus_single_pdf_table"></div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="upload_single_pdf_btn">Upload</button>
        </div>
      </div>
    </div>
  </div>
    
<div class="modal fade" id="singlePdfsModal" tabindex="-1" role="dialog" aria-labelledby="singlePdfsModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="singlePdfsModalCampus">Upload PDF for Agent</h4>
        </div>
        <div class="modal-body">
          <form class="validate" name="campus_upload_single_pdfs_form" id="campus_upload_single_pdfs_form" action="<?php echo base_url(); ?>index.php/backoffice/cmsUploadSinglePdfs" method="POST" enctype="multipart/form-data">

            <div class="form-group">
              <label for="campus_pdfs_file_title">Title</label>
              <input type="text" class="form-control" name="campus_pdfs_file_title" id="campus_pdfs_file_title" placeholder="Enter title">
            </div>
            <div class="form-group">
              <label for="campus_pdfs_file">Upload PDF</label>
              <input type="file" name="campus_pdfs_file" id="campus_pdfs_file">
            </div>

            <input type="hidden" id="single_pdfs_campus_id" name="single_pdfs_campus_id" value="">
          </form>

          <div id="campus_single_pdfs_table"></div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="upload_single_pdfs_btn">Upload</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="videoModalLabel">Add videos</h4>
        </div>
        <div class="modal-body">
          <form class="validate" name="campus_upload_video_form" id="campus_upload_video_form" action="<?php echo base_url(); ?>index.php/backoffice/cmsUploadVideo" method="POST">

            <div class="form-group">
              <label for="campus_video_1">Vimeo URL</label>
              <input type="text" class="form-control" name="campus_video_1" id="campus_video_1" placeholder="Enter vimeo URL">
            </div>

            <div class="form-group">
              <label for="campus_video_2">Vimeo URL</label>
              <input type="text" class="form-control" name="campus_video_2" id="campus_video_2" placeholder="Enter vimeo URL">
            </div>

            <div class="form-group">
              <label for="campus_video_3">Vimeo URL</label>
              <input type="text" class="form-control" name="campus_video_3" id="campus_video_3" placeholder="Enter vimeo URL">
            </div>

            <div class="form-group">
              <label for="campus_video_4">Vimeo URL</label>
              <input type="text" class="form-control" name="campus_video_4" id="campus_video_4" placeholder="Enter vimeo URL">
            </div>

            <input type="hidden" id="video_campus_id" name="video_campus_id" value="">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="upload_video_btn">Save</button>
        </div>
      </div>
    </div>
  </div>
    
<div class="modal fade" id="uploadWebImage" tabindex="-1" role="dialog" aria-labelledby="webImageModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <form class="validate" enctype="multipart/form-data" name="campus_upload_web_img_form" id="campus_upload_web_img_form" action="<?php echo base_url(); ?>index.php/backoffice/uploadCampusWebImage" method="POST">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="webImageModalLabel">Add/change website image</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                <label for="webImage">Upload website image</label>
                <input type="file" name="webImage" id="webImage" />
                </div>
                <input type="hidden" id="webimage_campus_id" name="webimage_campus_id" value="">
                <input type="hidden" id="webimage_old_file" name="webimage_old_file" value="">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="upload_video_btn">Save</button>
            </div>
        </form>
      </div>
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group">
                    <label >Existing image</label>
                </div>
                <div class="form-group" style="text-align: center;">
                    <img id="existWebImage" src="" /> 
                </div>
            </div>
        </div>
    </div>
  </div>

</section>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/additional-methods.min.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<script type="text/javascript">
  $(function(){
    
    $( "body" ).on( "click", "#uploadCampusWebImage", function() {
        $("#webimage_campus_id").val($(this).attr('data-cam-id'));
        var defaultImage = "default.jpg";
        if($(this).attr('data-img') != "")
            defaultImage = $(this).attr('data-img');
        $("#existWebImage").attr("src","<?php echo base_url().CAMPUS_WEBSITE_IMAGE;?>" + defaultImage);
        $("#webimage_old_file").val($(this).attr('data-img'));
        $("#uploadWebImage").modal('show');
    });
    var web_image_validator = $("#campus_upload_web_img_form").validate({
      errorElement:"div",
      ignore: "",
      rules: {
        webImage: {
          required: true
        }
      },
      messages: {
        webImage: {
          required: "Please select image to upload"
        }
      },
      submitHandler: function(form) {
        form.submit();
      }
    });
    $('#uploadWebImage').on('show.bs.modal', function (e) {
      web_image_validator.resetForm();
    });

    $( "body" ).on( "click", ".changeStatus", function() {
        var thisEle = $(this);
        var id = $(this).attr('data-id');
        var status = $(this).attr('data-status');
        confirmAction("Are you sure to change active/inactive status?", function(c)
        {
            if(c)
            {
                $.post( "<?php echo base_url();?>index.php/backoffice/campus_change_status",{'id':id,'status':status}, function( data ) {
                    if(parseInt(data.result)){
                        if(parseInt(data.status))
                        {
                            //color:#f00; td_cid
                            thisEle.children().switchClass('fa-square-o','fa-check-square-o',1);
                            thisEle.attr('data-status',data.status);
                            $("#td_"+id).css('color','#333');
                        }
                        else
                        {
                            thisEle.children().switchClass('fa-check-square-o','fa-square-o',1);
                            thisEle.attr('data-status',data.status);
                            $("#td_"+id).css('color','#f00');
                        }
                    }
                    else{

                    }
                },'json');
            }
        },true,true);
    });
    
    
    $(".campus_pdf").click(function(){
      $("#campus_upload_pdf_form #pdf_campus_id").val($(this).attr('data-id'));

      $("#pdf_file_title_1").val("");
      $("#pdf_file_title_2").val("");
      $("#pdf_file_title_3").val("");
      $("#pdf_file_1").val("");
      $("#pdf_file_2").val("");
      $("#pdf_file_3").val("");
      $("#pdf_file_name_1").html("");
      $("#pdf_file_name_2").html("");
      $("#pdf_file_name_3").html("");

      $.ajax({
        url: siteUrl+'backoffice/getCampusPdf',
        type: 'POST',
        dataType: 'json',
        data: {'campus_id':$(this).attr('data-id')},
        success: function(data){
          if(data)
          {
            $("#pdf_file_title_1").val( data.campus_pdf.pdf_title_1 );
            $("#pdf_file_title_2").val( data.campus_pdf.pdf_title_2 );
            $("#pdf_file_title_3").val( data.campus_pdf.pdf_title_3 );

            if( typeof data.campus_pdf.pdf_path_1 != 'undefined' && data.campus_pdf.pdf_path_1 != "")
              $("#pdf_file_name_1").html( '<a href="<?php echo base_url() . CAMPUS_PDF_PATH ?>'+data.campus_pdf.pdf_path_1+'" target="_blank">'+data.campus_pdf.pdf_path_1+'</a>' );

            if( typeof data.campus_pdf.pdf_path_2 != 'undefined' && data.campus_pdf.pdf_path_2 != "" )
              $("#pdf_file_name_2").html( '<a href="<?php echo base_url() . CAMPUS_PDF_PATH ?>'+data.campus_pdf.pdf_path_2+'" target="_blank">'+data.campus_pdf.pdf_path_2+'</a>' );

            if( typeof data.campus_pdf.pdf_path_3 != 'undefined' && data.campus_pdf.pdf_path_3 != "" )
              $("#pdf_file_name_3").html( '<a href="<?php echo base_url() . CAMPUS_PDF_PATH ?>'+data.campus_pdf.pdf_path_3+'" target="_blank">'+data.campus_pdf.pdf_path_3+'</a>' );
          }
        }
      });

    });

    $(".campus_image").click(function(){
      $("#campus_image_file_title").val("");
      $("#campus_image_file").val("");
      $("#campus_image_category").val("");
      $("#campus_upload_image_form #campus_id").val($(this).attr('data-id'));

      $.ajax({
        url: siteUrl+'backoffice/getCampusImage',
        type: 'POST',
        dataType: 'json',
        data: {'campus_id':$(this).attr('data-id')},
        success: function(data){
          if(data)
          {
            $("#campus_image_table").html( data.campus_image_table );
            $("#dataTableCampusImage").dataTable({
              "columnDefs": [
                {
                  "targets"  : 'no-sort',
                  "orderable": false
                }
              ]
            });
          }
        }
      });

    });

    $("#upload_pdf_btn").click(function(){
      $("#campus_upload_pdf_form").submit();
    });

    $.validator.addMethod("special_character_regex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\s'"]+$/i.test(value);
    }, "Title must contain only letters, numbers, or quotes");

    var pdf_validator = $("#campus_upload_pdf_form").validate({
      errorElement:"div",
      ignore: "",
      rules: {
        pdf_file_title_1: {
          required: function(){
              if($("#pdf_file_1").val() != "")
                  return true;
              else
                  return false;
          },
          special_character_regex: true
        },
        pdf_file_1:
        {
          required: function(element) {
            return ( $('#pdf_file_title_1').val() != "" && $("#pdf_file_name_1").html() == "")
          },
          extension: "pdf"
        },
        pdf_file_title_2: {
          required: function(){
              if($("#pdf_file_2").val() != "")
                  return true;
              else
                  return false;
          },
          special_character_regex: true
        },
        pdf_file_2: {
          required: function(element) {
            return ( $('#pdf_file_title_2').val() != "" && $("#pdf_file_name_2").html() == "")
          },
          extension: "pdf"
        },
        pdf_file_title_3: {
          required: function(){
              if($("#pdf_file_3").val() != "")
                  return true;
              else
                  return false;
          },
          special_character_regex: true
        },
        pdf_file_3: {
          required: function(element) {
            return ( $('#pdf_file_title_3').val() != "" && $("#pdf_file_name_3").html() == "")
          },
          extension: "pdf"
        }
      },
      messages: {
        pdf_file_title_1: {
          required: "Please enter title"
        },
        pdf_file_1: {
          required: "Please choose file",
          extension: "Please upload only pdf file"
        },
        pdf_file_title_2: {
          required: "Please enter title"
        },
        pdf_file_2: {
          required: "Please choose file",
          extension: "Please upload only pdf file"
        },
        pdf_file_title_3: {
          required: "Please enter title"
        },
        pdf_file_3: {
          required: "Please choose file",
          extension: "Please upload only pdf file"
        }
      },
      submitHandler: function(form) {
        if($("#pdf_file_1").val() != "" || $("#pdf_file_2").val() != "" || $("#pdf_file_3").val() != ""){
            loading("Files being uploaded, please be patient.");
            form.submit();
        }
        else if(($("#pdf_file_name_1").html() != "") || $("#pdf_file_name_2").html() != "" || $("#pdf_file_name_3").html() != ""){
            loading("Files being uploaded, please be patient.");
            form.submit();
        }
        else{
            swal("Error","Please select at least one file to upload");
        }
      }
    });

    $("#upload_image_btn").click(function(){
      $("#campus_upload_image_form").submit();
    });

    var image_validator = $("#campus_upload_image_form").validate({
      errorElement:"div",
      ignore: "",
      rules: {
        campus_image_file_title: {
          required: true,
          special_character_regex: true
        },
        campus_image_file: {
          required: true,
          extension: "jpg|jpeg"
        },
        campus_image_category: {
          required: true
        }
      },
      messages: {
        campus_image_file_title: {
          required: "Please enter title"
        },
        campus_image_file: {
          required: "Please choose file",
          extension: "Please upload only jpg images"
        },
        campus_image_category: {
          required: "Please select category"
        }
      },
      submitHandler: function(form) {
        form.submit();
      }
    });

    $('#pdfModal').on('show.bs.modal', function (e) {
      pdf_validator.resetForm();
    });

    $('#imageModal').on('show.bs.modal', function (e) {
      image_validator.resetForm();
    });

    $(".campus_single_pdf").click(function(){
      $("#campus_pdf_file_title").val("");
      $("#campus_pdf_file").val("");
      $("#campus_upload_single_pdf_form #single_pdf_campus_id").val($(this).attr('data-id'));

      $.ajax({
        url: siteUrl+'backoffice/getCampusSinglePdf',
        type: 'POST',
        dataType: 'json',
        data: {'campus_id':$(this).attr('data-id')},
        success: function(data){
          if(data)
          {
            $("#campus_single_pdf_table").html( data.campus_single_pdf_table );
            $("#dataTableCampusSinglePdf").dataTable({
              "columnDefs": [
                {
                  "targets"  : 'no-sort',
                  "orderable": false
                }
              ]
            });
          }
        }
      });
    });

    $("#upload_single_pdf_btn").click(function(){
      $("#campus_upload_single_pdf_form").submit();
    });
    
    $(".campus_single_pdfs").click(function(){
      $("#campus_pdfs_file_title").val("");
      $("#campus_pdfs_file").val("");
      $("#campus_upload_single_pdfs_form #single_pdfs_campus_id").val($(this).attr('data-id'));

      $.ajax({
        url: siteUrl+'backoffice/getCampusSinglePdfsForAgent',
        type: 'POST',
        dataType: 'json',
        data: {'campus_id':$(this).attr('data-id')},
        success: function(data){
          if(data)
          {
            $("#campus_single_pdfs_table").html( data.campus_single_pdfs_table );
            $("#dataTableCampusSinglePdfsForAgent").dataTable({
              "columnDefs": [
                {
                  "targets"  : [1,3],
                  "orderable": false
                }
              ]
            });
            $("#seqMe").trigger("click");
          }
        }
      });
    });
    
    $("#upload_single_pdfs_btn").click(function(){
      $("#campus_upload_single_pdfs_form").submit();
    });
    
    $('#singlePdfsModal').on('show.bs.modal', function (e) {
      single_pdfs_validator.resetForm();
    });

        var single_pdfs_validator = $("#campus_upload_single_pdfs_form").validate({
        errorElement:"div",
        ignore: "",
        rules: {
            campus_pdfs_file_title: {
            required: true,
            special_character_regex: true
            },
            campus_pdfs_file:
            {
            required: true,
            extension: "pdf"
            }
        },
        messages: {
            campus_pdfs_file_title: {
            required: "Please enter title"
            },
            campus_pdfs_file: {
            required: "Please choose file",
            extension: "Please upload only pdf file"
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
        });
    
    

    $('#singlePdfModal').on('show.bs.modal', function (e) {
      single_pdf_validator.resetForm();
    });

    var single_pdf_validator = $("#campus_upload_single_pdf_form").validate({
      errorElement:"div",
      ignore: "",
      rules: {
        campus_pdf_file_title: {
          required: true,
          special_character_regex: true
        },
        campus_pdf_file:
        {
          required: true,
          extension: "pdf"
        }
      },
      messages: {
        campus_pdf_file_title: {
          required: "Please enter title"
        },
        campus_pdf_file: {
          required: "Please choose file",
          extension: "Please upload only pdf file"
        }
      },
      submitHandler: function(form) {
        form.submit();
      }
    });

    $(".campus_video").click(function(){
      $("#campus_upload_video_form #video_campus_id").val($(this).attr('data-id'));

      $("#campus_video_1").val("");
      $("#campus_video_2").val("");
      $("#campus_video_3").val("");
      $("#campus_video_4").val("");

      $.ajax({
        url: siteUrl+'backoffice/getCampusVideo',
        type: 'POST',
        dataType: 'json',
        data: {'campus_id':$(this).attr('data-id')},
        success: function(data){
          if(data)
          {
            $("#campus_video_1").val( data.campus_video.campus_video_1 );
            $("#campus_video_2").val( data.campus_video.campus_video_2 );
            $("#campus_video_3").val( data.campus_video.campus_video_3 );
            $("#campus_video_4").val( data.campus_video.campus_video_4 );
          }
        }
      });

    });

    $("#upload_video_btn").click(function(){
      $("#campus_upload_video_form").submit();
    });

    $('#videoModal').on('show.bs.modal', function (e) {
      campus_video_validator.resetForm();
    });

    $.validator.addMethod('custom_vimeo_url', function (value) {
      if( value == '' )
        return true;
      return value.match(/^(https\:\/\/(vimeo\.com)\/(((.+)\/(.+))\/([0-9]+)|([0-9]+)))/);
    }, 'Please enter a valid vimeo URL.');

    var campus_video_validator = $("#campus_upload_video_form").validate({
      errorElement:"div",
      ignore: "",
      rules: {
        campus_video_1:
        {
          custom_vimeo_url: true
        },
        campus_video_2:
        {
          custom_vimeo_url: true
        },
        campus_video_3:
        {
          custom_vimeo_url: true
        },
        campus_video_4:
        {
          custom_vimeo_url: true
        }
      },
      submitHandler: function(form) {
        form.submit();
      }
    });
    
    /* this is upload PDFs modal script starts here */
    var loadingImg = "<span class='imgLoading loadingSpan' style='float:right;position:absolute;'><img  src='<?php echo base_url() . 'img/tuition/throbber.gif' ?>' /></span>"
    var saveAlert = "<span class='saveAlert loadingSpan' style='float:right;position:absolute;color:green;'>Saved!</span>"
    $('body').on('change','.updatePdfSequence', function () {
        var $control = $(this);
        var pdfId = $(this).attr('data-id');
        var sequence = $(this).val();
        var campus_id = $(this).attr("data-campus-id");
        if (sequence == '' || sequence < 0 || sequence > 100) {
            $(this).addClass('err-border');
            return;
        }
        $(this).removeClass('err-border');
        $control.parent().append(loadingImg);
        $.post("<?php echo base_url(); ?>index.php/backoffice/updatepdfsequence", 
        { 'pdfId': pdfId, 'sequence': sequence,'campus_id':campus_id}, function (data) {
            $("#txtSequence" + pdfId).val(data.result);
            $control.parent().find(".imgLoading").replaceWith(saveAlert);
            $control.parent().find(".saveAlert").fadeOut(4500);
        }, 'json');
    });
    // update file title
    $('body').on('change','.updateFileTitle', function () {
        var $control = $(this);
        var pdfId = $(this).attr('data-id');
        var fileTitle = $(this).val();
        var campus_id = $(this).attr("data-campus-id");
        if (fileTitle == '') {
            $(this).addClass('err-border');
            return;
        }
        $(this).removeClass('err-border');
        $control.parent().append(loadingImg);
        $.post("<?php echo base_url(); ?>index.php/backoffice/updatepdfsequence/title", 
        { 'pdfId': pdfId, 'fileTitle': fileTitle,'campus_id':campus_id}, function (data) {
            if(parseInt(data.result))
            {
                $control.parent().find(".imgLoading").replaceWith(saveAlert);
                $control.parent().find(".saveAlert").fadeOut(4500);
            }else
            {
                $control.addClass('err-border');
            }
            
        }, 'json');
    });
    
    
  });
</script>
<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header with-borde">
            <h3 class="box-title">Select type</h3>
            <label class="mr-right-15 handCursor"><input <?php echo ($pricetype == 'campus' ? 'checked' : '');?> class="changeType handCursor" type="radio" id="radCampus" name="priceType" value="campus" /> Campus</label>
            <label class="handCursor"><input <?php echo ($pricetype == 'transfer' ? 'checked' : '');?> class="changeType handCursor" type="radio" id="radTransfer" name="priceType" value="transfer" /> Transfers</label>
            <?php showSessionMessageIfAny($this,"",$errorMessage);?>
        </div>
        <div class="box-body">
            <form class="validate" name="frmPricelistUpload" id="frmPricelistUpload" action="<?php echo base_url(); ?>index.php/pricelistpdf/pricelist" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="campus_pdf_file_title">Title</label>
                            <input type="text" class="form-control" name="campus_pdf_file_title" id="campus_pdf_file_title" placeholder="Enter title">
                        </div>
                        <div class="form-group">
                            <label for="campus_pdf_file">Upload PDF</label>
                            <input type="file" name="campus_pdf_file" id="campus_pdf_file">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="hidden" name="hiddPriceType" value="<?php echo $pricetype;?>" />
                            <input class="btn btn-primary" type="submit" id="btnUpload" name="btnUpload" value="Upload" />
                            <input class="btn btn-danger" type="reset" id="btnCancel" name="btnCancel" value="Cancel" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="box-body">
          <table id="dataTableCampusSinglePdf" class="campus_table datatable table table-bordered table-striped" style="width:99.98%">
            <thead>
                <tr>
                    <th>PDF title</th>
                    <th>PDF path</th>
                    <th class="no-sort">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if($pricelistData)
                foreach( $pricelistData as $pdfFile )
                {
                ?>
                    <tr>
                    <td><?php echo $pdfFile["pricelist_title"]?></td>
                    <td><a href="<?php echo base_url() . CAMPUS_PRICELIST_PDF_PATH. $pdfFile["pricelist_pdf_path"] ?>" target="_blank"><?php echo $pdfFile["pricelist_pdf_path"]?></a></td>
                    <td class="text-center">
                        <div class="btn-group">
                            <span>
                                <a href="<?php echo base_url(); ?>index.php/pricelistpdf/deletepdf/<?php echo $pricetype ."/" . $pdfFile["pricelist_pdf_id"]?>" data-toggle="tooltip" data-container="body" class="btn btn-xs btn-danger min-wd-24" data-original-title="Delete PDF">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </span>
                        </div>
                    </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
            <tfoot>
            <tr>
                <th>PDF title</th>
                <th>PDF path</th>
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
<style>
    .handCursor{
        cursor: pointer;
    }
</style>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script>
    var pageHighlightMenu = "pricelistpdf/pricelist";
    $(document).ready(function() {
        $( "body" ).on( "change", "[name='priceType']", function() {
           var excType = $(this).val();
           if(excType == "transfer")
               window.location.href = "<?php echo base_url().'index.php/pricelistpdf/pricelist/transfer';?>";
           else
               window.location.href = "<?php echo base_url().'index.php/pricelistpdf/pricelist/campus';?>";
        });
        
        $("#frmPricelistUpload").validate({
                //errorElement:"div",
                ignore: [],
                rules: {
                        campus_pdf_file_title: {
                                required: true
                        },
                        campus_pdf_file: {
                                required: true
                        }
                },
                messages: {
                        campus_pdf_file_title: "Plase enter file tile.",
                        campus_pdf_file: "Plase select file to upload."
                },
                submitHandler: function(form) {
                        form.submit();
                }
        });
       
    });
</script>
<section class="content">
  <div class="row">

    <div class="col-md-4">
      <!-- DIRECT SEARCH PRIMARY -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Select date</h3>
        </div>
      	<!-- /.box-header -->
    		<!-- /.box-body -->
        <div class="box-footer">
          <div class="input-group">
            <input id="dateStart" name="dateStart" type="text" class="form-control" readonly="readonly">
            <span class="input-group-btn">
            	<button class="btn btn-primary btn-flat" name="inviaO" id="inviaO">Retrieve data</button>
          	</span>
          </div>
        </div>
        <!-- /.box-footer-->
      </div>
      <!--/.direct-chat -->
    </div>
  </div>    
</section>

<div class="modal fade" id="dialog_modal_retrive_data" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel">
    <div class="modal-dialog" role="document" style="width:90%;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="booking_modal_title">Bookings detail</h4>
        </div>
        <div class="modal-body">
          <div id="retriveDataDiv" class="modal-body"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<input type="hidden" value="" name="hidDate" id="hidDate" />
<input type="hidden" value="" name="typeForCsv" id="typeForCsv" />
<input type="hidden" value="" name="accoForCsv" id="accoForCsv" />
<input type="hidden" value="" name="accoForChList" id="accoForChList" />
<input type="hidden" value="" name="accoForBook" id="accoForBook" />
<input type="hidden" value="" name="transDate" id="transDate" />

<script src="<?php echo base_url() ?>js/jquery.browser.min.js"></script>	
<script src="<?php echo base_url() ?>js/jquery.printElement.min.js"></script>
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<link href="<?php echo LTE; ?>plugins/iCheck/all.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script> 
    
	$(document).ready(function() {
		
		$( "#dateStart" ).datepicker({
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",
			maxDate: "+1Y"
		}).datepicker("setDate", new Date());
		
		$('#inviaO').on('click', function(e) {
			var selDate = $('#dateStart').val();
			if( selDate == '' || typeof selDate == 'undefined' )
			{
				swal("Error","Please select a date");
				return false;
			}
			var selDateAct = selDate;
			selDate = selDate.replace(/\//g, '-');
			var diaH = $(window).height()* 0.9;
			e.preventDefault();

			$.post( "<?php echo base_url();?>index.php/backoffice/reviewByDate/",{
                'date':selDate
            }, function( data ) {
            	$("#retriveDataDiv").html('');
                $("#dialog_modal_retrive_data").modal("show");
                $("#retriveDataDiv").html(data);
                $("#booking_modal_title").html('Review by date - '+selDateAct);
            });

	      	setTimeout(function(){
	          unloading();
	      	},3000);

		});
		
	});
</script>
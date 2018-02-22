<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
          <div class="row">
            <?php showSessionMessageIfAny($this);?>
          </div>
        </div>

        <form class="form-horizontal validate" name="openTicketForm" id="openTicketForm" action="<?php echo site_url() ?>/backoffice/openTicket" method="POST" onsubmit="return btnDsbl()" enctype="multipart/form-data">

          <div class="box-body">

            <div class="form-group">
              <label class="col-sm-2 control-label" for="priority">Priority</label>
              <div class="col-sm-6 col-md-4">
                <label class="radio-inline">
                  <input type="radio" name="priority" value="low" <?php echo $priority == 'low' ? 'checked' : '' ?>> <span style="color: #05ca05">Low</span>
                </label>
                <label class="radio-inline">
                  <input type="radio" name="priority" value="medium" <?php echo $priority == 'medium' ? 'checked' : '' ?>> <span style="color: #d0c100">Medium</span>
                </label>
                <label class="radio-inline">
                  <input type="radio" name="priority" value="high" <?php echo $priority == 'high' ? 'checked' : '' ?>> <span style="color: #FF0000">High</span>
                </label>
                <div class="error"><?php echo form_error('priority');?></div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="selCategory">Category</label>
              <div class="col-sm-6 col-md-4">
                <select class="form-control" id="selCategory" name="selCategory">
                  <option value="">Select category</option>
                  <option <?php echo $category == 'HEALTH & SAFETY' ? 'selected' : '' ?> value="HEALTH & SAFETY">HEALTH & SAFETY</option>
                  <option <?php echo $category == 'ATTRACTION' ? 'selected' : '' ?> value="ATTRACTION">ATTRACTION</option>
                  <option <?php echo $category == 'BULLYING' ? 'selected' : '' ?> value="BULLYING">BULLYING</option>
                  <option <?php echo $category == 'CUSTOMER CARE' ? 'selected' : '' ?> value="CUSTOMER CARE">CUSTOMER CARE</option>
                  <option <?php echo $category == 'FACILITIES' ? 'selected' : '' ?> value="FACILITIES">FACILITIES</option>
                  <option <?php echo $category == 'TRANSPORTATION' ? 'selected' : '' ?> value="TRANSPORTATION">TRANSPORTATION</option>
                  <option <?php echo $category == 'CATERING' ? 'selected' : '' ?> value="CATERING">CATERING</option>
                  <option <?php echo $category == 'OTHERS' ? 'selected' : '' ?> value="OTHERS">OTHERS</option>
                  <option <?php echo $category == 'HOME STAY' ? 'selected' : '' ?> value="HOME STAY">HOME STAY</option>
                  <option <?php echo $category == 'ACTIVITY ON CAMPUS' ? 'selected' : '' ?> value="ACTIVITY ON CAMPUS">ACTIVITY ON CAMPUS</option>
                  <option <?php echo $category == 'PLUS STAFF' ? 'selected' : '' ?> value="PLUS STAFF">PLUS STAFF</option>
                </select>
                <div class="error"><?php echo form_error('selCategory');?></div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="tktTitle">Title</label>
              <div class="col-sm-6 col-md-4">
                <input class="form-control" type="text" name="tktTitle" id="tktTitle" value="">
                <div class="error"><?php echo form_error('tktTitle');?></div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="tktContent">Text</label>
              <div class="col-sm-6 col-md-4">
                <textarea class="form-control" name="tktContent" id="tktContent"><?php echo empty($content) ? '' : $content ?></textarea>
                <div class="error"><?php echo form_error('tktContent');?></div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="fileAttachment">Attachment</label>
              <div class="col-sm-6 col-md-4">
                <input type="file" id="fileAttachment" name="fileAttachment"/>
                <div class="fileInfo">Max. file size allowed is 2 MB</div>
                <div class="error"><?php echo form_error('fileAttachment');?></div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="selRefBooking">Reference booking</label>
              <div class="col-sm-6 col-md-4">
                <select class="form-control" name="selRefBooking" id="selRefBooking">
                  <option value="all">All</option>
                  <?php
                  if ($bookings) {
                    foreach ($bookings as $booking) {
                      ?>
                      <option <?php echo $booking['booking_id'] == $refBook ? 'selected' : '' ?> value="<?php echo $booking['booking_id'] ?>"><?php echo $booking['booking_id'] ?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
                <div class="error"><?php echo form_error('selRefBooking');?></div>
              </div>
            </div>

            <div class="form-group">
              <div class="form-data col-sm-10 col-md-offset-2">
                <input class="btn btn-primary" id="btnSave" name="btnSave" value="Submit" type="submit"/>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
              &nbsp;
          </div>
          <!-- /.box-footer-->
        </form>
      </div>
    </div>
  </div>
</section>
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script>
  function btnDsbl(){
    if($('input:radio[name=priority]:checked').val() != '' && typeof $('input:radio[name=priority]:checked').val() != 'undefined'  && $('#selCategory').val() != '' && $('#tktTitle').val() != '' && $('#tktContent').val() != '' && $('#selRefBooking').val() != '' ){
      $('#btnSave').prop('disabled', true);
      return true;
    }
  }

  $(function(){
    $("#openTicketForm").validate({
      errorElement:"div",
      ignore: "",
      rules: {
        priority: "required",
        selCategory: "required",
        tktTitle: "required",
        tktContent: "required",
        selRefBooking: "required"
      },
      messages: {
        priority: "Please select priority",
        selCategory: "Please select category",
        tktTitle: "Please enter title",
        tktContent: "Please enter text",
        selRefBooking: "Please select reference booking"
      },
      errorPlacement: function(error, element) {
        if ( element.is(':radio') )
        {
          error.appendTo($("input[name='priority']").last().parent().parent());
        }
        else
        {
          error.insertAfter(element);
        }
      },
      submitHandler: function(form) {
        form.submit();
      }
    });
  });
</script>

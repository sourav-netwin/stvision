<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
          <div class="row">
            <?php showSessionMessageIfAny($this);?>
          </div>
        </div>

        <form class="form-horizontal validate" name="falseForm" id="falseForm" action="" method="POST">

          <div class="box-body">

            <input type="hidden" id="gl_select" name="gl_select" value="all" />

            <div class="form-group">
              <label class="col-sm-2 control-label" for="ee_select">Attractions</label>
              <div class="col-sm-6">
                <select class="form-control" id="ee_select" name="ee_select">
                  <option value="">Choose an attraction</option>
                  <?php foreach($excursions as $exc) { ?>
                  <option value="<?php echo $exc["pat_id"] ?>"><?php echo ucfirst($exc["pat_name"]) ?> (<?php echo ucfirst($exc["patt_name"]) ?>)  <?php echo $exc["cou_descrizione"] ?> | <?php echo $exc["cit_descrizione"] ?></option> 
                  <?php } ?>  
                </select>
                <div class="error"><?php echo form_error('ee_select');?></div>
              </div>
            </div>

            <div class="form-group" style="display:none;" id="rowAmount">
              <label class="col-sm-2 control-label" for="amountRec">Amount received <span id="retrievedCurr"></label>
              <div class="col-sm-6">
                <input class="form-control" type="text" name="amountRec" id="amountRec" value="0,00">
                <div class="error"><?php echo form_error('amountRec');?></div>
              </div>
            </div>

            <div class="form-group" style="display:none;" id="complprices">
              <label class="col-sm-2 control-label" for="amountRec">Group leader total price</label>
              <div class="col-sm-6" style="margin-top: 7px;"></div>
            </div>

            <div class="form-group" style="display:none;" id="slprices">
              <label class="col-sm-2 control-label" for="amountRec">Students total price</label>
              <div class="col-sm-6" style="margin-top: 7px;"></div>
            </div>

            <div class="form-group" style="display:none;" id="fee">
              <label class="col-sm-2 control-label" for="amountRec">Fee</label>
              <div class="col-sm-6" style="margin-top: 7px;"></div>
            </div>

            <div class="form-group" style="display:none;" id="allprices">
              <label class="col-sm-2 control-label" for="amountRec">Total price</label>
              <div class="col-sm-6" style="margin-top: 7px;"></div>
            </div>
            <?php if($this -> session -> userdata('role') == 200){ ?>
            <input type="hidden" name="passTOTPAX" id="passTOTPAX" value="<?php echo $numALL ?>" />
            <input type="hidden" name="passPRICE" id="passPRICE" value="" />
            <input type="hidden" name="passCURRENCY" id="passCURRENCY" value="" />  
            <input type="hidden" name="passCAMPUS" id="passCAMPUS" value="<?php echo $idCampus ?>" /> 
            <input type="hidden" name="passATTR" id="passATTR" value="" />

            <div class="form-group">
              <div class="form-data col-sm-10 col-md-offset-2">
                <input class="btn btn-primary bookForGroup" id="btnSave" name="btnSave" value="Book this attraction for group <?php echo $bookTitle ?>" type="button"/>
              </div>
            </div>
            <?php } ?>
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
  pageHighlightMenu = "backoffice/ca_viewAllBookings";
  $(document).ready(function() {

    $("#falseForm").validate({
      errorElement:"div",
      ignore: "",
      rules: {
        ee_select: "required"
      },
      messages: {
        ee_select: "Please choose an attraction"
      },
      submitHandler: function(form) {
        form.submit();
      }
    });

    $("#ee_select").val("");
    $("#passPRICE").val("");
    $("#passCURRENCY").val("");
    $("#passATTR").val("");
    
    $(".bookForGroup").click(function() {
      if( $("#falseForm").valid() )
      {
        var patt = /^[0-9]+\,[0-9][0-9]$/;
        var result = patt.test($("#amountRec").val());

        if(!result)
        {
          alert("You have to insert an amount with two decimal places, comma separated");
          return void(0);
        }
        else
        {
          if(confirm("Are you sure you want to book this attraction for the selected group declaring to have received an amount of "+$("#amountRec").val()+" "+$("#passCURRENCY").val()+" from the agent?"))
          {
            window.location.replace("<?php echo base_url(); ?>index.php/backoffice/bookCA_AttractionForGroup/bookExc_<?php echo $bookId ?>_<?php echo $yearId ?>_"+$("#ee_select").val()+"_<?php echo $idCampus ?>_<?php echo $numALL ?>_"+$("#passPRICE").val().replace(",","comma")+"_"+$("#passCURRENCY").val()+"_"+$("#amountRec").val().replace(",","comma"));
          }
        }
      }
    });

    $("#ee_select").change(function(){
      $("#passATTR").val($(this).val());
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>index.php/backoffice/ca_getPriceForAttraction/"+$(this).val()+"/<?php echo $numGL ?>/<?php echo $numSTD ?>",
        success: function(msg){
          if (msg != '')
          {
            $("#rowAmount").show();
            arrMsg = msg.split("___");
            priceForGL = (arrMsg[0].replace(",",".")*1).toFixed(2).replace(".",",");
            priceForSTD = (arrMsg[1].replace(",",".")*1).toFixed(2).replace(".",",");
            totalPrice = ((arrMsg[1].replace(",",".")*1)+(arrMsg[0].replace(",",".")*1)+10*1).toFixed(2).replace(".",",");
            $("#passPRICE").val(totalPrice);
            $("#passCURRENCY").val(arrMsg[2]);
            $("#retrievedCurr").html("("+arrMsg[2]+")");
            $("#complprices").show();
            $("#slprices").show();
            $("#fee").show();
            $("#allprices").show();
            $("#complprices .col-sm-4").html("<font style='color:#f00;'>"+priceForGL+" "+arrMsg[2]+"</font> (for <?php echo $numGL ?> GL)");
            $("#slprices .col-sm-4").html("<font style='color:#f00;'>"+priceForSTD+" "+arrMsg[2]+"</font> (for <?php echo $numSTD ?> STD)");
            $("#fee .col-sm-4").html("<font style='color:#f00;'>10,00 "+arrMsg[2]+"</font>");
            $("#allprices .col-sm-4").html("<font style='color:#f00;'>"+totalPrice+" "+arrMsg[2]+"</font>");
          }
          else
          {
            $("#complprices").html('');
            $("#slprices").html('');
            $("#fee").html('');
            $("#allprices").html('<em>No prices retrieved</em>');
          }
        }
      });
    });
    
  });  
</script>

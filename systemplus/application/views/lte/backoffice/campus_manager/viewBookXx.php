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
              <label class="col-sm-2 control-label" for="ee_select">Extra excursion</label>
              <div class="col-sm-6">
                <select class="form-control" id="ee_select" name="ee_select">
                  <option value="">Choose an excursion</option>
                  <?php foreach($excursions as $exc) { ?>
                  <option value="<?php echo $exc["exc_id"] ?>"><?php echo ucfirst($exc["exc_length"]) ?> - <?php echo $exc["exc_excursion"] ?></option> 
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
              <label class="col-sm-2 control-label" for="amountRec">Excursion total price</label>
              <div class="col-sm-6" style="margin-top: 7px;">
                <font style='color:#f00;'></font>
              </div>
            </div>

            <div class="form-group" style="display:none;" id="allprices">
              <label class="col-sm-2 control-label" for="amountRec">Price per pax (only Students)</label>
              <div class="col-sm-6" style="margin-top: 7px;">
                <font style='color:#f00;'></font>
              </div>
            </div>
            <?php if($this -> session -> userdata('role') == 200){ ?>
            <input type="hidden" name="passNUMSTD" id="passNUMSTD" value="" />
            <input type="hidden" name="passPRICESTD" id="passPRICESTD" value="" />
            <input type="hidden" name="passCURRENCY" id="passCURRENCY" value="" />

            <div class="form-group">
              <div class="form-data col-sm-10 col-md-offset-2">
                <input class="btn btn-primary bookForGroup" id="btnSave" name="btnSave" value="Book this excursion for group <?php echo $bookTitle ?>" type="button"/>
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
        ee_select: "Please choose an excursion"
      },
      submitHandler: function(form) {
        form.submit();
      }
    });

    $("#ee_select").val("");
    $("#passNUMSTD").val("");
    $("#passPRICESTD").val("");
    $("#passCURRENCY").val("");
    
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
          if(confirm("Are you sure you want to book this excursion for the selected group declaring to have received an amount of "+$("#amountRec").val()+" "+$("#passCURRENCY").val()+" from the agent?"))
          {
            window.location.replace("<?php echo base_url(); ?>index.php/backoffice/bookCA_ExtraExcursionForGroup/bookExc_"+$("#ee_select").val()+"_<?php echo $bookId ?>_noCode_"+$("#amountRec").val().replace(",","comma"));
          }
        }
      }
    });

    $("#ee_select").change(function(){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>index.php/agents/bestBusPriceForExcursion/"+$(this).val()+"/<?php echo $numALL ?>/<?php echo $numSTD ?>",
        success: function(msg){
          if (msg != '')
          {
            $("#rowAmount").show();
            arrMsg = msg.split("___");
            $("#passNUMSTD").val(arrMsg[0]);
            $("#passPRICESTD").val(arrMsg[1]);
            $("#passCURRENCY").val(arrMsg[2]);
            if( arrMsg[2] != "" )
              $("#retrievedCurr").html("("+arrMsg[2]+")");
            $("#complprices").show();
            $("#allprices").show();
            $("#complprices font").html((arrMsg[1].replace(",",".")*<?php echo $numSTD ?>).toFixed(2).replace(".",",")+" "+arrMsg[2]).show();
            $("#allprices font").html(arrMsg[1]+" "+arrMsg[2]).show();
          }
          else
          {
            $("#complprices").html('');
            $("#allprices").html('<em>No prices retrieved</em>');
          }
        }
      }); 
    });
    
  });  
</script>

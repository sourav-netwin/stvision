<style>
    div#accomodations, span.accocentro {
        display: none;
    }

span.datearrivo {
    border-right: 1px solid #f00;
    color: #000;
    font-weight: bold;
    padding: 0 5px;
}
.ui-datepicker {
  font-size: smaller;
}
.invalid{
    color: red;
}
</style>
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <?php showSessionMessageIfAny($this);?>
            </div>
            <div class="box">
                <div class="box-body">
                    <form action="<?php echo base_url(); ?>index.php/agents/insertGroup" name="enrolform" id="enrolform" class="grid12" method="POST">

                            <div class="box-header with-border mr-bot-10">
                                <h3 class="box-title">Product and destination</h3>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3 col-md-3">
                                    <label class="mr-left-10" for="prod_select">
                                        <strong>Product</strong>
                                    </label>
                                </div>
                                <div class="form-data col-sm-9 col-md-9 col-lg-6 <?php echo (isset($form['error']['prod_select']) ? 'has-error' : ''); ?>">
                                    <select  autocomplete="off" name=prod_select id=prod_select class="search required form-control" data-placeholder="Choose a product">
                                        <option value="">Select product</option>
                                        <option value="1" <?php echo (isset($form['data']['prod_select']) && 1 == $form['data']['prod_select'] ? 'selected' : ''); ?>>Plus Junior Summer</option>
                                    </select>
                                    <?php if (isset($form['error']['prod_select'])) {?>
                                    <span class="invalid">
                                        Please Provide Product
                                    </span>
                                        <?php }?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3 col-md-3">
                                    <label class="mr-left-10" for="center_select">
                                        <strong>Center</strong>
                                    </label>
                                </div>
                                <div class="form-data col-sm-9 col-md-9 col-lg-6 <?php echo (isset($form['error']['center_select']) ? 'has-error' : ''); ?>">
                                    <select  autocomplete="off" name=center_select id=center_select class="search required form-control" data-placeholder="Choose a destination">
                                        <option value="">Select center</option>
                                        <?php
if (count($centri)) {
    foreach ($centri as $key => $item) {
        if (1 == $item["attivo"]) {
            ?>
                                                    <option value="<?php echo $item['id']; ?>" <?php echo (isset($form['data']['center_select']) && $item['id'] == $form['data']['center_select'] ? 'selected' : ''); ?>><?php echo $item['nome_centri']; ?></option>
                                                    <?php
}
    }
}
?>
                                    </select>
                                    <?php if (isset($form['error']['center_select'])) {?>
                                    <span class="invalid">
                                        Please Provide Center
                                    </span>
                                        <?php }?>
                                </div>
                            </div>


                            <div class="box-header with-border mr-bot-10">
                                <h3 class="box-title">Students accomodations</h3>
                            </div>
                            <div class="form-group row" id="row_st_en" <?php echo isset($form['data']['center_select']) && !empty($form['data']['center_select']) ? "" : "style='display:none;'" ?>>
                                <div class="col-sm-3 col-md-3">
                                <label class="mr-left-10" for="st_ensuite">
                                    <strong>Ensuite</strong>
                                </label>
                                    </div>
                                <div class="form-data col-sm-9 col-md-9 col-lg-6 <?php echo (isset($form['error']['sum_stud']) && !empty($form['data']['center_select']) && empty($form['data']['sum_stud']) ? 'has-error' : ''); ?>">
                                    <input class="contastudenti form-control" data-type="spinner" type="number" name=st_ensuite id="st_ensuite" value="<?php echo isset($form['data']['st_ensuite']) ? $form['data']['st_ensuite'] : 0 ?>" min="0" max="500" />
                                </div>
                            </div>
                            <div class="form-group row" id="row_st_st" <?php echo isset($form['data']['center_select']) && !empty($form['data']['center_select']) ? "" : "style='display:none;'" ?>>
                                <div class="col-sm-3 col-md-3">
                                <label class="mr-left-10" for="st_standard">
                                    <strong>Standard</strong>
                                </label>
                                </div>
                                <div class="form-data col-sm-9 col-md-9 col-lg-6 <?php echo (isset($form['error']['sum_stud']) && !empty($form['data']['center_select']) && empty($form['data']['sum_stud']) ? 'has-error' : ''); ?>">
                                    <input class="contastudenti form-control" data-type="spinner" type="number" name=st_standard id=st_standard value="<?php echo isset($form['data']['st_standard']) ? $form['data']['st_standard'] : 0 ?>" min="0" max="500" />
                                </div>
                            </div>
                            <div class="form-group row" id="row_st_ho" <?php echo isset($form['data']['center_select']) && !empty($form['data']['center_select']) ? "" : "style='display:none;'" ?>>
                                <div class="col-sm-3 col-md-3">
                                <label class="mr-left-10" for="st_homestay">
                                    <strong>Homestay</strong>
                                </label>
                                </div>
                                <div class="form-data col-sm-9 col-md-9 col-lg-6 <?php echo (isset($form['error']['sum_stud']) && !empty($form['data']['center_select']) && empty($form['data']['sum_stud']) ? 'has-error' : ''); ?>">
                                    <input class="contastudenti form-control" data-type="spinner" type="number" name=st_homestay id=st_homestay value="<?php echo isset($form['data']['st_homestay']) ? $form['data']['st_homestay'] : 0 ?>" min="0" max="500" />
                                    <?php if (isset($form['error']['sum_stud']) && !empty($form['data']['center_select']) && empty($form['data']['sum_stud'])) {?>
                                        <span class="invalid">
                                            No Students enrolled!
                                        </span>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="form-group row" id="row_st_tw" style="display:none;">
                                <div class="col-sm-3 col-md-3">
                                <label class="mr-left-10" for="st_twin">
                                    <strong>Twin</strong>
                                </label>
                                </div>
                                <div class="form-data col-sm-9 col-md-9 col-lg-6">
                                    <input class="contastudenti form-control" data-type="spinner" type="number" name=st_twin id=st_twin value="0" min="0" max="500" />
                                </div>
                            </div>


                            <div class="box-header with-border mr-bot-10">
                                <h3 class="box-title">Group leaders accomodations</h3>
                            </div>
                            <div class="form-group row" id="row_gl_en" <?php echo isset($form['data']['center_select']) && !empty($form['data']['center_select']) ? "" : "style='display:none;'" ?>>
                                <div class="col-sm-3 col-md-3">
                                <label class="mr-left-10" for="gl_ensuite">
                                    <strong>Ensuite</strong>
                                </label>
                                </div>
                                <div class="form-data col-sm-9 col-md-9 col-lg-6 <?php echo (isset($form['error']['sum_gl']) && !empty($form['data']['center_select']) && empty($form['data']['sum_gl']) ? 'has-error' : ''); ?>">
                                    <input class="contagl form-control" data-type="spinner" type="number" name=gl_ensuite id=gl_ensuite value="<?php echo isset($form['data']['gl_ensuite']) ? $form['data']['gl_ensuite'] : 0 ?>" min="0" max="100" />
                                </div>
                            </div>
                            <div class="form-group row" id="row_gl_st" <?php echo isset($form['data']['center_select']) && !empty($form['data']['center_select']) ? "" : "style='display:none;'" ?>>
                                <div class="col-sm-3 col-md-3">
                                <label class="mr-left-10" for="gl_standard">
                                    <strong>Standard</strong>
                                </label>
                                </div>
                                <div class="form-data col-sm-9 col-md-9 col-lg-6 <?php echo (isset($form['error']['sum_gl']) && !empty($form['data']['center_select']) && empty($form['data']['sum_gl']) ? 'has-error' : ''); ?>">
                                    <input class="contagl form-control"  data-type="spinner" type="number" name=gl_standard id=gl_standard value="<?php echo isset($form['data']['gl_standard']) ? $form['data']['gl_standard'] : 0 ?>" min="0" max="100" />
                                </div>
                            </div>
                            <div class="form-group row" id="row_gl_ho" <?php echo isset($form['data']['center_select']) && !empty($form['data']['center_select']) ? "" : "style='display:none;'" ?>>
                                <div class="col-sm-3 col-md-3">
                                <label class="mr-left-10" for="gl_homestay">
                                    <strong>Homestay</strong>
                                </label>
                                </div>
                                <div class="form-data col-sm-9 col-md-9 col-lg-6 <?php echo (isset($form['error']['sum_gl']) && !empty($form['data']['center_select']) && empty($form['data']['sum_gl']) ? 'has-error' : ''); ?>">
                                    <input class="contagl form-control" data-type="spinner" type="number" name=gl_homestay id=gl_homestay value="<?php echo isset($form['data']['gl_homestay']) ? $form['data']['gl_homestay'] : 0 ?>" min="0" max="100" />
                                    <?php if (isset($form['error']['sum_gl']) && !empty($form['data']['center_select']) && empty($form['data']['sum_gl'])) {?>
                                        <span class="invalid">
                                            No Group leaders enrolled!
                                        </span>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="form-group row" id="row_gl_tw" style="display:none;">
                                <div class="col-sm-3 col-md-3">
                                <label class="mr-left-10" for="gl_twin">
                                    <strong>Twin</strong>
                                </label>
                                </div>
                                <div class="form-data col-sm-9 col-md-9 col-lg-6">
                                    <input class="contagl form-control" data-type="spinner" type="number" name=gl_twin id=gl_twin value="0" min="0" max="100" />
                                </div>
                            </div>


                            <div class="box-header with-border mr-bot-10">
                                <h3 class="box-title">Arrival/departure dates and number of weeks on campus</h3>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3 col-md-3">
                                <label class="mr-left-10" for="n_weeks">
                                    <strong>Weeks</strong>
                                </label>
                                </div>
                                <div class="form-data col-sm-9 col-md-9 col-lg-6 <?php echo (isset($form['error']['n_weeks']) ? 'has-error' : ''); ?>">
                                    <input autocomplete="off" data-type="spinner" type="number" min=1 max=4 value=<?php echo isset($form['data']['n_weeks']) && !empty($form['data']['n_weeks']) ? $form['data']['n_weeks'] : 1 ?> id="n_weeks" name="n_weeks" class="form-control" />
                                    <?php if (isset($form['error']['n_weeks'])) {?>
                                    <span class="invalid">
                                        Please Provide Week
                                    </span>
                                        <?php }?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3 col-md-3">
                                <label class="mr-left-10" for="arrival_date">
                                    <strong>Arrival date</strong>
                                </label>
                                </div>
                                <div class="form-data col-sm-9 col-md-9 col-lg-9 <?php echo (isset($form['error']['arrival_date']) ? 'has-error' : ''); ?>" >
                                    <div id="alldates" style="border:0;color:#f00;"></div>
                                    <div style="overflow: auto;" id="arrival_date" data-type="date" data-id=arrival_date data-name=arrival_date data-show-button-panel=false data-number-of-months=3 data-min-date="06/01/2016"  data-max-date="09/30/2016" data-alt-field="#adate" data-alt-format="dd/mm/yy" data-alt-default-date=""></div>
                                    <input type="hidden" id="hidd_arrival_date" name="arrival_date" value="<?php echo @$form['data']['hid_arrival_date'] ?>" />
                                    <?php if (isset($form['error']['arrival_date'])) {?>
                                    <span class="invalid">
                                        Please Provide Arrival Date
                                    </span>
                                        <?php }?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3 col-md-3">
                                <label class="mr-left-10" for="departure_date">
                                    <strong>Departure date</strong>
                                </label>
                                </div>
                                <div class="form-data col-sm-9 col-md-9 col-lg-9 <?php echo (isset($form['error']['departure_date']) ? 'has-error' : ''); ?>" >
                                    <div style="overflow: auto;" id="departure_date" data-type="date" data-id=departure_date data-name=departure_date data-show-button-panel=false data-number-of-months=3 data-min-date="06/01/2016"  data-max-date="10/31/2016" data-alt-field="#ddate" data-alt-format="dd/mm/yy" data-alt-default-date=""></div>
                                    <input type="hidden" id="hidd_departure_date" name="departure_date" value="<?php echo @$form['data']['hid_departure_date'] ?>" />
                                    <?php if (isset($form['error']['departure_date'])) {?>
                                    <span class="invalid">
                                        Please Provide Departure Date
                                    </span>
                                        <?php }?>
                                        <?php if (isset($form['error']['invertBookingDate'])) {?>
                                    <span class="invalid">
                                        Please Provide Valid dates, arrival date cannot be higher than departure date.
                                    </span>
                                        <?php }?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3 col-md-3">
                                <label class="mr-left-10">
                                    <strong>Enrol summary</strong>
                                </label>
                                </div>
                                <div class="form-data col-sm-9 col-md-9 col-lg-6">
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-lg-3 col-md-4">
                                            Students total:
                                        </div>
                                        <div class="col-sm-9 col-lg-4 col-md-6">
                                            <input class="form-control" type="text" autocomplete="off" name="sum_stud" id="sum_stud" value="<?php echo @$form['data']['sum_stud']; ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-lg-3 col-md-4">
                                            Group leader total:
                                        </div>
                                        <div class="col-sm-9 col-lg-4 col-md-6">
                                            <input class="form-control" type="text" autocomplete="off" name="sum_gl" id="sum_gl" value="<?php echo @$form['data']['sum_gl']; ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-lg-3 col-md-4">
                                            Arrival date:
                                        </div>
                                        <div class="col-sm-9 col-lg-4 col-md-6">
                                            <input class="form-control" type="text" autocomplete="off" id="adate" value="<?php echo @$form['data']['arrival_date']; ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-lg-3 col-md-4">
                                            Departure date:
                                        </div>
                                        <div class="col-sm-9 col-lg-4 col-md-6">
                                            <input class="form-control" type="text" autocomplete="off" id="ddate" value="<?php echo @$form['data']['departure_date']; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3 col-lg-3 col-md-4">
                                </div>
                                <div class="form-data col-sm-9 col-md-9 col-lg-6">
                                    <div class="checkbox">
                                        <label><input type="checkbox" value="1" id="declaration_check" name="declaration_check" <?php echo (isset($form['data']['declaration_check']) && !empty($form['data']['declaration_check']) ? 'checked' : '') ?>>I declare that I have read, understood and agree to adhere to "PLUS Safeguarding and Child Protection Policy" and confirm that I have obtained a certificate of good conduct for any group leaders escorting groups that include under-18s</label>
                                    </div>
                                    <?php if (isset($form['error']['declaration_check'])) {?>
                                    <span class="invalid">
                                        Please accept the declaration
                                    </span>
                                        <?php }?>
                                </div>
                            </div>

                        <div class="form-group row">
                            <div class="col-sm-3 col-lg-3 col-md-4">
                            </div>
                            <div class="form-data col-sm-9 col-md-9 col-lg-6 actions">
                                <div id="accomodations" style="display:none;"></div>
                                    <input id="writebook" class="btn btn-primary" type="button" value="Submit" name=writebook />
                                    <input type="reset" class="btn btn-danger" value="Cancel" />
                            </div><!-- End of .actions -->
                        </div>
                    </form>
                </div><!-- End of .col-sm-12 -->
                <div class="box-footer">

                </div>
            <!-- /.box-footer-->
            </div>
        </div>
    </div>
<script src="<?php echo base_url(); ?>js/mylibs/forms/jquery.ui.datetimepicker.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script>
    var pageHighlightMenu = "agents/insertedBookings";
    $(document).ready(function() {

            $('#arrival_date').datepicker({
                numberOfMonths: 3,
                onSelect:function(sDate,s){
                    $("#adate").val(formatDate(sDate));
                    $("#hidd_arrival_date").val(sDate);
                }
            });

            //departure_date
            $('#departure_date').datepicker({numberOfMonths: 3,
                onSelect:function(sDate,s){
                    $("#ddate").val(formatDate(sDate));
                    $("#hidd_departure_date").val(sDate);
                }}); //departure_date

            $( "li#enrol" ).addClass("current");
		$("#center_select").on('change',function(){
			//swal("Error",$(this).val());
			$("#alldates").html('searching dates ...');
			$.ajax({
				type: "POST",
				data: "idcentro=" + $(this).val(),
				url: "<?php echo base_url(); ?>index.php/agents/findDatesByCenter",
				success: function(msg){
					if (msg != ''){
						$("#alldates").html(msg).show();
					}
					else{
						$("#alldates").html('<em>No item result</em>');
					}
				}
			});
			$.ajax({
				type: "POST",
				data: "idcentro=" + $(this).val(),
				url: "<?php echo base_url(); ?>index.php/agents/findAccoByCenter",
				success: function(msg){
					if (msg != ''){
						$("#accomodations").html(msg).show();
					}
					else{
						$("#accomodations").html('<em>No item result</em>');
					}
				}
			});
			$("#row_st_en").hide();
			$("#row_st_st").hide();
			$("#row_st_ho").hide();
			$("#row_st_tw").hide();
			$("#row_gl_en").hide();
			$("#row_gl_st").hide();
			$("#row_gl_ho").hide();
			$("#row_gl_tw").hide();
			$("#st_ensuite").val(0);
			$("#st_standard").val(0);
			$("#st_homestay").val(0);
			$("#st_twin").val(0);
			$("#gl_ensuite").val(0);
			$("#gl_standard").val(0);
			$("#gl_homestay").val(0);
			$("#gl_twin").val(0);
		});

        if($('#center_select').val() != ''){
            populateAccomodation();
        }

		$( ".contastudenti" ).blur(function(){
			var studval = $("#st_ensuite").val()*1+$("#st_standard").val()*1+$("#st_homestay").val()*1+$("#st_twin").val()*1;
			$("#sum_stud").val(studval);
		});

		$( ".contagl" ).blur(function(){
			var glval = $("#gl_ensuite").val()*1+$("#gl_standard").val()*1+$("#gl_homestay").val()*1+$("#gl_twin").val()*1;
			$("#sum_gl").val(glval);
		});

		$("#writebook").click(function(){
			var giornitotali = daydiff(parseDate($('#adate').val()), parseDate($('#ddate').val()))*1+1;
			var giornidaweek = $("#n_weeks").val()*7+1;
			//swal("Error",giornidaweek);
			var nogiorniok=0;
			if(giornitotali!=giornidaweek){
				var nogiorniok=1;
			}
			var arrivo_ok=0;
			var partenza_ok=0;
			$(".datearrivo").each(function(index) {
				//var miadataarrivo=$("#arrival_date").val().split("/");
				var miadataarrivook = $('#adate').val();//miadataarrivo[1]+"/"+miadataarrivo[0]+"/"+miadataarrivo[2];
				//swal("Error",miadataarrivook);
				//swal("Error",$(this).text());
				if(miadataarrivook==$(this).text()){
					arrivo_ok=1;
				}
			});
			if($("#prod_select").val()==""){
				swal("Error","Select a product!");
				return false;
			}
			if($("#center_select").val()==""){
				swal("Error","Select a center!");
				return false;
			}
			if($("#sum_stud").val()=="0"){
				swal("Error","No students enrolled!");
				return false;
			}
			if($("#sum_gl").val()=="0"){
				swal("Error","No group leaders enrolled!");
				return false;
			}
            if($("#hidd_arrival_date").val() == ''){
                swal("Error","Please Provide Arrival Date!");
                return false;
            }
            if($("#hidd_departure_date").val() == ''){
                swal("Error","Please Provide Departure Date!");
                return false;
            }
            if($("#declaration_check").prop('checked') == false){
                swal("Error","Please accept the declaration");
                return false;
            }
			if(giornitotali<=1){
				swal("Error","Please verify selected dates: "+(giornitotali-1)+"day(s) on campus!");
				return false;
			}
			if(arrivo_ok==0){
				if(nogiorniok==0){
					if(confirm("Arrival date doesn't match with campus arrival dates! You want to continue anyway?")){
						document.getElementById("enrolform").submit();
					}else{
						return false;
					}
				}else{
					if(confirm("Arrival date doesn't match with campus arrival dates and days on campus doesn't match with selected weeks! You want to continue anyway?")){
						document.getElementById("enrolform").submit();
					}else{
						return false;
					}
				}
			}else{
				if(nogiorniok==1){
					if(confirm("Days on campus doesn't match with selected weeks! You want to continue anyway?")){
						document.getElementById("enrolform").submit();
					}else{
						return false;
					}
				}else{
						document.getElementById("enrolform").submit();
				}
			}
		});
	});
function populateAccomodation(){
    $.ajax({
                type: "POST",
                data: "idcentro=" + $('#center_select').val(),
                url: "<?php echo base_url(); ?>index.php/agents/findDatesByCenter",
                success: function(msg){
                    if (msg != ''){
                        $("#alldates").html(msg).show();
                    }
                    else{
                        $("#alldates").html('<em>No item result</em>');
                    }
                }
            });
            $.ajax({
                type: "POST",
                data: "idcentro=" + $('#center_select').val(),
                url: "<?php echo base_url(); ?>index.php/agents/findAccoByCenter",
                success: function(msg){
                    if (msg != ''){
                        $("#accomodations").html(msg).show();
                    }
                    else{
                        $("#accomodations").html('<em>No item result</em>');
                    }
                }
            });
            $("#row_st_en").hide();
            $("#row_st_st").hide();
            $("#row_st_ho").hide();
            $("#row_st_tw").hide();
            $("#row_gl_en").hide();
            $("#row_gl_st").hide();
            $("#row_gl_ho").hide();
            $("#row_gl_tw").hide();
}

        function formatDate(str) {
		var mdy = str.split('/')
		return mdy[1]+"/"+mdy[0]+"/"+mdy[2];
	}
	function parseDate(str) {
		var mdy = str.split('/')
		return new Date(mdy[2], mdy[1], mdy[0]-1);
	}

	function daydiff(first, second) {
		return (second-first)/(1000*60*60*24)
	}

</script>
<?php $this -> load -> view('plused_header'); ?>
<script>
    var RATY_BASE_PATH = "<?php echo base_url();?>";
</script>
<script src="<?php echo base_url(); ?>js/raty/jquery.raty.js"></script>
<!-- The container of the sidebar and content box -->
<div role="main" id="main" class="container_12 clearfix">
	<!-- The blue toolbar stripe -->
	<section class="toolbar">
		<div class="user">
			<div class="avatar">
				<img src="<?php echo base_url(); ?>img/layout/content/toolbar/user/avatar.png">
				<!-- Evidenziare per icone attenzione <span>3</span> -->
			</div>
			<span><?php echo $this -> session -> userdata('businessname') ?></span>
			<ul>
				<li><a href="<?php echo base_url(); ?>index.php/backoffice/profile">Profile</a></li>
				<li class="line"></li>
				<li><a href="<?php echo base_url(); ?>index.php/backoffice/logout">Logout</a></li>
			</ul>
		</div>
	</section><!-- End of .toolbar-->
	<?php $this -> load -> view('plused_sidebar'); ?>
	<script type="text/javascript">
		$(function(){
			$( "li#mnutuition" ).addClass("current");
			$( "li#mnutuition a" ).addClass("open");		
			$( "li#mnutuition ul.sub" ).css('display','block');	
                        $( "li#mnutuition ul.sub li#mnutuition_10" ).addClass("current");
			//$('table.dynamic').table();
			$(document).on('click', ".dialogbtn", function() {
				var iddia = $(this).attr("data-id").replace('_btn','');
				//alert(iddia.replace('_btn',''));
				$( "#"+iddia ).dialog("open");
				return false;
			});
                        
			$( ".windia" ).dialog({
				autoOpen: false,
				modal: true,
                                width : '70%',
				buttons: [{
						text: "Close",
						click: function() { $(this).dialog("close"); }
					}]
			});
                        
                        $( "#txtCalFromDate" ).datepicker({
                                defaultDate: "+1w",
                                changeMonth: true,
                                changeYear: true,		  
                                dateFormat: "dd/mm/yy",		
                                numberOfMonths: 1,
                                onClose: function( selectedDate ) {
                                    $( "#txtCalToDate" ).datepicker( "option", "minDate", selectedDate );
                                }
                        });

                        $( "#txtCalToDate" ).datepicker({
                                defaultDate: "+1w",
                                changeMonth: true,
                                changeYear: true,		  
                                dateFormat: "dd/mm/yy",		
                                numberOfMonths: 1,
                                onClose: function( selectedDate ) {
                                        $( "#txtCalFromDate" ).datepicker( "option", "maxDate", selectedDate );
                                }
                        });
                        
                        
                        $( "body" ).on( "click", "#btnSearch", function() {
                            var keyword = $('#txtSearchText').val();
                            var fromDate = $('#txtCalFromDate').val();
                            var toDate = $('#txtCalToDate').val();
                            $.post( "<?php echo base_url();?>index.php/tuitions/ajaxFilterCDTeachersReview",{
                                        'keyword':keyword,
                                        'fromDate':fromDate,
                                        'toDate':toDate
                                    }, function( data ) {
                                    $("#teachersDetailsDiv").html(data);
                                    $('table.dynamic').table();
                                    $("select").chosen();
                                    $(".chzn-container").css('width','48px');
                                    $(".ui-dialog").remove();
                                    $( ".windia" ).dialog({
                                        autoOpen: false,
                                        modal: true,
                                        width : '70%',
                                        buttons: [{
                                                    text: "Close",
                                                    click: function() { $(this).dialog("close"); }
                                                }]
                                    });
                                    //load raty
                                    $('.viewStar').each(function(e,ele){
                                        var stars = $(ele).attr('data-star');
                                        var id = $(ele).attr('id');
                                        if(!parseInt(stars))
                                            stars = 0;
                                        if($("#"+id).html() == '')
                                        $("#"+id).raty({readOnly:true,start:stars,hintList:[]});
                                    });
                                    // load popup
                                    $( ".windia_review" ).dialog({
                                            autoOpen: false,
                                            modal: true,
                                            width : '50%',
                                            buttons: [{
                                                            text: "Close",
                                                            click: function() { $(this).dialog("close"); }
                                                    }]
                                    });
                            },'html');
                        });
                        
                        $( "body" ).on( "click", "#btnClear", function() {
                            $('#txtSearchText').val('');
                            $('#txtCalFromDate').val('');
                            $('#txtCalToDate').val('');
                            $("#btnSearch").trigger('click');
                        });
                
                        $( ".windia_review" ).dialog({
				autoOpen: false,
				modal: true,
                                width : '50%',
				buttons: [{
						text: "Close",
						click: function() { $(this).dialog("close"); }
					}]
			});
                        
                        $("body").on('click', ".dialogstar", function() {
				$( "#dialog_modal_review" ).dialog("open");
                                var teach_id = $(this).attr('data-ta-id');
                                var cont_id = $(this).attr('data-track-id');
                                $("#hidd_cont_id").val(cont_id);
                                $("#hidd_teach_id").val(teach_id);
                                // load review on popup
                                $("#btnReviewCancel").trigger('click');
                                // end.
				return false;
			});
                        
                        $('#formStar').raty({hintList:[]});
                        $('.viewStar').each(function(e,ele){
                            var stars = $(ele).attr('data-star');
                            var id = $(ele).attr('id');
                            if(!parseInt(stars))
                                stars = 0;
                            if($("#"+id).html() == '')
                                $("#"+id).raty({readOnly:true,start:stars,hintList:[]});
                        });
                        // load on pagination
                        $("body").on("click",".paginate_button",function(){
                            $('.viewStar').each(function(e,ele){
                                var stars = $(ele).attr('data-star');
                                var id = $(ele).attr('id');
                                if(!parseInt(stars))
                                    stars = 0;
                                if($("#"+id).html() == '')
                                $("#"+id).raty({readOnly:true,start:stars,hintList:[]});
                            });
                        });
                       // 
                        
                        
                        // send user input
                        $("body").on("click","#btnReview",function(){
                            $("#reviewMessage").html('');
                            $("#reviewMessage").removeClass('tuition_success');
                            $("#reviewMessage").removeClass('tuition_error');
                            var cont_id = $("#hidd_cont_id").val();
                            var teach_id = $("#hidd_teach_id").val();
                            var review = $("#txtReview").val();
                            var r_stars = $("#frmTeacherReview [name=score]").val();
                            var $el = $('#dialog_modal_review');
                            if ($el.validate().form()) {
                                $.post( "<?php echo base_url();?>index.php/tuitions/teacherrating",{
                                        'cont_id':cont_id,
                                        'teach_id':teach_id,
                                        'r_stars':r_stars,
                                        'review':review
                                    }, function( data ) {
                                    $("#reviewMessage").html(data.message);
                                    if(parseInt(data.result))
                                    {
                                        $("#reviewMessage").addClass('tuition_success');
                                        $.fn.raty.click(r_stars, '#viewfor_'+cont_id);
                                    }
                                    else
                                        $("#reviewMessage").addClass('tuition_error');
                                },'json');
                            }
                        });
                        //end
                        $("body").on("click","#btnReviewCancel",function(){
                            $("#reviewMessage").html('');
                            $("#reviewMessage").removeClass('tuition_success');
                            $("#reviewMessage").removeClass('tuition_error');
                            $("#txtReview").val('');
                            $.fn.raty.click(0, '#formStar');
                            $("#frmTeacherReview [name=score]").val('');
                            var cont_id = $("#hidd_cont_id").val();
                            var teach_id = $("#hidd_teach_id").val();
                            // load review on popup
                                $.post( "<?php echo base_url();?>index.php/tuitions/getteacherreview",{
                                    'cont_id':cont_id,
                                    'teach_id':teach_id
                                },function(data){
                                    if(parseInt(data.result)){
                                        var row = data.dataset;
                                        $("#txtReview").val(row.rat_review_text);
                                        $.fn.raty.click(row.rat_stars, '#formStar');
                                    }
                                },'json');
                            // end.
                        });
                        
		});
		
		$(document).on('click', '.paginate_button', function(){
			$("table.dynamic tr td:last-child").removeClass('center operation');
			$("table.dynamic tr td:last-child").addClass('center operation');
		});
                
	</script>
	<section id="content" class="container_12 clearfix" data-sort=true>
		<div class="grid_12">

			<div class="box">
				<div class="header">
					<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png"><?php echo $breadcrumb2; ?></h2>
				</div>
                                <div class="content">
                                    <div class="form-data grid_12" >
                                        <div class="left-class" style="padding-top:4px;padding-bottom: 4px;">
                                        <span >Please enter value for search, duration 'from date' - 'to date' and click search button to filter.</span>
                                        </div>
                                        <div class="left-class" style="width:100%;">
                                            <span class="text">Teacher: </span>
                                            <input type="text" style="width:23.3%;" id="txtSearchText" name="txtSearchText" value="" />
                                            <span class="text">From Date: </span>
                                            <input type="text" style="width:23.3%;" readonly id="txtCalFromDate" name="fd" value="" />
                                            <span style="margin-left:1.2%;" class="text">To Date: </span>
                                            <input style="width:25.9%;" type="text" readonly id="txtCalToDate" name="td" value="" /> 
                                        </div>
                                    </div>
                                    <div class="form-data grid_4" style="margin-left: 48px;margin-top: 5px;" >
                                        <input id="btnSearch" type="submit" value="Search" >
                                        <input id="btnClear" type="reset" value="Clear" >
                                    </div>
                                </div>
				<div class="content">
					<div class="tabletools">
						<div class="left">
							 
						</div>
						<div class="right">
                                                    <?php
                                                        $success_message = $this -> session -> flashdata('success_message');
                                                    if (!empty($success_message)) {
                                                            ?><div class="tuition_success"><?php echo $success_message; ?></div><?php
                                                        }
                                                        $error_message = $this -> session -> flashdata('error_message');
                                                        if (!empty($error_message)) {
                                                            ?><div class="tuition_error"><?php echo $error_message; ?></div><?php
                                                        }
                                                    ?>
						</div>
					</div>
                                    <div id="teachersDetailsDiv">
					<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"bRetrieve": true, "bDestroy": true, "bFilter":false, "aoColumns":[{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
						<thead>
                                                    <tr>
                                                        <th>Teacher</th>
                                                        <th>Date of birth</th>
                                                        <th>From Date</th>								
                                                        <th>To date</th>
                                                        <th>Review & rating</th>
                                                        <th>Action</th>
                                                    </tr>
						</thead>
						<tbody>
							<?php
							if (!empty($teachersData)) {
								foreach ($teachersData as $contract) {
                                                                ?>
								<div style="display: none;" id="dialog_modal_<?php echo $contract["joc_id"] ?>" title="Teacher detail - <?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?>" class="windia"> 
                                                                    <div class="box">
                                                                            <div class="header">
                                                                                <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon"><span >Teacher details as per contract</span></h2>
                                                                            </div>
                                                                            <div class="content">
                                                                                <div class="detailContainer">
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>Name:</strong></div>
                                                                                        <div class="grid_3"><?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?></div>

                                                                                        <div class="grid_3"><strong>Email:</strong></div>
                                                                                        <div class="grid_3"><?php echo $contract["joc_email"]; ?></div>
                                                                                    </div>
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>Campus:</strong></div>
                                                                                        <div class="grid_3"><?php echo $contract["nome_centri"]; ?></div>

                                                                                        <div class="grid_3"><strong>Position:</strong></div>
                                                                                        <div class="grid_3"><?php echo $contract["pos_position"]; ?></div>
                                                                                    </div>
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>From date:</strong></div>
                                                                                        <div class="grid_3"><?php echo date('d/m/Y', strtotime($contract["joc_from_date"])); ?></div>

                                                                                        <div class="grid_3"><strong>To date:</strong></div>
                                                                                        <div class="grid_3"><?php echo date('d/m/Y', strtotime($contract["joc_to_date"])); ?></div>
                                                                                    </div>
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>Hours per week:</strong></div>
                                                                                        <div class="grid_3"><?php echo $contract["joc_hourperweek_range"]; ?></div>

                                                                                        <div class="grid_3"><strong>Date of birth:</strong></div>
                                                                                        <div class="grid_3"><?php echo ((empty($contract["ta_date_of_birth"]) || $contract["ta_date_of_birth"] == '0000-00-00 00:00:00') ? '' : date('d/m/Y', strtotime($contract["ta_date_of_birth"]))); ?></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <div class="box">
                                                                            <div class="header">
                                                                                <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon"><span >Interview details</span></h2>
                                                                            </div>
                                                                            <div class="content">
                                                                                <div class="detailContainer">
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>Interview notes:</strong></div>
                                                                                        <div class="grid_9"><?php echo htmlentities($contract['ta_interview_notes']); ?></div>
                                                                                    </div>
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>Interview strong:</strong></div>
                                                                                        <div class="grid_9"><?php echo htmlentities($contract['ta_interview_strong']); ?></div>
                                                                                    </div>
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>Interview weak:</strong></div>
                                                                                        <div class="grid_9"><?php echo htmlentities($contract['ta_interview_weak']); ?></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
								</div>
								<tr>
                                                                    <td class="center"><?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?></td>
                                                                    <td class="center"><?php echo ((empty($contract["ta_date_of_birth"]) || $contract["ta_date_of_birth"] == '0000-00-00 00:00:00') ? '' : date('d/m/Y', strtotime($contract["ta_date_of_birth"]))); ?></td>
                                                                    <td class="center"><?php echo date('d/m/Y', strtotime($contract["joc_from_date"])); ?></td>
                                                                    <td class="center"><?php echo date('d/m/Y', strtotime($contract["joc_to_date"])); ?></td>
                                                                    <td class="center"><div class="viewStar" id="viewfor_<?php echo $contract['joc_id'];?>" data-star="<?php echo $contract['rat_stars'];?>"></div></td>
                                                                    <td class="center operation">
                                                                            <a title="View" href="javascript:void(0);" data-ta-id="<?php echo $contract["joc_application_id"]; ?>" data-track-id="<?php echo $contract['joc_id']; ?>" data-id="dialog_modal_btn_<?php echo $contract["joc_id"]; ?>" class="dialogbtn">
                                                                                    <span class="icon-eye-open"></span>
                                                                            </a>
                                                                            <a title="Review & rating" href="javascript:void(0);" data-ta-id="<?php echo $contract["joc_application_id"]; ?>" data-track-id="<?php echo $contract['joc_id']; ?>" class="dialogstar">
                                                                                    <span class="icon-star-empty"></span>
                                                                            </a>
                                                                    </td>
								</tr>
								<?php
							}
						}
						?>
						</tbody>
					</table>
                                    </div>
				</div>

			</div>
		</div>
            
            <div style="display: none;" id="dialog_modal_review" title="Teacher review & rating" class="windia_review"> 
                <div class="box">
                    <div class="header">
                        <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon"><span >Teacher review & rating</span></h2>
                    </div>
                    <div class="content">
                            <form action="" id="frmTeacherReview" class="validate" method="post">
                               <div class="row">
                                        <label >
                                            <strong>Mark star rating</strong>
                                        </label>
                                        <div class="form-data" >
                                            <div id="formStar"></div>
                                        </div>
                                </div>
                                <div class="row">
                                        <label>
                                            <strong>Notes</strong>
                                        </label>
                                        <div class="form-data">
                                            <textarea cols="5" rows="6" maxlength="250" id="txtReview" class="required" name="txtReview"></textarea>
                                        </div>
                                </div>
                                <div class="row">
                                        <div class="form-data">
                                            <input type="hidden" value="0" name="hidd_cont_id" id="hidd_cont_id" />
                                            <input type="hidden" value="0" name="hidd_teach_id" id="hidd_teach_id" />
                                            <input type="button" value="Submit" name="btnReview" id="btnReview" class="btn btn-tuition">
                                            <input type="reset" value="Cancel" name="btnReviewCancel" id="btnReviewCancel" class="btn btn-tuition">
                                            <div style="margin-top: 0;" id="reviewMessage"></div>
                                        </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
	</section>	
</div>
<style>
    table tr td{
        height: 16px;
    }
</style>
<?php $this -> load -> view('plused_footer'); ?>
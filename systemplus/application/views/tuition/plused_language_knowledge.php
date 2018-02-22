<?php $this->load->view('plused_header');?>
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<!--<script src="//cdn.datatables.net/plug-ins/1.10.11/api/fnStandingRedraw.js"></script>-->
	<!-- The container of the sidebar and content box -->
	<div role="main" id="main" class="container_12 clearfix">
	
		<!-- The blue toolbar stripe -->
		<section class="toolbar">
			<div class="user">
				<div class="avatar">
					<img src="<?php echo base_url(); ?>img/layout/content/toolbar/user/avatar.png">
					<!-- Evidenziare per icone attenzione <span>3</span> -->
				</div>
				<span><?php echo $this->session->userdata('businessname') ?></span>
				<ul>
					<li><a href="<?php echo base_url(); ?>index.php/backoffice/profile">Profile</a></li>
					<li class="line"></li>
					<li><a href="<?php echo base_url(); ?>index.php/backoffice/logout">Logout</a></li>
				</ul>
			</div>
		</section><!-- End of .toolbar-->
<?php $this->load->view('plused_sidebar');?>		
                <style>
                    .loadingSpan{
                        margin-left: 2px;
                        margin-top: 6px;
                    }
                </style>      
<script>
        var SITE_PATH = "<?php echo base_url();?>index.php/";
	$(document).ready(function() {
		$( "li#mnutuition" ).addClass("current");
		$( "li#mnutuition a" ).addClass("open");		
		$( "li#mnutuition ul.sub" ).css('display','block');	
		$( "li#mnutuition ul.sub li#mnutuition_7" ).addClass("current");	
                 var loadingImg = "<span class='imgLoading loadingSpan' style='float:right;position:absolute;'><img  src='<?php echo base_url().'img/tuition/throbber.gif'?>' /></span>"
                 var saveAlert = "<span class='saveAlert loadingSpan' style='float:right;position:absolute;color:green;'>Saved!</span>"

                $( "body" ).on( "change", ".updatelang", function() {
                    var thisEle = $(this);
                    var uuid = $(this).attr('data-uuid');
                    var knowledge_lang = $(this).val();
                    if(0 < knowledge_lang && knowledge_lang > 100)
                    {
                        $(this).val('0');
                        thisEle.parent().append(saveAlert);
                        thisEle.parent().find(".saveAlert").css('margin-top','0px').css('color','red').html('Not Allowed!').fadeOut(4500);
                    }else{
                        thisEle.parent().append(loadingImg);
                        $.post( "<?php echo base_url();?>index.php/tuitions/updatelang",{'uuid':uuid,'knowledge_lang':knowledge_lang}, function( data ) {
                            $("#td_"+uuid).html(knowledge_lang);
                            thisEle.parent().find(".imgLoading").replaceWith(saveAlert);
                            thisEle.parent().find(".saveAlert").fadeOut(4500);
                            boolReload = true;
                        },'json');
                    }
                        
                });

		$( ".dialogbtn" ).click(function() {
				var iddia = $(this).attr("id").replace('_btn','');
				//alert(iddia.replace('_btn',''));
				$( "#"+iddia ).dialog("open");
				return false;
		});
            
		$( ".windia" ).dialog({
				autoOpen: false,
				modal: true,
				buttons: [{
					text: "Close",
					click: function() { $(this).dialog("close"); }
				}]
		});
                
                var boolReload = false;
                $( "body" ).on( "click", "#sortLK", function() {
                    var currentSearchText = $(".dataTables_filter input").val();
                    var sortType = $(this).attr('class');
                    if(boolReload){
                        var oTable = $('.dynamic').dataTable();
                        oTable.fnDestroy(); 
                        if(sortType == 'sorting_asc')
                            $('.dynamic').table();
                        else
                            $('.dynamic').table();
                        boolReload = false;
                        $(this).trigger('click');
                        if(currentSearchText.length > 0)
                        {
                            $(".dataTables_filter input").val(currentSearchText);
                            $(".dataTables_filter input").trigger('keyup');
                        }
                        $("select").chosen();
                        $(".chzn-container").css('width','48px');
                    }
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
                
                
                $( "body" ).on( "click", "#btnClear", function() {
                    $('#txtSearchText').val('');
                    $('#txtCalFromDate').val('');
                    $('#txtCalToDate').val('');
                    $("#btnSearch").trigger('click');
                });
                $( "body" ).on( "click", "#btnSearch", function() {
                    var keyword = $('#txtSearchText').val();
                    var campfrom = $('#txtCalFromDate').val();
                    var campto = $('#txtCalToDate').val();
                    $.post( "<?php echo base_url();?>index.php/tuitions/searchlangknowledgeajax",{
                                'keyword':keyword,
                                'campfrom':campfrom,
                                'campto':campto
                            }, function( data ) {
                            $("#langStudentsList").html(data);
                            $('table.dynamic').table();
                            $("select").chosen();
                            $(".chzn-container").css('width','48px');
                    },'html');
                });
                
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<div class="box">
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Language knowledge</h2>
					</div>
                                        <div class="content">
                                            <div class="form-data grid_12" >
                                                
                                                <div class="left-class" style="padding-top:4px;padding-bottom: 4px;">
                                                <span >Please enter value for search, campus arrival date and campus departure date and click search button to filter.</span>
                                                </div>
                                                <div class="left-class" style="width:100%;">
                                                    <span class="text">Search: </span>
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
                                                        <span>
                                                        Sort columns by clicking on the arrow on the right of first row cells.
                                                        </span>
                                                        <?php 
                                                            /* $success_message = $this->session->flashdata('success_message');
                                                            if(!empty($success_message))
                                                            {
                                                                ?><div class="tuition_success"><?php echo $success_message;?></div><?php 
                                                            }
                                                            $error_message = $this->session->flashdata('error_message');
                                                            if(!empty($error_message))
                                                            {
                                                                ?><div class="tuition_error"><?php echo $error_message;?></div><?php 
                                                            }*/
                                                        ?>
                                                    </div>
                                            </div>
                                            
<!--					    <table id="langDatatable" class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aaSortable: [1,"asc"]","aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": false, "bSortable": false}]}'>-->
                                            <div id="langStudentsList">
                                            <table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"bFilter":false,"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Name</th>
									<th>Age</th>								
									<th>Nationality</th>								
									<th>Booking Id</th>
									<th>Campus arrival</th>
									<th>Campus departure</th>
									<th id="sortLK" style="border-right:none;">Language knowledge</th>
                                                                        <th style="display: none;"></th>
								</tr>
							</thead>
							<tbody>
							<?php 
                                                        if($studentsList)
                                                        foreach($studentsList as $student){
							?>
								<tr>
                                                                    <td class="center">
                                                                        <?php 
                                                                            if(empty($student["nome"]) && empty($student["cognome"]))
                                                                                echo '-';
                                                                            else
                                                                                echo html_entity_decode($student["nome"].' '.$student["cognome"]);
                                                                        ?>
                                                                        <?php /*
                                                                            *<div style="display: none;" id="dialog_modal_<?php echo $student["id_prenotazione"]?>" title="Campus student detail - <?php echo htmlspecialchars($student["nome"].' '.$student["cognome"]);?>" class="windia">
                                                                                <p><strong>Name: </strong><?php echo html_entity_decode($student["nome"].' '.$student["cognome"]);?></p>
                                                                                <p><strong>Age: </strong><?php echo date_diff(date_create($student["pax_dob"]), date_create('today'))->y;?></p>
                                                                                <p><strong>Nationality: </strong><?php echo $student["nazionalita"];?></p>
                                                                                <p><strong>Booking Id: </strong><?php echo $student["id_book"].'_'.$student["id_year"];?></p>
                                                                                <p><strong>Campus arrival: </strong><?php echo date('d/m/Y',  strtotime($student["data_arrivo_campus"]));?></p>
                                                                                <p><strong>Campus departure: </strong><?php echo date('d/m/Y',strtotime($student["data_partenza_campus"]));?></p>
                                                                                <p><strong>Language Knowledge: </strong></p>
                                                                            </div>
                                                                            */?>
                                                                    </td>
                                                                    <td class="center"><?php echo date_diff(date_create($student["pax_dob"]), date_create('today'))->y;?></td>
                                                                    <td class="center"><?php echo (empty($student["nazionalita"]) ? '-' : $student["nazionalita"]);?></td>
                                                                    <td class="center"><?php echo $student["id_book"].'_'.$student["id_year"];?></td>
                                                                    <td class="center"><?php echo date('d/m/Y',  strtotime($student["data_arrivo_campus"]));?></td>
                                                                    <td class="center"><?php echo date('d/m/Y',  strtotime($student["data_partenza_campus"]));?></td>
                                                                    <td class="center" id="td_<?php echo $student["uuid"];?>" style="text-align:right;border-right:none;display: none;"><?php echo (!empty($student["lk_lang_knowledge"]) ? $student["lk_lang_knowledge"] : 0);?></td>
                                                                    <td class="center operation" >
<!--                                                                        <span style="display:hide;"><?php //echo (!empty($student["lk_lang_knowledge"]) ? $student["lk_lang_knowledge"] : 0);?></span>-->
                                                                        <input style="width:40px;text-align: center;" type="text" class="updatelang" data-uuid="<?php echo $student["uuid"];?>" id="txt_<?php echo $student["uuid"];?>" autocomplete="off" maxlength="3" onkeypress="return keyRestrict(event,'1234567890');" value="<?php echo (!empty($student["lk_lang_knowledge"]) ? $student["lk_lang_knowledge"] : 0);?>" />
                                                                    </td>
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
                                            </div>
					</div><!-- End of .content -->
				</div><!-- End of .box -->
			</div><!-- End of .grid_12 -->
			
		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
	
<?php $this->load->view('plused_footer');?>
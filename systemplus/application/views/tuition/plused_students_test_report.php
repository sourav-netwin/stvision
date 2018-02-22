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
		$( "li#mnustudents" ).addClass("current");
		$( "li#mnustudents a" ).addClass("open");		
		$( "li#mnustudents ul.sub" ).css('display','block');	
		$( "li#mnustudents ul.sub li#mnustudents_1" ).addClass("current");	
                
                $( "body" ).on( "click", "#btnClear", function() {
                    $('#txtSearch').val('');
                    $('#selTest').val('');
                    $('#selTest').trigger("liszt:updated");
                    $("#btnSearch").trigger('click');
                });
                
                $( "body" ).on( "click", "#btnSearch", function() {
                    var keyword = $('#txtSearch').val();
                    var test = $('#selTest').val();
                    myloading(1);
                    $.post( "<?php echo base_url();?>index.php/studentsreport/ajaxsearch",{
                                'keyword':keyword,
                                'test':test
                            }, function( data ) {
                            myloading(0);
                            $("#testListDiv").html(data);
                            $('table.dynamic').table();
                            $("#testListDiv select").chosen();
                            $("#testListDiv .chzn-container").css('width','49px');
                    },'html');
                });
	});
        function myloading(show){
            $("#loading-overlay").css('z-index','999999');
            $("#loading").css('z-index','999999');
            $("#loading").html("<span>Loading...</span>");
            if(show == 1)
            {
                $("#loading-overlay").show();
                $("#loading").show();
            }
            else
            {
                $("#loading-overlay").hide();
                $("#loading").hide();
            }
        }
	</script>	
            <!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<div class="box">
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Test report</h2>
					</div>
                                        <div class="content" style="margin: 10px;">
                                            <div class="form-data grid_4" >
                                                <div class="left-class">
                                                    <label for="selTest" style="width: 115px;">
                                                        <strong>Test</strong>
                                                    </label>
                                                </div>
                                                <div class="left-class" style="width:100%;">
                                                    <select id="selTest" name="selTest"  >
                                                        <option value="">All</option>
                                                        <?php 
                                                            if(!empty($testDropdown)){
                                                                foreach($testDropdown as $testdd){
                                                                    ?>
                                                                    <option value="<?php echo $testdd['test_id'];?>"><?php echo $testdd['test_title'];?></option>
                                                                    <?php 
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-data grid_4" >
                                                <div class="left-class">
                                                    <label for="txtSearch" style="width: 115px;">
                                                        <strong>Student name</strong>
                                                    </label>
                                                </div>
                                                <div class="left-class" style="width:100%;">
                                                    <input type="text" id="txtSearch" name="txtSearch" value="" />
                                                </div>
                                            </div>
                                            <div class="form-data grid_4" >
                                                <div class="left-class">
                                                    &nbsp;
                                                </div>
                                                <div class="left-class" style="width:100%;">
                                                    <input id="btnSearch" type="submit" value="Search" >
                                                    <input id="btnClear" type="reset" value="Clear" >
                                                </div>
                                            </div>
                                                 
                                        </div>
                                        
					<div class="content">
                                            <div class="tabletools">
                                                    <div class="left">
                                                        <span style="margin-left:10px;">
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
                                            <div id="testListDiv">
                                            <table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"bFilter":false,"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Test</th>
									<th>Submitted date</th>								
									<th>Student name</th>								
									<th>Booking id</th>
									<th>Total questions</th>
									<th>Correct answers</th>
								</tr>
							</thead>
							<tbody>
							<?php 
                                                        if($testData)
                                                        foreach($testData as $test){
							?>
								<tr>
                                                                    <td class="center"><?php echo $test["test_title"];?></td>
                                                                    <td class="center"><?php echo date('d/m/Y',  strtotime($test["ts_submitted_on"]));?></td>
                                                                    <td class="center">
                                                                        <?php 
                                                                            if(empty($test["nome"]) && empty($test["cognome"]))
                                                                                echo '-';
                                                                            else
                                                                                echo html_entity_decode($test["cognome"].' '.$test["nome"]);
                                                                        ?>
                                                                    </td>
                                                                    <td class="center"><?php echo $test["id_book"].'_'.$test["id_year"];?></td>
                                                                    <td class="center"><?php echo $test["total_questions"];?></td>
                                                                    <td class="center"><?php echo $test["correct_answers"];?></td>
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
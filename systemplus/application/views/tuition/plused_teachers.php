<?php $this->load->view('plused_header');?>
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
	<script>
	$(document).ready(function() {
		$( "li#mnutuition" ).addClass("current");
		$( "li#mnutuition a" ).addClass("open");		
		$( "li#mnutuition ul.sub" ).css('display','block');	
		$( "li#mnutuition ul.sub li#mnutuition_3" ).addClass("current");	
                
                $(".changeStatus").click(function(){
                    var thisEle = $(this);
                    var id = $(this).attr('data-id');
                    var status = $(this).attr('data-status');
                    if(confirm("Are you sure to change active/inactive status?")){
                        $.post( "<?php echo base_url();?>index.php/teachers/teachers_change_status",{'id':id,'status':status}, function( data ) {
                            if(parseInt(data.result)){
                                if(parseInt(data.status))
                                {
                                    thisEle.children().switchClass('icon-check-empty','icon-check');
                                    thisEle.attr('data-status',data.status);
                                }
                                else
                                {
                                    thisEle.children().switchClass('icon-check','icon-check-empty');
                                    thisEle.attr('data-status',data.status);
                                }
                            }
                            else{
                                
                            }
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
		
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Teachers</h2>
					</div>
					
					<div class="content">
						<div class="tabletools">
							<div class="left">
                                                            <a class="open-add-client-dialog" href="<?php echo base_url(); ?>index.php/teachers/addedit"><i class="icon-plus"></i>Create new teacher</a>
							</div>
							<div class="right">	
                                                            <?php 
                                                                $success_message = $this->session->flashdata('success_message');
                                                                if(!empty($success_message))
                                                                {
                                                                    ?><div class="tuition_success"><?php echo $success_message;?></div><?php 
                                                                }
                                                                $error_message = $this->session->flashdata('error_message');
                                                                if(!empty($error_message))
                                                                {
                                                                    ?><div class="tuition_error"><?php echo $error_message;?></div><?php 
                                                                }
                                                            ?>
							</div>
						</div>
                                            
						<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aoColumns":[{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
                                                                    <th>Teacher</th>
                                                                    <th>Campus</th>
                                                                    <th>From date</th>								
                                                                    <th>To date</th>
                                                                    <th>Hour per day</th>
                                                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php 
                                                        if($all_teachers)
                                                        foreach($all_teachers as $teacher){
							?>
								<tr>
									<td class="center">
                                                                            <?php echo html_entity_decode($teacher["teacher_full_name"]);?>
                                                                            <div style="display: none;" id="dialog_modal_<?php echo $teacher["teach_id"]?>" title="Teacher detail - <?php echo htmlentities($teacher["teacher_full_name"]);?>" class="windia">
                                                                                <p><strong>Name: </strong><?php echo html_entity_decode($teacher["teacher_full_name"]);?></p>
										<p><strong>Campus: </strong><?php echo $teacher["nome_centri"];?></p>
										<p><strong>From date: </strong><?php echo date('d/m/Y',strtotime($teacher["teach_from_date"]));?></p>
										<p><strong>To date: </strong><?php echo date('d/m/Y',strtotime($teacher["teach_to_date"]));?></p>
										<p><strong>Hours per day: </strong><?php echo $teacher["teach_hours_per_day"];?></p>
                                                                            </div>
									</td>
									<td class="center"><?php echo $teacher["nome_centri"];?></td>
									<td class="center"><?php echo date('d/m/Y',strtotime($teacher["teach_from_date"]));?></td>
									<td class="center"><?php echo date('d/m/Y',strtotime($teacher["teach_to_date"]));?></td>
                                                                        <td class="center"><?php echo $teacher["teach_hours_per_day"];?></td>
									<td class="center operation">
                                                                            <a title="View" href="javascript:void(0);" id="dialog_modal_btn_<?php echo $teacher["teach_id"];?>" class="dialogbtn">
                                                                                <span class="icon-eye-open"></span>
                                                                            </a>
                                                                            <a title="Edit" href="<?php echo base_url().'index.php/teachers/addedit/'.$teacher["teach_id"];?>">
                                                                                <span class="icon-edit"></span>
                                                                            </a>
                                                                            <a class="changeStatus" data-status="<?php echo $teacher['teach_is_active'];?>" data-id="<?php echo $teacher['teach_id'];?>" title="Change status" href="javascript:void(0);">
                                                                                <span class="<?php echo ($teacher['teach_is_active'] == '1' ? 'icon-check' : 'icon-check-empty');?>"></span>
                                                                            </a>
                                                                            <a title="Delete" onclick="return confirm('Are you sure to delete this teacher?');" href="<?php echo base_url().'index.php/teachers/deleteteachers/'.$teacher["teach_id"];?>">
                                                                                <span class="icon-remove"></span>
                                                                            </a>
                                                                        </td>
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
					</div><!-- End of .content -->
				</div><!-- End of .box -->
			</div><!-- End of .grid_12 -->
			
		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
	
<?php $this->load->view('plused_footer');?>
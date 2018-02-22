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
				<span><?echo $this->session->userdata('businessname') ?></span>
				<ul>
					<li><a href="<?php echo base_url(); ?>index.php/agents/changeCredential">Profile</a></li>
					<li class="line"></li>
					<li><a href="<?php echo base_url(); ?>index.php/agents/logout">Logout</a></li>
				</ul>
			</div>
		</section><!-- End of .toolbar-->	
	
<?php 
	$this->load->view('plused_sidebar');
?>		
		
		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<h1 class="grid_12 margin-top no-margin-top-phone">Sales by Date: <?php echo date("d/m/Y", strtotime($byDate)); ?></h1>
			<div class="row">
				<form style="margin:10px;" id="box_campus" name="box_campus" action="<?php echo base_url(); ?>index.php/backoffice/salesNew" method="post">  
					<div class="grid_12">
						<div class="box">
							<div class="header">
								<h2>Campus
									<span style="float:right;">
										<a href="javascript:void(0);" id="s_USA">USA</a> - 
										<a href="javascript:void(0);" id="s_UK">UK</a> - 
										<a href="javascript:void(0);" id="s_EUR">EUR</a> - 
										<a href="javascript:void(0);" id="s_all">All</a> - 
										<a href="javascript:void(0);" id="s_none">None</a>
									</span>
								</h2>
							</div>
							<div class="content" style="margin:10px;">
										<div class="grid_4">
												<?php
													$contaCentri=0;
													$differenceFormat = "%d";
													foreach($centri as $key=>$item){
														$datetime1 = date_create($byDate);
														$datetime2 = date_create($item['openingDate']);
														$diff = date_diff( $datetime1, $datetime2, false);
														$total = $diff->y * 365.25 + $diff->m * 30 + $diff->d + $diff->h/24 + $diff->i / 60;
														$addDay = " days";
														if($total==0){
															$mycolor = "green";
															$interval = "";
															$addDay = "";
														}else{
															if($total==1)
																$mycolor = "orange";
																$addDay = " day";
															if($total==2)
																$mycolor = "red";
															if($total >= 3)
																$mycolor = "gray";
															if( $diff->invert)
																$interval = "-".$total;
															else
																$interval = "+".$total;
														}
														//$interval = date_diff($datetime1, $datetime2)->format($differenceFormat);
													?>
													 <input type="checkbox" class="chCentri sel_<?php echo $item['valuta_fattura']?>" name="centri[]" id="c_<?php echo $item['id']?>" value="<?php echo $item['id']?>"><span style="color:<?php echo $mycolor ?>"><?php echo $item['nome_centri']?>  <?php echo $interval.$addDay; ?></span><br />
												<?php
													$contaCentri++;
													if($contaCentri%5==0){
														?>
														</div>
														<div class="grid_3">
														<?php
													}
													}
												?>	
											</div>
							</div>
						</div>
					</div>					
					<div class="grid_4">
						<div class="box">
							<div class="header">
								<h2>Start Date</h2>
							</div>
							<div class="content" style="margin:10px;text-align:center;height:68px;">
										<input type="text" readonly id="dateStart" name="dateStart" value="" style="cursor:pointer;" />
							</div>
						</div>
					</div>	
					<div class="grid_4">
						<div class="box">
							<div class="header">
								<h2>End date</h2>
							</div>
							<div class="content" style="margin:10px;text-align:center;height:68px;">
										<input type="text" readonly id="dateEnd" name="dateEnd" value="" style="cursor:pointer;" />
							</div>
						</div>
					</div>						
					<div class="grid_3">
						<div class="box">
							<div class="header">
								<h2>Retrieve data</h2>
							</div>
							<div class="content" style="margin:10px;text-align:center;height:68px;">
								<input type="button" name="inviaO" id="inviaO" value="Retrieve Data" />
							</div>
						</div>
					</div>						
				</form>
			</div>
		</section>	
		
	</div>
	<script>
	function aggiornaAcco(campusId){
		$.ajax({
			url: "<?php echo base_url(); ?>index.php/backoffice/getAccoByCampus/"+campusId+"",
			success: function(html){
					arrAcco = html.toLowerCase().split(";");
					$("input[name='accomodation[]']").each(function(){
						$(this).attr("checked",false);
						$(this).prop("disabled",false);
						if(arrAcco.indexOf($(this).val())==-1){
							$(this).prop("disabled",true);
						}
					});
			}
		});
	}
	
	function disableAcco(){
		$("input.chAcco").each(function(){
			$(this).attr("checked",false);
			$(this).prop("disabled",true);
		});
	}
	
	$(document).ready(function() {
	
	var numberOfChecked = $('input.chCentri:checked').length;
	if(numberOfChecked==1){
		aggiornaAcco($('input.chCentri:checked').val());
	}else{
		disableAcco();
	}
	
	$("#s_USA").click(function(){
		disableAcco();
		$("input.chCentri").each(function(){
				$(this).attr("checked",false);
		});
		$("input.sel_USD").each(function(){
				$(this).attr("checked",true);
		});		
	});
	
	$("#s_UK").click(function(){
		disableAcco();	
		$("input.chCentri").each(function(){
				$(this).attr("checked",false);
		});
		$("input.sel_GBP").each(function(){
				$(this).attr("checked",true);
		});		
	});	
	
	$("#s_EUR").click(function(){
		disableAcco();	
		$("input.chCentri").each(function(){
				$(this).attr("checked",false);
		});
		$("input.sel_EUR").each(function(){
				$(this).attr("checked",true);
		});		
	});		
	
	$("#s_all").click(function(){
		disableAcco();	
		$("input.chCentri").each(function(){
				$(this).attr("checked",true);
		});
	});	

	$("#s_none").click(function(){
		disableAcco();	
		$("input.chCentri").each(function(){
				$(this).attr("checked",false);
		});
	});		
	
	$("input.chCentri").change(function(){
		var numberOfChecked = $('input.chCentri:checked').length;
		//alert(numberOfChecked);
		if(numberOfChecked==1){
			aggiornaAcco($('input.chCentri:checked').val());
		}else{
			$("input.chAcco").each(function(){
				$(this).attr("checked",false);
				$(this).prop("disabled",true);
			});
		}
	});
	/*
	$( "#dateStart" ).datepicker({
	  changeMonth: true,
	  changeYear: true,		  
	  dateFormat: "dd/mm/yy",
	  maxDate: "+1Y"
	}).datepicker("setDate", new Date());; */
	
	$( "#dateStart" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,		  
		dateFormat: "dd/mm/yy",		
		numberOfMonths: 1,
		onClose: function( selectedDate ) {
			$( "#dateEnd" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#dateStart" ).datepicker( "setDate", "<?php echo date("d/m/Y",strtotime($byDate)) ?>" );
	
	$( "#dateEnd" ).datepicker({
		setDate: "16/07/2015",
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,		  
		dateFormat: "dd/mm/yy",		
		numberOfMonths: 1,
		onClose: function( selectedDate ) {
			$( "#dateStart" ).datepicker( "option", "maxDate", selectedDate );
		}
	});	
	$( "#dateEnd" ).datepicker( "setDate", "<?php echo date("d/m/Y",strtotime($byDate . "+15 days")) ?>" );
	


	$('#inviaO').on('click', function(e){
		var centriChecked = $('input.chCentri:checked').length;
		var accomoChecked = $('input.chAcco:checked').length;
		if(centriChecked==0){
			alert("Please, select one or more campus!");
			return false;
		}else{
			if($("#dateStart").val()==""){
				alert("Please, select a start date");
				return false;
			}else{
				if($("#dateEnd").val()==""){
					alert("Please, select an end date");
					return false;
				}
			}		
		}
        var diaH = $(window).height()* 0.9;
        e.preventDefault();
		passingData = $('#box_campus').serialize();
        $('<div/>', {'class':'myDlgClass', 'style' :'background:#fff url(http://plus-ed.com/vision_ag/img/logo_loading.gif) center center no-repeat;', 'id':'link-'+($(this).index()+1)})
            .html($('<iframe/>', {
                'src' : "<?php echo base_url(); ?>index.php/backoffice/salesDetailNew/?"+passingData,
                'style' :'width:100%; height:100%;border:none;',
            })).appendTo('body')
            .dialog({
                'title' : 'Sales detail',
                'width' : '90%',
                'height' : diaH,
                modal: true,
                buttons: [ {
                    text: "Close",
                    click: function() { $( this ).dialog( "close" ); }
                } ]
            });
    });	
	
	
	
		$( "li#boSalesRisks" ).addClass("current");
		$( "li#boSalesRisks a" ).addClass("open");		
		$( "li#boSalesRisks ul.sub" ).css('display','block');	
		$( "li#boSalesRisks ul.sub li#boSalesRisks_1" ).addClass("current");	
		
	});
	</script>	
<?php $this->load->view('plused_footer');?>

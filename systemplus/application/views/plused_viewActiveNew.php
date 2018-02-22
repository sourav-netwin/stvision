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
			<h1 class="grid_12 margin-top no-margin-top-phone">Down payment</h1>
			<div class="row">
				<form style="margin:10px;" id="box_campus" name="box_campus" action="<?php echo base_url(); ?>index.php/bo_accounting/viewActiveNew" method="post">  
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
										<div class="grid_3">
												<?php
													$contaCentri=0;
													foreach($centri as $key=>$item){
													?>
													 <input type="checkbox" class="chCentri sel_<?php echo $item['valuta_fattura']?>" name="centri[]" id="c_<?php echo $item['id']?>" value="<?php echo $item['id']?>"><?php echo $item['nome_centri']?><br />
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
					<div class="grid_5">
						<div class="box">
							<div class="header">
								<h2>Season / Agency</h2>
							</div>
							<div class="content text-center" style="margin:10px;height:37px;">
										<select name="season" id="season">
											<?php for($y=2014;$y<=date("Y")+1;$y++){ ?>
											<option <?php if($season==$y){?>selected <?php }?>value="<?php echo $y ?>"><?php echo $y ?> season</option>
											<?php } ?>
										</select> 
							</div>		
							<div class="content text-center" style="margin:10px;height:37px;">
									<input type="text" name="ag_complete" id="ag_complete" class="ui-autocomplete-input" autocomplete="off" style="width:96%;">
							</div>							
						</div>
					</div>	
					<div class="grid_4">
						<div class="box">
							<div class="header">
								<h2>Bookings Status
									<span style="float:right;">
										<a href="javascript:void(0);" id="bk_all">All</a> - 
										<a href="javascript:void(0);" id="bk_none">None</a>
									</span>
								</h2>
							</div>
							<div class="content" style="margin:10px;padding-bottom:33px;">
									<input class="chStatus" type="checkbox" name="status[]" id="s_confirmed" value="confirmed">Confirmed<br />
									<input class="chStatus" type="checkbox" name="status[]" id="s_active" value="active">Active<br />
									<input class="chStatus" type="checkbox" name="status[]" id="s_elapsed" value="elapsed">Elapsed<br />
									<?php /* <input class="chStatus" type="checkbox" name="status[]" id="s_tbc" value="tbc">To Be Confirmed<br /> */ ?>
									<?php /* <input class="chStatus" type="checkbox" name="status[]" id="s_rejected" value="rejected">Rejected<br /> */ ?>
							</div>
						</div>
					</div>	
					<div class="grid_3">
						<div class="box">
							<div class="header">
								<h2>Retrieve Bookings</h2>
							</div>
							<div class="content" style="margin:10px;text-align:center;height:85px;">
								<input type="button" name="inviaO" id="inviaO" value="Retrieve Bookings" />
							</div>
						</div>
					</div>		
					<input name="agenzia_in" id="idAgente" value="" type="hidden" />
				</form>
			</div>
		</section>	
		
	</div>
	<script>

	
	$(document).ready(function() {
	
	$("#s_USA").click(function(){
		$("input.chCentri").each(function(){
				$(this).attr("checked",false);
		});
		$("input.sel_USD").each(function(){
				$(this).attr("checked",true);
		});		
	});
	
	$("#s_UK").click(function(){
		$("input.chCentri").each(function(){
				$(this).attr("checked",false);
		});
		$("input.sel_GBP").each(function(){
				$(this).attr("checked",true);
		});		
	});	
	
	$("#s_EUR").click(function(){
		$("input.chCentri").each(function(){
				$(this).attr("checked",false);
		});
		$("input.sel_EUR").each(function(){
				$(this).attr("checked",true);
		});		
	});		
	$("#s_all").click(function(){
		$("input.chCentri").each(function(){
				$(this).attr("checked",true);
		});
	});	

	$("#s_none").click(function(){
		$("input.chCentri").each(function(){
				$(this).attr("checked",false);
		});
	});	
	$("#bk_all").click(function(){
		$("input.chStatus").each(function(){
				$(this).attr("checked",true);
		});
	});	

	$("#bk_none").click(function(){
		$("input.chStatus").each(function(){
				$(this).attr("checked",false);
		});
	});		
	
	<?php 
		if($pStatus=="tbc"){
	?>
		$("input.chCentri").each(function(){
			$(this).attr("checked",true);
		});
		$("#s_<?php echo $pStatus ?>").attr("checked",true);
	<?php
		}
	?>
	
	
	$( "#dateStart" ).datepicker({
	  changeMonth: true,
	  changeYear: true,		  
	  dateFormat: "dd/mm/yy",
	  maxDate: "+1Y"
	}).datepicker("setDate", new Date());;
	


	$('#inviaO').on('click', function(e){
		var centriChecked = $('input.chCentri:checked').length;
		var statusChecked = $('input.chStatus:checked').length;
		if(centriChecked==0){
			alert("Please, select one or more campus!");
			return false;
		}else{
			if(statusChecked==0){
				alert("Please, select one or more status!");
				return false;
			}				
		}
		if($("#ag_complete").val()==""){
			$("#idAgente").val("");
		}
        var diaH = $(window).height()* 0.9;
        e.preventDefault();
		passingData = $('#box_campus').serialize();
        $('<div/>', {'class':'myDlgClass', 'style' :'background:#fff url(<?php echo base_url(); ?>img/logo_loading.gif) center center no-repeat;', 'id':'link-'+($(this).index()+1)})
            .html($('<iframe/>', {
                'src' : "<?php echo site_url(); ?>/backoffice/overviewBookingsDetailNew/?"+passingData,
                'style' :'width:100%; height:100%;border:none;',
            })).appendTo('body')
            .dialog({
                'title' : 'Bookings detail',
                'width' : '90%',
                'height' : diaH,
                modal: true,
                buttons: [ {
                    text: "Close",
                    click: function() { $( this ).dialog( "close" ); }
                } ]
            });
    });	
	
	$("#ag_complete").autocomplete({
		source: function (request, response) {
			 // request.term is the term searched for.
			 // response is the callback function you must call to update the autocomplete's 
			 // suggestion list.
			 $.ajax({
				 url: "http://plus-ed.com/vision_ag/index.php/backoffice/getAgenciesForAutoComplete/"+request.term,
				 dataType: "json",
				 success: response,
				 error: function () {
					 response([]);
				 }
			 });
		}
	});
	
	$("#ag_complete").on("autocompleteselect", function (e, ui) {
		e.preventDefault();
		$("#idAgente").val(ui.item.id);
		this.value = ui.item.label;
	});	

		$( "li#boaccounting" ).addClass("current");
		$( "li#boaccounting a" ).addClass("open");		
		$( "li#boaccounting ul.sub" ).css('display','block');	
		$( "li#boaccounting ul.sub li#boaccounting_1" ).addClass("current");			
		
	});
	</script>	
<?php $this->load->view('plused_footer');?>

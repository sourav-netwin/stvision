<?php $this -> load -> view('plused_header'); ?>
<!-- The container of the sidebar and content box -->
<style type="text/css">
	@media(max-width: 650px){
		.box{
			background-color: #FFFFFF;
		}
		#inviaO{
			margin: 10px;
			float: none !important;
		}
		.btnDisp{
			text-align: center;
		}
	}
</style>
<div role="main" id="main" class="container_12 clearfix">
	<!-- The blue toolbar stripe -->
	<section class="toolbar">
		<div class="user">
			<div class="avatar">
				<img src="<?php echo base_url(); ?>img/layout/content/toolbar/user/avatar.png">
				<!-- Evidenziare per icone attenzione <span>3</span> -->
			</div>
			<span><? echo $this -> session -> userdata('businessname') ?></span>
			<ul>
				<li><a href="<?php echo base_url(); ?>index.php/agents/changeCredential">Profile</a></li>
				<li class="line"></li>
				<li><a href="<?php echo base_url(); ?>index.php/agents/logout">Logout</a></li>
			</ul>
		</div>
	</section><!-- End of .toolbar-->	
	<?php
	$this -> load -> view('plused_sidebar');
	?>		
	<!-- Here goes the content. -->
	<section id="content" class="container_12 clearfix" data-sort=true>
		<h1 class="grid_12 margin-top no-margin-top-phone">Review CM Balances</h1>
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
								$contaCentri = 0;
								foreach ($centri as $key => $item) {
									?>
									<input type="checkbox" class="chCentri sel_<?php echo $item['valuta_fattura'] ?>" name="centri[]" id="c_<?php echo $item['id'] ?>" value="<?php echo $item['id'] ?>"><?php echo $item['nome_centri'] ?><br />
									<?php
									$contaCentri++;
									if ($contaCentri % 5 == 0) {
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
				<div class="grid_12 btnDisp">
					<input type="button" name="inviaO" id="inviaO" value="Retrieve CM Balances" style="float: right;" />
				</div>
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
		$('#inviaO').on('click', function(e){
			var centriChecked = $('input.chCentri:checked').length;
			var statusChecked = $('input.chStatus:checked').length;
			if(centriChecked==0){
				alert("Please, select one or more campus!");
				return false;
			}
			var passingData = '';
			var dataCnt = 0;
			$('input.chCentri:checked').each(function(){
				if(dataCnt == 0){
					passingData += $(this).val();
				}
				else{
					passingData += '/'+$(this).val();
				}
				dataCnt += 1;
			});
			var diaH = $(window).height()* 0.9;
			e.preventDefault();
			$('<div/>', {'class':'myDlgClass', 'style' :'background:#fff url(<?php echo base_url(); ?>img/logo_loading.gif) center center no-repeat;', 'id':'link-'+($(this).index()+1)})
			.html($('<iframe/>', {
				'src' : "<?php echo site_url(); ?>/bo_accounting/cmBalanceView/"+passingData,
				'style' :'width:100%; height:100%;border:none;'
			})).appendTo('body')
			.dialog({
				'title' : 'Balance detail',
				'width' : '90%',
				'height' : diaH,
				modal: true,
				buttons: [ {
						text: "Close",
						click: function() { $( this ).dialog( "close" ); }
					} ]
			});
		});
		$( "li#boaccounting" ).addClass("current");
		$( "li#boaccounting a" ).addClass("open");		
		$( "li#boaccounting ul.sub" ).css('display','block');	
		$( "li#boaccounting ul.sub li#boaccounting_6" ).addClass("current");			
		
	});
</script>	
<?php $this -> load -> view('plused_footer'); ?>

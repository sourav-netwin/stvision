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
<?php $this->load->view('plused_sidebar');?>		
	<script>
	$(document).ready(function() {
		$( "li#botransfers" ).addClass("current");
		$( "li#botransfers a" ).addClass("open");		
		$( "li#botransfers ul.sub" ).css('display','block');
		<?php 
		if($in_out=="inbound"){
		?>
		$( "li#botransfers ul.sub li#botransfers_1" ).addClass("current");	
		<?php 
		}else{
		?>
		$( "li#botransfers ul.sub li#botransfers_2" ).addClass("current");	
		<?php 
		}
		?>
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<form style="margin:10px;" id="box_transport" name="box_transport" action="<?php echo base_url(); ?>index.php/backoffice/setTransfers/<?php echo $in_out ?>" method="post">  
				<h1 class="grid_12 margin-top no-margin-top-phone">Book inbound transfers <a href="#" id="findTr">-</a></h1>
				<div class="grid_6">
					<div class="box">
						<div class="header">
							<h2>Select Campus</h2>
						</div>
						<div class="content" style="margin:8px 4px;">
							<select name="centri" id="centricampus">
								<option value="">All Campus</option>
								<?php
									 foreach($centri as $key=>$item){?>
								 <option <?if($campus==$item['id']){?>selected <?php }?>value="<?php echo $item['id']?>"><?php echo $item['nome_centri']?></option>
								<?php 	 }
								?>
							</select> 
						</div>
					</div>
				</div>
				<div class="grid_5">
					<div class="box">
						<div class="header">
							<h2>Select Date</h2>
						</div>
						<div class="content" style="margin:8px 4px;">
							<?php 
							if($in_out=="inbound"){
							?>
							<label for="when">Arrival day</label>
							<?php
							}else{
							?>
							<label for="when">Departure day</label>
							<?php
							}
							?>
							<input type="text" id="when" name="when" value="<?php echo $when ?>" style="width:80px;" />
						</div>
					</div>
				</div>	
				<div class="grid_1">
						<div class="content" style="margin-top:30px;text-align:center;">
							<input type="button" name="transpmi" id="transpmi" class="cercaid" value="Search" />
						</div>
				</div>	
			</form>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Book <?php echo $in_out ?> transfers</h2>
					</div>
		
					<div class="content">
						<div class="tabletools">
							<div class="left">
							</div>
							<div class="right">								
							</div>
						</div>
						<table class="styled" data-table-tools='{"display":false}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Campus</th>
									<th>Booking ID</th>
									<th>Agency</th>									
									<th>Arrival Date</th>
									<th style="width:120px;">Arrival Flight</th>																									
									<th>Pax</th>
									<th>Select</th>
								</tr>
							</thead>
							<?php
							$arrdataw = explode("/",$when);
							//print_r($arrdataw);
							$datagiusta = $arrdataw[2]."-".$arrdataw[1]."-".$arrdataw[0];
							?>
							<form name="alltran" id="alltran" method="POST" action="<?php echo base_url(); ?>index.php/backoffice/setTransfersTransport/<?php echo $in_out ?>/<?php echo $campus ?>/<?php echo $datagiusta ?>">
							<tbody>
							<?php 
							if(count($all_transfers)>0){
							foreach($all_transfers as $exc){
							?>
								<tr>
									<td><?php echo $exc["nome_centri"]?></td>
									<td class="center n_<?php echo $exc["statopre"]?>">
										<span class="idofbook"><?php echo $exc["bookid"]?><?php if($exc["start_end_overnight"]=="end"){ ?><br /><span style="background-color: #FFF;color: #f00;padding: 1px 4px;border-radius: 5px;font-size: 10px;">NO TRNSF IN (ref. <?php echo $exc["id_ref_overnight"] ?>)</span><?php } ?><br /><span style="color:#f00"><?php echo $exc["totForBook"]?> pax unmatched</span></span>
									</td>
									<td><img class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $exc["businesscountry"]?>.png" alt="<?php echo $exc["businesscountry"]?>" title="<?php echo $exc["businesscountry"]?>" /><?php echo $exc["businessname"]?></td>
									<td class="center"><?php echo date("d/m/Y",strtotime($exc["andata_data_arrivo"]))?></td>
									<td class="center" style="width:120px;"><div style="width:60px;background-color:#ddd;float:left;color:#17549B;"><?php echo date("H:i",strtotime($exc["andata_data_arrivo"]))?></div><div style="width:60px;background-color:#ccc;float:left;font-weight:bold;color:#333;"><?php echo $exc["andata_volo"]?></div><div style="width:120px;background-color:#bbb;clear:left;float:left;font-weight:normal;color:#000;"><?php echo $exc["andata_apt_partenza"]?> &#x2708; <?php echo $exc["andata_apt_arrivo"]?></div><?php if($exc["ptt_buscompany_code"]!=""){ ?><button style="width:120px;" <?php if($campus==""){ ?>disabled <?php } ?>class="button red addToTransfer" id="<?php echo $exc["ptt_buscompany_code"]?>_<?php echo $exc["id_book"] ?>_<?php echo $exc["id_year"] ?>_<?php echo $exc["totnumpax"]?>" name="">Add to <?php echo $exc["ptt_buscompany_code"]?><br /><?php echo $exc["oldName"]?></button><?php } ?></td>
									<td><?php echo $exc["totnumpax"]?></td>
									<td class="center containcheck"><input <?php if($campus=="" or $exc["andata_volo"]=="" or $exc["andata_apt_arrivo"] == ""){ ?>disabled <?php } ?>type="checkbox" name="transfer[]" value="<?php echo $exc["bookid"]?>_<?php echo date("U",strtotime($exc["andata_data_arrivo"]))?>_<?php echo $exc["andata_apt_partenza"]?>_<?php echo $exc["andata_apt_arrivo"]?>_<?php echo $exc["andata_volo"]?>_<?php echo $exc["idcentro"]?>_<?php echo $exc["totnumpax"]?>" class="transfer" /></td>
									
								</tr>
							<?php
								}
							}
							?>
							</tbody>
							</form>
						</table>
						<table class="styled" style="border-top:1px solid #ddd;">
							<tfoot>
								<tr>
									<td style="text-align:right;"><button <?php if($campus==""){ ?>disabled <?php } ?>class="button red block" id="tra_all" name="tra_all" class="alt_btn">Set transportation for selected transfers</button></td>
								</tr>
							</tfoot>
						</table>						
					</div><!-- End of .content -->
				</div><!-- End of .box -->
			</div><!-- End of .grid_12 -->
		</section><!-- End of #content -->
	</div><!-- End of #main -->
	
	

	
<script>
$(document).ready(function(){
	$('#transpmi').click(function(){
		$('#loading-data').show();
		$('#box_transport').submit();
	});
	
	$('#findTr').on('click', function(e){
        var diaH = $(window).height()* 0.9;
        e.preventDefault();
		passingData = $('#box_campus').serialize();
        $('<div/>', {'class':'myDlgClass', 'style' :'background:#fff url(http://plus-ed.com/vision_ag/img/logo_loading.gif) center center no-repeat;', 'id':'link-'+($(this).index()+1)})
            .html($('<iframe/>', {
                'src' : "http://plus-ed.com/vision_ag/index.php/backoffice/transferCalendar/?"+passingData,
                'style' :'width:100%; height:100%;border:none;',
            })).appendTo('body')
            .dialog({
                'title' : 'Transfer Calendar',
                'width' : '90%',
                'height' : diaH,
                modal: true,
                buttons: [ {
                    text: "Close",
                    click: function() { $( this ).dialog( "close" ); }
                } ]
            });
    });	
	
})
</script>
  <script>
  $(document).ready(function(){
    $( "#when" ).datepicker({
      defaultDate: "+1d",
      changeMonth: true,
      numberOfMonths: 1,
	  dateFormat: "dd/mm/yy"
    });
	$("#tra_all").click(function(){
		$("#alltran").submit();
	});
	$(".addToTransfer").click(function(e){
		e.preventDefault();
		arrmid = $(this).attr("id").split("_");
		if(confirm("Are you sure you want to add these pax to this service?")){
			window.location.replace("<?php echo base_url(); ?>index.php/backoffice/addPaxToExistingTransfer/"+arrmid[0]+"/"+arrmid[1]+"/"+arrmid[2]+"/"+arrmid[3]);
		}else{
			return(void(0));
		}
	});
  });
  </script>
<?php $this->load->view('plused_footer');?>

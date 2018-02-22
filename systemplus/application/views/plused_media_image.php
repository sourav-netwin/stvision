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
					<?php if($this->session->userdata('role')!=97){ ?>
					<li><a href="<?php echo base_url(); ?>index.php/agents/changeCredential">Profile</a></li>
					<li class="line"></li>
					<?php } ?>
					<li><a href="<?php echo base_url(); ?>index.php/agents/logout">Logout</a></li>
				</ul>
			</div>
			<!-- <input type="search" data-source="extras/search.php" placeholder="Search..." autocomplete="off" class="tooltip" title="e.g. Canterbury" data-gravity=s> -->
		</section><!-- End of .toolbar-->
<?php $this->load->view('plused_sidebar');?>		
	<script>
	$(document).ready(function() {
		$( "li#imagegallery" ).addClass("current");
		$( "li#imagegallery a" ).addClass("open");		
		$( "li#imagegallery ul.sub" ).css('display','block');	
		$( "li#imagegallery ul.sub li#media_1" ).addClass("current");			
	});
	</script>		
		<!-- Optional: Right Sidebar -->
		<div class="right-sidebar">
			<ul class=nav>
				<li class="current"><a href="#mi_1"><span class="icon icon-list-alt"></span>College images</a></li>
				<li><a href="#mi_2" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Cities images</a></li>
				<li><a href="#mi_3" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Students images</a></li>
			</ul>
		</div><!-- End of right sidebar -->
		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix with-right-sidebar" data-sort=true>

		<h1 class="grid_12 margin-top">Image gallery</h1>
		
			<div class="vertical-tabs grid_12">
<?php
function elencafiles($dirname,$arrayext){
	$dirname = strtolower($dirname);
	$arrayfiles=Array();
	if(file_exists($dirname)){
		$handle = opendir($dirname);
		while (false !== ($file = readdir($handle))) { 
			if(is_file($dirname.$file)){
				if(strrpos($dirname.$file, '-s_')){
					array_push($arrayfiles,$file);
				}
			}
		}
		$handle = closedir($handle);
	}
	sort($arrayfiles);
	return $arrayfiles;
}
?>
				<div id="mi_1" class="box">
<?php
$directory="/var/www/html/www.plus-ed.com/vision_ag/gallery/college/";
$array_extimg=array('.jpg');
$arrayfile=array();
?>
					<div class="header">
					<h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/images-stack.png" class="icon">College images</h2>
					</div>
					<div class="content">
						<div class="gallery">
<?php
	$arrayfile=elencafiles($directory,$array_extimg);
	if(count($arrayfile)){ 
		foreach($arrayfile as $nome_small){
			$nome_big=str_replace("-s_","-b_",$nome_small);
			$nome_esteso=str_replace("_"," ",str_replace(".jpg","",str_replace("-s_","",$nome_small)));
			?>
							<div class="image">
								<a href="<?php echo base_url(); ?>gallery/college/<?php echo $nome_big?>" rel="gallery0"><img src="<?php echo base_url(); ?>gallery/college/<?php echo $nome_small?>"></a><span><?php echo $nome_esteso?></span>
							</div>
<?php
		}
	}else{?>
		<li>No images for this category</li>
	<?php
	}
?>	
						</div>
					</div>
				</div>
				
				<div id="mi_2" class="box">
<?php
$directory="/var/www/html/www.plus-ed.com/vision_ag/gallery/cities/";
$array_extimg=array('.jpg');
$arrayfile=array();
?>
					<div class="header">
					<h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/images-stack.png" class="icon">Cities images</h2>
					</div>
					<div class="content">
						<div class="gallery">
<?php
	$arrayfile=elencafiles($directory,$array_extimg);
	if(count($arrayfile)){ 
		foreach($arrayfile as $nome_small){
			$nome_big=str_replace("-s_","-b_",$nome_small);
			$nome_esteso=str_replace("_"," ",str_replace(".jpg","",str_replace("-s_","",$nome_small)));
			?>
							<div class="image">
								<a href="<?php echo base_url(); ?>gallery/cities/<?php echo $nome_big?>" rel="gallery0"><img src="<?php echo base_url(); ?>gallery/cities/<?php echo $nome_small?>"></a><span><?php echo $nome_esteso?></span>
							</div>
<?php
		}
	}else{?>
		<li>No images for this category</li>
	<?php
	}
?>	
						</div>
					</div>
				</div>

				<div id="mi_3" class="box">
<?php
$directory="/var/www/html/www.plus-ed.com/vision_ag/gallery/students/";
$array_extimg=array('.jpg');
$arrayfile=array();
?>
					<div class="header">
					<h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/images-stack.png" class="icon">Students images</h2>
					</div>
					<div class="content">
						<div class="gallery">
<?php
	$arrayfile=elencafiles($directory,$array_extimg);
	if(count($arrayfile)){ 
		foreach($arrayfile as $nome_small){
			$nome_big=str_replace("-s_","-b_",$nome_small);
			$nome_esteso=str_replace("_"," ",str_replace(".jpg","",str_replace("-s_","",$nome_small)));
			?>
							<div class="image">
								<a href="<?php echo base_url(); ?>gallery/students/<?php echo $nome_big?>" rel="gallery0"><img src="<?php echo base_url(); ?>gallery/students/<?php echo $nome_small?>"></a><span><?php echo $nome_esteso?></span>
							</div>
<?php
		}
	}else{?>
		<li>No images for this category</li>
	<?php
	}
?>	
						</div>
					</div>
				</div>	
			</div><!-- End of .vertical-tabs -->
			
		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
<?php $this->load->view('plused_footer');?>

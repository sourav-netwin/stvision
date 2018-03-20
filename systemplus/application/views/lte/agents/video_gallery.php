<!------Load necessary css files for datatable and fancybox------>
<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo LTE;?>plugins/fancybox/jquery.fancybox-buttons.css">
<link rel="stylesheet" href="<?php echo LTE;?>plugins/fancybox/jquery.fancybox-thumbs.css">
<link rel="stylesheet" href="<?php echo LTE;?>plugins/fancybox/jquery.fancybox.css">

<div class="box">
	<div class="row">
		<?php showSessionMessageIfAny($this); ?>
	</div>
	<div class="box-body" style="padding-top:0;min-height: 410px;">
		<div class="box-header with-border">
			<h4 class="box-title"><?php echo $breadcrumb2; ?></h4>
		</div>
		<div class="box-body">
			<div id="campus_images" class="box-group">
				<div id="campus_videos" class="box-group">
<?php
					if( !empty( $campusDetails ) )
					{
?>
						<div class="row">
<?php
							foreach($campusDetails as $campus)
							{
								if($campus["image_path"] != "")
									$img_path = base_url().CAMPUS_IMAGE_PATH. $campus["image_path"];
								else
									$img_path = base_url().'img/placeholder_image.png';

								$video_arr = array();
								if($campus['campus_video_1'] != '')
								{
									$video_1 = substr(parse_url($campus['campus_video_1'] , PHP_URL_PATH) , 1);
									array_push($video_arr , $video_1);
								}
								if($campus['campus_video_2'] != '')
								{
									$video_2 = substr(parse_url($campus['campus_video_2'] , PHP_URL_PATH) , 1);
									array_push($video_arr , $video_2);
								}
								if($campus['campus_video_3'] != '')
								{
									$video_3 = substr(parse_url($campus['campus_video_3'] , PHP_URL_PATH) , 1);
									array_push($video_arr , $video_3);
								}
								if($campus['campus_video_4'] != '')
								{
									$video_4 = substr(parse_url($campus['campus_video_4'] , PHP_URL_PATH) , 1);
									array_push($video_arr , $video_4);
								}
?>
								<div class="col-sm-3 campus-gallery-image-col">
									<div class="img_outer">
										<div class="img_box_main">
											<a class="fancybox" data-fancybox-type="iframe" rel="gallery<?php echo $campus['id']?>" href="<?php echo ( !empty( $video_arr ) ) ? 'https://player.vimeo.com/video/'.$video_arr[0] : 'javascript:void(0);'?>">
												<img src="<?php echo $img_path; ?>" class="img-responsive"/>
											</a>
<?php
											if(count($video_arr) > 1)
											{
												for($i = 1 ; $i < count($video_arr) ; $i++)
												{
?>
													<a class="fancybox" data-fancybox-type="iframe" rel="gallery<?php echo $campus['id']?>" href="https://player.vimeo.com/video/<?php echo $video_arr[$i]?>" style="display: none;"></a>
<?php
												}
											}
?>
										</div>
									</div>
									<h5><?php echo $campus['nome_centri']; ?></h5>
								</div>
<?php
							}
?>
						</div>
<?php
					}
					else
					{
?>
						<li>No videos for this category</li>
<?php
					}
?>
				</div>
			</div>
		</div>
	</div>
	<div class="box-footer">&nbsp;</div>
</div>

<!-----------Load necessary js files------------>
<script src="<?php echo LTE;?>plugins/fancybox/jquery.fancybox.js"></script>
<script src="<?php echo LTE;?>plugins/fancybox/jquery.fancybox-buttons.js"></script>
<script src="<?php echo LTE;?>plugins/fancybox/jquery.fancybox-thumbs.js"></script>
<script src="<?php echo LTE;?>plugins/fancybox/jquery.easing-1.3.pack.js"></script>
<script src="<?php echo LTE;?>plugins/fancybox/jquery.mousewheel-3.0.6.pack.js"></script>
<script>
	pageHighlightMenu = "agents/videoGallery";
	$(document).ready(function()
	{
		$('.fancybox').fancybox({
			beforeShow : function(){
				this.title =  $(this.element).data("caption");
			}
		});
	});
</script>
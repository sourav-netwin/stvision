<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<!-- <link rel="stylesheet" href="<?php echo LTE;?>plugins/fancybox/jquery.fancybox-buttons.css">
<link rel="stylesheet" href="<?php echo LTE;?>plugins/fancybox/jquery.fancybox-thumbs.css">
<link rel="stylesheet" href="<?php echo LTE;?>plugins/fancybox/jquery.fancybox.css"> -->

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
      <?php
        if( !empty( $campusImages ) )
        {
      ?>
          <div class="row">
      <?php
            foreach ( $campusImages as $campus => $campus_image )
            {
              $arr = explode('_', $campus);
              $campus_id = $arr[1];
              $campus_name = $arr[0];
      ?>
              <div class="col-sm-3 campus-gallery-image-col">
                <div class="img_outer">
                  <div class="img_box_main">
                    <a class="fancybox" data-image_id = "<?php echo $campus_image[0]['campus_image_id']; ?>" rel="gallery<?php echo $campus_id ?>" href="<?php echo base_url() . CAMPUS_IMAGE_PATH. $campus_image[0]['image_name']; ?>" data-caption="<?php echo $campus_image[0]['title'] ?>" data-fancybox="images<?php echo $campus_id ?>">
                      <img src="<?php echo base_url() . CAMPUS_IMAGE_PATH. $campus_image[0]['image_name']; ?>" class="img-responsive"/>
                    </a>
                    <?php
                      if( count($campus_image) > 1 )
                      {
                        for( $i = 1; $i < count($campus_image); $i++ )
                        {
                    ?>
                          <a class="fancybox" data-image_id = "<?php echo $campus_image[$i]['campus_image_id']; ?>" rel="gallery<?php echo $campus_id ?>" href="<?php echo base_url() . CAMPUS_IMAGE_PATH. $campus_image[$i]['image_name']; ?>" data-caption="<?php echo $campus_image[$i]['title'] ?>" data-fancybox="images<?php echo $campus_id ?>">
                          </a>
                    <?php
                        }
                      }
                    ?>
                  </div>
                </div>
                <h5><?php echo $campus_name; ?></h5>
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
          <li>No images for this category</li>
      <?php
        }
      ?>
      </div>
    </div>
  </div>
  <!-- /.box-body -->
  <div class="box-footer">
    &nbsp;
  </div>
  <!-- /.box-footer-->
</div>

<!-- <script src="<?php echo LTE;?>plugins/fancybox/jquery.fancybox.js"></script>
<script src="<?php echo LTE;?>plugins/fancybox/jquery.fancybox-buttons.js"></script>
<script src="<?php echo LTE;?>plugins/fancybox/jquery.fancybox-thumbs.js"></script>
<script src="<?php echo LTE;?>plugins/fancybox/jquery.easing-1.3.pack.js"></script>
<script src="<?php echo LTE;?>plugins/fancybox/jquery.mousewheel-3.0.6.pack.js"></script> -->

<!-- <script>
  pageHighlightMenu = "agents/imageGallery";
  $(document).ready(function() {
    $('.fancybox').fancybox({
      beforeShow : function(){
        this.title =  $(this.element).data("caption");
      }
    });
  });
</script> -->

<!---------CSS and JS for jquery fancy box (New version)------------>
<link rel="stylesheet" href="<?php echo LTE;?>frontweb/jquery.fancybox.css">
<script src="<?php echo LTE;?>frontweb/jquery.fancybox.js"></script>

<script>
	pageHighlightMenu = "agents/imageGallery";
	$(document).ready(function(){
		$('.fancybox').fancybox({
			buttons : [
				'download',
				'close'
			],
			afterShow : function(instance , current){
				$('.fancybox-button--download').attr('href' , '<?php echo base_url().'index.php/agents/download_image/'; ?>'+current.opts.$orig.attr("data-image_id"));
			}
		});
	});
</script>
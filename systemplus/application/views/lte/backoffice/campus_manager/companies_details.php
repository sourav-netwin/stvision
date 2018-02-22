<section class="content">
  <?php
    if( $companies )
    {
      foreach( $companies as $cp )
      {
  ?>
        <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">

              <div class="box-body pos_rel">                

                <h4>
                  <?php echo $cp["tra_cp_name"] ?>                  
                </h4>

                <div>
                  <?php echo $cp["tra_cp_address"] ?><br />
                  Tel: <?php echo $cp["tra_cp_phone"] ?> - Fax: <?php echo $cp["tra_cp_fax"] ?> - Email: <?php echo $cp["tra_cp_email"] ?><br />
                </div>
                <?php if($this -> session -> userdata('role') != 553){ ?>
                <div>
                  <a style="margin:10px 5px;display: inline-block;" href="<?php echo base_url(); ?>backoffice/cms_coach_company/<?php echo $cp["tra_cp_id"] ?>" title="Edit <?php echo $cp["tra_cp_name"] ?>">
                    <img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/pencil-small.png">
                  </a>
                  <a style="margin:10px 5px;display: inline-block;" href="<?php echo base_url(); ?>backoffice/cms_bus_coach_company/<?php echo $cp["tra_cp_id"] ?>" title="Edit bus for <?php echo $cp["tra_cp_name"] ?>">
                    <img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/bus_excursion.png">
                  </a>
                </div>
                <?php } ?>
                <span class="company_number">Emergency Line: <?php echo $cp["tra_cp_emergency"] ?></span>
              </div>
            </div>
            <!--/.direct-chat -->
          </div>
        </div>
  <?php 
      }
    }
  ?>
</section>
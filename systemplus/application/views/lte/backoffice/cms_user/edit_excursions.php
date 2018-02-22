<?php $CC = $excursion; ?>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div>
        <span>
          <img src="<?php echo base_url(); ?>img/elements/profile/avatar_campus.png" />
        </span>
        <span class="campus_edit_title">
          <h3><?php echo $CC['exc_excursion'] ?></h3>
          <h5><?php echo $CC['exc_centro'] ?></h5>
        </span>
      </div>

      <div class="box">
        <div class="box-header col-sm-12">
          <div class="row">
            <?php showSessionMessageIfAny($this);?>
          </div>
        </div>

        <form class="form-horizontal validate" name="persoprofile" id="persoprofile" action="<?php echo base_url(); ?>index.php/backoffice/cmsUpdateExcursion/<?php echo $CC['exc_id'] ?>" method="POST">

          <div class="box-body">

            <div class="form-group">
              <label class="col-sm-2 control-label" for="exc_excursion">Excursion</label>
              <div class="col-sm-4">
                <input class="form-control" type="text" name="exc_excursion" id="exc_excursion" value="<?php echo $CC['exc_excursion'] ?>">
                <div class="error"><?php echo form_error('exc_excursion');?></div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="exc_id_centro">Campus</label>
              <div class="col-sm-4">
                <select class="form-control" id="exc_id_centro" name="exc_id_centro">
                  <option value="">Select Campus</option>
                  <?php
                    if( $campus )
                    {
                      foreach( $campus as $camp )
                      {
                  ?>
                      <option value="<?php echo $camp['id'] ?>" <?php if($camp['id']==$CC['exc_id_centro']){ ?> selected="selected"<?php } ?>><?php echo $camp['nome_centri'] ?></option>
                <?php }
                    }
                ?>
                </select>
                <div class="error"><?php echo form_error('exc_id_centro');?></div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="exc_length">Length</label>
              <div class="col-sm-4">
                <select class="form-control" name="exc_length" id="exc_length">
                  <option value="half day"<?php if($CC['exc_length']=="half day"){ ?> selected="selected"<?php } ?>>Half day</option>
                  <option value="full day"<?php if($CC['exc_length']=="full day"){ ?> selected="selected"<?php } ?>>Full day</option>
                </select>
                <div class="error"><?php echo form_error('exc_length');?></div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="exc_type">Type</label>
              <div class="col-sm-4">
                <select class="form-control" name="exc_type" id="exc_type">
                  <option value="planned"<?php if($CC['exc_type']=="planned"){ ?> selected="selected"<?php } ?>>Planned</option>
                  <option value="extra"<?php if($CC['exc_type']=="full day"){ ?> selected="selected"<?php } ?>>Extra</option>
                </select>
                <div class="error"><?php echo form_error('exc_type');?></div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="exc_weeks">Weeks</label>
              <div class="col-sm-4">
                <select class="form-control" name="exc_weeks" id="exc_weeks">
                  <option value="1"<?php if($CC['exc_weeks']=="1"){ ?> selected="selected"<?php } ?>>1 week</option>
                  <option value="2"<?php if($CC['exc_weeks']=="2"){ ?> selected="selected"<?php } ?>>2 weeks</option>
                  <option value="3"<?php if($CC['exc_weeks']=="3"){ ?> selected="selected"<?php } ?>>3 weeks</option>
                </select>
                <div class="error"><?php echo form_error('exc_weeks');?></div>
              </div>
            </div>

            <div class="form-group">
              <div class="form-data col-sm-10 col-md-offset-2">
                <input class="btn btn-primary" id="modprofile" type="submit" value="Update excursion details" name=modprofile />
              </div>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
              &nbsp;
          </div>
          <!-- /.box-footer-->
        </form>
      </div>
    </div>
  </div>
</section>
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script>
  pageHighlightMenu = "backoffice/cmsManageExcursions/planned";
</script>

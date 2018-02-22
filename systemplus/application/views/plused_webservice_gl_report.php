<?php $this->load->view('plused_header'); ?>
<!-- The container of the sidebar and content box -->
<div role="main" id="main" class="container_12 clearfix reportsFilters">

  <!-- The blue toolbar stripe -->
  <section class="toolbar">
    <div class="user">
      <div class="avatar">
        <img src="<?php echo base_url(); ?>img/layout/content/toolbar/user/avatar.png">
      </div>
      <span><?php echo $this->session->userdata('businessname') ?></span>
      <ul>
        <?php
          $bOArray = array(200,300,400,100,550); // BACKOFFICE USERS ROLE IDS
          if($this->session->userdata('username') && in_array($this->session->userdata('role'), $bOArray)){
        ?>
            <li><a href="<?php echo base_url(); ?>index.php/backoffice/profile">Profile</a></li>
            <li class="line"></li>
            <li><a href="<?php echo base_url(); ?>index.php/backoffice/logout">Logout</a></li>
        <?php
        } elseif ($this->session->userdata('role')!=97) { ?>
            <li><a href="<?php echo base_url(); ?>index.php/agents/changeCredential">Profile</a></li>
            <li class="line"></li>
            <li><a href="<?php echo base_url(); ?>index.php/agents/logout">Logout</a></li>
        <?php } else { ?>
              <li><a href="<?php echo base_url(); ?>index.php/agents/logout">Logout</a></li>
        <?php } ?>

      </ul>
    </div>
  </section><!-- End of .toolbar-->

  <?php $this->load->view('plused_sidebar');?>

  <!-- Here goes the content. -->
  <section id="content" class="container_12 clearfix survey-report-content" data-sort=true>
    <h1 class="grid_12 margin-top no-margin-top-phone">Export by GL</h1>
    <div class="row">
      <div class="grid_12 mr-top-10" style="min-height:250px;">
        <div class="box">
          <form class="webservice-report-form" id="frmWebserviceGlReport" onsubmit="return validate();" action="<?php echo base_url(); ?>index.php/webservice/glReport" method="post">
            <div class="header">
              <h2>Export by GL</h2>
            </div>
            <div class="content" style="margin: 10px;">

              <div class="form-data grid_4">
                <div class="left-class">
                  <label for="txtCollaboratore" style="width: 115px;">
                    <strong>Collaboratore</strong>
                  </label>
                </div>
                <div class="left-class form-custom-select-container">
                  <select id="txtCollaboratore" name="txtCollaboratore">
                    <option value="">Select Collaboratore</option>
                    <?php
                      if( $collaboratore )
                      {
                        foreach ( $collaboratore as $data )
                        {
                    ?>
                        <option value="<?php echo $data['collaboratore'];?>"><?php echo $data['collaboratore'];?></option>
                    <?php
                        }
                      }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-data grid_4">
                <div class="left-class">
                  <label for="txtAccompagnatore" style="width: 115px;">
                    <strong>Accompagnatore</strong>
                  </label>
                </div>
                <div class="left-class form-custom-select-container">
                  <select id="txtAccompagnatore" name="txtAccompagnatore">
                    <option value="">Select Accompagnatore</option>
                  </select>
                </div>
              </div>

              <div class="form-data grid_12" >
                <div style="float:right;padding-top: 15px;">
                  <input id="btnReport" type="submit" value="Report" style="margin-left: 10px">
                </div>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

</div>
<script>
  var SITE_PATH = "<?php echo base_url();?>index.php/";
  $(document).ready(function() {
    $('form').removeClass('no-box');
    $( "li#mnuwebservice" ).addClass("current");
    $( "li#mnuwebservice a" ).addClass("open");
    $( "li#mnuwebservice ul.sub" ).css('display','block');
    $( "li#mnuwebservice ul.sub li#mnuwebservice_3" ).addClass("current");

    $( "body" ).on( "change", "#txtCollaboratore", function() {
      var txtCollaboratore = $(this).val();
      $.post( SITE_PATH + "webservice/getAccompagnatore",{'txtCollaboratore':txtCollaboratore}, function( data ) {
        $("#txtAccompagnatore").html(data);
        $("#txtAccompagnatore").trigger("liszt:updated");
      });
    });

  });

  function validate(){
    var txtAccompagnatore = $("#txtAccompagnatore").val();
    var txtCollaboratore = $("#txtCollaboratore").val();

    if( txtAccompagnatore != '' && txtCollaboratore != '') {
      return true;
    } else {
      alert("Please select collaboratore and accompagnatore to search");
      return false;
    }
  }

</script>
<?php $this->load->view('plused_footer'); ?>

  <section class="content">
      <div class="row">
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo LTE;?>dist/img/avatar5.png" alt="<?php echo $this->session->userdata('mainfirstname'); ?> <?php echo $this->session->userdata('mainfamilyname') ?>">

              <h3 class="profile-username text-center"><?php echo $this->session->userdata('mainfirstname'); ?> <?php echo $this->session->userdata('mainfamilyname') ?></h3>

              <p class="text-muted text-center"><?php echo ($this->session->userdata('ruolo') == "Students" ? "Student" : $this->session->userdata('ruolo')); ?></p>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-9">

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Personal Details</h3>
            </div>
            <!-- /.box-header -->
            <div class="table-responsive">
                <table class="table">
                <tbody><tr>
                    <th style="width:25%">Name:</th>
                    <td><?php echo $this->session->userdata('mainfirstname'); ?> <?php echo $this->session->userdata('mainfamilyname'); ?></td>
                </tr>
                <tr>
                    <th>UUID:</th>
                    <td><?php echo $this->session->userdata('uuid'); ?></td>
                </tr>
                <tr>
                    <th>Date of birth:</th>
                    <td><?php echo date("d/m/Y",strtotime($this->session->userdata('pax_dob')));?></td>
                </tr>
                </tbody>
                </table>
        </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
    </div>
    </section>
    
<script>
    $(function () {
        // your code
    });
    
    
</script>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php 
        if(isset($pageHeader)){
            echo (!empty($pageHeader) ? $pageHeader : "");
        }
        ?>
        <small>
            <?php 
            if(isset($optionalDescription)){
                echo (!empty($optionalDescription) ? $optionalDescription : "");
            }
            ?>
        </small>
      </h1>
      <ol class="breadcrumb">
        <li><a class="hit-dashboard" href="javascript:void(0);"><i class="fa fa-dashboard"></i></li>
        <li><a href="javascript:void(0);"> <?php echo (isset($breadcrumb1) ? $breadcrumb1 : "Level");  ?> </a></li>
        <?php echo !empty($breadcrumb2) ? '<li class="active">'.  $breadcrumb2. '</li>' : ''; ?>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->
      <?php 
        if(isset($content_view))
            $this->load->view($content_view);
      ?>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
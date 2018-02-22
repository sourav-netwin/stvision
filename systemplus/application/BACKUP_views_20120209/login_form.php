<?php $this->load->view('admin_header');?>
<?php $this->load->view('admin_menu_left');?>
   <section id="main" class="column">
       <div id="container">
           <article class="module width_full">
                <h1>Box login</h1>
       
      <div class="module_content">
        <?php
                echo form_open('gestione_centri/dati_ok');
                echo form_input('username', 'Username');
                echo form_password('password', '');
                echo form_submit('submit', 'Login');
        ?>
        <!-- Controlli con relativi messaggi -->


        <!-- Se fai logout -->
         <?php
            if(isset($logout)){;
         ?>
            <h4 class="alert_logout"><?php if(isset($logout)) echo $logout;?></h4>
                
        <?php  } ?>


       <!--  No autorizzato ad accedere -->
        <?php
            if(isset($permits)){;
        ?>
            <h4 class="alert_error"><?php if(isset($permits)) echo $permits;?></h4>
        <?php  } ?>

        <!-- Errore nell'inserimento password -->

        <?php
            if   (isset($error)){;
        ?>
            <h4 class="alert_error"><?php if(isset($error)) echo $error;?></h4>
       <?php } ?>
          
            </div>
       </div>
</section>

<?php $this->load->view('admin_footer');?>

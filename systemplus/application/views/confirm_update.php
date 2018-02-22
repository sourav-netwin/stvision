<?php $this->load->view('admin_header');?>
<?php $this->load->view('admin_menu_left');?>
  <section id="main" class="column">
                <h4 class="alert_success">The system has uptaded the booking</h4>
                
        <div id="footer">
            <ul>
                <li><a href ="<?php echo base_url(); ?>index.php/gestione_centri" >Booking form</a></li>
            </ul>
            <ul>
                <li><a href ="<?php echo base_url(); ?>index.php/gestione_centri/presearch" >Booking review</a></li>
            </ul>
        </div>
        <div class="spacer"></div>
</section>


<?php $this->load->view('admin_footer');?>

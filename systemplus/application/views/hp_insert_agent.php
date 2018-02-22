<?php $this->load->view('admin_header');?>
<?php $this->load->view('admin_menu_left');?>
<section id="main" class="column">
        <div id="container">
          <article class="module width_full">
	<header><h3>Add</h3></header>
       <!-- Form per inserire nuovi agenti -->        
                        
       <form name="insert_agent"  action="<?php echo base_url(); ?>index.php/Gestione_centri/add_agent"  method="post" >
	<div class="module_content">
           <?php echo $this->validation->error_string; ?> 
           <fieldset><legend>New Agent</legend>
                <label>Agent's name</label>
                    <input type="text" name="agent" value="" />
           <div class="submit_link"><input type="submit" class="alt_btn" name="inserisci" value="insert" /></div>
           </fieldset>
            </div>
       </form>
            <div id="cerca">
                <ul><li><a href="<?php echo base_url(); ?>index.php/gestione_centri/presearch" class="text">Booking review</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/gestione_centri/list_confirm" class="text">Trasfert Status</a></li>
                    <li>
                        <?php 
                            if(isset($logout))
                        ?>
                        <a href="<?php echo base_url(); ?>index.php/gestione_centri/logout" class="text">Logout</a>
                    </li>
                </ul>
                
            </div>

</section>
       



   <?php $this->load->view('admin_footer');?>
<?php $this->load->view('admin_header');?>
<?php $this->load->view('admin_menu_left');?>
  <section id="main" class="column">

      <div id="container">
          <article class="module width_full">
			<header><h3>Booking review</h3></header>
               
       <!-- Ricerca per centro -->                  
	<form action="<?php echo base_url(); ?>index.php/gestione_centri/search" method="post" >
            <div class="module_content">
		<fieldset>
		<legend>Center</legend>
		<label>Select date</label>
		<select name="mese">
			<option value = 'gen' >January</option>
			<option value = 'feb' >Febraury</option>
			<option value = 'mar' >March</option>
			<option value = 'apr' >April</option>
			<option value = 'mag' >May</option>
			<option value = 'giu' >June</option>
			<option value = 'lug' >July</option>
			<option value = 'ago' >August</option>
			<option value = 'set' >September</option>
			<option value = 'ott' >October</option>
			<option value = 'nov' >November</option>
			<option value = 'dic' >December</option>
		</select>
		<label>Select destination</label>
		<select name="centro">
                    <?php

                         if (count($centri)){
                            foreach($centri as $key=>$item): ?>
                             <option value="<?=$item['id'];?>"><?=$item['nome_centri'];?></option>
                        <? endforeach;
                         }
                        ?> 
		</select>
		<div class="submit_link">
			<input type="submit" class="alt_btn" name="inserisci" value="search" />
		</div>
		</fieldset>
             </div>
	</form>
                        
           <!-- Ricerca per agente -->     
        	<form action="<?php echo base_url(); ?>index.php/gestione_centri/search_agency" method="post" >
            <div class="module_content">
		<fieldset>
		<label>Select Agency</label>
		<select name="agency">
                        <?php

                         if (count($agency)){
                            foreach($agency as $key=>$item): ?>
                             <option value="<?=$item['id'];?>"><?=$item['name'];?></option>
                        <? endforeach;
                         }
                        ?>
		</select>
		<div class="submit_link">
			<input type="submit" class="alt_btn" name="inserisci" value="search" />
		</div>
		</fieldset>
             </div>
	</form>   
	<div id="cerca">
		<ul>
                    <li><a href="<?php echo base_url(); ?>index.php/gestione_centri" class="text">Booking form</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/gestione_centri/list_confirm" class="text">Trasfert Status</a></li>
                    <li>
                        <?php 
                            if(isset($logout))
                        ?>
                        <a href="<?php echo base_url(); ?>index.php/gestione_centri/logout" class="text">Logout</a>
                    </li>
                </ul>
	</div>
     <div class="spacer"></div>
     </div>
   </section>
<?php $this->load->view('admin_footer');?>


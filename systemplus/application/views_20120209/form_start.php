<?php $this->load->view('admin_header');?>
<?php $this->load->view('admin_menu_left');?>
<section id="main" class="column">
        <div id="container">
          <article class="module width_full">
			<header><h3>Booking form</h3></header>
       <form name="formData"  action="<?php echo base_url(); ?>index.php/gestione_centri"  method="post" >
	<div class="module_content">
            
           <fieldset><legend>booking center</legend>
                <label>Total number of students</label>
                    <input type="text" name="totpax" value="<?php echo $this->validation->totpax; ?>" />
                <label>Destination</label>
                    <select name="scuole">
                       <?php

                         if (count($centri)){
                            foreach($centri as $key=>$item): ?>
                             <option value="<?=$item['id'];?>"><?=$item['nome_centri'];?></option>
                        <? endforeach;
                         }
                        ?>
                    </select>
                <label>Agency</label>
                    <select name="agency">
                       <?php

                         if (count($agency)){
                            foreach($agency as $key=>$item): ?>
                             <option value="<?=$item['id'];?>"><?=$item['name'];?></option>
                        <? endforeach;
                         }
                        ?>
                    </select>
                 <label>Group Leader</label>
                    <input type="text" name="group_leader" value="<?php echo $this->validation->group_leader; ?>"/>
                <label>Number group leader</label>
                    <select name="group">
                       <?php

                         if (count($group)){
                            foreach($group as $key=>$item): ?>
                             <option value="<?=$item['id'];?>"><?=$item['n_group'];?></option>
                        <? endforeach;
                         }
                        ?>
                    </select>
            </fieldset>

            <fieldset><legend>booking IN</legend>
              
                <?php echo $this->validation->error_string; ?>

            <label for="date_start">Arrival date</label>
                 <a href="javascript:show_calendar('document.formData.date_start', document.formData.date_start.value);"><input  type="text" name="date_start" value="<?php echo $this->validation->date_start; ?>" /></a>
            <label for="arrival_time">Arrival time</label>
                 <input type="text" name="arrival_time" value="<?php echo $this->validation->arrival_time; ?>"/>
            <label>Arrival airport</label>
                <select name="aereo_in">
                       <?php

                         if (count($aereo_in)){
                            foreach($aereo_in as $key=>$item): ?>
                             <option value="<?=$item['id'];?>"><?=$item['name_airport'];?></option>
                        <? endforeach;
                         }
                        ?>
                    </select>
            <label for="arrival_flight">Arrival flight</label>
                 <input type="text" name="arrival_flight" value="<?php echo $this->validation->arrival_flight; ?>"/>
             </fieldset>

            
            <fieldset><legend>booking OUT </legend>
            <label for="date_end">Departure date</label>
                <a href="javascript:show_calendar('document.formData.date_end', document.formData.date_end.value);"><input type="text" name="date_end" value="<?php echo $this->validation->date_end; ?>"/></a>
            <label for="departure_time">Departure time</label>
                 <input type="text" name="departure_time" value="<?php echo $this->validation->departure_time; ?>"/>
            <label>Departure airport</label>
                <select name="aereo_out">
                       <?php

                         if (count($aereo_out)){
                            foreach($aereo_out as $key=>$item): ?>
                             <option value="<?=$item['id'];?>"><?=$item['name_airport'];?></option>
                        <? endforeach;
                         }
                        ?>
                  </select>           
            <label for="departure_flight">Departure flight</label>
                 <input type="text" name="departure_flight" value="<?php echo $this->validation->departure_flight; ?>"/>
            <div class="submit_link"><input type="submit" class="alt_btn" name="inserisci" value="submit" /></div>

          </fieldset>
        </div>
        </form>
        </div>
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
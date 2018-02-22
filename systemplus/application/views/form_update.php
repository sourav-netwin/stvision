<?php $this->load->view('admin_header');?>
<?php $this->load->view('admin_menu_left');?>
<section id="main" class="column">
        <div id="container">
          <article class="module width_full">
	    <header><h3>Booking form update</h3></header>

                      <?php

                            foreach($up as $key=>$item):
                            if(count($up)){

                    ?>
            
       <form name="upData"  action="<?php echo base_url();?>index.php/Gestione_centri/update/<?php echo $item ['id']; ?>"  method="post" >
	<div class="module_content">

           <fieldset><legend>booking center</legend>
                <label>Total number of students</label>
                    <input type="text" name="totpax" value="<?php echo $item ['tot_pax']; ?>" />
                        <?php
                            }
                         endforeach;
                    ?>

                <label>Destination</label>
                    <select name="scuole">
                      <?php

                         if (count($centri)){
                            foreach($centri as $key=>$sel):
                            if($sel['id']== $item['id_centro']){
                             echo "<option value=\"".$sel['id']."\" selected=\"selected\">".$sel['nome_centri']."</option>";

                                }
                            ?>
                             <option value="<?=$sel['id'];?>"><?=$sel['nome_centri'];?></option>
                        <? endforeach;
                         }
                        ?>
                    </select>

                <label>Agency</label>
                    <select name="agency">
                       <?php
                         if (count($agency)){
                            foreach($agency as $key=>$sel):
                            if($sel['id']== $item['id_agency']){
                                 echo "<option value=\"".$sel['id']."\" selected=\"selected\">".$sel['name']."</option>";

                                }
                            ?>
                             <option value="<?=$sel['id'];?>"><?=$sel['name'];?></option>
                        <? endforeach;
                         }
                        ?>
                    </select>
                    <?php
                        foreach($up as $key=>$item):
                        if(count($up)){
                    ?>

                 <label>Group Leader</label>
                    <input type="text" name="group_leader" value="<?php echo $item ['gruppo']; ?>"/>
                                            <?php
                            }
                         endforeach;
                    ?>

                <label>Number group leader</label>
                    <select name="group">
                         <?php

                         if (count($group)){
                            foreach($group as $key=>$sel):
                                if($sel['id']== $item['id_gruppo']){
                                 echo "<option value=\"".$sel['id']."\" selected=\"selected\">".$sel['n_group']."</option>";

                                }
                            ?>
                             <option value="<?=$sel['id'];?>"><?=$sel['n_group'];?></option>
                        <? endforeach;
                         }
                        ?>
                    </select>

            </fieldset>

            <fieldset><legend>booking IN</legend>
              
                <?php

                    foreach($up as $key=>$item):
                    if(count($up)){
                    ?>
            <label for="date_start">Arrival date</label>
                 <a href="javascript:show_calendar('document.upData.date_start', document.upData.date_start.value);"><input  type="text" name="date_start" value="<?php echo $item ['data_inizio']; ?>" /></a>
            <label for="arrival_time">Arrival time</label>
                 <input type="text" name="arrival_time" value="<?php echo $item ['ore_arrivo']; ?>"/>
                    <?php
                            }
                         endforeach;
                    ?>
             
                 
            <label>Arrival airport</label>
                 <select name="aereo_in">
                         <?php

                         if (count($aereo_in)){
                            foreach($aereo_in as $key=>$sel):                                
                                if($sel['id']== $item['id_airport_arrivo']){
                                 echo "<option value=\"".$sel['id']."\" selected=\"selected\">".$sel['name_airport']."</option>";

                                }
                            ?>
                             <option value="<?=$sel['id'];?>"><?=$sel['name_airport'];?></option>
                        <? endforeach;
                         }
                        ?>
                    </select>
            
            
                            <?php

                    foreach($up as $key=>$item):
                    if(count($up)){
                    ?>
            
            <label for="arrival_flight">Arrival flight</label>
                 <input type="text" name="arrival_flight" value="<?php echo $item ['n_volo_arrivo']; ?>"/>
             </fieldset>

            
            <fieldset><legend>booking OUT </legend>
            <label for="date_end">Departure date</label>
                <a href="javascript:show_calendar('document.upData.date_end', document.upData.date_end.value);"><input type="text" name="date_end" value="<?php echo $item ['data_fine']; ?>"/></a>
            <label for="departure_time">Departure time</label>
                 <input type="text" name="departure_time" value="<?php echo $item ['ore_partenza'];  ?>"/>
                    
                    <?php
                            }
                         endforeach;
                    ?>
            <label>Departure airport</label>

                 <select name="aereo_out">
                         <?php

                         if (count($aereo_out)){
                            foreach($aereo_out as $key=>$sel):                                
                                if($sel['id']== $item['id_airport_partenza']){
                                 echo "<option value=\"".$sel['id']."\" selected=\"selected\">".$sel['name_airport']."</option>";

                                }
                            ?>
                             <option value="<?=$sel['id'];?>"><?=$sel['name_airport'];?></option>
                        <? endforeach;
                         }
                        ?>
                    </select>
                                        <?php

                    foreach($up as $key=>$item):
                    if(count($up)){
                    ?>
            <label for="departure_flight">Departure flight</label>
                 <input type="text" name="departure_flight" value="<?php echo $item ['n_volo_partenza']; ?>"/>
            <div class="submit_link"><input type="submit" class="alt_btn" name="up_date" value="update" /></div>

          </fieldset>
        </div>
        </form>
        </div>
            <div id="cerca">
                <ul><li><a href="<?php echo base_url(); ?>index.php/gestione_centri/presearch" class="text">Booking review</a></li>
                    <li>
                        <?php 
                            if(isset($logout))
                        ?>
                        <a href="<?php echo base_url(); ?>index.php/gestione_centri/logout" class="text">Logout</a>
                    </li>
                </ul>
                
            </div>

</section>
                        <?php
                            }
                         endforeach;
                    ?>
<?php $this->load->view('admin_footer');?>
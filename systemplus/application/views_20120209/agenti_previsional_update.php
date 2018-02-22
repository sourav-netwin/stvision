<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<title><?php echo $title?></title>    
<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/agenti.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery-ui_1.8.16.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery-ui_1.8.css" media="screen" />      
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ts_picker_en.js"></script>
<script type="text/javascript">

 $(document).ready(function(){
    
    $("#accomodation_standard").hide();
    $("#accomodation_homestay").hide();
    $("#accomodation_ensuite").hide(); 
    
    $("#selectionresult").hide();
    
    $("#dialog_in").hide();
    $("#dialog_out").hide();
    
    $("#gl_def").hide();

     // Funzione retrive per accomodation //
    $("#centri").change( function() {
        $("#accomodation").html('searching ...');
        $.ajax({
            type: "POST",
            data: "data=" + $(this).val(),
            url: "<?php echo site_url('agenti/retrieve_accomodation'); ?>",
            success: function(msg){
                if (msg != ''){                   
                     $("#accomodation").html(msg).show();
                     $("#update").hide();
                }
                else{
                    $("#accomodation").html('<em>No item result</em>');
                }
            }
        });
    });
    
       // Funzione retrive // 
   
    $("#selection").change( function() {
        $("#selectionresult").hide();
        $("#result").html('cerco ...');
        $.ajax({
            type: "POST",
            data: "data=" + $(this).val(),
            url: "<?php echo site_url('agenti/retrieve'); ?>",
            success: function(msg){
                
                if (msg != ''){
                    $("#selectionresult").html(msg).show();
                    $("#result").html('');
                    $("#gl_def").show();
                }
                else{
                    $("#result").html('<em>No item result</em>');
                }
            }
        });
    }); 
 
 //funzione calendario//
 	$(function() {
		$.datepicker.setDefaults($.datepicker.regional['en']);
          $("input.data").datepicker({minDate:"today"});
            $("input#data_arrivo").change(function()
                    {
                    var valore_data = $(this).val();
                    if(valore_data)$("input#data_partenza").datepicker("option","minDate",valore_data);
                }
            );

	});
 
      //Funzione info time //
        
        $("#opn_in").click(function(){
            $("#dialog_in").dialog({ height: 175 },{ resizable: false });
        }); 
        
       $("#opn_out").click(function(){
            $("#dialog_out").dialog({ height: 175 },{ resizable: false });
        });  
 });

</script>
</head>
<body>

<img src="<?php echo base_url(); ?>images/agenti_header.png" style="margin:10px 0 0 0">
<div id="container" >
	<div id="bigbox" >	
	<?php $this->load->view('agenti_tab');?>
		<div id="left" >
			<div class="left_menu" >
				<?php $this->load->view('agenti_left_enrol');?>
			</div>
                    <img src="<?php echo base_url(); ?>images/agent_news_end.png" >
		</div>
		
                <?php 

                    //Controllo limitato all'operatore 

                    if($attivi==false){

                    echo "<div id=\"container\" > ";   
                            echo "<div id=\"middle\" style=\"float:left;\" >";  

                                echo "<a href=\"".base_url()."index.php/agenti/logged\">";
                                    echo "Back at Home";
                                echo "</a>";

                            echo "</div>"; 
                    echo "</div>";        
                    }else{  
                ?>            

		<div id="middle" >
                      <?php

                            foreach($up as $key=>$item){
                            if(count($up)){

                    ?>
       <form name="pippa"  action="<?php echo base_url();?>index.php/agenti/update/<?php echo $item ['id']; ?>"  method="post" >
	<div class="module_content">
           <fieldset>
               <h1>booking form update </h1><br/>
                <label>Total number of students</label>
                    <input type="text" name="totpax" value="<?php echo $item ['tot_pax']; ?>" />
                        <?php
                            }
                           }
                    ?>
                <label>Destination</label>
                    <select name="scuole" id="centri">
                      <?php

                         if (count($centri)){
                            foreach($centri as $key=>$sel){
                            if($sel['nome_centri']== $item['id_centro']){
                             echo "<option value=\"".$sel['nome_centri']."\" selected=\"selected\">".$sel['nome_centri']."</option>";
                                }
                            ?>
                             <option value="<?php echo $sel['nome_centri'];?>"><?php echo $sel['nome_centri'];?></option>
                        <?php
                            }
                         }
                        ?>
                    </select>
                            
                      <div id="accomodation">&nbsp;</div>
                            
                            <div align="left" id="update">
                                <input type="radio" checked="checked" name="choose" value="<?php echo $item ['accomodation']; ?>" >
                                <?php echo strtoupper($item ['accomodation']);?>
                            </div>
                                        <br>
                                            
              <?php 
                if($user=="admin"){
               ?>
    <!-- RETRIVE --> 
    
        <label>Agency</label>
               <select name="agency" id="selection">                              

                        <?php
                        if (count($agency)){
                            foreach ($agency as $key=>$sel){
                                  if($sel['id']== $item['id_agency']){
                                    echo "<option value=\"".$sel['id']."\" selected=\"selected\">".$sel['login']."</option>"; 
                                   } 
                         ?>
                                <option value="<?php echo $sel['id'];?>"><?php echo $sel['login'];?></option>
                        <?php 
                                }
                            }
                        ?>   
                        </select>

                <label id="gl_def">Group</label>             
                            <br> 
   <!-- FINE RETRIVE -->          
<?php 
                }else{
                    ?>
                
                <label>Agent</label> 

                            <select name="agency" id="selection">                              

                        <?php
                        
                                    echo "<option value=\"".$id."\" selected=\"selected\">".$business."</option>"; 
                                   
                         ?>
                                <option value="<?php echo $id;?>"><?php echo $business;?></option>
        
                        </select>
          <!-- id="gl_def" -->
          
                <label id="gl_def">Group leader</label> 

                            <select name="gl" id="selectionresult">
                            <option value="<?php echo $item ['id_nome_gruppo']; ?>"></option>	
                            </select>
            <?php
                }
            ?>
 <?php
                        foreach($up as $key=>$item){
                        if(count($up)){
                    ?>

                <label>Number group leader</label>
                    <select name="n_group">
                        <option value="<?php echo $item['n_gruppo'];?>"><?php echo $item['n_gruppo'];?></option>
                            <option value = '1' >1</option>
                            <option value = '2' >2</option>
                            <option value = '3' >3</option>
                            <option value = '4' >4</option>
                            <option value = '5' >5</option>
                            <option value = '6' >6</option>
                            <option value = '7' >7</option>
                            <option value = '8' >8</option>
                            <option value = '9' >9</option>
                            <option value = '10' >10</option>
                    </select>
            </fieldset>
                   
            <fieldset>
                <h1>booking IN </h1><br/>
            <label for="date_start">Arrival date</label>
            <div>
                <input type="text" name="date_start" class="data" id="data_arrivo" value="<?php echo $item ['data_inizio']; ?>"/>
            </div>  
            <label for="arrival_time">Arrival time</label>
                 <input  class="no_clear" type="text" name="arrival_time" value="<?php echo $item ['ore_arrivo']; ?>"/>
                       <div class="faq">
                             <img src="<?php echo base_url();?>images/faq.png" alt="alert" id="opn_in" >
                                     <div id="dialog_in" title="Important">
                                         <p class="box_red">Wrong insert:</p>
                                         <div class="box_txt_red">ex. ("10:00 pm/am"  -  "10,00")</div>

                                         <p class="box_green">Correct insert:</p>
                                         <div class="box_txt_green">ex. ("10:00")</div>
                                     </div>    
                       </div>
                    <?php
                            }
                        }
                    ?>   
            <label>Arrival airport</label>
                 <select name="aereo_in">
                     <option value="<?php echo $item['id_airport_arrivo'];?>"><?php echo $item['id_airport_arrivo'];?></option>
                         <?php

                         if (count($aereo_in)){
                            foreach($aereo_in as $key=>$sel){                              
                                if($sel['id']== $item['id_airport_arrivo']){
                                 echo "<option value=\"".$sel['id']."\" selected=\"selected\">".$sel['name_airport']."</option>";

                                }
                            ?>
                             <option value="<?php echo $sel['name_airport'];?>"><?php echo $sel['name_airport'];?></option>
                        <?php 
                            }
                         }
                        ?>
                    </select>
            
            
                            <?php

                    foreach($up as $key=>$item){
                    if(count($up)){
                    ?>
            
            <label for="arrival_flight">Arrival flight</label>
                 <input type="text" name="arrival_flight" value="<?php echo $item ['n_volo_arrivo']; ?>"/>
            <!--label>Arrival Service</label>
                <select name="service_in">
                 
                    <option value="<//?php echo $item['arrival_service'];?>"><//?php echo $item['arrival_service'];?></option> 
                    <option value = 'Breakfast' >Breakfast</option>
                    <option value = 'Lunch' >Lunch</option>
                    <option value = 'Packet Lunch' >Packet Lunch</option>
                    <option value = 'Dinner' >Dinner</option>
                    <option value = 'Packet Dinner' >Packet Dinner</option>
                    <option value = 'None' >None</option>
                 </select-->       
             </fieldset>
            <fieldset>
                <h1>booking OUT </h1><br/>
            <label>Departure date</label>
            <div>
                <input type="text" name="date_end" class="data" id="data_partenza" value="<?php echo $item ['data_fine']; ?>"/>
            </div>             
            <label for="departure_time">Departure time</label>
                        <input  class="no_clear" type="text" name="departure_time" value="<?php echo $item ['ore_partenza']; ?>"/>
                       <div class="faq">
                             <img src="<?php echo base_url();?>images/faq.png" alt="alert" id="opn_out" >
                                     <div id="dialog_out" title="Important">
                                         <p class="box_red">Wrong insert:</p>
                                         <div class="box_txt_red">ex. ("10:00 pm/am"  -  "10,00")</div>

                                         <p class="box_green">Correct insert:</p>
                                         <div class="box_txt_green">ex. ("10:00")</div>
                                     </div>    
                       </div>
                    
                    <?php
                            }
                    }
                    ?>
                 <label>Departure airport</label>
                    <select name="aereo_out">
                     <option value="<?php echo $item['id_airport_partenza'];?>"><?php echo $item['id_airport_partenza'];?></option>
                         <?php

                         if (count($aereo_out)){
                            foreach($aereo_out as $key=>$sel){                              
                                if($sel['id']== $item['id_airport_partenza']){
                                 echo "<option value=\"".$sel['id']."\" selected=\"selected\">".$sel['name_airport_back']."</option>";

                                }
                            ?>
                            <option value="<?php echo $sel['name_airport_back'];?>"><?php echo $sel['name_airport_back'];?></option>
                        <?php 
                            }
                         }
                        ?>
                    </select>
                 <?php
                    foreach($up as $key=>$item){
                        if(count($up)){
                    ?>
                 <label for="departure_flight">Departure flight</label>
                 <input type="text" name="departure_flight" value="<?php echo $item ['n_volo_partenza']; ?>"/>
                 <!--label>Departure Service</label>
                <select name="service_out">                 
                    <option value="<//?php echo $item['partenza_service'];?>"><//?php echo $item['partenza_service'];?></option> 
                    <option value = 'Breakfast' >Breakfast</option>
                    <option value = 'Lunch' >Lunch</option>
                    <option value = 'Packet Lunch' >Packet Lunch</option>
                    <option value = 'Dinner' >Dinner</option>
                    <option value = 'Packet Dinner' >Packet Dinner</option>
                    <option value = 'None' >None</option>
                </select--> 
               <script type="text/javascript">
                function show_alert()
                    {
                    alert("Your booking is being modified. Please remember to check the coach capacity for the transfers and optional excursions.");
                    }
          </script>    

          </fieldset>
             <div class="submit_link"><input type="submit" class="alt_btn" name="up_date" value="update" onclick="show_alert()" /></div>
        </div>  
                 
        </form>
                    
		</div>
	                        <?php
                            }
                    }
                    ?>	

		<?php $this->load->view('agenti_footer');?>

</div>
    <?php   
        }
      ?>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<title><?php echo $title?></title>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/agenti.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery-ui_1.8.css" media="screen" />      
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ts_picker_en.js"></script>

<!-- Script -->
<script type="text/javascript">

$(document).ready(function(){
    
    $("#accomodation_standard").hide();
    $("#accomodation_homestay").hide();
    $("#accomodation_ensuite").hide(); 
    
    $("#selectionresult").hide();
    
    $("#dialog_in").hide();
    $("#dialog_out").hide();

     
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
          $( "input.data" ).datepicker({ minDate:"today"});
          
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
		<div id="left">
			<div class="left_menu" >
				<?php $this->load->view('agenti_left_enrol');?>
			</div>
		<img src="<?php echo base_url(); ?>images/agent_news_end.png" >	
		</div>
            
                <!--?php 

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
                ?-->

		<div id="middle" style="float:left;" >
			<form name="pippa"  action="<?php echo base_url(); ?>index.php/agenti/enrol"  method="post" >
			<?php echo $this->validation->error_string; ?>     
                       
			<fieldset>
			<h1>booking form </h1><br/>
                <label>Total number of students</label>
                    <input type="text" name="totpax" value="<?php echo $this->validation->totpax; ?>" />
                <label>Destination</label>
                    <select name="scuole" id="centri">
                        <option selected=" ">None</option>
                       <?php
                         if (count($centri)){
                            foreach($centri as $key=>$item){ ?>
                        
                            <option value="<?php echo $item['nome_centri'];?>"><?php echo $item['nome_centri'];?></option> 
                        <?php 
                            }
                         }
                        ?>
                    </select>
                        <div id="accomodation">&nbsp;</div>
                
		   <label>Weeks</label>
			<select name="weeks" id="weeks">
				<option value="1">1 week</options>
				<option value="2">2 weeks</options>
				<option value="3">3 weeks</options>
				<option value="4">4 weeks</options>
			</select>
                 <label>Agent</label>
                    <input  type="text" readonly name="agent" value="<?php echo $business; ?>" />
                    <input class="left" type="hidden" name="agency" value="<?php echo $id; ?>" />
 
                    
            <label>Group leader name</label>
            
            <input type="text" name="group" value="" />

             
            <label>Number group leader</label>
                    <select name="n_group">
                    <option SELECTED VALUE=" ">None</option>
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
			<h1>Arrival </h1>     
            <label>Arrival date</label>
               <div>
                    <input  type="text" name="date_start" class="data" id="data_arrivo" value="<?php echo $this->validation->date_start; ?>" />
               </div>          
            <label for="arrival_time">Arrival time</label>
            <input  class="no_clear" type="text" name="arrival_time" value=""/>
                       <div class="faq">
                             <img src="<?php echo base_url();?>images/faq.png" alt="alert" id="opn_in" >
                                     <div id="dialog_in" title="Important">
                                         <p class="box_red">Wrong insert:</p>
                                         <div class="box_txt_red">ex. ("10:00 pm/am"  -  "10,00")</div>

                                         <p class="box_green">Corret insert:</p>
                                         <div class="box_txt_green">ex. ("10:00")</div>
                                     </div>    
                       </div>
            <label>Arrival airport</label>
                <select name="aereo_in">
                    <option SELECTED VALUE="None">None</option>
                       <?php

                         if (count($aereo_in)){
                            foreach($aereo_in as $key=>$item): ?>
                             <option value="<?php echo $item['name_airport'];?>"><?php echo $item['name_airport'];?></option>
                        <?php endforeach;
                         }
                        ?>
                    </select>
            <label for="arrival_flight">Flight details</label>
                 <input type="text" name="arrival_flight" value=""/>
            <!--label>Arrival Service</label>
                <select name="service_in">
                    <option SELECTED VALUE="None">None</option>
                    <option value = 'Breakfast' >Breakfast</option>
                    <option value = 'Lunch' >Lunch</option>
                    <option value = 'Packet Lunch' >Packed Lunch</option>
                    <option value = 'Dinner' >Dinner</option>
                    <option value = 'Packet Dinner' >Packed Dinner</option>
                  </select-->  
            </fieldset>

           
            <fieldset>
			 <h1>Departure</h1> 
            <label>Departure date</label>
               <div>
                    <input  type="text" name="date_end" class="data"  id="data_partenza" value="<?php echo $this->validation->date_end; ?>" />
               </div> 
            <label for="departure_time">Departure time</label>
                        <input  class="no_clear" type="text" name="departure_time" value=""/>
                       <div class="faq">
                             <img src="<?php echo base_url();?>images/faq.png" alt="alert" id="opn_out" >
                                     <div id="dialog_out" title="Important">
                                         <p class="box_red">Wrong insert:</p>
                                         <div class="box_txt_red">ex. ("10:00 pm/am"  -  "10,00")</div>

                                         <p class="box_green">Correct insert:</p>
                                         <div class="box_txt_green">ex. ("10:00")</div>
                                     </div>    
                       </div>
            <label>Departure airport</label>
                <select name="aereo_out">
                    <option value="None">None</option>
                       <?php

                         if (count($aereo_out)){
                            foreach($aereo_out as $key=>$item): ?>
                             <option value="<?php echo $item['name_airport_back'];?>"><?php echo $item['name_airport_back'];?></option>
                        <?php endforeach;
                         }
                        ?>
                  </select>           
            <label for="departure_flight">Flight details</label>
                 <input type="text" name="departure_flight" value=""/>
           <!--label>Departure Service</label>
                <select name="service_out">
                    <option SELECTED VALUE="None">None</option>
                    <option value = 'Breakfast' >Breakfast</option>
                    <option value = 'Lunch' >Lunch</option>
                    <option value = 'Packet Lunch' >Packed Lunch</option>
                    <option value = 'Dinner' >Dinner</option>
                    <option value = 'Packet Dinner' >Packed Dinner</option>
                    
                  </select-->  
			</fieldset>
                        <div class="submit_link"><input type="submit" class="alt_btn" name="inserisci" value="submit" /></div>
		 </form>
                    
		</div>
	</div>
		

		<?php $this->load->view('agenti_footer');?>

</div>
<!--?php   
    }
  ?-->
</body>
</html>
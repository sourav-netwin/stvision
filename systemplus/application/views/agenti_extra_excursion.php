<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<title><?php echo $title?></title>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/agenti.css" media="screen" /> 
<style type="text/css">
<!--
form, label {
	padding:0;
	margin:0;
	color: #999;
	clear:both;
	text-align:left;;
}
select{
	display:block;
	clear:both;
}
-->
</style>
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
		<div id="middle" >
                    <div class="intestazione">
                        Extra excursion confirm
                    </div> 
                <br>
                   <table id="excursions">
                            <tr>
                                <th>Pratica</th>
                                <th>Centro</th>
                                <th>Agente</th>
                                <th>Gl</th>   
                                <th>Arrival</th>
                                <th>Departure</th>
                                <th>Tot pax</th>
                                <th>Tipo</th>
                                <th>Excursion</th>
                                <th>Price</th>
                            </tr>
                           <?php 
                                
                             echo  "<input type=\"hidden\" name=\"rand\" value=\"".$_POST['rand']."\">";
                            
                               foreach ($confirmed_excursions as $key=>$item){
                                     
                                   echo "<tr>";
                                        echo "<td>".$item['id_pratica']."</td>";
                                        echo "<td>".$item['centro']."</td>";
                                        echo "<td>".$business."</td>";
                                        echo "<td>".$item['gl']."</td>";
                                        echo "<td>".date('d-m-Y',strtotime($item['data_in']))."</td>";
                                        echo "<td>".date('d-m-Y',strtotime($item['data_out']))."</td>";
                                        echo "<td>".$item['tot_pax']."</td>";
                                        echo "<td>".$item['type']."</td>";
                                        echo "<td>".$item['excursion']."</td>";

                                        if($item['price_14']!= 0){
                                            echo "<td>&pound; ".ceil($item['price_14'])."</td>";
                                        }elseif($item['price_16']!= 0){
                                            echo "<td>&pound; ".ceil($item['price_16'])."</td>";
                                        }elseif($item['price_24']!=0){
                                            echo "<td>&pound; ".ceil($item['price_24'])."</td>";      
                                        }elseif($item['price_25']!=0){
                                            echo "<td>&pound; ".ceil($item['price_25'])."</td>";
                                        }elseif($item['price_28']!=0){
                                            echo "<td>&pound; ".ceil($item['price_28'])."</td>";
                                        }elseif($item['price_29']!=0){
                                            echo "<td>&pound; ".ceil($item['price_29'])."</td>";
                                        }elseif($item['price_33']!=0){
                                            echo "<td>&pound; ".ceil($item['price_33'])."</td>";
                                        }elseif($item['price_35']!=0){
                                            echo "<td>&pound; ".ceil($item['price_35'])."</td>";
                                        }elseif($item['price_38']!=0){
                                            echo "<td>&pound; ".ceil($item['price_38'])."</td>"; 
                                        }elseif($item['price_41']!=0){
                                            echo "<td>&pound; ".ceil($item['price_41'])."</td>";                                            
                                        }elseif($item['price_45']!=0){
                                            echo "<td>&pound; ".ceil($item['price_45'])."</td>";
                                        }elseif($item['price_49']!=0){
                                            echo "<td>&pound; ".ceil($item['price_49'])."</td>";
                                        }elseif($item['price_50']!=0){
                                            echo "<td>&pound; ".ceil($item['price_50'])."</td>";    
                                        }elseif($item['price_51']!=0){
                                            echo "<td>&pound; ".ceil($item['price_51'])."</td>";
                                        }elseif($item['price_53']!=0){
                                            echo "<td>&pound; ".ceil($item['price_53'])."</td>";
                                        }elseif($item['price_57']!=0){
                                            echo "<td>&pound; ".ceil($item['price_57'])."</td>";
                                        }elseif($item['price_70']!=0){
                                            echo "<td>&pound; ".ceil($item['price_70'])."</td>";
                                        }elseif($item['price_75']!=0){
                                            echo "<td>&pound; ".ceil($item['price_75'])."</td>";    
                                        }
                               }
                           ?>
                  </table>   
                    <br>
                    <form name="confirm_extra_excursion"  action="<?php echo base_url(); ?>index.php/agenti/confirm_extra_excursions"  method="post" >
                        <input type="hidden" name="rand" value="<?php echo $_POST['rand'];?>">
                        <input type="hidden" name="excursion" value="<?php echo $_POST['excursion'];?>">  
                      
                       <label class="dark_blue">Attraction: </label>
                        <p><?php echo $_POST['extra_ex']; ?></p>
                           <input type="hidden" name="extra_ex" value="<?php echo $_POST['extra_ex'];?>"> 
                            <br> 
                        <label class="dark_blue">Tipology: </label>
                        <p><?php echo $extra_excursions[0]['opzione']; ?></p>
                        <input type="hidden" name="opzione" value="<?php echo $extra_excursions[0]['opzione']; ?>">
                            <br>    
                        <label class="dark_blue">Price: </label>
                            <p><?php echo $extra_excursions[0]['price_plus_agent'];?>  &pound;</p>
                            <input type="hidden" name="price_plus_agent" value="<?php echo $extra_excursions[0]['price_plus_agent'];?>">
                            <br>
                         <label class="dark_blue">Address: </label>       
                            <p><?php echo $extra_excursions[0]['indirizzo'];?></p>
                            <input type="hidden" name="indirizzo" value="<?php echo $extra_excursions[0]['indirizzo'];?>">         

                      <div class="submit_link"><input id="button" type="submit" class="alt_btn" name="inserisci" value="confirm" /></div>   
                    </form>
        </div>
		<?php $this->load->view('agenti_footer');?>
</div>
</body>
</html>
<?php $this->load->view('admin_header');?>
<?php $this->load->view('admin_menu_left');?>
<section id="main" class="column">
        <div id="header">
            <h1>Review :</h1>
        </div>

             <div id="" class="tab_content">
            <table class="tablesorter">
                <tr>
                    <th>CENTER</th>
                    <th>AGENCY</th>
                    <th>N GL</th>
                    <th>GL</th>
                    <th>PAX</th>
                    <th>DATE IN</th>
                    <th>TRANSFER</th>
                    <th>ARRIVAL TIME</th>
                    <th>ARRIVAL AIRPORT</th>
                    <th>N° FLIGHT</th>
                    <th>ARRIVAL SERVICE</th>
                    <th>DATE OUT</th>
                    <th>TRANSFER</th>
                    <th>DEPARTURE TIME</th>
                    <th>DEPARTURE AIRPORT</th>
                    <th>N° FLIGHT</th>
                    <th>DEPARTURE SERVICE</th>
                    <th>MODIFY BOOK</th>
                </tr>


       <?php

          foreach($group as $key=>$item):
             if(count($group)){
        ?>
                <tr>
                    <td><?php echo $nomi_centri[0]['nome_centri']; ?></td>
                    <td><?php echo $nomi_agenzie[0]['name']; ?></td>
                    <td><?php echo $item ['id_gruppo']; ?></td>
                    <td><?php echo $item ['gruppo']; ?></td>
                    <td><?php echo $item ['tot_pax']; ?></td>
                    <td><?php echo $item ['data_inizio']; ?></td>
                    <td>
                        <?php
                      if($item ['confirm_in']== 'NO'){

                          echo "<a href=\"".base_url()."index.php/Gestione_centri/confirm_datain/".$item ['id']."\"  onClick=\"return confirm('Do you confim the transfer?');\">";
                          echo "<img src=\"".base_url()."images/not.jpg\" alt=\"check\"/>";
                          echo "</a>";  
                         }else{ 
                            echo "<img src= \"".base_url()."images/check.jpg\" alt=\"check\"/>";
                            }
                        ?>
                    </td>
                    <td><?php echo $item ['ore_arrivo']; ?></td>
                    <td><?php echo $nomi_airport_arrive[0]['name_airport']; ?></td>
                    <td><?php echo $item ['n_volo_arrivo']; ?></td>
                    <td>
                    <?php
                        if (strtotime($item ['ore_arrivo']) < strtotime('10:30:00')) {
                            echo 'LUNCH';
                            }elseif(strtotime($item ['ore_arrivo']) >= strtotime('12:00:00')&& strtotime($item ['ore_arrivo']) <= strtotime('19:30:00')){
                                echo 'DINNER';
                            }else {
                                echo 'NONE';
                            }
                    ?>
                    </td>

                    <td><?php echo $item ['data_fine']; ?></td>
                    <td>
                        <?php
                      if($item ['confirm_out']== 'NO'){

                          echo "<a href=\"".base_url()."index.php/Gestione_centri/confirm_dataout/".$item ['id']."\"  onClick=\"return confirm('Do you confim the transfer?');\">";
                          echo "<img src=\"".base_url()."images/not.jpg\" alt=\"check\"/>";
                          echo "</a>";  
                         }else{ 
                            echo "<img src= \"".base_url()."images/check.jpg\" alt=\"check\"/>";
                            }
                        ?>
                    </td>
                    <td><?php echo $item ['ore_partenza']; ?></td>
                    <td><?php echo $nomi_airport_departure[0]['name_airport']; ?></td>
                    <td><?php echo $item ['n_volo_partenza']; ?></td>
                    <td>
                        <?php

                        if (strtotime($item ['ore_partenza']) <= strtotime('11:00:00')&& strtotime($item ['ore_partenza']) > strtotime('08:00:00')) {
                            echo 'BREAKFAST';
                            }elseif(strtotime($item ['ore_partenza']) <= strtotime('16:00:00')&& strtotime($item ['ore_partenza']) > strtotime('11:00:00')){
                                echo 'LUNCH';
                            }elseif(strtotime($item ['ore_partenza']) >= strtotime('19:00:00')&& strtotime($item ['ore_partenza']) <= strtotime('20:00:00')){
                                echo 'DINNER';
                            }elseif(strtotime($item ['ore_partenza']) > strtotime('20:00:00')|| strtotime($item ['ore_partenza']) <= strtotime('08:00:00')){
                                echo 'NONE';
                            }else{
                                echo 'NONE';
                            }
                        ?>
                    </td>
                     <td>

                          <?php   
                               if($item ['confirm_in']== 'YES' || $item ['confirm_out']== 'YES' ){
                          ?>
                                <script type="text/javascript">
                                    function show_alert()
                                        {
                                        alert("Your booking beening modified please remember to view the bus capacity for the trasnfer");
                                        }
                                </script>       
                            <a href= "<?php echo base_url(); ?>index.php/Gestione_centri/take/<?php echo $item ['id']; ?>" onclick="show_alert()" >
                               <img src= "<?php echo base_url(); ?>/images/edit.jpeg" alt="edit"/>

                            </a>
                          <?php
                               }    else{                     
                          ?>
                               <a href="<?php echo base_url(); ?>index.php/Gestione_centri/take/<?php echo $item ['id']; ?>" >
                                    <img src= "<?php echo base_url(); ?>/images/edit.jpeg" alt="edit"/>
                               </a> 
                         <?php
                               }                    
                          ?>
                     </td>


                 <?php
                            }
                         endforeach;
                    ?>
        <?php
?>      
            </table>
                    </div>
        <div id="cerca">
            <ul>
                <li><a href="<?php echo base_url(); ?>index.php/gestione_centri">Booking form</a></li>
                <li><a href="<?php echo base_url(); ?>index.php/gestione_centri/presearch">Booking review</a></li>
            </ul>
        </div>
</section>
<?php $this->load->view('admin_footer');?>
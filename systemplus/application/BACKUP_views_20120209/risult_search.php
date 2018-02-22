<?php $this->load->view('admin_header');?>
<?php $this->load->view('admin_menu_left');?>
<section id="main" class="column">
        <div id="header">
            <h1>Month review :</h1>
        </div>
        <div id="" class="tab_content">
            <table class="tablesorter">
               <tr>

                    <th>DAYS</th>
                    <th>NUM. STUDENTS</th>
                    <th>TEACHERS</th>
                    <th>EMPLOYED</th>
                    <th>MISS TEACHERS</th>
                    <th>INFO</th>

                </tr>
                             <?php 
                             for($i=0; $i<count($mydata); $i++){
                             ?>    
                                 <tr>  
                                        <td><?php echo $mydata[$i];?></td>
                                        <td><?php echo $mypax[$i];?></td>
                                        <td><?php echo (round($mypax[$i]/12,2));?></td>
                                        <td><?php echo $insegnanti ;?></td>
                                        <td>
                                            <?php 
                                                if (round($mypax[$i]/12 - $insegnanti,2)<0)
                                                    echo '---';
                                                else
                                                  echo (round($mypax[$i]/12 - $insegnanti,2)) ;
                                            ;?>
                                        </td>
                                        <td>
                                            <?php
            
                                                 if($valoreflag[$i]){
                                                    echo "<a href=\"". base_url()."index.php/Gestione_centri/info/".$mydata[$i]."/".$id ."\">";
                                                     echo "<img src=\"".base_url()."images/info.jpeg\" alt=\"info\"/>";
                                                    echo "</a>";
                                                 };
                                            ?>
                                        </td>
                                        
                                        
                                        
                                        
                                  </tr>
                            <?php           
                                }
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
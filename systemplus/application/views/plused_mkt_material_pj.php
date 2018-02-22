<?php $this->load->view('plused_header');?>
	<!-- The container of the sidebar and content box -->
	<div role="main" id="main" class="container_12 clearfix">
	
		<!-- The blue toolbar stripe -->
		<section class="toolbar">
			<div class="user">
				<div class="avatar">
					<img src="<?php echo base_url(); ?>img/layout/content/toolbar/user/avatar.png">
					<!-- Evidenziare per icone attenzione <span>3</span> -->
				</div>
				<span><?echo $this->session->userdata('businessname') ?></span>
				<ul>
					<li><a href="<?php echo base_url(); ?>index.php/agents/changeCredential">Profile</a></li>
					<li class="line"></li>
					<li><a href="<?php echo base_url(); ?>index.php/agents/logout">Logout</a></li>
				</ul>
			</div>
			<input type="search" data-source="extras/search.php" placeholder="Search..." autocomplete="off" class="tooltip" title="e.g. Canterbury" data-gravity=s>
		</section><!-- End of .toolbar-->
<?php $this->load->view('plused_sidebar');?>		
	<script>
	$(document).ready(function() {
		$( "li#mktplusj" ).addClass("current");
		$( "li#mktplusj a" ).addClass("open");		
		$( "li#mktplusj ul.sub" ).css('display','block');	
		$( "li#mktplusj ul.sub li#mktplusj_1" ).addClass("current");			
	});
	</script>		
		<!-- Optional: Right Sidebar -->
		<div class="right-sidebar">
			<ul class=nav>
				<li class="current"><a href="#mpj_1"><span class="icon icon-list-alt"></span>Plus Junior</a></li>
				<li><a href="#mpj_2_1" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Destination factsheet UK</a></li>
				<li><a href="#mpj_2_2" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Destination factsheet Ireland</a></li>
				<li><a href="#mpj_2_3" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Destination factsheet Malta</a></li>
				<li><a href="#mpj_2_5" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Destination factsheet USA</a></li>
				<?php /*
				<li><a href="#mpj_3" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Our team</a></li>
				<li><a href="#mpj_4" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Who's who on campus?</a></li>
				<li><a href="#mpj_5" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Our courses</a></li>
				<li><a href="#mpj_6" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Activities on campus</a></li>
				<li><a href="#mpj_7" href="javascript:void(0);"><span class="icon icon-list-alt"></span>The package includes</a></li>
				<li><a href="#mpj_8" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Accomodation</a></li>
				<li><a href="#mpj_9" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Plus Experience</a></li> */ ?>
				<li><a href="#mpj_10" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Agents manual - Host Families Guidelines</a></li>
				<li><a href="#mpj_11" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Students Handbook</a></li>
				<li><a href="#mpj_12" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Group Leaders manual</a></li>
				<li><a href="#mpj_13" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Campus price list</a></li>
				<li><a href="#mpj_14" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Transfer price list</a></li>
			</ul>
		</div><!-- End of right sidebar -->
		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix with-right-sidebar" data-sort=true>

		<h1 class="grid_12 margin-top">Plus Junior</h1>
		
			<div class="vertical-tabs grid_12">
				<div id="mpj_1">
					<p class="grid_12">
						<em class="minitit">Download and printed material</em>
						In this section you can find materials you might want to download or order in a printed version.<br />We have divided materials by brand. You will find brochures and prospectuses with application forms, fees, agent manuals, pre-arrival information, flyers, etc.
					</p>
					<p class="grid_12">
						<em class="minitit">Accomodation factsheets</em>
						We have prepared a selected list of information for all our locations around the world, providing you with a detailed list of amenities, accommodation facilities, activities and excursions for each of our Centres in the UK, Ireland, Malta, Canada and North America.<br />This will give you access to a wide range of information to help you choose the best package tailored to your own need.<br /><b>Just click on the destination!</b>
					</p>
					<p class="grid_12">
						<em class="minitit">Image gallery</em>
						You can find a broad range of images of all our centres, cities, facilities, and students in our Image Library. This will be the ideal tool for choosing the best photos to prepare your own brochure and marketing material. How does it work?<br />Just click on the Categories you require and select the images you prefer. Then simply click <b>download</b> and the image will be automatically transferred to your computer.
					</p>					
				</div>	
<?php
function elencafiles($dirname,$arrayext){
	$dirname = strtolower($dirname);
	$arrayfiles=array();
	if(file_exists($dirname)){
//		echo $dirname;
		$handle = opendir($dirname);
		while (false !== ($file = readdir($handle))) { 
			if(is_file($dirname.$file)){
				array_push($arrayfiles,$file);
			}
		}
		$handle = closedir($handle);
	}
	//echo "<pre>";
	//print_r($arrayfiles);
	//echo "</pre>";
	sort($arrayfiles);
	//print_r($arrayfiles);
	return $arrayfiles;
}
?>				
				<div id="mpj_2_1">
					<h2 class="grid_12 margin-top">Destination factsheet UK</h2>
					<div class="accordion grid_12 border">
					<?php
						foreach($fsUK as $cUK){
					?>
						<h3><a href="javascript:void(0);"><?echo $cUK["nome_centri"] ?></a></h3>
						<div>
							<p>
							
<?php

$directoryCENTRO="/var/www/html/www.plus-ed.com/vision_ag/downloads/".strtolower(urlencode($cUK["nome_centri"]))."_".$cUK["id"]."/";
$directoryLINK="downloads/".strtolower(urlencode($cUK["nome_centri"]))."_".$cUK["id"]."/";
$array_extimg=array('.pdf');
$arrayfile=array();
?>
								<ul>
<?php
	$arrayfile=elencafiles($directoryCENTRO,$array_extimg);
	if(count($arrayfile)){ 
		foreach($arrayfile as $numerojc){
			$nome_esteso=str_replace(".pdf","",str_replace("_"," ",$numerojc));
			?>
			<li style="text-transform:capitalize;"><a target="_blank" href="/vision_ag/<?php echo $directoryLINK ?><?php echo $numerojc ?>" title="Download <?php echo $nome_esteso ?>"><?php echo $nome_esteso ?></a></li>
		<?php
		}
	}else{?>
		<li>No documents for  <?php echo $cUK["nome_centri"] ?></li>
	<?php
	}
?>									
								</ul>
							</p>
						</div>
					<?php
						}
					?>
					</div>
				</div>	
				<div id="mpj_2_2">
					<h2 class="grid_12 margin-top">Destination factsheet Ireland</h2>
					<div class="accordion grid_12 border">
<?php
						foreach($fsIR as $cIR){
					?>
						<h3><a href="javascript:void(0);"><?echo $cIR["nome_centri"] ?></a></h3>
						<div>
							<p>
							
<?php

$directoryCENTRO="/var/www/html/www.plus-ed.com/vision_ag/downloads/".strtolower(urlencode($cIR["nome_centri"]))."_".$cIR["id"]."/";
$directoryLINK="downloads/".strtolower(urlencode($cIR["nome_centri"]))."_".$cIR["id"]."/";
$array_extimg=array('.pdf');
$arrayfile=array();
?>
								<ul>
<?php
	$arrayfile=elencafiles($directoryCENTRO,$array_extimg);
	if(count($arrayfile)){ 
		foreach($arrayfile as $numerojc){
			$nome_esteso=str_replace(".pdf","",str_replace("_"," ",$numerojc));
			?>
			<li style="text-transform:capitalize;"><a target="_blank" href="/vision_ag/<?php echo $directoryLINK ?><?php echo $numerojc ?>" title="Download <?php echo $nome_esteso ?>"><?php echo $nome_esteso ?></a></li>
		<?php
		}
	}else{?>
		<li>No documents for  <?php echo $cIR["nome_centri"] ?></li>
	<?php
	}
?>									
								</ul>
							</p>
						</div>
					<?php
						}
					?>
					</div>					
				</div>	
				<div id="mpj_2_3">
					<h2 class="grid_12 margin-top">Destination factsheet Malta</h2>
					<div class="accordion grid_12 border">
<?php
						foreach($fsMA as $cMA){
					?>
						<h3><a href="javascript:void(0);"><?echo $cMA["nome_centri"] ?></a></h3>
						<div>
							<p>
							
<?php

$directoryCENTRO="/var/www/html/www.plus-ed.com/vision_ag/downloads/".strtolower(urlencode($cMA["nome_centri"]))."_".$cMA["id"]."/";
$directoryLINK="downloads/".strtolower(urlencode($cMA["nome_centri"]))."_".$cMA["id"]."/";
$array_extimg=array('.pdf');
$arrayfile=array();
?>
								<ul>
<?php
	$arrayfile=elencafiles($directoryCENTRO,$array_extimg);
	if(count($arrayfile)){ 
		foreach($arrayfile as $numerojc){
			$nome_esteso=str_replace(".pdf","",str_replace("_"," ",$numerojc));
			?>
			<li style="text-transform:capitalize;"><a target="_blank" href="/vision_ag/<?php echo $directoryLINK ?><?php echo $numerojc ?>" title="Download <?php echo $nome_esteso ?>"><?php echo $nome_esteso ?></a></li>
		<?php
		}
	}else{?>
		<li>No documents for  <?php echo $cMA["nome_centri"] ?></li>
	<?php
	}
?>									
								</ul>
							</p>
						</div>
					<?php
						}
					?>
					</div>					
				</div>	
				<div id="mpj_2_5">
					<h2 class="grid_12 margin-top">Destination factsheet USA</h2>
					<div class="accordion grid_12 border">
<?php
						foreach($fsUSA as $cUSA){
					?>
						<h3><a href="javascript:void(0);"><?echo $cUSA["nome_centri"] ?></a></h3>
						<div>
							<p>
							
<?php

$directoryCENTRO="/var/www/html/www.plus-ed.com/vision_ag/downloads/".strtolower(urlencode($cUSA["nome_centri"]))."_".$cUSA["id"]."/";
$directoryLINK="downloads/".strtolower(urlencode($cUSA["nome_centri"]))."_".$cUSA["id"]."/";
$array_extimg=array('.pdf');
$arrayfile=array();
?>
								<ul>
<?php
	$arrayfile=elencafiles($directoryCENTRO,$array_extimg);
	if(count($arrayfile)){ 
		foreach($arrayfile as $numerojc){
			$nome_esteso=str_replace(".pdf","",str_replace("_"," ",$numerojc));
			?>
			<li style="text-transform:capitalize;"><a target="_blank" href="/vision_ag/<?php echo $directoryLINK ?><?php echo $numerojc ?>" title="Download <?php echo $nome_esteso ?>"><?php echo $nome_esteso ?></a></li>
		<?php
		}
	}else{?>
		<li>No documents for  <?php echo $cUSA["nome_centri"] ?></li>
	<?php
	}
?>									
								</ul>
							</p>
						</div>
					<?php
						}
					?>
					</div>					
				</div>					
				<div id="mpj_3">
					<h2 class="grid_12 margin-top">Our team</h2>
					<p class="grid_12">
						PLUS recruits only fully-qualified personnel to work in our summer schools. We strive to employ enthusiastic and charismatic staff who we know can deliver a fantastic summer programme. Our aim is for this to not only be a study holiday but also one where the students will develop and be aware of international differences.<br /><br />Our centres are staffed with people from a wide range of backgrounds which will add to the overall cultural experience the students will have.We ensure all our summer camps are places where students can improve their language skills and build their confidence academically as well as socially.<br /><br />Our Course Directors are always highly-experienced as both teachers and managers and are able to ensure the smooth running of the centre while overseeing the tuition programme. All teachers working for PLUS, either as Residential Teachers or Non-Residential Teachers have undertaken intensive TEFL teacher training courses to conform to the British Council criteria.<br /><br /><em class="minitit">30 YEARS OF EXPERIENCE</em>Plus starter operating in the ELT market in 1972. Today, our group with offices in England, Ireland, the USA, Italy and Malta, represents one of the world's largest and finest organisation in language teaching. Our success is recognised by over 20.000 student from all around the world who choose PLUS every year for their Study Holiday experience. 
					</p>
				</div>	
				<div id="mpj_4">
					<h2 class="grid_12 margin-top">Who's who on campus</h2>				
					<p class="grid_12">
						<em class="minitit">Course Director</em>The Course Director has overall responsability for academic side of  the programme. He guides the teachers and ensures lessons are running about their study programme, don't hesitate to speak to him.<br /><br /><em class="minitit">Campus Manager</em>The Campus Manager has overall responsibility for the wellbeing of all students while staying at our PLUS center. He will check on the accomodation, catering, excursions  and leisure programme to ensure everything is of the high standars we insist upon at our centres. Come and talk to the Campus manager any time about anything!<br /><br /><em class="minitit">Activity Leader</em>Activity Leaders run the afternoon and evening activities on campus. Students can recognise them by their PLUS Uniforms. They are all native English speakers and can help students practise their English while playing sports and enjoying the many leisure activities.<br /><br /><em class="minitit">Teacher</em>PLUS teachers lead classes every morning and students will get to know their teacher very well. Teachers are qualified native English speakers and want to help students improve their English while having fun with the language. Teachers also help out with some afternoon and evening activities and join the weekend excursions.
					</p>
				</div>	
				<div id="mpj_5">
					<h2 class="grid_12 margin-top">Our courses</h2>					
					<p class="grid_12">
						PLUS provided a comprehensive range of programmes for students who wish to Study Abroad.<br /><br />Our courses are designed for students who wish to become more proficient in English and more confident in their speaking and listening skills.<br /><br />Our highly-interactive course  reflects this awareness and is focused on fuctional and communicative language studies with a specific focus on vocabulary and pronunciation skills. We use specially-designed text books wich have been specifically written for teenage students on short summer courses. There are gennerally 12-13 students in a class with a maximum of 15 students. The courses are planned around 20 lessons per week (45 minutes each) from Monday to Friday wich is a total of 15 hours a week, at up to five different levels from Beginner to Advanced.
					</p>
				</div>	
				<div id="mpj_6">
					<h2 class="grid_12 margin-top">Activities on campus</h2>							
					<p class="grid_12">PLUS is extremely proud of its fun-filled, action-packed leisure programme. PLUS ensures that students will always have plenty to do, all day long, seven days a week.<br /><br />Educational visit to places of cultural and historical interest form an important part of the course programme at each campus. Students are also able to enjoy sporting and leisure  activities during the afternoon, while sports tournaments are organised by PLUS staff. Every night  there will be a choice of disco-music (two/three times per week), films shows (with English subtitles), quizzes, treasure hunts, drama, workshops, table-tennis and other indoor games organised by our residential staff. 
					</p>
				</div>	
				<div id="mpj_7">
					<h2 class="grid_12 margin-top">The package includes</h2>							
					<p class="grid_12">
						<ol>
							<li>20 English Language Lessons per week during mornings</li>
							<li>Multinational classes</li>
							<li>Maximum 15 students per class</li>
							<li>Full board package</li>
							<li>Full day and Half day excursions 7 day's a week supervised social activity with: Discos, sports, karaoke, films...</li>
							<li>Text book</li>
							<li>End of Course Diploma</li>
							<li>24 hours assistance with Worlwide coverage</li>
						</ol>
					</p>
				</div>	
				<div id="mpj_8">
					<h2 class="grid_12 margin-top">Accomodation</h2>							
					<p class="grid_12">Your new home abroad is an important part of your study experience, particulary as enjoying life outside of school will help you to learn more effectively in  the classroom.<br /><br />PLUS offers accomodation worldwide with options designed to give you the opportunity to interact with native  speakers or fellow students and to experience more of culture of your chosen study destination. 
					</p>
				</div>	
				<div id="mpj_9">
					<h2 class="grid_12 margin-top">Plus Experience</h2>							
					<p class="grid_12">And for those looking for the most stimulating study holiday, PLUS has created the EXPERIENCE package, an <b>All inclusive</b> programme that will make your study holiday even more special.<br /><br />The PLUS  EXPERIENCE is a must for those who wish to truly discover their destinations. You will be able to explore quaint, beautifull villages, throughout the British Isles, legendary Scottish abbeys, or the wonderful Aran Islands in Ireland. Would you prefer a ride on the London Eye or a tour along the U2 trail in Dublin?<br /><br />A rafting course in Canada or a relaxing afternoon on a California beach? With the PLUS EXPERIENCE you only have to choose your location and let us take care of all the rest.  
					</p>
				</div>
	
				<div id="mpj_10">
					<h2 class="grid_12 margin-top">Agents manual</h2>							
					<p class="grid_12">
							
<?php

$directoryhb="/var/www/html/www.plus-ed.com/vision_ag/downloads/agentsmanuals/";
$directoryLhb="downloads/agentsmanuals/";
$array_extimg=array('.pdf');
$arrayfile=array();
?>
								<ul>
<?php
	//echo $directoryhb;
	$arrayfile=elencafiles($directoryhb,$array_extimg);
	if(count($arrayfile)){ 
		foreach($arrayfile as $numerojc){
			$nome_esteso=str_replace(".pdf","",str_replace("_"," ",$numerojc));
			?>
			<li style="text-transform:capitalize;"><a target="_blank" href="/vision_ag/<?php echo $directoryLhb ?><?php echo $numerojc ?>" title="Download <?php echo $nome_esteso ?>"><?php echo $nome_esteso ?></a></li>
		<?php
		}
	}else{?>
		<li>No documents in this section</li>
	<?php
	}
?>									
								</ul>
							</p>

				</div>	
		<div id="mpj_11">
							<h2 class="grid_12 margin-top">Students Handbook</h2>							
							<p class="grid_12">
									
		<?php

		$directoryhb="/var/www/html/www.plus-ed.com/vision_ag/downloads/studentsmanuals/";
		$directoryLhb="downloads/studentsmanuals/";
		$array_extimg=array('.pdf');
		$arrayfile=array();
		?>
										<ul>
		<?php
			$arrayfile=elencafiles($directoryhb,$array_extimg);
			if(count($arrayfile)){ 
				foreach($arrayfile as $numerojc){
					$nome_esteso=str_replace(".pdf","",str_replace("_"," ",$numerojc));
					?>
					<li style="text-transform:capitalize;"><a target="_blank" href="/vision_ag/<?php echo $directoryLhb ?><?php echo $numerojc ?>" title="Download <?php echo $nome_esteso ?>"><?php echo $nome_esteso ?></a></li>
				<?php
				}
			}else{?>
				<li>No documents in this section</li>
			<?php
			}
		?>									
										</ul>
									</p>

						</div>
		<div id="mpj_12">
							<h2 class="grid_12 margin-top">Group Leaders manual</h2>							
							<p class="grid_12">
									
		<?php

		$directoryhb="/var/www/html/www.plus-ed.com/vision_ag/downloads/gleadersmanuals/";
		$directoryLhb="downloads/gleadersmanuals/";
		$array_extimg=array('.pdf');
		$arrayfile=array();
		?>
										<ul>
		<?php
			$arrayfile=elencafiles($directoryhb,$array_extimg);
			if(count($arrayfile)){ 
				foreach($arrayfile as $numerojc){
					$nome_esteso=str_replace(".pdf","",str_replace("_"," ",$numerojc));
					?>
					<li style="text-transform:capitalize;"><a target="_blank" href="/vision_ag/<?php echo $directoryLhb ?><?php echo $numerojc ?>" title="Download <?php echo $nome_esteso ?>"><?php echo $nome_esteso ?></a></li>
				<?php
				}
			}else{?>
				<li>No documents in this section</li>
			<?php
			}
		?>									
										</ul>
									</p>

						</div>						
		<div id="mpj_13">
							<h2 class="grid_12 margin-top">Campus price list</h2>							
							<p class="grid_12">
									
		<?php

		$directoryhb="/var/www/html/www.plus-ed.com/vision_ag/downloads/campuspricelist/";
		$directoryLhb="downloads/campuspricelist/";
		$array_extimg=array('.pdf');
		$arrayfile=array();
		?>
										<ul>
		<?php
			$arrayfile=elencafiles($directoryhb,$array_extimg);
			if(count($arrayfile)){ 
				foreach($arrayfile as $numerojc){
					$nome_esteso=str_replace(".pdf","",str_replace("_"," ",$numerojc));
					?>
					<li style="text-transform:capitalize;"><a target="_blank" href="/vision_ag/<?php echo $directoryLhb ?><?php echo $numerojc ?>" title="Download <?php echo $nome_esteso ?>"><?php echo $nome_esteso ?></a></li>
				<?php
				}
			}else{?>
				<li>No documents in this section</li>
			<?php
			}
		?>									
										</ul>
									</p>

						</div>
		<div id="mpj_14">
							<h2 class="grid_12 margin-top">Transfer price list</h2>							
							<p class="grid_12">
									
		<?php

		$directoryhb="/var/www/html/www.plus-ed.com/vision_ag/downloads/transferpricelist/";
		$directoryLhb="downloads/transferpricelist/";
		$array_extimg=array('.pdf');
		$arrayfile=array();
		?>
										<ul>
		<?php
			$arrayfile=elencafiles($directoryhb,$array_extimg);
			if(count($arrayfile)){ 
				foreach($arrayfile as $numerojc){
					$nome_esteso=str_replace(".pdf","",str_replace("_"," ",$numerojc));
					?>
					<li style="text-transform:capitalize;"><a target="_blank" href="/vision_ag/<?php echo $directoryLhb ?><?php echo $numerojc ?>" title="Download <?php echo $nome_esteso ?>"><?php echo $nome_esteso ?></a></li>
				<?php
				}
			}else{?>
				<li>No documents in this section</li>
			<?php
			}
		?>									
										</ul>
									</p>

						</div>				
			</div><!-- End of .vertical-tabs -->
			
		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
<?php $this->load->view('plused_footer');?>

<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<style>
.col-xs-3 {
    padding-right: 0;
}
.nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover{
    border-color:#ddd #ddd #ddd transparent!important;
    background-color: #f7f7f7;
}

.nav-tabs > li > a{
    /*border-radius:  0 4px 4px 0!important;*/
    margin-right: -2px;

}
.nav-tabs > li > a:hover {
    border-color: #eee;

}
.nav-tabs > li {
    width: 104%;
}
.nav-tabs > li:not(.active) {
    border-left: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
}
.nav-tabs > li:first-of-type {
    border-top: 0px solid #ddd;
}

em.minitit {
    color: #225087;
    display: block;
    font-style: normal;
    font-weight: bold;
    text-transform: uppercase;
    width: 100%;
}

@media only screen and (max-width: 500px) {
    .mobile-tab {
        display: block;
    }
    .desktop-tab {
        display: none;
    }
    .tab-content{
        width: 98%!important;
    }
    .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {
        border-color: #ddd #ddd #ddd #ddd !important;
    }
    .nav-tabs > li > a {
        margin-right: unset!important;
    }
}
@media only screen and (min-width: 500px) {
    .mobile-tab {
        display: none;
    }
    .desktop-tab {
        display: block;
    }
}

</style>
<link rel="stylesheet" href="<?php echo LTE;?>plugins/fancybox/jquery.fancybox-buttons.css">
<link rel="stylesheet" href="<?php echo LTE;?>plugins/fancybox/jquery.fancybox-thumbs.css">
<link rel="stylesheet" href="<?php echo LTE;?>plugins/fancybox/jquery.fancybox.css">
      <div class="box" >
        <div class="row">
            <?php showSessionMessageIfAny($this);?>
        </div>
        <div class="box-body" style="padding-top:0;">
            <!-- Optional: Right Sidebar -->
		<div class="nav-tabs-custom">

<!--		</div> End of right sidebar -->
		<!-- Here goes the content. -->
<!--		<section id="content" class="col-sm-8 row clearfix with-right-sidebar" data-sort=true>-->
                <div class="col-sm-12 mobile-tab">
                    <ul class="nav nav-tabs">
                            <li class="current active">
                                <a data-toggle="tab" aria-expanded="true" href="#mpj_1"><span class="icon icon-list-alt"></span>Plus Junior</a></li>
                            <li><a data-toggle="tab" aria-expanded="true" href="#mpj_2_1" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Destination factsheet UK</a></li>
                            <li><a data-toggle="tab" aria-expanded="true" href="#mpj_2_2" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Destination factsheet Ireland</a></li>
                            <li><a data-toggle="tab" aria-expanded="true" href="#mpj_2_3" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Destination factsheet Malta</a></li>
                            <li><a data-toggle="tab" aria-expanded="true" href="#mpj_2_5" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Destination factsheet USA</a></li>
                            <li><a data-toggle="tab" aria-expanded="true" href="#mpj_2_6" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Campus videos</a></li>
                            <?php /*
                            <li><a href="#mpj_3" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Our team</a></li>
                            <li><a href="#mpj_4" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Who's who on campus?</a></li>
                            <li><a href="#mpj_5" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Our courses</a></li>
                            <li><a href="#mpj_6" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Activities on campus</a></li>
                            <li><a href="#mpj_7" href="javascript:void(0);"><span class="icon icon-list-alt"></span>The package includes</a></li>
                            <li><a href="#mpj_8" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Accomodation</a></li>
                            <li><a href="#mpj_9" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Plus Experience</a></li> */ ?>
                            <li><a data-toggle="tab" aria-expanded="true" href="#mpj_10" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Agents manual - Host Families Guidelines</a></li>
                            <li><a data-toggle="tab" aria-expanded="true" href="#mpj_11" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Students Handbook</a></li>
                            <li><a data-toggle="tab" aria-expanded="true" href="#mpj_12" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Group Leaders manual</a></li>
                            <li><a data-toggle="tab" aria-expanded="true" href="#mpj_13" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Campus price list</a></li>
                            <li><a data-toggle="tab" aria-expanded="true" href="#mpj_14" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Transfer price list</a></li>
                    </ul>
                </div>
			<div class="tab-content col-xs-9">
				<div id="mpj_1" class="tab-pane active">
                                    <h4 >Plus Junior</h4>
					<p>
						<em class="minitit">Download and printed material</em>
						In this section you can find materials you might want to download or order in a printed version.<br />We have divided materials by brand. You will find brochures and prospectuses with application forms, fees, agent manuals, pre-arrival information, flyers, etc.
					</p>
					<p>
						<em class="minitit">Accomodation factsheets</em>
						We have prepared a selected list of information for all our locations around the world, providing you with a detailed list of amenities, accommodation facilities, activities and excursions for each of our Centres in the UK, Ireland, Malta, Canada and North America.<br />This will give you access to a wide range of information to help you choose the best package tailored to your own need.<br /><b>Just click on the destination!</b>
					</p>
					<p>
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
				<div id="mpj_2_1" class="tab-pane">
                                    <h4>Destination factsheet UK</h4>
                                         <div id="accordion_uk" class="box-group">
                                        <?php
						foreach($fsUK as $cUK){
					?>


                                                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                                                <div class="panel box box-primary">
                                                <div class="box-header with-border">
                                                    <h4 class="box-title">
                                                    <a href="#collapse<?echo $cUK["id"] ?>" data-parent="#accordion_uk" data-toggle="collapse" aria-expanded="false" class="collapsed">
                                                        <?echo $cUK["nome_centri"] ?>
                                                    </a>
                                                    </h4>
                                                </div>
						<div class="panel-collapse collapse" id="collapse<?echo $cUK["id"] ?>" aria-expanded="false" style="height: 0px;">
                                                <div class="box-body">

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
							</div>
                                                    </div>
                                                </div>

					<?php
						}
					?>
                                         </div>

                                    </div>



				<div id="mpj_2_2" class="tab-pane">
                                        <h4>Destination factsheet Ireland</h4>
                                        <div id="accordion_irs" class="box-group">
<?php
						foreach($fsIR as $cIR){
					?>
                                            <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                                                <div class="panel box box-primary">
                                                <div class="box-header with-border">
                                                    <h4 class="box-title">
                                                    <a href="#collapse<?echo $cIR["id"] ?>" data-parent="#accordion_irs" data-toggle="collapse" aria-expanded="false" class="collapsed">
                                                        <?echo $cIR["nome_centri"] ?>
                                                    </a>
                                                    </h4>
                                                </div>
						<div class="panel-collapse collapse" id="collapse<?echo $cIR["id"] ?>" aria-expanded="false" style="height: 0px;">
                                                <div class="box-body">

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
							</div>
                                                    </div>
                                                </div>
					<?php
						}
					?>
					</div>
				</div>
				<div id="mpj_2_3" class="tab-pane">
					 <h4>Destination factsheet Malta</h4>
                                        <div id="accordion_malta" class="box-group">
                                        <?php
						foreach($fsMA as $cMA){
					?>
                                        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                                        <div class="panel box box-primary">
                                        <div class="box-header with-border">
                                            <h4 class="box-title">
                                            <a href="#collapse<?echo $cMA["id"] ?>" data-parent="#accordion_malta" data-toggle="collapse" aria-expanded="false" class="collapsed">
                                                <?echo $cMA["nome_centri"] ?>
                                            </a>
                                            </h4>
                                        </div>
                                        <div class="panel-collapse collapse" id="collapse<?echo $cMA["id"] ?>" aria-expanded="false" style="height: 0px;">
                                            <div class="box-body">
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
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                                }
                                        ?>
                                        </div>
                                </div>
				<div id="mpj_2_5" class="tab-pane">
                                        <h4>Destination factsheet USA</h4>
                                        <div id="accordion_usa" class="box-group">
<?php
						foreach($fsUSA as $cUSA){
					?>
						<!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                                                <div class="panel box box-primary">
                                                <div class="box-header with-border">
                                                    <h4 class="box-title">
                                                    <a href="#collapse<?echo $cUSA["id"] ?>" data-parent="#accordion_usa" data-toggle="collapse" aria-expanded="false" class="collapsed">
                                                        <?echo $cUSA["nome_centri"] ?>
                                                    </a>
                                                    </h4>
                                                </div>
                                                <div class="panel-collapse collapse" id="collapse<?echo $cUSA["id"] ?>" aria-expanded="false" style="height: 0px;">
                                                    <div class="box-body">

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
                                                </div>
                                            </div>
                                        </div>
					<?php
						}
					?>
					</div>
				</div>
                <div id="mpj_2_6" class="tab-pane">
                    <h4>Campus videos</h4>
                    <div id="campus_videos" class="box-group">
                        <?php
                            if( !empty( $campusDetails ) )
                            {
                        ?>
                                <div class="row">
                        <?php
                                    foreach ( $campusDetails as $campus )
                                    {
                                        if( $campus["image_path"] != "" )
                                            $img_path = base_url() . CAMPUS_IMAGE_PATH. $campus["image_path"];
                                        else
                                           $img_path = base_url() . 'img/placeholder_image.png';

                                        $video_arr = array();
                                        if( $campus['campus_video_1'] != '' )
                                        {
                                            $video_1 =  substr(parse_url($campus['campus_video_1'], PHP_URL_PATH), 1);
                                            array_push( $video_arr, $video_1 );
                                        }
                                        if( $campus['campus_video_2'] != '' )
                                        {
                                            $video_2 =  substr(parse_url($campus['campus_video_2'], PHP_URL_PATH), 1);
                                            array_push( $video_arr, $video_2 );
                                        }
                                        if( $campus['campus_video_3'] != '' )
                                        {
                                            $video_3 =  substr(parse_url($campus['campus_video_3'], PHP_URL_PATH), 1);
                                            array_push( $video_arr, $video_3 );
                                        }
                                        if( $campus['campus_video_4'] != '' )
                                        {
                                            $video_4 =  substr(parse_url($campus['campus_video_4'], PHP_URL_PATH), 1);
                                            array_push( $video_arr, $video_4 );
                                        }
                        ?>
                                        <div class="col-sm-4 campus-image-col">
                                            <div class="img_outer">
                                                <div class="img_box_main">
                                                    <a class="fancybox" data-fancybox-type="iframe" rel="gallery<?php echo $campus['id']?>" href="<?php echo ( !empty( $video_arr ) ) ? 'https://player.vimeo.com/video/'.$video_arr[0] : 'javascript:void(0);'?>">
                                                        <img src="<?php echo $img_path; ?>" class="img-responsive"/>
                                                    </a>
                                                    <?php
                                                        if( count($video_arr) > 1 )
                                                        {
                                                            for( $i = 1; $i < count($video_arr); $i++ )
                                                            {
                                                    ?>
                                                                <a class="fancybox" data-fancybox-type="iframe" rel="gallery<?php echo $campus['id']?>" href="https://player.vimeo.com/video/<?php echo $video_arr[$i]?>" style="display: none;">
                                                                </a>
                                                    <?php
                                                            }
                                                        }

                                                    ?>
                                                </div>
                                            </div>
                                            <h5><?php echo $campus['nome_centri']; ?></h5>
                                        </div>
                        <?php
                                    }
                        ?>
                                </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
				<div id="mpj_3" class="tab-pane">
					<h4 >Our team</h4>
					<div class="col-sm-12">
						PLUS recruits only fully-qualified personnel to work in our summer schools. We strive to employ enthusiastic and charismatic staff who we know can deliver a fantastic summer programme. Our aim is for this to not only be a study holiday but also one where the students will develop and be aware of international differences.<br /><br />Our centres are staffed with people from a wide range of backgrounds which will add to the overall cultural experience the students will have.We ensure all our summer camps are places where students can improve their language skills and build their confidence academically as well as socially.<br /><br />Our Course Directors are always highly-experienced as both teachers and managers and are able to ensure the smooth running of the centre while overseeing the tuition programme. All teachers working for PLUS, either as Residential Teachers or Non-Residential Teachers have undertaken intensive TEFL teacher training courses to conform to the British Council criteria.<br /><br /><em class="minitit">30 YEARS OF EXPERIENCE</em>Plus starter operating in the ELT market in 1972. Today, our group with offices in England, Ireland, the USA, Italy and Malta, represents one of the world's largest and finest organisation in language teaching. Our success is recognised by over 20.000 student from all around the world who choose PLUS every year for their Study Holiday experience.
					</div>
				</div>
				<div id="mpj_4" class="tab-pane">
					<h4 >Who's who on campus</h4>
					<div class="col-sm-12">
						<em class="minitit">Course Director</em>The Course Director has overall responsability for academic side of  the programme. He guides the teachers and ensures lessons are running about their study programme, don't hesitate to speak to him.<br /><br /><em class="minitit">Campus Manager</em>The Campus Manager has overall responsibility for the wellbeing of all students while staying at our PLUS center. He will check on the accomodation, catering, excursions  and leisure programme to ensure everything is of the high standars we insist upon at our centres. Come and talk to the Campus manager any time about anything!<br /><br /><em class="minitit">Activity Leader</em>Activity Leaders run the afternoon and evening activities on campus. Students can recognise them by their PLUS Uniforms. They are all native English speakers and can help students practise their English while playing sports and enjoying the many leisure activities.<br /><br /><em class="minitit">Teacher</em>PLUS teachers lead classes every morning and students will get to know their teacher very well. Teachers are qualified native English speakers and want to help students improve their English while having fun with the language. Teachers also help out with some afternoon and evening activities and join the weekend excursions.
					</div>
				</div>
				<div id="mpj_5" class="tab-pane">
					<h4 >Our courses</h4>
					<div class="col-sm-12">
						PLUS provided a comprehensive range of programmes for students who wish to Study Abroad.<br /><br />Our courses are designed for students who wish to become more proficient in English and more confident in their speaking and listening skills.<br /><br />Our highly-interactive course  reflects this awareness and is focused on fuctional and communicative language studies with a specific focus on vocabulary and pronunciation skills. We use specially-designed text books wich have been specifically written for teenage students on short summer courses. There are gennerally 12-13 students in a class with a maximum of 15 students. The courses are planned around 20 lessons per week (45 minutes each) from Monday to Friday wich is a total of 15 hours a week, at up to five different levels from Beginner to Advanced.
					</div>
				</div>
				<div id="mpj_6" class="tab-pane">
					<h4 >Activities on campus</h4>
					<div class="col-sm-12">PLUS is extremely proud of its fun-filled, action-packed leisure programme. PLUS ensures that students will always have plenty to do, all day long, seven days a week.<br /><br />Educational visit to places of cultural and historical interest form an important part of the course programme at each campus. Students are also able to enjoy sporting and leisure  activities during the afternoon, while sports tournaments are organised by PLUS staff. Every night  there will be a choice of disco-music (two/three times per week), films shows (with English subtitles), quizzes, treasure hunts, drama, workshops, table-tennis and other indoor games organised by our residential staff.
					</div>
				</div>
				<div id="mpj_7" class="tab-pane">
					<h4 >The package includes</h4>
					<div class="col-sm-12">
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
					</div>
				</div>
				<div id="mpj_8" class="tab-pane">
					<h4 >Accomodation</h4>
					<div class="col-sm-12">Your new home abroad is an important part of your study experience, particulary as enjoying life outside of school will help you to learn more effectively in  the classroom.<br /><br />PLUS offers accomodation worldwide with options designed to give you the opportunity to interact with native  speakers or fellow students and to experience more of culture of your chosen study destination.
					</div>
				</div>
				<div id="mpj_9" class="tab-pane">
					<h4 >Plus Experience</h4>
					<div class="col-sm-12">And for those looking for the most stimulating study holiday, PLUS has created the EXPERIENCE package, an <b>All inclusive</b> programme that will make your study holiday even more special.<br /><br />The PLUS  EXPERIENCE is a must for those who wish to truly discover their destinations. You will be able to explore quaint, beautifull villages, throughout the British Isles, legendary Scottish abbeys, or the wonderful Aran Islands in Ireland. Would you prefer a ride on the London Eye or a tour along the U2 trail in Dublin?<br /><br />A rafting course in Canada or a relaxing afternoon on a California beach? With the PLUS EXPERIENCE you only have to choose your location and let us take care of all the rest.
					</div>
				</div>

				<div id="mpj_10" class="tab-pane">
					<h4 >Agents manual</h4>
					<div class="col-sm-12">

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
							</div>

				</div>
		<div id="mpj_11" class="tab-pane">
                    <h4 >Students Handbook</h4>
                    <div class="col-sm-12">

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
									</div>

						</div>
		<div id="mpj_12" class="tab-pane">
							<h4 >Group Leaders manual</h4>
							<div class="col-sm-12">

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
									</div>

						</div>
		<div id="mpj_13" class="tab-pane">
                    <h4 >Campus price list</h4>
                    <div class="col-sm-12">

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
									</div>

						</div>
		<div id="mpj_14" class="tab-pane">
                    <h4 >Transfer price list</h4>
                    <div class="col-sm-12">

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
									</div>

						</div>
<!--			</div> End of .vertical-tabs

		</section> End of #content -->
        </div>
                <div class="col-xs-3 desktop-tab">
			<ul class="nav nav-tabs">
				<li class="current active">
                                    <a data-toggle="tab" aria-expanded="true" href="#mpj_1"><span class="icon icon-list-alt"></span>Plus Junior</a></li>
				<li><a data-toggle="tab" aria-expanded="true" href="#mpj_2_1" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Destination factsheet UK</a></li>
				<li><a data-toggle="tab" aria-expanded="true" href="#mpj_2_2" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Destination factsheet Ireland</a></li>
				<li><a data-toggle="tab" aria-expanded="true" href="#mpj_2_3" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Destination factsheet Malta</a></li>
				<li><a data-toggle="tab" aria-expanded="true" href="#mpj_2_5" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Destination factsheet USA</a></li>
                <li><a data-toggle="tab" aria-expanded="true" href="#mpj_2_6" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Campus videos</a></li>
				<?php /*
				<li><a href="#mpj_3" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Our team</a></li>
				<li><a href="#mpj_4" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Who's who on campus?</a></li>
				<li><a href="#mpj_5" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Our courses</a></li>
				<li><a href="#mpj_6" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Activities on campus</a></li>
				<li><a href="#mpj_7" href="javascript:void(0);"><span class="icon icon-list-alt"></span>The package includes</a></li>
				<li><a href="#mpj_8" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Accomodation</a></li>
				<li><a href="#mpj_9" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Plus Experience</a></li> */ ?>
				<li><a data-toggle="tab" aria-expanded="true" href="#mpj_10" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Agents manual - Host Families Guidelines</a></li>
				<li><a data-toggle="tab" aria-expanded="true" href="#mpj_11" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Students Handbook</a></li>
				<li><a data-toggle="tab" aria-expanded="true" href="#mpj_12" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Group Leaders manual</a></li>
				<li><a data-toggle="tab" aria-expanded="true" href="#mpj_13" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Campus price list</a></li>
				<li><a data-toggle="tab" aria-expanded="true" href="#mpj_14" href="javascript:void(0);"><span class="icon icon-list-alt"></span>Transfer price list</a></li>
			</ul>
                </div>
        </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            &nbsp;
        </div>
        <!-- /.box-footer-->
      </div>

<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo LTE;?>plugins/fancybox/jquery.fancybox.js"></script>
<script src="<?php echo LTE;?>plugins/fancybox/jquery.fancybox-buttons.js"></script>
<script src="<?php echo LTE;?>plugins/fancybox/jquery.fancybox-thumbs.js"></script>
<script src="<?php echo LTE;?>plugins/fancybox/jquery.easing-1.3.pack.js"></script>
<script src="<?php echo LTE;?>plugins/fancybox/jquery.mousewheel-3.0.6.pack.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $(".fancybox").fancybox();

        $(".mobile-tab li").click(function(e){
            $('html,body').animate({
                scrollTop: $(".tab-content").offset().top
            },
            'slow');
        });
    });
</script>
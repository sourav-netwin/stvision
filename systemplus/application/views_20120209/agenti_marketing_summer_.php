<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<title><?=$title?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/agenti.css" media="screen" /> 
<style type="text/css">

.dhtmlgoodies_question{	/* Styling question */
	/* Start layout CSS */
	
	font-family: tahoma;
	font-size: 10px;
	font-weight: normal;
	color:#53534B;
	text-decoration: underline;
	width:140px;
	margin-bottom:2px;
	margin-top:2px;
	padding-left:2px;
	
	/* End layout CSS */
	
	overflow:hidden;
	cursor:pointer;
}
.dhtmlgoodies_answer{	/* Parent box of slide down content */
	/* Start layout CSS */
	border:1px solid #317082;
	background-color:#E2EBED;
	width:140px;	
	text-decoration:none;
	/* End layout CSS */
	
	visibility:hidden;
	height:0px;
	overflow:hidden;
	position:relative;

}
.dhtmlgoodies_answer_content{	/* Content that is slided down */
	padding:1px;

	position:relative;
}

</style>
<script type="text/javascript">
/************************************************************************************************************
(C) www.dhtmlgoodies.com, November 2005

This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.	

Terms of use:
You are free to use this script as long as the copyright message is kept intact. However, you may not
redistribute, sell or repost it without our permission.

Thank you!

www.dhtmlgoodies.com
Alf Magne Kalleland

************************************************************************************************************/

var dhtmlgoodies_slideSpeed = 10;	// Higher value = faster
var dhtmlgoodies_timer = 10;	// Lower value = faster

var objectIdToSlideDown = false;
var dhtmlgoodies_activeId = false;
var dhtmlgoodies_slideInProgress = false;
function showHideContent(e,inputId)
{
	if(dhtmlgoodies_slideInProgress)return;
	dhtmlgoodies_slideInProgress = true;
	if(!inputId)inputId = this.id;
	inputId = inputId + '';
	var numericId = inputId.replace(/[^0-9]/g,'');
	var answerDiv = document.getElementById('dhtmlgoodies_a' + numericId);

	objectIdToSlideDown = false;
	
	if(!answerDiv.style.display || answerDiv.style.display=='none'){		
		if(dhtmlgoodies_activeId &&  dhtmlgoodies_activeId!=numericId){			
			objectIdToSlideDown = numericId;
			slideContent(dhtmlgoodies_activeId,(dhtmlgoodies_slideSpeed*-1));
		}else{
			
			answerDiv.style.display='block';
			answerDiv.style.visibility = 'visible';
			
			slideContent(numericId,dhtmlgoodies_slideSpeed);
		}
	}else{
		slideContent(numericId,(dhtmlgoodies_slideSpeed*-1));
		dhtmlgoodies_activeId = false;
	}	
}

function slideContent(inputId,direction)
{
	
	var obj =document.getElementById('dhtmlgoodies_a' + inputId);
	var contentObj = document.getElementById('dhtmlgoodies_ac' + inputId);
	height = obj.clientHeight;
	if(height==0)height = obj.offsetHeight;
	height = height + direction;
	rerunFunction = true;
	if(height>contentObj.offsetHeight){
		height = contentObj.offsetHeight;
		rerunFunction = false;
	}
	if(height<=1){
		height = 1;
		rerunFunction = false;
	}

	obj.style.height = height + 'px';
	var topPos = height - contentObj.offsetHeight;
	if(topPos>0)topPos=0;
	contentObj.style.top = topPos + 'px';
	if(rerunFunction){
		setTimeout('slideContent(' + inputId + ',' + direction + ')',dhtmlgoodies_timer);
	}else{
		if(height<=1){
			obj.style.display='none'; 
			if(objectIdToSlideDown && objectIdToSlideDown!=inputId){
				document.getElementById('dhtmlgoodies_a' + objectIdToSlideDown).style.display='block';
				document.getElementById('dhtmlgoodies_a' + objectIdToSlideDown).style.visibility='visible';
				slideContent(objectIdToSlideDown,dhtmlgoodies_slideSpeed);				
			}else{
				dhtmlgoodies_slideInProgress = false;
			}
		}else{
			dhtmlgoodies_activeId = inputId;
			dhtmlgoodies_slideInProgress = false;
		}
	}
}



function initShowHideDivs()
{
	var divs = document.getElementsByTagName('DIV');
	var divCounter = 1;
	for(var no=0;no<divs.length;no++){
		if(divs[no].className=='dhtmlgoodies_question'){
			divs[no].onclick = showHideContent;
			divs[no].id = 'dhtmlgoodies_q'+divCounter;
			var answer = divs[no].nextSibling;
			while(answer && answer.tagName!='DIV'){
				answer = answer.nextSibling;
			}
			answer.id = 'dhtmlgoodies_a'+divCounter;	
			contentDiv = answer.getElementsByTagName('DIV')[0];
			contentDiv.style.top = 0 - contentDiv.offsetHeight + 'px'; 	
			contentDiv.className='dhtmlgoodies_answer_content';
			contentDiv.id = 'dhtmlgoodies_ac' + divCounter;
			answer.style.display='none';
			answer.style.height='1px';
			divCounter++;
		}		
	}	
}
window.onload = initShowHideDivs;
</script>

</head>
<body>
<img src="<?php echo base_url(); ?>images/agenti_header.png" style="margin:10px 0 0 0">
<div id="container">
	<div id="bigbox">	
	<?php $this->load->view('agenti_tab');?>
		<div id="left" >
			<div class="left_menu" >
				<?php $this->load->view('agenti_left_marketing');?>
		
		</div>

		<div id="middle">

			<div id="up_middle" style="background:#fff url('../../images/agenti_up_middle.png') no-repeat; margin:0 0 0 0px; padding:5px 0 0 0; height:30px;"><h2>THE DESTINATION FACT SHEET</h2>
			</div>
			<div id="middle_destinazioni">
            <div class="col_destinazioni" >
				<h3 class="tit_destinazioni">UK</h3>
				<ul class="icodoc">
				<li>
					<div class="dhtmlgoodies_question">BATH</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/factsheet/BATH.pdf">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/tabelleextraex/bathextraex.pdf">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>pdf/tabellemusei/bathtabellemusei.pdf">Museums</a>
					</div>
					</div>
				</li>
                
                <li>
               		<div class="dhtmlgoodies_question">BEDFORD</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/factsheet/BEDFORD.pdf">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/tabelleextraex/bedfordextraex.pdf">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>pdf/tabellemusei/londondocktabellemusei.pdf">Museums - same table of London Docklands</a>
					</div>
					</div>
				</li>
          
				<li>
					<div class="dhtmlgoodies_question">CANTERBURY</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/factsheet/CANTERBURY.pdf">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/tabelleextraex/canterburyextraex.pdf">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Museums</a>
					</div>
					</div>
					</li>
                
				<li>
                	<div class="dhtmlgoodies_question">CHELMSFORD</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/factsheet/CHELMSFORD.pdf">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Museums</a>
					</div>
					</div>
                </li>
				<li>
                
                	<div class="dhtmlgoodies_question">CHELTENHAM</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/factsheet/CHELTENHAM.pdf">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/tabelleextraex/cheltenhamextraex.pdf">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>pdf/tabellemusei/cheltenhamtabellemusei.pdf">Museums</a>
					</div>
					</div>
                </li>
                
                <li>
                
                <div class="dhtmlgoodies_question">CHESTER</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/factsheet/CHESTER.pdf">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/tabelleextraex/chesterextraex.pdf">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>pdf/tabellemusei/chestertabellemusei.pdf">Museums</a>
					</div>
					</div>
                
                
                </li>
                <li>
                
                <div class="dhtmlgoodies_question">EDIMBURGH</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/factsheet/EDIMBURGH.pdf">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/tabelleextraex/edimburghextraex.pdf">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>pdf/tabellemusei/edimburghtabellemusei.pdf">Museums</a>
					</div>
					</div>
                
                
                </li>
				 <li>
                	<div class="dhtmlgoodies_question">GREENWICH</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/factsheet/GREENWICH.pdf">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Museums</a>
					</div>
					</div>
                    
                 </li>
                <li>
                <div class="dhtmlgoodies_question">LEICESTER</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/factsheet/LEICESTER.pdf">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/tabelleextraex/leicesterextraex.pdf">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>pdf/tabellemusei/leicestertabellemusei.pdf">Museums</a>
					</div>
					</div>
               
                </li>
               
                <li>
                     <div class="dhtmlgoodies_question">LONDON REGENTS</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/factsheet/LONDONREGENTS.pdf">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/tabelleextraex/docklandsextraex.pdf">Extra Excursion and Tranfers - same table of London Docklands</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>pdf/tabellemusei/londonregtabellemusei.pdf">Museums</a>
					</div>
					</div>
                </li>
                <li>
                
                     <div class="dhtmlgoodies_question">LONDON DOCKLANDS</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/factsheet/LONDONDOCKLANDS.pdf">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/tabelleextraex/docklandsextraex.pdf">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>pdf/tabellemusei/londondocktabellemusei.pdf">Museums</a>
					</div>
					</div>
                    
                </li>
               
                <li>
                <div class="dhtmlgoodies_question">LONDON ROEHAMPTON</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/factsheet/LONDONROEHAMPTON.pdf">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/tabelleextraex/roehamptonextraex.pdf">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>pdf/tabellemusei/londonroehatabellemusei.pdf">Museums</a>
					</div>
					</div>
                </li>
                
                
                          <li>
                <div class="dhtmlgoodies_question">LOUGHBOROUGH</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/factsheet/LOUGHBOROUGH.pdf">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Museums</a>
					</div>
					</div>
                </li>             
               
                <li>
                <div class="dhtmlgoodies_question">NORWICH</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/factsheet/NORWICH.pdf">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/tabelleextraex/norwichextraex.pdf">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>pdf/tabellemusei/norwichtabellemusei.pdf">Museums</a>
					</div>
					</div>
                </li>
                
                     <li>
                <div class="dhtmlgoodies_question">PLYMOUTH</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/factsheet/PLYMOUTH.pdf">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/tabelleextraex/plymouthextraex.pdf">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>pdf/tabellemusei/plymouthtabellemusei.pdf">Museums</a>
					</div>
					</div>
                </li>
                
                <li>
                <div class="dhtmlgoodies_question">PORTSMOUTH</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/factsheet/PORTSMOUTH.pdf">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/tabelleextraex/portsmouthextraex.pdf">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>pdf/tabellemusei/portsmouthtabellemusei.pdf">Museums</a>
					</div>
					</div>
                </li>
                
                
                
                <li>
                     <div class="dhtmlgoodies_question">ST. ANDREWS</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/factsheet/STANDREWS.pdf">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/tabelleextraex/standrewsextraex.pdf">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>pdf/tabellemusei/standrewstabellemusei.pdf">Museums</a>
					</div>
					</div>
                </li>
               
                <li>
                	<div class="dhtmlgoodies_question">SHEFFIELD</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/factsheet/SHEFFIELD.pdf">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>pdf/tabellemusei/sheffieldtabellemusei.pdf">Museums</a>
					</div>
					</div>
                    
                    </li>
              
               
   
                
				</ul>
             </div>
			<div class="col_destinazioni" >
				<h3 class="tit_destinazioni">I R E L A N D</h3>
				<ul class="icodoc">
				
                <li>
                	<div class="dhtmlgoodies_question">DUBLIN</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/factsheet/DUBLIN.pdf">Campus Fact Sheet</a><br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Museums</a>
					</div>
					</div>
                    </li>
				
                <li>
                <div class="dhtmlgoodies_question">GALWAY</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/factsheet/GALWAY.pdf">Campus Fact Sheet</a><br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Museums</a>
					</div>
					</div>
                    </li>
                    
				<li>
                   <div class="dhtmlgoodies_question">MAYNOOTH</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/factsheet/MAYNOOTH.pdf">Campus Fact Sheet</a><br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Museums</a>
					</div>
					</div>
                    </li>
                          
				</ul>
				<h3 class="tit_destinazioni">E U R O P E</h3>
				<ul class="icodoc">
				 <li>
                <div class="dhtmlgoodies_question">MALTA</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Museums</a>
					</div>
					</div>
                    </li>
				
                </ul>
				<h3 class="tit_destinazioni">C A N A D A</h3>
				<ul class="icodoc">
				  <li>
                <div class="dhtmlgoodies_question">TORONTO</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Museums</a>
					</div>
					</div>
                    </li>
                    
		
                </ul>
				<h3 class="tit_destinazioni">U S A</h3>
				<ul class="icodoc">
				<li>
                	<div class="dhtmlgoodies_question">BOSTON</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Museums</a>
					</div>
					</div>
                    </li>
				
                <li>
                <div class="dhtmlgoodies_question">LOS ANGELES</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Museums</a>
					</div>
					</div>
                    </li>
                    
				<li>
                   <div class="dhtmlgoodies_question">NEW YORK RIDER</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Museums</a>
					</div>
					</div>
                 <li>
                <div class="dhtmlgoodies_question">NEW YORK DREW</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Museums</a>
					</div>
					</div>
                    </li>
                    
				<li>
                   <div class="dhtmlgoodies_question">ORLANDO</div>
					<div class="dhtmlgoodies_answer">
					<div>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="<?php echo base_url(); ?>	pdf/">Campus Fact Sheet</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Extra Excursion and Tranfers</a> <br>
						<img src="<?php echo base_url(); ?>images/iconpdf.jpg" style="margin:4px;"><a class="blu" href="#">Museums</a>
					</div>
					</div>    
				</ul>
			</div>
		</div>
	</div>

		<div id="right">
			<div id="up_gallery" style="background:#fff url('../../images/agenti_up_gallery.png') no-repeat; padding:5px 0 0 0; height:30px;"><h2>IMAGE LIBRARY</h2></div>
			<div id="text_gallery" style="padding:0 10px 0 10px; text-align:left; font-size:12px; background:#fff url('../../images/agenti_pattern_text.png') repeat-x; line-height:18px;">
			  <p><img src="../../images/gallery_general.png" ><br clear="all">
			    <strong>Welcome to PLUS IMAGE GALLERY!</strong> You can find a broad range of images of all our centres, cities, facilities, and students in our Image Library. This will be the ideal tool for choosing the best photos to prepare your own brochure and marketing material. How does it work? : Just click on the Categories you require and select the images you prefer. Then simply click "download" and the image will be automatically transferred to your computer. </p>
                
<p><a href="http://www.plus-ed.com/apps/index.php/agenti/gallery">Just click</a> on the Categories you require and select the images you prefer. Then simply click �download� and the image will be automatically transferred to your computer.</p>
			</div>
		</div>
	</div>
		<?php $this->load->view('agenti_footer');?></body>
</div>


</html>
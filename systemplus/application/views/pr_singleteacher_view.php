<?php $this->load->view('admin_header');?>
	<section id="main" class="column">
	<div id="box_radius">
		<h4 class="alert_info"><?php echo $heading; ?></h4>
		<article class="module width_full">
			<header><h3><?php echo $center; ?></h3></header>
				<div class="module_content">

<h1>Attendants Register</h1>
<ol>
<?php 
		
		
		
		if($teachers_check){
		/*** CICLO VALIDO SE IL TEACHER E' GIA PRESENTE IN PAYROLL *****/
		// Form
		echo "<form action=\"".base_url()."/index.php/payroll/singleupdate/".$this->uri->segment(3)."\" method=\"post\">";
		foreach($teachers_check as $item): 

		     list($anno_start, $mese_start, $giorno_start) = explode("-",$item['date_rif']);
			 $h = mktime(0, 0, 0, $mese_start, $giorno_start, $anno_start);
			 $d = date("F dS, Y", $h);
			 $w= date("l", $h);

			echo "Hour: <input type=\"text\" name=\"".$item['id']."\" size=1 value=\"".$item['work']."\"/>&nbsp; Date:" . $item['date_rif']." - ".$w."<br>Note:&nbsp;<input name=\"m_".$item['id']."\" value=\"".$item['motivi']."\">" ;
			echo "<hr>\n";
		echo "<br>";

		endforeach;
		}else{
		
		// Form
		echo "<form action=\"".base_url()."/index.php/payroll/singlewrite/".$this->uri->segment(3)."\" method=\"post\">";
		foreach($teachers as $item): 
		
		echo "<strong>";
			echo $item['cognome'] . " - " .$item['nome'] ."<br>";
			echo "<i>Contract Start " . $item['date_start'] ." - ";
			echo "Contract End " . $item['date_end'] . "</i><br>";
		echo "</strong>";		
		echo "<hr/>";
		
		/*********    
		Ciclo valido solo se è la prima volta che viene compilato     ********/


		// carico la data da controllare nelle 3 variabili
		list($anno_end, $mese_end, $giorno_end) = explode("-",$item['date_end']);
		list($anno_start, $mese_start, $giorno_start) = explode("-",$item['date_start']);

		// calcolo la differenza tra il timestamp della data definita e la data attuale
		// il risultato dovrò dividerlo per 86400 (il numero di secondi in un giorno)
		$differenza=(strtotime("$anno_end/$mese_end/$giorno_end") - strtotime($item['date_start']))/(86400); 

		// qui stampo giorni o giorno a seconda se la differenza è composta da 1 giorno o più giorni
		// funziona anche con i numeri negativi
		$pluraleosingolare = ((ceil(abs($differenza)>1)) or ceil($differenza)==0)?"giorni":"giorno";
		
		//echo "tra la data di inizio contratto ".$item['date_start']." e la data di fine $giorno_end/$mese_end/$anno_end la differenza è di $differenza $pluraleosingolare<br >";

		//Check day of the week
		$h = mktime(0, 0, 0, $mese_start, $giorno_start, $anno_start);
		$d = date("Y-m-d", $h) ;
		$w = date("l", $h);
		
		
		
		
		for($i=0; $i<=$differenza;$i++){
			$h = mktime(0, 0, 0, $mese_start, ($giorno_start)+$i, $anno_start);
			$w = date("l", $h);

			$data=date("Y-m-d",mktime(date("H"),date("i"),date("s"),date($mese_start),date($giorno_start)+$i,date($anno_start)));

		if($w != "Sunday" && $w != "Saturday"){
			echo $data . " - " . $w . "<br/><input type=\"text\" name=\"".$data."\" size=1 value=\"\"/>";
			
		}else{
			echo "(X) " . $data . " - " . $w;
		}
			echo "<hr/>\n";
		}
		
		/***************************************************************************************/
		echo "<br>";

		
		endforeach;
		} // CHIUDO ELSE "SE UTENTE E' NUOVO E NON PRESENTE IN PAYROLL
		
		// CHIUDI FORM
		echo "<input type=\"submit\" value=\"Submit\">";
		echo "</form>";

$this->load->view('footer_html5');

?>
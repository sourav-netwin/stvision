<html>
<head>
<title><?=$title?></title>

<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 14px;
 color: #4F5155;
}

a {
 color: #003399;
 background-color: transparent;
 font-weight: normal;
}

h1 {
 color: #444;
 background-color: transparent;
 border-bottom: 1px solid #D0D0D0;
 font-size: 16px;
 font-weight: bold;
 margin: 24px 0 2px 0;
 padding: 5px 0 6px 0;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 border: 1px solid #D0D0D0;
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}

</style>
</head>
<body>

<h1>try</h1>
<ol>
<?php 
		// Form
		echo "<form action=\"http://localhost/plus/apps/index.php/payroll/singlewrite/".$this->uri->segment(3)."\" method=\"post\">";
		foreach($teachers as $item): 
		/*
		echo "<strong>";
			echo $item['cognome'] . " - " .$item['nome'] ."<br>";
			echo "<i>Contract Start " . $item['date_start'] ." - ";
			echo "Contract End " . $item['date_end'] . "</i><br>";
		echo "</strong>";		
		echo "<hr/>";
		*/
		     list($anno_start, $mese_start, $giorno_start) = explode("-",$item['date_rif']);
			 $h = mktime(0, 0, 0, $mese_start, $giorno_start, $anno_start);
			 $d = date("F dS, Y", $h);
			 $w= date("l", $h);

			echo "<input type=\"text\" name=\"".$item['id']."\" size=1 value=\"".$item['work']."\"/>" . $item['date_rif']." - ".$w."";
			echo "<hr>\n";


		
		echo "<br>";

		endforeach;
		// CHIUDI FORM
		echo "<input type=\"submit\" value=\"invia i dati\">";
		echo "</form>";
?>
</ol>
</body>
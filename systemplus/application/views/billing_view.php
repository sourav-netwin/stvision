<html>
<head>
<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 11px;
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

h3 {
 color: #444;
 background-color: transparent;
 /* border-bottom: 1px solid #D0D0D0; */
 font-size: 11px;
 font-weight: bold;
 margin: 2px 0 2px 0;
 padding: 2px 0 6px 0;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 /* border: 1px solid #D0D0D0; */
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}

.mytable{
 margin: 14px 0 14px 0;
}

</style>
<title>Billing</title>
</head>
<body>
<img src="<?php echo base_url(); ?>images/up_contract.jpg"/>


<div style="margin:30px 10px 10px 10px; width:600px">

<?php 	
		foreach ($getcandidate as $nome){
		echo "Billing for: " . $nome['sex'] ."&nbsp;" . $nome['name'] . "&nbsp;" . $nome['surname'];
		
		echo "<br/>" . $nome['homeaddress'];
		echo "<br/><div style=\"float:right\"> " . date('l jS \of F Y') . "</div>";

		echo "<div class=\"mytable\"><strong>Centre</strong> " . $nome['location'] . "</div>";
		echo "<div class=\"mytable\"><strong>Start Date:</strong> " . $nome['datefrom_a'] . "</div>";
		echo "<div class=\"mytable\"><strong>End Date:</strong> " . $nome['dateto_a'] . "</div>";
		if($nome['locationassigned_b']){
		echo "<div class=\"mytable\"><strong>Second Centre</strong> " . $nome['locationassigned_b'] . "</div>";
		echo "<div class=\"mytable\"><strong>Start Date:</strong> " . $nome['datefrom_b'] . "</div>";
		echo "<div class=\"mytable\"><strong>End Date:</strong> " . $nome['dateto_b'] . "</div>";
		}
		echo "<div class=\"mytable\"><strong>Days Work:</strong>". $dwork ."</div>";
		echo "<div class=\"mytable\"><strong>Agreed Salary:</strong> £ " . $nome['cost01'] ." per week</div>";
		echo "<div class=\"mytable\"><strong>Billing:</strong> £ " . $somma ." </div>";
		}
?>
<p>
		
		<? echo "<div class=\"mytable\">Note:" . $nome['notes'] ." </div>"?>
		
		
</div>
<p><?php echo anchor('cms', 'Back to Home'); echo " | " . anchor('cms/panel_candidate/'. $this->uri->segment(3), 'Admin this contact'); ?></p>
</body>
</html>
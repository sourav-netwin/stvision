<?php
echo "<div class=\"innertable_left\">";
if (count($navlist)){

foreach ($navlist as $key=>$name){
echo "<div class=\"jobtype\"><img src=\"".base_url()."images/iconjob.png\"/>";
echo anchor("job/cat/$key",$name);
echo "</div>";

}

}
echo "</div>";
?>
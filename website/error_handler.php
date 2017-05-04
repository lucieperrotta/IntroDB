<?php 

if(isset($_GET["code"])) {
	echo '<div style="font-weight:bold;font-size:3em;text-align:center;">' . $_GET["code"];
	if(isset($_GET["cause"])){
		echo " on ". $_GET["cause"];
	}
	echo "</div>";
}
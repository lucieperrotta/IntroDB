<?php 

if(isset($_GET["code"])) {
	echo '<div style="font-weight:bold;font-size:3em;text-align:center;">' . $_GET["code"];
	if(isset($_GET["on"])){
		echo " on ". $_GET["on"];
		if(isset($_GET["cause"])){
			$cause = $_GET["cause"];
			if($cause=="duplicata"){
				echo " because of duplicata";
			}
			else if($cause=="isnull"){
				echo " because is null";
			}
			else if($cause=="notexist") {
				echo " because does not exist";
			}
			else if($cause=="notnumber") {
				echo " because is not a valid number";
			}
		}
	}
	echo "</div>";
}
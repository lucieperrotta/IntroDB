<?php 
try {
	$con = new PDO('mysql:host=localhost;dbname=grand_comics', 'root', '');
	//$con1 = new PDO('mysql:host=localhost;dbname=creaphy', 'root', '');
} catch (PDOException $e) {
	print "Error!: " . $e->getMessage() . "<br/>";
	die();
}
 ?>
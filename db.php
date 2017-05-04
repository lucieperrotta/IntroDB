<?php 
try {
	$con = new PDO('mysql:host=localhost;dbname=grand_comics', 'root', '');
	//$con1 = new PDO('mysql:host=localhost;dbname=creaphy', 'root', '');
} catch (PDOException $e) {
	print "Error!: " . $e->getMessage() . "<br/>";
	die();
}


/*Pour lancer une requet sql et la récupérer

$s = $con->query("SELECT * FROM story ORDER BY id DESC LIMIT 10");
$result = $s->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $key => $value) {
	var_dump($value);
}

*/
 ?>
 <?php


try {
	$con = new PDO('mysql:host=databases.000webhost.com;dbname=id1301038_grandcomics14', 'id1301038_grandcomics14', 'grandcomics14');
	//$con1 = new PDO('mysql:host=localhost;dbname=creaphy', 'root', '');
} catch (PDOException $e) {
	print "Error!: " . $e->getMessage() . "<br/>";
	die();
}


/*$file = fopen("comics/series.csv","r");

$max = 1000;
$i = 0;

var_dump(fgetcsv($file));

while(! feof($file)){
	$i++;
	$val = fgetcsv($file)[7];
	if(val == '') {
		var_dump(val);

	}
	if($i == $max) {
		break;
	}
}

fclose($file);*/
?> 


<?php 
include("../db.php");
include("../functions.php");
include("functions_todb.php");

$table = "country";


$code = parseDoubleQuote(htmlspecialchars($_POST["code"]));
$name= parseDoubleQuote(htmlspecialchars($_POST["name"]));

	// ------------ CHECK DUPLICATA AND EXIST
checkPrimaryKey($name, "name", $table, $con);
checkPrimaryKey($code, "code", $table, $con);
checkLength($code, 4, "code", $table);

		// ID
$id = getLastId($table,$con); 


$query = 'INSERT INTO country(id,code,name) VALUES(
'.$id.', '.$code.', '.$name.'
);';
var_dump($query);


$add_query = $con->query($query);
$add_query->fetchAll(PDO::FETCH_ASSOC);



header("Location: insert.php?currenttable=country&code=sucess");
exit();
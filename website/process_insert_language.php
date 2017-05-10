<?php 
include("../db.php");
include("../functions.php");
include("functions_todb.php");

$table = "language";

$code = parseDoubleQuote(htmlspecialchars($_POST["code"]));
$name= parseDoubleQuote(htmlspecialchars($_POST["name"]));

	// ------------ CHECK DUPLICATA AND EXIST
checkPrimaryKey($name, "name", $table, $con);
checkPrimaryKey($code, "code", $table, $con);
checkLength($code, 4, "code", $table);

// ID
$id = getLastId($table,$con); 


$query = 'INSERT INTO language(id,code,name) VALUES(
'.$id.', '.$code.', '.$name.'
);';

$add_query = $con->query($query);
$add_query->fetchAll(PDO::FETCH_ASSOC);



header("Location: insert.php?currenttable=language&code=sucess");
exit();
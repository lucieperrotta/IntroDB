<?php 
include("../db.php");
include("../functions.php");


$code = parseDoubleQuote(htmlspecialchars($_POST["code"]));
$name= parseDoubleQuote(htmlspecialchars($_POST["name"]));

	// ------------ CHECK DUPLICATA
$s = $con->query("SELECT id FROM country WHERE name='".$name."'"); // @todo compare better
$name_id = $s->fetchAll(PDO::FETCH_ASSOC);
if(!empty($name_id)) {
	header("Location: insert.php?currenttable=country&code=error&cause=duplicata&on=name"); exit();
}

		// ID
		// get higher id (cannot use AI because of foreignkey...)
$s = $con->query("SELECT MAX(id) FROM country");
$id_query = $s->fetchAll(PDO::FETCH_ASSOC);
$id = $id_query[0]["MAX(id)"] + 1;



$query = 'INSERT INTO country(id,code,name) VALUES(
'.$id.', '.$code.', '.$name.'
);';


$add_query = $con->query($query);
$s->fetchAll(PDO::FETCH_ASSOC);



header("Location: insert.php?currenttable=country&code=sucess");
exit();
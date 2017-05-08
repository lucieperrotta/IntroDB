<?php 
include("../db.php");
include("../functions.php");


$code = parseDoubleQuote(htmlspecialchars($_POST["code"]));
$name= parseDoubleQuote(htmlspecialchars($_POST["name"]));

	// ------------ CHECK DUPLICATA
$s = $con->query("SELECT id FROM language WHERE name=".$name); // @todo compare better
$name_id = $s->fetchAll(PDO::FETCH_ASSOC);
if(!empty($name_id)) {
	header("Location: insert.php?currenttable=language&code=error&cause=duplicata&on=name"); exit();
}

$s = $con->query("SELECT id FROM language WHERE code=".$code); // @todo compare better
$code_id = $s->fetchAll(PDO::FETCH_ASSOC);
if(!empty($code_id)) {
	header("Location: insert.php?currenttable=language&code=error&cause=duplicata&on=code"); exit();
}

// ID
// get higher id (cannot use AI because of foreignkey...)
$s = $con->query("SELECT MAX(id) FROM language");
$id_query = $s->fetchAll(PDO::FETCH_ASSOC);
$id = $id_query[0]["MAX(id)"] + 1;



$query = 'INSERT INTO language(id,code,name) VALUES(
'.$id.', '.$code.', '.$name.'
);';

$add_query = $con->query($query);
$s->fetchAll(PDO::FETCH_ASSOC);



header("Location: insert.php?currenttable=language&code=sucess");
exit();
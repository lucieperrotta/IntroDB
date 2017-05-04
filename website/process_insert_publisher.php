<?php 
include("../db.php");
include("../functions.php");


$name = parseDoubleQuote(htmlspecialchars($_POST["name"]));
$country_id = getInt(htmlspecialchars($_POST["country_id"]));
$year_began = getDateFromYear(htmlspecialchars($_POST["year_began"]));
$year_ended = getDateFromYear(htmlspecialchars($_POST["year_ended"]));
$notes = parseDoubleQuote(htmlspecialchars($_POST["notes"]));
$url = parseDoubleQuote(htmlspecialchars($_POST["website"]));


// -------------- CANNOT BE NULL
if($name=="NULL") {
	header("Location: insert.php?currenttable=publisher&code=error&cause=isnull&on=name");
	exit();
}
		// check no duplicata
$s = $con->query("SELECT id FROM publisher WHERE name='".$name."'"); // @todo compare better
$name_id = $s->fetchAll(PDO::FETCH_ASSOC);
if(!empty($name_id)) {
	header("Location: insert.php?currenttable=publisher&code=error&cause=duplicata&on=name"); exit();
}

// -------------HAVE TO EXIST
		// COUNTRY ID
if(!is_numeric($country_id)) {
	header("Location: insert.php?currenttable=publisher&code=error&cause=notnumber&on=country_id"); exit();
}
$s = $con->query("SELECT id FROM country WHERE id='".$country_id."'"); // @todo compare better
$country_id_check = $s->fetchAll(PDO::FETCH_ASSOC);
if(empty($country_id_check)) {
	header("Location: insert.php?currenttable=publisher&code=error&cause=notexist&on=country_id"); exit();
}


// --------------- CAN BE NULL BUT NOT A STRING
if($year_ended!="NULL" && !is_numeric($year_ended)) {
	header("Location: insert.php?currenttable=publisher&code=error&cause=notnumber&on=year_ended"); exit();
}
if($year_began!="NULL" && !is_numeric($year_began)) {
	header("Location: insert.php?currenttable=publisher&code=error&cause=notnumber&on=year_began"); exit();
}


$s = $con->query("SELECT MAX(id) FROM publisher");
$id_query = $s->fetchAll(PDO::FETCH_ASSOC);
$id = $id_query[0]["MAX(id)"] + 1;



		// WEBSITE
$s = $con->query("SELECT id FROM website WHERE url='".$url."'"); // @todo compare better
$url_id = $s->fetchAll(PDO::FETCH_ASSOC);
if(empty($url_id)) {
	$s = $con->query("SELECT MAX(id) FROM website");
	$url_id = $s->fetchAll(PDO::FETCH_ASSOC)[0]["MAX(id)"] + 1;;
	$s = $con->query('INSERT INTO website(id, url) VALUES('.$url_id.','.$url.')');
	$s->fetchAll(PDO::FETCH_ASSOC);
}


$query = 'INSERT INTO publisher(id, name, country_id, year_began, year_ended, notes, website_id) VALUES(
'.$id.','.$name.',
'.$country_id.',
'.$year_began.','.$year_ended.',
'.$notes.','.$url_id.'
);';

$add_query = $con->query($query);
$s->fetchAll(PDO::FETCH_ASSOC);


header("Location: insert.php?currenttable=publisher&code=sucess");
exit();
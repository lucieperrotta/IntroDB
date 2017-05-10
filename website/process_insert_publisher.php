<?php 
include("../db.php");
include("../functions.php");
include("functions_todb.php");

$table = "publisher";

$name = parseDoubleQuote(htmlspecialchars($_POST["name"]));
$country_id = getInt(htmlspecialchars($_POST["country_id"]));
$year_began = getDateFromYear(htmlspecialchars($_POST["year_began"]));
$year_ended = getDateFromYear(htmlspecialchars($_POST["year_ended"]));
$notes = parseDoubleQuote(htmlspecialchars($_POST["notes"]));
$url = parseDoubleQuote(htmlspecialchars($_POST["website"]));


// -------------- CANNOT BE NULL
checkPrimaryKey($name,"name",$table,$con);

// -------------HAVE TO EXIST AND NOT NULL
checkForeignKeyNotNull($country_id, "country","country_id",$table,$con);


// --------------- CAN BE NULL BUT NOT A STRING
checkDateFromFormNotNull($year_began,"year_began",$table);
checkDateFromForm($year_ended,"year_ended",$table);


$id = getLastId($table,$con);

$url_id = getWebsiteId($url, $con);


$query = 'INSERT INTO publisher(id, name, country_id, year_began, year_ended, notes, website_id) VALUES(
'.$id.','.$name.',
'.$country_id.',
'.$year_began.','.$year_ended.',
'.$notes.','.$url_id.'
);';

$add_query = $con->query($query);
$add_query->fetchAll(PDO::FETCH_ASSOC);


header("Location: insert.php?currenttable=".$table."&code=sucess");
exit();
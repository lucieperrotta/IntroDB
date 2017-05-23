<?php 
include("../db.php");
include("../functions.php");
include("functions_todb.php");

$table = "indicia_publisher";

$name = parseDoubleQuote(htmlspecialchars($_POST["name"]));
$publisher_id= getInt(htmlspecialchars($_POST["publisher_id"]));
$country_id = getInt(htmlspecialchars($_POST["country_id"]));
$year_began = getInt(htmlspecialchars($_POST["year_began"]));
$year_ended = getInt(htmlspecialchars($_POST["year_ended"]));
$is_surrogate = getInt(htmlspecialchars($_POST["is_surrogate"]));
$notes = parseDoubleQuote(htmlspecialchars($_POST["notes"]));
$url = parseDoubleQuote(htmlspecialchars($_POST["website"]));

checkDateFromForm($year_began,"year_began",$table);
checkDateFromForm($year_ended,"year_ended",$table);

// -------------- Primary Key
checkPrimaryKey($name,"name",$table,$con);

// -------------HAVE TO EXIST
checkForeignKeyNotNull($publisher_id, "publisher", "publisher_id", $table, $con);
checkForeignKeyNotNull($country_id, "country","country_id",$table,$con);


// -------- GET NEEDED ID
$url_id = getWebsiteId($url, $con);
$id = getLastId($table,$con);


$query = 'INSERT INTO indicia_publisher(id, name, publisher_id, country_id, year_began, year_ended, is_surrogate, notes, website_id) VALUES(
'.$id.','.$name.',
'.$publisher_id.',
'.$country_id.',
'.$year_began.','.$year_ended.',
'.$is_surrogate.',
'.$notes.','.$url_id.'
);';

$add_query = $con->query($query);
$add_query->fetchAll(PDO::FETCH_ASSOC);


header("Location: insert.php?currenttable=indicia_publisher&code=sucess");
exit();
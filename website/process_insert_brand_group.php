<?php 
include("../db.php");
include("../functions.php");
include("functions_todb.php");

$table = "brand_group";

$name = parseDoubleQuote(htmlspecialchars($_POST["name"]));
$year_began = htmlspecialchars($_POST["year_began"]);
$year_ended = htmlspecialchars($_POST["year_ended"]);
$notes = parseDoubleQuote(htmlspecialchars($_POST["notes"]));
$url = parseDoubleQuote(htmlspecialchars($_POST["website"]));
$publisher_id = getInt(htmlspecialchars($_POST["publisher_id"]));


// -------------- CANNOT BE NULL
checkPrimaryKey($name,"name",$table, $con);

checkDateFromForm($year_began,"year_began",$table);
checkDateFromForm($year_ended,"year_ended",$table);

// -------------HAVE TO EXIST
checkForeignKey($publisher_id, "publisher", "publisher_id", $table, $con);


// WEBSITE
$url_id = getWebsiteId($url, $con);
$id = getLastId($table,$con);


$query = 'INSERT INTO brand_group(id, name, year_began, year_ended, notes, website_id, publisher_id) VALUES(
'.$id.','.$name.','.$year_began.','.$year_ended.',
'.$notes.','.$url_id.','.$publisher_id.'
);';

$add_query = $con->query($query);
$add_query->fetchAll(PDO::FETCH_ASSOC);


header("Location: insert.php?currenttable=".$table."&code=sucess");
exit();
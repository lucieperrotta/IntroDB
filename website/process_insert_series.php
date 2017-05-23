<?php 
include("../db.php");
include("../functions.php");
include("functions_todb.php");

$table = "series";

$name = parseDoubleQuote(htmlspecialchars($_POST["name"]));

$year_began = getInt(htmlspecialchars($_POST["year_began"]));
$year_ended = getInt(htmlspecialchars($_POST["year_ended"]));

$first_issue_id = getInt(htmlspecialchars($_POST["first_issue_id"]));
$last_issue_id = getInt(htmlspecialchars($_POST["last_issue_id"]));
$publisher_id = getInt(htmlspecialchars($_POST["publisher_id"]));
$country_id = getInt(htmlspecialchars($_POST["country_id"]));
$language_id = getInt(htmlspecialchars($_POST["language_id"]));
$publication_type_id = getInt(htmlspecialchars($_POST["publication_type_id"]));

$format = parseDoubleQuote(htmlspecialchars($_POST["format"]));
$publication_dates = parseDoubleQuote(htmlspecialchars($_POST["publication_dates"]));
$color = parseDoubleQuote(htmlspecialchars($_POST["color"]));
$dimensions = parseDoubleQuote(htmlspecialchars($_POST["dimensions"]));
$paper_stock = parseDoubleQuote(htmlspecialchars($_POST["paper_stock"]));
$binding = parseDoubleQuote(htmlspecialchars($_POST["binding"]));
$publishing_format = parseDoubleQuote(htmlspecialchars($_POST["publishing_format"]));

$notes = parseDoubleQuote(htmlspecialchars($_POST["notes"]));

// null case not handled
checkPrimaryKey($name, "name", $table, $con);

checkDateFromForm($year_began,"year_began",$table);
checkDateFromForm($year_ended,"year_ended",$table);

// check validity
checkForeignKey($first_issue_id, "issue", "first_issue_id", $table, $con);
checkForeignKey($last_issue_id, "issue", "last_issue_id", $table, $con);
checkForeignKey($publisher_id, "publisher", "publisher_id", $table, $con);
checkForeignKey($country_id, "country", "country_id", $table, $con);
checkForeignKey($language_id, "language", "language_id", $table, $con);
checkForeignKey($publication_type_id, "series_publication_type", "publication_type_id", $table, $con);


// ID
$id = getLastId($table,$con);


$query = 'INSERT INTO series(id, name, format, year_began, year_ended, publication_dates, first_issue_id, last_issue_id, publisher_id, country_id, language_id, notes, color, dimensions, paper_stock, binding, publishing_format, publication_type_id) VALUES(
'.$id.',
'.$name.',
'.$format.',
'.$year_began.',
'.$year_ended.',
'.$publication_dates.',
'.$first_issue_id.',
'.$last_issue_id.',
'.$publisher_id.',
'.$country_id.',
'.$language_id.',
'.$notes.',
'.$color.',
'.$dimensions.',
'.$paper_stock.',
'.$binding.',
'.$publishing_format.',
'.$publication_type_id.'
);';

var_dump($query);

$add_query = $con->query($query);
$add_query->fetchAll(PDO::FETCH_ASSOC);

header("Location: insert.php?currenttable=".$table."&code=sucess");
exit();
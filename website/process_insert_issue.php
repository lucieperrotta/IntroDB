<?php 
include("../db.php");
include("../functions.php");
include("functions_todb.php");

$table = "issue";

$number = parseDoubleQuote(htmlspecialchars($_POST["number"]));
$series_id= getInt(htmlspecialchars($_POST["series_id"]));
$indicia_publisher_id = getInt(htmlspecialchars($_POST["indicia_publisher_id"]));
$publication_date = getDateFromYear(htmlspecialchars($_POST["publication_date"]));
$price = parseDoubleQuote(htmlspecialchars($_POST["price"]));
$page_count = getInt(htmlspecialchars($_POST["page_count"]));
$indicia_frequency = parseDoubleQuote(htmlspecialchars($_POST["indicia_frequency"]));
$editing = parseDoubleQuote(htmlspecialchars($_POST["editing"]));
$isbn = parseDoubleQuote(htmlspecialchars($_POST["isbn"]));
$valid_isbn = parseDoubleQuote(htmlspecialchars($_POST["valid_isbn"]));
$barcode = getInt(htmlspecialchars($_POST["barcode"]));
$notes = parseDoubleQuote(htmlspecialchars($_POST["notes"]));
$title = parseDoubleQuote(htmlspecialchars($_POST["title"]));
$on_sale_date = getInt(htmlspecialchars($_POST["on_sale_date"]));
$rating = parseDoubleQuote(htmlspecialchars($_POST["rating"]));

// HAVE TO EXIST AND NOT NULL
checkForeignKeyNotNull($series_id, "series", "series_id", $table, $con);

// check no duplicata
noDuplicata($title, "title",$table,$con);

// ------------- CAN BE NULL BUT NOT STRING
checkForeignKey($indicia_publisher_id, "indicia_publisher", "indicia_publisher_id", $table, $con);

// CHECK VALIDITY
checkIsNullOrInt($page_count, "page count", $table);
checkIsNullOrInt($barcode, "barcode", $table);
checkIsNullOrInt($on_sale_date, "sale date", $table);


// ID
$id = getLastId($table,$con);


		// Insert issue itself (o/w cannot insert into has_ table)
$query = 'INSERT INTO issue(id, number, series_id, indicia_publisher_id, publication_date, price, page_count, indicia_frequency, notes, isbn, valid_isbn, barcode,title, on_sale_date, rating) VALUES(
'.$id.','.$number.','.$series_id.','.$indicia_publisher_id.','.$publication_date.',
'.$price.','.$page_count.','.$indicia_frequency.','.$notes.',
'.$isbn.','.$valid_isbn.','.$barcode.','.$title.','.$on_sale_date.','.$rating.'
);';

$add_query = $con->query($query);
$add_query->fetchAll(PDO::FETCH_ASSOC);


		// Editing
  		// process editing if does not exist, otherwise get the id
$editing_array = parseNames($editing);
foreach ($editing_array as $p){
	$p = parseComments($p);
	$s = $con->query("SELECT id FROM artist WHERE name='".$p."'"); // @todo compare better
	$editing_id = $s->fetchAll(PDO::FETCH_ASSOC);
	if(empty($editing_id)) {
				// add in artist
		$s = $con->query("SELECT MAX(id) FROM artist");
		$editing_id = $s->fetchAll(PDO::FETCH_ASSOC)[0]["MAX(id)"] + 1;
		$s = $con->query('INSERT INTO artist(id, name) VALUES('.$editing_id.','.parseDoubleQuote($p).')');
		$s->fetchAll(PDO::FETCH_ASSOC);
	}
	else {
		$editing_id = $editing_id[0]["id"];
	}

			// add in has_editing
	$s = $con->query('INSERT INTO has_editing_issue(issue_id, artist_id) VALUES('.$id.','.$editing_id.')');
	$s->fetchAll(PDO::FETCH_ASSOC);


}

header("Location: insert.php?currenttable=issue&code=sucess");
exit();
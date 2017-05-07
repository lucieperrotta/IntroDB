<?php 
include("../db.php");
include("../functions.php");


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


	// ------------ HAVE TO EXIST
	// check no duplicata
$s = $con->query("SELECT id FROM issue WHERE title='".$title."'"); // @todo compare better
$title_id = $s->fetchAll(PDO::FETCH_ASSOC);
if(!empty($title_id)) {
	header("Location: insert.php?currenttable=issue&code=error&cause=duplicata&on=title"); exit();
}

		// ISSUE ID
		// check validity of issue id
if(!is_numeric($series_id)) {
	header("Location: insert.php?currenttable=issue&code=error&cause=notnumber&on=seriesid"); exit();
}
$s = $con->query("SELECT id FROM series WHERE id='".$series_id."'"); // @todo compare better
$series_id_check = $s->fetchAll(PDO::FETCH_ASSOC);
if(empty($series_id_check)) {
	header("Location: insert.php?currenttable=issue&code=error&cause=notexist&on=seriesid"); exit();
}


		// ------------- CAN BE NULL BUT NOT STRING
		// INDICIA_PUBLISHER_ID
		// check validity
if($indicia_publisher_id != "NULL" && !is_numeric($indicia_publisher_id)) {
	header("Location: insert.php?currenttable=issue&code=error&cause=notnumber&on=indicia_publisher_id"); exit();
}

		// PAGE COUNT
		// check validity
if($page_count != "NULL" && !is_numeric($page_count)) {
	header("Location: insert.php?currenttable=issue&code=error&cause=notnumber&on=page_count"); exit();
}

		// BARCODE
		// check validity
if($barcode != "NULL" && !is_numeric($barcode)) {
	header("Location: insert.php?currenttable=issue&code=error&cause=notnumber&on=barcode"); exit();
}

		// BARCODE
		// check validity
if($on_sale_date != "NULL" && !is_numeric($on_sale_date)) {
	header("Location: insert.php?currenttable=issue&code=error&cause=notnumber&on=on_sale_date"); exit();
}


		// ID
		// get higher id (cannot use AI because of foreignkey...)
$s = $con->query("SELECT MAX(id) FROM issue");
$id_query = $s->fetchAll(PDO::FETCH_ASSOC);
$id = $id_query[0]["MAX(id)"] + 1;



		// Insert issue itself (o/w cannot insert into has_ table)
$query = 'INSERT INTO issue(id, number, series_id, indicia_publisher_id, publication_date, price, page_count, indicia_frequency, notes, isbn, valid_isbn, barcode,title, on_sale_date, rating) VALUES(
'.$id.','.$number.','.$series_id.','.$indicia_publisher_id.','.$publication_date.',
'.$price.','.$page_count.','.$indicia_frequency.','.$notes.',
'.$isbn.','.$valid_isbn.','.$barcode.','.$title.','.$on_sale_date.','.$rating.'
);';

$add_query = $con->query($query);
$s->fetchAll(PDO::FETCH_ASSOC);


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
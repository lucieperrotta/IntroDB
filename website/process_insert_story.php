<?php 
include("../db.php");
include("../functions.php");


$title = parseDoubleQuote(htmlspecialchars($_POST["title"]));
$features= parseDoubleQuote(htmlspecialchars($_POST["features"]));
$issue_id = getInt(htmlspecialchars($_POST["issueId"]));
$letters = parseDoubleQuote(htmlspecialchars($_POST["letters"]));
$editing = parseDoubleQuote(htmlspecialchars($_POST["editing"]));
$inks = parseDoubleQuote(htmlspecialchars($_POST["inks"]));
$pencils = parseDoubleQuote(htmlspecialchars($_POST["pencils"]));
$script = parseDoubleQuote(htmlspecialchars($_POST["script"]));
$colors = parseDoubleQuote(htmlspecialchars($_POST["colors"]));
$synopsis = parseDoubleQuote(htmlspecialchars($_POST["synopsis"]));
$reprint_notes = parseDoubleQuote(htmlspecialchars($_POST["reprintNotes"]));
$notes = parseDoubleQuote(htmlspecialchars($_POST["notes"]));
$type = parseDoubleQuote(htmlspecialchars($_POST["type"]));
$character = parseDoubleQuote(htmlspecialchars($_POST["characters"]));

		// TITLE
		// null case not handled
if($title=="NULL") {
	header("Location: insert.php?currenttable=story&code=error&cause=isnull&on=title");
	exit();
}
		// check no duplicata
		$s = $con->query("SELECT id FROM story WHERE title='".$title."'"); // @todo compare better
		$title_id = $s->fetchAll(PDO::FETCH_ASSOC);
		if(!empty($title_id)) {
			header("Location: insert.php?currenttable=story&code=error&cause=duplicata&on=title"); exit();
		}

		// ISSUE ID
		// check validity of issue id
		if(!is_numeric($issue_id)) {
			header("Location: insert.php?currenttable=story&code=error&cause=notnumber&on=issueid"); exit();
		}
		$s = $con->query("SELECT id FROM issue WHERE id='".$issue_id."'"); // @todo compare better
		$issue_id_check = $s->fetchAll(PDO::FETCH_ASSOC);
		if(empty($issue_id_check)) {
			header("Location: insert.php?currenttable=story&code=error&cause=notexist&on=issueid"); exit();
		}


		// ID
		// get higher id (cannot use AI because of foreignkey...)
		$s = $con->query("SELECT MAX(id) FROM story");
		$id_query = $s->fetchAll(PDO::FETCH_ASSOC);
		$id = $id_query[0]["MAX(id)"] + 1;



		// TYPE
  		// process type if does not exist, otherwise get the type_id
		$s = $con->query("SELECT id FROM story_type WHERE name='".$type."'"); // @todo compare better
		$type_id = $s->fetchAll(PDO::FETCH_ASSOC);
		if(empty($type_id)) {
			$s = $con->query("SELECT MAX(id) FROM story_type");
			$type_id = $s->fetchAll(PDO::FETCH_ASSOC)[0]["MAX(id)"] + 1;;
			$s = $con->query('INSERT INTO story_type(id, name) VALUES('.$type_id.','.$type.')');
			$s->fetchAll(PDO::FETCH_ASSOC);
		}


		// Insert story itself (o/w cannot insert into has_ table)
		$query = 'INSERT INTO story(id, title, issue_id, synopsis, reprint_notes, notes, type_id) VALUES(
		'.$id.',
		'.$title.',
		'.$issue_id.',
		'.$synopsis.',
		'.$reprint_notes.',
		'.$notes.',
		'.$type_id.'
		);';

		$add_query = $con->query($query);
		$s->fetchAll(PDO::FETCH_ASSOC);


		// FEATURES
  		// process features if does not exist, otherwise get the id
		$features_array = parseNames($features);
		foreach ($features_array as $p){
			$p = parseComments($p);
			$s = $con->query("SELECT id FROM characters WHERE name='".$p."'"); // @todo compare better
			$feature_id = $s->fetchAll(PDO::FETCH_ASSOC);
			if(empty($feature_id)) {
				// add in artist
				$s = $con->query("SELECT MAX(id) FROM characters");
				$feature_id = $s->fetchAll(PDO::FETCH_ASSOC)[0]["MAX(id)"] + 1;
				$s = $con->query('INSERT INTO characters(id, name) VALUES('.$feature_id.','.parseDoubleQuote($p).')');
				$s->fetchAll(PDO::FETCH_ASSOC);
			}
			else {
				$feature_id = $feature_id[0]["id"];
			}

				// add in has_featured_characters
			$s = $con->query('INSERT INTO has_featured_characters(story_id, character_id) VALUES('.$id.','.$feature_id.')');
			$s->fetchAll(PDO::FETCH_ASSOC);
		}


		// Editing
  		// process editing if does not exist, otherwise get the id
		$editing_array = parseNames($features);
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
			$s = $con->query('INSERT INTO has_editing_story(story_id, artist_id) VALUES('.$id.','.$editing_id.')');
			$s->fetchAll(PDO::FETCH_ASSOC);

		}


		// Characters
  		// process characters if does not exist, otherwise get the id
		$character_array = parseNames($character);
		foreach ($character_array as $p){
			$p = parseComments($p);
			$s = $con->query("SELECT id FROM characters WHERE name='".$p."'"); // @todo compare better
			$character_id = $s->fetchAll(PDO::FETCH_ASSOC);
			if(empty($character_id)) {
				$s = $con->query("SELECT MAX(id) FROM characters");
				$character_id = $s->fetchAll(PDO::FETCH_ASSOC)[0]["MAX(id)"] + 1;
				$s = $con->query('INSERT INTO characters(id, name) VALUES('.$character_id.','.parseDoubleQuote($p).')');
				$s->fetchAll(PDO::FETCH_ASSOC);
			}
			else {
				$character_id = $character_id[0]["id"];
			}

			// add in has_characters
			$s = $con->query('INSERT INTO has_characters(story_id, character_id) VALUES('.$id.','.$character_id.')');
			$s->fetchAll(PDO::FETCH_ASSOC);

		}


		


		header("Location: insert.php?currenttable=story&code=sucess");
		exit();
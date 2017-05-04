<?php 
include("../db.php");
include("../functions.php");

if(isset($_POST["table"])){

	$table = $_POST["table"];

	if($table == "story"){

		// CHARACTER
		$title = parseDoubleQuote(htmlspecialchars($_POST["title"]));
		$features= parseDoubleQuote(htmlspecialchars($_POST["features"]));
		$issue_id = htmlspecialchars($_POST["issueId"]);
		$letters = parseDoubleQuote(htmlspecialchars($_POST["letters"]));
		$editing = parseDoubleQuote(htmlspecialchars($_POST["editing"]));
		$synopsis = parseDoubleQuote(htmlspecialchars($_POST["synopsis"]));
		$reprint_notes = parseDoubleQuote(htmlspecialchars($_POST["reprintNotes"]));
		$notes = parseDoubleQuote(htmlspecialchars($_POST["notes"]));
		$type = parseDoubleQuote(htmlspecialchars($_POST["type"]));


		// null case not handled
		if($title=="NULL") header("Location: insert.php?code=error&cause=title");


		// get higher id (cannot use AI because of foreignkey...)
		$s = $con->query("SELECT MAX(id) FROM story");
		$id_query = $s->fetchAll(PDO::FETCH_ASSOC);
		$id = $id_query[0]["MAX(id)"] + 1;



  		// process features if does not exist, otherwise get the id
		$features_array = parseNames($features);
		foreach ($features_array as $p){
			$p = parseComments($p);
			$s = $con->query("SELECT id FROM artist WHERE name='".$p."'"); // @todo compare better
			$feature_id = $s->fetchAll(PDO::FETCH_ASSOC);
			if(empty($feature_id)) {
				$s = $con->query("SELECT MAX(id) FROM artist");
				$a_id = $s->fetchAll(PDO::FETCH_ASSOC)[0]["MAX(id)"] + 1;
				$s = $con->query('INSERT INTO artist(id, name) VALUES('.$a_id.','.parseDoubleQuote($p).')');
				$s->fetchAll(PDO::FETCH_ASSOC);
			}

			// @todo add in has table
		}


  		// process type if does not exist, otherwise get the type_id
		$s = $con->query("SELECT id FROM story_type WHERE name='".$type."'"); // @todo compare better
		$type_id = $s->fetchAll(PDO::FETCH_ASSOC);
		if(empty($type_id)) {
			$s = $con->query("SELECT MAX(id) FROM story_type");
			$type_id = $s->fetchAll(PDO::FETCH_ASSOC)[0]["MAX(id)"] + 1;;
			$s = $con->query('INSERT INTO story_type(id, name) VALUES('.$type_id.','.$type.')');
			$s->fetchAll(PDO::FETCH_ASSOC);
		}



		$query = 'INSERT INTO story(id, title, features, issue_id, letters, editing, synopsis, reprint_notes, notes, type_id) VALUES(
		'.$id.',
		'.$title.',
		'.$features.',
		'.$issue_id.',
		'.$letters.',
		'.$editing.',
		'.$synopsis.',
		'.$reprint_notes.',
		'.$notes.',
		'.$type_id.'
		);';

		var_dump($query);

		$add_query = $con->query($query);
	}
}
else {
	header("Location: insert.php?code=error");
}


$s = $con->query("SELECT * FROM story ORDER BY id DESC LIMIT 10");
$result = $s->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $key => $value) {
	//var_dump($value);
}


//header("Location: insert.php?code=sucess");
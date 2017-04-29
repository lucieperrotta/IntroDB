<?php
include("db.php");
include("functions.php");

$file = fopen("comics/story.csv","r");
$mysql = fopen("story.sql", "w"); // write into this sql to import 


/*
date marche pas -> besoin que year
synospsis -> text
*/

$min = 0;
$max = 100;
$i = 0;

var_dump(fgetcsv($file));

/*'id' (length=2)
  1 => string 'title' (length=5)
  2 => string 'feature' (length=7)
  3 => string 'issue_id' (length=8)
  4 => string 'script' (length=6)
  5 => string 'pencils' (length=7)
  6 => string 'inks' (length=4)
  7 => string 'colors' (length=6)
  8 => string 'letters' (length=7)
  9 => string 'editing' (length=7)
  10 => string 'genre' (length=5)
  11 => string 'characters' (length=10)
  12 => string 'synopsis' (length=8)
  13 => string 'reprint_notes' (length=13)
  14 => string 'notes' (length=5)
  15 => string 'type_id' (length=7)
*/

  while(! feof($file)){
  	$i++;
  	$val = fgetcsv($file);

  	if($i > $min){

  		$id = getInt($val[0]);
  		$title = parseDoubleQuote($val[1]);
  		$features = parseDoubleQuote($val[2]);
  		$issue_id = getInt($val[3]);
  		$script = parseDoubleQuote($val[4]);
  		$pencils = parseDoubleQuote($val[5]);
  		$inks = parseDoubleQuote($val[6]);
  		$colors = parseDoubleQuote($val[7]);
  		$letters = parseDoubleQuote($val[8]);
  		$editing = parseDoubleQuote($val[9]);
  		$genre = parseDoubleQuote($val[10]);
  		$characters = parseDoubleQuote($val[11]);
  		$synopsis = parseDoubleQuote($val[12]);
  		$reprint_notes = parseDoubleQuote($val[13]);
  		$notes = parseDoubleQuote($val[14]);
  		$type_id = getInt($val[15]);

      // don't process null title stories
      if($title="NULL") continue;

      /*
      !!!!!!!!!!!!!!!
      PARSE script, pencils, inks, colors, characters, genre
      */

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

  	//var_dump($query);

      fwrite($mysql,$query);

  		//$s1 = $con->query($query);
  		/*var_dump($s1);*/

  		if($i==$max){
  			break;
  		}
  	}
  	
  }
//var_dump($s1->fetchAll(PDO::FETCH_ASSOC));

  /*$s = $con->query("SELECT * FROM story ORDER BY id DESC LIMIT 10");
  $result = $s->fetchAll(PDO::FETCH_ASSOC);
  var_dump($result);*/

  fclose($file);
  ?> 
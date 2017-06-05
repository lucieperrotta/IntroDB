<?php
include("db.php");
include("functions.php");

$file = fopen("comics/series.csv","r");
$mysql = fopen("series.csv", "w"); // write into this sql to import 


/*
date marche pas -> besoin que year
*/

$min = 52000; // 16375
$max = 56000; // 16603
$i = 0;

var_dump(fgetcsv($file));

/*
  0 => string 'id' (length=2)
  1 => string 'name' (length=4)
  2 => string 'format' (length=6)
  3 => string 'year_began' (length=10)
  4 => string 'year_ended' (length=10)
  5 => string 'publication_dates' (length=17)
  6 => string 'first_issue_id' (length=14)
  7 => string 'last_issue_id' (length=13)
  8 => string 'publisher_id' (length=12)
  9 => string 'country_id' (length=10)
  10 => string 'language_id' (length=11)
  11 => string 'notes' (length=5)
  12 => string 'color' (length=5)
  13 => string 'dimensions' (length=10)
  14 => string 'paper_stock' (length=11)
  15 => string 'binding' (length=7)
  16 => string 'publishing_format' (length=17)
  17 => string 'publication_type_id' (length=19)
*/

  while(! feof($file)){
  	$i++;
  	$val = fgetcsv($file);
  	if($i > $min){

  		$id = getInt($val[0]);
  		$name = parseDoubleQuote($val[1]);
  		$format = parseDoubleQuote($val[2]);
  		$year_began = parseDoubleQuote($val[3]);
  		$year_ended = parseDoubleQuote($val[4]);
  		$publication_dates = parseDoubleQuote($val[5]);
  		$first_issue_id = getInt($val[6]);
  		$last_issue_id = getInt($val[7]);
  		$publisher_id = getInt($val[8]);
  		$country_id = getInt($val[9]);
  		$language_id = getInt($val[10]);
  		$notes = parseDoubleQuote($val[11]);
  		$color = parseDoubleQuote($val[12]);
  		$dimensions = parseDoubleQuote($val[13]);
  		$paper_stock = parseDoubleQuote($val[14]);
  		$binding = parseDoubleQuote($val[15]);
  		$publishing_format = parseDoubleQuote($val[16]);
  		$publication_type_id = getInt($val[17]);

  		/*$query = 'INSERT INTO series(id, name, format, year_began, year_ended, publication_dates, first_issue_id, last_issue_id, publisher_id, country_id, language_id, notes, color, dimensions, paper_stock, binding, publishing_format, publication_type_id) VALUES(
  		'.$id.','.$name.','.$format.','.$year_began.',
  		'.$year_ended.','.$publication_dates.',
  		'.$first_issue_id.','.$last_issue_id.','.$publisher_id.','.$country_id.',
  		'.$language_id.','.$notes.',
  		'.$color.','.$dimensions.','.$paper_stock.','.$binding.',
  		'.$publishing_format.','.$publication_type_id.'
  		);';
*/

      $query = $id.','.$name.','.$format.','.$year_began.','.$year_ended.','.$publication_dates.','.$first_issue_id.','.$last_issue_id.','.$publisher_id.','.$country_id.','.$language_id.','.$notes.','.$color.','.$dimensions.','.$paper_stock.','.$binding.','.$publishing_format.','.$publication_type_id . '
';

  	//var_dump($query);

  		//print_r($query);
      fwrite($mysql,$query);

  		$s1 = $con->query($query);
  		/*var_dump($s1);*/

  		if($i==$max){
  			break;
  		}
  	}
  	
  }
//var_dump($s1->fetchAll(PDO::FETCH_ASSOC));

  /*$s = $con->query("SELECT * FROM series ORDER BY id DESC");
  var_dump($s->fetchAll(PDO::FETCH_ASSOC));*/

  fclose($file);
  ?> 
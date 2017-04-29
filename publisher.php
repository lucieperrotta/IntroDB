<?php
include("db.php");
include("functions.php");

$file = fopen("comics/publisher.csv","r");
$mysql = fopen("publisher.sql", "w"); // write into this sql to import 


/*
website id ->> mettre dans table website -> remettre foreign key
year -> date
*/

$min = 0;
$max = 2000;
$i = 0;

var_dump(fgetcsv($file));

/*
  0 => string 'id' (length=2)
  1 => string 'name' (length=4)
  2 => string 'country_id' (length=10)
  3 => string 'year_began' (length=10)
  4 => string 'year_ended' (length=10)
  5 => string 'notes' (length=5)
  6 => string 'url' (length=3)
*/

  while(! feof($file)){
  	$i++;
  	$val = fgetcsv($file);

  	if($i > $min){

  		$id = getInt($val[0]);
  		$name = parseDoubleQuote($val[1]);
  		$country_id = getInt($val[2]);
      $year_began = getDateFromYear($val[3]);
      $year_ended = getDateFromYear($val[4]);
      $notes = parseDoubleQuote($val[5]);
      $url = parseDoubleQuote($val[6]);

  		$query = 'INSERT INTO publisher(id, name, country_id, year_began, year_ended, notes, website_id) VALUES(
      '.$id.','.$name.',
      '.$country_id.',
  		'.$year_began.','.$year_ended.',
      '.$notes.','.$url.'
  		);';

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

  /*$s = $con->query("SELECT * FROM indicia_publisher ORDER BY id DESC LIMIT 10");
  $result = $s->fetchAll(PDO::FETCH_ASSOC);
  var_dump($result);*/

  fclose($file);
  ?> 
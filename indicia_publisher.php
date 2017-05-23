<?php
include("db.php");
include("functions.php");

$file = fopen("comics/indicia_publisher_id.csv","r");
$mysql = fopen("indicia_publisher.sql", "w"); // write into this sql to import 


/*
website id ->> mettre dans table website -> remettre foreign key
year -> date
*/

$min = 0;
$max = 10000000;
$i = 0;

var_dump(fgetcsv($file));

/*   0 => string 'id' (length=2)
  1 => string 'name' (length=4)
  2 => string 'publisher_id' (length=12)
  3 => string 'country_id' (length=10)
  4 => string 'year_began' (length=10)
  5 => string 'year_ended' (length=10)
  6 => string 'is_surrogate' (length=12)
  7 => string 'notes' (length=5)
  8 => string 'url' (length=3)
*/

  while(! feof($file)){
  	$i++;
  	$val = fgetcsv($file);

  	if($i > $min){

  		$id = getInt($val[0]);
  		$name = parseDoubleQuote($val[1]);
  		$publisher_id = getInt($val[2]);
  		$country_id = getInt($val[3]);
      $year_began = getDateFromYear($val[4]);
      $year_ended = getDateFromYear($val[5]);
      $is_surrogate = getInt($val[6]);
      $notes = parseDoubleQuote($val[7]);
      //$url = parseDoubleQuote($val[8]);
      $url = getInt($val[8]);


  		$query = 'INSERT INTO indicia_publisher(id, name, publisher_id, country_id, year_began, year_ended, is_surrogate, notes, website_id) VALUES(
      '.$id.','.$name.',
      '.$publisher_id.',
      '.$country_id.',
  		'.$year_began.','.$year_ended.',
      '.$is_surrogate.',
      '.$notes.','.$url.'
  		);';


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
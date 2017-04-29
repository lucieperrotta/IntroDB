<?php
include("db.php");
include("functions.php");

$file = fopen("comics/genre.csv","r");
$mysql = fopen("genre.sql", "w"); // write into this sql to import 


/*
website id ->> mettre dans table website -> remettre foreign key
year -> date
*/

$min = 0;
$max = 500;
$i = 0;

/*
  0 => string 'id' (length=2)
  1 => string 'code' (length=4)
  2 => string 'name' (length=4)
*/

  fwrite($mysql, "INSERT INTO genre(id,name) VALUES");

  while(! feof($file)){
  	$i++;
  	$val = fgetcsv($file);

  	if($i > $min){

  		$id = getInt($val[0]);
  		$name = parseDoubleQuote($val[1]);

      if($id=='id') continue;

      $query = '('.$id.','.$name.' ),
      ';

      fwrite($mysql,$query);

  		$s1 = $con->query($query);

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
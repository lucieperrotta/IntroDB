<?php
include("db.php");
include("functions.php");

$file = fopen("comics/story_reprint.csv","r");
$mysql = fopen("story_reprint.sql", "w"); // write into this sql to import 


/*
website id ->> mettre dans table website -> remettre foreign key
year -> date
*/

$min = 0;
$max = 500;
$i = 0;

var_dump(fgetcsv($file));

  fwrite($mysql, "INSERT INTO story_reprint(id,origin_id, target_id) VALUES");

  while(! feof($file)){
  	$i++;
  	$val = fgetcsv($file);

  	if($i > $min){

  		$id = getInt($val[0]);
  		$origin = getInt($val[1]);
  		$target = getInt($val[2]);

      if(empty($id)) continue;

  		$query = '('.$id.', '.$origin.', '.$target.' ),
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

  /*$s = $con->query("SELECT * FROM indicia_publisher ORDER BY id DESC LIMIT 10");
  $result = $s->fetchAll(PDO::FETCH_ASSOC);
  var_dump($result);*/

  fclose($file);
  ?> 
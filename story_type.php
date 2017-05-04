<?php
include("db.php");
include("functions.php");

$file = fopen("comics/story_type.csv","r");
$mysql = fopen("story_type.sql", "w"); // write into this sql to import 


/*
website id ->> mettre dans table website -> remettre foreign key
year -> date
*/

$min = 0;
$max = 500;
$i = 0;

var_dump(fgetcsv($file));

/*
  0 => string 'id' (length=2)
  1 => string 'code' (length=4)
  2 => string 'name' (length=4)

  @TODO unknown ?
*/

  while(! feof($file)){
  	$i++;
  	$val = fgetcsv($file);

  	if($i > $min){

  		$id = getInt($val[0]);
  		$name = parseDoubleQuote($val[1]);

      if($name != "(backcovers) *do not use* / *please fix*") {
        ïf($name != "(unknown)"){

          $query = 'INSERT INTO story_type(id,name) VALUES(
          '.$id.','.$name.'
          );';

          fwrite($mysql,$query);

        }
      }

      if($i==$max){
       break;
     }
   }

 }

 fclose($file);
 ?> 
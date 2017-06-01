<?php
include("db.php");
include("functions.php");

$file_c = fopen("comics/has_character.csv","r");
$mysql = fopen("has_character.sql", "w"); // write into this sql to import 

$min = 0;
$max = 200000000;
$i = 0;


while(! feof($file_c)){
  $i++;
  $val = fgetcsv($file_c);

  if($i > $min){

    $id = getInt($val[0]);
    $name = getInt($val[1]);

    $query = 'INSERT INTO has_characters(story_id,character_id) VALUES('.$id.','.$name.');
    ';

    fwrite($mysql,$query);

    $s1 = $con->query($query);

    if($i==$max){
      break;
    }
  }

}
fclose($file_c);

?> 
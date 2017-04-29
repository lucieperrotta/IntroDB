<?php
include("db.php");
include("functions.php");

$file = fopen("comics/has_featured_characters.csv","r");
$mysql = fopen("has_featured_characters.sql", "w"); // write into this sql to import 

$min = 0;
$max = 20;
$i = 0;

while(! feof($file)){
  $i++;
  $val = fgetcsv($file);

  if($i > $min){

    $id = getInt($val[0]);
    $name = parseDoubleQuote($val[1]);

    $query = 'INSERT INTO has_featured_characters(story_id,character_id) VALUES(
    '.$id.','.$name.');
    ';

    fwrite($mysql,$query);

    $s1 = $con->query($query);

    if($i==$max){
      break;
    }
  }
  
}
fclose($file);

?> 
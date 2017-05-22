<?php
include("db.php");
include("functions.php");

$file = fopen("comics/character.csv","r");
$mysql = fopen("character.sql", "w"); // write into this sql to import 

$min = 0;
$max = 10000000;
$i = 0;

while(! feof($file)){
  $i++;
  $val = fgetcsv($file);

  if($i > $min){

    $id = getInt($val[0]);
    $name = parseDoubleQuote($val[1]);

    $query = 'INSERT INTO characters(id,name) VALUES(
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
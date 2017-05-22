<?php
include("db.php");
include("functions.php");

$file = fopen("comics/has_genre.csv","r");
$mysql = fopen("has_genre.sql", "w"); // write into this sql to import 


/*
website id ->> mettre dans table website -> remettre foreign key
year -> date
*/

$min = 0;
$max = 10000000000000;
$i = 0;

fwrite($mysql, "INSERT INTO has_genre(story_id,genre_id) VALUES");

while(! feof($file)){
 $i++;
 $val = fgetcsv($file);

 if($i > $min){

  $s_id = getInt($val[0]);
  $g_id = getInt($val[1]);

  if($s_id=="id") continue;

  $query = '('.$s_id.','.$g_id.' ),
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
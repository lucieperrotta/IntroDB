<?php
include("db.php");
include("functions.php");

$file = fopen("comics/story.csv","r");
$csv = fopen("comics/genre.csv", "a+"); 

echo "<h1>Genre</h1>";

$index = getLastIndex($csv);

$min = 0;
$max = 10000;
$i = 0;

var_dump(fgetcsv($file));

while(! feof($file)){
  $i++;
  $val = fgetcsv($file);

  if($i > $min){

    $genre = parseDoubleQuote($val[10]);
    if($genre!="NULL"){
      $genre_array = parseNames($genre);
      $lastp = "";
      foreach ($genre_array as $p){
        //$p = parseComments($p);
        if($p==$lastp) continue;
        if(!isInCsvName($csv, $p,1)) {
          $add = $index . ",".$p."\n";
          fwrite($csv, $add);
          $index++;
          $lastp = $p;
        }
      }
    }

    /*var_dump($s1);*/

    if($i==$max){
      break;
    }
  }

}
//var_dump($s1->fetchAll(PDO::FETCH_ASSOC));

  /*$s = $con->query("SELECT * FROM story ORDER BY id DESC LIMIT 10");
  $result = $s->fetchAll(PDO::FETCH_ASSOC);
  var_dump($result);*/

  fclose($file);
  fclose($csv);


  ?> 
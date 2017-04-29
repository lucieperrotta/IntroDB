<?php
include("db.php");
include("functions.php");

$file = fopen("comics/story.csv","r");
$csv = fopen("comics/genre.csv", "a+"); 
$has_csv = fopen("comics/has_genre.csv", "w+"); 

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

    $id = getInt($val[0]);
    $genre = parseDoubleQuote($val[10]);

    if($genre!="NULL"){
      $genre_array = parseNames($genre);
      foreach ($genre_array as $p){
        $p = parseComments($p);
        $exist = isInCsvName($csv, $p,1);
        if(!is_numeric($exist)) {
          $add = $index . ",".$p."\n";
          fwrite($csv, $add);

          // has_
          $query = $id.",".$index ."\n";
          fwrite($csv, $add);

          $index++;
        }
        else {

          $query = $id.",".$exist ."\n";
          fwrite($has_csv, $query);
        }
      }
    }


    if($i==$max){
      break;
    }
  }

}

fclose($file);
fclose($csv);


?> 
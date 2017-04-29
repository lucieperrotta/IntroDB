<?php
include("db.php");
include("functions.php");

$file = fopen("comics/story.csv","r");
$csv = fopen("comics/character.csv", "a+"); 
$has_csv = fopen("comics/has_character.csv","w+");

echo "<h1>Characters</h1>";

$index = getLastIndex($csv);

$min = 0;
$max = 2000;
$i = 0;

/*
@TODO process "and" ?
*/

var_dump(fgetcsv($file));

while(! feof($file)){
  $i++;
  $val = fgetcsv($file);

  if($i > $min){

    $id = getInt($val[0]);
    $character = parseDoubleQuote($val[11]);
    //$editing = parseDoubleQuote($val[9]);
    
    if($character!="NULL"){
      $character_array = parseNames($character);
      foreach ($character_array as $p){
        $p = parseComments($p);
        $exist = isInCsvName($csv, $p,1);
        if(!is_numeric($exist)) {
          $add = $index . ",".$p."\n";
          fwrite($csv, $add);

          // has_
          $query = $id.",".$index ."\n";
          fwrite($has_csv, $query);

          $index++;
        }
        else {
          // author exist thus we can add in has_
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
//var_dump($s1->fetchAll(PDO::FETCH_ASSOC));

  /*$s = $con->query("SELECT * FROM story ORDER BY id DESC LIMIT 10");
  $result = $s->fetchAll(PDO::FETCH_ASSOC);
  var_dump($result);*/

  fclose($file);
  fclose($csv);


  ?> 
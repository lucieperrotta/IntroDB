<?php
include("db.php");
include("functions.php");

$file = fopen("comics/story.csv","r");
$csv = fopen("comics/character.csv", "a+"); 

echo "<h1>Characters</h1>";

$index = getLastIndex($csv);

$min = 0;
$max = 1000;
$i = 0;

var_dump(fgetcsv($file));

while(! feof($file)){
  $i++;
  $val = fgetcsv($file);

  if($i > $min){

    $character = parseDoubleQuote($val[11]);
    //$editing = parseDoubleQuote($val[9]);
    
    // use lastp to speed up the query, since artists are close to each other in the csv file
    if($character!="NULL"){
      $character_array = parseNames($character);
      $lastp = "";
      foreach ($character_array as $p){
        $p = parseComments($p);
        if($p==$lastp) continue;
        if(!isInCsvName($csv, $p,1)) {
          $add = $index . ",".$p."\n";
          fwrite($csv, $add);
          $index++;
          $lastp = $p;
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
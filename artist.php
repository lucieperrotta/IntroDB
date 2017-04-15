<?php
include("db.php");
include("functions.php");

$file = fopen("comics/story.csv","r");
$csv = fopen("comics/artist.csv", "a+"); 

echo "<h1>Artists</h1>";

$index = getLastIndex($csv);

$min = 0;
$max = 200;
$i = 0;

var_dump(fgetcsv($file));

while(! feof($file)){
  $i++;
  $val = fgetcsv($file);

  if($i > $min){

    $script = parseDoubleQuote($val[4]);
    $pencils = parseDoubleQuote($val[5]);
    $inks = parseDoubleQuote($val[6]);
    $colors = parseDoubleQuote($val[7]);
    $letters = parseDoubleQuote($val[8]);
    //$editing = parseDoubleQuote($val[9]);
    
    // use lastp to speed up the query, since artists are close to each other in the csv file
    if($script!="NULL"){
      $script_array = parseNames($script);
      $lastp = "";
      foreach ($script_array as $p){
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

    if($pencils!="NULL"){
      $p_array = parseNames($pencils);
      $lastp = "";
      foreach ($p_array as $p){
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

    if($inks!="NULL"){
      $inks_array = parseNames($inks);
      $lastp = "";
      foreach ($inks_array as $p){
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

    if($colors!="NULL"){
      $colors_array = parseNames($colors);
      $lastp = "";
      foreach ($colors_array as $p){
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

    if($letters!="NULL"){
      $letters_array = parseNames($letters);
      $lastp = "";
      foreach ($letters_array as $p){
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
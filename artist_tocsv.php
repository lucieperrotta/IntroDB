<?php

include("db.php");
include("functions.php");

$csv = fopen("comics/artist.csv", "a+"); 
$file = fopen("comics/story.csv","r");
$has_script = fopen("comics/has_script.csv", "w+"); 
$has_colors = fopen("comics/has_colors.csv", "w+"); 
$has_pencils = fopen("comics/has_pencils.csv", "w+"); 
$has_inks = fopen("comics/has_inks.csv", "w+"); 
$has_letters = fopen("comics/has_letters.csv", "w+"); 

echo "<h1>Artists to csv</h1>";
echo "<h2>Don't forget to delete artist otherwise it is false !!</h2>";

$index = getLastIndex($csv);

$min = 0;
$max = 20;
$i = 0;

var_dump(fgetcsv($file));

while(! feof($file)){
  $i++;
  $val = fgetcsv($file);
  /*var_dump($val);*/

  if($i > $min){

    $id = getInt($val[0]);
    $script = parseDoubleQuote($val[4]);
    $pencils = parseDoubleQuote($val[5]);
    $inks = parseDoubleQuote($val[6]);
    $colors = parseDoubleQuote($val[7]);
    $letters = parseDoubleQuote($val[8]);

    //$editing = parseDoubleQuote($val[9]);
    
    if($script!="NULL"){
      $script_array = parseNames($script);
      foreach ($script_array as $p){
        $p = parseComments($p);
        $exist = isInCsvName($csv, $p,1);

        if(!is_numeric($exist)) {
          // if author does not exist, add it in csv and has_
          $add = $index . ",".$p."\n";
          fwrite($csv, $add);

          // has_script
          $query = $id.",".$index ."\n";
          fwrite($has_script, $query);

          $index++;
        }
        else {
          // author exist thus we can add in has_
          $query = $id.",".$exist ."\n";
          fwrite($has_script, $query);
        }
      }
    }

    if($pencils!="NULL"){
      $pencils_array = parseNames($pencils);
      foreach ($pencils_array as $p){
        $p = parseComments($p);
        $exist = isInCsvName($csv, $p,1);
        if(!is_numeric($exist)) {
          $add = $index . ",".$p."\n";
          fwrite($csv, $add);

          $query = $id.",".$index ."\n";
          fwrite($has_pencils, $query);

          $index++;
        }
        else {
          // author exist thus we can add in has_
          $query = $id.",".$exist ."\n";
          fwrite($has_pencils, $query);
        }
      }
    }

    if($inks!="NULL"){
      $inks_array = parseNames($inks);
      foreach ($inks_array as $p){
        $p = parseComments($p);
        $exist = isInCsvName($csv, $p,1);
        if(!is_numeric($exist)) {
          $add = $index . ",".$p."\n";
          fwrite($csv, $add);

          $query = $id.",".$index ."\n";
          fwrite($has_inks, $query);

          $index++;
        }
        else {
          // author exist thus we can add in has_
          $query = $id.",".$exist ."\n";
          fwrite($has_inks, $query);
        }
      }
    }

    if($colors!="NULL"){
      $colors_array = parseNames($colors);
      foreach ($colors_array as $p){
        $p = parseComments($p);
        $exist = isInCsvName($csv, $p,1);
        if(!is_numeric($exist)) {
          $add = $index . ",".$p."\n";
          fwrite($csv, $add);

          $query = $id.",".$index ."\n";
          fwrite($has_colors, $query);

          $index++;
        }
        else {
          // author exist thus we can add in has_
          $query = $id.",".$exist ."\n";
          fwrite($has_colors, $query);
        }
      }
    }

    if($letters!="NULL"){
      $letters_array = parseNames($letters);
      foreach ($letters_array as $p){
        $p = parseComments($p);
        $exist = isInCsvName($csv, $p,1);
        if(!is_numeric($exist)) {
          $add = $index . ",".$p."\n";
          fwrite($csv, $add);

          $query = $id.",".$index ."\n";
          fwrite($has_letters, $query);

          $index++;
        }
        else {
          // author exist thus we can add in has_
          $query = $id.",".$exist ."\n";
          fwrite($has_letters, $query);
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
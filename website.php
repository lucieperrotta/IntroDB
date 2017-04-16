<?php
include("db.php");
include("functions.php");

$files = array("comics/brand_group.csv" => 5 , "comics/indicia_publisher.csv" => 8, "comics/publisher.csv" => 6);
$csv = fopen("comics/website.csv", "a+"); // write into this sql to import 

echo "<h1>Websites</h1>";

$index = getLastIndex($csv);

$min = 0;
$max = 1000000;
$i = 0;

// get websites from all given files
foreach ($files as $f => $pos) {
  $file = fopen($f,"r");

  while(! feof($file)){
    $i++;
    $val = fgetcsv($file);

    if($i > $min){

      $url = $val[$pos];

      // if the websie 
      if(!parseNullValueWebsite($url)){
        if(isInCsv($csv, $url,1)===false) {
          $add = $index . ",".$url."\n";
          fwrite($csv, $add);
          $index++;
        }
      }
    }


    if($i==$max){
      return;
    }

  }
  fclose($file);

}

fclose($csv);


?> 
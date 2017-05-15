<?php
include("db.php");
include("functions.php");

$files = array("comics/brand_group.csv" => 5 , "comics/indicia_publisher.csv" => 8, "comics/publisher.csv" => 6);
$filesnames = array("comics/brand_group.csv" => "comics/brand_group_id.csv" , "comics/indicia_publisher.csv" => "comics/indicia_publisher_id.csv", "comics/publisher.csv" => "comics/publisher_id.csv");
$csv = fopen("comics/website.csv", "r"); // write into this sql to import 

echo "<h1>Websites to id</h1>";
echo "<h2>Don't forget to run websites script first !!</h2>";

$index = getLastIndex($csv);

$min = 0;
$max = 1000000000;

// get websites from all given files
foreach ($files as $f => $pos) {
  $i = 0;
  $file = fopen($f,"r");
  $out = implode(",",fgetcsv($file))."\n";

  while(! feof($file) && ($i<$max)){
    $i++;
    $val = fgetcsv($file);

    if($i > $min){

      $url = $val[$pos];

      if(!parseNullValue($url)){
        $index = isInCsvName($csv, $url,1);
        $val[$pos] = $index;
      }

      //var_dump($val);
      $out .= implode(",",$val)."\n";

      if($i>$max) break;
    }

  }
  fclose($file);
  file_put_contents($filesnames[$f], $out);

}

fclose($csv);

?> 
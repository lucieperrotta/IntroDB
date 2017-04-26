<?php
include("db.php");
include("functions.php");

$f = "comics/story.csv";
$res = "comics/story_id.csv";
$has_script = fopen("comics/has_script.csv", "w+"); 
$csv = fopen("comics/artist.csv", "r"); // write into this sql to import 

echo "<h1>Story to id</h1>";
echo "<h2>Don't forget to run websites script first !!</h2>";

$index = getLastIndex($csv);

$min = 0;
$max = 10;
$i = 0;

$pos = 4;


// get websites from all given files
$file = fopen($f,"r");
$out = "";

while(! feof($file) && ($i<$max)){
  $i++;
  $val = fgetcsv($file);
  var_dump($val);

  if($i > $min){

    $url = $val[$pos];
    $id = $val[0];

    if($id == "id") continue;

    if(!parseNullValue($url)){
      $index = isInCsv($csv, $url,1);
      $val[$pos] = $index;

      // has_script
      $query = $id.",".$index ."\n";
      fwrite($has_script, $query);
    }

      //var_dump($val);
    $out .= implode(",",$val)."\n";


    if($i>$max) break;
  }

}
fclose($file);
file_put_contents($res, $out);


fclose($csv);
fclose($has_script);

?> 
<?php
include("db.php");
include("functions.php");

$file = fopen("comics/story.csv","r");
$mysql = fopen("story.sql", "w"); // write into this sql to import 


$min = 783000;
$max = 785001;
$i = 0;

var_dump(fgetcsv($file));

while(! feof($file)){
 $i++;
 $val = fgetcsv($file);

 if($i > $min){

  $id = getInt($val[0]);
  $title = parseDoubleQuote($val[1]);
  $issue_id = getInt($val[3]);
  $synopsis = parseDoubleQuote($val[12]);
  $reprint_notes = parseDoubleQuote($val[13]);
  $notes = parseDoubleQuote($val[14]);
  $type_id = getInt($val[15]);

  if($type_id==3) {
      $type_id = "NULL"; // backover do not use
    }

    $query = 'INSERT INTO story(id, title, issue_id, synopsis, reprint_notes, notes, type_id) VALUES(
    '.$id.','.$title.', '.$issue_id.','.$synopsis.','.$reprint_notes.','.$notes.','.$type_id.');
    ';

  	//var_dump($query);

    fwrite($mysql,$query);

    if($i==$max){
     break;
   }
 }


}

fclose($file);
?> 
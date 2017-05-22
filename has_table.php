<?php
include("db.php");
include("functions.php");

$mysql = fopen("has_table.sql", "w"); // write into this sql to import 

$min = 0;
$max = 1000000000000;

 
// script
/*$i = 0;
$file = fopen("comics/has_script.csv","r");
while(! feof($file)){
  $i++;
  $val = fgetcsv($file);

  if($i > $min){
    $s_id = getInt($val[0]);
    $a_id = getInt($val[1]);

    if(!is_numeric($s_id)) continue;

    $query = '('.$s_id.','. $a_id.' );
    ';

    fwrite($mysql, "INSERT INTO has_script(story_id,artist_id) VALUES");
    fwrite($mysql,$query);

    if($i==$max){
      break;
    }
  }
}
fclose($file);*/

// colors
/*$i = 0;
$file = fopen("comics/has_colors.csv","r");
while(! feof($file)){
  $i++;
  $val = fgetcsv($file);

  if($i > $min){
    $s_id = getInt($val[0]);
    $a_id = getInt($val[1]);

    if(!is_numeric($s_id)) continue;

    $query = '('.$s_id.','. $a_id.' );
    ';

    fwrite($mysql, "INSERT INTO has_colors(story_id,artist_id) VALUES");
    fwrite($mysql,$query);

    if($i==$max){
      break;
    }
  }
}
fclose($file);*/

// inks
/*$i = 0;
$file = fopen("comics/has_inks.csv","r");
while(! feof($file)){
  $i++;
  $val = fgetcsv($file);

  if($i > $min){
    $s_id = getInt($val[0]);
    $a_id = getInt($val[1]);

    if(!is_numeric($s_id)) continue;

    $query = '('.$s_id.','. $a_id.' );
    ';

    fwrite($mysql, "INSERT INTO has_inks(story_id,artist_id) VALUES");
    fwrite($mysql,$query);

    if($i==$max){
      break;
    }
  }
}
fclose($file);*/


// pencils
/*$i = 0;
$file = fopen("comics/has_pencils.csv","r");
while(! feof($file)){
  $i++;
  $val = fgetcsv($file);

  if($i > $min){
    $s_id = getInt($val[0]);
    $a_id = getInt($val[1]);

    if(!is_numeric($s_id)) continue;

    $query = '('.$s_id.','. $a_id.' );
    ';

    fwrite($mysql, "INSERT INTO has_pencils(story_id,artist_id) VALUES");
    fwrite($mysql,$query);

    if($i==$max){
      break;
    }
  }
}
fclose($file);*/


// letters
/*$i = 0;
$file = fopen("comics/has_letters.csv","r");
while(! feof($file)){
  $i++;
  $val = fgetcsv($file);

  if($i > $min){
    $s_id = getInt($val[0]);
    $a_id = getInt($val[1]);

    if(!is_numeric($s_id)) continue;

    $query = '('.$s_id.','. $a_id.' );
    ';
    fwrite($mysql, "INSERT INTO has_letters(story_id,artist_id) VALUES");
    fwrite($mysql,$query);

    if($i==$max){
      break;
    }
  }
}
fclose($file);*/


// editing
/*$i = 0;
$file = fopen("comics/has_editing_story.csv","r");
while(! feof($file)){
  $i++;
  $val = fgetcsv($file);

  if($i > $min){
    $s_id = getInt($val[0]);
    $a_id = getInt($val[1]);

    if(!is_numeric($s_id)) continue;

    $query = '('.$s_id.','. $a_id.' );
    ';
    fwrite($mysql, "INSERT INTO has_editing_story(story_id,artist_id) VALUES");
    fwrite($mysql,$query);

    if($i==$max){
      break;
    }
  }
}
fclose($file);*/


// editing
$i = 0;
$file = fopen("comics/has_editing_issue.csv","r");
while(! feof($file)){
  $i++;
  $val = fgetcsv($file);

  if($i > $min){
    $s_id = getInt($val[0]);
    $a_id = getInt($val[1]);

    if(!is_numeric($s_id)) continue;

    $query = '('.$s_id.','. $a_id.' );
    ';
    fwrite($mysql, "INSERT INTO has_editing_issue(issue_id,artist_id) VALUES");
    fwrite($mysql,$query);

    if($i==$max){
      break;
    }
  }
}
fclose($file);

?> 
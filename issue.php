<?php

include("db.php");
include("functions.php");

$file = fopen("comics/issue.csv","r");
$mysql = fopen("issue.sql", "w"); // write into this sql to import 
/*
date marche pas -> besoin que year

rating and number varchar
isbn, valid isbn become varchar

*/


// to test and not print/insert all lines
$min = 210024;
$max = 220024;
$i = 0;


// print first line to show columns
var_dump(fgetcsv($file));

// disable check of foreign key
//print_r("set foreign_key_checks=0;");

while(! feof($file)){
	$i++;
	$val = fgetcsv($file);


	if($i > $min) {

		/*
	 'id' (length=2)
	  1 => string 'number' (length=6)
	  2 => string 'series_id' (length=9)
	  3 => string 'indicia_publisher_id' (length=20)
	  4 => string 'publication_date' (length=16)
	  5 => string 'price' (length=5)
	  6 => string 'page_count' (length=10)
	  7 => string 'indicia_frequency' (length=17)
	  8 => string 'editing' (length=7)
	  9 => string 'notes' (length=5)
	  10 => string 'isbn' (length=4)
	  11 => string 'valid_isbn' (length=10)
	  12 => string 'barcode' (length=7)
	  13 => string 'title' (length=5)
	  14 => string 'on_sale_date' (length=12)
	  15 => string 'rating' (length=6)
		*/
	  
	  //if($i==1) var_dump($val);

	  $id = getInt($val[0]);
	  $number = parseDoubleQuote($val[1]);
	  $series_id = getInt($val[2]);
	  $indicia_publisher_id = getInt($val[3]);
	  $publication_date = getDateFromYear($val[4]);
	  $price = parseDoubleQuote($val[5]);
	  $page_count = getInt($val[6]);
	  $indicia_frequency = parseDoubleQuote($val[7]);
	  $notes = parseDoubleQuote($val[9]);
	  $isbn = parseDoubleQuote($val[10]);
	  $valid_isbn = parseDoubleQuote($val[11]);
	  $barcode = getInt($val[12]);
	  $title = parseDoubleQuote($val[13]);
	  $on_sale_date = getDateFromYear($val[14]);
	  $rating = parseDoubleQuote($val[15]);

	// to debug, var_dump query or $con->query(query) -> should print a PDO object and not true or false (je crois que true veut dire qu'elle existe et false c'est qu'il y a une erreur) -> c/c une query dans sql dans phpmyadmin va te donner des indications sur pk ça fail

	  $query = 'INSERT INTO issue(id, number, series_id, indicia_publisher_id, publication_date, price, page_count, indicia_frequency, notes, isbn, valid_isbn, barcode,title, on_sale_date, rating) VALUES(
	  '.$id.','.$number.','.$series_id.','.$indicia_publisher_id.','.$publication_date.',
	  '.$price.','.$page_count.','.$indicia_frequency.','.$notes.',
	  '.$isbn.','.$valid_isbn.','.$barcode.','.$title.','.$on_sale_date.','.$rating.'
	  );';


	  //if($id==36382) {var_dump($query);var_dump($val);var_dump($i);break;};

  	fwrite($mysql,$query);

  	//var_dump($query);
  	/*$s1 = $con->query($query);

  	var_dump($s1);*/

  	//print_r($query);

  	if($i>$max) break;

  }
}

// print last 10 entries
/*$s = $con->query("SELECT * FROM issue ORDER BY id DESC LIMIT 10");
var_dump($s->fetchAll(PDO::FETCH_ASSOC));*/

fclose($file);
?> 
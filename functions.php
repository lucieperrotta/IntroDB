<?php 

function parseNullValue($s) {

	if(empty($s)) return true;

	$nullValues = ['NULL', '[nn]', '[none]','?', 'none'];
	foreach($nullValues as $n) {
		$res = strpos($s, $n);
		if ($res !== false) {
			return true;
		}
	}

	return false;
}

function parseNullValueWebsite($s) {

	if(empty($s)) return true;

	$nullValues = ['NULL', '[nn]', '[none]','?', 'none', 'url']; // url comes from first line of csv
	foreach($nullValues as $n) {
		$res = strpos($s, $n);
		if ($res !== false) {
			return true;
		}
	}

	return false;
}

function parseDoubleQuote($s) {

	if(parseNullValue($s)) return "NULL";

	$res = str_replace('"', '\"', $s);
	return '"'.$res.'"';
}

/*
echo(getDateFromYear("[du borbel 1970's]]"));
echo(getDateFromYear("1897"));
echo(getDateFromYear("July 17 1897")); //1897 too early for strtotime -> keep full date ?
echo(getDateFromYear("1898-11-05")); //1897 too early -> keep full date ?
*/

function getDateFromYear($year) {

	if(parseNullValue($year)) return "NULL";

	// remove any char, ], [, ', ", whitespace
	// should get 4 digits group
	//$res = preg_replace("/\b[a-zA-Z]*]*\'*\"*\[*[\s]*[0-9]{2}[\s]*\b/" , "", $year);
	$res = preg_replace("/[^\d\s-]/" , "", $year);
	$res1 = preg_split("/[\s-]/" , $res);

	//var_dump($res1);

	for ($i = 0; $i < sizeof($res1); $i++) {
		if(strlen($res1[$i])==4) {
			$res = $res1[$i];
		}
	}

	$month=1; $day=1;
	$hour=0; $minute=0; $second=0;

	return '"'.$res.'-'.$month.'-'.$day.'"';
}

function getInt($i) {

	if(parseNullValue($i)) return "NULL";

	// suppress [ ] char
	$i = preg_replace("/\[*\]*/" ,"", $i);

	return $i;
}

// return last index used in csv - useful for assigning id
function getLastIndex($file) {
	$index;
	while((!feof($file)) && ($val = fgetcsv($file))){
		$index = $val[0];
	}
	return (empty($index)) ? 0 : $index+1;
}

// return words separated by delimiter
function parseNames($s, $delimiter=";"){
	// get rid of first and last double quotes
	$string = substr($s, 1, -1);
	$array = explode($delimiter, $string);
	for($i = 0; $i< sizeof($array); $i++){
		$array[$i] = ltrim($array[$i]);
	}
	return $array;
}

// return true if $s in contained in $csv file (opened) (at position $pos), false otherwise
function isInCsv($file, $s, $pos){

	rewind($file);

	if(empty($s)) {
		return false;
	}

	while(! feof($file)){
		$val = fgetcsv($file);
		if($val[$pos]==$s) {
			return true;
		}
	}
	return false;
}

// return true if $s in contained in $csv file (opened) (at position $pos), false otherwise
function isInCsvName($file, $s, $pos){

	rewind($file);

	if(empty($s)) {
		return false;
	}

	$string = parseToCompare($s);

	while(! feof($file)){
		$val = parseToCompare(fgetcsv($file)[$pos]);
		if($val==$string) {
			return true;
		}
	}
	return false;
}

// modify string so that it can match even with the following differences : whitespaces, dot, dash
// in csv -> will keep first occurence
// @todo match entries when [as ...] is defined
function parseToCompare($s){
	$res = preg_replace("/\s/", "", $s);
	$res = preg_replace("/\-/", "", $res);
	$res = preg_replace("/\./", "", $res);
	$res = strtolower($res);
	return $res;
}


// delete from $s all content between () or []
function parseComments($s) {
	$res = preg_replace("/\[.*\]/", "", $s);
	$res = preg_replace("/\(.*\)/", "", $res);


	$res = trim($res);
	return $res;
}
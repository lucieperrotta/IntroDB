<?php 

/*var_dump(parseNullValue("dwed?ded"));
var_dump(parseNullValue("hey None"));
var_dump(parseNullValue(0));
var_dump(parseNullValue("?"));
var_dump(parseNullValue("NULL"));
var_dump(parseNullValue("[none]"));
var_dump(parseNullValue("[nn]"));
var_dump(parseNullValue("(unknown)"));*/

function parseNullValue($s) {

	if(empty($s) && $s!='0') return true;

	//if(is_numeric($s)) return false; // handle 0 values of id 

	$nullValues = ['NULL', '[nn]', 'nn', 'none', '[none]','?', '(unknown)','None'];
	foreach($nullValues as $n) {
		if ($s === $n) {
			return true;
		}
	}

	return false;
}

/*echo parseDoubleQuote('"fweihfekf"') . "<br/>";
echo parseDoubleQuote('\"fweihfekf\"');*/

function parseDoubleQuote($s) {

	if(parseNullValue($s)) return "NULL";

	$res = str_replace('"', '\"', $s);
	$res = str_replace('\\\\"', '\"', $res);
	//return $res;
	return '"'.$res.'"';
}

function parseDoubleQuoteHas($s) {

	if(parseNullValue($s)) return "NULL";

	$res = str_replace('"', '\"', $s);
	$res = str_replace('\\\\"', '\"', $res);
	return '"'.$res.'"';
}


/*echo(getDateFromYear("[du borbel 1970's]]")."<br/>");
echo(getDateFromYear("1897")."<br/>");
echo(getDateFromYear("July 17 1897")."<br/>"); //1897 too early for strtotime -> keep full date ?
echo(getDateFromYear("1898-11-05")."<br/>"); //1897 too early -> keep full date ??
echo(getDateFromYear("189811-05")."<br/>"); //1897 too early -> keep full date ?*/


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
			return $res1[$i];
		}
	}

	$month=1; $day=1;
	$hour=0; $minute=0; $second=0;

	// no date with 4 digits
	return "0";
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
	return array_filter($array, function($value) { return $value !== ''; });
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
			return $val[0];
		}
	}
	return false;
}

// return true if $s in contained in $csv file (opened) (at position $pos), false otherwise
// @TODO parse "?"
function isInCsvName($file, $s, $pos){

	rewind($file);

	if(empty($s)) {
		return false;
	}

	$string = parseToCompare($s);

	while(! feof($file)){
		$content = fgetcsv($file);
		$val = parseToCompare($content[$pos]);
		if($val==$string) {
			return $content[0];
		}
	}
	return false;
}

// modify string so that it can match even with the following differences : whitespaces, dot, dash (essentially for names)
// in csv -> will keep first occurence
// @todo match entries when [as ...] is defined
function parseToCompare($s){
	$res = preg_replace("/\s/", "", $s);
	$res = preg_replace("/\-/", "", $res);
	$res = preg_replace("/\./", "", $res);
	$res = strtolower($res);
	return $res;
}
/*
var_dump(parseComments("rfjidrgi ?"));
var_dump(parseComments("rfjidrgi (wewe)"));*/

// delete from $s all content between () or [] or ?
function parseComments($s) {
	$res = preg_replace("/\[.*\]/", "", $s);
	$res = preg_replace("/\(.*\)/", "", $res);
	$res = preg_replace("/\?/", "", $res);

	if(empty(preg_replace("/\s/","",$res))){
		return "NULL";
	}

	$res = trim($res);
	return $res;
}
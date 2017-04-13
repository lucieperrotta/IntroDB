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
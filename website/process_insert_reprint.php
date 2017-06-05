<?php 
include("../db.php");
include("../functions.php");
include("functions_todb.php");

$table_origin = $_POST["table"];
$table = $table_origin."_reprint";

var_dump($table);


$origin_id = getInt(htmlspecialchars($_POST["origin_id"]));
$target_id = getInt(htmlspecialchars($_POST["target_id"]));

checkForeignKeyNotNull($origin_id, $table_origin, "origin_id", $table, $con);
checkForeignKeyNotNull($target_id, $table_origin, "target_id", $table, $con);

checkDoubleForeignKey($origin_id,$target_id, $table, "origin_id and target_id", $table, $con);


// ID
$id = getLastId($table,$con);

$query = 'INSERT INTO '.$table_origin.'_reprint(id,origin_id, target_id) VALUES('.$id.', '.$origin_id.', '.$target_id.' )';
var_dump($query);
$add_query = $con->query($query);
$add_query->fetchAll(PDO::FETCH_ASSOC);

header("Location: insert.php?currenttable=".$table."&code=sucess");
exit();


function checkDoubleForeignKey($s1,$s2, $foreignTable, $on, $table, $con){
	$q = "SELECT id FROM ".$foreignTable." WHERE origin_id=".$s1." AND target_id=".$s2;
	var_dump($q);
	$query = $con->query($q);
	$check = $query->fetchAll(PDO::FETCH_ASSOC);
	if(!empty($check)) {
		header("Location: insert.php?currenttable=".$table."&code=error&cause=alreadyexist&on=".$on); exit();
	}
}
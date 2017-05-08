<?php  

function getLastId($table, $con){
	$s = $con->query("SELECT MAX(id) FROM ".$table);
	$id_query = $s->fetchAll(PDO::FETCH_ASSOC);
	return $id_query[0]["MAX(id)"] + 1;
}

function getWebsiteId($url, $con){
	$s = $con->query("SELECT id FROM website WHERE url=".$url); // @todo compare better
	$url_id = $s->fetchAll(PDO::FETCH_ASSOC);
	if(empty($url_id)) {
		$s = $con->query("SELECT MAX(id) FROM website");
		$url_id = $s->fetchAll(PDO::FETCH_ASSOC)[0]["MAX(id)"] + 1;;
		$s = $con->query('INSERT INTO website(id, url) VALUES('.$url_id.','.$url.')');
		$s->fetchAll(PDO::FETCH_ASSOC);

		return $url_id;
	}
	else{
		return $url_id = $url_id[0]["id"];
	}
}

function checkPrimaryKey($s,$on,$table,$con){
	notNull($s,$on,$table);
	noDuplicata($s,$on,$table,$con);
}

function notNull($s,$on,$table){
	if($s=="NULL") {
		header("Location: insert.php?currenttable=".$table."&code=error&cause=isnull&on=".$on);
		exit();
	}
}

function noDuplicata($s, $on, $table, $con){
	$query = $con->query("SELECT id FROM ".$table." WHERE ".$on."=".$s); 
	$id = $query->fetchAll(PDO::FETCH_ASSOC);
	if(!empty($id)) {
		header("Location: insert.php?currenttable=".$table."&code=error&cause=duplicata&on=".$on); exit();
	}
}

function checkForeignKey($s, $foreignTable, $on, $table, $con){
	if(!is_numeric($s)) {
		header("Location: insert.php?currenttable=".$table."&code=error&cause=notnumber&on=".$on); exit();
	}
	$query = $con->query("SELECT id FROM ".$foreignTable." WHERE id=".$s);
	$check = $query->fetchAll(PDO::FETCH_ASSOC);
	if(empty($check)) {
		header("Location: insert.php?currenttable=".$table."&code=error&cause=notexist&on=".$on); exit();
	}
}

function checkIsNullOrInt($s, $on, $table){
	if($s!="NULL" && !is_numeric($s)) {
		header("Location: insert.php?currenttable=".$table."&code=error&cause=notnumber&on=".$on); exit();
	}
}

function checkDateFromForm($s, $on, $table){
	if($s!="" && (!is_numeric($s) || intval($s)>2020)) {
		header("Location: insert.php?currenttable=".$table."&code=error&cause=notnumber&on=".$on); exit();
	}
}
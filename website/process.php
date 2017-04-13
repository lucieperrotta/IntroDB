<?php 

var_dump($_POST);

$query = $_POST['query'];

if($query == "select") {
	// SELECT
}
else if($query == "insert") {
	// INSERT
}
else if($query == "delete") {
	// DELETE
}
else {
	// ERROR
}



header("Location: index.php");
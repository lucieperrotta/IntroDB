<!DOCTYPE html>
<html>
<?php
include("header.php");
include("../db.php");
?>
<body>

	<?php 
	if(isset($_POST["delete"])){
		$id = $_POST["id"];
		$table = $_POST["table"][0];
		$sql = "DELETE FROM ".$table." WHERE id=" . $id;

		var_dump($sql);

		$add_query = $con->query($sql);
		$results = $add_query->fetchAll(PDO::FETCH_ASSOC);


	}
	?>

	<?php //var_dump($_POST); ?>

	<?php include("navigation.php"); ?>

	
	<section id="search_delete">
		<form action="" method="post">
			<input type="" name="search" value="search">
			<input type="submit" name="">
		</form>

		<div id="results">
			
			<?php 

			if(isset($_POST["search"])){

				$search = htmlspecialchars($_POST["search"]);
				$tables = ["story"];

				$alltables = implode(",",$tables);

				$sql = "SELECT * FROM ".$alltables." WHERE title LIKE '%" .$search."%'";

				$msc = microtime(true);
				$add_query = $con->query($sql);
				$results = $add_query->fetchAll(PDO::FETCH_ASSOC);
				$msc = microtime(true) - $msc;
	//var_dump($results);


				if(!empty($results)) {
					echo "<table>";
					echo '<tr class="titles">';
					/*for($i=0;$i<sizeof($columns);$i++){
						echo "<td>";
						echo ($columns[$i]) . "<br/>";
						echo "</td>";
					}*/
					echo "</tr>";
					foreach ($results as $key => $value) {
						echo '<tr>';
						
						foreach ($value as $k => $v) {
							echo "<td>";
							echo ($v) . "<br/>";
							echo "</td>";
						}

						echo "<td>";
						echo '<form method="post" action="">
						<input type="hidden" name="id" value="'.$value["id"].'">';
						echo '<input type="hidden" name="search" value="'.$search.'">';

						for($i=0;$i<sizeof($tables);$i++){
							echo '<input type="hidden" name="table[]" value="'.$tables[$i].'">';
						}

						echo '<input type="submit" name="delete" value="delete">
					</form>';
					echo "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
			else {
				echo "<h3>No results</h3>";
			}
			echo '<div id="executing_time">'.$msc.' seconds</div>';
		}
		?>

		<?php 

	if(isset($_POST["delete"])){
		echo "<h3>Entry with id ".$id." deleted</h3>";
	}
		 ?>

	</div>

</section>

</body>
</html>
<!DOCTYPE html>
<html>
<?php include("header.php"); ?>
<?php include("../db.php"); ?>

<body>

	<?php include("navigation.php"); ?>

	<section>

		<div id="ongletsBox">
			<span onclick="display(this)" value="story">Story</span>
			<span onclick="display(this)" value="issue">Issue</span>
			<span onclick="display(this)" value="publisher">Publisher</span>
			<span onclick="display(this)" value="indicia_publisher">Indicia Publisher</span>
			<span onclick="display(this)" value="country">Country</span>
		</div>


		<div id="displayBoxInsert">


			<div class="active content" id="story">

				<form method="post" action="process_insert_story.php">
					<fieldset>
						<h2>Story</h2>
						Title: <input type="text" name="title" value="title"><br>
						Features: <input type="text" name="features" value="features_test"><br>
						Issue ID: <input type="text" name="issueId" value="1"><br>
						Letters: <input type="text" name="letters" value="letters_test"><br>
						Editing: <input type="text" name="editing" value="editing_test"><br>
						Script: <input type="text" name="script" value="script_test"><br>
						Inks: <input type="text" name="inks" value="ink_test"><br>
						Colors: <input type="text" name="colors" value="color_test"><br>
						Letters: <input type="text" name="letters" value="letter_test"><br>
						Characters: <input type="text" name="characters" value="character_test"><br>
						Synopsis: <textarea type="text" name="synopsis" value="Synopsis">hey! </textarea><br>
						Reprint notes: <input type="text" name="reprintNotes" value="sometextforreprintnotes"><br>
						Notes: <input type="text" name="notes" value="notes"><br>
						Type : <input type="text" name="type" value="type_test"><br>
					</fieldset>
					<br/>
					<input type="submit" value="Submit">
				</form>

			</div>


			<div class="content" id="issue">

				<form method="post" action="process_insert_issue.php">
					<fieldset>
						<h2>Issue</h2>
						Number: <input type="text" name="number" value="number"><br>
						Series ID: <input type="text" name="series_id" value="1"><br>
						Indicia Publisher ID: <input type="text" name="indicia_publisher_id" value="2"><br>
						Publication date: <input type="text" name="publication_date" value="1234"><br>
						price: <input type="text" name="price" value="price"><br>
						Page Count: <input type="text" name="page_count" value="31"><br>
						Indicia Frequency: <input type="text" name="indicia_frequency" value="Frequency"><br>
						Editing: <input type="text" name="editing" value="editing_test"><br>
						Notes: <input type="text" name="notes" value="notes"><br>
						ISBN: <input type="text" name="isbn" value="isbn"><br>
						Valid ISBN: <input type="text" name="valid_isbn" value="valid isbn"><br>
						title: <textarea type="text" name="title" value="title">hey! </textarea><br>
						On Sale Date: <input type="text" name="on_sale_date" value="1234"><br>
						Barcode : <input type="text" name="barcode" value="1234567"><br>
						rating : <input type="text" name="rating" value="rating"><br>
					</fieldset>
					<br/>
					<input type="submit" value="Submit">
				</form>


			</div>
			<div class="content" id="indicia_publisher">
				<form method="post" action="process_insert_indicia_publisher.php">
					<fieldset>
						<h2>Indicia Publisher</h2>
						Name: <input type="text" name="name" value="name"><br>
						Publiser ID: <input type="text" name="publisher_id" value="1"><br>
						Country ID: <input type="text" name="country_id" value="1"><br>
						year began: <input type="text" name="year_began" value="1234"><br>
						year ended: <input type="text" name="year_ended" value="1234"><br>
						is surrogate: 
						<input type="radio" name="is_surrogate" value="1"> Yes<br>
						<input type="radio" name="is_surrogate" value="0"> No<br>
						<input type="radio" name="is_surrogate" value="?" checked> ?<br>
						Notes: <input type="text" name="notes" value="notes"><br>
						website: <input type="text" name="website" value="urlhttp//"><br>
					</fieldset>
					<br/>
					<input type="submit" value="Submit">

				</form>



				<?php 
				$s = $con->query("SELECT * FROM indicia_publisher ORDER BY id DESC LIMIT 3");
				$result = $s->fetchAll(PDO::FETCH_ASSOC);

				$text = '<table class="table_content">';
				foreach ($result as $key => $value) {
					$text .= '<tr>';
					$text .= '<td class="id">'.$value["id"].'</td>';
					$text .= '<td class="name">'.$value["name"].'</td>';
					$text .= '<td class="publisher_id">'.$value["publisher_id"].'</td>';
					$text .= '<td class="country_id">'.$value["country_id"].'</td>';
					$text .= '<td class="year_began">'.$value["year_began"].'</td>';
					$text .= '<td class="year_ended">'.$value["year_ended"].'</td>';
					$text .= '<td class="is_surrogate">'.$value["is_surrogate"].'</td>';
					$text .= '<td class="notes">'.$value["notes"].'</td>';
					$text .= '<td class="url">'.$value["website_id"].'</td>';
					$text .= '</tr>';
				}
				$text .= '</table>'; 

				echo $text;

				?>
			</div>

			<div class="content" id="publisher">

				<form method="post" action="process_insert_publisher.php">
					<fieldset>
						<h2>Publisher</h2>
						Name: <input type="text" name="name" value="name"><br>
						Country ID: <input type="text" name="country_id" value="1"><br>
						year began: <input type="text" name="year_began" value="1234"><br>
						year ended: <input type="text" name="year_ended" value="1234"><br>
						Notes: <input type="text" name="notes" value="notes"><br>
						website: <input type="text" name="website" value="urlhttp//"><br>
					</fieldset>
					<br/>
					<input type="submit" value="Submit">

				</form>

			</div>

			<div class="content" id="country">
				<form method="post" action="process_insert_country.php">
					<fieldset>
						<h2>Country</h2>
						Name: <input type="text" name="name" value="name"><br>
						Code: <input type="text" name="code" value="ch"><br>
					</fieldset>
					<br/>
					<input type="submit" value="Submit">
				</form>



				<?php 
				$s = $con->query("SELECT * FROM country ORDER BY id DESC LIMIT 3");
				$result = $s->fetchAll(PDO::FETCH_ASSOC);

				$text = '<table class="table_content">';
				foreach ($result as $key => $value) {
					$text .= '<tr>';
					$text .= '<td class="id">'.$value["id"].'</td>';
					$text .= '<td class="name">'.$value["name"].'</td>';
					$text .= '<td class="code">'.$value["code"].'</td>';
					$text .= '</tr>';
				}
				$text .= '</table>'; 

				echo $text;

				?>

			</div>

		</div>


	</section>

</body>

<script type="text/javascript">

	<?php 
	// display current table content. By default story is displayed
	if(isset($_GET["currenttable"])) {
		echo "displayByValue('".$_GET["currenttable"]."');";
	}

	?>

	function display(mySpan){
		var myValue = mySpan.getAttribute("value");
		displayByValue(myValue);
	}

	function displayByValue(myValue){
		document.getElementsByClassName("active")[0].classList.remove("active");
		document.getElementById(myValue).className += " active";
	}

</script>
</html>

<?php 
$s = $con->query("SELECT * FROM publisher ORDER BY id DESC LIMIT 3");
$result = $s->fetchAll(PDO::FETCH_ASSOC);

$text = '<table class="table_content">';
foreach ($result as $key => $value) {
	var_dump($value);
}
?>


	<?php include("error_handler.php"); ?>
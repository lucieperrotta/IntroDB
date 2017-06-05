<!DOCTYPE html>
<html>
<?php include("header.php"); ?>
<?php include("../db.php"); ?>

<?php 
// nb of entries to display
$count = 5;
 ?>
}

<body>

	<?php include("navigation.php"); ?>

	<section>

		<div id="ongletsBox">
			<span onclick="display(this)" value="story" class="spanActive">Story</span>
			<span onclick="display(this)" value="story_reprint">Story Reprint</span>
			<span onclick="display(this)" value="series">Series</span>
			<span onclick="display(this)" value="issue">Issue</span>
			<span onclick="display(this)" value="issue_reprint">Issue Reprint</span>
			<span onclick="display(this)" value="publisher">Publisher</span>
			<span onclick="display(this)" value="indicia_publisher">Indicia Publisher</span>
			<span onclick="display(this)" value="brand_group">Brand Group</span>
			<span onclick="display(this)" value="country">Country</span>
			<span onclick="display(this)" value="language">Language</span>
		</div>


		<div id="displayBoxInsert">


			<div class="active content" id="story">

				<form method="post" action="process_insert_story.php">
					<fieldset>
						<h2>Story</h2>
						Title: <input type="text" name="title" value="title" maxlength="700"><br>
						Features: <input type="text" name="features" value="features_test"><br>
						Issue ID: <input type="number" name="issueId" value="1"><br>
						Letters: <input type="text" name="letters" value="letters_test" maxlength="255"><br><br><br><br><br>
						Editing: <input type="text" name="editing" value="editing_test" maxlength="255"><br>
						Script: <input type="text" name="script" value="script_test" maxlength="255"><br>
						Pencils: <input type="text" name="pencils" value="pencils_test" maxlength="255"><br>
						Inks: <input type="text" name="inks" value="ink_test" maxlength="255"><br>
						Colors: <input type="text" name="colors" value="color_test" maxlength="255"><br><br><br><br>
						Characters: <input type="text" name="characters" value="character_test" maxlength="255"><br>
						Synopsis: <textarea type="text" name="synopsis" value="Synopsis">hey! </textarea><br>
						Reprint notes: <input type="text" name="reprintNotes" value="sometextforreprintnotes"><br>
						Notes: <input type="text" name="notes" value="notes"><br>
						Type : <input type="text" name="type" value="type_test"><br>
					</fieldset>
					<br/>
					<input type="submit" value="Submit">
				</form>
				<?php 
				$s = $con->query("SELECT * FROM story ORDER BY id DESC LIMIT ".$count);
				$result = $s->fetchAll(PDO::FETCH_ASSOC);

				$text = '<table class="table_content">';
				foreach ($result as $key => $value) {
					$text .= '<tr>';
					$text .= '<td class="id">'.$value["id"].'</td>';
					$text .= '<td class="title">'.$value["title"].'</td>';
					$text .= '<td class="issue_id">'.$value["issue_id"].'</td>';
					$text .= '<td class="synopsis">'.$value["synopsis"].'</td>';
					$text .= '<td class="reprint_notes">'.$value["reprint_notes"].'</td>';
					$text .= '<td class="notes">'.$value["notes"].'</td>';
					$text .= '<td class="type_id">'.$value["type_id"].'</td>';
					$text .= '</tr>';
				}
				$text .= '</table>'; 

				echo $text;

				?>

			</div>


			<div class="content" id="story_reprint">

				<form method="post" action="process_insert_reprint.php">
					<fieldset>
						<h2>Story Reprint</h2><br>
						<input type="hidden" name="table" value="story">
						Origin Issue ID: <input type="text" name="origin_id" value="5"><br>
						Target Issue ID: <input type="text" name="target_id" value="5"><br>
					</fieldset>
					<br/>
					<input type="submit" value="Submit">
				</form>


				<?php 
				$s = $con->query("SELECT * FROM story_reprint ORDER BY id DESC LIMIT ".$count);
				$result = $s->fetchAll(PDO::FETCH_ASSOC);

				$text = '<table class="table_content">';
				foreach ($result as $key => $value) {
					$text .= '<tr>';
					$text .= '<td class="id">'.$value["id"].'</td>';
					$text .= '<td class="origin_id">'.$value["origin_id"].'</td>';
					$text .= '<td class="target_id">'.$value["target_id"].'</td>';
					$text .= '</tr>';
				}
				$text .= '</table>'; 

				echo $text;

				?>

			</div>

			<div class="content" id="series">

				<form method="post" action="process_insert_series.php">
					<fieldset>
						<h2>Series</h2>
						Name: <input type="text" name="name" value="name" maxlength="255"><br>
						Format: <input type="text" name="format" value="format" maxlength="255"><br>
						year began: <input type="number" name="year_began" value="1234" maxlength="4"><br>
						year ended: <input type="number" name="year_ended" value="1234" maxlength="4"><br>
						Publication dates: <input type="text" name="publication_dates" value="1wefio" maxlength="255"><br>
						First issue ID: <input type="number" name="first_issue_id" value="1"><br>
						Last issue ID: <input type="number" name="last_issue_id" value="1"><br>
						Publisher ID: <input type="number" name="publisher_id" value="2"><br>
						Country ID: <input type="number" name="country_id" value="1"><br>
						Language ID: <input type="number" name="language_id" value="1"><br>
						notes: <input type="text" name="notes" value="wefjwpfo"><br>
						Color: <input type="text" name="color" value="color_test" maxlength="255"><br><br>
						dimensions: <input type="text" name="dimensions" value="dimensions" maxlength="255"><br>
						paper stock: <input type="text" name="paper_stock" value="paperstock" maxlength="255"><br>
						binding: <textarea type="text" name="binding" value="binding" maxlength="255">hey! </textarea><br>
						publishing format: <input type="text" name="publishing_format" value="sometextforreprintnotes" maxlength="255"><br>
						publication type ID: <input type="number" name="publication_type_id" value="1"><br><br>
					</fieldset>
					<br/>
					<input type="submit" value="Submit">
				</form>

				<?php 
				$s = $con->query("SELECT * FROM series ORDER BY id DESC LIMIT ".$count);
				$result = $s->fetchAll(PDO::FETCH_ASSOC);

				$text = '<table class="table_content">';
				foreach ($result as $key => $value) {
					$text .= '<tr>';
					$text .= '<td class="id">'.$value["id"].'</td>';
					$text .= '<td class="name">'.$value["name"].'</td>';
					$text .= '<td class="format">'.$value["format"].'</td>';
					$text .= '<td class="year_began">'.$value["year_began"].'</td>';
					$text .= '<td class="year_ended">'.$value["year_ended"].'</td>';
					$text .= '<td class="publication_dates">'.$value["publication_dates"].'</td>';
					$text .= '<td class="first_issue_id">'.$value["first_issue_id"].'</td>';
					$text .= '<td class="last_issue_id">'.$value["last_issue_id"].'</td>';
					$text .= '<td class="publisher_id">'.$value["publisher_id"].'</td>';
					$text .= '<td class="country_id">'.$value["country_id"].'</td>';
					$text .= '<td class="language_id">'.$value["language_id"].'</td>';
					$text .= '<td class="notes">'.$value["notes"].'</td>';
					$text .= '<td class="color">'.$value["color"].'</td>';
					$text .= '<td class="dimensions">'.$value["dimensions"].'</td>';
					$text .= '<td class="paper_stock">'.$value["paper_stock"].'</td>';
					$text .= '<td class="binding">'.$value["binding"].'</td>';
					$text .= '<td class="publishing_format">'.$value["publishing_format"].'</td>';
					$text .= '<td class="publication_type_id">'.$value["publication_type_id"].'</td>';
					$text .= '</tr>';
				}
				$text .= '</table>'; 

				echo $text;

				?>

			</div>


			<div class="content" id="issue">

				<form method="post" action="process_insert_issue.php">
					<fieldset>
						<h2>Issue</h2>
						Number: <input type="text" name="number" value="number" maxlength="255"><br>
						Series ID: <input type="number" name="series_id" value="1"><br>
						Indicia Publisher ID: <input type="number" name="indicia_publisher_id" value="2" maxlength="4"><br>
						Publication date: <input type="number" name="publication_date" value="1234" maxlength="4"><br>
						price: <input type="text" name="price" value="price" maxlength="255"><br><br>
						Page Count: <input type="number" name="page_count" value="31" maxlength="255"><br>
						Indicia Frequency: <input type="text" name="indicia_frequency" value="Frequency" maxlength="255"><br>
						Editing: <input type="text" name="editing" value="editing_test" maxlength="255"><br>
						Notes: <input type="text" name="notes" value="notes"><br>
						ISBN: <input type="text" name="isbn" value="isbn" maxlength="255"><br><br><br>
						Valid ISBN: <input type="text" name="valid_isbn" value="valid isbn" maxlength="255"><br>
						title: <textarea type="text" name="title" value="title" maxlength="255">hey! </textarea><br>
						On Sale Date: <input type="text" name="on_sale_date" value="1234" maxlength="4"><br>
						Barcode : <input type="number" name="barcode" value="1234567" maxlength="255"><br>
						rating : <input type="text" name="rating" value="rating" maxlength="255"><br>
					</fieldset>
					<br/>
					<input type="submit" value="Submit">
				</form>


				<?php 
				$s = $con->query("SELECT * FROM issue ORDER BY id DESC LIMIT ".$count);
				$result = $s->fetchAll(PDO::FETCH_ASSOC);

				$text = '<table class="table_content">';
				foreach ($result as $key => $value) {
					$text .= '<tr>';
					$text .= '<td class="id">'.$value["id"].'</td>';
					$text .= '<td class="number">'.$value["number"].'</td>';
					$text .= '<td class="series_id">'.$value["series_id"].'</td>';
					$text .= '<td class="indicia_publisher_id">'.$value["indicia_publisher_id"].'</td>';
					$text .= '<td class="publication_date">'.$value["publication_date"].'</td>';
					$text .= '<td class="price">'.$value["price"].'</td>';
					$text .= '<td class="page_count">'.$value["page_count"].'</td>';
					$text .= '<td class="indicia_frequency">'.$value["indicia_frequency"].'</td>';
					$text .= '<td class="notes">'.$value["notes"].'</td>';
					$text .= '<td class="isbn">'.$value["isbn"].'</td>';
					$text .= '<td class="valid_isbn">'.$value["valid_isbn"].'</td>';
					$text .= '<td class="title">'.$value["title"].'</td>';
					$text .= '<td class="on_sale_date">'.$value["on_sale_date"].'</td>';
					$text .= '<td class="barcode">'.$value["barcode"].'</td>';
					$text .= '<td class="rating">'.$value["rating"].'</td>';
					$text .= '</tr>';
				}
				$text .= '</table>'; 

				echo $text;

				?>

			</div>

			<div class="content" id="issue_reprint">

				<form method="post" action="process_insert_reprint.php">
					<fieldset>
						<h2>Issue Reprint</h2>
						<input type="hidden" name="table" value="issue"><br/>
						Origin Issue ID: <input type="number" name="origin_id" value="5"><br>
						Target Issue ID: <input type="number" name="target_id" value="5"><br>
					</fieldset>
					<br/>
					<input type="submit" value="Submit">
				</form>


				<?php 
				$s = $con->query("SELECT * FROM issue_reprint ORDER BY id DESC LIMIT ".$count);
				$result = $s->fetchAll(PDO::FETCH_ASSOC);

				$text = '<table class="table_content">';
				foreach ($result as $key => $value) {
					$text .= '<tr>';
					$text .= '<td class="id">'.$value["id"].'</td>';
					$text .= '<td class="origin_id">'.$value["origin_id"].'</td>';
					$text .= '<td class="target_id">'.$value["target_id"].'</td>';
					$text .= '</tr>';
				}
				$text .= '</table>'; 

				echo $text;

				?>

			</div>

			<div class="content" id="indicia_publisher">
				<form method="post" action="process_insert_indicia_publisher.php">
					<fieldset>
						<h2>Indicia Publisher</h2>
						Name: <input type="text" name="name" value="name" maxlength="255"><br>
						Publiser ID: <input type="number" name="publisher_id" value="1"><br><br>
						Country ID: <input type="number" name="country_id" value="1"><br>
						year began: <input type="number" name="year_began" value="1234" maxlength="4"><br>
						year ended: <input type="number" name="year_ended" value="1234" maxlength="4"><br>
						is surrogate: 
						<input type="radio" name="is_surrogate" value="1"> Yes 
						<input type="radio" name="is_surrogate" value="0"> No 
						<input type="radio" name="is_surrogate" value="?" checked> ?<br>
						Notes: <input type="text" name="notes" value="notes"><br>
						website: <input type="text" name="website" value="urlhttp//" maxlength="255"><br>
					</fieldset>
					<br/>
					<input type="submit" value="Submit">

				</form>



				<?php 
				$s = $con->query("SELECT * FROM indicia_publisher ORDER BY id DESC LIMIT ".$count);
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
						Name: <input type="text" name="name" value="name" maxlength="255"><br>
						Country ID: <input type="number" name="country_id" value="1"><br><br>
						year began: <input type="number" name="year_began" value="1234" maxlength="4"><br>
						year ended: <input type="number" name="year_ended" value="1234" maxlength="4"><br><br/>
						Notes: <input type="text" name="notes" value="notes"><br>
						website: <input type="text" name="website" value="urlhttp//"><br>
					</fieldset>
					<br/>
					<input type="submit" value="Submit">

				</form>



				<?php 
				$s = $con->query("SELECT * FROM publisher ORDER BY id DESC LIMIT ".$count);
				$result = $s->fetchAll(PDO::FETCH_ASSOC);

				$text = '<table class="table_content">';
				foreach ($result as $key => $value) {
					$text .= '<tr>';
					$text .= '<td class="id">'.$value["id"].'</td>';
					$text .= '<td class="name">'.$value["name"].'</td>';
					$text .= '<td class="country_id">'.$value["country_id"].'</td>';
					$text .= '<td class="year_began">'.$value["year_began"].'</td>';
					$text .= '<td class="year_ended">'.$value["year_ended"].'</td>';
					$text .= '<td class="notes">'.$value["notes"].'</td>';
					$text .= '<td class="website_id">'.$value["website_id"].'</td>';
					$text .= '</tr>';
				}
				$text .= '</table>'; 

				echo $text;

				?>

			</div>

			<div class="content" id="brand_group">

				<form method="post" action="process_insert_brand_group.php">
					<fieldset>
						<h2>Brand Group</h2>
						Name: <input type="text" name="name" value="name" maxlength="255"><br>
						year began: <input type="number" name="year_began" value="1234" maxlength="4"><br><br>
						year ended: <input type="number" name="year_ended" value="1234" maxlength="4"><br>
						Notes: <input type="text" name="notes" value="notes"><br><br>
						website: <input type="text" name="website" value="urlhttp//" maxlength="255"><br>
						Publisher ID: <input type="number" name="publisher_id" value="1"><br>
					</fieldset>
					<br/>
					<input type="submit" value="Submit">

				</form>


				<?php 
				$s = $con->query("SELECT * FROM brand_group ORDER BY id DESC LIMIT ".$count);
				$result = $s->fetchAll(PDO::FETCH_ASSOC);

				$text = '<table class="table_content">';
				foreach ($result as $key => $value) {
					$text .= '<tr>';
					$text .= '<td class="id">'.$value["id"].'</td>';
					$text .= '<td class="name">'.$value["name"].'</td>';
					$text .= '<td class="year_began">'.$value["year_began"].'</td>';
					$text .= '<td class="year_ended">'.$value["year_ended"].'</td>';
					$text .= '<td class="notes">'.$value["notes"].'</td>';
					$text .= '<td class="website">'.$value["website_id"].'</td>';
					$text .= '<td class="publisher_id">'.$value["publisher_id"].'</td>';
					$text .= '</tr>';
				}
				$text .= '</table>'; 

				echo $text;

				?>

			</div>

			<div class="content" id="country">
				<form method="post" action="process_insert_country.php">
					<fieldset>
						<h2>Country</h2><br>
						Name: <input type="text" name="name" value="name"><br>
						Code: <input type="text" name="code" value="ch"><br>
					</fieldset>
					<br/>
					<input type="submit" value="Submit">
				</form>



				<?php 
				$s = $con->query("SELECT * FROM country ORDER BY id DESC LIMIT ".$count);
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

			<div class="content" id="language">
				<form method="post" action="process_insert_language.php">
					<fieldset>
						<h2>Language</h2><br>
						Name: <input type="text" name="name" value="name"><br>
						Code: <input type="text" name="code" value="ch"><br>
					</fieldset>
					<br/>
					<input type="submit" value="Submit">
				</form>



				<?php 
				$s = $con->query("SELECT * FROM language ORDER BY id DESC LIMIT ".$count);
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
		document.getElementsByClassName("spanActive")[0].classList.remove("spanActive");
		mySpan.className = "spanActive";


		var myValue = mySpan.getAttribute("value");
		displayByValue(myValue);
	}

	function displayByValue(myValue){
		document.getElementsByClassName("active")[0].classList.remove("active");
		document.getElementById(myValue).className += " active";
	}

</script>
</html>


<?php include("error_handler.php"); ?>

<?php 
/*$s = $con->query("SELECT * FROM series ORDER BY id DESC LIMIT 3");
$result = $s->fetchAll(PDO::FETCH_ASSOC);

$text = '<table class="table_content">';
foreach ($result as $key => $value) {
	var_dump($value);
}*/
?>


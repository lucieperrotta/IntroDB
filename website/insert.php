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
		</div>


		<div id="displayBoxInsert">


			<div class="active content" id="story">

				<form method="post" action="process_insert.php">
					<fieldset>
						<h2>Story</h2>
						<input type="hidden" name="table" value="story">
						Title: <input type="text" name="title" value="title"><br>
						Features: <input type="text" name="features" value="features_test"><br>
						Issue ID: <input type="text" name="issueId" value="1"><br>
						Letters: <input type="text" name="letters" value="letters_test"><br>
						Editing: <input type="text" name="editing" value="editing_test"><br>
						Synopsis: <textarea type="text" name="synopsis" value="Synopsis">hey! </textarea><br>
						Reprint notes: <input type="text" name="reprintNotes" value="sometextforreprintnotes"><br>
						Notes: <input type="text" name="notes" value="notes"><br>
						Type : <input type="text" name="type" value="type_test"><br>
					</fieldset>
					<br/>
					<input type="submit" value="Submit">
				</form>

			</div>


			<div class="content" id="issue">content2</div>
			<div class="content" id="publisher">content3</div>
			<div class="content" id="indicia_publisher">content4</div>
		</div>


	</section>

</body>

<script type="text/javascript">
	
	function display(mySpan){
		var myValue = mySpan.getAttribute("value");
		document.getElementsByClassName("active")[0].classList.remove("active");
		document.getElementById(myValue).className += " active";
	}

</script>
</html>



<?php include("error_handler.php"); ?>
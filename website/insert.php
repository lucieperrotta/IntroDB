<!DOCTYPE html>
<html>
<?php include("header.php"); ?>
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
						First name: <input type="text" name="FirstName" value="Mickey"><br>
						Last name: <input type="text" name="LastName" value="Mouse"><br>
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
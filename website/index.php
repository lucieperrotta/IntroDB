 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="UTF-8">
 	<title>Grand comics</title>
 	<link rel="stylesheet" type="text/css" href="styles.css">
 </head>

 <body>
 	<div id="wrapperContent">
 		<h1>Grand comics</h1>

 		<form action="process.php" method="post">

 			<fieldset>
 				<h2>Query</h2>
 				<input type="radio" name="query" value="search" checked> Search<br>
 				<input type="radio" name="query" value="insert"> Insert<br>
 				<input type="radio" name="query" value="delete"> Delete
 			</fieldset>

 			<fieldset>
 				<h2>Table name</h2>
 				<input type="radio" name="tableName" value="male" checked> Search<br>
 				<input type="radio" name="tableName" value="female"> Insert<br>
 				<input type="radio" name="tableName" value="other"> Delete
 			</fieldset>

 			<fieldset>
 				<h2>Where parameters</h2>
 				First name:
 				<input type="text" name="firstname"><br/>
 				Last name:
 				<input type="text" name="lastname"><br/>
 			</fieldset>
 			<br/>
 			<input type="submit" value="Submit">

 		</form>


 		<div id="displayContent">
 			Display content here
 		</div>

 	</div>
 </body>

 </html> 
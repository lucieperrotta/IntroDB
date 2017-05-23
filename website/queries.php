<!DOCTYPE html>
<html>
<?php 
include("header.php");
include("../db.php"); 
?>

<?php 

//var_dump($_POST);

if(isset($_POST["query"])){

	$columns;

	$query = $_POST["query"];
	switch($query){
		case "brandGroupHighestNumberBelgiumIndiciaPublisher":
		$sql = "SELECT T.name
		FROM    (
		SELECT  B.name, 
		COUNT(*) AS bid
		FROM    brand_group B,
		indicia_publisher I,
		publisher P,
		country C
		WHERE   C.name = 'Belgium' AND
		C.id = I.country_id AND
		I.publisher_id = P.id AND
		P.id = B.publisher_id
		GROUP BY B.name
		) AS T
		ORDER BY T.bid
		";
		$columns = ["name"];
		break;
		
		case "idNamesPublishersDanishBookSeries":
		$sql = "SELECT  P.id, P.name
		FROM    publisher P,
		country C,
		series S
		WHERE   C.name = 'Denmark' AND
		S.country_id = C.id AND
		S.publisher_id = P.id
		";
		$columns = ["id","name"];
		break;
		
		case "namesSwissSeriesMagazines":
		$sql = 'SELECT  S.name
		FROM    series S,
		country C,
		series_publication_type T
		WHERE   T.name = "magazine" AND
		T.id = S.publication_type_id AND
		S.country_id = C.id AND
		C.name = "Switzerland"
		';
		$columns = ["name"];
		break;

		case "from1990NumberIssuesPerYear":
		$sql = "SELECT  COUNT(*)
		FROM    issue I
		WHERE   I.publication_date >= 1990
		GROUP BY I.publication_date";
		$columns = ["COUNT(*)"];
		break;

		case "numberSeriesIndiciaPublisherDcComics":
		break;

		case "titles10MostReprintedStories":
		$sql = "SELECT  S.title
		FROM    story S,
		story_reprint R
		WHERE   S.id = R.origin_id
		GROUP BY R.origin_id
		ORDER BY COUNT(R.origin_id)
		";
		$columns = ["title"];
		break;

		case "artistScriptDrawnColor":
		$sql = "SELECT  distinct A.name
		FROM    artist A,
		has_script SC,
		has_pencils P,
		has_colors C,
		has_inks I,
		story S
		WHERE   A.id = SC.artist_id AND
		A.id = P.artist_id AND
		A.id = C.artist_id AND
		A.id = I.artist_id AND
		S.id = SC.story_id AND
		S.id = P.story_id AND
		S.id = C.story_id AND
		S.id = I.story_id
		";
		$columns = ["name"];
		break;
		
		case "nonReprintedStoriesBatmanNonFeatured":
		$sql = "SELECT  S.title
		FROM    story S,
		characters C, 
		has_characters HS
		WHERE   0 = (   SELECT COUNT(distinct R.origin_id)
		FROM story_reprint R
		WHERE S.id = R.origin_id
		) AND
		HS.character_id = C.id AND
		HS.story_id = S.id AND
		C.name LIKE '%Batman%'
		";
		$columns = ["title"];
		break;
		
		case "seriesNameHighestNumberIssuesWhoseStoryTypeNotOccuringMost":
		break;
		
		case "namePublisherSeriesAllTypes":
		break;
		
		case "tenMostReprintedCharactersAlanMoore":
		break;
		
		case "writersNatureStoryPencil":
		break;
		
		case "tenPublisherSeries3Languages":
		break;
		
		case "language10000OriginalStoriesMagazinesAndNumber":
		break;
		
		case "allStoryTypesNotPublishedItalianMagazineSeries":
		break;
		
		case "writersCartoonStoriesWritersMoreOneIndicia":
		break;
		
		case "tenBrandGroupsHighestNbIndicia":
		break;
		case "averageSeriesLengthPerIndicia":
		break;
		case "tenIndiciaMostSingleIssueSeries":
		break;
		case "tenIndiciaHighestNumberScriptWritersSingleStory":
		break;
		case "allMarbelHeroesMarvelDC":
		break;
		case "top5SeriesMostIssues":
		break;

	}

	$msc = microtime(true);
	$add_query = $con->query($sql);
	$results = $add_query->fetchAll(PDO::FETCH_ASSOC);
	$msc = microtime(true) - $msc;
	//var_dump($results);
}
?>


<body>


	<?php include("navigation.php"); ?>

	<section id="basic_queries">
		<div id="queries">
			<form action="" method="post">
				<input type="hidden" name="query" value="brandGroupHighestNumberBelgiumIndiciaPublisher"/>
				<input type="submit" value="Print the brand group names with the highest number of Belgian indicia publishers"/>
			</form>
			<form action="" method="post">
				<input type="hidden" name="query" value="idNamesPublishersDanishBookSeries"/>
				<input type="submit" value="Print the ids and names of publishers of Danish book series"/>
			</form>
			<form action="" method="post">
				<input type="hidden" name="query" value="namesSwissSeriesMagazines"/>
				<input type="submit" value="Print the names of all Swiss series that have been published in magazines."/>
			</form>
			<form action="" method="post">
				<input type="hidden" name="query" value="from1990NumberIssuesPerYear"/>
				<input type="submit" value="Starting from 1990, print the number of issues published each year."/>
			</form>
			<form action="" method="post">
				<input type="hidden" name="query" value="numberSeriesIndiciaPublisherDcComics"/>
				<input type="submit" value="Print the number of series for each indicia publisher whose name resembles ‘DC comics’."/>
			</form>
			<form action="" method="post">
				<input type="hidden" name="query" value="titles10MostReprintedStories"/>
				<input type="submit" value="Print the titles of the 10 most reprinted stories"/>
			</form>
			<form action="" method="post">
				<input type="hidden" name="query" value="artistScriptDrawnColor"/>
				<input type="submit" value="Print the artists that have scripted, drawn, and colored at least one of the stories they were involved in"/>
			</form>
			<form action="" method="post">
				<input type="hidden" name="query" value="nonReprintedStoriesBatmanNonFeatured"/>
				<input type="submit" value="Print all non-reprinted stories involving Batman as a non-featured character."/>
			</form>
			<form action="" method="post">
				<input type="hidden" name="query" value="seriesNameHighestNumberIssuesWhoseStoryTypeNotOccuringMost"/>
				<input type="submit" value="Print the series names that have the highest number of issues which contain a story whose type (e.g., cartoon) is not the one occurring most frequently in the database (e.g, illustration)."/>
			</form>
			<form action="" method="post">
				<input type="hidden" name="query" value="namePublisherSeriesAllTypes"/>
				<input type="submit" value="Print the names of publishers who have series with all series types."/>
			</form>
			<form action="" method="post">
				<input type="hidden" name="query" value="writersNatureStoryPencil"/>
				<input type="submit" value="Print the writers of nature-related stories that have also done the pencilwork in all their nature-related stories."/>
			</form>
			<form action="" method="post">
				<input type="hidden" name="query" value="tenPublisherSeries3Languages"/>
				<input type="submit" value="For each of the top-10 publishers in terms of published series, print the 3 most popular languages of their series."/>
			</form>
			<form action="" method="post">
				<input type="hidden" name="query" value="language10000OriginalStoriesMagazinesAndNumber"/>
				<input type="submit" value="Print the languages that have more than 10000 original stories published in magazines, along with the number of those stories."/>
			</form>
			<form action="" method="post">
				<input type="hidden" name="query" value="allStoryTypesNotPublishedItalianMagazineSeries"/>
				<input type="submit" value="Print all story types that have not been published as a part of Italian magazine series."/>
			</form>
			<form action="" method="post">
				<input type="hidden" name="query" value="writersCartoonStoriesWritersMoreOneIndicia"/>
				<input type="submit" value="Print the writers of cartoon stories who have worked as writers for more than one indicia publisher."/>
			</form>
			<form action="" method="post">
				<input type="hidden" name="query" value="tenBrandGroupsHighestNbIndicia"/>
				<input type="submit" value="Print the 10 brand groups with the highest number of indicia publishers."/>
			</form>
			<form action="" method="post">
				<input type="hidden" name="query" value="averageSeriesLengthPerIndicia"/>
				<input type="submit" value="Print the average series length (in terms of years) per indicia publisher."/>
			</form>
			<form action="" method="post">
				<input type="hidden" name="query" value="tenIndiciaMostSingleIssueSeries"/>
				<input type="submit" value="Print the top 10 indicia publishers that have published the most single-issue series."/>
			</form>
			<form action="" method="post">
				<input type="hidden" name="query" value="tenIndiciaHighestNumberScriptWritersSingleStory"/>
				<input type="submit" value="Print the 10 indicia publishers with the highest number of script writers in a single story."/>
			</form>
			<form action="" method="post">
				<input type="hidden" name="query" value="allMarbelHeroesMarvelDC"/>
				<input type="submit" value="Print all Marvel heroes that appear in Marvel-DC story crossovers."/>
			</form>
			<form action="" method="post">
				<input type="hidden" name="query" value="top5SeriesMostIssues"/>
				<input type="submit" value="Print the top 5 series with most issues"/>
			</form>
			<form action="" method="post">
				<input type="hidden" name="query" value="mostReprintedStory"/>
				<input type="submit" value="Given an issue, print its most reprinted story."/>
				<input type="" name="issue" value="1">
			</form>
		</div>
		<div id="results">
			<?php 

			if(isset($_POST["query"])){
				if(!empty($results)) {
					echo "<table>";
					echo '<tr class="titles">';
					for($i=0;$i<sizeof($columns);$i++){
						echo "<td>";
						echo ($columns[$i]) . "<br/>";
						echo "</td>";
					}
					echo "</tr>";
					foreach ($results as $key => $value) {
						echo "<tr>";
						for($i=0;$i<sizeof($columns);$i++){
							echo "<td>";
							echo ($value[$columns[$i]]) . "<br/>";
							echo "</td>";
						}
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

		</div>
	</section>

</body>
</html>

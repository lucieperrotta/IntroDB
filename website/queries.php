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
		$sql = "SELECT T.name FROM(SELECT B.name,  COUNT(*) AS bid FROM brand_group B, indicia_publisher I, country C WHERE	C.name = 'Belgium' AND
		C.id = I.country_id AND I.publisher_id = B.publisher_id
		GROUP BY B.name ) AS T ORDER BY T.bid ";
		$columns = ["name"];
		break;
		
		case "idNamesPublishersDanishBookSeries":
		$sql = "SELECT 	P.id, P.name
FROM 	publisher P,
		series S
WHERE	S.country_id = 56 AND
		S.publisher_id = P.id AND
		S.publication_type_id = 1
		";
		$columns = ["id","name"];
		break;
		
		case "namesSwissSeriesMagazines":
		$sql = 'SELECT  S.name
		FROM    series S,
		series_publication_type T
		WHERE   T.name = "magazine" AND
		T.id = S.publication_type_id AND
		S.country_id = 40
		';
		$columns = ["name"];
		break;

		case "from1990NumberIssuesPerYear":
		$sql = "SELECT 	I.publication_date,
		COUNT(*)
FROM 	issue I
WHERE	I.publication_date >= 1990
GROUP BY I.publication_date";
		$columns = ["publication_date", "COUNT(*)"];
		break;

		case "numberSeriesIndiciaPublisherDcComics":
		$sql = "SELECT 	I.name AS name, 
		COUNT(I.id) AS nb
		FROM 	indicia_publisher I 
		LEFT JOIN series S 
		ON S.publisher_id = I.publisher_id 
		WHERE 	I.name LIKE '%DC_comics%' 
		GROUP BY I.name
		";
		$columns = ["name", "nb"];
		break;

		case "titles10MostReprintedStories":
		$sql = "SELECT	S.title
		FROM 	story S,
		story_reprint R
		WHERE 	S.id = R.origin_id
		GROUP BY R.origin_id
		ORDER BY COUNT(R.origin_id) DESC LIMIT 10
		";
		$columns = ["title"];
		break;

		case "artistScriptDrawnColor":
		$sql = "SELECT 	distinct A.name
		FROM	artist A,
		has_script SC,
		has_pencils P,
		has_colors C,
		has_inks I,
		story S
		WHERE	A.id = SC.artist_id AND
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
		$sql = "SELECT	S.title
FROM 	story S,
		characters C1,
		characters C2,
		has_characters HS,
		has_featured_characters HFC
WHERE	0 =	(	SELECT COUNT(distinct R.origin_id)
			 	FROM story_reprint R
			 	WHERE S.id = R.origin_id
			) AND
		HS.character_id = C1.id AND
		HS.story_id = S.id AND
		C1.name LIKE '%Batman%' AND
		HFC.character_id = C2.id AND
		HFC.story_id = S.id AND
		C2.name NOT LIKE '%Batman%'
		";
		$columns = ["title"];
		break;
		
		case "seriesNameHighestNumberIssuesWhoseStoryTypeNotOccuringMost":
		$sql = "SELECT 	S.name, 
		T2.nbi
		FROM 	(
		SELECT 	I.series_id, 
		COUNT(*) AS nbi
		FROM 	issue I,
		(
		SELECT distinct S.issue_id
		FROM 	story S
		WHERE 	S.type_id <>
		(
		SELECT 	S.type_id
		FROM 	story S
		GROUP BY S.type_id
		ORDER BY COUNT(*) DESC LIMIT 1
		)
		) as T 
		WHERE	I.id = T.issue_id
		GROUP BY I.series_id
		) as T2,
		series S
		WHERE 	S.id = T2.series_id
		ORDER BY T2.nbi DESC
		";
		$columns = ["name", "nbi"];
		break;
		
		case "namePublisherSeriesAllTypes":
		$sql="
		SELECT 	P.name
		FROM 	publisher P
		WHERE 	(SELECT COUNT(distinct SP.name)
		FROM	series_publication_type SP, 
		series S
		WHERE	SP.id = S.publication_type_id AND
		S.publisher_id = P.id
		) = 3
		";
		$columns = ["name"];
		break;
		
		case "tenMostReprintedCharactersAlanMoore":
		$sql="
		SELECT C.name
		FROM	(
		SELECT	HC.character_id,
		COUNT(*) as nch
		FROM 	story_reprint SR,
		artist A, 
		has_script HS, 
		has_characters HC
		WHERE 	HC.story_id = SR.origin_id AND
		HC.story_id = HS.story_id AND
		HS.artist_id = A.id AND
		A.name LIKE '%Alan_Moore%'	
		GROUP BY HC.character_id
		) as T,
		characters C
		WHERE	C.id = T.character_id
		ORDER BY T.nch DESC LIMIT 10
		";
		$columns = ["name"];
		break;
		
		case "writersNatureStoryPencil":
		$sql="
		SELECT 	distinct A.name
		FROM 	artist A, 
		has_script HS
		WHERE	HS.artist_id = A.id AND
		(
		SELECT	COUNT(HS.artist_id)
		FROM	has_pencils HP, 
		story S
		WHERE	HS.story_id = S.id AND
		(S.title LIKE '%natur%' OR
		S.synopsis LIKE '%natur%')
		) = (
		SELECT	COUNT(HS.artist_id)
		FROM	has_pencils HP, 
		story S
		WHERE	HP.artist_id = HS.artist_id AND
		HS.story_id = S.id AND
		HP.story_id = S.id AND
		(S.title LIKE '%natur%' OR
		S.synopsis LIKE '%natur%')
		)
		";
		$columns = ["name"];
		break;
		
		case "tenPublisherSeries3Languages":
		$sql="
		SELECT 	L.name,
		COUNT(*) as nb 
		FROM 	series SE LEFT JOIN 
		( 
		SELECT 	P.id, 
		COUNT(P.id) 
		FROM 	series S,
		publisher P 
		WHERE 	P.id = S.publisher_id
		GROUP BY P.id DESC 
		ORDER BY COUNT(P.id) DESC LIMIT 10
		) as T ON T.id = SE.publisher_id,
		language L 
		WHERE	SE.language_id = L.id 
		GROUP BY L.id 
		ORDER BY nb DESC LIMIT 3
		";
		$columns = ["name", "nb"];
		break;
		
		case "language10000OriginalStoriesMagazinesAndNumber":
		$sql="
		SELECT	T.name, 
		T.num
		FROM	(
		SELECT	distinct L.name, 
		COUNT(*) as num
		FROM	language L,
		series SE,
		story ST, 
		issue I
		WHERE	L.id = SE.language_id AND
		SE.id = I.series_id AND
		I.id = ST.issue_id AND
		SE.publication_type_id = 2 AND
		(SELECT COUNT(*)
		FROM story_reprint SR
		WHERE SR.target_id = ST.id)=0
		GROUP BY L.name
		)as T
		WHERE 	T.num >= 10000
		ORDER BY T.num DESC
		";
		$columns = ["name", "num"];
		break;
		
		case "allStoryTypesNotPublishedItalianMagazineSeries":
		$sql="
		SELECT 	distinct STT.name
		FROM	series SE,
		story ST, 	
		issue I,
		story_type STT
		WHERE	STT.id = ST.type_id AND
		I.id = ST.issue_id AND
		SE.id = I.series_id AND
		SE.country_id <> 51 AND
		SE.publication_type_id = 2
		";
		$columns = ["name"];
		break;
		
		case "writersCartoonStoriesWritersMoreOneIndicia":
		$sql="
		SELECT 	A.name
		FROM 	artist A, 
		has_script HS, 
		story S,
		issue I,
		indicia_publisher IP
		WHERE 	A.id = HS.artist_id AND
		HS.story_id = S.id AND
		S.type_id = 5 AND
		S.issue_id = I.id AND
		I.indicia_publisher_id = IP.id
		GROUP BY A.name
		HAVING COUNT(*) > 1
		";
		$columns = ["name"];
		break;
		
		case "tenBrandGroupsHighestNbIndicia":
		$sql="
		SELECT	distinct BG.name,
		COUNT(*) as ipn
		FROM	indicia_publisher IP, 
		brand_group BG
		WHERE	BG.publisher_id = IP.publisher_id
		GROUP BY BG.name
		ORDER BY ipn DESC LIMIT 10
		";
		$columns = ["name", "ipn"];
		break;

		case "averageSeriesLengthPerIndicia":
		$sql="
		SELECT 	T.name,
		AVG(years) AS average_years
		FROM	(
		SELECT	distinct I.name, 
		(S.year_ended - S.year_began) AS years
		FROM	series S,
		indicia_publisher I
		WHERE	S.year_began < S.year_ended AND 
		S.year_began > 0 AND 
		S.year_ended > 0 AND
		S.publisher_id = I.publisher_id 
		) AS T
		GROUP BY T.name
		";
		$columns = ["name", "average_years"];
		break;

		case "tenIndiciaMostSingleIssueSeries":
		$sql="
		SELECT	I.name, 
		COUNT(*) as nb
		FROM	series S,
		indicia_publisher I
		WHERE	S.first_issue_id = S.last_issue_id AND
		S.publisher_id = I.publisher_id
		GROUP BY I.name
		ORDER BY nb DESC LIMIT 10
		";
		$columns = ["name", "nb"];
		break;

		case "tenIndiciaHighestNumberScriptWritersSingleStory":
		$sql="
		SELECT	S.id, 
		IP.name, 
		COUNT(*) as nb
		FROM	story S, 
		has_script HS,	
		issue I,
		indicia_publisher IP
		WHERE	HS.story_id = S.id AND
		S.issue_id = I.id AND
		I.indicia_publisher_id = IP.id
		GROUP BY S.id, IP.name
		ORDER BY nb DESC LIMIT 10
		";
		$columns = ["id", "name", "nb"];
		break;

		case "allMarbelHeroesMarvelDC":
		$sql="
		
		";
		$columns = [];
		break;

		case "top5SeriesMostIssues":
		$sql="
		SELECT	T.name
		FROM	(
		SELECT	S.name,
		COUNT(*) as inb
		FROM	series S,
		issue I
		WHERE	I.series_id = S.id
		GROUP BY S.id
		) AS T
		ORDER BY T.inb DESC LIMIT 5
		";
		$columns = ["name"];
		break;

		case "mostReprintedStory":
		$id = $_POST["issue"]; 
		$sql = "SELECT  S.title,
		COUNT(*) as nb
		FROM   story S, 
		story_reprint SR
		WHERE  S.issue_id = ".$id." AND
		S.id = SR.origin_id
		GROUP BY S.title
		ORDER BY nb DESC LIMIT 1";
		$columns = ["title"];
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
				<input type="text" name="issue" value="1">
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

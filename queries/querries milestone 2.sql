-- a)
SELECT T.name
FROM	(
		SELECT 	B.name, 
				COUNT(*) AS bid
		FROM 	brand_group B,
				indicia_publisher I,
				country C
		WHERE	C.name = 'Belgium' AND
				C.id = I.country_id AND
				I.publisher_id = B.publisher_id
		GROUP BY B.name
		) AS T
ORDER BY T.bid

-- b)
SELECT 	P.id, P.name
FROM 	publisher P,
		country C,
		series S
WHERE	C.name = 'Denmark' AND
		S.country_id = C.id AND
		S.publisher_id = P.id AND
		S.publication_type_id = 1

-- c)
SELECT	S.name
FROM	series S,
		country C,
		series_publication_type T
WHERE	T.name = 'magazine' AND
		T.id = S.publication_type_id AND
		S.country_id = C.id AND
		C.name = "Switzerland"

-- d)
SELECT 	COUNT(*)
FROM 	issue I,
WHERE	I.publication_date >= 1990
GROUP BY I.publication_date

-- e)
SELECT 	I.name AS name, 
		COUNT(I.id) AS nb
FROM 	indicia_publisher I 
		LEFT JOIN series S 
		ON S.publisher_id = I.publisher_id 
WHERE 	I.name LIKE '%DC_comics%' 
GROUP BY I.name

/*
SELECT T.name, COUNT(*)
FROM	(
		SELECT	I.name
		FROM	indicia_publisher I,
				publisher P,
				series S
		WHERE	I.publisher_id = P.id AND
				S.publisher_id = P.id AND
				I.name LIKE '%DC_comics%'
		) AS T
GROUP BY T.name
*/

-- f)
SELECT	S.title
FROM 	story S,
		story_reprint R
WHERE 	S.id = R.origin_id
GROUP BY R.origin_id
ORDER BY COUNT(R.origin_id) DESC LIMIT 10

-- g)
SELECT 	distinct A.name
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

-- h)
SELECT	S.title
FROM 	story S,
		characters C,
		has_characters HS
WHERE	0 =	(	SELECT COUNT(distinct R.origin_id)
			 	FROM story_reprint R
			 	WHERE S.id = R.origin_id
			) AND
		HS.character_id = C.id AND
		HS.story_id = S.id AND
		C.name LIKE '%Batman%' AND
		S.features NOT LIKE '%Batman%'
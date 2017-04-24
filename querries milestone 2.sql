-- a) not sure ??
SELECT 	B.name
FROM 	brand_group B,
		indicia_publisher I,
		publisher P,
		country C
WHERE	C.name = 'Belgium' AND
		C.id = I.country_id AND
		I.publisher_id = P.id AND
		P.id = B.publisher_id
ORDER BY COUNT(distinct I.id)

-- b)
SELECT 	P.id, P.name
FROM 	publisher P,
		country C,
		series S
WHERE	C.name = 'Danemark' AND
		S.country_id = C.id AND
		S.publisher_id = P.id

-- c)
SELECT	S.name
FROM	series S,
		country C,
		series_publication_type T
WHERE	T.name = 'magazine' AND
		T.id = S.publication_type_id AND
		S.country_id = C.id AND
		C.name = "Switzerland"

-- d) publication_date must be year only!!!
SELECT 	I.publication_date,
		COUNT(distinct I.id)
FROM 	issue I,
GROUP BY I.publication_date

-- e)
SELECT	I.name,
		COUNT (S.id)
FROM	indicia_publisher I,
		publisher P,
		series S
WHERE	I.publisher_id = P.id AND
		S.publisher_id = P.id AND
		I.name LIKE '%DC comics%'

-- f)
SELECT	S.name
FROM 	story S,
		story_reprint R,
WHERE 	S.id = R.origin_id
GROUP BY R.origin_id
ORDER BY COUNT(R.origin_id)

-- g)
SELECT 	distinct A.name
FROM	artist A,
		has_script SC,
		has_pencils P,
		has_color C,
		has_inked I,
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
SELECT	S.name
FROM 	story S
WHERE	0 =	(	SELECT COUNT(distinct R.origin_id)
			 	FROM story_reprint R
			 	WHERE S.id = R.origin_id
			) AND
		0 =	(	SELECT COUNT(distinct HS.story_id)
			 	FROM character C, has_character HS
			 	WHERE HS.character_id = C.id AND
			 	HS.story_id = S.id AND
			 	C.name = 'Batman'
			)
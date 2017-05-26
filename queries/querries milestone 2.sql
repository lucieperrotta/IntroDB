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
		series S
WHERE	S.country_id = 56 AND
		S.publisher_id = P.id AND
		S.publication_type_id = 1

-- c)
SELECT	S.name
FROM	series S,
		series_publication_type T
WHERE	T.name = 'magazine' AND
		T.id = S.publication_type_id AND
		S.country_id = 40

-- d)
SELECT 	I.publication_date,
		COUNT(*)
FROM 	issue I
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

-- f)
SELECT	S.title
FROM 	story S,
		story_reprint R
WHERE 	S.id = R.origin_id
GROUP BY R.origin_id
ORDER BY COUNT(R.origin_id)

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
-- a) ok
SELECT 	S.name, 
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

-- b) ok (improved = hardcode 3)
SELECT 	P.name
FROM 	publisher P
WHERE 	(SELECT COUNT(distinct SP.name)
		FROM	series_publication_type SP, 
				series S
		WHERE	SP.id = S.publication_type_id AND
				S.publisher_id = P.id
	 	) = 3

-- c) improved (no story access)
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

-- d) ok
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

-- e) ok
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

-- f) ok
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

-- g) ok
SELECT 	distinct STT.name
FROM	(
		SELECT	ST.type_id
		FROM	(
				SELECT	I.id
				FROM	series SE,
						issue I
				WHERE	SE.id = I.series_id AND
						SE.country_id <> 51 AND
						SE.publication_type_id = 2
				) as T1,
				story ST
		WHERE	T1.id = ST.issue_id
		) as T2,
		story_type STT
WHERE	STT.id = T2.type_id

--g) ok (improve = hardcore 51 and 2)
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
		
-- g) Dom version
SELECT distinct STT.name 
FROM story ST
LEFT JOIN story_type STT ON STT.id = ST.type_id
LEFT JOIN (
		SELECT I.id 
		FROM issue I 
		RIGHT JOIN (
					SELECT SE.id 
					FROM series SE
					WHERE SE.language_id != 51 AND 
					SE.publication_type_id = 2
					) AS temp ON temp.id = I.series_id
		) AS iss ON ST.issue_id = iss.id

-- h) improvement = hardcode type_id=5
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

-- i) ok
SELECT	distinct BG.name,
		COUNT(*) as ipn
FROM	indicia_publisher IP, 
		brand_group BG
WHERE	BG.publisher_id = IP.publisher_id
GROUP BY BG.name
ORDER BY ipn DESC LIMIT 10

-- j) ok
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

-- k) ok
SELECT	I.name, 
		COUNT(*) as nb
FROM	series S,
		indicia_publisher I
WHERE	S.first_issue_id = S.last_issue_id AND
		S.publisher_id = I.publisher_id
GROUP BY I.name
ORDER BY nb DESC LIMIT 10

-- l) ok
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

-- m) empty result
SELECT	distinct C.name
FROM	characters C,
		has_characters HC,
		has_featured_characters HFC,
		story S1,
		story S2,
		issue I1,
		issue I2,
		indicia_publisher IP1,
		indicia_publisher IP2
WHERE 	HC.character_id = C.id AND
		HC.story_id  = S1.id AND
		HFC.character_id = C.id AND
		HFC.story_id = S2.id AND
		S1.issue_id = I1.id AND
		I1.indicia_publisher_id = IP1.id AND
		IP1.name LIKE 'Marvel' AND
		S2.issue_id = I2.id AND
		I2.indicia_publisher_id = IP2.id AND
		IP2.name LIKE '%Marvel%DC%'
		
-- n) ok
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

-- o) ok
SELECT	S.title,
		COUNT(*) as nb
FROM 	story S, 
		story_reprint SR
WHERE	S.issue_id = 68 AND
		S.id = SR.origin_id
GROUP BY S.title
ORDER BY nb DESC LIMIT 1
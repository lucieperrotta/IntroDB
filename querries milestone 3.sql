-- a) flemme
SELECT 

-- b)
SELECT 	P.name
FROM 	publisher P
WHERE 	(SELECT COUNT(distinct SP.name)
		FROM	series_publication_type SP, 
				series S
		WHERE	SP.id = S.publication_type_id AND
				S.publisher_id = P.id
	 	) =
		(SELECT COUNT(distinct SP.name)
		FROM	series_publication_type SP)

-- c)
SELECT C.name
FROM	(
		SELECT	HC.character_id,
				COUNT(*) as nch
		FROM 	story_reprint SR,
				story S,
				artist A, 
				has_script HS, 
				has_characters HC
		WHERE 	SR.origin_id = S.id AND
				HS.story_id = S.id AND
				HS.artist_id = A.id AND
				A.name LIKE '%Alan_Moore%' AND
				HC.story_id = S.id
		GROUP BY HC.character_id
		) as T,
		characters C
WHERE	C.id = T.character_id
ORDER BY T.nch

-- d)
SELECT 	A.name
FROM 	artist A, 
		has_script HS
WHERE	HS.artist_id = A.id AND
		(
		SELECT	HS.artist_id
		FROM	has_pencils HP, 
				story S
		WHERE	HS.story_id = S.id AND
				(S.title LIKE '%natur%' OR
				S.synopsis LIKE '%natur%')
		) = (
		SELECT	HS.artist_id
		FROM	has_pencils HP, 
				story S
		WHERE	HP.artist_id = HS.artist_id AND
				HS.story_id = S.id AND
				HP.story_id = S.id AND
				(S.title LIKE '%natur%' OR
				S.synopsis LIKE '%natur%')
		)

-- e) hellp
SELECT	T.name
FROM	(
		SELECT	P.id,
				COUNT(*) as num
		FROM	series S,
				publisher P, 
				language L
		WHERE	S.publisher_id = P.id
		GROUP BY P.id
		) as T
ORDER BY T.num LIMIT 10


so long: 10 publishier name in order by series

-- f) left join wont work ???
SELECT	T.name, 
		T.num
FROM	(
		SELECT	L.name, 
				COUNT(*) as num
		FROM	language L,
				series SE,
				story ST, 
				issue I
		LEFT JOIN story_reprint SR ON SR.target_id = ST.id
		WHERE	L.id = SE.language_id AND
				SE.id = I.series_id AND
				I.id = ST.issue_id AND
				SE.publication_type_id = 2 AND
				SR.target_id IS NULL
		GROUP BY L.name
		)as T
ORDER BY T.num LIMIT 10

-- g)

SELECT 	STT.name
FROM 	language L,
		series SE,
		story ST, 	
		issue I,
		story_type STT
WHERE	NOT C.name = 'Italy' AND
		C.id = SE.country_id AND
		SE.id = I.series_id AND
		I.id = ST.issue_id AND
		SE.publication_type_id = 2 AND
		STT.id = ST.type_id

all story types in italian

-- h)
SELECT A.name FROM artist A, has_script HS, Story S, Story_type ST
WHERE 
  A.id = HS.artist_id AND
  HS.story_id = S.id AND
  S.type_id = ST.id AND
  ST.name = "cartoon"
HAVING
  1 =< COUNT(

SELECT IP.id FROM artist A, has_script HS, story S, issue I, series SE, indicia_publisher IP, publisher P
WHERE
  IP.publisher_id = P.id AND
  SE.publisher_id = P.id AND
  I.series_id = SE.id AND
  S.issue_id = I.id AND
  HS.story_id = S.id AND
  A.id = HS.artist_id
GROUP BY IP.id

)

-- i) meh
SELECT	T.name,
		COUNT(*) as ipn
FROM	(
		SELECT	distinct BG.name, IP.id
		FROM	indicia_publisher IP, 
				publisher P,
				brand_group BG
		WHERE	BG.publisher_id = P.id AND
				IP.publisher_id = P.id
		) AS T
GROUP BY T.name
ORDER BY ipn LIMIT 10

-- j)
SELECT T.name,
		AVG(*) as lgh
		(
		SELECT	I.name, S.year_ended-S.year_began
		FROM	series S,
				publisher P,
				indicia_poublisher I
		WHERE	S.publisher_id = P.id AND
				I.publisher_id = P.id
		) as T
GROUP BY T.name
ORDER by lgh

-- k)



-- m) what do you mean crossover ?

-- n)
SELECT	T.name
FROM	(
		SELECT	S.name,
				COUNT(*) as inb
		FROM	series S,
				issue I
		WHERE	I.series_id = S.id
		GROUP BY S.id
		) AS T
ORDER BY T.inb

-- o) help, how to group by on 2 levels
SELECT	I.title,
		S.title
FROM 	issue I, 
		story S, 
		story_reprint SR
WHERE	S.issue_id = I.id AND
		S.id = SR.origin_id

all issues with their reprinted stories
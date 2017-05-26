
-- --------------------------------------------------------

--
-- Structure de la table `story_type`
--

CREATE TABLE `story_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `story_type`
--

INSERT INTO `story_type` (`id`, `name`) VALUES
(1, 'activity'),
(2, 'advertisement'),
(3, '(backcovers) *do not use* / *please fix*'),
(4, 'biography (nonfictional)'),
(5, 'cartoon'),
(6, 'cover'),
(7, 'cover reprint (on interior page)'),
(8, 'credits title page'),
(9, 'filler'),
(10, 'foreword introduction preface afterword'),
(11, 'insert or dust jacket'),
(12, 'letters page'),
(13, 'photo story'),
(14, 'illustration'),
(15, 'character profile'),
(16, 'promo (ad from the publisher)'),
(17, 'public service announcement'),
(18, 'recap'),
(19, 'comic story'),
(20, 'text article'),
(21, 'text story'),
(22, 'statement of ownership'),
(24, 'blank page(s)'),
(25, 'table of contents');

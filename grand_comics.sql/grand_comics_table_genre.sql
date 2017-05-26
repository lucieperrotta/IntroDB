
-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `genre`
--

INSERT INTO `genre` (`id`, `name`) VALUES
(1, 'humor'),
(2, 'anthropomorphic-funny animals'),
(3, 'satire-parody'),
(4, 'advocacy'),
(5, 'drama'),
(6, 'romance'),
(7, 'fantasy'),
(8, 'erotica'),
(9, 'war'),
(10, 'animal'),
(11, 'sports'),
(12, 'Crime'),
(13, 'Adventure'),
(14, 'history'),
(15, 'children'),
(16, 'non-fiction'),
(17, 'historical'),
(18, 'aviation'),
(19, 'science fiction'),
(20, 'detective-mystery'),
(21, 'sword and sorcery'),
(22, 'biography'),
(23, 'domestic'),
(24, 'military'),
(25, 'teen'),
(26, 'jungle'),
(27, 'fashion'),
(28, 'spy'),
(29, 'nature'),
(30, 'superhero'),
(31, 'medical'),
(32, 'horror-suspense');

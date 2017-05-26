
-- --------------------------------------------------------

--
-- Structure de la table `series_publication_type`
--

CREATE TABLE `series_publication_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `series_publication_type`
--

INSERT INTO `series_publication_type` (`id`, `name`) VALUES
(1, 'book'),
(2, 'magazine'),
(3, 'album');

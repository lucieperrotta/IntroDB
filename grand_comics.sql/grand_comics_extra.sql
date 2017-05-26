
--
-- Index pour les tables exportées
--

--
-- Index pour la table `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `brand_group`
--
ALTER TABLE `brand_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `publisher_id_idx` (`publisher_id`),
  ADD KEY `website_id` (`website_id`);

--
-- Index pour la table `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `has_characters`
--
ALTER TABLE `has_characters`
  ADD PRIMARY KEY (`story_id`,`character_id`) USING BTREE,
  ADD KEY `character_id_idx` (`character_id`),
  ADD KEY `story_id_idx` (`story_id`);

--
-- Index pour la table `has_colors`
--
ALTER TABLE `has_colors`
  ADD PRIMARY KEY (`story_id`,`artist_id`),
  ADD KEY `story_id_idx` (`story_id`),
  ADD KEY `artist_id_idx` (`artist_id`);

--
-- Index pour la table `has_editing_issue`
--
ALTER TABLE `has_editing_issue`
  ADD PRIMARY KEY (`issue_id`,`artist_id`),
  ADD KEY `artist_id_editing_issue` (`artist_id`);

--
-- Index pour la table `has_editing_story`
--
ALTER TABLE `has_editing_story`
  ADD PRIMARY KEY (`story_id`,`artist_id`),
  ADD KEY `artist_id_editing` (`artist_id`);

--
-- Index pour la table `has_featured_characters`
--
ALTER TABLE `has_featured_characters`
  ADD PRIMARY KEY (`story_id`,`character_id`) USING BTREE,
  ADD KEY `character_id_feat` (`character_id`);

--
-- Index pour la table `has_genre`
--
ALTER TABLE `has_genre`
  ADD PRIMARY KEY (`genre_id`,`story_id`),
  ADD KEY `genre_id_idx` (`genre_id`),
  ADD KEY `story_id_idx` (`story_id`);

--
-- Index pour la table `has_inks`
--
ALTER TABLE `has_inks`
  ADD PRIMARY KEY (`story_id`,`artist_id`),
  ADD KEY `stpry_Id_idx` (`story_id`),
  ADD KEY `artist_id_idx` (`artist_id`);

--
-- Index pour la table `has_letters`
--
ALTER TABLE `has_letters`
  ADD PRIMARY KEY (`story_id`,`artist_id`),
  ADD KEY `artist_id_letters` (`artist_id`);

--
-- Index pour la table `has_pencils`
--
ALTER TABLE `has_pencils`
  ADD PRIMARY KEY (`story_id`,`artist_id`),
  ADD KEY `id_artist_idx` (`artist_id`),
  ADD KEY `story_id_idx` (`story_id`);

--
-- Index pour la table `has_script`
--
ALTER TABLE `has_script`
  ADD PRIMARY KEY (`story_id`,`artist_id`),
  ADD KEY `story_id_idx` (`story_id`),
  ADD KEY `artist_id_idx` (`artist_id`);

--
-- Index pour la table `indicia_publisher`
--
ALTER TABLE `indicia_publisher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `publisher_id_idx` (`publisher_id`),
  ADD KEY `country_id_idx` (`country_id`),
  ADD KEY `website_id` (`website_id`);

--
-- Index pour la table `issue`
--
ALTER TABLE `issue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `indicia_publisher_id` (`indicia_publisher_id`),
  ADD KEY `series_id` (`series_id`);

--
-- Index pour la table `issue_reprint`
--
ALTER TABLE `issue_reprint`
  ADD PRIMARY KEY (`id`,`origin_id`,`target_id`),
  ADD KEY `origin_issue_id_idx` (`origin_id`),
  ADD KEY `target_issue_id_idx` (`target_id`);

--
-- Index pour la table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_id_idx` (`country_id`),
  ADD KEY `website_id` (`website_id`);

--
-- Index pour la table `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`),
  ADD KEY `first_issue_id_idx` (`first_issue_id`),
  ADD KEY `last_issue_id_idx` (`last_issue_id`),
  ADD KEY `publisher_id_idx` (`publisher_id`),
  ADD KEY `country_id_idx` (`country_id`),
  ADD KEY `language_id_idx` (`language_id`),
  ADD KEY `publication_type_id` (`publication_type_id`);

--
-- Index pour la table `series_publication_type`
--
ALTER TABLE `series_publication_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `story`
--
ALTER TABLE `story`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_id_idx` (`issue_id`),
  ADD KEY `type_id_idx` (`type_id`);

--
-- Index pour la table `story_reprint`
--
ALTER TABLE `story_reprint`
  ADD PRIMARY KEY (`id`,`origin_id`,`target_id`),
  ADD KEY `origin_id_idx` (`origin_id`),
  ADD KEY `target_id_idx` (`target_id`);

--
-- Index pour la table `story_type`
--
ALTER TABLE `story_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `website`
--
ALTER TABLE `website`
  ADD PRIMARY KEY (`id`);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `brand_group`
--
ALTER TABLE `brand_group`
  ADD CONSTRAINT `publisher_id_brand` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `website_id_brand` FOREIGN KEY (`website_id`) REFERENCES `website` (`id`) ON DELETE NO ACTION;

--
-- Contraintes pour la table `has_characters`
--
ALTER TABLE `has_characters`
  ADD CONSTRAINT `character_id_characters` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `story_id_characters` FOREIGN KEY (`story_id`) REFERENCES `story` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `has_colors`
--
ALTER TABLE `has_colors`
  ADD CONSTRAINT `artist_id_colors` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `story_id_colors` FOREIGN KEY (`story_id`) REFERENCES `story` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `has_editing_issue`
--
ALTER TABLE `has_editing_issue`
  ADD CONSTRAINT `artist_id_editing_issue` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `issue_id_editing_issue` FOREIGN KEY (`issue_id`) REFERENCES `issue` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `has_editing_story`
--
ALTER TABLE `has_editing_story`
  ADD CONSTRAINT `artist_id_editing` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `story_id_editing` FOREIGN KEY (`story_id`) REFERENCES `story` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `has_featured_characters`
--
ALTER TABLE `has_featured_characters`
  ADD CONSTRAINT `character_id_feat` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `story_id_feat` FOREIGN KEY (`story_id`) REFERENCES `story` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `has_genre`
--
ALTER TABLE `has_genre`
  ADD CONSTRAINT `genre_id_genre` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `story_id_genre` FOREIGN KEY (`story_id`) REFERENCES `story` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `has_inks`
--
ALTER TABLE `has_inks`
  ADD CONSTRAINT `artist_id_inks` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `story_id_inks` FOREIGN KEY (`story_id`) REFERENCES `story` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `has_letters`
--
ALTER TABLE `has_letters`
  ADD CONSTRAINT `artist_id_letters` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `story_id_letters` FOREIGN KEY (`story_id`) REFERENCES `story` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `has_pencils`
--
ALTER TABLE `has_pencils`
  ADD CONSTRAINT `artist_id_pencils` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `story_id_pencils` FOREIGN KEY (`story_id`) REFERENCES `story` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `has_script`
--
ALTER TABLE `has_script`
  ADD CONSTRAINT `artist_id_script` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `story_id_script` FOREIGN KEY (`story_id`) REFERENCES `story` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `indicia_publisher`
--
ALTER TABLE `indicia_publisher`
  ADD CONSTRAINT `country_id_indicia` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `publisher_id_indicia` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `website_id_indicia` FOREIGN KEY (`website_id`) REFERENCES `website` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Contraintes pour la table `issue`
--
ALTER TABLE `issue`
  ADD CONSTRAINT `indicia_publishier_id_issue` FOREIGN KEY (`indicia_publisher_id`) REFERENCES `indicia_publisher` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `series_id_issue` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `issue_reprint`
--
ALTER TABLE `issue_reprint`
  ADD CONSTRAINT `origin_issue_id_issue_reprint` FOREIGN KEY (`origin_id`) REFERENCES `issue` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `target_issue_id_issue_reprint` FOREIGN KEY (`target_id`) REFERENCES `issue` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `publisher`
--
ALTER TABLE `publisher`
  ADD CONSTRAINT `country_id_publisher` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `website_id_publisher` FOREIGN KEY (`website_id`) REFERENCES `website` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Contraintes pour la table `series`
--
ALTER TABLE `series`
  ADD CONSTRAINT `country_id_series` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `first_issue_id_series` FOREIGN KEY (`first_issue_id`) REFERENCES `issue` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `language_id_series` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `last_issue_id_series` FOREIGN KEY (`last_issue_id`) REFERENCES `issue` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `publisher_id_series` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Contraintes pour la table `story`
--
ALTER TABLE `story`
  ADD CONSTRAINT `issue_id_story` FOREIGN KEY (`issue_id`) REFERENCES `issue` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `type_id_story` FOREIGN KEY (`type_id`) REFERENCES `story_type` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `story_reprint`
--
ALTER TABLE `story_reprint`
  ADD CONSTRAINT `origin_id_reprint` FOREIGN KEY (`origin_id`) REFERENCES `story` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `target_id_reprint` FOREIGN KEY (`target_id`) REFERENCES `story` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

-- Schema mydb

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- `country
CREATE TABLE IF NOT EXISTS `mydb`.`country` (
  `id` INT NOT NULL,
  `code` VARCHAR(4) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`));

-- `website
CREATE TABLE IF NOT EXISTS `mydb`.`website` (
  `id` INT NOT NULL,
  `url` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`));

-- `publisher
CREATE TABLE IF NOT EXISTS `mydb`.`publisher` (
  `id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `country_id` INT NULL,
  `year_began` DATE NOT NULL,
  `year_ended` DATE NULL,
  `notes` TEXT NULL,
  `website_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `country_id_idx` (`country_id` ASC),
  INDEX `website_id_idx` (`website_id` ASC),
  CONSTRAINT `country_id`
    FOREIGN KEY (`country_id`)
    REFERENCES `mydb`.`country` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `website_id`
    FOREIGN KEY (`website_id`)
    REFERENCES `mydb`.`website` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE);

-- `language
CREATE TABLE IF NOT EXISTS `mydb`.`language` (
  `id` INT NOT NULL,
  `code` VARCHAR(4) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`));

-- `series
CREATE TABLE IF NOT EXISTS `mydb`.`series` (
  `id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `format` VARCHAR(255) NULL,
  `year_began` DATE NOT NULL,
  `year_ended` DATE NULL,
  `publication_dates` VARCHAR(255) NULL,
  `first_issue_id` INT NULL,
  `last_issue_id` INT NULL,
  `publisher_id` INT NULL,
  `country_id` INT NULL,
  `language_id` INT NULL,
  `notes` TEXT NULL,
  `color` VARCHAR(255) NULL,
  `dimensions` VARCHAR(255) NULL,
  `paper_stock` VARCHAR(255) NULL,
  `binding` VARCHAR(255) NULL,
  `publishing_format` VARCHAR(255) NULL,
  `publication_type_id` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  INDEX `first_issue_id_idx` (`first_issue_id` ASC),
  INDEX `last_issue_id_idx` (`last_issue_id` ASC),
  INDEX `publisher_id_idx` (`publisher_id` ASC),
  INDEX `country_id_idx` (`country_id` ASC),
  INDEX `language_id_idx` (`language_id` ASC),
  CONSTRAINT `first_issue_id`
    FOREIGN KEY (`first_issue_id`)
    REFERENCES `mydb`.`issue` (`id`)
    ON DELETE SET NULL,
  CONSTRAINT `last_issue_id`
    FOREIGN KEY (`last_issue_id`)
    REFERENCES `mydb`.`issue` (`id`)
    ON DELETE SET NULL,
  CONSTRAINT `publisher_id`
    FOREIGN KEY (`publisher_id`)
    REFERENCES `mydb`.`publisher` (`id`)
    ON DELETE SET NULL,
  CONSTRAINT `country_id`
    FOREIGN KEY (`country_id`)
    REFERENCES `mydb`.`country` (`id`)
    ON DELETE SET NULL,
  CONSTRAINT `language_id`
    FOREIGN KEY (`language_id`)
    REFERENCES `mydb`.`language` (`id`)
    ON DELETE SET NULL);

-- `indicia_publisher
CREATE TABLE IF NOT EXISTS `mydb`.`indicia_publisher` (
  `id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `publisher_id` INT NOT NULL,
  `country_id` INT NULL,
  `year_began` DATE NOT NULL,
  `year_ended` DATE NULL,
  `is_surrogate` TINYINT NULL,
  `notes` TEXT NULL,
  `website_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `publisher_id_idx` (`publisher_id` ASC),
  INDEX `country_id_idx` (`country_id` ASC),
  INDEX `website_id_idx` (`website_id` ASC),
  CONSTRAINT `publisher_id`
    FOREIGN KEY (`publisher_id`)
    REFERENCES `mydb`.`publisher` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `country_id`
    FOREIGN KEY (`country_id`)
    REFERENCES `mydb`.`country` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `website_id`
    FOREIGN KEY (`website_id`)
    REFERENCES `mydb`.`website` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE);

-- `issue
CREATE TABLE IF NOT EXISTS `mydb`.`issue` (
  `id` INT NOT NULL,
  `number` INT NULL,
  `series_id` INT NOT NULL,
  `indicia_publisher_id` INT NOT NULL,
  `publication_date` DATE NULL,
  `page_count` INT NULL,
  `indicia_frequency` VARCHAR(255) NULL,
  `editing` VARCHAR(255) NULL,
  `notes` TEXT NULL,
  `isbn` INT NULL,
  `valid_isbn` INT NULL,
  `barcode` INT NULL,
  `title` VARCHAR(255) NOT NULL,
  `on_sale_date` DATE NULL,
  `rating` INT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  UNIQUE INDEX `series_id_UNIQUE` (`series_id` ASC),
  UNIQUE INDEX `indicia_publisher_id_UNIQUE` (`indicia_publisher_id` ASC),
  CONSTRAINT `series_id`
    FOREIGN KEY (`series_id`)
    REFERENCES `mydb`.`series` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `indicia_publisher_id`
    FOREIGN KEY (`indicia_publisher_id`)
    REFERENCES `mydb`.`indicia_publisher` (`id`)
    ON DELETE CASCADE);

-- `story_type
CREATE TABLE IF NOT EXISTS `mydb`.`story_type` (
  `id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`));

-- `story
CREATE TABLE IF NOT EXISTS `mydb`.`story` (
  `id` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `features` TEXT NULL,
  `issue_id` INT NULL,
  `letters` VARCHAR(255) NULL,
  `editing` VARCHAR(255) NULL,
  `synopsis` VARCHAR(255) NULL,
  `reprint_notes` TEXT NULL,
  `notes` TEXT NULL,
  `type_id` INT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `issue_id_idx` (`issue_id` ASC),
  INDEX `type_id_idx` (`type_id` ASC),
  CONSTRAINT `issue_id`
    FOREIGN KEY (`issue_id`)
    REFERENCES `mydb`.`issue` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `type_id`
    FOREIGN KEY (`type_id`)
    REFERENCES `mydb`.`story_type` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE);

-- `brand_group
CREATE TABLE IF NOT EXISTS `mydb`.`brand_group` (
  `id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `year_began` DATE NOT NULL,
  `year_ended` DATE NULL,
  `notes` TEXT NULL,
  `website_Id` INT NULL,
  `publisher_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `publisher_id_idx` (`publisher_id` ASC),
  INDEX `website_id_idx` (`website_Id` ASC),
  CONSTRAINT `publisher_id`
    FOREIGN KEY (`publisher_id`)
    REFERENCES `mydb`.`publisher` (`id`)
    ON DELETE SET NULL,
  CONSTRAINT `website_id`
    FOREIGN KEY (`website_Id`)
    REFERENCES `mydb`.`website` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE);

-- `story_reprint
CREATE TABLE IF NOT EXISTS `mydb`.`story_reprint` (
  `id` INT NOT NULL,
  `origin_id` INT NOT NULL,
  `target_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `origin_id_idx` (`origin_id` ASC),
  INDEX `target_id_idx` (`target_id` ASC),
  CONSTRAINT `origin_id`
    FOREIGN KEY (`origin_id`)
    REFERENCES `mydb`.`story` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `target_id`
    FOREIGN KEY (`target_id`)
    REFERENCES `mydb`.`story` (`id`)
    ON DELETE CASCADE);

-- `issue_reprint
CREATE TABLE IF NOT EXISTS `mydb`.`issue_reprint` (
  `id` INT NOT NULL,
  `origin_issue_id` INT NOT NULL,
  `target_issue_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `origin_issue_id_idx` (`origin_issue_id` ASC),
  INDEX `target_issue_id_idx` (`target_issue_id` ASC),
  CONSTRAINT `origin_issue_id`
    FOREIGN KEY (`origin_issue_id`)
    REFERENCES `mydb`.`issue` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `target_issue_id`
    FOREIGN KEY (`target_issue_id`)
    REFERENCES `mydb`.`issue` (`id`)
    ON DELETE CASCADE);

-- `series_publication_type
CREATE TABLE IF NOT EXISTS `mydb`.`series_publication_type` (
  `id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`));

-- `artist
CREATE TABLE IF NOT EXISTS `mydb`.`artist` (
  `id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`));

-- `character
CREATE TABLE IF NOT EXISTS `mydb`.`character` (
  `id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`));

-- `genre
CREATE TABLE IF NOT EXISTS `mydb`.`genre` (
  `id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`));

-- `has_pencils
CREATE TABLE IF NOT EXISTS `mydb`.`has_pencils` (
  `id` INT NOT NULL,
  `story_id` INT NOT NULL,
  `artist_id` INT NOT NULL,
  INDEX `id_artist_idx` (`artist_id` ASC),
  INDEX `story_id_idx` (`story_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `story_id`
    FOREIGN KEY (`story_id`)
    REFERENCES `mydb`.`story` (`id`),
  CONSTRAINT `artist_id`
    FOREIGN KEY (`artist_id`)
    REFERENCES `mydb`.`artist` (`id`));

-- `has_genre
CREATE TABLE IF NOT EXISTS `mydb`.`has_genre` (
  `id` INT NOT NULL,
  `genre_id` INT NOT NULL,
  `story_id` INT NOT NULL,
  INDEX `genre_id_idx` (`genre_id` ASC),
  INDEX `story_id_idx` (`story_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `genre_id`
    FOREIGN KEY (`genre_id`)
    REFERENCES `mydb`.`genre` (`id`),
  CONSTRAINT `story_id`
    FOREIGN KEY (`story_id`)
    REFERENCES `mydb`.`story` (`id`));

-- `has_inks
CREATE TABLE IF NOT EXISTS `mydb`.`has_inks` (
  `id` INT NOT NULL,
  `story_id` INT NOT NULL,
  `artist_id` INT NOT NULL,
  INDEX `stpry_Id_idx` (`story_id` ASC),
  INDEX `artist_id_idx` (`artist_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `story_Id`
    FOREIGN KEY (`story_id`)
    REFERENCES `mydb`.`story` (`id`),
  CONSTRAINT `artist_id`
    FOREIGN KEY (`artist_id`)
    REFERENCES `mydb`.`artist` (`id`));

-- `has_colors
CREATE TABLE IF NOT EXISTS `mydb`.`has_colors` (
  `id` INT NOT NULL,
  `story_id` INT NOT NULL,
  `artist_id` INT NOT NULL,
  INDEX `story_id_idx` (`story_id` ASC),
  INDEX `artist_id_idx` (`artist_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `story_id`
    FOREIGN KEY (`story_id`)
    REFERENCES `mydb`.`story` (`id`),
  CONSTRAINT `artist_id`
    FOREIGN KEY (`artist_id`)
    REFERENCES `mydb`.`artist` (`id`));

-- `has_script
CREATE TABLE IF NOT EXISTS `mydb`.`has_script` (
  `id` INT NOT NULL,
  `story_id` INT NOT NULL,
  `artist_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `story_id_idx` (`story_id` ASC),
  INDEX `artist_id_idx` (`artist_id` ASC),
  CONSTRAINT `story_id`
    FOREIGN KEY (`story_id`)
    REFERENCES `mydb`.`story` (`id`),
  CONSTRAINT `artist_id`
    FOREIGN KEY (`artist_id`)
    REFERENCES `mydb`.`artist` (`id`));

-- `price
CREATE TABLE IF NOT EXISTS `mydb`.`price` (
  `id` INT NOT NULL,
  `amount` DECIMAL NOT NULL,
  `currency` VARCHAR(5) NOT NULL,
  PRIMARY KEY (`id`));

-- `has_price
CREATE TABLE IF NOT EXISTS `mydb`.`has_price` (
  `id` INT NOT NULL,
  `issue_id` INT NOT NULL,
  `price_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `price_id_idx` (`price_id` ASC),
  INDEX `issue_id_idx` (`issue_id` ASC),
  CONSTRAINT `price_id`
    FOREIGN KEY (`price_id`)
    REFERENCES `mydb`.`price` (`id`),
  CONSTRAINT `issue_id`
    FOREIGN KEY (`issue_id`)
    REFERENCES `mydb`.`issue` (`id`));

-- `has_characters
CREATE TABLE IF NOT EXISTS `mydb`.`has_characters` (
  `id` INT NOT NULL,
  `character_id` INT NOT NULL,
  `story_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `character_id_idx` (`character_id` ASC),
  INDEX `story_id_idx` (`story_id` ASC),
  CONSTRAINT `character_id`
    FOREIGN KEY (`character_id`)
    REFERENCES `mydb`.`character` (`id`),
  CONSTRAINT `story_id`
    FOREIGN KEY (`story_id`)
    REFERENCES `mydb`.`story` (`id`);
SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
)
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `homestead` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `homestead` ;

-- -----------------------------------------------------
-- Table `homestead`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homestead`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('guide', 'traveler', 'admin') NOT NULL,
  `short_bio` TEXT NULL,
  `long_bio` TEXT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Table `homestead`.`country`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homestead`.`country` (
  `id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Table `homestead`.`city`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homestead`.`city` (
  `id` INT NOT NULL,
  `country_id` INT NULL,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_city_country_idx` (`country_id` ASC),
  CONSTRAINT `fk_city_country`
    FOREIGN KEY (`country_id`)
    REFERENCES `homestead`.`country` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `homestead`.`adventures`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homestead`.`adventures` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `guide_id` INT NOT NULL,
  `description` TEXT NULL,
  `price` DOUBLE NULL,
  `city_id` INT NULL,
  `meeting_point` VARCHAR(255) NULL,
  `start_time` INT NULL,
  `end_time` INT NULL,
  `extra_days` INT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_adventures_1_idx` (`guide_id` ASC),
  INDEX `fk_adventures_city_idx` (`city_id` ASC),
  CONSTRAINT `fk_adventures_1`
    FOREIGN KEY (`guide_id`)
    REFERENCES `homestead`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_adventures_city`
    FOREIGN KEY (`city_id`)
    REFERENCES `homestead`.`city` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `homestead`.`bookings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homestead`.`bookings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `users_id` INT NOT NULL,
  `adventures_id` INT NOT NULL,
  `rate` TEXT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_users_has_adventures_adventures1_idx` (`adventures_id` ASC),
  INDEX `fk_users_has_adventures_users_idx` (`users_id` ASC),
  CONSTRAINT `fk_users_has_adventures_users`
    FOREIGN KEY (`users_id`)
    REFERENCES `homestead`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_adventures_adventures1`
    FOREIGN KEY (`adventures_id`)
    REFERENCES `homestead`.`adventures` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `homestead`.`reviews`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homestead`.`reviews` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `booking_id` INT NULL,
  `rate` INT NULL,
  `comment` TEXT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_reviews_booking_idx` (`booking_id` ASC),
  CONSTRAINT `fk_reviews_booking`
    FOREIGN KEY (`booking_id`)
    REFERENCES `homestead`.`bookings` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `homestead`.`photos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homestead`.`photos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `adventure_id` INT NULL,
  `path` VARCHAR(45) NULL,
  `type` ENUM('adventure', 'user', 'other') NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_photos_adventure_idx` (`adventure_id` ASC),
  INDEX `fk_photos_user_idx` (`user_id` ASC),
  CONSTRAINT `fk_photos_adventure`
    FOREIGN KEY (`adventure_id`)
    REFERENCES `homestead`.`adventures` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_photos_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `homestead`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `homestead`.`calendar`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homestead`.`calendar` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `adventure_id` INT NULL,
  `start_date` DATE NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_calendar_adventure_idx` (`adventure_id` ASC),
  CONSTRAINT `fk_calendar_adventure`
    FOREIGN KEY (`adventure_id`)
    REFERENCES `homestead`.`adventures` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `homestead`.`category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homestead`.`category` (
  `id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Table `homestead`.`adventures_has_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homestead`.`adventures_has_category` (
  `adventures_id` INT NOT NULL,
  `category_id` INT NOT NULL,
  PRIMARY KEY (`adventures_id`, `category_id`),
  INDEX `fk_adventures_has_category_category1_idx` (`category_id` ASC),
  INDEX `fk_adventures_has_category_adventures1_idx` (`adventures_id` ASC),
  CONSTRAINT `fk_adventures_has_category_adventures1`
    FOREIGN KEY (`adventures_id`)
    REFERENCES `homestead`.`adventures` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_adventures_has_category_category1`
    FOREIGN KEY (`category_id`)
    REFERENCES `homestead`.`category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `homestead`.`users_has_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homestead`.`users_has_category` (
  `users_id` INT NOT NULL,
  `category_id` INT NOT NULL,
  PRIMARY KEY (`users_id`, `category_id`),
  INDEX `fk_users_has_category_category1_idx` (`category_id` ASC),
  INDEX `fk_users_has_category_users1_idx` (`users_id` ASC),
  CONSTRAINT `fk_users_has_category_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `homestead`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_category_category1`
    FOREIGN KEY (`category_id`)
    REFERENCES `homestead`.`category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

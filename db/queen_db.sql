-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema queen_db
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema queen_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `queen_db` DEFAULT CHARACTER SET utf8 ;
USE `queen_db` ;

-- -----------------------------------------------------
-- Table `queen_db`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `queen_db`.`usuarios` (
  `idusuarios` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(20) NOT NULL,
  `Apellido` VARCHAR(30) NOT NULL,
  `correo` VARCHAR(75) NOT NULL,
  `contrasena` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`idusuarios`))
ENGINE = InnoDB;

CREATE UNIQUE INDEX `correo_UNIQUE` ON `queen_db`.`usuarios` (`correo` ASC);


-- -----------------------------------------------------
-- Table `queen_db`.`tableros`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `queen_db`.`tableros` (
  `idtableros` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(145) NOT NULL,
  `es_destacado` TINYINT(1) NOT NULL,
  `es_oculto` TINYINT(1) NOT NULL,
  `fecha_creacion` DATE NOT NULL,
  PRIMARY KEY (`idtableros`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `queen_db`.`status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `queen_db`.`status` (
  `idstatus` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(65) NOT NULL,
  `valor` VARCHAR(65) NOT NULL,
  `color` VARCHAR(6) NOT NULL,
  PRIMARY KEY (`idstatus`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `queen_db`.`elementos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `queen_db`.`elementos` (
  `idelementos` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `indice_de_elemento` INT UNSIGNED NOT NULL,
  ` es_lista` TINYINT(1) NOT NULL,
  `contenido` VARCHAR(300) NOT NULL,
  `fecha_deadline` DATE NOT NULL,
  `fecha_creacion` DATE NOT NULL,
  `tableros_idtableros` INT UNSIGNED NOT NULL,
  `status_idstatus` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`idelementos`),
  CONSTRAINT `fk_elementos_tableros`
    FOREIGN KEY (`tableros_idtableros`)
    REFERENCES `queen_db`.`tableros` (`idtableros`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_elementos_status1`
    FOREIGN KEY (`status_idstatus`)
    REFERENCES `queen_db`.`status` (`idstatus`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_elementos_tableros_idx` ON `queen_db`.`elementos` (`tableros_idtableros` ASC);

CREATE INDEX `fk_elementos_status1_idx` ON `queen_db`.`elementos` (`status_idstatus` ASC);


-- -----------------------------------------------------
-- Table `queen_db`.`usuarios_has_tableros`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `queen_db`.`usuarios_has_tableros` (
  `usuarios_idusuarios` INT UNSIGNED NOT NULL,
  `tableros_idtableros` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`usuarios_idusuarios`, `tableros_idtableros`),
  CONSTRAINT `fk_usuarios_has_tableros_usuarios1`
    FOREIGN KEY (`usuarios_idusuarios`)
    REFERENCES `queen_db`.`usuarios` (`idusuarios`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_has_tableros_tableros1`
    FOREIGN KEY (`tableros_idtableros`)
    REFERENCES `queen_db`.`tableros` (`idtableros`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_usuarios_has_tableros_tableros1_idx` ON `queen_db`.`usuarios_has_tableros` (`tableros_idtableros` ASC);

CREATE INDEX `fk_usuarios_has_tableros_usuarios1_idx` ON `queen_db`.`usuarios_has_tableros` (`usuarios_idusuarios` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

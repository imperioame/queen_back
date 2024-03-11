-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema test_queen_back
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema test_queen_back
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `test_queen_back` DEFAULT CHARACTER SET utf8 ;
USE `test_queen_back` ;

-- -----------------------------------------------------
-- Table `test_queen_back`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `test_queen_back`.`queen_usuarios` (
  `idusuarios` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(20) NOT NULL,
  `Apellido` VARCHAR(30) NOT NULL,
  `correo` VARCHAR(75) NOT NULL,
  `contrasena` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`idusuarios`),
  UNIQUE INDEX `correo_UNIQUE` (`correo` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_queen_back`.`tableros`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `test_queen_back`.`queen_tableros` (
  `idtableros` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(145) NOT NULL,
  `es_destacado` TINYINT(1) NOT NULL,
  `es_oculto` TINYINT(1) NOT NULL,
  `fecha_creacion` DATE NOT NULL,
  PRIMARY KEY (`idtableros`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_queen_back`.`status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `test_queen_back`.`queen_status` (
  `idstatus` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(65) NOT NULL,
  `valor` VARCHAR(65) NOT NULL,
  `color` VARCHAR(6) NOT NULL,
  PRIMARY KEY (`idstatus`))
ENGINE = InnoDB;


INSERT INTO `queen_status`(`titulo`, `valor`, `color`) VALUES ('','','');
INSERT INTO `queen_status`(`titulo`, `valor`, `color`) VALUES ('Nuevo','nuevo','9CB5FF');
INSERT INTO `queen_status`(`titulo`, `valor`, `color`) VALUES ('Pendiente','pendiente','EBD265');
INSERT INTO `queen_status`(`titulo`, `valor`, `color`) VALUES ('En progreso','en_progreso','A8FF78');
INSERT INTO `queen_status`(`titulo`, `valor`, `color`) VALUES ('Realizado','realizado','7DF0D4');

-- -----------------------------------------------------
-- Table `test_queen_back`.`elementos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `test_queen_back`.`queen_elementos` (
  `idelementos` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `indice_de_elemento` INT UNSIGNED NOT NULL,
  `contenido` VARCHAR(300) NOT NULL,
  `es_lista` TINYINT(1) NOT NULL,
  `realizado` TINYINT(1) NOT NULL,
  `fecha_deadline` DATE NOT NULL,
  `fecha_creacion` DATE NOT NULL,
  `tableros_idtableros` INT UNSIGNED NOT NULL,
  `status_idstatus` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`idelementos`),
  INDEX `fk_elementos_tableros_idx` (`tableros_idtableros` ASC),
  INDEX `fk_elementos_status1_idx` (`status_idstatus` ASC),
  CONSTRAINT `fk_elementos_tableros`
    FOREIGN KEY (`tableros_idtableros`)
    REFERENCES `test_queen_back`.`queen_tableros` (`idtableros`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_elementos_status1`
    FOREIGN KEY (`status_idstatus`)
    REFERENCES `test_queen_back`.`queen_status` (`idstatus`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_queen_back`.`usuarios_has_tableros`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `test_queen_back`.`queen_usuarios_has_tableros` (
  `usuarios_idusuarios` INT UNSIGNED NOT NULL,
  `tableros_idtableros` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`usuarios_idusuarios`, `tableros_idtableros`),
  INDEX `fk_usuarios_has_tableros_tableros1_idx` (`tableros_idtableros` ASC),
  INDEX `fk_usuarios_has_tableros_usuarios1_idx` (`usuarios_idusuarios` ASC),
  CONSTRAINT `fk_usuarios_has_tableros_usuarios1`
    FOREIGN KEY (`usuarios_idusuarios`)
    REFERENCES `test_queen_back`.`queen_usuarios` (`idusuarios`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_has_tableros_tableros1`
    FOREIGN KEY (`tableros_idtableros`)
    REFERENCES `test_queen_back`.`queen_tableros` (`idtableros`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- MySQL Script generated by MySQL Workbench
-- Fri Jun  9 09:32:32 2017
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema academia_gontijo
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `academia_gontijo` ;

-- -----------------------------------------------------
-- Schema academia_gontijo
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `academia_gontijo` DEFAULT CHARACTER SET utf8 ;
USE `academia_gontijo` ;

-- -----------------------------------------------------
-- Table `academia_gontijo`.`Treinadores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academia_gontijo`.`Treinadores` ;

CREATE TABLE IF NOT EXISTS `academia_gontijo`.`Treinadores` (
  `trei_id` INT NOT NULL AUTO_INCREMENT,
  `trei_nome` VARCHAR(45) NOT NULL,
  `trei_sexo` ENUM('M', 'F') NULL,
  PRIMARY KEY (`trei_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `academia_gontijo`.`Atletas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academia_gontijo`.`Atletas` ;

CREATE TABLE IF NOT EXISTS `academia_gontijo`.`Atletas` (
  `atle_id` INT NOT NULL AUTO_INCREMENT,
  `atle_nome` VARCHAR(45) NOT NULL,
  `atle_cpf` VARCHAR(15) NOT NULL,
  `atle_dt_nasc` DATE NOT NULL,
  `atle_sexo` ENUM('M', 'F') NOT NULL,
  `atle_peso` FLOAT NOT NULL,
  `atle_altura` FLOAT NOT NULL,
  `atle_pretencao` VARCHAR(45) NOT NULL,
  `atle_obs` VARCHAR(200) NULL,
  `atle_trei_id` INT NOT NULL,
  PRIMARY KEY (`atle_id`),
  INDEX `fk_Atletas_Treinadores1_idx` (`atle_trei_id` ASC),
  UNIQUE INDEX `atle_cpf_UNIQUE` (`atle_cpf` ASC),
  CONSTRAINT `fk_Atletas_Treinadores1`
    FOREIGN KEY (`atle_trei_id`)
    REFERENCES `academia_gontijo`.`Treinadores` (`trei_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `academia_gontijo`.`TiposDeTreinos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academia_gontijo`.`TiposDeTreinos` ;

CREATE TABLE IF NOT EXISTS `academia_gontijo`.`TiposDeTreinos` (
  `tptr_id` INT NOT NULL AUTO_INCREMENT,
  `tptr_nome` VARCHAR(45) NOT NULL,
  `tptr_descricao` VARCHAR(45) NULL,
  PRIMARY KEY (`tptr_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `academia_gontijo`.`Exercicios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academia_gontijo`.`Exercicios` ;

CREATE TABLE IF NOT EXISTS `academia_gontijo`.`Exercicios` (
  `exer_id` INT NOT NULL AUTO_INCREMENT,
  `exer_nome` VARCHAR(45) NOT NULL,
  `exer_descricao` VARCHAR(45) NULL,
  `exer_tptr_id` INT NOT NULL,
  PRIMARY KEY (`exer_id`),
  INDEX `fk_Exercicios_TiposDeTreinos1_idx` (`exer_tptr_id` ASC),
  CONSTRAINT `fk_Exercicios_TiposDeTreinos1`
    FOREIGN KEY (`exer_tptr_id`)
    REFERENCES `academia_gontijo`.`TiposDeTreinos` (`tptr_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `academia_gontijo`.`Treinos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academia_gontijo`.`Treinos` ;

CREATE TABLE IF NOT EXISTS `academia_gontijo`.`Treinos` (
  `tren_id` INT NOT NULL AUTO_INCREMENT,
  `tren_atle_id` INT NOT NULL,
  `tren_seq` INT NOT NULL,
  `tren_tptr_id` INT NOT NULL,
  PRIMARY KEY (`tren_id`),
  INDEX `fk_Atletas_has_Exercicios_Atletas_idx` (`tren_atle_id` ASC),
  INDEX `fk_Treinos_TiposDeTreinos1_idx` (`tren_tptr_id` ASC),
  UNIQUE INDEX `unique` (`tren_atle_id` ASC, `tren_seq` ASC, `tren_tptr_id` ASC),
  CONSTRAINT `fk_Atletas_has_Exercicios_Atletas`
    FOREIGN KEY (`tren_atle_id`)
    REFERENCES `academia_gontijo`.`Atletas` (`atle_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Treinos_TiposDeTreinos1`
    FOREIGN KEY (`tren_tptr_id`)
    REFERENCES `academia_gontijo`.`TiposDeTreinos` (`tptr_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `academia_gontijo`.`Treinamentos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academia_gontijo`.`Treinamentos` ;

CREATE TABLE IF NOT EXISTS `academia_gontijo`.`Treinamentos` (
  `trem_tren_id` INT NOT NULL,
  `trem_exer_id` INT NOT NULL,
  `trem_temp` INT NULL,
  `trem_repeticao` INT NULL,
  `trem_serie` INT NULL,
  PRIMARY KEY (`trem_exer_id`, `trem_tren_id`),
  INDEX `fk_Treinamentos_Exercicios1_idx` (`trem_exer_id` ASC),
  INDEX `fk_Treinamentos_Treinos1_idx` (`trem_tren_id` ASC),
  CONSTRAINT `fk_Treinamentos_Exercicios1`
    FOREIGN KEY (`trem_exer_id`)
    REFERENCES `academia_gontijo`.`Exercicios` (`exer_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Treinamentos_Treinos1`
    FOREIGN KEY (`trem_tren_id`)
    REFERENCES `academia_gontijo`.`Treinos` (`tren_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

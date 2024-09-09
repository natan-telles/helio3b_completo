-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema api_rest
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema api_rest
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `api_rest` DEFAULT CHARACTER SET utf8 ;
USE `api_rest` ;

-- -----------------------------------------------------
-- Table `api_rest`.`clientes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `api_rest`.`clientes` (
  `id_cliente` INT NOT NULL AUTO_INCREMENT,
  `nome_cliente` VARCHAR(128) NOT NULL,
  `pedido_cliente` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`id_cliente`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `api_rest`.`empresas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `api_rest`.`empresas` (
  `id_empresa` INT NOT NULL AUTO_INCREMENT,
  `id_cliente_empresa` INT NOT NULL,
  `nome_empresa` VARCHAR(45) NOT NULL,
  `cnpj` VARCHAR(18) NOT NULL,
  PRIMARY KEY (`id_empresa`),
  CONSTRAINT `id_cliente_empresa`
    FOREIGN KEY (`id_cliente_empresa`)
    REFERENCES `api_rest`.`clientes` (`id_cliente`)
)
ENGINE = InnoDB;

CREATE INDEX `id_cliente_empresa_idx` ON `api_rest`.`empresas` (`id_cliente_empresa` ASC);


-- -----------------------------------------------------
-- Table `api_rest`.`estagiarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `api_rest`.`estagiarios` (
  `id_estagiario` INT NOT NULL AUTO_INCREMENT,
  `nome_estagiario` VARCHAR(128) NOT NULL,
  `data_nascimento` DATE NOT NULL,
  `telefone` VARCHAR(14) NOT NULL,
  `email` VARCHAR(128) NOT NULL,
  `id_empresa` INT NOT NULL,
  PRIMARY KEY (`id_estagiario`),
  CONSTRAINT `id_empresa`
    FOREIGN KEY (`id_empresa`)
    REFERENCES `api_rest`.`empresas` (`id_empresa`)
)
ENGINE = InnoDB;

CREATE INDEX `id_empresa_idx` ON `api_rest`.`estagiarios` (`id_empresa` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `api_rest`.`clientes`
-- -----------------------------------------------------
START TRANSACTION;
USE `api_rest`;
INSERT INTO `api_rest`.`clientes` (`id_cliente`, `nome_cliente`, `pedido_cliente`) VALUES (1, 'Bruno', 'quero trocar a lente da minha câmera que veio quebrada');

COMMIT;


-- -----------------------------------------------------
-- Data for table `api_rest`.`empresas`
-- -----------------------------------------------------
START TRANSACTION;
USE `api_rest`;
INSERT INTO `api_rest`.`empresas` (`id_empresa`, `id_cliente_empresa`, `nome_empresa`, `cnpj`) VALUES (1, 1, 'Sony', '99999999999999999');

COMMIT;


-- -----------------------------------------------------
-- Data for table `api_rest`.`estagiarios`
-- -----------------------------------------------------
START TRANSACTION;
USE `api_rest`;
INSERT INTO `api_rest`.`estagiarios` (`id_estagiario`, `nome_estagiario`, `data_nascimento`, `telefone`, `email`, `id_empresa`) VALUES (1, 'Natan Soares Telles', '2007-04-23', '(12)99181-0319', 'oemaildonatan@gmail.com', 1);

COMMIT;

create table login (
	usuario varchar(45),
    senha varchar(45)
);

insert into login (usuario, senha) values ("admin","admin");



CREATE SCHEMA IF NOT EXISTS `commandes_clients` DEFAULT CHARACTER SET latin1 ;
USE `commandes_clients` ;

-- -----------------------------------------------------
-- Table `commandes_clients`.`pays`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `commandes_clients`.`pays` (
  `id_pays` CHAR(3) NOT NULL DEFAULT '',
  `nom_pays` VARCHAR(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_pays`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `commandes_clients`.`villes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `commandes_clients`.`villes` (
  `cp` CHAR(6) NOT NULL,
  `nom_ville` VARCHAR(50) NOT NULL,
  `id_pays` CHAR(3) NOT NULL DEFAULT '',
  PRIMARY KEY (`cp`),
  INDEX `FK_villes_id_pays` (`id_pays` ASC),
  CONSTRAINT `FK_villes_id_pays`
    FOREIGN KEY (`id_pays`)
    REFERENCES `commandes_clients`.`pays` (`id_pays`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `commandes_clients`.`clients`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `commandes_clients`.`clients` (
  `id_client` INT(5) NOT NULL AUTO_INCREMENT,
  `nom_client` VARCHAR(50) NOT NULL,
  `date_naissance` DATE NULL DEFAULT NULL,
  `cp` CHAR(6) NOT NULL,
  `prenom_client` VARCHAR(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_client`),
  INDEX `FK_clients_ville` (`cp` ASC),
  INDEX `I_clients_nom_prenom` (`nom_client` ASC, `prenom_client` ASC),
  CONSTRAINT `FK_clients_ville`
    FOREIGN KEY (`cp`)
    REFERENCES `commandes_clients`.`villes` (`cp`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `commandes_clients`.`cdes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `commandes_clients`.`cdes` (
  `id_cde` INT(5) NOT NULL AUTO_INCREMENT,
  `date_cde` DATE NOT NULL,
  `id_client` INT(5) NOT NULL,
  PRIMARY KEY (`id_cde`),
  INDEX `FK_cdes_client` (`id_client` ASC),
  CONSTRAINT `FK_cdes_client`
    FOREIGN KEY (`id_client`)
    REFERENCES `commandes_clients`.`clients` (`id_client`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 17
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `commandes_clients`.`produits`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `commandes_clients`.`produits` (
  `id_produit` INT(5) NOT NULL AUTO_INCREMENT,
  `designation` VARCHAR(50) NOT NULL,
  `prix` DOUBLE(7,2) NULL DEFAULT NULL,
  `qte_stockee` INT(5) NULL DEFAULT NULL,
  PRIMARY KEY (`id_produit`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `commandes_clients`.`ligcdes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `commandes_clients`.`ligcdes` (
  `id_cde` INT(5) NOT NULL,
  `id_produit` INT(5) NOT NULL,
  `qte` INT(5) NOT NULL,
  PRIMARY KEY (`id_cde`, `id_produit`),
  INDEX `FK_ligcdes_id_produit` (`id_produit` ASC),
  CONSTRAINT `FK_ligcdes_id_cde`
    FOREIGN KEY (`id_cde`)
    REFERENCES `commandes_clients`.`cdes` (`id_cde`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `FK_ligcdes_id_produit`
    FOREIGN KEY (`id_produit`)
    REFERENCES `commandes_clients`.`produits` (`id_produit`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;



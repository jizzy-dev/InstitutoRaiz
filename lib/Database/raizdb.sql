-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `raizdb` DEFAULT CHARACTER SET utf8mb4 ;
USE `raizdb` ;

-- -----------------------------------------------------
-- Table `raizdb`.`turma`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `raizdb`.`turma` (
  `ID_TURMA` INT NOT NULL AUTO_INCREMENT,
  `nome_turma` VARCHAR(20) NOT NULL,
  `periodo` ENUM('manha', 'tarde') NOT NULL,
  PRIMARY KEY (`ID_TURMA`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -----------------------------------------------------
-- Table `raizdb`.`imagem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `raizdb`.`imagem` (
  `ID_IMAGEM` INT NOT NULL AUTO_INCREMENT,
  `imgCaminho` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`ID_IMAGEM`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -----------------------------------------------------
-- Table `raizdb`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `raizdb`.`usuario` (
  `ID_USER` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(80) NOT NULL,
  `cpf` VARCHAR(11) UNIQUE NOT NULL,
  `rg` VARCHAR(9) NOT NULL,
  `contato` VARCHAR(12) NOT NULL,
  `email` VARCHAR(80) UNIQUE NOT NULL,
  `senha` VARCHAR(256) NOT NULL,
  `data_nasc` DATE NOT NULL,
  `cep` VARCHAR(12) NOT NULL,
  `logradouro` VARCHAR(80) NOT NULL,
  `bairro` VARCHAR(50) NOT NULL,
  `numero_endereco` VARCHAR(5) NOT NULL,
  `complemento` VARCHAR(20) NOT NULL,
  `cidade` VARCHAR(80) NOT NULL,
  `estado` VARCHAR(50) NOT NULL,
  `isResponsavel` TINYINT(1) NULL DEFAULT NULL,
  `isPadrinho` TINYINT(1) NULL DEFAULT NULL,
  `perfil_acesso` ENUM('A', 'M', 'D', 'U') NOT NULL DEFAULT 'U',
  `ID_IMAGEM` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`ID_USER`),
  INDEX `fk_Usuario_Imagem_idx` (`ID_IMAGEM` ASC),
  CONSTRAINT `fk_Usuario_Imagem`
    FOREIGN KEY (`ID_IMAGEM`)
    REFERENCES `raizdb`.`imagem` (`ID_IMAGEM`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -----------------------------------------------------
-- Table `raizdb`.`aluno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `raizdb`.`aluno` (
  `ID_ALUNO` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(80) NOT NULL,
  `cpf` VARCHAR(11) UNIQUE NOT NULL,
  `rg` VARCHAR(9) NOT NULL,
  `data_nasc` DATE NOT NULL,
  `certidao` VARCHAR(32) UNIQUE NOT NULL,
  `carteira_vacina` VARCHAR(45) UNIQUE NOT NULL,
  `situacao_matricula` ENUM('pendente', 'aprovado', 'reprovado') NOT NULL,
  `data_matricula` DATE NOT NULL,
  `data_inicio` DATE NOT NULL,
  `ID_TURMA` INT NOT NULL,
  `ID_USER_RESPONSAVEL` INT NOT NULL,
  `ID_USER_PADRINHO` INT NOT NULL,
  PRIMARY KEY (`ID_ALUNO`),
  INDEX `fk_Aluno_Turma_idx` (`ID_TURMA` ASC),
  INDEX `fk_Aluno_Usuario1_idx` (`ID_USER_RESPONSAVEL` ASC),
  INDEX `fk_Aluno_Usuario2_idx` (`ID_USER_PADRINHO` ASC),
  CONSTRAINT `fk_Aluno_Turma`
    FOREIGN KEY (`ID_TURMA`)
    REFERENCES `raizdb`.`turma` (`ID_TURMA`),
  CONSTRAINT `fk_Aluno_Usuario1`
    FOREIGN KEY (`ID_USER_RESPONSAVEL`)
    REFERENCES `raizdb`.`usuario` (`ID_USER`),
  CONSTRAINT `fk_Aluno_Usuario2`
    FOREIGN KEY (`ID_USER_PADRINHO`)
    REFERENCES `raizdb`.`usuario` (`ID_USER`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -----------------------------------------------------
-- Table `raizdb`.`frequencia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `raizdb`.`frequencia` (
  `ID_FREQUENCIA` INT NOT NULL AUTO_INCREMENT,
  `data_aula` DATE NOT NULL,
  `presenca` ENUM('P','F') NOT NULL,
  `ID_ALUNO` INT NOT NULL,
  `ID_TURMA` INT NOT NULL,
  PRIMARY KEY (`ID_FREQUENCIA`),
  INDEX `fk_Frequencia_Aluno1_idx` (`ID_ALUNO` ASC),
  INDEX `fk_Frequencia_Turma1_idx` (`ID_TURMA` ASC),
  CONSTRAINT `fk_Frequencia_Aluno1`
    FOREIGN KEY (`ID_ALUNO`)
    REFERENCES `raizdb`.`aluno` (`ID_ALUNO`),
  CONSTRAINT `fk_Frequencia_Turma1`
    FOREIGN KEY (`ID_TURMA`)
    REFERENCES `raizdb`.`turma` (`ID_TURMA`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -----------------------------------------------------
-- Insert `raizdb`.`imagem`
-- -----------------------------------------------------
INSERT INTO `imagem` (`ID_IMAGEM`, `imgCaminho`) VALUES
(1, 'https://localhost/InstitutoRaiz/public/assets/images/vectors/icons/user-placeholder-vector.svg');

-- -----------------------------------------------------
-- Insert `raizdb`.`turma`
-- -----------------------------------------------------
INSERT INTO `turma` (`ID_TURMA`, `nome_turma`, `periodo`) VALUES
(1, 'Turma A', 'manha'),
(2, 'Turma B', 'tarde');

-- -----------------------------------------------------
-- Insert `raizdb`.`usuario`
-- -----------------------------------------------------
INSERT INTO `usuario` (`ID_USER`, `nome`, `cpf`, `rg`, `contato`, `email`, `senha`, `data_nasc`, `cep`, `logradouro`, `bairro`, `numero_endereco`, `complemento`, `cidade`, `estado`, `isResponsavel`, `isPadrinho`, `isAdm`, `isMod`, `ID_IMAGEM`) VALUES
(1, 'Ana', '12345678901', '98765412', '11999887777', 'teste@email.com', '', '2024-05-03', '077190', 'Rua Brad Pitt', 'Hollywood', '100', '', 'Franco da Rocha', 'São Paulo', 0, 0, 0, 0, 1),
(6, 'João', '23123123', '123123', '321321321', 'email@email.com', '', '2024-05-11', '2131312', 'adasd', 'adsa', '213', 'ads', 'asd', 'asd', 0, 0, 0, 0, 1);

-- -----------------------------------------------------
-- Insert `raizdb`.`aluno`
-- -----------------------------------------------------
INSERT INTO `aluno` (`ID_ALUNO`, `nome`, `cpf`, `rg`, `data_nasc`, `certidao`, `carteira_vacina`, `situacao_matricula`, `data_matricula`, `data_inicio`, `ID_TURMA`, `ID_USER_RESPONSAVEL`, `ID_USER_PADRINHO`) VALUES
(1, 'João', '2132131', '12213133', '2024-05-20', '12321313211231', '132213123211', 'pendente', '2024-05-20', '2024-05-20', 2, 1, 1),
(2, 'Karol', '3333', '222222', '2024-05-19', '55555', '666666', 'aprovado', '2024-05-08', '2024-05-02', 1, 1, 1),
(3, 'Jeziel', '31231', '23131', '2024-05-21', '21313', '123123', 'pendente', '2024-05-21', '2024-05-21', 1, 1, 1);
-- -----------------------------------------------------
-- Views
-- -----------------------------------------------------
CREATE VIEW vw_aluno_validar_tempo_padrinho AS
SELECT *
FROM `aluno`
WHERE DATE_ADD(data_inicio, INTERVAL 1 YEAR) <= CURDATE();

CREATE VIEW vw_padrinho AS
SELECT *
FROM `usuario`
WHERE isPadrinho = 1;
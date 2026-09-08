-- Banco de dados Faustino Motors Multimarcas
-- Compatível com MariaDB/MySQL

SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
SET time_zone = '+00:00';
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS `faustino_motors_multimarcas`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE `faustino_motors_multimarcas`;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `veiculos_opcionais`;
DROP TABLE IF EXISTS `veiculos`;
DROP TABLE IF EXISTS `vendas`;
DROP TABLE IF EXISTS `modelos`;
DROP TABLE IF EXISTS `marcas`;
DROP TABLE IF EXISTS `opcionais`;
DROP TABLE IF EXISTS `usuarios`;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE `marcas` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nome` varchar(100) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `marcas` (`id`, `nome`) VALUES
    (1, 'Ford'),
    (2, 'Chevrolet'),
    (4, 'Fiat'),
    (7, 'Audi'),
    (8, 'Volkswagen'),
    (9, 'BYD'),
    (10, 'Toyota');

ALTER TABLE `marcas` AUTO_INCREMENT = 11;

CREATE TABLE `modelos` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `id_marca` int(11) NOT NULL,
    `nome` varchar(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `modelos` (`id`, `id_marca`, `nome`) VALUES
    (1, 1, 'Ka 1.0 2p'),
    (2, 1, 'Fiesta 1.6 ROCAN'),
    (4, 2, 'Prisma 1.4'),
    (7, 7, 'A4'),
    (8, 7, 'TT 2'),
    (9, 9, 'Dolphin'),
    (10, 10, 'Hilux');

ALTER TABLE `modelos` AUTO_INCREMENT = 11;

CREATE TABLE `opcionais` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nome` varchar(500) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `opcionais` (`id`, `nome`) VALUES
    (1, 'Ar condicionado'),
    (2, 'Vidro Elétrico'),
    (3, 'Banco de Couro'),
    (4, 'Airbag');

ALTER TABLE `opcionais` AUTO_INCREMENT = 5;

CREATE TABLE `usuarios` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nome` varchar(100) NOT NULL,
    `email` varchar(150) NOT NULL,
    `senha` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`) VALUES
    (1, 'admin_alexandre', 'alexandre.faustino1308@gmail.com', '$2y$10$gnTdBjja9SwokWtgVTNsheNn6sTLrHzuOB2Iw6OGJ63QgXaSCclkm'),
    (2, 'admin_luis', 'rubioluisgustavo@gmail.com', '$2y$10$gnTdBjja9SwokWtgVTNsheNn6sTLrHzuOB2Iw6OGJ63QgXaSCclkm'),
    (3, 'admin_pedro', 'pedrotelesbrito@gmail.com', '$2y$10$gnTdBjja9SwokWtgVTNsheNn6sTLrHzuOB2Iw6OGJ63QgXaSCclkm');

ALTER TABLE `usuarios` AUTO_INCREMENT = 4;

CREATE TABLE `veiculos` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `id_modelo` int(11) NOT NULL,
    `ano` varchar(10) DEFAULT NULL,
    `km` varchar(100) DEFAULT NULL,
    `cambio` enum('manual','automatico') NOT NULL,
    `combustivel` enum('flex','gasolina','etanol','diesel','eletrico','hibrido') NOT NULL,
    `valor` int(11) DEFAULT NULL,
    `valor_premium` int(11) DEFAULT NULL,
    `imagem_principal` varchar(255) DEFAULT NULL,
    `descricao` varchar(1000) DEFAULT NULL,
    `novo` enum('y','n') NOT NULL DEFAULT 'n',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `veiculos` (
    `id`,
    `id_modelo`,
    `ano`,
    `km`,
    `cambio`,
    `combustivel`,
    `valor`,
    `valor_premium`,
    `imagem_principal`,
    `descricao`,
    `novo`
) VALUES
    (9, 8, '2015', '130555', 'manual', 'flex', 120000, 125000, 'img/carros/1788547492_6a9b11a4f1dcb.jpg', 'a', 'y'),
    (10, 4, '2014', '120000', 'manual', 'etanol', 30000, NULL, 'img/carros/1788547488_6a9b11a049e59.jpg', '', 'y'),
    (11, 9, '2025', '100000', 'automatico', 'hibrido', 200000, 205000, 'img/carros/1788547478_6a9b1196eb92c.jpg', '', 'y'),
    (12, 10, '2010', '120000', 'manual', 'diesel', 125000, NULL, 'img/carros/1788547460_6a9b1184346c4.jpg', 'Hilux impecável', 'y');

ALTER TABLE `veiculos` AUTO_INCREMENT = 13;

CREATE TABLE `veiculos_opcionais` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `id_veiculo` int(11) NOT NULL,
    `id_opcionais` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `veiculos_opcionais` (`id`, `id_veiculo`, `id_opcionais`) VALUES
    (76, 12, 1),
    (77, 12, 3),
    (78, 12, 2),
    (81, 10, 1),
    (82, 10, 2),
    (85, 9, 4),
    (86, 9, 2),
    (87, 11, 1),
    (88, 11, 2);

ALTER TABLE `veiculos_opcionais` AUTO_INCREMENT = 89;

CREATE TABLE `vendas` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nome` varchar(255) DEFAULT NULL,
    `imagem_principal` varchar(255) DEFAULT NULL,
    `depoimento` longtext DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `vendas` (`id`, `nome`, `imagem_principal`, `depoimento`) VALUES
    (1, 'Zé2', 'img/vendas/1788551140_6a9b1fe4d57ed5.36251248.jpg', 'ótima compra'),
    (2, 'Pedro teles', 'img/vendas/1788551402_6a9b20eae759b2.71812269.jpg', 'compra melhor de todas');

ALTER TABLE `vendas` AUTO_INCREMENT = 3;


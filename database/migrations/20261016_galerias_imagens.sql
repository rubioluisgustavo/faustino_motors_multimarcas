ALTER TABLE `veiculos`
    MODIFY `ano` varchar(20) DEFAULT NULL,
    MODIFY `descricao` LONGTEXT DEFAULT NULL;

CREATE TABLE IF NOT EXISTS `veiculo_imagens` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `id_veiculo` int(11) NOT NULL,
    `imagem` varchar(255) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_veiculo_imagens_veiculo` (`id_veiculo`),
    CONSTRAINT `fk_veiculo_imagens_veiculo`
        FOREIGN KEY (`id_veiculo`) REFERENCES `veiculos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `venda_imagens` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `id_venda` int(11) NOT NULL,
    `imagem` varchar(255) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_venda_imagens_venda` (`id_venda`),
    CONSTRAINT `fk_venda_imagens_venda`
        FOREIGN KEY (`id_venda`) REFERENCES `vendas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

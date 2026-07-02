CREATE TABLE `campeonatos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `temporada` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `times` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `tecnico` varchar(100) DEFAULT NULL,
  `escudo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `token_validacao` varchar(64) DEFAULT NULL,
  `conta_ativa` tinyint(1) DEFAULT 0,
  `token_recuperacao` varchar(64) DEFAULT NULL,
  `recuperacao_expira_em` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `jogadores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `idade` int(11) DEFAULT NULL,
  `posicao` varchar(50) DEFAULT NULL,
  `numero_camisa` int(11) DEFAULT NULL,
  `overall` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `id_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_time` (`id_time`),
  CONSTRAINT `jogadores_ibfk_1` FOREIGN KEY (`id_time`) REFERENCES `times` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `jogador_campeonato` (
  `id_jogador` int(11) DEFAULT NULL,
  `id_campeonato` int(11) DEFAULT NULL,
  KEY `id_jogador` (`id_jogador`),
  KEY `id_campeonato` (`id_campeonato`),
  CONSTRAINT `jogador_campeonato_ibfk_1` FOREIGN KEY (`id_jogador`) REFERENCES `jogadores` (`id`),
  CONSTRAINT `jogador_campeonato_ibfk_2` FOREIGN KEY (`id_campeonato`) REFERENCES `campeonatos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
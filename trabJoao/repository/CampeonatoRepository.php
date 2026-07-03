<?php

require_once __DIR__ . '/../entity/Campeonato.php'; 

class CampeonatoRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function listarTodos(): array {
        $stmt = $this->pdo->query("SELECT * FROM campeonatos ORDER BY ano DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar(Campeonato $campeonato): bool {
        $sql = "INSERT INTO campeonatos (nome, ano, premiacao) VALUES (:nome, :ano, :premiacao)";
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            ':nome'      => $campeonato->getNome(),
            ':ano'       => $campeonato->getAno(),
            ':premiacao' => $campeonato->getPremiacao()
        ]);
    }
}
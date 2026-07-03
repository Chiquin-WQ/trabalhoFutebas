<?php

require_once __DIR__ . '/../entity/Campeonato.php'; 

class CampeonatoRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function listarTodos(): array {
        $stmt = $this->pdo->query("SELECT * FROM campeonatos ORDER BY ano DESC, nome ASC");
        $resultados = $stmt->fetchAll();

        $campeonatos = [];
        foreach ($resultados as $dados) {
            $campeonatos[] = new Campeonato($dados);
        }

        return $campeonatos;
    }

    public function salvar(Campeonato $campeonato): bool {
        $sql = "INSERT INTO campeonatos (nome, ano, premiacao) VALUES (:nome, :ano, :premiacao)";
        
        $stmt = $this->pdo->prepare($sql);
        
        $executou = $stmt->execute([
            ':nome'      => $campeonato->getNome(),
            ':ano'       => $campeonato->getAno(),
            ':premiacao' => $campeonato->getPremiacao()
        ]);

        if ($executou) {
            $campeonato->registrarIdGerado((int)$this->pdo->lastInsertId());
        }

        return $executou;
    }
}
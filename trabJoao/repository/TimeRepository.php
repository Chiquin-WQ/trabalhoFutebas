<?php

class TimeRepository {

    private PDO $pdo;

    public function __construct() {
        require_once __DIR__ . '/../config/database.php';
        
        global $pdo;
        $this->pdo = $pdo;
    }

    // Busca todos os times do banco ordenados por nome
    public function listarTodos(): array {
        $stmt = $this->pdo->query('SELECT * FROM times ORDER BY nome ASC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cadastra um novo time baseado nos campos reais da sua tabela
    public function cadastrar(string $nome, string $cidade, string $tecnico, ?string $escudo = null): bool {
        $sql = "INSERT INTO times (nome, cidade, tecnico, escudo) 
                VALUES (:nome, :cidade, :tecnico, :escudo)";
                
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            ':nome'    => $nome,
            ':cidade'  => $cidade,
            ':tecnico' => $tecnico,
            ':escudo'  => $escudo
        ]);
    }
}
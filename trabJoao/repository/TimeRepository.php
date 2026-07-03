<?php

class TimeRepository {

    private PDO $pdo;

    public function __construct() {
        require_once __DIR__ . '/../config/database.php';
        
        global $pdo;
        
        if (!isset($pdo) || $pdo === null) {
            try {
                $pdo = new PDO("mysql:host=127.0.0.1;dbname=futebas;charset=utf8mb4", "root", "");
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro de conexão: " . $e->getMessage());
            }
        }
        
        $this->pdo = $pdo;
    }

    public function listarTodos(): array {
        $stmt = $this->pdo->query('SELECT * FROM times ORDER BY nome ASC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function buscarPorId(int $id): ?array {
        $stmt = $this->pdo->prepare('SELECT * FROM times WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        return $dados ? $dados : null;
    }

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

    public function atualizar(int $id, string $nome, string $cidade, string $tecnico): bool {
        $sql = "UPDATE times SET nome = :nome, cidade = :cidade, tecnico = :tecnico WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'      => $id,
            ':nome'    => $nome,
            ':cidade'  => $cidade,
            ':tecnico' => $tecnico
        ]);
    }

    public function deletar(int $id): bool {
        $sql = "DELETE FROM times WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../entity/Usuario.php';

class UsuarioRepository {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConexao();
    }

    public function buscarPorEmail(string $email): ?Usuario {
      
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $dados = $stmt->fetch();

        if ($dados) {
            return new Usuario($dados);
        }

        return null;
    }

    
    public function cadastrar(string $nome, string $email, string $senha, string $tokenValidacao): bool {
        // O campo conta_ativa entra como 0 (falso) por padrão até o usuário validar no e-mail
        $sql = "INSERT INTO usuarios (nome, email, senha, token_validacao, conta_ativa) 
                VALUES (:nome, :email, :senha, :token_validacao, 0)";
                
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            ':nome'            => $nome,
            ':email'           => $email,
            ':senha'           => hash('sha256', $senha),
            ':token_validacao' => $tokenValidacao
        ]);
    }
}
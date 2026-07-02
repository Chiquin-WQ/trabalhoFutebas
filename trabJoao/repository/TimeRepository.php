<?php

class TimeRepository {
    private PDO $pdo;

    public function __construct() {
        require_once __DIR__ . '/../config/database.php';
        
        // Tentamos pegar a variável global $pdo
        global $pdo;
        
        // Se a global não existir ou estiver vazia, criamos a conexão direto aqui como plano B
        if (!isset($pdo) || $pdo === null) {
            try {
                $pdo = new PDO("mysql:host=127.0.0.1;dbname=futebas;charset=utf8mb4", "root", "");
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro na conexão com o banco: " . $e->getMessage());
            }
        }
        
        $this->pdo = $pdo;
    }
    }

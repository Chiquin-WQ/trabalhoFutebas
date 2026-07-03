<?php

require_once __DIR__ . '/../entity/Jogador.php'; 

class JogadorRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function buscarPorId(int $id): ?Jogador {
        $stmt = $this->pdo->prepare("SELECT * FROM jogadores WHERE id = ?");
        $stmt->execute([$id]);
        $dados = $stmt->fetch();

        if (!$dados) {
            return null;
        }

        return new Jogador($dados);
    }

    public function listarTodos(): array {
        $stmt = $this->pdo->query("SELECT * FROM jogadores ORDER BY nome ASC");
        $resultados = $stmt->fetchAll();

        $jogadores = [];
        foreach ($resultados as $dados) {
            $jogadores[] = new Jogador($dados);
        }

        return $jogadores;
    }

    public function salvar(Jogador $jogador): bool {
        $sql = "INSERT INTO jogadores (nome, idade, posicao, numero_camisa, overall, foto, id_time) 
                VALUES (:nome, :idade, :posicao, :numero_camisa, :overall, :foto, :id_time)";
        
        $stmt = $this->pdo->prepare($sql);
        
        $executou = $stmt->execute([
            ':nome'          => $jogador->getNome(),
            ':idade'         => $jogador->getIdade(),
            ':posicao'       => $jogador->getPosicao(),
            ':numero_camisa' => $jogador->getNumeroCamisa(),
            ':overall'       => $jogador->getOverall(),
            ':foto'          => $jogador->getFoto(),
            ':id_time'       => $jogador->getIdTime()
        ]);

        if ($executou) {
            $jogador->registrarIdGerado((int)$this->pdo->lastInsertId());
        }

        return $executou;
    }

    public function atualizar(Jogador $jogador): bool {
        $sql = "UPDATE jogadores SET 
                    nome = :nome, 
                    idade = :idade, 
                    posicao = :posicao, 
                    numero_camisa = :numero_camisa, 
                    overall = :overall, 
                    foto = :foto, 
                    id_time = :id_time
                WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            ':id'            => $jogador->getId(),
            ':nome'          => $jogador->getNome(),
            ':idade'         => $jogador->getIdade(),
            ':posicao'       => $jogador->getPosicao(),
            ':numero_camisa' => $jogador->getNumeroCamisa(),
            ':overall'       => $jogador->getOverall(),
            ':foto'          => $jogador->getFoto(),
            ':id_time'       => $jogador->getIdTime()
        ]);
    }

    public function excluir(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM jogadores WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
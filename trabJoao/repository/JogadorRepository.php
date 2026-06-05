<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../entity/Jogador.php';

class JogadorRepository {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConexao();
    }

    /** @return Jogador[] */
    public function listar(): array {

        $stmt = $this->pdo->query(
            'SELECT * FROM jogadores ORDER BY nome ASC'
        );

        $lista = [];

        foreach ($stmt->fetchAll() as $dados) {
            $lista[] = new Jogador($dados);
        }

        return $lista;
    }

    public function buscarPorId(int $id): ?Jogador {

        $stmt = $this->pdo->prepare(
            'SELECT * FROM jogadores WHERE id = :id LIMIT 1'
        );

        $stmt->execute([
            ':id' => $id
        ]);

        $dados = $stmt->fetch();

        if ($dados) {
            return new Jogador($dados);
        }

        return null;
    }

    public function salvar(Jogador $jogador): void {

        if ($jogador->getId() > 0) {

            $stmt = $this->pdo->prepare(
                'UPDATE jogadores
                SET
                    nome = :nome,
                    idade = :idade,
                    posicao = :posicao,
                    numero_camisa = :numero_camisa,
                    overall = :overall,
                    foto = :foto,
                    id_time = :id_time
                WHERE id = :id'
            );

            $stmt->execute([
                ':nome'           => $jogador->getNome(),
                ':idade'          => $jogador->getIdade(),
                ':posicao'        => $jogador->getPosicao(),
                ':numero_camisa'  => $jogador->getNumeroCamisa(),
                ':overall'        => $jogador->getOverall(),
                ':foto'           => $jogador->getFoto(),
                ':id_time'        => $jogador->getIdTime(),
                ':id'             => $jogador->getId()
            ]);

            return;
        }

        $stmt = $this->pdo->prepare(
            'INSERT INTO jogadores
            (
                nome,
                idade,
                posicao,
                numero_camisa,
                overall,
                foto,
                id_time
            )
            VALUES
            (
                :nome,
                :idade,
                :posicao,
                :numero_camisa,
                :overall,
                :foto,
                :id_time
            )'
        );

        $stmt->execute([
            ':nome'           => $jogador->getNome(),
            ':idade'          => $jogador->getIdade(),
            ':posicao'        => $jogador->getPosicao(),
            ':numero_camisa'  => $jogador->getNumeroCamisa(),
            ':overall'        => $jogador->getOverall(),
            ':foto'           => $jogador->getFoto(),
            ':id_time'        => $jogador->getIdTime()
        ]);

        $jogador->registrarIdGerado(
            (int) $this->pdo->lastInsertId()
        );
    }

    public function inserir(
        string $nome,
        int $idade,
        string $posicao,
        int $numeroCamisa,
        int $overall,
        string $foto,
        int $idTime
    ): void {

        $jogador = Jogador::novo(
            $nome,
            $idade,
            $posicao,
            $numeroCamisa,
            $overall,
            $foto,
            $idTime
        );

        $this->salvar($jogador);
    }

    public function atualizar(
        int $id,
        string $nome,
        int $idade,
        string $posicao,
        int $numeroCamisa,
        int $overall,
        string $foto,
        int $idTime
    ): void {

        $jogador = $this->buscarPorId($id);

        if ($jogador === null) {
            throw new RuntimeException('Jogador não encontrado.');
        }

        $jogador->alterarDados(
            $nome,
            $idade,
            $posicao,
            $numeroCamisa,
            $overall,
            $foto
        );

        $this->salvar($jogador);
    }

    public function excluir(int $id): void {

        $stmt = $this->pdo->prepare(
            'DELETE FROM jogadores WHERE id = :id'
        );

        $stmt->execute([
            ':id' => $id
        ]);
    }
}
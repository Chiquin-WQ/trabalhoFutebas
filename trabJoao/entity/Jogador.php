<?php

class Jogador {
    private ?int $id;
    private string $nome;
    private int $idade;
    private string $posicao;
    private int $numero_camisa;
    private int $overall;
    private ?string $foto;
    private int $id_time;
    private int $status;

    public function __construct(array $dados = []) {
        $this->id            = $dados['id'] ?? null;
        $this->nome          = $dados['nome'] ?? '';
        $this->idade         = $dados['idade'] ?? 0;
        $this->posicao       = $dados['posicao'] ?? '';
        $this->numero_camisa = $dados['numero_camisa'] ?? 0;
        $this->overall       = $dados['overall'] ?? 0;
        $this->foto          = $dados['foto'] ?? '';
        $this->id_time       = $dados['id_time'] ?? 0;
        $this->status        = $dados['status'] ?? 1;
    }

    public function getId(): ?int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function getIdade(): int { return $this->idade; }
    public function getPosicao(): string { return $this->posicao; }
    public function getNumeroCamisa(): int { return $this->numero_camisa; }
    public function getOverall(): int { return $this->overall; }
    public function getFoto(): string { return $this->foto ?? ''; }
    public function getIdTime(): int { return $this->id_time; }
    public function getStatus(): int { return $this->status; }

    public function registrarIdGerado(int $id): void {
        $this->id = $id;
    }
}
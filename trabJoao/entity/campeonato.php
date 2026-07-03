<?php

class Campeonato {
    private ?int $id;
    private string $nome;
    private int $ano;
    private string $premiacao;

    public function __construct(array $dados = []) {
        $this->id        = $dados['id'] ?? null;
        $this->nome      = $dados['nome'] ?? '';
        $this->ano       = $dados['ano'] ?? date('Y');
        $this->premiacao = $dados['premiacao'] ?? '';
    }

    public function getId(): ?int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function getAno(): int { return $this->ano; }
    public function getPremiacao(): string { return $this->premiacao; }

    public function registrarIdGerado(int $id): void {
        $this->id = $id;
    }
}
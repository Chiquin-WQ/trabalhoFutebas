<?php

class Jogador {
    private ?int $id;
    private string $nome;
    private string $posicao;
    private int $idade;
    private int $idTime;
    private ?string $nomeTime;

    public function __construct(?int $id, string $nome, string $posicao, int $idade, int $idTime, ?string $nomeTime = null) {
        $this->id = $id;
        $this->nome = $nome;
        $this->posicao = $posicao;
        $this->idade = $idade;
        $this->idTime = $idTime;
        $this->nomeTime = $nomeTime;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function getPosicao(): string {
        return $this->posicao;
    }

    public function setPosicao(string $posicao): void {
        $this->posicao = $posicao;
    }

    public function getIdade(): int {
        return $this->idade;
    }

    public function setIdade(int $idade): void {
        $this->idade = $idade;
    }

    public function getIdTime(): int {
        return $this->idTime;
    }

    public function setIdTime(int $idTime): void {
        $this->idTime = $idTime;
    }

    public function getNomeTime(): ?string {
        return $this->nomeTime;
    }

    public function setNomeTime(?string $nomeTime): void {
        $this->nomeTime = $nomeTime;
    }
}
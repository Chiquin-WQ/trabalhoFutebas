<?php

class Jogador {

    public $id;
    public $nome;
    public $idade;
    public $posicao;
    public $numero_camisa;
    public $overall;
    public $foto;
    public $id_time;

}

    public function __construct(array $dados) {
    $this->id             = (int) ($dados['id'] ?? 0);
    $this->nome           = $dados['nome'] ?? '';
    $this->idade          = (int) ($dados['idade'] ?? 0);
    $this->posicao        = $dados['posicao'] ?? '';
    $this->numeroCamisa   = (int) ($dados['numero_camisa'] ?? 0);
    $this->overall        = (int) ($dados['overall'] ?? 0);
    $this->foto           = $dados['foto'] ?? '';
    $this->idTime         = (int) ($dados['id_time'] ?? 0);
}

public function getId(): int {
    return $this->id;
}

public function getNome(): string {
    return $this->nome;
}

public function getIdade(): int {
    return $this->idade;
}

public function getPosicao(): string {
    return $this->posicao;
}

public function getNumeroCamisa(): int {
    return $this->numeroCamisa;
}

public function getOverall(): int {
    return $this->overall;
}

public function getFoto(): string {
    return $this->foto;
}

public function getIdTime(): int {
    return $this->idTime;
}

public static function novo(
    string $nome,
    int $idade,
    string $posicao,
    int $numeroCamisa,
    int $overall,
    string $foto,
    int $idTime
): Jogador {

    if ($idTime <= 0) {
        throw new InvalidArgumentException('Time inválido.');
    }

    $jogador = new Jogador([
        'id_time' => $idTime
    ]);

    $jogador->alterarDados(
        $nome,
        $idade,
        $posicao,
        $numeroCamisa,
        $overall,
        $foto
    );

    return $jogador;
}

public function alterarDados(
    string $nome,
    int $idade,
    string $posicao,
    int $numeroCamisa,
    int $overall,
    string $foto
): void {

    $nome = trim($nome);
    $posicao = trim($posicao);

    if ($nome === '') {
        throw new InvalidArgumentException('Nome obrigatório.');
    }

    if ($idade <= 0) {
        throw new InvalidArgumentException('Idade inválida.');
    }

    $posicoes = [
        'Goleiro',
        'Zagueiro',
        'Lateral',
        'Meia',
        'Atacante'
    ];

    if (!in_array($posicao, $posicoes)) {
        throw new InvalidArgumentException('Posição inválida.');
    }

    if ($numeroCamisa <= 0 || $numeroCamisa > 99) {
        throw new InvalidArgumentException('Número da camisa inválido.');
    }

    if ($overall < 0 || $overall > 99) {
        throw new InvalidArgumentException('Overall deve ser entre 0 e 99.');
    }

    $this->nome = $nome;
    $this->idade = $idade;
    $this->posicao = $posicao;
    $this->numeroCamisa = $numeroCamisa;
    $this->overall = $overall;
    $this->foto = $foto;
}

public function registrarIdGerado(int $id): void {

    if ($id <= 0) {
        throw new InvalidArgumentException('ID inválido.');
    }

    $this->id = $id;
}
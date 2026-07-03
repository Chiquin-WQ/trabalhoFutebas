<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../repository/JogadorRepository.php';
// Importamos o repositório de times para listar as opções no formulário
require_once __DIR__ . '/../repository/TimeRepository.php';

$erro = '';

// Buscamos todos os times cadastrados para listar no <select>
try {
    $timeRepository = new TimeRepository();
    $timesCadastrados = $timeRepository->listarTodos();
} catch (Exception $e) {
    $timesCadastrados = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nome = $_POST['nome'];
        $idade = (int) $_POST['idade'];
        $posicao = $_POST['posicao'];
        $numeroCamisa = (int) $_POST['numero_camisa'];
        $overall = (int) $_POST['overall'];
        $idTime = (int) $_POST['id_time'];

        $foto = '';

        if (!empty($_FILES['foto']['name'])) {
            $arquivo = $_FILES['foto'];
            $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
            $permitidas = ['jpg', 'png', 'webp'];

            if (!in_array($extensao, $permitidas)) {
                throw new Exception('Formato de imagem inválido. Use JPG, PNG ou WEBP.');
            }

            if ($arquivo['size'] > 2 * 1024 * 1024) {
                throw new Exception('A imagem não pode ser maior que 2MB.');
            }

            $pastaDestino = '../assets/uploads/';
            if (!is_dir($pastaDestino)) {
                mkdir($pastaDestino, 0755, true);
            }

            $nomeArquivo = uniqid() . '.' . $extensao;

            move_uploaded_file(
                $arquivo['tmp_name'],
                $pastaDestino . $nomeArquivo
            );

            $foto = $nomeArquivo;
        }

        // Importante: A classe Jogador precisa estar carregada ou pelo autoload, 
        // ou sendo incluída dentro do JogadorRepository.php
        $jogador = new Jogador([
            'nome'          => $nome,
            'idade'         => $idade,
            'posicao'       => $posicao,
            'numero_camisa' => $numeroCamisa,
            'overall'       => $overall,
            'foto'          => $foto,
            'id_time'       => $idTime,
            'status'        => 1
        ]);

        $repository = new JogadorRepository($pdo);
        $repository->salvar($jogador);

        header('Location: index.php');
        exit;

    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Convocar Jogador — Futebas Club</title>
  <link rel="stylesheet" href="../assets/style.css" />
  <style>
      /* Garantindo que o select herde os estilos bonitos dos inputs do seu projeto */
      select {
          width: 100%;
          padding: 10px;
          border: 1px solid #ccc;
          border-radius: 4px;
          background-color: white;
          box-sizing: border-box;
          font-size: 14px;
      }
  </style>
</head>
<body>

<div class="container">
  <div class="form-card">
    <div class="page-header">
      <h2>Inscrição de Jogador 🏆</h2>
      <a href="index.php" class="btn btn-ghost">← Voltar</a>
    </div>

    <?php if ($erro): ?>
      <div class="alert alert-erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="nome">Nome do Craque</label>
        <input type="text" id="nome" name="nome" placeholder="Ex: Neymar Jr" required>
      </div>

      <div class="form-group">
        <label for="idade">Idade</label>
        <input type="number" id="idade" name="idade" placeholder="Ex: 28" min="15" max="50">
      </div>

      <div class="form-group">
        <label for="posicao">Posição</label>
        <input type="text" id="posicao" name="posicao" placeholder="Ex: Atacante" required>
      </div>

      <div class="form-group">
        <label for="numero_camisa">Número da Camisa</label>
        <input type="number" id="numero_camisa" name="numero_camisa" placeholder="Ex: 10" min="1" max="99">
      </div>

      <div class="form-group">
        <label for="overall">Overall (Nível do jogador)</label>
        <input type="number" id="overall" name="overall" placeholder="Ex: 89" min="1" max="99">
      </div>

      <!-- AQUI A MÁGICA ACONTECE: TROCAMOS O INPUT POR UM SELECT DINÂMICO -->
      <div class="form-group">
        <label for="id_time">Time / Seleção</label>
        <select id="id_time" name="id_time" required>
            <option value="">-- Selecione um Time --</option>
            <?php foreach ($timesCadastrados as $time): ?>
                <option value="<?= $time['id'] ?>">
                    <?= htmlspecialchars($time['nome']) ?> (<?= htmlspecialchars($time['cidade'] ?? 'Sem Cidade') ?>)
                </option>
            <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="foto">Foto de Perfil</label>
        <input type="file" id="foto" name="foto" accept="image/*">
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Convocar Jogador</button>
        <a href="index.php" class="btn btn-ghost">Cancelar</a>
      </div>
    </form>
  </div>
</div>

</body>
</html>
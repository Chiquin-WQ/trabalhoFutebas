<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../repository/JogadorRepository.php';

$erro = '';

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

        $jogador = new Jogador(
            null,
            $nome,
            $posicao,
            $idade,
            $numeroCamisa,
            $overall,
            $foto,
            $idTime,
            1
        );

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

      <div class="form-group">
        <label for="id_time">ID da Seleção / Time</label>
        <input type="number" id="id_time" name="id_time" placeholder="Ex: 1" required>
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
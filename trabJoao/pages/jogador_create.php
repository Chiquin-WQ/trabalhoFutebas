<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../repository/JogadorRepository.php';
require_once __DIR__ . '/../repository/TimeRepository.php';

$erro = '';
try {
    $timeRepository = new TimeRepository($pdo);
    $timesCadastrados = $timeRepository->listarTodos();
} catch (Exception $e) {
    $timesCadastrados = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $jogador = new Jogador([
            'nome' => $_POST['nome'],
            'idade' => (int) $_POST['idade'],
            'posicao' => $_POST['posicao'],
            'numero_camisa' => (int) $_POST['numero_camisa'],
            'overall' => (int) $_POST['overall'],
            'id_time' => (int) $_POST['id_time'],
            'status' => 1
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
  <meta charset="UTF-8">
  <title>Convocar Jogador — Futebas</title>
  <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>

<div class="container">
  <div class="form-card">
    <div class="page-header">
      <h2>Convocar Jogador 🏆</h2>
      <a href="index.php" class="btn btn-ghost">Voltar</a>
    </div>

    <?php if ($erro): ?>
      <div class="alert alert-erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="nome">Nome do Craque</label>
        <input type="text" id="nome" name="nome" required>
      </div>

      <div class="form-group">
        <label for="idade">Idade</label>
        <input type="number" id="idade" name="idade">
      </div>

      <div class="form-group">
        <label for="posicao">Posição</label>
        <input type="text" id="posicao" name="posicao">
      </div>

      <div class="form-group">
        <label for="numero_camisa">Número da Camisa</label>
        <input type="number" id="numero_camisa" name="numero_camisa">
      </div>

      <div class="form-group">
        <label for="overall">Overall</label>
        <input type="number" id="overall" name="overall">
      </div>

      <div class="form-group">
        <label for="id_time">Time / Seleção</label>
        <select id="id_time" name="id_time" required>
            <option value="">-- Selecione --</option>
            <?php foreach ($timesCadastrados as $time): ?>
                <option value="<?= $time['id'] ?>"><?= htmlspecialchars($time['nome']) ?></option>
            <?php endforeach; ?>
        </select>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Convocar Jogador</button>
      </div>
    </form>
  </div>
</div>

</body>
</html>
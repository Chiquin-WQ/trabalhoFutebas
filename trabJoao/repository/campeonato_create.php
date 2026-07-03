<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../repository/CampeonatoRepository.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $campeonato = new Campeonato([
            'nome'      => $_POST['nome'],
            'ano'       => (int) $_POST['ano'],
            'premiacao' => $_POST['premiacao']
        ]);

        $repository = new CampeonatoRepository($pdo);
        $repository->salvar($campeonato);

        header('Location: index.php');
        exit;

    } catch (Exception $e) {
        $erro = "Erro ao cadastrar: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Criar Campeonato — Futebas Club</title>
  <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>

<div class="container">
  <div class="form-card">
    <div class="page-header">
      <h2>Novo Campeonato 🏆</h2>
      <a href="index.php" class="btn btn-ghost">← Voltar</a>
    </div>

    <?php if ($erro): ?>
      <div class="alert alert-erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label for="nome">Nome do Campeonato</label>
        <input type="text" id="nome" name="nome" placeholder="Ex: Copa do Mundo" required>
      </div>

      <div class="form-group">
        <label for="ano">Ano</label>
        <input type="number" id="ano" name="ano" placeholder="Ex: 2026" value="<?= date('Y') ?>" required>
      </div>

      <div class="form-group">
        <label for="premiacao">Premiação</label>
        <input type="text" id="premiacao" name="premiacao" placeholder="Ex: R$ 50.000,00" required>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Criar Campeonato</button>
        <a href="index.php" class="btn btn-ghost">Cancelar</a>
      </div>
    </form>
  </div>
</div>

</body>
</html>
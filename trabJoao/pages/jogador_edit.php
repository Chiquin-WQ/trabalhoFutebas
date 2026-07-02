<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../repository/JogadorRepository.php';

$repository = new JogadorRepository();

$id = (int) ($_GET['id'] ?? 0);

$jogador = $repository->buscarPorId($id);

if (!$jogador) {
    header('Location: index.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nome = $_POST['nome'];
        $idade = (int) $_POST['idade'];
        $posicao = $_POST['posicao'];
        $numeroCamisa = (int) $_POST['numero_camisa'];
        $overall = (int) $_POST['overall'];
        $idTime = (int) $_POST['id_time'];

        $foto = $jogador->getFoto();

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

        $repository->atualizar(
            $id,
            $nome,
            $idade,
            $posicao,
            $numeroCamisa,
            $overall,
            $foto,
            $idTime
        );

        header('Location: index.php');
        exit;

    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}

require_once __DIR__ . '/../includes/header.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Editar Jogador — Futebas Club</title>
  <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>

<div class="container">
  <div class="form-card">
    <div class="page-header">
      <h2>Editar Dados do Craque 📝</h2>
      <a href="index.php" class="btn btn-ghost">← Voltar</a>
    </div>

    <?php if ($erro): ?>
      <div class="alert alert-erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="nome">Nome do Craque</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($jogador->getNome()) ?>" required>
      </div>

      <div class="form-group">
        <label for="idade">Idade</label>
        <input type="number" id="idade" name="idade" value="<?= $jogador->getIdade() ?>" min="15" max="50">
      </div>

      <div class="form-group">
        <label for="posicao">Posição</label>
        <input type="text" id="posicao" name="posicao" value="<?= htmlspecialchars($jogador->getPosicao()) ?>" required>
      </div>

      <div class="form-group">
        <label for="numero_camisa">Número da Camisa</label>
        <input type="number" id="numero_camisa" name="numero_camisa" value="<?= $jogador->getNumeroCamisa() ?>" min="1" max="99">
      </div>

      <div class="form-group">
        <label for="overall">Overall (Nível do jogador)</label>
        <input type="number" id="overall" name="overall" value="<?= $jogador->getOverall() ?>" min="1" max="99">
      </div>

      <div class="form-group">
        <label for="id_time">ID da Seleção / Time</label>
        <input type="number" id="id_time" name="id_time" value="<?= $jogador->getIdTime() ?>" required>
      </div>

      <div class="form-group">
        <label for="foto">Alterar Foto de Perfil</label>
        <input type="file" id="foto" name="foto" accept="image/*">
        
        <?php if ($jogador->getFoto()): ?>
          <div style="margin-top: 15px;">
            <p style="font-size: 0.85rem; margin-bottom: 5px; color: var(--ink-soft);">Foto atual:</p>
            <img 
              src="../assets/uploads/<?= htmlspecialchars($jogador->getFoto()) ?>" 
              alt="Foto Atual" 
              style="width: 90px; height: 90px; object-fit: cover; border: 2px solid var(--ink); box-shadow: 3px 3px 0px #000;"
            >
          </div>
        <?php endif; ?>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Atualizar Informações</button>
        <a href="index.php" class="btn btn-ghost">Cancelar</a>
      </div>
    </form>
  </div>
</div>

</body>
</html>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
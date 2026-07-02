<?php

session_start();

if (!empty($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/../repository/UsuarioRepository.php';

$erro = '';
$emailFormulario = $_POST['email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($email === '' || $senha === '') {
        $erro = 'Preencha todos os campos.';
    } else {
        $repo    = new UsuarioRepository();
        $usuario = $repo->buscarPorEmail($email);


        if ($usuario && hash('sha256', $senha) === $usuario->getSenha()) {
            
          
            if ($usuario->getContaAtiva() === 0) {
                $erro = 'Sua conta ainda não foi ativada. Verifique seu e-mail.';
            } else {
                $_SESSION['usuario_id']   = $usuario->getId();
                $_SESSION['usuario_nome'] = $usuario->getNome();

                header('Location: index.php');
                exit;
            }
            
        } else {
            $erro = 'E-mail ou senha inválidos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Acesso ao Sistema — Futebas Club</title>
  <link rel="stylesheet" href="../assets/style.css" />
</head>
<body class="login-body">

<div class="login-card">
  <div class="login-logo">FUTEBAS FC</div>
  <h1 class="login-title">Área Técnica — Entrar</h1>

  <?php if ($erro !== ''): ?>
    <div class="alert alert-erro"><?= htmlspecialchars($erro) ?></div>
  <?php endif; ?>

  <form method="POST" action="login.php">
    <div class="form-group">
      <label for="email">E-mail do Treinador</label>
      <input type="email" id="email" name="email" value="<?= htmlspecialchars($emailFormulario) ?>" required />
    </div>

    <div class="form-group">
      <label for="senha">Chave de Acesso</label>
      <input type="password" id="senha" name="senha" required />
    </div>

    <button type="submit" class="btn btn-primary btn-full">Entrar em Campo</button>
  </form>

  <div class="login-hint" style="margin-top: 15px; display: flex; justify-content: space-between; font-size: 0.85rem;">
    <a href="cadastro.php">Registrar Treinador</a>
    <a href="esqueci_senha.php" style="color: var(--ink-soft);">Esqueci a senha 🔑</a>
  </div>
</div>

</body>
</html>
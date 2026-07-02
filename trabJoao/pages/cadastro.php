<?php

session_start();

if (!empty($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/../repository/UsuarioRepository.php';

$erro = '';
$sucesso = '';
$nomeFormulario = $_POST['nome'] ?? '';
$emailFormulario = $_POST['email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($nome === '' || $email === '' || $senha === '') {
        $erro = 'Preencha todos os campos.';
    } else {
        $repo = new UsuarioRepository();
        
        if ($repo->buscarPorEmail($email)) {
            $erro = 'Este e-mail já está cadastrado.';
        } else {
            $tokenValidacao = bin2hex(random_bytes(32));

            if ($repo->cadastrar($nome, $email, $senha, $tokenValidacao)) {
                $linkSimulado = "verificar.php?token=" . $tokenValidacao;
                $sucesso = "Inscrição realizada! Como estamos em ambiente de teste, ative a conta clicando no botão abaixo: <br><br><a href='$linkSimulado' class='btn btn-primary' style='display:inline-block; text-decoration:none;'>Ativar Conta de Treinador 🏆</a>";
            } else {
                $erro = 'Erro ao realizar o cadastro. Tente novamente.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastrar — Futebas Club</title>
  <link rel="stylesheet" href="../assets/style.css" />
</head>
<body class="login-body">

<div class="login-card">
  <div class="login-logo">FUTEBAS FC</div>
  <h1 class="login-title">Nova Conta de Treinador</h1>

  <?php if ($erro !== ''): ?>
    <div class="alert alert-erro"><?= htmlspecialchars($erro) ?></div>
  <?php endif; ?>

  <?php if ($sucesso !== ''): ?>
    <div class="alert alert-sucesso" style="background: #d1fae5; border: 2px solid #065f46; padding: 15px; margin-bottom: 25px; font-size: 0.9rem; line-height: 1.4; color: #065f46;">
        <?= $sucesso ?>
    </div>
  <?php endif; ?>

  <?php if ($sucesso === ''): ?>
  <form method="POST" action="cadastro.php">
    <div class="form-group">
      <label for="nome">Nome do Treinador</label>
      <input
        type="text"
        id="nome"
        name="nome"
        placeholder="Ex: Professor Tite"
        value="<?= htmlspecialchars($nomeFormulario) ?>"
        required
      />
    </div>

    <div class="form-group">
      <label for="email">E-mail</label>
      <input
        type="email"
        id="email"
        name="email"
        placeholder="seu@email.com"
        value="<?= htmlspecialchars($emailFormulario) ?>"
        required
      />
    </div>

    <div class="form-group">
      <label for="senha">Senha</label>
      <input
        type="password"
        id="senha"
        name="senha"
        placeholder="••••••••"
        required
      />
    </div>

    <button type="submit" class="btn btn-primary btn-full">Registrar Treinador</button>
  </form>
  <?php endif; ?>

  <div class="login-hint" style="margin-top: 15px; text-align: center;">
    <a href="login.php">Já tem uma conta? Entrar</a>
  </div>
</div>

</body>
</html>
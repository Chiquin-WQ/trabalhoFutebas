<?php
require_once __DIR__ . '/../config/database.php';

$token = $_GET['token'] ?? '';
$erro = '';
$sucesso = '';

if (empty($token)) {
    die("Token de recuperação inválido.");
}

global $pdo;

$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE token_recuperacao = :token AND recuperacao_expira_em > NOW()");
$stmt->execute(['token' => $token]);
$usuario = $stmt->fetch();

if (!$usuario) {
    die("Este link de recuperação expirou ou é inválido. Peça um novo link.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novaSenha = $_POST['senha'] ?? '';
    
    if (strlen($novaSenha) < 4) {
        $erro = "A nova chave de acesso precisa ter pelo menos 4 caracteres.";
    } else {
        $senhaHash = hash('sha256', $novaSenha);
        
        $update = $pdo->prepare("UPDATE usuarios SET senha = :senha, token_recuperacao = NULL, recuperacao_expira_em = NULL WHERE id = :id");
        $update->execute([
            'senha' => $senhaHash,
            'id' => $usuario['id']
        ]);
        
        $sucesso = "Senha redefinida com sucesso! Nova tática aplicada.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Nova Chave — Futebas Club</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="login-body">

<div class="login-card">
  <div class="login-logo">FUTEBAS FC</div>
  <h1 class="login-title">Criar Nova Senha</h1>

  <?php if ($erro): ?> <div class="alert alert-erro"><?= $erro ?></div> <?php endif; ?>
  <?php if ($sucesso): ?> 
    <div class="alert alert-success" style="background:#d1fae5; border:2px solid #065f46; padding:15px; margin-bottom:15px; font-size:0.9rem;">
        <?= $sucesso ?>
    </div>
    <a href="login.php" class="btn btn-primary btn-full" style="text-align:center; display:block;">Entrar no Sistema</a>
  <?php else: ?>

  <form method="POST">
    <div class="form-group">
      <label for="senha">Nova Senha</label>
      <input type="password" id="senha" name="senha" required placeholder="Mínimo de 4 dígitos">
    </div>
    <button type="submit" class="btn btn-primary btn-full">Confirmar Alteração</button>
  </form>
  <?php endif; ?>
</div>

</body>
</html>
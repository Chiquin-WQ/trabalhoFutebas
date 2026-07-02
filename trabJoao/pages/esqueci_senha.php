<?php
require_once __DIR__ . '/../config/database.php';

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if ($email !== '') {
        $pdo = getConexao();
        
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch();

        if ($usuario) {
            
            $token = bin2hex(random_bytes(32));
            $expira = date('Y-m-d H:i:s', strtotime('+30 minutes'));

            $update = $pdo->prepare("UPDATE usuarios SET token_recuperacao = :token, recuperacao_expira_em = :expira WHERE id = :id");
            $update->execute([
                'token' => $token,
                'expira' => $expira,
                'id' => $usuario['id']
            ]);

            
            $link = "redefinir_senha.php?token=" . $token;
            $sucesso = "Link gerado! Como estamos em teste, clique aqui para redefinir: <br><br><a href='$link' class='btn btn-primary'>Redefinir Senha Agora</a>";
        } else {
            $erro = "E-mail não cadastrado no elenco.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Recuperar Acesso — Futebas Club</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="login-body">

<div class="login-card">
  <div class="login-logo">FUTEBAS FC</div>
  <h1 class="login-title">Recuperar Chave de Acesso</h1>

  <?php if ($erro): ?> <div class="alert alert-erro"><?= $erro ?></div> <?php endif; ?>
  <?php if ($sucesso): ?> 
    <div class="alert alert-success" style="background:#d1fae5; border:2px solid #065f46; padding:15px; margin-bottom:15px; font-size:0.9rem;">
        <?= $sucesso ?>
    </div>
  <?php endif; ?>

  <form method="POST">
    <div class="form-group">
      <label for="email">Digite seu E-mail Cadastrado</label>
      <input type="email" id="email" name="email" required placeholder="professor@futebas.com">
    </div>
    <button type="submit" class="btn btn-primary btn-full">Enviar Código de Recuperação</button>
  </form>

  <div class="login-hint" style="margin-top: 15px; text-align: center;">
    <a href="login.php" style="color: var(--ink-soft);">← Voltar para o Login</a>
  </div>
</div>

</body>
</html>
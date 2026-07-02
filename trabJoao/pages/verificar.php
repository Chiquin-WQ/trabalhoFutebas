<?php
require_once __DIR__ . '/../config/database.php';

$token = $_GET['token'] ?? '';

if (empty($token)) {
    die("Token de validação ausente.");
}

$pdo = getConexao();


$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE token_validacao = :token");
$stmt->execute(['token' => $token]);
$usuario = $stmt->fetch();

require_once __DIR__ . '/../includes/header.php';
?>

<div class="container" style="max-width: 600px; margin: 50px auto; text-align: center;">
    <div class="form-card" style="align-items: center; display: flex; flex-direction: column;">
        <?php if ($usuario): ?>
            <?php
           
            $update = $pdo->prepare("UPDATE usuarios SET conta_ativa = 1, token_validacao = NULL WHERE id = :id");
            $update->execute(['id' => $usuario['id']]);
            ?>
            <h2 style="font-family: 'Impact', sans-serif; color: var(--pitch-green);">CONTA ATIVADA! 🏆</h2>
            <p style="margin: 15px 0;">Sua inscrição na Área Técnica do Futebas FC foi confirmada com sucesso.</p>
            <a href="login.php" class="btn btn-primary">Ir para o Login</a>
        <?php else: ?>
            <h2 style="font-family: 'Impact', sans-serif; color: var(--ink);">LINK INVÁLIDO ❌</h2>
            <p style="margin: 15px 0;">Este link de validação já expirou, foi utilizado ou não existe.</p>
            <a href="cadastro.php" class="btn btn-ghost">Tentar se Cadastrar Novamente</a>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
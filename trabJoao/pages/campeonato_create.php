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

        header('Location: campeonatos.php');
        exit;
    } catch (Exception $e) {
        $erro = "Erro: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo Campeonato</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h2>Novo Campeonato</h2>
        <?php if ($erro): ?><p style="color:red"><?= $erro ?></p><?php endif; ?>
        <form method="POST">
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="number" name="ano" value="<?= date('Y') ?>" required>
            <input type="text" name="premiacao" placeholder="Premiação" required>
            <button type="submit">Salvar</button>
        </form>
    </div>
</body>
</html>
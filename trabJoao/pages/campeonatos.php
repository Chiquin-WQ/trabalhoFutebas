<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../repository/CampeonatoRepository.php';

$repository = new CampeonatoRepository($pdo);
$campeonatos = $repository->listarTodos();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Campeonatos</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Campeonatos Cadastrados</h1>
        <a href="campeonato_create.php" class="btn btn-primary">+ Novo Campeonato</a>
        <a href="index.php" class="btn btn-ghost">Voltar</a>
        <br><br>
        <table border="1">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Ano</th>
                    <th>Premiação</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($campeonatos)): ?>
                    <tr><td colspan="3">Nenhum campeonato encontrado.</td></tr>
                <?php else: ?>
                    <?php foreach ($campeonatos as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['nome'] ?? '') ?></td>
                        <td><?= htmlspecialchars($c['ano'] ?? '') ?></td>
                        <td><?= htmlspecialchars($c['premiacao'] ?? '') ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
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
    <title>Campeonatos - Futebas</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

    <header class="site-header">
        <div class="header-inner">
            <a href="index.php" class="logo">Futebas</a>
        </div>
    </header>

    <div class="container">
        <div class="page-header">
            <h2>Campeonatos</h2>
            <a href="campeonato_create.php" class="btn btn-primary">+ Novo Campeonato</a>
        </div>

        <?php if (empty($campeonatos)): ?>
            <div class="empty-state">
                <p>Nenhum campeonato cadastrado ainda.</p>
                <a href="campeonato_create.php" class="btn">Cadastrar Primeiro</a>
            </div>
        <?php else: ?>
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Ano</th>
                            <th>Premiação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($campeonatos as $c): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($c['nome'] ?? '') ?></strong></td>
                            <td><?= htmlspecialchars($c['ano'] ?? '') ?></td>
                            <td><?= htmlspecialchars($c['premiacao'] ?? '') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <footer class="site-footer">
        <div class="footer-inner">
            Sistema de Gestão Futebas &copy; 2026
        </div>
    </footer>

</body>
</html>
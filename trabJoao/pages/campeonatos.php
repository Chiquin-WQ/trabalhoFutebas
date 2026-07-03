<?php
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
        <table>
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
                    <td><?= htmlspecialchars($c->getNome()) ?></td>
                    <td><?= $c->getAno() ?></td>
                    <td><?= htmlspecialchars($c->getPremiacao()) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../repository/CampeonatoRepository.php';

$repository = new CampeonatoRepository($pdo);
$campeonatos = $repository->listarTodos();
?>

<?php foreach ($campeonatos as $c): ?>
    <tr>
        <td><?= htmlspecialchars($c['nome']) ?></td>
        <td><?= htmlspecialchars($c['ano']) ?></td>
        <td><?= htmlspecialchars($c['premiacao']) ?></td>
    </tr>
<?php endforeach; ?>
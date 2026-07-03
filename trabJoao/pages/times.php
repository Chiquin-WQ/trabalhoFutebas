<?php
require_once __DIR__ . '/../repository/TimeRepository.php';

$timeRepository = new TimeRepository();
$times = $timeRepository->listarTodos();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Futebas - Lista de Times</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f4f4f9; }
        h1 { color: #2c3e50; }
        .card-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 20px; }
        .card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 5px solid #27ae60; position: relative; }
        .card h3 { margin: 0 0 10px 0; color: #333; }
        .card p { margin: 5px 0; color: #666; font-size: 14px; }
        .btn { display: inline-block; background: #27ae60; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .btn:hover { background: #219150; }
        
        /* Estilo para a área dos botões de ação */
        .acoes { margin-top: 15px; display: flex; gap: 10px; }
        .btn-editar { display: inline-block; background: #3498db; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 13px; font-weight: bold; text-align: center; flex: 1; }
        .btn-editar:hover { background: #2980b9; }
        .btn-excluir { display: inline-block; background: #e74c3c; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 13px; font-weight: bold; text-align: center; flex: 1; border: none; cursor: pointer; }
        .btn-excluir:hover { background: #c0392b; }
    </style>
</head>
<body>

    <h1>Times Cadastrados</h1>
    <a href="cadastro_time.php" class="btn">+ Cadastrar Novo Time</a>
    <hr>

    <?php if (empty($times)): ?>
        <p>Nenhum time encontrado no banco de dados. Que tal cadastrar o primeiro? </p>
    <?php else: ?>
        <div class="card-container">
            <?php foreach ($times as $time): ?>
                <div class="card">
                    <h3>⚽ <?php echo htmlspecialchars($time['nome']); ?></h3>
                    <p><strong>Cidade:</strong> <?php echo htmlspecialchars($time['cidade'] ?? 'Não informada'); ?></p>
                    <p><strong>Técnico:</strong> <?php echo htmlspecialchars($time['tecnico'] ?? 'Não informado'); ?></p>
                    
                    <!-- BOTÕES DE EDITAR E EXCLUIR -->
                    <div class="acoes">
                        <a href="editar_time.php?id=<?php echo $time['id']; ?>" class="btn-editar">Editar</a>
                        <a href="excluir_time.php?id=<?php echo $time['id']; ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir o time <?php echo htmlspecialchars($time['nome']); ?>?')">Excluir</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</body>
</html>
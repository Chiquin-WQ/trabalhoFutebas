<?php
require_once __DIR__ . '/../repository/TimeRepository.php';

$timeRepository = new TimeRepository();
$mensagem = "";
$sucesso = false;


$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    
    header("Location: times.php");
    exit;
}

$time = $timeRepository->buscarPorId($id);

if (!$time) {
    die("Time não encontrado no banco de dados!");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $cidade = trim($_POST['cidade'] ?? '');
    $tecnico = trim($_POST['tecnico'] ?? '');
    
    if (empty($nome) || empty($cidade) || empty($tecnico)) {
        $mensagem = "Por favor, preencha todos os campos!";
    } else {
       
        $atualizou = $timeRepository->atualizar($id, $nome, $cidade, $tecnico);
        
        if ($atualizou) {
            $mensagem = "Time atualizado com sucesso!";
            $sucesso = true;
            
            $time['nome'] = $nome;
            $time['cidade'] = $cidade;
            $time['tecnico'] = $tecnico;
        } else {
            $mensagem = "Erro ao atualizar o time no banco de dados.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Futebas - Editar Time ⚽</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f4f4f9; }
        .form-container { max-width: 400px; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin: 0 auto; }
        h2 { color: #2c3e50; text-align: center; margin-top: 0; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #333; font-weight: bold; }
        input[type="text"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-enviar { width: 100%; background: #3498db; color: white; padding: 12px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; }
        .btn-enviar:hover { background: #2980b9; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 4px; text-align: center; font-weight: bold; }
        .alert-info { background-color: #f8d7da; color: #721c24; }
        .alert-success { background-color: #d4edda; color: #155724; }
        .back-link { display: block; text-align: center; margin-top: 15px; color: #666; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Editar Time</h2>
        
        <?php if (!empty($mensagem)): ?>
            <div class="alert <?php echo $sucesso ? 'alert-success' : 'alert-info'; ?>">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>

        <!-- Note que passamos o ID na URL do action para manter a referência na hora do POST -->
        <form action="editar_time.php?id=<?php echo $id; ?>" method="POST">
            <div class="form-group">
                <label for="nome">Nome do Time *</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($time['nome']); ?>" required>
            </div>

            <div class="form-group">
                <label for="cidade">Cidade *</label>
                <!-- Usando operador de coalescência nula caso o campo no banco seja 'cidade' ou venha nulo -->
                <input type="text" id="cidade" name="cidade" value="<?php echo htmlspecialchars($time['cidade'] ?? $time['city'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="tecnico">Técnico *</label>
                <input type="text" id="tecnico" name="tecnico" value="<?php echo htmlspecialchars($time['tecnico'] ?? ''); ?>" required>
            </div>

            <button type="submit" class="btn-enviar">Salvar Alterações</button>
        </form>

        <a href="times.php" class="back-link">← Voltar para a lista</a>
    </div>

</body>
</html>
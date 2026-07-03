<?php
require_once __DIR__ . '/../repository/TimeRepository.php';

$mensagem = "";
$sucesso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $cidade = trim($_POST['cidade'] ?? '');
    $tecnico = trim($_POST['tecnico'] ?? '');
    
    if (empty($nome) || empty($cidade) || empty($tecnico)) {
        $mensagem = "Preencha todos os campos!";
    } else {
        $timeRepository = new TimeRepository();
        $cadastrou = $timeRepository->cadastrar($nome, $cidade, $tecnico);
        
        if ($cadastrou) {
            $mensagem = "Time cadastrado com sucesso!";
            $sucesso = true;
        } else {
            $mensagem = "Erro ao cadastrar no banco.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Futebas - Cadastrar Time</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f4f4f9; }
        .form-container { max-width: 400px; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin: 0 auto; }
        h2 { color: #2c3e50; text-align: center; margin-top:0; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-enviar { width: 100%; background: #27ae60; color: white; padding: 12px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; }
        .btn-enviar:hover { background: #219150; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 4px; text-align: center; font-weight: bold; }
        .alert-info { background-color: #f8d7da; color: #721c24; }
        .alert-success { background-color: #d4edda; color: #155724; }
        .back-link { display: block; text-align: center; margin-top: 15px; color: #3498db; text-decoration: none; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Cadastrar Novo Time</h2>
        
        <?php if (!empty($mensagem)): ?>
            <div class="alert <?php echo $sucesso ? 'alert-success' : 'alert-info'; ?>">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>

        <form action="cadastro_time.php" method="POST">
            <div class="form-group">
                <label>Nome do Time *</label>
                <input type="text" name="nome" required>
            </div>
            <div class="form-group">
                <label>Cidade *</label>
                <input type="text" name="cidade" required>
            </div>
            <div class="form-group">
                <label>Técnico *</label>
                <input type="text" name="tecnico" required>
            </div>
            <button type="submit" class="btn-enviar">Salvar Time</button>
        </form>

        <a href="times.php" class="back-link">← Voltar para a lista</a>
    </div>

</body>
</html>
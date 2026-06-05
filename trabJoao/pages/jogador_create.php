<?php

require_once '../repository/JogadorRepository.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {

        $nome = $_POST['nome'];
        $idade = (int) $_POST['idade'];
        $posicao = $_POST['posicao'];
        $numeroCamisa = (int) $_POST['numero_camisa'];
        $overall = (int) $_POST['overall'];
        $idTime = (int) $_POST['id_time'];

        $foto = '';

        if (!empty($_FILES['foto']['name'])) {

            $arquivo = $_FILES['foto'];

            $extensao = strtolower(
                pathinfo($arquivo['name'], PATHINFO_EXTENSION)
            );

            $permitidas = ['jpg', 'png', 'webp'];

            if (!in_array($extensao, $permitidas)) {
                throw new Exception('Formato inválido.');
            }

            $nomeArquivo = uniqid() . '.' . $extensao;

            move_uploaded_file(
                $arquivo['tmp_name'],
                '../uploads/' . $nomeArquivo
            );

            $foto = $nomeArquivo;
        }

        $repository = new JogadorRepository();

        $repository->inserir(
            $nome,
            $idade,
            $posicao,
            $numeroCamisa,
            $overall,
            $foto,
            $idTime
        );

        header('Location: jogador_list.php');
        exit;

    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}
?>

<h1>Cadastrar Jogador</h1>

<?php if ($erro): ?>
    <p><?= $erro ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="nome" placeholder="Nome">

    <input type="number" name="idade" placeholder="Idade">

    <input type="text" name="posicao" placeholder="Posição">

    <input type="number" name="numero_camisa" placeholder="Número">

    <input type="number" name="overall" placeholder="Overall">

    <input type="number" name="id_time" placeholder="ID do Time">

    <input type="file" name="foto">

    <button type="submit">
        Salvar
    </button>

</form>
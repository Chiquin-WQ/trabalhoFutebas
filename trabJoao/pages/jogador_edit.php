<?php

require_once '../repository/JogadorRepository.php';

$repository = new JogadorRepository();

$id = (int) $_GET['id'];

$jogador = $repository->buscarPorId($id);

if (!$jogador) {
    die('Jogador não encontrado.');
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {

        $nome = $_POST['nome'];
        $idade = (int) $_POST['idade'];
        $posicao = $_POST['posicao'];
        $numeroCamisa = (int) $_POST['numero_camisa'];
        $overall = (int) $_POST['overall'];
        $idTime = (int) $_POST['id_time'];

        $foto = $jogador->getFoto();

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

        $repository->atualizar(
            $id,
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

<h1>Editar Jogador</h1>

<?php if ($erro): ?>
    <p><?= $erro ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

    <input
        type="text"
        name="nome"
        value="<?= $jogador->getNome() ?>"
    >

    <input
        type="number"
        name="idade"
        value="<?= $jogador->getIdade() ?>"
    >

    <input
        type="text"
        name="posicao"
        value="<?= $jogador->getPosicao() ?>"
    >

    <input
        type="number"
        name="numero_camisa"
        value="<?= $jogador->getNumeroCamisa() ?>"
    >

    <input
        type="number"
        name="overall"
        value="<?= $jogador->getOverall() ?>"
    >

    <input
        type="number"
        name="id_time"
        value="<?= $jogador->getIdTime() ?>"
    >

    <input type="file" name="foto">

    <?php if ($jogador->getFoto()): ?>

        <img
            src="../uploads/<?= $jogador->getFoto() ?>"
            width="120"
        >

    <?php endif; ?>

    <button type="submit">
        Atualizar
    </button>

</form>
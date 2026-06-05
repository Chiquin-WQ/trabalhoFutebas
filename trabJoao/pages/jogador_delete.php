<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../repository/JogadorRepository.php';

$repo = new JogadorRepository();

$id = 0;

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
}

$jogador = null;

if ($id > 0) {
    $jogador = $repo->buscarPorId($id);
}

// Jogador não encontrado
if ($jogador === null) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $repo->excluir($jogador->getId());

    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
    <h2>Excluir Jogador</h2>

    <a href="index.php" class="btn btn-ghost">
        ← Voltar
    </a>
</div>

<div class="confirm-card">

    <h3>Você tem certeza?</h3>

    <p>
        Você está prestes a excluir o jogador
        <strong><?= htmlspecialchars($jogador->getNome()) ?></strong>
        da posição
        <strong><?= htmlspecialchars($jogador->getPosicao()) ?></strong>
        com overall
        <strong><?= $jogador->getOverall() ?></strong>.
        Esta ação não pode ser desfeita.
    </p>

    <?php if ($jogador->getFoto()) : ?>

        <img
            src="../uploads/<?= htmlspecialchars($jogador->getFoto()) ?>"
            width="150"
        >

    <?php endif; ?>

    <form
        method="POST"
        action="jogador_delete.php?id=<?= $jogador->getId() ?>"
    >

        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-excluir"
            >
                Sim, excluir
            </button>

            <a
                href="index.php"
                class="btn btn-ghost"
            >
                Cancelar
            </a>

        </div>

    </form>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
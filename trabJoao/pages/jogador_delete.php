<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php'; 
require_once __DIR__ . '/../repository/JogadorRepository.php';


$repo = new JogadorRepository($pdo);

$id = 0;

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
}

$jogador = null;

if ($id > 0) {
    $jogador = $repo->buscarPorId($id);
}

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
    <h2>Dispensar Jogador</h2>
    <a href="index.php" class="btn btn-ghost">← Voltar</a>
</div>

<div class="container" style="max-width: 600px; margin: 0 auto;">
    <div class="form-card" style="text-align: center; align-items: center; display: flex; flex-direction: column;">
        <h3 style="font-family: 'Impact', sans-serif; text-transform: uppercase; font-size: 1.6rem; color: var(--ink); margin-bottom: 15px;">
            Você tem certeza?
        </h3>

        <p style="font-family: 'Arial', sans-serif; font-size: 1rem; color: var(--ink); margin-bottom: 20px; line-height: 1.5;">
            Você está prestes a tirar o craque 
            <strong><?= htmlspecialchars($jogador->getNome()) ?></strong> 
            (<?= htmlspecialchars($jogador->getPosicao()) ?> | ★ <?= $jogador->getOverall() ?>) 
            da delegação oficial da Copa. Esta ação não poderá ser desfeita!
        </p>

        <?php if ($jogador->getFoto()) : ?>
            <img 
                src="../assets/uploads/<?= htmlspecialchars($jogador->getFoto()) ?>" 
                alt="<?= htmlspecialchars($jogador->getNome()) ?>"
                style="width: 120px; height: 120px; object-fit: cover; border: 3px solid var(--ink); box-shadow: 4px 4px 0px #000; margin-bottom: 25px; display: block;"
            >
        <?php endif; ?>

        <form method="POST" action="jogador_delete.php?id=<?= $jogador->getId() ?>" style="width: 100%;">
            <div class="form-actions" style="justify-content: center; width: 100%; gap: 15px;">
                <button type="submit" class="btn btn-excluir">
                    Sim, dispensar
                </button>
                <a href="index.php" class="btn btn-ghost">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
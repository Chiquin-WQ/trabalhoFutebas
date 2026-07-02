<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../repository/JogadorRepository.php';


$pdo = getConexao();
$repo = new JogadorRepository($pdo);
$jogadores = $repo->listarTodos();

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
  <h2>Painel de Elenco - Jogadores 🏆</h2>
  <a href="jogador_create.php" class="btn btn-primary">+ Novo Jogador</a>
</div>

<div class="filtros-wrapper">
  <input
    type="text"
    id="buscaNome"
    placeholder="Buscar por nome do craque..."
    class="input-busca"
  />

  <select id="filtroPosicao" class="input-select">
    <option value="">Todas as posições</option>
    <option value="Goleiro">Goleiro</option>
    <option value="Zagueiro">Zagueiro</option>
    <option value="Lateral">Lateral</option>
    <option value="Volante">Volante</option>
    <option value="Meia">Meia</option>
    <option value="Atacante">Atacante</option>
  </select>

  <div class="toggle-view">
    <button class="btn btn-sm btn-toggle active" id="btnTabela" onclick="alternarView('tabela')">
      Tabela
    </button>
    <button class="btn btn-sm btn-toggle" id="btnCards" onclick="alternarView('cards')">
      Cards
    </button>
  </div>
</div>

<?php if (empty($jogadores)): ?>
  <div class="empty-state">
    <p>Nenhum jogador foi convocado para a Copa até o momento.</p>
    <a href="jogador_create.php" class="btn btn-primary">Convocar Primeiro Jogador</a>
  </div>

<?php else: ?>

  <div id="viewTabela" class="table-wrapper">
    <table class="data-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Foto</th>
          <th>Nome</th>
          <th>Idade</th>
          <th>Posição</th>
          <th>Camisa</th>
          <th>Overall</th>
          <th>Time ID</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody id="tabelaBody">
        <?php foreach ($jogadores as $jogador): ?>
          <tr
            class="jogador-row"
            data-nome="<?= strtolower(htmlspecialchars($jogador->getNome())) ?>"
            data-posicao="<?= htmlspecialchars($jogador->getPosicao()) ?>"
          >
            <td><?= $jogador->getId() ?></td>
            <td>
              <?php if ($jogador->getFoto()): ?>
                <img
                  src="../assets/uploads/<?= htmlspecialchars($jogador->getFoto()) ?>"
                  alt="<?= htmlspecialchars($jogador->getNome()) ?>"
                  class="avatar-tabela"
                />
              <?php else: ?>
                <div class="avatar-placeholder">-</div>
              <?php endif; ?>
            </td>
            <td><strong><?= htmlspecialchars($jogador->getNome()) ?></strong></td>
            <td><?= $jogador->getIdade() ?> anos</td>
            <td><span class="badge"><?= htmlspecialchars($jogador->getPosicao()) ?></span></td>
            <td>Nº <?= $jogador->getNumeroCamisa() ?></td>
            <td><strong><?= $jogador->getOverall() ?></strong></td>
            <td>#<?= $jogador->getIdTime() ?></td>
            <td class="acoes">
              <a href="jogador_edit.php?id=<?= $jogador->getId() ?>" class="btn btn-sm btn-editar">Editar</a>
              <a href="jogador_delete.php?id=<?= $jogador->getId() ?>" class="btn btn-sm btn-excluir">Excluir</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div id="viewCards" class="cards-wrapper" style="display:none;">
    <?php foreach ($jogadores as $jogador): ?>
      <div
        class="jogador-card"
        data-nome="<?= strtolower(htmlspecialchars($jogador->getNome())) ?>"
        data-posicao="<?= htmlspecialchars($jogador->getPosicao()) ?>"
      >
        <div class="card-foto">
          <?php if ($jogador->getFoto()): ?>
            <img
              src="../assets/uploads/<?= htmlspecialchars($jogador->getFoto()) ?>"
              alt="<?= htmlspecialchars($jogador->getNome()) ?>"
              class="avatar-card"
            />
          <?php else: ?>
            <div class="avatar-placeholder-card">-</div>
          <?php endif; ?>
        </div>

        <div class="card-info">
          <h3><?= htmlspecialchars($jogador->getNome()) ?></h3>
          <span class="badge" style="margin-bottom: 12px;"><?= htmlspecialchars($jogador->getPosicao()) ?></span>
          <p>Camisa: <strong>Nº <?= $jogador->getNumeroCamisa() ?></strong></p>
          <p>Idade: <strong><?= $jogador->getIdade() ?> anos</strong></p>
          <p>Overall: <strong>★ <?= $jogador->getOverall() ?></strong></p>
          <p>Time ID: <strong>#<?= $jogador->getIdTime() ?></strong></p>
        </div>

        <div class="card-acoes">
          <a href="jogador_edit.php?id=<?= $jogador->getId() ?>" class="btn btn-sm btn-editar">Editar</a>
          <a href="jogador_delete.php?id=<?= $jogador->getId() ?>" class="btn btn-sm btn-excluir">Excluir</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

<?php endif; ?>

<style>
  .filtros-wrapper {
    display: flex;
    gap: 15px;
    margin-bottom: 30px;
    align-items: center;
    flex-wrap: wrap;
  }

  .input-busca, .input-select {
    min-height: 44px;
    padding: 10px 13px;
    border: 2px solid var(--ink);
    border-radius: var(--radius);
    outline: none;
    color: var(--ink);
    background: #ffffff;
    font-family: "Arial", system-ui, sans-serif;
    font-size: 0.9rem;
  }

  .input-busca {
    min-width: 260px;
    flex: 1;
  }

  .input-busca:focus, .input-select:focus {
    border-color: var(--pitch-green);
    box-shadow: 0 0 0 4px rgba(0, 135, 90, 0.2);
  }

  .toggle-view {
    margin-left: auto;
    display: flex;
    gap: 10px;
  }

  .btn-toggle {
    background: var(--stadium-concrete);
    color: var(--ink);
  }

  .btn-toggle.active {
    background: var(--world-cup-blue);
    color: var(--chalk-white);
  }

  .avatar-tabela {
    width: 45px;
    height: 45px;
    object-fit: cover;
    border: 2px solid var(--ink);
    display: block;
  }

  .avatar-placeholder {
    width: 45px;
    height: 45px;
    border: 2px dashed var(--ink);
    background: var(--stadium-concrete);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: "Impact", sans-serif;
    font-size: 1.2rem;
  }

  .cards-wrapper {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 25px;
  }

  .jogador-card {
    background: #ffffff;
    border: 3px solid var(--ink);
    box-shadow: var(--shadow);
    padding: 24px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .avatar-card {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border: 3px solid var(--ink);
    margin-bottom: 15px;
    display: block;
  }

  .avatar-placeholder-card {
    width: 100px;
    height: 100px;
    border: 3px dashed var(--ink);
    background: var(--stadium-concrete);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: "Impact", sans-serif;
    font-size: 2.5rem;
    margin-bottom: 15px;
  }

  .card-info h3 {
    font-family: "Impact", sans-serif;
    text-transform: uppercase;
    font-size: 1.3rem;
    letter-spacing: 0.02em;
    margin-bottom: 6px;
    color: var(--ink);
  }

  .card-info p {
    font-family: "Arial", system-ui, sans-serif;
    font-size: 0.9rem;
    margin: 4px 0;
    color: var(--ink-soft);
  }

  .card-acoes {
    margin-top: 18px;
    display: flex;
    gap: 10px;
    width: 100%;
    justify-content: center;
  }
</style>

<script>
  const buscaInput    = document.getElementById('buscaNome');
  const filtroSelect  = document.getElementById('filtroPosicao');

  function filtrar() {
    const busca   = buscaInput.value.toLowerCase().trim();
    const posicao = filtroSelect.value;

    document.querySelectorAll('.jogador-row').forEach(row => {
      const nome     = row.dataset.nome;
      const pos      = row.dataset.posicao;
      const ok       = nome.includes(busca) && (posicao === '' || pos === posicao);
      row.style.display = ok ? '' : 'none';
    });

    document.querySelectorAll('.jogador-card').forEach(card => {
      const nome     = card.dataset.nome;
      const pos      = card.dataset.posicao;
      const ok       = nome.includes(busca) && (posicao === '' || pos === posicao);
      card.style.display = ok ? '' : 'none';
    });
  }

  buscaInput.addEventListener('input', filtrar);
  filtroSelect.addEventListener('change', filtrar);

  function alternarView(view) {
    const tabela  = document.getElementById('viewTabela');
    const cards   = document.getElementById('viewCards');
    const btnTab  = document.getElementById('btnTabela');
    const btnCard = document.getElementById('btnCards');

    if (view === 'tabela') {
      tabela.style.display  = '';
      cards.style.display   = 'none';
      btnTab.classList.add('active');
      btnCard.classList.remove('active');
    } else {
      tabela.style.display  = 'none';
      cards.style.display   = 'grid';
      btnCard.classList.add('active');
      btnTab.classList.remove('active');
    }
  }
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
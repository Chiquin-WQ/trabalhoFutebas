<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../repository/JogadorRepository.php';

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
        <div class="card-overall">★ <?= $jogador->getOverall() ?></div>
        
        <div class="card-foto">
          <?php if ($jogador->getFoto()): ?>
            <img
              src="../assets/uploads/<?= htmlspecialchars($jogador->getFoto()) ?>"
              alt="<?= htmlspecialchars($jogador->getNome()) ?>"
              class="avatar-card"
            />
          <?php else: ?>
            <div class="avatar-placeholder-card">🏃‍♂️</div>
          <?php endif; ?>
        </div>

        <div class="card-info">
          <h3><?= htmlspecialchars($jogador->getNome()) ?></h3>
          <span class="badge position-badge"><?= htmlspecialchars($jogador->getPosicao()) ?></span>
          
          <div class="card-stats-grid">
            <div class="card-stat-item">
              <span class="stat-lbl">Camisa</span>
              <span class="stat-val">Nº <?= $jogador->getNumeroCamisa() ?></span>
            </div>
            <div class="card-stat-item">
              <span class="stat-lbl">Idade</span>
              <span class="stat-val"><?= $jogador->getIdade() ?> anos</span>
            </div>
            <div class="card-stat-item">
              <span class="stat-lbl">Time</span>
              <span class="stat-val">#<?= $jogador->getIdTime() ?></span>
            </div>
          </div>
        </div>

        <div class="card-acoes">
          <a href="jogador_edit.php?id=<?= $jogador->getId() ?>" class="btn btn-sm btn-editar" style="flex: 1;">Editar</a>
          <a href="jogador_delete.php?id=<?= $jogador->getId() ?>" class="btn btn-sm btn-excluir">❌</a>
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
    border: 3px solid var(--ink);
    border-radius: var(--radius, 6px);
    outline: none;
    color: var(--ink);
    background: #ffffff;
    font-family: "Arial", system-ui, sans-serif;
    font-size: 0.9rem;
    box-shadow: 2px 2px 0px #000;
  }

  .input-busca {
    min-width: 260px;
    flex: 1;
  }

  .toggle-view {
    margin-left: auto;
    display: flex;
    gap: 10px;
  }

  .btn-toggle {
    background: #e2e8f0;
    color: var(--ink);
    border: 2px solid var(--ink);
    box-shadow: 2px 2px 0px #000;
    font-weight: bold;
  }

  .btn-toggle.active {
    background: #3b82f6;
    color: #fff;
  }

  /* Customizações da Tabela */
  .data-table tbody tr:hover {
    background-color: #f8fafc;
  }

  .avatar-tabela {
    width: 45px;
    height: 45px;
    object-fit: cover;
    border: 2px solid var(--ink);
    border-radius: 4px;
    display: block;
  }

  .avatar-placeholder {
    width: 45px;
    height: 45px;
    border: 2px dashed var(--ink);
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: "Impact", sans-serif;
    font-size: 1.2rem;
    border-radius: 4px;
  }

  /* Grid de Cards Brutalista */
  .cards-wrapper {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 25px;
    padding-bottom: 30px;
  }

  .jogador-card {
    background: #ffffff;
    border: 3px solid var(--ink);
    box-shadow: 5px 5px 0px #000000;
    border-radius: 8px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    position: relative;
    transition: transform 0.2s, box-shadow 0.2s;
  }

  .jogador-card:hover {
    transform: translate(-3px, -3px);
    box-shadow: 8px 8px 0px #000000;
  }

  .card-overall {
    position: absolute;
    top: 12px;
    right: 12px;
    background: #facc15;
    border: 2px solid var(--ink);
    padding: 3px 8px;
    font-family: "Impact", sans-serif;
    font-size: 0.85rem;
    border-radius: 4px;
    box-shadow: 1px 1px 0px #000;
  }

  .avatar-card {
    width: 110px;
    height: 110px;
    object-fit: cover;
    border: 3px solid var(--ink);
    border-radius: 6px;
    margin-bottom: 15px;
    display: block;
    background: #f8fafc;
  }

  .avatar-placeholder-card {
    width: 110px;
    height: 110px;
    border: 3px dashed var(--ink);
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    margin-bottom: 15px;
    border-radius: 6px;
  }

  .card-info {
    width: 100%;
    margin-bottom: 15px;
  }

  .card-info h3 {
    font-family: "Impact", sans-serif;
    text-transform: uppercase;
    font-size: 1.4rem;
    letter-spacing: 0.03em;
    margin: 0 0 8px 0;
    color: var(--ink);
  }

  .position-badge {
    display: inline-block;
    margin-bottom: 15px;
    background: #e0f2fe;
    color: #0369a1;
    border: 1px solid var(--ink);
    font-weight: bold;
  }

  /* Mini Grid interna de atributos do jogador */
  .card-stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 5px;
    background: #f8fafc;
    border: 2px solid var(--ink);
    border-radius: 6px;
    padding: 8px;
  }

  .card-stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .card-stat-item .stat-lbl {
    font-size: 0.7rem;
    color: #64748b;
    text-transform: uppercase;
    font-weight: bold;
    margin-bottom: 2px;
  }

  .card-stat-item .stat-val {
    font-size: 0.85rem;
    font-weight: bold;
    color: var(--ink);
  }

  .card-acoes {
    margin-top: auto;
    display: flex;
    gap: 10px;
    width: 100%;
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
<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../Repository/JogadorRepository.php';
require_once __DIR__ . '/../config/database.php';

$pdo = getConexao();
$repo = new JogadorRepository($pdo);
$jogadores = $repo->listarTodos();

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
  <h2>Painel de Elenco - Jogadores</h2>
  <a href="jogador_create.php" class="btn btn-primary">+ Novo Jogador</a>
</div>

<div class="filtros-wrapper">
  <input
    type="text"
    id="buscaNome"
    placeholder="Buscar por nome..."
    class="input-busca"
  />

  <select id="filtroPosicao" class="input-select">
    <option value="">Todas as posições</option>
    <option value="Goleiro">Goleiro</option>
    <option value="Zagueiro">Zagueiro</option>
    <option value="Lateral">Lateral</option>
    <option value="Meio-Campista">Meio-Campista</option>
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
    <p>Nenhum jogador foi cadastrado no sistema até o momento.</p>
    <a href="jogador_create.php" class="btn btn-primary">Cadastrar Primeiro Jogador</a>
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
          <th>Time (ID)</th>
          <th>Status</th>
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
              <?php if ($jogador->getFoto() && $jogador->getFoto() !== 'uploads/default_avatar.png'): ?>
                <img
                  src="/uploads/jogadores/<?= htmlspecialchars($jogador->getFoto()) ?>"
                  alt="<?= htmlspecialchars($jogador->getNome()) ?>"
                  class="avatar-tabela"
                />
              <?php else: ?>
                <div class="avatar-placeholder">-</div>
              <?php endif; ?>
            </td>
            <td><strong><?= htmlspecialchars($jogador->getNome()) ?></strong></td>
            <td><?= $jogador->getIdade() ?> anos</td>
            <td><span class="badge badge-posicao"><?= htmlspecialchars($jogador->getPosicao()) ?></span></td>
            <td>Nº <?= $jogador->getNumeroCamisa() ?></td>
            <td><strong><?= $jogador->getOverall() ?></strong></td>
            <td>#<?= $jogador->getIdTime() ?></td>
            <td><span class="badge badge-status"><?= htmlspecialchars($jogador->getStatus()) ?></span></td>
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
          <?php if ($jogador->getFoto() && $jogador->getFoto() !== 'uploads/default_avatar.png'): ?>
            <img
              src="/uploads/jogadores/<?= htmlspecialchars($jogador->getFoto()) ?>"
              alt="<?= htmlspecialchars($jogador->getNome()) ?>"
              class="avatar-card"
            />
          <?php else: ?>
            <div class="avatar-placeholder-card">-</div>
          <?php endif; ?>
        </div>

        <div class="card-info">
          <h3><?= htmlspecialchars($jogador->getNome()) ?></h3>
          <span class="badge badge-posicao"><?= htmlspecialchars($jogador->getPosicao()) ?></span>
          <p>Camisa: <?= $jogador->getNumeroCamisa() ?></p>
          <p>Idade: <?= $jogador->getIdade() ?> anos</p>
          <p>Overall: <strong><?= $jogador->getOverall() ?></strong></p>
          <p>Time ID: #<?= $jogador->getIdTime() ?></p>
          <p>Status: <strong><?= htmlspecialchars($jogador->getStatus()) ?></strong></p>
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
    gap: 12px;
    margin-bottom: 20px;
    align-items: center;
    flex-wrap: wrap;
  }

  .input-busca, .input-select {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    min-width: 200px;
  }

  .toggle-view {
    margin-left: auto;
    display: flex;
    gap: 6px;
  }

  .btn-toggle {
    background: #f0f0f0;
    border: 1px solid #ccc;
    cursor: pointer;
    padding: 6px 14px;
    border-radius: 6px;
  }

  .btn-toggle.active {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
  }

  .avatar-tabela {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ddd;
  }

  .avatar-placeholder {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
  }

  .cards-wrapper {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 20px;
  }

  .jogador-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    padding: 20px;
    text-align: center;
    transition: transform 0.2s;
  }

  .jogador-card:hover {
    transform: translateY(-4px);
  }

  .avatar-card {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #3b82f6;
    margin-bottom: 12px;
  }

  .avatar-placeholder-card {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    margin: 0 auto 12px;
  }

  .card-info h3 {
    margin: 8px 0 4px;
    font-size: 16px;
  }

  .card-info p {
    font-size: 13px;
    color: #666;
    margin: 4px 0;
  }

  .card-acoes {
    margin-top: 12px;
    display: flex;
    gap: 8px;
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
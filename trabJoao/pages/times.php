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
  /* Container de Filtros */
  .filtros-wrapper {
    margin-bottom: 35px;
    display: flex;
    justify-content: flex-start;
  }

  .input-busca {
    width: 100%;
    max-width: 420px;
    min-height: 46px;
    padding: 12px 16px;
    border: 3px solid var(--ink, #1a1a1a);
    border-radius: 8px;
    outline: none;
    color: var(--ink, #1a1a1a);
    background: #ffffff;
    font-family: "Segoe UI", system-ui, sans-serif;
    font-size: 0.95rem;
    font-weight: 500;
    box-shadow: 4px 4px 0px #000000;
    transition: all 0.2s ease;
  }

  .input-busca:focus {
    transform: translate(-2px, -2px);
    box-shadow: 6px 6px 0px #000000;
    border-color: #3b82f6; /* Destaque azul ao focar */
  }

  /* Grid de Exibição dos Times */
  .teams-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
    gap: 30px;
    padding-bottom: 40px;
  }

  /* O Card do Time Estilizado */
  .time-card {
    background: #ffffff;
    border: 3px solid var(--ink, #1a1a1a);
    box-shadow: 6px 6px 0px #000000;
    border-radius: 12px;
    padding: 26px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    position: relative;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .time-card:hover {
    transform: translate(-4px, -4px);
    box-shadow: 10px 10px 0px #000000;
  }

  /* Container do Escudo / Brasão */
  .badge-container {
    width: 110px;
    height: 110px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
    border: 3px solid var(--ink, #1a1a1a);
    border-radius: 50%; /* Formato circular de medalha */
    box-shadow: 4px 4px 0px #000000;
    overflow: hidden;
    transition: transform 0.3s ease;
  }

  .time-card:hover .badge-container {
    transform: scale(1.05) rotate(3deg); /* Leve efeito ao passar o mouse */
  }

  .team-shield {
    width: 75%;
    height: 75%;
    object-fit: contain;
    display: block;
  }

  .shield-placeholder {
    font-size: 2.8rem;
    filter: drop-shadow(2px 2px 0px rgba(0,0,0,0.1));
  }

  /* Informações textuais */
  .time-info {
    width: 100%;
    margin-bottom: 22px;
  }

  .time-info h3 {
    font-family: "Impact", "Arial Black", sans-serif;
    text-transform: uppercase;
    font-size: 1.6rem;
    letter-spacing: 0.04em;
    margin: 0 0 6px 0;
    color: var(--ink, #1a1a1a);
    line-height: 1.2;
  }

  .location-tag {
    font-family: "Segoe UI", system-ui, sans-serif;
    font-size: 0.85rem;
    color: #64748b;
    margin: 0 0 18px 0;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  /* Painel de Estatísticas do Time */
  .time-stats {
    background: #f1f5f9;
    border: 3px solid var(--ink, #1a1a1a);
    border-radius: 8px;
    padding: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    box-shadow: inset 2px 2px 0px rgba(0,0,0,0.05);
  }

  .time-stats .stat-title {
    font-size: 0.7rem;
    color: #475569;
    text-transform: uppercase;
    font-weight: 800;
    letter-spacing: 0.06em;
    margin-bottom: 4px;
  }

  .time-stats .stat-number {
    font-family: "Impact", "Arial Black", sans-serif;
    font-size: 1.8rem;
    color: #10b981; /* Verde vivo de gol */
    text-shadow: 2px 2px 0px #000000;
    line-height: 1;
    margin-top: 2px;
  }

  /* Botões de Ação Inferiores */
  .time-actions {
    margin-top: auto;
    display: flex;
    gap: 12px;
    width: 100%;
  }

  /* Ajuste fino nos botões padrões para combinarem */
  .time-actions .btn {
    font-family: "Segoe UI", system-ui, sans-serif;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.02em;
    border: 2px solid var(--ink, #1a1a1a);
    box-shadow: 3px 3px 0px #000000;
    transition: all 0.1s ease;
  }

  .time-actions .btn:active {
    transform: translate(2px, 2px);
    box-shadow: 1px 1px 0px #000000;
  }

  .time-actions .btn-editar {
    background: #bae6fd; /* Azul suave */
    color: #0369a1;
  }
  .time-actions .btn-editar:hover {
    background: #7dd3fc;
  }

  .time-actions .btn-excluir {
    background: #fecaca; /* Vermelho suave */
    padding: 8px 14px;
  }
  .time-actions .btn-excluir:hover {
    background: #fca5a5;
  }
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
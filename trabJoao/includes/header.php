<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FutManager - Gestão de Elenco</title>
  <link rel="stylesheet" href="../assets/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body>

<header class="site-header">
  <div class="header-inner">
    <a href="../pages/index.php" class="logo">
      <i class="fa-solid to fa-soccer-ball"></i> FutManager
    </a>

    <nav class="nav">
      <a href="../pages/index.php"><i class="fa-solid fa-users"></i> Jogadores</a>
      <a href="../pages/times.php"><i class="fa-solid fa-shield-halved"></i> Times</a>
      <a href="../pages/campeonatos.php"><i class="fa-solid fa-trophy"></i> Campeonatos</a>
      <a href="../pages/jogador_create.php" class="nav-highlight"><i class="fa-solid fa-plus"></i> Novo Jogador</a>
    </nav>

    <div class="header-user">
      <?php
        // Garante que a sessão está ativa para não dar erro de Notice
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $nomeUser = $_SESSION['usuario_nome'] ?? 'Treinador';
      ?>
      <span class="user-name">
        <i class="fa-solid fa-user-tie"></i> Prof: <?= htmlspecialchars($nomeUser) ?>
      </span>
      <a href="../pages/logout.php" class="btn-logout"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
    </div>
  </div>
</header>

<main class="container">
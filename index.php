<?php
// Importa o arquivo com funções auxiliares
require 'lib.php';

// Garante que o usuário está autenticado
verificar_auth();

// Carrega todas as playlists salvas no arquivo JSON
$playlists = db_load();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Minhas Playlists</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- Cabeçalho com título e menu de navegação -->
  <header>
    <h1>You<span>Playlist</span></h1>

    <nav>
      <!-- Link para página atual -->
      <a href="index.php" class="active">Playlists</a>

      <!-- Criar nova playlist -->
      <a href="criar.php">Nova</a>

      <!-- Logout do sistema -->
      <a href="logout.php" class="logout-btn">Sair</a>

      <!-- Página Sobre -->
      <a href="sobre.php" class="sobre-btn">Sobre</a>
    </nav>
  </header>

  <main>

    <!-- Seção de apresentação do usuário -->
    <div class="intro-section">
      <div>
          <!-- Nome do usuário — sempre sanitizado para evitar XSS -->
          <h2>Olá, <?= htmlspecialchars($_SESSION['usuario']) ?></h2>
          <p style="color:var(--text-muted)">Selecione uma playlist para ouvir</p>
      </div>

      <!-- Botão para criar playlist -->
      <a href="criar.php" class="btn">+ Criar Playlist</a>
    </div>

    <!-- Grade com todas as playlists do usuário -->
    <div class="playlist-grid">

      <!-- Checa se existe alguma playlist cadastrada -->
      <?php if (!empty($playlists)): ?>

        <!-- Loop para exibir cada playlist -->
        <?php foreach ($playlists as $p): ?>

          <!-- Card clicável redirecionando para visualizar playlist -->
          <div class="playlist-card" onclick="location.href='view.php?id=<?= $p['id'] ?>'">

            <!-- Ícone ilustrativo -->
            <div class="playlist-icon">🎵</div>

            <div>
                <!-- Nome da playlist sanitizado -->
                <h3><?= htmlspecialchars($p["nome"]) ?></h3>

                <!-- Conta quantas músicas existem na playlist -->
                <p><?= isset($p["links"]) ? count($p["links"]) : 0 ?> faixas</p>
            </div>

            <!-- Botão grande dentro do card -->
            <button class="btn" style="width:100%; border-radius:8px; padding:8px;">
              Tocar Agora
            </button>
          </div>

        <?php endforeach; ?>

      <?php else: ?>

        <!-- Caso não existam playlists -->
        <p style="color:#777; width:100%;">Nenhuma playlist encontrada. Crie a primeira!</p>

      <?php endif; ?>

    </div>
  </main>

  <footer>
    © 2025 YouPlaylist - Organized Layout
  </footer>
</body>
</html>

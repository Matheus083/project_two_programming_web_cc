<?php
require 'lib.php';      
verificar_auth();
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

  <header>
    <h1>You<span>Playlist</span></h1>
    <nav>
      <a href="index.php" class="active">Playlists</a>
      <a href="criar.php">Nova</a>
      <a href="logout.php" class="logout-btn">Sair</a>
    </nav>
  </header>

  <main>
    <div class="intro-section">
      <div>
          <h2>Olá, <?= htmlspecialchars($_SESSION['usuario']) ?></h2>
          <p style="color:var(--text-muted)">Selecione uma playlist para ouvir</p>
      </div>
      <a href="criar.php" class="btn">+ Criar Playlist</a>
    </div>

    <div class="playlist-grid">
      <?php if (!empty($playlists)): ?>
        <?php foreach ($playlists as $p): ?>
          <div class="playlist-card" onclick="location.href='view.php?id=<?= $p['id'] ?>'">
            <div class="playlist-icon">🎵</div>
            <div>
                <h3><?= htmlspecialchars($p["nome"]) ?></h3>
                <p><?= isset($p["links"]) ? count($p["links"]) : 0 ?> faixas</p>
            </div>
            <button class="btn" style="width:100%; border-radius:8px; padding:8px;">Tocar Agora</button>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p style="color:#777; width:100%;">Nenhuma playlist encontrada. Crie a primeira!</p>
      <?php endif; ?>
    </div>
  </main>

  <footer>© 2025 YouPlaylist - Organized Layout</footer>
</body>
</html>
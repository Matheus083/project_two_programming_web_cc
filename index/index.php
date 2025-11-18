<?php
require 'lib.php';      // carrega as funções
$playlists = db_load(); // carrega o JSON como array
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>YouPlaylist - Minhas Playlists</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <header>
    <h1>🎧 YouPlaylist</h1>
    <nav>
      <a href="inicio.php">Início</a>
      <a href="index.php">Minhas Playlists</a>
      <a href="sobre.php">Sobre</a>
    </nav>
  </header>

  <main>
    <section class="intro">
      <h2>Minhas Playlists</h2>
      <a href="playlist-cadastro-form.php" class="new-playlist-btn">+ Criar nova playlist</a>
    </section>

    <section class="playlist-grid">

      <?php if (!empty($playlists)): ?>
        <?php foreach ($playlists as $p): ?>
          <div class="playlist-card">
            <h3><?= htmlspecialchars($p["nome"]) ?></h3>

            <p>
              <?= isset($p["links"]) ? count($p["links"]) : 0 ?> músicas
            </p>

            <!-- Você pode criar um futuro view.php -->
            <button onclick="location.href='view.php?id=<?= $p['id'] ?>'">
              ▶ Ver Playlist
            </button>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Você ainda não possui playlists cadastradas. 😊</p>
      <?php endif; ?>

    </section>
  </main>

  <footer>
    © 2025 Grupo de Desenvolvimento Web | Projeto YouPlaylist
  </footer>

</body>
</html>

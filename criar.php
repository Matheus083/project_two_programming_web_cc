<?php
require 'lib.php';
verificar_auth();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Criar Playlist - YouPlaylist</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <header>
    <h1>🎧 YouPlaylist</h1>
    <nav>
      <a href="index.php">Minhas Playlists</a>
      <a href="logout.php">Sair</a>
    </nav>
  </header>

  <main>
    <section>
      <h2>Criar nova playlist</h2>
      <form method="post" action="playlist-cadastro.php" class="playlist-form">
        <label>Nome da playlist:</label>
        <input type="text" name="nome" required />

        <label>Adicionar link do YouTube (opcional):</label>
        <input type="url" name="url" />

        <button type="submit" class="new-playlist-btn">Salvar Playlist</button>
      </form>
    </section>
  </main>
  <footer>© 2025 YouPlaylist</footer>
</body>
</html>
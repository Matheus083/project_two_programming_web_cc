<?php
require 'lib.php';

// pega ID da playlist via GET
$id = $_GET['id'] ?? null;

$playlists = db_load();

// procura playlist pelo id
$playlist = null;
foreach ($playlists as $p) {
    if ($p['id'] == $id) {
        $playlist = $p;
        break;
    }
}

if (!$playlist) {
    echo "<h2>Playlist não encontrada.</h2>";
    echo "<p><a href='index.php'>Voltar</a></p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($playlist['nome']) ?></title>
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
  <h2>Playlist: <?= htmlspecialchars($playlist['nome']) ?></h2>

  <h3>Músicas:</h3>

  <?php if (!empty($playlist['links'])): ?>

    <ul>
      <?php foreach ($playlist['links'] as $link): ?>
        <li>
          <a href="<?= $link ?>" target="_blank">
            <?= htmlspecialchars($link) ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>

  <?php else: ?>
      <p>Nenhuma música cadastrada ainda.</p>
  <?php endif; ?>

  <br>
  <a href="index.php" class="new-playlist-btn">Voltar</a>

</main>

<footer>
  © 2025 Grupo de Desenvolvimento Web | Projeto YouPlaylist
</footer>

</body>
</html>

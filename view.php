<?php
require 'lib.php';

function extractYoutubeId($url) {
    if (preg_match('/[?&]v=([a-zA-Z0-9_-]{11})/', $url, $m)) return $m[1];
    if (preg_match('#youtu\.be/([a-zA-Z0-9_-]{11})#', $url, $m)) return $m[1];
    if (preg_match('#/embed/([a-zA-Z0-9_-]{11})#', $url, $m)) return $m[1];
    if (preg_match('/([a-zA-Z0-9_-]{11})/', $url, $m)) return $m[1];
    return null;
}

$id = $_GET['id'] ?? null;
$playlists = db_load();

$playlist = null;
foreach ($playlists as $p) {
    if ($p['id'] == $id) {
        $playlist = $p;
        break;
    }
}

if (!$playlist) {
    echo "<h2>Playlist não encontrada.</h2>";
    exit;
}

$musicas = [];
if (!empty($playlist['musicas'])) {
    foreach ($playlist['musicas'] as $m) {
        $url = $m['url'];
        $musicas[] = [
            'id_video' => extractYoutubeId($url),
            'titulo'   => $m['titulo'] ?? $url,
            'url'      => $url
        ];
    }
} elseif (!empty($playlist['links'])) {
    foreach ($playlist['links'] as $i => $link) {
        $musicas[] = [
            'id_video' => extractYoutubeId($link),
            'titulo'   => "Faixa " . ($i+1),
            'url'      => $link
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<title><?= htmlspecialchars($playlist['nome']) ?> — YouPlaylist</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <h1>🎧 YouPlaylist</h1>
  <nav>
    <a href="inicio.php">Início</a>
    <a href="index.php">Minhas Playlists</a>
  </nav>
</header>

<main>
  <h2 style="color:#FF4B2B"><?= htmlspecialchars($playlist['nome']) ?></h2>
  <p><?= count($musicas) ?> músicas</p>

  <a href="add-musica.php?id=<?= $playlist['id'] ?>" class="new-playlist-btn">Adicionar Música</a>

  <?php if (!empty($musicas)):

    $firstId = $musicas[0]['id_video'];
    $firstEmbed = $firstId
        ? "https://www.youtube.com/embed/$firstId?autoplay=1&rel=0"
        : "";
  ?>

  <div class="player-box">
    <iframe id="videoPlayer"
            class="player-iframe"
            src="<?= $firstEmbed ?>"
            allow="accelerometer; autoplay; encrypted-media; gyroscope"
            allowfullscreen></iframe>

    <div class="player-buttons">
      <button id="prevBtn">◀ Anterior</button>
      <button id="nextBtn">Próxima ▶</button>
    </div>
  </div>

  <div class="tracks" id="tracksList">
    <?php foreach ($musicas as $i => $m):
        $thumb = $m['id_video']
            ? "https://img.youtube.com/vi/{$m['id_video']}/hqdefault.jpg"
            : "https://via.placeholder.com/320x180?text=Sem+Thumbnail";
    ?>
    <div class="track-card" data-index="<?= $i ?>" data-video-id="<?= $m['id_video'] ?>">
      <div class="track-thumb"><img src="<?= $thumb ?>"></div>
      <div class="track-meta">
        <div class="track-title"><?= htmlspecialchars($m['titulo']) ?></div>
        <div class="track-url"><?= htmlspecialchars($m['url']) ?></div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <?php else: ?>
    <p>Nenhuma música cadastrada.</p>
  <?php endif; ?>
</main>

<footer>
  © 2025 YouPlaylist
</footer>

<script>
const tracks = <?= json_encode($musicas) ?>;
let current = 0;

const video = document.getElementById("videoPlayer");
const prev = document.getElementById("prevBtn");
const next = document.getElementById("nextBtn");

function loadVideo(i, autoplay = true) {
    if (!tracks[i]) return;
    const id = tracks[i].id_video;
    const src = "https://www.youtube.com/embed/" + id + "?rel=0&autoplay=" + (autoplay ? 1 : 0);
    video.src = src;
    current = i;
}

prev.onclick = () => {
    if (current > 0) loadVideo(current - 1);
};

next.onclick = () => {
    if (current < tracks.length - 1) loadVideo(current + 1);
};

document.querySelectorAll(".track-card").forEach(card => {
  card.onclick = () => {
    const i = parseInt(card.dataset.index);
    loadVideo(i);
  };
});
</script>

</body>
</html>

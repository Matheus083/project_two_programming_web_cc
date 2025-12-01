<?php
require 'lib.php';
verificar_auth();

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: index.php"); exit; }

$playlists = db_load();
$playlist = null;

foreach ($playlists as $p) {
    if ($p['id'] == $id) { $playlist = $p; break; }
}

if (!$playlist) { echo "<p>Playlist não encontrada.</p>"; exit; }

$links = $playlist['links'] ?? [];
$total = count($links);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($playlist['nome']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>You<span>Playlist</span></h1>
    <nav>
        <a href="index.php">Voltar</a>
        <a href="logout.php" class="logout-btn">Sair</a>
    </nav>
</header>

<main>

    <div class="view-header">
        <div>
            <h2 style="margin-bottom:0.2rem"><?= htmlspecialchars($playlist['nome']) ?></h2>
            <span style="color:var(--text-muted)"><?= $total ?> músicas na fila</span>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="add-musica.php?id=<?= $id ?>" class="btn">Adicionar Música</a>
            <form method="post" action="delete-playlist.php" onsubmit="return confirm('Tem certeza? Isso apaga tudo!')">
                <input type="hidden" name="id" value="<?= $id ?>">
                <button type="submit" class="btn btn-danger">Excluir Playlist</button>
            </form>
        </div>
    </div>

    <?php if ($total > 0): ?>
    
    <div class="player-container">
        <iframe id="player" class="player-iframe"
            src="https://www.youtube.com/embed/<?= extract_youtube_id($links[0]) ?>?autoplay=1"
            allowfullscreen>
        </iframe>
        <div class="player-controls">
            <button class="control-btn" onclick="prev()">⏮</button>
            <button class="control-btn" onclick="shuffle()">🔀</button>
            <button class="control-btn" onclick="next()">⏭</button>
        </div>
    </div>

    <div class="tracks-list">
    <?php foreach ($links as $i => $url): 
        $idyt = extract_youtube_id($url);
        $thumb = "https://img.youtube.com/vi/$idyt/default.jpg";
    ?>
        <div class="track-item">
            <div class="track-thumb" onclick="play(<?= $i ?>)" style="cursor:pointer">
                <img src="<?= $thumb ?>" alt="cover">
            </div>
            <div class="track-info" onclick="play(<?= $i ?>)" style="cursor:pointer">
                <div class="track-title">Faixa <?= $i+1 ?></div>
                <div class="track-link"><?= htmlspecialchars($url) ?></div>
            </div>
            
            <form method="post" action="delete.php" onsubmit="return confirm('Remover esta música?')" style="margin:0;">
                <input type="hidden" name="playlist" value="<?= $id ?>">
                <input type="hidden" name="index" value="<?= $i ?>">
                <button class="track-action">✖</button>
            </form>
        </div>
    <?php endforeach; ?>
    </div>

    <?php else: ?>
        <div style="text-align:center; padding: 3rem; background: var(--card-bg); border-radius:12px;">
            <p style="color:var(--text-muted); margin-bottom:1rem;">Esta playlist está vazia.</p>
            <a href="add-musica.php?id=<?= $id ?>" class="btn">Adicionar primeira música</a>
        </div>
    <?php endif; ?>

</main>

<script>
let links = <?= json_encode($links) ?>;
let index = 0;
function extractID(url) {
    let r = url.match(/(?:v=|youtu\.be\/|embed\/)([a-zA-Z0-9_-]{11})/);
    return r ? r[1] : "";
}
function play(i) {
    index = i;
    document.getElementById("player").src = "https://www.youtube.com/embed/" + extractID(links[i]) + "?autoplay=1";
}
function next() { index = (index + 1) % links.length; play(index); }
function prev() { index = (index - 1 + links.length) % links.length; play(index); }
function shuffle() { index = Math.floor(Math.random() * links.length); play(index); }
</script>

</body>
</html>
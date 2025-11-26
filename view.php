<?php
require 'lib.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<p>ID inválido.</p>";
    exit;
}

$playlists = db_load();
$playlist = array_values(array_filter($playlists, fn($p) => $p['id'] == $id))[0] ?? null;

if (!$playlist) {
    echo "<p>Playlist não encontrada.</p>";
    exit;
}

$links = $playlist['links'] ?? [];
$total = count($links);

function extract_youtube_id_local($url) {
    if (preg_match('/(?:v=|youtu\.be\/|embed\/)([a-zA-Z0-9_-]{11})/', trim($url), $m)) {
        return $m[1];
    }
    return "";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($playlist['nome']) ?></title>
    <link rel="stylesheet" href="style.css">
<style>
/* ------- GERAL -------- */
main { margin-top: 1.5rem; }

/* ------- PLAYER -------- */
.player-box {
    width: 320px;
    background:#111;
    padding:12px;
    border-radius:10px;
    margin-bottom:20px;
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:10px;
    box-shadow:0 0 12px #000;
}
.player-iframe { width:100%; height:180px; border-radius:10px; border:none; }
.player-buttons { display:flex; gap:10px; width:100%; }
.player-buttons button {
    flex:1; padding:8px 0; background:#333; border:none; color:#fff;
    font-size:16px; border-radius:6px; cursor:pointer;
}
.player-buttons button:hover { background:#555; }

/* ------- LISTA DE FAIXAS -------- */
.tracks { display:flex; flex-direction:column; gap:14px; }
.track-card {
    display:flex; align-items:center; background:#1b1b1b;
    padding:10px; border-radius:10px; cursor:pointer; transition:0.2s; border:1px solid #222;
}
.track-card:hover { background:#222; transform:scale(1.01); }
.track-thumb img { width:120px; height:70px; object-fit:cover; border-radius:8px; }
.track-meta { margin-left:10px; flex:1; }
.track-title { font-size:16px; color:#fff; font-weight:600; }
.track-url { font-size:12px; opacity:0.6; }

/* Botão delete */
.track-card form button { padding:6px 10px; border:none; border-radius:6px; color:#fff; background:#a00; cursor:pointer; }
.track-card form button:hover { background:#c00; }

/* Botão deletar playlist */
.delete-playlist-btn {
    padding:8px 12px;
    background:#a00;
    color:#fff;
    border:none;
    border-radius:6px;
    cursor:pointer;
}
.delete-playlist-btn:hover { background:#c00; }

</style>
</head>
<body>

<header>
    <h1>🎧 YouPlaylist</h1>
    <nav>
        <a href="index.php">Início</a>
        <a href="sobre.php">Sobre</a>
    </nav>
</header>

<main>

<h2><?= htmlspecialchars($playlist['nome']) ?></h2>
<p><?= $total ?> músicas</p>

<!-- BOTÕES SUPERIORES -->
<div style="margin: 1rem 0; display:flex; gap:10px;">
    <a href="add-musica.php?id=<?= $id ?>" class="btn">Adicionar Música</a>
    <a href="index.php" class="btn" style="background:#444;">Voltar</a>
    <?php if ($total > 0): ?>
    <button onclick="shuffle()" class="btn" style="background:#2d6;">🔀 Shuffle</button>
    <?php endif; ?>

    <!-- Botão deletar playlist -->
    <form method="post" action="delete-playlist.php" onsubmit="return confirm('Tem certeza que deseja deletar a playlist inteira?')" style="display:inline;">
        <input type="hidden" name="id" value="<?= $id ?>">
        <button type="submit" class="delete-playlist-btn">🗑 Deletar Playlist</button>
    </form>
</div>

<?php if ($total > 0): ?>

<!-- PLAYER COMPACTO -->
<div class="player-box">
    <iframe id="player"
        class="player-iframe"
        src="https://www.youtube.com/embed/<?= extract_youtube_id_local($links[0]) ?>?autoplay=1"
        allowfullscreen>
    </iframe>
    <div class="player-buttons">
        <button onclick="prev()">⏮</button>
        <button onclick="next()">⏭</button>
    </div>
</div>

<!-- LISTA -->
<div class="tracks">
<?php foreach ($links as $i => $url): 
    $idyt = extract_youtube_id_local($url);
    $thumb = "https://img.youtube.com/vi/$idyt/hqdefault.jpg";
?>
    <div class="track-card" onclick="play(<?= $i ?>)">
        <div class="track-thumb"><img src="<?= $thumb ?>" alt="Thumbnail"></div>
        <div class="track-meta">
            <div class="track-title">Faixa <?= $i+1 ?></div>
            <div class="track-url"><?= htmlspecialchars($url) ?></div>
        </div>
        <form method="post" action="delete.php" onsubmit="return confirm('Excluir esta música?')">
            <input type="hidden" name="playlist" value="<?= $id ?>">
            <input type="hidden" name="index" value="<?= $i ?>">
            <button>🗑</button>
        </form>
    </div>
<?php endforeach; ?>
</div>

<?php else: ?>
<p>Nenhuma música ainda. Clique em <strong>Adicionar Música</strong>.</p>
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
    document.getElementById("player").src =
        "https://www.youtube.com/embed/" + extractID(links[i]) + "?autoplay=1";
}

function next() {
    index = (index + 1) % links.length;
    play(index);
}

function prev() {
    index = (index - 1 + links.length) % links.length;
    play(index);
}

function shuffle() {
    index = Math.floor(Math.random() * links.length);
    play(index);
}
</script>

</body>
</html>

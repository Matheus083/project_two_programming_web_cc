<?php
require 'lib.php';

/*
 * Se a função já existir em lib.php, não a redefinimos.
 * Isso evita o "Cannot redeclare" quando você carregar ambos os arquivos.
 */
if (!function_exists('extract_youtube_id')) {
    function extract_youtube_id($url) {
        if (preg_match('/(?:v=|youtu\.be\/|embed\/)([a-zA-Z0-9_-]{11})/', $url, $m)) {
            return $m[1];
        }
        // fallback: tenta capturar qualquer sequência de 11 chars (menos agressivo)
        if (preg_match('/([a-zA-Z0-9_-]{11})/', $url, $m2)) {
            return $m2[1];
        }
        return "";
    }
}

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: index.php");
    exit;
}

$playlists = db_load();
$playlist = null;

foreach ($playlists as $p) {
    if ($p['id'] == $id) {
        $playlist = $p;
        break;
    }
}

if (!$playlist) {
    echo "<p>Playlist não encontrada.</p>";
    exit;
}

$links = $playlist['links'] ?? [];
$hasTracks = count($links) > 0;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<title><?= htmlspecialchars($playlist['nome']) ?></title>
<link rel="stylesheet" href="style.css">
<style>
/* Pequenos estilos locais (opcional) para garantir espaçamento */
.playlist-header { display:flex; justify-content:space-between; align-items:center; gap:1rem; margin-bottom:1.2rem; }
.playlist-header h2 { margin:0; color:#fff; }
</style>
</head>
<body>

<div class="playlist-header">
    <h2><?= htmlspecialchars($playlist['nome']) ?></h2>
    <div>
        <a class="btn" href="add-musica.php?id=<?= urlencode($playlist['id']) ?>">Adicionar Música</a>
        <a class="btn" style="background:#333; margin-left:.6rem;" href="index.php">Voltar</a>
    </div>
</div>

<?php if ($hasTracks): ?>

<div class="player-box">
    <iframe id="playerFrame" class="player-iframe" src="" allow="autoplay" allowfullscreen></iframe>

    <div class="player-buttons">
        <button id="btnPrev">⏮ Voltar</button>
        <button id="btnNext">⏭ Avançar</button>
    </div>
</div>

<script>
const tracks = <?= json_encode($links, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) ?>;
let currentTrack = 0;
const frame = document.getElementById("playerFrame");

function toEmbed(url) {
    // tenta extrair id e montar URL embed segura
    try {
        // remove parâmetros após &
        let clean = url.split('&')[0];
        // transforma watch?v=... e youtu.be/... em embed
        clean = clean.replace("watch?v=", "embed/");
        clean = clean.replace("youtu.be/", "youtube.com/embed/");
        // garante https
        if (!clean.startsWith("https://")) clean = "https://" + clean.replace(/^https?:\/\//, "");
        return clean + "?autoplay=1";
    } catch(e) {
        return "";
    }
}

function loadTrack(i) {
    if (i < 0 || i >= tracks.length) return;
    currentTrack = i;
    const embed = toEmbed(tracks[currentTrack]);
    frame.src = embed;
    // atualiza destaque visual (se quiser)
    document.querySelectorAll('.track-card').forEach((c, idx) => {
        c.style.opacity = idx === i ? '0.9' : '1';
    });
}

function nextTrack() { loadTrack((currentTrack + 1) % tracks.length); }
function prevTrack() { loadTrack((currentTrack - 1 + tracks.length) % tracks.length); }

document.addEventListener('DOMContentLoaded', () => {
    // liga botões
    document.getElementById('btnNext').addEventListener('click', nextTrack);
    document.getElementById('btnPrev').addEventListener('click', prevTrack);

    // liga cards
    document.querySelectorAll('.track-card').forEach((card, i) => {
        card.addEventListener('click', () => loadTrack(i));
        card.addEventListener('keypress', (e) => { if (e.key === 'Enter') loadTrack(i); });
    });

    // carrega primeira faixa
    loadTrack(0);
});
</script>

<?php else: ?>

<p style="margin-top:20px; color:#ccc;">Nenhuma música adicionada ainda.</p>

<?php endif; ?>

<hr style="margin: 2rem 0; opacity: .12;">

<h3>Faixas da playlist</h3>

<div class="tracks">
<?php foreach ($links as $i => $url): 
    $vid = extract_youtube_id($url);
    $thumb = $vid ? "https://img.youtube.com/vi/{$vid}/hqdefault.jpg" : "https://via.placeholder.com/320x180?text=Sem+Thumbnail";
?>
    <div class="track-card" tabindex="0" role="button" aria-pressed="false">
        <div class="track-thumb"><img src="<?= htmlspecialchars($thumb) ?>" alt="thumb"></div>
        <div class="track-meta">
            <div class="track-title">Faixa <?= $i + 1 ?></div>
            <div class="track-url"><?= htmlspecialchars($url) ?></div>
        </div>
    </div>
<?php endforeach; ?>
</div>

<br><br>
<a href="index.php" class="btn" style="background:#333;">Voltar</a>

</body>
</html>

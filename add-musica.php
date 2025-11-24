<?php
require 'lib.php';

$id = $_POST['id'] ?? null;
$url = trim($_POST['url'] ?? '');

if (!$id || $url === '') {
    echo "<p>Dados inválidos.</p>";
    echo "<p><a href='index.php'>Voltar</a></p>";
    exit;
}

// carrega playlists
$playlists = db_load();

$found = false;
foreach ($playlists as $pi => $p) {
    if ($p['id'] == $id) {
        $found = true;
        $index = $pi;
        break;
    }
}

if (!$found) {
    echo "<p>Playlist não encontrada.</p>";
    echo "<p><a href='index.php'>Voltar</a></p>";
    exit;
}

// helper: extrai id do YouTube (aceita watch?v=, youtu.be/, embed/, e URLs com params)
function extractYoutubeId($url) {
    if (preg_match('/[?&]v=([a-zA-Z0-9_-]{11})/', $url, $m)) return $m[1];
    if (preg_match('#youtu\.be/([a-zA-Z0-9_-]{11})#', $url, $m)) return $m[1];
    if (preg_match('#/embed/([a-zA-Z0-9_-]{11})#', $url, $m)) return $m[1];
    if (preg_match('/([a-zA-Z0-9_-]{11})/', $url, $m)) return $m[1];
    return null;
}

$videoId = extractYoutubeId($url);

// tenta buscar título via oEmbed (sem precisar de API key)
$titulo = null;
if ($videoId) {
    $oembedUrl = "https://www.youtube.com/oembed?url=" . urlencode("https://www.youtube.com/watch?v={$videoId}") . "&format=json";
    $o = @file_get_contents($oembedUrl);
    if ($o !== false) {
        $j = @json_decode($o, true);
        if (isset($j['title'])) $titulo = $j['title'];
    }
}

// tentativa de duração (método heurístico): busca no HTML do vídeo
$duracao = null;
if ($videoId) {
    $videoPage = @file_get_contents("https://www.youtube.com/watch?v={$videoId}");
    if ($videoPage !== false) {
        // procura lengthSeconds (algumas versões do html trazem isso em player response)
        if (preg_match('/"lengthSeconds":"?(\d+)"?/', $videoPage, $m)) {
            $secs = intval($m[1]);
            $min = floor($secs / 60);
            $sec = $secs % 60;
            $duracao = sprintf("%d:%02d", $min, $sec);
        } elseif (preg_match('/"approxDurationMs":\s*"?(\d+)"?/', $videoPage, $m2)) {
            $ms = intval($m2[1]);
            $secs = intval(round($ms / 1000));
            $min = floor($secs / 60);
            $sec = $secs % 60;
            $duracao = sprintf("%d:%02d", $min, $sec);
        }
    }
}

// se não pegou título, cria um título genérico
if (!$titulo) {
    // conta quantas músicas existem hoje para criar nome "Faixa X"
    $count = 0;
    if (isset($playlists[$index]['musicas']) && is_array($playlists[$index]['musicas'])) {
        $count = count($playlists[$index]['musicas']);
    } elseif (isset($playlists[$index]['links']) && is_array($playlists[$index]['links'])) {
        $count = count($playlists[$index]['links']);
    }
    $titulo = "Faixa " . ($count + 1);
}

// prepara objeto de música
$musicaObj = [
    "id_video" => $videoId,
    "titulo"   => $titulo,
    "duracao"  => $duracao, // pode ser null
    "url"      => $url
];

// assegura chave 'musicas'
if (!isset($playlists[$index]['musicas']) || !is_array($playlists[$index]['musicas'])) {
    $playlists[$index]['musicas'] = [];
}

// adiciona metadados no array 'musicas'
$playlists[$index]['musicas'][] = $musicaObj;

// para compatibilidade com outras partes do código que usam 'links', também adicionamos lá
if (!isset($playlists[$index]['links']) || !is_array($playlists[$index]['links'])) {
    $playlists[$index]['links'] = [];
}
$playlists[$index]['links'][] = $url;

// salva o JSON
$ok = file_put_contents(
    "playlists.json",
    json_encode($playlists, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
);

header("Location: view.php?id=" . $playlists[$index]['id']);
exit;

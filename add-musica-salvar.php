<?php
require 'lib.php';

$id = $_POST['id'] ?? null;
$url = $_POST['url'] ?? "";

if (!$id || $url === "") {
    echo "<p>Dados inválidos.</p>";
    echo "<p><a href='index.php'>Voltar</a></p>";
    exit;
}

$playlists = db_load();

$salvou = false;

foreach ($playlists as $index => $p) {
    if ($p['id'] == $id) {
        $playlists[$index]['links'][] = $url;
        $salvou = true;
        break;
    }
}

if ($salvou) {
    file_put_contents(
        "playlists.json",
        json_encode($playlists, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
    );
}

header("Location: view.php?id=" . $id);
exit;

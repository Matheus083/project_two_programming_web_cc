<?php
require 'lib.php';
verificar_auth();

$id = $_POST['id'] ?? null;
$url = $_POST['url'] ?? "";

if (!$id || $url === "") {
    header("Location: add-musica.php?id=$id&error=empty");
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
    db_save($playlists);
}

header("Location: view.php?id=" . $id);
exit;
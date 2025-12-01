<?php
require 'lib.php';
verificar_auth();

$playlistId = $_POST['playlist'] ?? null;
$musicIndex = $_POST['index'] ?? null;

if ($playlistId === null || $musicIndex === null) {
    exit;
}

$playlists = db_load();

foreach ($playlists as &$p) {
    if ($p['id'] == $playlistId) {
        if (isset($p['links'][$musicIndex])) {
            array_splice($p['links'], $musicIndex, 1);
        }
        break;
    }
}

db_save($playlists);

header("Location: view.php?id=" . $playlistId);
exit;
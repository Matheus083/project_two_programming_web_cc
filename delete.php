<?php
require 'lib.php';

$playlistId = $_POST['playlist'] ?? null;
$musicIndex = $_POST['index'] ?? null;

if ($playlistId === null || $musicIndex === null) {
    echo "<p>Dados inválidos.</p>";
    exit;
}

$playlists = db_load();

foreach ($playlists as &$p) {
    if ($p['id'] == $playlistId) {
        if (isset($p['links'][$musicIndex])) {
            array_splice($p['links'], $musicIndex, 1); // remove 1 item
        }
        break;
    }
}

db_save($playlists);

header("Location: view.php?id=" . $playlistId);
exit;

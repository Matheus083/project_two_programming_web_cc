<?php
require 'lib.php';
verificar_auth();

$id = $_POST['id'] ?? null;
if (!$id) exit;

$playlists = db_load();
$index = false;

foreach ($playlists as $key => $p) {
    if ($p['id'] == $id) {
        $index = $key;
        break;
    }
}

if ($index !== false) {
    array_splice($playlists, $index, 1);
    db_save($playlists);
}

header("Location: index.php");
exit;
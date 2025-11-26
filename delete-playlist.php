<?php
require 'lib.php';

$id = $_POST['id'] ?? null;
if (!$id) {
    echo "<p>ID inválido.</p>";
    exit;
}

$playlists = db_load();
$index = array_search($id, array_column($playlists, 'id'));

if ($index === false) {
    echo "<p>Playlist não encontrada.</p>";
    exit;
}

// Remove a playlist
array_splice($playlists, $index, 1);
db_save($playlists);

// Redireciona para a página inicial
header("Location: index.php");
exit;

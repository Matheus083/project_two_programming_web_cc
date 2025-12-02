<?php
require 'lib.php';
verificar_auth();

// Parâmetros enviados pelo formulário
$playlistId = $_POST['playlist'] ?? null;
$musicIndex = $_POST['index'] ?? null;

// Validação
if (!$playlistId || $musicIndex === null) {
    exit("Parâmetros faltando.");
}

// Carrega playlists
$playlists = db_load();

// Procura a playlist
foreach ($playlists as $pIndex => $p) {
    if ($p['id'] == $playlistId) {

        // Verifica se a música existe
        if (isset($playlists[$pIndex]['links'][$musicIndex])) {

            unset($playlists[$pIndex]['links'][$musicIndex]);

            // Reorganiza o array
            $playlists[$pIndex]['links'] = array_values($playlists[$pIndex]['links']);

            db_save($playlists);
        }

        header("Location: view.php?id=" . $playlistId);
        exit;
    }
}

exit("Playlist não encontrada.");

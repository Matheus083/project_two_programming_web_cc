<?php

const PLAYLIST_FILE = __DIR__ . '/playlists.json';

function db_load(): array {
    if (!file_exists(PLAYLIST_FILE)) {
        return [];
    }

    $json = file_get_contents(PLAYLIST_FILE);
    $dados = json_decode($json, true);

    if (!is_array($dados)) {
        return [];
    }

    return $dados; 
}

function db_save(array $playlists): void {
    file_put_contents(
        PLAYLIST_FILE,
        json_encode($playlists, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
    );
}

function next_id(array $playlists): int {
    if (empty($playlists)) {
        return 1;
    }

    $ids = array_column($playlists, 'id');
    return max($ids) + 1;
}

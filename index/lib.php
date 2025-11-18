<?php

// Caminho do "banco de dados" (JSON)
const PLAYLIST_FILE = __DIR__ . '/playlists.json';

// Carrega as playlists do arquivo JSON
function db_load(): array {
    if (!file_exists(PLAYLIST_FILE)) {
        // Se não existir ainda, começa com lista vazia
        return [];
    }

    $json = file_get_contents(PLAYLIST_FILE);
    $dados = json_decode($json, true);

    if (!is_array($dados)) {
        return [];
    }

    return $dados; // aqui $dados é um array de playlists
}

// Salva as playlists no arquivo JSON
function db_save(array $playlists): void {
    file_put_contents(
        PLAYLIST_FILE,
        json_encode($playlists, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
    );
}

// Gera um novo ID para uma playlist
function next_id(array $playlists): int {
    // Se não tiver nada, começa em 1
    if (empty($playlists)) {
        return 1;
    }

    // Pega o maior id que já existe e soma 1
    $ids = array_column($playlists, 'id');
    return max($ids) + 1;
}

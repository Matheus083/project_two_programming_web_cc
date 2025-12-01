<?php
session_start();

const USER_FILE = __DIR__ . '/usuarios.json';

function get_all_users(): array {
    if (!file_exists(USER_FILE)) return [];
    $json = file_get_contents(USER_FILE);
    $data = json_decode($json, true);
    return is_array($data) ? $data : [];
}

function save_all_users(array $users): void {
    file_put_contents(
        USER_FILE,
        json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
    );
}

function cadastrar_usuario($login, $senha) {
    $users = get_all_users();
    
    foreach ($users as $u) {
        if ($u['login'] === $login) return false;
    }

    $users[] = [
        'login' => $login,
        'senha' => password_hash($senha, PASSWORD_DEFAULT),
        'playlists' => []
    ];

    save_all_users($users);
    return true;
}

function logar_usuario($login, $senha) {
    $users = get_all_users();
    foreach ($users as $u) {
        if ($u['login'] === $login && password_verify($senha, $u['senha'])) {
            $_SESSION['usuario'] = $login;
            return true;
        }
    }
    return false;
}

function verificar_auth() {
    if (!isset($_SESSION['usuario'])) {
        header("Location: login.php");
        exit;
    }
}

function db_load(): array {
    if (!isset($_SESSION['usuario'])) return [];

    $users = get_all_users();
    foreach ($users as $u) {
        if ($u['login'] === $_SESSION['usuario']) {
            return $u['playlists'] ?? [];
        }
    }
    return [];
}

function db_save(array $playlists): void {
    if (!isset($_SESSION['usuario'])) return;

    $users = get_all_users();
    foreach ($users as &$u) {
        if ($u['login'] === $_SESSION['usuario']) {
            $u['playlists'] = $playlists;
            break;
        }
    }
    save_all_users($users);
}

function next_id(array $playlists): int {
    if (empty($playlists)) return 1;
    $ids = array_column($playlists, 'id');
    return max($ids) + 1;
}

function extract_youtube_id($url) {
    if (preg_match('/(?:v=|youtu\.be\/|embed\/)([a-zA-Z0-9_-]{11})/', trim($url), $match)) {
        return $match[1];
    }
    return "";
}
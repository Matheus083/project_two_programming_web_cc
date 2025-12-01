<?php
// Inicia a sessão para controlar autenticação e dados do usuário
session_start();

/**
 * Caminho do arquivo que armazena os usuários
 * Cada usuário contém: login, senha hash, playlists
 */
const USER_FILE = __DIR__ . '/usuarios.json';

/* ============================================================
   ===============      FUNÇÕES DE USUÁRIOS      ===============
   ============================================================ */

/**
 * Lê todos os usuários do arquivo JSON.
 * 
 * @return array Lista de usuários cadastrados
 */
function get_all_users(): array {
    if (!file_exists(USER_FILE)) return [];

    $json = file_get_contents(USER_FILE);
    $data = json_decode($json, true);

    return is_array($data) ? $data : [];
}

/**
 * Salva a lista completa de usuários no arquivo JSON.
 * 
 * @param array $users Lista de usuários
 */
function save_all_users(array $users): void {
    file_put_contents(
        USER_FILE,
        json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
    );
}

/**
 * Cadastra um novo usuário.
 * Verifica se o login já existe, cria senha com hash e salva.
 * 
 * @param string $login Nome do usuário
 * @param string $senha Senha em texto puro
 * @return bool True se cadastrado / False se já existe
 */
function cadastrar_usuario($login, $senha) {
    $users = get_all_users();
    
    // Checa se já existe um login igual
    foreach ($users as $u) {
        if ($u['login'] === $login) return false;
    }

    // Adiciona novo usuário com senha criptografada
    $users[] = [
        'login' => $login,
        'senha' => password_hash($senha, PASSWORD_DEFAULT),
        'playlists' => [] // Cada usuário tem suas próprias playlists
    ];

    save_all_users($users);
    return true;
}

/**
 * Realiza o login do usuário.
 * Compara o login e verifica se a senha está correta.
 * 
 * @param string $login
 * @param string $senha
 * @return bool True se logado / False se falhou
 */
function logar_usuario($login, $senha) {
    $users = get_all_users();

    foreach ($users as $u) {
        // Verifica login e compara senha usando password_verify
        if ($u['login'] === $login && password_verify($senha, $u['senha'])) {
            $_SESSION['usuario'] = $login; // Guarda login na sessão
            return true;
        }
    }
    return false;
}

/**
 * Verifica se o usuário está logado.
 * Caso não esteja, redireciona para o login.
 */
function verificar_auth() {
    if (!isset($_SESSION['usuario'])) {
        header("Location: login.php");
        exit;
    }
}

/* ============================================================
   ===============     FUNÇÕES DE PLAYLISTS     ===============
   ============================================================ */

/**
 * Carrega as playlists do usuário logado.
 * 
 * @return array Playlists do usuário atual
 */
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

/**
 * Salva as playlists do usuário logado.
 * 
 * @param array $playlists Nova lista de playlists
 */
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

/**
 * Gera o próximo ID numérico disponível para playlists.
 * 
 * @param array $playlists Lista de playlists existentes
 * @return int Novo ID único
 */
function next_id(array $playlists): int {
    if (empty($playlists)) return 1;

    $ids = array_column($playlists, 'id');
    return max($ids) + 1;
}

/**
 * Extrai o ID de um vídeo do YouTube a partir de uma URL comum.
 * Aceita formatos: 
 * - https://youtube.com/watch?v=ID
 * - https://youtu.be/ID
 * - https://youtube.com/embed/ID
 * 
 * @param string $url Link do vídeo
 * @return string Retorna o ID (11 caracteres) ou "" se inválido
 */
function extract_youtube_id($url) {
    if (preg_match('/(?:v=|youtu\.be\/|embed\/)([a-zA-Z0-9_-]{11})/', trim($url), $match)) {
        return $match[1];
    }
    return "";
}

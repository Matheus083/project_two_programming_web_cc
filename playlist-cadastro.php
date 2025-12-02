<?php
// Processa o cadastro de uma nova playlist

require 'lib.php';

// Garante que só usuário logado pode criar playlist
verificar_auth();

// Só aceita requisição via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: criar.php");
    exit;
}

// Coleta os dados enviados pelo formulário
$nome = $_POST['nome'] ?? '';
$url  = $_POST['url'] ?? '';

// Validação simples: nome é obrigatório
if (trim($nome) === '') {
    header("Location: criar.php");
    exit;
}

// Carrega playlists atuais do usuário logado
$playlists = db_load();

// Gera um novo ID único usando a função do lib.php
$id = next_id($playlists);

// Monta a nova playlist
$novaPlaylist = [
    'id'    => $id,
    'nome'  => $nome,
    'links' => []
];

// Se o usuário já informou um link inicial, adiciona
if (trim($url) !== '') {
    $novaPlaylist['links'][] = $url;
}

// Adiciona a nova playlist ao array
$playlists[] = $novaPlaylist;

// Salva de volta no JSON associado ao usuário logado
db_save($playlists);

// Redireciona para a página da playlist recém-criada
header("Location: view.php?id=" . $id);
exit;

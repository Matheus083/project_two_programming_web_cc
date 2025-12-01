<?php
require 'lib.php';          // Importa funções essenciais, como db_load(), db_save() e verificar_auth()
verificar_auth();           // Garante que só usuários LOGADOS possam adicionar músicas

// Recebendo dados do formulário via método POST
$id = $_POST['id'] ?? null;     // ID da playlist
$url = $_POST['url'] ?? "";     // Link do YouTube inserido pelo usuário

// Validação: se faltar o ID ou o URL estiver vazio, retorna para o formulário com erro
if (!$id || $url === "") {
    header("Location: add-musica.php?id=$id&error=empty");
    exit;
}

// Carrega o "banco de dados" (playlists.json)
$playlists = db_load();
$salvou = false;

// Procura a playlist correta dentro do array
foreach ($playlists as $index => $p) {
    if ($p['id'] == $id) {

        // Adiciona o novo link dentro do array 'links'
        $playlists[$index]['links'][] = $url;

        $salvou = true;
        break; // para o loop
    }
}

// Se encontrou e alterou a playlist, salva novamente no arquivo JSON
if ($salvou) {
    db_save($playlists);
}

// Redireciona o usuário de volta para a página da playlist
header("Location: view.php?id=" . $id);
exit;

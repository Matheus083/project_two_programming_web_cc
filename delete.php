<?php
// Importa funções do sistema
require 'lib.php';

// Garante que o usuário está logado
verificar_auth();

// Obtém o ID da playlist enviada pelo formulário
$id = $_POST['id'] ?? null;

// Se nenhum ID foi enviado, encerra o script
if (!$id) exit;

// Carrega todas as playlists do arquivo JSON
$playlists = db_load();

// Variável para guardar o índice encontrado no array
$index = false;

// Percorre todas as playlists para encontrar qual tem o ID enviado
foreach ($playlists as $key => $p) {
    if ($p['id'] == $id) {
        $index = $key; // Guarda o índice exato dentro do array
        break;
    }
}

// Se encontrou, remove a playlist do array
if ($index !== false) {
    // Remove exatamente 1 elemento a partir do índice encontrado
    array_splice($playlists, $index, 1);

    // Salva novamente o array atualizado no arquivo JSON
    db_save($playlists);
}

// Redireciona para a página inicial
header("Location: index.php");
exit;

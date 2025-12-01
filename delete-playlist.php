<?php
// Importa todas as funções essenciais da aplicação
// como carregar e salvar playlists, autenticação, etc.
require 'lib.php';

// Verifica se o usuário está logado.
// Se não estiver, ele é automaticamente redirecionado ao login.
verificar_auth();


// Recebe o ID da playlist enviada pelo formulário como POST.
// Caso o ID não exista, o script é encerrado imediatamente.
$id = $_POST['id'] ?? null;
if (!$id) exit;


// Carrega todas as playlists do arquivo JSON.
$playlists = db_load();


// Variável que armazenará a posição da playlist dentro do array.
// Começa como "false" para indicar que não foi encontrada ainda.
$index = false;


// Loop para encontrar qual item do array possui o ID enviado.
// $key é o índice da playlist no array (posição no JSON).
// $p é a playlist atual.
foreach ($playlists as $key => $p) {
    if ($p['id'] == $id) {
        $index = $key; // Aqui encontramos a posição da playlist
        break;         // Encerra o loop, pois já achamos
    }
}


// Se a playlist foi encontrada ($index !== false),
// então ela será removida do array.
if ($index !== false) {

    // Remove 1 elemento na posição encontrada.
    // array_splice modifica o array original.
    array_splice($playlists, $index, 1);

    // Salva o array atualizado de playlists no JSON.
    db_save($playlists);
}


// Redireciona o usuário de volta para a página inicial,
// onde a lista de playlists será mostrada sem a que foi deletada.
header("Location: index.php");
exit;

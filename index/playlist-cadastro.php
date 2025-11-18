<?php
$arquivo_json = "playlists.json";

// Coleta simples (sem validações complexas)
$nome = $_POST['nome'] ?? "";
$url  = $_POST['url']  ?? ""; // primeiro link do YouTube (opcional)

// Carrega JSON existente (ou inicia vazio)
$playlists = [];
if (file_exists($arquivo_json)) {
    $json = file_get_contents($arquivo_json);
    $playlists = json_decode($json, true);
    if (!is_array($playlists)) { 
        $playlists = []; 
    }
}

// Gera ID simples
$id = count($playlists) + 1;

// Monta o registro da playlist
$nova_playlist = [
    "id"    => $id,
    "nome"  => $nome,
    // guardando os links como um array, começando com o primeiro link (se tiver)
    "links" => []
];

if ($url !== "") {
    $nova_playlist["links"][] = $url;
}

// Adiciona no array principal
$playlists[] = $nova_playlist;

// Salva no arquivo
$ok = file_put_contents(
    $arquivo_json, 
    json_encode($playlists, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)
);

if ($ok !== false) {
    echo "<p>Playlist <strong>{$nome}</strong> cadastrada com sucesso.</p>";
    echo "<p><a href='index.php'>Listar Playlists</a></p>";
    echo "<p><a href='playlist-cadastro-form.php'>Cadastrar outra playlist</a></p>";
} else {
    echo "<h2>Erro ao salvar.</h2>";
    echo "<p><a href='playlist-cadastro-form.php'>Voltar</a></p>";
}
?>
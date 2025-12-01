<?php
require 'lib.php';
verificar_auth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: criar.php");
    exit;
}

$nome = $_POST['nome'] ?? "";
$url  = $_POST['url']  ?? ""; 

$playlists = db_load();
$id = next_id($playlists);

$nova_playlist = [
    "id"    => $id,
    "nome"  => $nome,
    "links" => []
];

if ($url !== "") {
    $nova_playlist["links"][] = $url;
}

$playlists[] = $nova_playlist;

db_save($playlists);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Playlist cadastrada</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Playlists</h1>
    <nav><a href="index.php">Início</a></nav>
</header>
<main>
    <div class="form-box" style="text-align:center;">
        <h2 style="color:#FF4B2B; margin-bottom:1rem;">Sucesso!</h2>
        <p>Playlist <strong><?= htmlspecialchars($nome) ?></strong> cadastrada.</p>
        <a class="btn" style="margin-top:1.5rem;" href="index.php">Listar Minhas Playlists</a>
    </div>
</main>
</body>
</html>
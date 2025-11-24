<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: criar.php");
    exit;
}

$arquivo_json = "playlists.json";

$nome = $_POST['nome'] ?? "";
$url  = $_POST['url']  ?? ""; 

$playlists = [];
if (file_exists($arquivo_json)) {
    $json = file_get_contents($arquivo_json);
    $playlists = json_decode($json, true);
    if (!is_array($playlists)) { 
        $playlists = []; 
    }
}

$id = count($playlists) + 1;

$nova_playlist = [
    "id"    => $id,
    "nome"  => $nome,
    "links" => []
];

if ($url !== "") {
    $nova_playlist["links"][] = $url;
}

$playlists[] = $nova_playlist;

$ok = file_put_contents(
    $arquivo_json, 
    json_encode($playlists, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)
);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playlist cadastrada</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Playlists</h1>
    <nav>
        <a href="index.php">Início</a>
        <a href="criar.php">Criar Playlist</a>
    </nav>
</header>

<main>
<?php if ($ok !== false): ?>
    <div class="form-box" style="text-align:center;">
        <h2 style="color:#FF4B2B; margin-bottom:1rem;">Playlist cadastrada</h2>

        <p>Playlist <strong><?= htmlspecialchars($nome) ?></strong> cadastrada com sucesso.</p>

        <a class="btn" style="margin-top:1.5rem; display:inline-block;" href="index.php">
            Listar Playlists
        </a>
        <br><br>
        <a class="btn" style="background:#444;" href="criar.php">
            Cadastrar outra playlist
        </a>
    </div>
<?php else: ?>
    <div class="form-box" style="text-align:center;">
        <h2 style="color:#FF4B2B; margin-bottom:1rem;">Erro ao salvar</h2>
        <p>Ocorreu um problema ao tentar salvar a playlist.</p>

        <a class="btn" style="margin-top:1.5rem;" href="criar.php">Voltar</a>
    </div>
<?php endif; ?>
</main>

<footer>
    © <?= date("Y") ?> - Sistema de Playlists
</footer>

</body>
</html>

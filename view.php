<?php
// Inclui funções auxiliares do arquivo 'lib.php'
require 'lib.php';

// Verifica se o usuário está autenticado. Caso não esteja, redireciona ou bloqueia o acesso.
verificar_auth();

// Obtém o ID da playlist a partir da URL (ex: view.php?id=1)
$id = $_GET['id'] ?? null;

// Se nenhum ID for fornecido, redireciona para a página inicial
if (!$id) { 
    header("Location: index.php"); 
    exit; 
}

// Carrega todas as playlists do banco de dados ou arquivo
$playlists = db_load();

// Inicializa a variável que irá armazenar a playlist atual
$playlist = null;

// Procura a playlist com o ID fornecido
foreach ($playlists as $p) {
    if ($p['id'] == $id) { 
        $playlist = $p; 
        break; 
    }
}

// Se não encontrar a playlist, exibe mensagem de erro e encerra
if (!$playlist) { 
    echo "<p>Playlist não encontrada.</p>"; 
    exit; 
}

// Obtém os links de vídeos/músicas da playlist
$links = $playlist['links'] ?? [];

// Conta quantas músicas existem na playlist
$total = count($links);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <!-- Título da página com o nome da playlist -->
    <title><?= htmlspecialchars($playlist['nome']) ?></title>
    <!-- Link para o arquivo de estilos CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>You<span>Playlist</span></h1>
    <nav>
        <!-- Navegação principal: voltar e logout -->
        <a href="index.php">Voltar</a>
        <a href="logout.php" class="logout-btn">Sair</a>
    </nav>
</header>

<main>

    <!-- Cabeçalho da visualização da playlist -->
    <div class="view-header">
        <div>
            <!-- Nome da playlist -->
            <h2 style="margin-bottom:0.2rem"><?= htmlspecialchars($playlist['nome']) ?></h2>
            <!-- Quantidade de músicas na fila -->
            <span style="color:var(--text-muted)"><?= $total ?> músicas na fila</span>
        </div>
        <div style="display:flex; gap:10px;">
            <!-- Botão para adicionar música -->
            <a href="add-musica.php?id=<?= $id ?>" class="btn">Adicionar Música</a>
            <!-- Formulário para deletar a playlist inteira -->
            <form method="post" action="delete-playlist.php" onsubmit="return confirm('Tem certeza? Isso apaga tudo!')">
                <input type="hidden" name="id" value="<?= $id ?>">
                <button type="submit" class="btn btn-danger">Excluir Playlist</button>
            </form>
        </div>
    </div>

    <!-- Se houver músicas na playlist -->
    <?php if ($total > 0): ?>
    
    <!-- Player de vídeo incorporado do YouTube -->
    <div class="player-container">
        <iframe id="player" class="player-iframe"
            src="https://www.youtube.com/embed/<?= extract_youtube_id($links[0]) ?>?autoplay=1"
            allowfullscreen>
        </iframe>
        <!-- Controles do player -->
        <div class="player-controls">
            <button class="control-btn" onclick="prev()">⏮</button>
            <button class="control-btn" onclick="shuffle()">🔀</button>
            <button class="control-btn" onclick="next()">⏭</button>
        </div>
    </div>

    <!-- Lista de faixas -->
    <div class="tracks-list">
    <?php foreach ($links as $i => $url): 
        // Extrai o ID do vídeo do YouTube
        $idyt = extract_youtube_id($url);
        // URL da miniatura do vídeo
        $thumb = "https://img.youtube.com/vi/$idyt/default.jpg";
    ?>
        <div class="track-item">
            <!-- Miniatura clicável para tocar a música -->
            <div class="track-thumb" onclick="play(<?= $i ?>)" style="cursor:pointer">
                <img src="<?= $thumb ?>" alt="cover">
            </div>
            <!-- Informações da faixa -->
            <div class="track-info" onclick="play(<?= $i ?>)" style="cursor:pointer">
                <div class="track-title">Faixa <?= $i+1 ?></div>
                <div class="track-link"><?= htmlspecialchars($url) ?></div>
            </div>
            
            <!-- Botão para remover a faixa individualmente -->
            <form method="post" action="delete.php" onsubmit="return confirm('Remover esta música?')" style="margin:0;">
                <input type="hidden" name="playlist" value="<?= $id ?>">
                <input type="hidden" name="index" value="<?= $i ?>">
                <button class="track-action">✖</button>
            </form>

        </div>
    <?php endforeach; ?>
    </div>

    <?php else: ?>
        <!-- Mensagem se a playlist estiver vazia -->
        <div style="text-align:center; padding: 3rem; background: var(--card-bg); border-radius:12px;">
            <p style="color:var(--text-muted); margin-bottom:1rem;">Esta playlist está vazia.</p>
            <a href="add-musica.php?id=<?= $id ?>" class="btn">Adicionar primeira música</a>
        </div>
    <?php endif; ?>

</main>

<!-- Scripts JavaScript para controlar o player -->
<script>
// Array com todos os links da playlist
let links = <?= json_encode($links) ?>;
let index = 0;

// Função para extrair o ID de um vídeo do YouTube a partir da URL
function extractID(url) {
    let r = url.match(/(?:v=|youtu\.be\/|embed\/)([a-zA-Z0-9_-]{11})/);
    return r ? r[1] : "";
}

// Função para reproduzir uma música pelo índice
function play(i) {
    index = i;
    document.getElementById("player").src = "https://www.youtube.com/embed/" + extractID(links[i]) + "?autoplay=1";
}

// Próxima música
function next() { 
    index = (index + 1) % links.length; 
    play(index); 
}

// Música anterior
function prev() { 
    index = (index - 1 + links.length) % links.length; 
    play(index); 
}

// Tocar música aleatória
function shuffle() { 
    index = Math.floor(Math.random() * links.length); 
    play(index); 
}
</script>

</body>
</html>

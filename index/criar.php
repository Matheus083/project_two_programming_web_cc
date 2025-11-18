<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Criar Playlist - YouPlaylist</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <header>
    <h1>🎧 YouPlaylist</h1>
    <nav>
      <a href="inicio.php">Início</a>
      <a href="index.php">Minhas Playlists</a>
      <a href="sobre.php">Sobre</a>
    </nav>
  </header>

  <main>
    <section>
      <h2>Criar nova playlist</h2>

     
      <form method="post" action="playlist-cadastro.php" class="playlist-form">
        <label>Nome da playlist:</label>
        <input 
          type="text" 
          name="nome" 
          required 
        />

        <label>Adicionar link do YouTube:</label>
        <input 
          type="url" 
          name="url"  
        />

        <button type="submit" class="new-playlist-btn">Salvar Playlist</button>
      </form>
    </section>
  </main>

  <footer>
    © 2025 Grupo de Desenvolvimento Web | Projeto YouPlaylist
  </footer>
</body>
</html>
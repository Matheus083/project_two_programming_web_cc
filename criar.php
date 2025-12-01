<?php
// Importa funções do arquivo principal da aplicação.
// Essas funções incluem autenticação, manipulação de playlists,
// e outras utilidades usadas em várias páginas.
require 'lib.php';

// Garante que o usuário esteja logado antes de acessar esta página.
// Caso não esteja logado, será redirecionado para login.php
verificar_auth();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />

  <!-- Título que aparece na aba do navegador -->
  <title>Criar Playlist - YouPlaylist</title>

  <!-- Estilos gerais do sistema -->
  <link rel="stylesheet" href="style.css" />
</head>
<body>

  <!-- Cabeçalho da página -->
  <header>
    <!-- Logo com emoji -->
    <h1>🎧 YouPlaylist</h1>

    <!-- Menu de navegação -->
    <nav>
      <!-- Link para voltar para a lista de playlists -->
      <a href="index.php">Minhas Playlists</a>

      <!-- Link para logout (encerra sessão do usuário) -->
      <a href="logout.php">Sair</a>
    </nav>
  </header>


  <main>
    <section>
      <!-- Título do formulário -->
      <h2>Criar nova playlist</h2>

      <!-- Formulário para criar nova playlist -->
      <!-- Envia os dados para playlist-cadastro.php -->
      <form method="post" action="playlist-cadastro.php" class="playlist-form">

        <!-- Campo para digitar o nome da playlist -->
        <label>Nome da playlist:</label>
        <input type="text" name="nome" required />

        <!-- Campo opcional para já adicionar um vídeo na playlist -->
        <label>Adicionar link do YouTube (opcional):</label>
        <input type="url" name="url" />

        <!-- Botão de envio -->
        <button type="submit" class="new-playlist-btn">Salvar Playlist</button>
      </form>
    </section>
  </main>

  <!-- Rodapé simples -->
  <footer>© 2025 YouPlaylist</footer>
</body>
</html>

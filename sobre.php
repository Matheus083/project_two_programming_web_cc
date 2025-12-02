<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sobre Nós - YouPlaylist</title>
  <link rel="stylesheet" href="style.css" />
  <style>

    /* CAIXAS */
    .sobre-container {
      max-width: 900px;
      margin: auto;
      display: flex;
      flex-direction: column;
      gap: 2rem;
    }

    .sobre-box {
      background: var(--card-bg);
      padding: 2rem;
      border-radius: 10px;
      border: 1px solid var(--border);
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
    }

    .sobre-box h2 {
      color: var(--primary);
      margin-bottom: 1rem;
    }

    /* FRASE DE IMPACTO ROLANDO */
    .impact-container {
      margin-top: 3rem;
      width: 100%;
      overflow: hidden;
      white-space: nowrap;
      border-top: 1px solid rgba(255,255,255,0.1);
      border-bottom: 1px solid rgba(255,255,255,0.1);
      padding: 15px 0;
    }

    .impact-text {
      display: inline-block;
      font-size: 1.2rem;
      padding-left: 100%;
      animation: slideLeft 18s linear infinite;
      color: var(--text-muted);
      font-weight: 600;
    }

    @keyframes slideLeft {
      from { transform: translateX(0); }
      to   { transform: translateX(-100%); }
    }
  </style>
</head>

<body>
  <header>
    <h1>🎧 YourPlaylist</h1>
    <nav>
      <a href="inicio.php">Início</a>
      <a href="index.php">Minhas Playlists</a>
      <a class="active" href="sobre.php">Sobre</a>
    </nav>
  </header>

  <main class="sobre-page">

    <div class="sobre-container">

      <!-- CAIXA 1 -->
      <section class="sobre-box">
        <h2>Sobre Nós</h2>
        <p>
          O <strong>YouPlaylist</strong> nasceu como um projeto acadêmico do curso de Ciência da Computação,
          com a missão de tornar simples o que sempre deveria ter sido simples:
          organizar e ouvir suas músicas favoritas com liberdade.
        </p>
        <p>
          Criamos uma plataforma leve, rápida e intuitiva para transformar vídeos do YouTube em
          playlists personalizadas, no seu ritmo, no seu estilo.
        </p>
      </section>

      <!-- CAIXA 2 -->
      <section class="sobre-box">
        <h2>Nossa Missão</h2>
        <p>
          Entregar uma experiência fluida, acessível e agradável, unindo tecnologia e design para que
          você possa transformar vídeos em momentos.
        </p>
      </section>

    </div>

    <!-- FRASE ROLANDO -->
    <div class="impact-container">
      <div class="impact-text">
        A música conecta pessoas — e organizar suas playlists deveria ser tão simples quanto apertar o play.
      </div>
    </div>

  </main>

  <footer>
    © 2025 YourPlaylist — Projeto de Desenvolvimento Web
  </footer>
</body>
</html>

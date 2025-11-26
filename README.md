# project_two_programming_web_cc
Segundo projeto da disciplina de programação web do curso de ciência da computação.
Tema do projeto:
SITE PARA CRIAR PLAYLISTS DE MUSICAS ONLINE.

Integrantes da equipe:
- João Emanoel (Front-end + Back-end)
- Matheus Nunes (Gerente de projetos);
- Italo Moraes (Back-end);
- Caze Netto (Back-end);
- Bruno Sales (Full-Stack);


# YourPlaylist 🎧  
Projeto de Programação Web – Criação e edição de playlists com vídeos do YouTube

## 📌 Descrição do projeto

O YourPlaylist é um site onde o usuário pode criar playlists personalizadas com links de vídeos do YouTube e reproduzi-los dentro da própria aplicação.  
A ideia é simular uma experiência simples de “mini Spotify / YouTube playlists”, focando em:

- Organização de playlists
- Armazenamento de links
- Reprodução embutida dos vídeos
- Estrutura de páginas em PHP seguindo o que foi pedido em aula

O projeto está sendo desenvolvido como trabalho da disciplina de Programação Web, utilizando HTML, CSS, PHP e arquivos em JSON para armazenamento dos dados.

---

Obs.: Conforme combinado em reunião, todos terão contato com o back-end (PHP), mesmo quem começou focado em front-end.

---

## 🛠 Tecnologias utilizadas

- HTML
- CSS
- PHP
- Arquivos TXT / JSON: para armazenamento de dados
- GitHub (com colaboração via pull request)
- GitHub Codespaces (edição do código direto no navegador)
- docker (rodar o projeto)

---

## Estrutura do site (páginas)

## Página Inicial – index.php

- Cabeçalho com o nome do projeto (YourPlaylist) e logo ao lado  
- Menu principal com links para:
  - Início
  - Minhas Playlists
  - Sobre
  - Login (se der tempo)

- Botão/área de destaque com:
  - Criar nova playlist
  - Ver minhas playlists
  - Layout simples e minimalista, focado em usabilidade.

---

## Minhas Playlists – minhas_playlists.php

- Lista todas as playlists já cadastradas pelo usuário.
- Para cada playlist, exibe:
  - Nome da playlist
  - Quantidade de músicas
- Ações:
  - Ver playlist
  - Excluir playlist (se der tempo)
  - Renomear playlist (se der tempo)

---

## Criar nova playlist – criar_playlist.php

- Formulário para:
  - Nome da playlist  
  - Adicionar link do Youtube

---

## Detalhes da Playlist – playlist.php

Página onde o usuário gerencia uma playlist específica.

- Exibe:
  - Nome da playlist
  - Lista de vídeos cadastrados
  - Botão para adicionar nova música

- Funcionalidades:
  - Adicionar vídeo à playlist
  - Vídeos cadastrados
  - Reproduzir o vídeo embutido (player do YouTube dentro da página)
  - Remover vídeo da playlist (se der tempo)

---

## Sobre Nós / Sobre o Projeto – sobre.php

- Breve texto explicando:
  - O que é o YourPlaylist
  - Objetivo do projeto na disciplina
  - Nome dos integrantes do grupo
  - Frase de “empresa fictícia”, simulando um serviço de streaming

---

## (Opcional / Extra) Login e Cadastro de Usuário – `login.php` / `cadastro.php`

Extra: não obrigatório, mas cogitado pelo grupo.

- Cadastro simples:
  - Nome de usuário
  - Senha
  - Login básico:
  - Ao logar, o sistema carrega as playlists daquele usuário.
  - Armazenamento: Usuário + playlists salvos em um arquivo JSON/TXT


## Fluxo de uso do usuário

1. Usuário acessa a página inicial (index.php).
2. Clica em + Criar nova playlist:
   - Define nome
   - Adiciona Link do Youtube
3. É redirecionado para a página da playlist:
   - Adiciona links de vídeos do YouTube.
4. Sempre que acessar Minhas Playlists, consegue:
   - Ver todas as playlists
   - Abrir uma playlist específica
5. - Login: (se der tempo)
   - Cada usuário vê apenas suas próprias playlists.

---

## Organização dos arquivos

- criar.php - criaçao de playlist
- index.php – Página inicial
- lib.php - Funçao intermediária para salvar no json
- playlist-cadastro.php - Listar as músicas dentro da playlist
- playlists.json – Pasta para arquivos com lista de playlists
- sobre.php – Página institucional / sobre o projeto
- style.css – Estilos gerais do site
- view.php - mostra todas as playlists
- criar_playlist.php – Criação de playlist
- playlist.php – Detalhes da playlist e vídeo
- FavIcon – Ícones, logo, etc.

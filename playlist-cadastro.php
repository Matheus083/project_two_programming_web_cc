<?php
/**
 * Este arquivo exibe o formulário para criação de uma nova playlist.
 * Ele **não grava nada** no arquivo JSON — apenas coleta os dados.
 * O processamento ocorre em: playlist-cadastro.php
 */

// Nome do arquivo onde playlists são armazenadas
$arquivo = "playlists.json";

// Título da página
echo "<h2>Cadastro de playlists</h2>";
?>

<!--
    Formulário de criação de playlist:
    - Envia os dados via POST para playlist-cadastro.php
    - Campos:
        • nome: nome da playlist
        • url: primeiro link opcional do YouTube
-->
<form method="post" action="playlist-cadastro.php">

    <label>Nome da playlist:</label>
    <input type="text" name="nome" required><br>

    <label>Primeiro link do YouTube (opcional):</label>
    <input type="url" name="url" placeholder="https://youtu.be/..."><br>

    <input type="submit" value="Cadastrar">

</form>

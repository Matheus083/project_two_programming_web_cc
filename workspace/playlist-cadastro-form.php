<?php
    $arquivo = "playlists.json";
    echo "<h2>Cadastro de playlists</h2>";
?>

<form method="post" action="playlist-cadastro.php">

    <label>Nome da playlist:</label>
    <input type="text" name="nome"><br>

    <label>Primeiro link do YouTube (opcional):</label>
    <input type="url" name="url" placeholder="https://youtu.be/..."><br>

    <input type="submit" value="Cadastrar">

</form>

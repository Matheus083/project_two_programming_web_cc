<?php
require 'lib.php';

$erro = "";
$sucesso = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if ($login && $senha) {
        if (cadastrar_usuario($login, $senha)) {
            $sucesso = "Conta criada com sucesso!";
        } else {
            $erro = "Este usuário já existe.";
        }
    } else {
        $erro = "Preencha todos os campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - YouPlaylist</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>You<span>Playlist</span></h1>
    </header>
    <main>
        <div class="form-container">
            <div class="form-box">
                <h2>Criar Conta</h2>
                
                <?php if ($erro): ?>
                    <p style="color:#ff5555; margin-bottom:15px;"><?= $erro ?></p>
                <?php endif; ?>

                <?php if ($sucesso): ?>
                    <p style="color:#2d6; margin-bottom:15px; font-weight:bold;"><?= $sucesso ?></p>
                    <a href="login.php" class="btn" style="width:100%">Ir para Login</a>
                <?php else: ?>
                
                <form method="post">
                    <label>Escolha um Usuário</label>
                    <input type="text" name="login" placeholder="Ex: joaosilva" required>
                    
                    <label>Escolha uma Senha</label>
                    <input type="password" name="senha" placeholder="******" required>
                    
                    <button type="submit" style="width:100%">Cadastrar</button>
                </form>
                
                <br>
                <p style="color:#888; font-size:0.9rem;">
                    Já tem conta? <a href="login.php" style="color:var(--primary); font-weight:600;">Faça Login</a>
                </p>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>
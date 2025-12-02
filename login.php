<?php
// Importa funções principais (autenticação, leitura de usuários etc.)
require 'lib.php';

// Variável usada para exibir mensagem de erro na interface
$erro = "";

/**
 * Se o formulário foi enviado via POST, tenta realizar o login.
 * - Obtém usuário e senha enviados
 * - Chama logar_usuario() para validar credenciais
 * - Se correto → redireciona para index.php
 * - Se incorreto → define mensagem de erro
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (logar_usuario($login, $senha)) {
        // Login válido → redireciona para a página inicial do sistema
        header("Location: index.php");
        exit;
    } else {
        // Login inválido → mostra mensagem na tela
        $erro = "Usuário ou senha incorretos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - YourPlaylist</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>You<span>Playlist</span></h1>
    </header>

    <main>
        <div class="form-container">
            <div class="form-box">
                <h2>Bem-vindo de volta</h2>

                <!-- Exibição da mensagem de erro, se existir -->
                <?php if ($erro): ?>
                    <p style="color:#ff5555; margin-bottom:15px;"><?= $erro ?></p>
                <?php endif; ?>

                <!-- Formulário de Login -->
                <form method="post">
                    <label>Usuário</label>
                    <input type="text" name="login" placeholder="Seu nome de usuário" required>

                    <label>Senha</label>
                    <input type="password" name="senha" placeholder="Sua senha" required>

                    <button type="submit" style="width:100%">Entrar</button>
                </form>

                <!-- Link para página de cadastro -->
                <br>
                <p style="color:#888; font-size:0.9rem;">
                    Não tem conta? 
                    <a href="cadastro.php" style="color:var(--primary); font-weight:600;">
                        Crie agora
                    </a>
                </p>
            </div>
        </div>
    </main>
</body>
</html>

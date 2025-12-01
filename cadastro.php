<?php
// Importa funções da biblioteca principal (manipulação de usuários, playlists, autenticação, etc.)
require 'lib.php';

// Variáveis para mensagens de erro e sucesso
$erro = "";
$sucesso = "";

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recebe os dados enviados pelo usuário
    $login = $_POST['login'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Verifica se os campos estão preenchidos
    if ($login && $senha) {

        // Função que tenta cadastrar um novo usuário
        // Ela retorna FALSE se o usuário já existir
        if (cadastrar_usuario($login, $senha)) {
            $sucesso = "Conta criada com sucesso!";
        } else {
            $erro = "Este usuário já existe.";
        }

    } else {
        // Caso o formulário tenha campos vazios
        $erro = "Preencha todos os campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - YouPlaylist</title>

    <!-- Estilos globais do projeto -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <!-- Logo do sistema -->
        <h1>You<span>Playlist</span></h1>
    </header>

    <main>
        <div class="form-container">
            <div class="form-box">
                <h2>Criar Conta</h2>

                <!-- Mensagem de erro (exibida se $erro não estiver vazio) -->
                <?php if ($erro): ?>
                    <p style="color:#ff5555; margin-bottom:15px;"><?= $erro ?></p>
                <?php endif; ?>

                <!-- Mensagem de sucesso (exibida após cadastro) -->
                <?php if ($sucesso): ?>
                    <p style="color:#2d6; margin-bottom:15px; font-weight:bold;"><?= $sucesso ?></p>

                    <!-- Botão para ir direto ao login após criar conta -->
                    <a href="login.php" class="btn" style="width:100%">Ir para Login</a>

                <?php else: ?>

                <!-- Formulário de cadastro -->
                <form method="post">

                    <!-- Campo de nome de usuário -->
                    <label>Escolha um Usuário</label>
                    <input type="text" name="login" placeholder="Ex: joaosilva" required>

                    <!-- Campo de senha -->
                    <label>Escolha uma Senha</label>
                    <input type="password" name="senha" placeholder="******" required>

                    <!-- Botão de envio -->
                    <button type="submit" style="width:100%">Cadastrar</button>
                </form>

                <br>

                <!-- Link para usuários que já possuem conta -->
                <p style="color:#888; font-size:0.9rem;">
                    Já tem conta? 
                    <a href="login.php" style="color:var(--primary); font-weight:600;">Faça Login</a>
                </p>

                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>

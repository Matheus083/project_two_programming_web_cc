<?php
// Importa funções essenciais do sistema (carregar/salvar JSON, autenticação, etc.)
require 'lib.php';

// Garante que só usuários logados possam acessar esta página
verificar_auth();

// Recebe o ID da playlist via GET (URL)
// Se não existir, redireciona para a página principal
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

// Verifica se existe algum erro enviado pela URL (ex: URL vazia)
$error = $_GET['error'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Adicionar Música</title>

    <!-- Importa o CSS do projeto -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Adicionar Música</h2>

<?php
// Caso o usuário tenha tentado salvar sem inserir URL,
// exibimos uma mensagem amigável de erro.
if ($error === 'empty'): ?>
    <div class="form-box" style="color:red;">Informe uma URL.</div>
<?php endif; ?>

<!-- 
    FORMULÁRIO PARA ADICIONAR MÚSICAS NA PLAYLIST
    Ele envia os dados para add-musica-salvar.php
-->
<form action="add-musica-salvar.php" method="post">

    <!-- Campo oculto que carrega o ID da playlist -->
    <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

    <label>URL da música (YouTube):</label>

    <!-- Campo obrigatório para digitar o link da música -->
    <input type="text" name="url" required>

    <!-- Botão de confirmação -->
    <button type="submit">Adicionar</button>
</form>

<!-- Link para voltar à visualização da playlist -->
<a href="view.php?id=<?= htmlspecialchars($id) ?>">Voltar</a>

</body>
</html>

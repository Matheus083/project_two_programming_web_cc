<?php
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: index.php");
    exit;
}

$error = $_GET['error'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<title>Adicionar Música</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Adicionar Música</h2>

<?php if ($error === 'empty'): ?>
    <div class="form-box" style="color:red;">Você precisa informar uma URL.</div>
<?php elseif ($error === 'save'): ?>
    <div class="form-box" style="color:red;">Erro ao salvar. Tente novamente.</div>
<?php endif; ?>

<form action="add-musica-salvar.php" method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

    <label>URL da música (YouTube):</label>
    <input type="text" name="url" required>

    <button type="submit">Adicionar</button>
</form>

<a href="view.php?id=<?= htmlspecialchars($id) ?>">Voltar</a>

</body>
</html>

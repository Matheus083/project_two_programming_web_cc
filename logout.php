<?php
// Inicia a sessão para poder destruí-la
session_start();

/**
 * Encerra completamente a sessão atual.
 * - Remove todas as variáveis da sessão
 * - Apaga o arquivo de sessão do servidor
 * - "Desloga" o usuário do sistema
 */
session_destroy();

// Redireciona o usuário para a página de login
header("Location: login.php");
exit; // Garante que nenhum código seja executado depois do redirecionamento

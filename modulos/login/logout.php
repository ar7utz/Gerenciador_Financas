<?php
session_start();

// Limpar todas as variáveis de sessão
$_SESSION = array();

// Destruir a sessão
session_destroy();

// Redirecionar para a página de login ou qualquer outra página desejada após o logout
header("Location: ../../index.php");
exit;
?>

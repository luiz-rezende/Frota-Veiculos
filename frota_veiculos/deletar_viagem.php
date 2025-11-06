<?php
require 'includes/config.php';
require 'includes/functions.php';
check_login($pdo);

$id_agendamento = $_GET['id_agendamento'] ?? null;
if ($id_agendamento) {
    $stmt = $pdo->prepare("DELETE FROM viagens WHERE id_agendamento = ?");
    $stmt->execute([$id_agendamento]);
}
header("Location: viagens.php");
exit();
?>
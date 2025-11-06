<?php
require 'includes/config.php';
require 'includes/functions.php';
check_login($pdo);

$id_abastecimento = $_GET['id_abastecimento'] ?? null;
if ($id_abastecimento) {
    $stmt = $pdo->prepare("DELETE FROM registro_abastecimentos WHERE id_abastecimento = ?");
    $stmt->execute([$id_abastecimento]);
}
header("Location: abastecimento.php");
exit();
?>
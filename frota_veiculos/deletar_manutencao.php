<?php
require 'includes/config.php';
require 'includes/functions.php';
check_login($pdo);

$id_manutencao = $_GET['id_manutencao'] ?? null;
if ($id_manuteid_manutencaoncao) {
    $stmt = $pdo->prepare("DELETE FROM registro_de_manutencoes_preventivas WHERE id_manutencao = ?");
    $stmt->execute([$id_manutencao]);
}
header("Location: manutencoes.php");
exit();
?>
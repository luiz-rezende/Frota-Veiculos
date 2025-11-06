<?php
function check_login($pdo) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit();
    } else {
        // Verifica o usuário no banco
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->execute(['id' => $_SESSION['user_id']]);
        if ($stmt->rowCount() == 0) {
            header('Location: index.php');
            exit();
        }
    }
}

function is_master() {
    return isset($_SESSION['user_id']) && $_SESSION['is_master'];
}
?>
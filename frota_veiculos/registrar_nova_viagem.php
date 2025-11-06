<?php
require 'includes/config.php';
require 'includes/functions.php';
check_login($pdo);

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_agendamento = $_POST["id_agendamento"];
    $data_viagem = $_POST["data_viagem"];
    $quilometragem_inicial = $_POST["quilometragem_inicial"];
    $quilometragem_final = $_POST["quilometragem_final"];
    $km_rodados = $_POST["km_rodados"];
    $observacoes = $_POST["observacoes"];

    if (empty($id_agendamento) || empty($data_viagem) || empty($quilometragem_inicial) || empty($quilometragem_final) || empty($km_rodados) || empty($observacoes)) {
        $error = "Todos os campos são obrigatórios.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO registro_viagens (id_agendamento, data_viagem, quilometragem_inicial, quilometragem_final, km_rodados, observacoes ) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$id_agendamento, $data_viagem, $quilometragem_inicial, $quilometragem_final, $km_rodados, $observacoes ]);
            header("Location: rg_viagens.php");
            exit();
        } catch (PDOException $e) {
            $error = "Erro ao inserir uma nova transação: " . $e->getMessage();
        }
    }
}
include 'includes/header.php';
?>

<h1 style="margin-left: 280px; margin-top:40px;">Registrar Viagem</h1>
<?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<form action="registrar_nova_viagem.php" method="post" style="width:70%; margin-left:auto; margin-right:auto;">
    <div class="form-group">
        <label for="id_agendamento">ID Veiculo</label>
        <input type="text" class="form-control" id="id_agendamento" name="id_agendamento" required>
    </div>
    <div class="form-group">
        <label for="data_viagem">Data Viagem</label>
        <input type="date" class="form-control" id="data_viagem" name="data_viagem" required>
    </div>
    <div class="form-group">
        <label for="quilometragem_inicial">KM Inicial</label>
        <input type="text" class="form-control" id="quilometragem_inicial" name="quilometragem_inicial" required>
    </div>
    <div class="form-group">
        <label for="quilometragem_final">KM Final</label>
        <input type="text" class="form-control" id="quilometragem_final" name="quilometragem_final" required>
    </div>
    <div class="form-group">
        <label for="km_rodados">KM Rodados</label>
        <input type="text" class="form-control" id="km_rodados" name="km_rodados" required>
    </div>
    <div class="form-group">
        <label for="observacoes">observacoes</label>
        <input type="text" class="form-control" id="observacoes" name="observacoes" required>
    </div>
    <button type="submit" class="btn btn-success" style="margin-top:20px;">Adicionar</button>
</form>

<?php include 'includes/footer.php'; ?>
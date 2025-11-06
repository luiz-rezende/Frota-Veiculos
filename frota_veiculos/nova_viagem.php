<?php
require 'includes/config.php';
require 'includes/functions.php';
check_login($pdo);

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_veiculo = $_POST["id_veiculo"];
    $data_hora = $_POST["data_hora"];
    $destino = $_POST["destino"];
    $finalidade = $_POST["finalidade"];
    $colaborador_responsavel = $_POST["colaborador_responsavel"];
    $status = $_POST["status"];

    if (empty($id_veiculo) || empty($data_hora) || empty($destino) || empty($finalidade) || empty($colaborador_responsavel) || empty($status)) {
        $error = "Todos os campos são obrigatórios.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO agendamento_viagens (id_veiculo, data_hora, destino, finalidade, colaborador_responsavel, status ) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$id_veiculo, $data_hora, $destino, $finalidade, $colaborador_responsavel, $status ]);
            header("Location: ag_viagens.php");
            exit();
        } catch (PDOException $e) {
            $error = "Erro ao inserir uma nova transação: " . $e->getMessage();
        }
    }
}
include 'includes/header.php';
?>

<h1 style="margin-left: 280px; margin-top:40px;">Nova Viagem</h1>
<?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<form action="nova_viagem.php" method="post" style="width:70%; margin-left:auto; margin-right:auto;">
    <div class="form-group">
        <label for="id_veiculo">ID Veiculo</label>
        <input type="text" class="form-control" id="id_veiculo" name="id_veiculo" required>
    </div>
    <div class="form-group">
        <label for="data_hora">Data/Hora</label>
        <input type="date" class="form-control" id="data_hora" name="data_hora" required>
    </div>
    <div class="form-group">
        <label for="destino">Destino</label>
        <input type="text" class="form-control" id="destino" name="destino" required>
    </div>
    <div class="form-group">
        <label for="finalidade">Finalidade</label>
        <input type="text" class="form-control" id="finalidade" name="finalidade" required>
    </div>
    <div class="form-group">
        <label for="colaborador_responsavel">Colaborador</label>
        <input type="text" class="form-control" id="colaborador_responsavel" name="colaborador_responsavel" required>
    </div>
    <div class="form-group">
    <label for="status">Status</label>
    <select class="form-control" id="status" name="status" required>
        <option value="Agendada" selected>Agendada</option>
        <option value="Desmarcada">Desmarcada</option>
        <option value="Concluida">Concluída</option>
    </select>
</div>

    <button type="submit" class="btn btn-success" style="margin-top:20px;">Adicionar</button>
</form>

<?php include 'includes/footer.php'; ?>
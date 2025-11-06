<?php
require 'includes/config.php';
require 'includes/functions.php';
check_login($pdo);

$error = '';
$id_agendamento = $_GET['id_agendamento'] ?? null;
$agendamento_vg = null;

if ($id_agendamento) {
    $stmt = $pdo->prepare("SELECT * FROM viagens WHERE id_agendamento = ?");
    $stmt->execute([$id_agendamento]);
    $agendamento_vg = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$agendamento_vg) {
        header("Location: viagens.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_veiculo = $_POST["id_veiculo"];
    $data_hora = $_POST["data_hora"];
    $destino = $_POST["destino"];
    $quilometragem_inical = $_POST["quilometragem_inicial"];
    $quilometragem_final = $_POST["quilometragem_final"];
    $finalidade = $_POST["finalidade"];
    $colaborador_responsavel = $_POST["colaborador_responsavel"];
    $status = $_POST["status"];

    if (empty($id_veiculo) || empty($data_hora) || empty($destino) || empty($quilometragem_inical) || empty($quilometragem_final) || empty($finalidade) || empty($colaborador_responsavel) || empty($status)) {
        $error = "Todos os campos são obrigatórios.";
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE viagens SET  id_veiculo = ?, data_hora = ?, destino= ?, quilometragem_inicial= ?, quilometragem_final= ?, finalidade = ?, colaborador_responsavel = ?, status = ? WHERE id_agendamento = ?");
            $stmt->execute([$id_veiculo, $data_hora, $destino, $quilometragem_inical, $quilometragem_final, $finalidade, $colaborador_responsavel, $status, $id_agendamento]);
            header("Location: viagens.php");
            exit();
        } catch (PDOException $e) {
            $error = "Erro ao atualizar transações: " . $e->getMessage();
        }
    }
}
include 'includes/header.php';
?>

<h1 style="margin-left: 280px; margin-top:40px;">Editar Agendamento</h1>
<?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<form action="editar_viagem.php?id_agendamento=<?= $id_agendamento ?>" method="post" style="width:70%; margin-left:auto; margin-right:auto;">
    <div class="form-group">
        <label for="id_veiculo">ID Veiculo</label>
        <input type="text" class="form-control" id="id_veiculo" name="id_veiculo" value="<?= $agendamento_vg['id_veiculo'] ?>" required>
    </div>
    <div class="form-group">
        <label for="data_hora">Data/Hora</label>
        <input type="date" class="form-control" id="data_hora" name="data_hora" value="<?= $agendamento_vg['data_hora'] ?>" required>
    </div>
    <div class="form-group">
        <label for="destino">Destino</label>
        <input type="text" class="form-control" id="destino" name="destino" value="<?= $agendamento_vg['destino'] ?>" required>
    </div>
    <div class="form-group">
        <label for="quilometragem_inicial">KM Inicial</label>
        <input type="text" class="form-control" id="quilometragem_inicial" name="quilometragem_inicial" value="<?= $agendamento_vg['quilometragem_inicial'] ?>" required>
    </div>
    <div class="form-group">
        <label for="quilometragem_final">KM Final</label>
        <input type="text" class="form-control" id="quilometragem_final" name="quilometragem_final" value="<?= $agendamento_vg['quilometragem_final'] ?>" required>
    </div>
    <div class="form-group">
        <label for="finalidade">Finalidade</label>
        <input type="text" class="form-control" id="finalidade" name="finalidade" value="<?= $agendamento_vg['finalidade'] ?>" required>
    </div>
    <div class="form-group">
        <label for="colaborador_responsavel">Colaborador</label>
        <input type="text" class="form-control" id="colaborador_responsavel" name="colaborador_responsavel" value="<?= $agendamento_vg['colaborador_responsavel'] ?>" required>
    </div>
    <div class="form-group">
    <label for="status">Status</label>
    <select class="form-control" id="status" name="status" required>
        <option value="Agendada" selected>Agendada</option>
        <option value="Desmarcada">Desmarcada</option>
        <option value="Concluida">Concluída</option>
    </select>
    <button type="submit" class="btn btn-success" style="margin-top:20px;">Atualizar</button>
</form>

<?php include 'includes/footer.php'; ?>
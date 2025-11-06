<?php
require 'includes/config.php';
require 'includes/functions.php';
check_login($pdo);

$error = '';
$id_manutencao = $_GET['id_manutencao'] ?? null;
$registro_de_manutencoes_preventivas = null;

if ($id_manutencao) {
    $stmt = $pdo->prepare("SELECT * FROM registro_de_manutencoes_preventivas WHERE id_manutencao = ?");
    $stmt->execute([$id_manutencao]);
    $registro_de_manutencoes_preventivas = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$registro_de_manutencoes_preventivas) {
        header("Location: ag_viagens.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_veiculo = $_POST["id_veiculo"];
    $data_manutencao = $_POST["data_manutencao"];
    $tipo_servico = $_POST["tipo_servico"];
    $custo = $_POST["custo"];
    

    if (empty($id_veiculo) || empty($data_manutencao) || empty($tipo_servico) || empty($custo) || empty($passageiros)) {
        $error = "Todos os campos são obrigatórios.";
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE manutencao_viagens SET  id_veiculo = ?, id_veiculo = ?, data_manutencao= ?, tipo_servico = ?, custo = ?, passageiros = ? WHERE id_manutencao = ?");
            $stmt->execute([$id_veiculo, $data_manutencao, $tipo_servico, $custo, $passageiros, $id_manutencao]);
            header("Location: manutencoes.php");
            exit();
        } catch (PDOException $e) {
            $error = "Erro ao atualizar: " . $e->getMessage();
        }
    }
}
include 'includes/header.php';
?>

<h1 style="margin-left: 280px; margin-top:40px;">Editar manutenção</h1>
<?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<form action="editar_manutencao.php?id_manutencao=<?= $id_manutencao ?>" method="post" style="width:70%; margin-left:auto; margin-right:auto;">
    <div class="form-group">
        <label for="id_veiculo">ID Veiculo</label>
        <input type="number" class="form-control" id="id_veiculo" name="id_veiculo" value="<?= $registro_de_manutencoes_preventivas['id_veiculo'] ?>" required>
    </div>
    <div class="form-group">
        <label for="data_manutencao">Data</label>
        <input type="date" class="form-control" id="data_manutencao" name="data_manutencao" value="<?= $registro_de_manutencoes_preventivas['data_manutencao'] ?>" required>
    </div>
    <div class="form-group">
        <label for="tipo_servico">Tipo de Serviço</label>
        <input type="text" class="form-control" id="tipo_servico" name="tipo_servico" value="<?= $registro_de_manutencoes_preventivas['tipo_servico'] ?>" required>
    </div>
    <div class="form-group">
        <label for="custo">Custo</label>
        <input type="number" class="form-control" id="custo" name="custo" value="<?= $registro_de_manutencoes_preventivas['custo'] ?>" required>
    </div>
    <button type="submit" class="btn btn-success" style="margin-top:20px;">Atualizar</button>
</form>

<?php include 'includes/footer.php'; ?>
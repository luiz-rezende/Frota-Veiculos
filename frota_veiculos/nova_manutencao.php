<?php
require 'includes/config.php';
require 'includes/functions.php';
check_login($pdo);

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_veiculo = $_POST["id_veiculo"];
    $data_manutencao = $_POST["data_manutencao"];
    $tipo_servico = $_POST["tipo_servico"];
    $custo = $_POST["custo"];
    
    if (empty($id_veiculo) || empty($data_manutencao) || empty($tipo_servico) || empty($custo)) {
        $error = "Todos os campos são obrigatórios.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO registro_de_manutencoes_preventivas (id_veiculo, data_manutencao, tipo_servico, custo) VALUES (?, ?, ?, ?)");
            $stmt->execute([$id_veiculo, $data_manutencao, $tipo_servico, $custo]);
            header("Location: manutencoes.php");
            exit();
        } catch (PDOException $e) {
            $error = "Erro ao inserir uma nova transação: " . $e->getMessage();
        }
    }
}
include 'includes/header.php';
?>

<h1 style="margin-left: 280px; margin-top:40px;">Nova Manutenção</h1>
<?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<form action="nova_manutencao.php" method="post" style="width:70%; margin-left:auto; margin-right:auto;">
    <div class="form-group">
        <label for="id_veiculo">ID Veiculo</label>
        <input type="text" class="form-control" id="id_veiculo" name="id_veiculo" required>
    </div>
    <div class="form-group">
        <label for="data_manutencao">Data</label>
        <input type="date" class="form-control" id="data_manutencao" name="data_manutencao" required>
    </div>
    <div class="form-group">
        <label for="tipo_servico">Tipo de Serviço</label>
        <input type="text" class="form-control" id="tipo_servico" name="tipo_servico" required>
    </div>
    <div class="form-group">
        <label for="custo">Custo</label>
        <input type="text" class="form-control" id="custo" name="custo" required>
    </div>
    
    <button type="submit" class="btn btn-success" style="margin-top:20px;">Adicionar</button>
</form>

<?php include 'includes/footer.php'; ?>
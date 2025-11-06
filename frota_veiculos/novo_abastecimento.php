<?php
require 'includes/config.php';
require 'includes/functions.php';
check_login($pdo);

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_veiculo = $_POST["id_veiculo"];
    $data_abastecimento = $_POST["data_abastecimento"];
    $quantidade_litros = $_POST["quantidade_litros"];
    $custo = $_POST["custo"];
    

    if (empty($id_veiculo) || empty($data_abastecimento) || empty($quantidade_litros) || empty($custo)) {
        $error = "Todos os campos são obrigatórios.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO registro_abastecimentos (id_veiculo, data_abastecimento, quantidade_litros, custo) VALUES (?, ?, ?, ?)");
            $stmt->execute([$id_veiculo, $data_abastecimento, $quantidade_litros, $custo]);
            header("Location: abastecimento.php");
            exit();
        } catch (PDOException $e) {
            $error = "Erro ao inserir uma nova transação: " . $e->getMessage();
        }
    }
}
include 'includes/header.php';
?>

<h1 style="margin-left: 280px; margin-top:40px;">Novo Abastecimento</h1>
<?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<form action="novo_abastecimento.php" method="post" style="width:70%; margin-left:auto; margin-right:auto;">
    <div class="form-group">
        <label for="id_veiculo">ID Veiculo</label>
        <input type="text" class="form-control" id="id_veiculo" name="id_veiculo" required>
    </div>
    <div class="form-group">
        <label for="data_abastecimento">Data</label>
        <input type="date" class="form-control" id="data_abastecimento" name="data_abastecimento" required>
    </div>
    <div class="form-group">
        <label for="quantidade_litros">Qntd/L</label>
        <input type="text" class="form-control" id="quantidade_litros" name="quantidade_litros" required>
    </div>
    <div class="form-group">
        <label for="custo">Custo</label>
        <input type="text" class="form-control" id="custo" name="custo" required>
    </div>
    <button type="submit" class="btn btn-success" style="margin-top:20px;">Adicionar</button>
</form>

<?php include 'includes/footer.php'; ?>
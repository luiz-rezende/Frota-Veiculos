<?php
require 'includes/config.php';
require 'includes/functions.php';
check_login($pdo);

$error = '';
$id_abastecimento = $_GET['id_abastecimento'] ?? null;
$abastecimento = null;

if ($id_abastecimento) {
    $stmt = $pdo->prepare("SELECT * FROM registro_abastecimentos WHERE id_abastecimento = ?");
    $stmt->execute([$id_abastecimento]);
    $abastecimento = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$abastecimento) {
        header("Location: abastecimento.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_veiculo = $_POST["id_veiculo"];
    $data_abastecimento = $_POST["data_abastecimento"];
    $quantidade_litros = $_POST["quantidade_litros"];
    $custo = $_POST["custo"];

    if (empty($id_veiculo) || empty($data_abastecimento) || empty($quantidade_litros) || empty($custo)) {
        $error = "Todos os campos são obrigatórios.";
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE registro_abastecimentos SET  id_veiculo = ?, data_abastecimento = ?, quantidade_litros= ?, custo = ? WHERE id_abastecimento = ?");
            $stmt->execute([$id_veiculo, $data_abastecimento, $quantidade_litros, $custo, $id_abastecimento]);
            header("Location: abastecimento.php");
            exit();
        } catch (PDOException $e) {
            $error = "Erro ao atualizar transações: " . $e->getMessage();
        }
    }
}
include 'includes/header.php';
?>

<h1 style="margin-left: 280px; margin-top:40px;">Editar Registro</h1>
<?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<form action="editar_abastecimento.php?id_abastecimento=<?= $id_abastecimento ?>" method="post" style="width:70%; margin-left:auto; margin-right:auto;">
    <div class="form-group">
        <label for="id_veiculo">ID Veiculo</label>
        <input type="text" class="form-control" id="id_veiculo" name="id_veiculo" value="<?= $abastecimento['id_veiculo'] ?>" required>
    </div>
    <div class="form-group">
        <label for="data_abastecimento">Data</label>
        <input type="date" class="form-control" id="data_abastecimento" name="data_abastecimento" value="<?= $abastecimento['data_abastecimento'] ?>" required>
    </div>
    <div class="form-group">
        <label for="quantidade_litros">Qntd/L</label>
        <input type="text" class="form-control" id="quantidade_litros" name="quantidade_litros" value="<?= $abastecimento['quantidade_litros'] ?>" required>
    </div>
    <div class="form-group">
        <label for="custo">KM Custo</label>
        <input type="text" class="form-control" id="custo" name="custo" value="<?= $abastecimento['custo'] ?>" required>
    </div>
    
    <button type="submit" class="btn btn-success" style="margin-top:20px;">Atualizar</button>
</form>

<?php include 'includes/footer.php'; ?>
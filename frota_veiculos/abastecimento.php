<?php
require 'includes/config.php';
require 'includes/functions.php';
check_login($pdo);
include 'includes/header.php';
?>

<h1 style="margin-left: 230px; margin-top:40px;">Registro de Abastecimento</h1>
<a class="btn btn-primary mb-2" href="novo_abastecimento.php" style="margin-left: 230px;">Novo Abastecimento</a>
<table class="table table-bordered table-striped" style="width:70%; margin-left:auto; margin-right:auto;">
    <thead>
        <tr>
            <th>ID</th>
            <th>ID Veiculo</th>
            <th>Data</th>
            <th>Qntd/L</th>
            <th>Custo</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $stmt = $pdo->query("SELECT * FROM registro_abastecimentos");
        while ($registro_abastecimentos = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data_transacoes_formatada = date('d/m/Y', strtotime($registro_abastecimentos['data_abastecimento']));
            echo "<tr>
                    <td>{$registro_abastecimentos['id_abastecimento']}</td>
                    <td>{$registro_abastecimentos['id_veiculo']}</td>
                    <td>{$data_transacoes_formatada}</td>
                    <td>{$registro_abastecimentos['quantidade_litros']}</td>
                    <td>{$registro_abastecimentos['custo']}</td>
                    <td>
                        <a href='editar_abastecimento.php?id_abastecimento={$registro_abastecimentos['id_abastecimento']}' class='btn btn-warning btn-sm'>Editar</a>
                        <a href='deletar_abastecimento.php?id_abastecimento={$registro_abastecimentos['id_abastecimento']}' class='btn btn-danger btn-sm'>Deletar</a>
                    </td>
                  </tr>";
        }
        ?>
    </tbody>
</table>

<?php include 'includes/footer.php'; ?>